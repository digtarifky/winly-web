<?php

namespace App\Http\Controllers;

use App\Exports\PesertaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Competition;
use App\Models\CompetitionField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganizerController extends Controller
{
    // Fungsi untuk Download Excel
    public function exportExcel()
    {
        $user = Auth::user();
        $namaFile = 'Data_Peserta_Valid_Winly_' . date('Ymd') . '.xlsx';

        return Excel::download(new PesertaExport($user->id), $namaFile);
    }

    // 1. Menampilkan Dashboard Penyelenggara
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data lomba milik panitia ini
        $competitions = Competition::where('user_id', $user->id)->latest()->get();

        // Ambil array ID lomba milik panitia ini untuk filter
        $competitionIds = $competitions->pluck('id')->toArray();

        // 2. Ambil SEMUA data pendaftar (registrations) yang nyangkut di lomba milik panitia
        $registrations = \App\Models\Registration::with(['user.profile', 'field.competition'])
            ->whereHas('field', function ($query) use ($competitionIds) {
                $query->whereIn('competition_id', $competitionIds);
            })
            ->latest()
            ->get();

        // 3. Hitung Data untuk 3 Kotak Statistik
        $totalPendaftar = $registrations->count();

        // Asumsi: status_pembayaran 'sukses' artinya Terverifikasi (Aman)
        $pesertaValid = $registrations->where('status_pembayaran', 'sukses')->count();

        // Asumsi: status_pembayaran 'menunggu' (bayar nanti) dan 'menunggu_verifikasi' (gratis)
        $pesertaPending = $registrations->whereIn('status_pembayaran', ['menunggu', 'menunggu_verifikasi'])->count();

        // 4. PISAHKAN DATA UNTUK DITAMPILKAN DI TABEL (PENTING!)
        $pendingRegistrations = $registrations->whereIn('status_pembayaran', ['menunggu', 'menunggu_verifikasi']);
        $validRegistrations = $registrations->where('status_pembayaran', 'sukses');

        return view('penyelenggara.dashboard', compact(
            'user',
            'competitions',
            'registrations',
            'totalPendaftar',
            'pesertaValid',
            'pesertaPending',
            'pendingRegistrations', // Tambahan data tabel pending
            'validRegistrations'    // Tambahan data tabel valid
        ));
    }

    // 2. Fungsi Form Buat Lomba (BARU DITAMBAHKAN)
    public function manajemen()
    {
        $user = Auth::user();
        $competitions = \App\Models\Competition::where('user_id', $user->id)->latest()->get();

        // Pastikan nama file blade-nya sudah kamu ubah jadi manajemen-lomba.blade.php
        return view('penyelenggara.manajemen', compact('user', 'competitions'));
    }

    // Khusus untuk memanggil form kosong tambah lomba
    public function create()
    {
        // Pastikan ini memanggil file form buatanmu (bukan memanggil index lagi)
        return view('penyelenggara.create');
    }

    // 3. Memproses Data dari Form Tambah Lomba
    public function store(Request $request)
    {
        // A. TAMBAHKAN VALIDASI BARU DI SINI 👇
        $request->validate([
            'judul_lomba' => 'required|string|max:255',
            'kategori' => 'required|string|in:akademik,teknologi_it,ekonomi_bisnis,karya_tulis,seni_desain,kesehatan,soshum_hukum',
            'tingkat_sekolah' => 'required|string|in:sd,smp,sma,mahasiswa',
            'tingkat_lomba' => 'required|in:kota,umum,provinsi,nasional,internasional',
            'tanggal_pelaksanaan' => 'nullable|date',

            // Validasi aturan baru Winly
            'tgl_buka_pendaftaran' => 'required|date',
            'tgl_tutup_pendaftaran' => 'required|date|after_or_equal:tgl_buka_pendaftaran',
            'kuota_peserta' => 'required|integer|min:1',

            'link_panduan' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'benefits' => 'nullable|array',

            'bidang' => 'required|array|min:1',
            'bidang.*.nama_bidang' => 'required|string',
            'bidang.*.harga' => 'required|numeric|min:0',
            'bidang.*.link_wa' => 'required|url',
        ]);

        DB::beginTransaction();
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $posterPath = null;
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('posters', 'public');
            }

            $status = 'draf';
            $isPaid = false;
            $tingkat = strtolower($request->tingkat_lomba);

            if (in_array($tingkat, ['kota', 'umum'])) {
                if ($user->kuota_gratis > 0) {
                    $user->decrement('kuota_gratis');
                    $status = 'aktif';
                } else {
                    $isPaid = true;
                }
            } else {
                $isPaid = true;
            }

            // B. MASUKKAN DATA BARU KE DATABASE DI SINI 👇
            $competition = Competition::create([
                'user_id' => $user->id,
                'judul_lomba' => $request->judul_lomba,
                'kategori' => $request->kategori,
                'tingkat_sekolah' => $request->tingkat_sekolah,
                'deskripsi' => $request->deskripsi ?? 'Deskripsi belum tersedia.',
                'poster' => $posterPath,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

                // Kolom baru
                'tgl_buka_pendaftaran' => $request->tgl_buka_pendaftaran,
                'tgl_tutup_pendaftaran' => $request->tgl_tutup_pendaftaran,
                'kuota_peserta' => $request->kuota_peserta,
                'is_pendaftaran_tutup' => false,

                'tingkat_lomba' => $request->tingkat_lomba,
                'link_panduan' => $request->link_panduan,
                'status' => $status,
                'benefits' => $request->benefits ? json_encode($request->benefits) : null,
            ]);

            foreach ($request->bidang as $item) {
                $tipe = $item['harga'] == 0 ? 'gratis' : 'berbayar';
                CompetitionField::create([
                    'competition_id' => $competition->id,
                    'nama_bidang' => $item['nama_bidang'],
                    'tipe_pendaftaran' => $tipe,
                    'harga' => $item['harga'],
                    'link_wa' => $item['link_wa'],
                ]);
            }

            DB::commit();

            if ($isPaid) {
                return redirect()->route('penyelenggara.payment', $competition->id);
            }

            return redirect()->route('penyelenggara.dashboard')->with('success', 'Lomba berhasil diterbitkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }

        // 1. Ambil data lomba beserta hitungan jumlah peserta yang sudah terverifikasi/sukses
        $lomba = Competition::withCount(['registrations' => function ($query) {
            $query->where('status_pembayaran', 'sukses');
        }])->findOrFail($competition_id);

        $hariIni = Carbon::now()->startOfDay();
        $tglBuka = Carbon::parse($lomba->tgl_buka_pendaftaran)->startOfDay();
        $tglTutup = Carbon::parse($lomba->tgl_tutup_pendaftaran)->endOfDay();

        // GEMBOK 1: VALIDASI WAKTU (OTOMATIS)
        // ==========================================
        if ($hariIni->lt($tglBuka)) {
            return back()->withErrors('Pendaftaran lomba ini belum dibuka! Pendaftaran dibuka mulai tanggal ' . $tglBuka->format('d M Y'));
        }

        if ($hariIni->gt($tglTutup)) {
            return back()->withErrors('Mohon maaf, pendaftaran lomba ini sudah ditutup karena telah melewati batas tanggal penutupan.');
        }

        // GEMBOK 2: VALIDASI KUOTA (OTOMATIS)
        // ==========================================
        if ($lomba->registrations_count >= $lomba->kuota_peserta) {
            return back()->withErrors('Mohon maaf, pendaftaran tidak dapat dilanjutkan karena kuota peserta sudah terpenuhi (Penuh).');
        }
    }

    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        $lomba = Competition::with('fields')->where('user_id', Auth::id())->findOrFail($id);
        return view('penyelenggara.edit', compact('lomba'));
    }

    // 5. Memproses Data Update (BESERTA BUG FIX BIDANG & WA)
    public function update(Request $request, $id)
    {
        $lomba = Competition::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul_lomba' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',

            // Validasi kolom baru saat update
            'tgl_buka_pendaftaran' => 'required|date',
            'tgl_tutup_pendaftaran' => 'required|date|after_or_equal:tgl_buka_pendaftaran',
            'kuota_peserta' => 'required|integer|min:1',

            'link_panduan' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'benefits' => 'nullable|array',

            'bidang' => 'required|array|min:1',
            'bidang.*.nama_bidang' => 'required|string',
            'bidang.*.harga' => 'required|numeric|min:0',
            'bidang.*.link_wa' => 'required|url',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('posters', 'public');
                $lomba->poster = $posterPath;
            }

            // UPDATE DATA TERMASUK KOLOM BARU 👇
            $lomba->update([
                'judul_lomba' => $request->judul_lomba,
                'kategori' => $request->kategori,
                'tingkat_sekolah' => $request->tingkat_sekolah,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

                // Kolom baru
                'tgl_buka_pendaftaran' => $request->tgl_buka_pendaftaran,
                'tgl_tutup_pendaftaran' => $request->tgl_tutup_pendaftaran,
                'kuota_peserta' => $request->kuota_peserta,

                'link_panduan' => $request->link_panduan,
                'benefits' => $request->benefits ? json_encode($request->benefits) : null,
            ]);

            $submittedFieldIds = [];
            if ($request->has('bidang')) {
                foreach ($request->bidang as $item) {
                    $field = \App\Models\CompetitionField::updateOrCreate(
                        [
                            'id' => $item['id'] ?? null,
                            'competition_id' => $lomba->id
                        ],
                        [
                            'nama_bidang' => $item['nama_bidang'],
                            'tipe_pendaftaran' => $item['harga'] == 0 ? 'gratis' : 'berbayar',
                            'harga' => $item['harga'],
                            'link_wa' => $item['link_wa'],
                        ]
                    );
                    $submittedFieldIds[] = $field->id;
                }
            }

            \App\Models\CompetitionField::where('competition_id', $lomba->id)
                ->whereNotIn('id', $submittedFieldIds)
                ->delete();

            DB::commit();
            return redirect()->route('penyelenggara.dashboard')->with('success', 'Data lomba berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan saat update data: ' . $e->getMessage())->withInput();
        }
    }

    // 6. Menghapus Lomba
    public function destroy($id)
    {
        $lomba = Competition::where('user_id', Auth::id())->findOrFail($id);

        // 1. Hapus file poster dari penyimpanan
        if ($lomba->poster) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($lomba->poster);
        }
        $lomba->fields()->delete();
        $lomba->delete();
        return redirect()->route('penyelenggara.dashboard')->with('success', 'Lomba dan semua bidangnya berhasil dihapus bersih!');
    }

    // 7. Menampilkan Halaman Pembayaran QRIS (Langkah setelah Create)
    public function payment($id)
    {
        $lomba = Competition::where('user_id', Auth::id())->findOrFail($id);
        $tingkat = strtolower($lomba->tingkat_lomba);

        $harga = 0;
        if ($tingkat == 'kota' || $tingkat == 'umum') $harga = 25000;
        if ($tingkat == 'provinsi') $harga = 50000;
        if ($tingkat == 'nasional') $harga = 100000;
        if ($tingkat == 'internasional') $harga = 250000;

        return view('penyelenggara.payment', compact('lomba', 'harga'));
    }

    // 8. Konfirmasi Pembayaran Selesai (Ubah Draf -> Aktif & Catat Transaksi)
    public function confirmPayment($id)
    {
        $lomba = Competition::where('user_id', Auth::id())->findOrFail($id);

        // 1. Tentukan Ulang Harga Pembayaran (Sebagai bukti nominal di database)
        $tingkat = strtolower($lomba->tingkat_lomba);
        $harga = 0;

        if (in_array($tingkat, ['kota', 'umum'])) $harga = 25000;
        if ($tingkat == 'provinsi') $harga = 50000;
        if ($tingkat == 'nasional') $harga = 100000;
        if ($tingkat == 'internasional') $harga = 250000;

        // 2. Kode Transaksi panitia
        $kodeTransaksi = 'PUB-WINLY-' . strtoupper(\Illuminate\Support\Str::random(6));

        // 3. Catat Riwayat Uang Masuk ke Tabel Transactions
        // Kita pakai DB::table agar aman dan langsung masuk ke database
        \Illuminate\Support\Facades\DB::table('transactions')->insert([
            'user_id' => Auth::id(),
            'competition_id' => $lomba->id,
            'kode_transaksi' => $kodeTransaksi,
            'tipe_transaksi' => 'publikasi_lomba',
            'total_bayar' => $harga,
            'status_pembayaran' => 'berhasil',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Ubah status lomba menjadi Aktif
        $lomba->update([
            'status' => 'aktif'
        ]);

        return redirect()->route('penyelenggara.dashboard')->with('success', 'Pembayaran berhasil dikonfirmasi dan dicatat di sistem! Lomba Anda sekarang AKTIF.');
    }

    // 9. Verifikasi Pendaftaran Peserta (Dari Halaman Dashboard Penyelenggara)
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sukses,gagal'
        ]);

        $registration = \App\Models\Registration::findOrFail($id);

        // Update statusnya
        $registration->update([
            'status_pembayaran' => $request->status
        ]);

        $pesan = $request->status === 'sukses' ? 'Peserta berhasil diverifikasi! ✅' : 'Pendaftaran peserta ditolak. ❌';
        return back()->with('success', $pesan);
    }

    /**
     * Fungsi untuk Gembok Ke-3: Saklar Tutup/Buka Pendaftaran Manual
     */
    public function toggleStatus(Request $request, $id)
    {
        // 1. Cari lomba berdasarkan ID dan pastikan itu milik panitia yang sedang login (Keamanan)
        $lomba = \App\Models\Competition::where('user_id', Auth::id())->findOrFail($id);

        $isTutup = $request->has('is_pendaftaran_tutup');

        // 3. Update kolom di database
        $lomba->update([
            'is_pendaftaran_tutup' => $isTutup
        ]);

        // 4. Siapkan pesan sukses dinamis berdasarkan statusnya
        $pesan = $isTutup
            ? 'Rem Darurat ditarik: Pendaftaran lomba berhasil DITUTUP!'
            : 'Saklar dimatikan: Pendaftaran lomba kembali DIBUKA!';

        // 5. Kembalikan ke halaman dashboard beserta notifikasi SweetAlert
        return back()->with('success', $pesan);
    }
}
