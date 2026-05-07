<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\CompetitionField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizerController extends Controller
{
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
        
        // Asumsi: status_pembayaran 'pending' artinya butuh cek bukti (Gratis) atau nunggu bayar (Premium)
        $pesertaPending = $registrations->whereIn('status_pembayaran', ['pending', 'menunggu_verifikasi'])->count();

        return view('penyelenggara.index', compact(
            'user', 
            'competitions', 
            'registrations', 
            'totalPendaftar', 
            'pesertaValid', 
            'pesertaPending'
        ));
    }

    // 3. Memproses Data dari Form Tambah Lomba
    public function store(Request $request)
    {
        // A. Validasi Data yang Masuk
        $request->validate([
            'judul_lomba' => 'required|string|max:255',
            'kategori' => 'required|string|in:akademik,teknologi_it,ekonomi_bisnis,karya_tulis,seni_desain,kesehatan,soshum_hukum',
            'tingkat_sekolah' => 'required|string|in:sd,smp,sma,mahasiswa',
            'tingkat_lomba' => 'required|in:kota,umum,provinsi,nasional,internasional',
            'tanggal_pelaksanaan' => 'nullable|date',
            'link_panduan' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'benefits' => 'nullable|array',

            'bidang' => 'required|array|min:1',
            'bidang.*.nama_bidang' => 'required|string',
            'bidang.*.harga' => 'required|numeric|min:0',
            'bidang.*.link_wa' => 'required|url',
        ]);

        // B. Mulai Transaksi Database
        DB::beginTransaction();
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // C. Proses Upload Poster
            $posterPath = null;
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('posters', 'public');
            }

            // D. Logika Potong Kuota & Penentuan Berbayar
            $status = 'draf';
            $isPaid = false;

            // Ubah input jadi huruf kecil semua agar aman
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

            // E. Simpan ke tabel Competitions
            $competition = Competition::create([
                'user_id' => $user->id,
                'judul_lomba' => $request->judul_lomba,
                'kategori' => $request->kategori,
                'tingkat_sekolah' => $request->tingkat_sekolah,
                'deskripsi' => $request->deskripsi ?? 'Deskripsi belum tersedia.',
                'poster' => $posterPath,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'tingkat_lomba' => $request->tingkat_lomba,
                'link_panduan' => $request->link_panduan,
                'status' => $status,
                'benefits' => $request->benefits ? json_encode($request->benefits) : null,
            ]);

            // F. Looping untuk menyimpan banyak Bidang sekaligus
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

            // Jika lomba berbayar, lempar ke halaman QRIS
            if ($isPaid) {
                return redirect()->route('penyelenggara.payment', $competition->id);
            }

            return redirect()->route('penyelenggara.dashboard')->with('success', 'Lomba berhasil diterbitkan!');
        } catch (\Exception $e) {

            DB::rollback();
            return back()->withErrors('Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
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

        // 1. Validasi Data yang Masuk (Termasuk validasi Bidang)
        $request->validate([
            'judul_lomba' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'link_panduan' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'benefits' => 'nullable|array',
            
            // Wajib memvalidasi array bidang agar aman
            'bidang' => 'required|array|min:1',
            'bidang.*.nama_bidang' => 'required|string',
            'bidang.*.harga' => 'required|numeric|min:0',
            'bidang.*.link_wa' => 'required|url',
        ]);

        DB::beginTransaction();
        try {
            // 2. Proses Poster (Sama seperti aslimu)
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('posters', 'public');
                $lomba->poster = $posterPath;
            }

            // 3. Update Data Induk Lomba
            $lomba->update([
                'judul_lomba' => $request->judul_lomba,
                'kategori' => $request->kategori,
                'tingkat_sekolah' => $request->tingkat_sekolah,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'link_panduan' => $request->link_panduan,
                'benefits' => $request->benefits ? json_encode($request->benefits) : null,
            ]);

            // =======================================================
            // 4. FIX BUG: PROSES SINKRONISASI BIDANG & LINK WA
            // =======================================================
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
            return redirect()->route('penyelenggara.dashboard')->with('success', 'Data lomba dan bidang berhasil diperbarui!');
            
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
}
