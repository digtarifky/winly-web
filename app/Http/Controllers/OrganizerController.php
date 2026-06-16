<?php

namespace App\Http\Controllers;

use App\Exports\PesertaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Competition;
use App\Models\CompetitionField;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $competitionIds = $competitions->pluck('id')->toArray();

        // 2. Hitung Data untuk 3 Kotak Statistik (Langsung Query DB agar lebih ringan)
        $totalPendaftar = Registration::whereHas('field', function ($query) use ($competitionIds) {
            $query->whereIn('competition_id', $competitionIds);
        })->count();

        $pesertaValid = Registration::whereHas('field', function ($query) use ($competitionIds) {
            $query->whereIn('competition_id', $competitionIds);
        })->where('status_pembayaran', 'sukses')->count();

        $pesertaPending = Registration::whereHas('field', function ($query) use ($competitionIds) {
            $query->whereIn('competition_id', $competitionIds);
        })->whereIn('status_pembayaran', ['menunggu', 'menunggu_verifikasi'])->count();

        // 3. PISAHKAN DATA UNTUK DITAMPILKAN DI TABEL DENGAN PAGINATION (MAX 7)
        $validRegistrations = Registration::with(['user.profile', 'field.competition'])
            ->whereHas('field', function ($query) use ($competitionIds) {
                $query->whereIn('competition_id', $competitionIds);
            })
            ->where('status_pembayaran', 'sukses')
            ->latest()
            ->paginate(10, ['*'], 'valid_page');

        $pendingRegistrations = Registration::with(['user.profile', 'field.competition'])
            ->whereHas('field', function ($query) use ($competitionIds) {
                $query->whereIn('competition_id', $competitionIds);
            })
            ->whereIn('status_pembayaran', ['menunggu', 'menunggu_verifikasi'])
            ->latest()
            ->paginate(10, ['*'], 'pending_page');

        return view('penyelenggara.dashboard', compact(
            'user',
            'competitions',
            'totalPendaftar',
            'pesertaValid',
            'pesertaPending',
            'pendingRegistrations', 
            'validRegistrations'    
        ));
    }

    // 2. Fungsi Form Buat Lomba
    public function manajemen()
    {
        $user = Auth::user();
        $competitions = Competition::where('user_id', $user->id)->latest()->get();

        return view('penyelenggara.manajemen', compact('user', 'competitions'));
    }

    // Khusus untuk memanggil form kosong tambah lomba
    public function create()
    {
        if (Auth::user()->status_verifikasi !== 'verified') {
            return redirect()->route('penyelenggara.manajemen')
                ->with('error', 'Akses ditolak. Akun Anda belum diverifikasi oleh Admin.');
        }
        return view('penyelenggara.create');
    }

    // 3. Memproses Data dari Form Tambah Lomba
    public function store(Request $request)
    {   
        if (Auth::user()->status_verifikasi !== 'verified') {
            return redirect()->route('penyelenggara.manajemen')
                ->with('error', 'Akses ditolak. Akun Anda belum diverifikasi oleh Admin.');
        }
        
        $request->validate([
            'judul_lomba' => 'required|string|max:255',
            'kategori' => 'required|string|in:akademik,teknologi_it,ekonomi_bisnis,karya_tulis,seni_desain,kesehatan,soshum_hukum',
            'tingkat_sekolah' => 'required|string|in:sd,smp,sma,mahasiswa',
            'tingkat_lomba' => 'required|in:kota,umum,provinsi,nasional,internasional',
            'tanggal_pelaksanaan' => 'nullable|date',

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
            /** @var User $user */
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

            $competition = Competition::create([
                'user_id' => $user->id,
                'judul_lomba' => $request->judul_lomba,
                'kategori' => $request->kategori,
                'tingkat_sekolah' => $request->tingkat_sekolah,
                'deskripsi' => $request->deskripsi ?? 'Deskripsi belum tersedia.',
                'poster' => $posterPath,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

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
    }

    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        $lomba = Competition::with('fields')->where('user_id', Auth::id())->findOrFail($id);
        return view('penyelenggara.edit', compact('lomba'));
    }

    // 5. Memproses Data Update
    public function update(Request $request, $id)
    {
        $lomba = Competition::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul_lomba' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',

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

            $lomba->update([
                'judul_lomba' => $request->judul_lomba,
                'kategori' => $request->kategori,
                'tingkat_sekolah' => $request->tingkat_sekolah,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

                'tgl_buka_pendaftaran' => $request->tgl_buka_pendaftaran,
                'tgl_tutup_pendaftaran' => $request->tgl_tutup_pendaftaran,
                'kuota_peserta' => $request->kuota_peserta,

                'link_panduan' => $request->link_panduan,
                'benefits' => $request->benefits ? json_encode($request->benefits) : null,
            ]);

            $submittedFieldIds = [];
            if ($request->has('bidang')) {
                foreach ($request->bidang as $item) {
                    $field = CompetitionField::updateOrCreate(
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

            CompetitionField::where('competition_id', $lomba->id)
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

        if ($lomba->poster) {
            Storage::disk('public')->delete($lomba->poster);
        }
        
        $lomba->fields()->delete();
        $lomba->delete();
        return redirect()->route('penyelenggara.dashboard')->with('success', 'Lomba dan semua bidangnya berhasil dihapus bersih!');
    }

    // 7. Menampilkan Halaman Pembayaran QRIS
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

    // 8. Konfirmasi Pembayaran Selesai
    public function confirmPayment($id)
    {
        $lomba = Competition::where('user_id', Auth::id())->findOrFail($id);

        $tingkat = strtolower($lomba->tingkat_lomba);
        $harga = 0;

        if (in_array($tingkat, ['kota', 'umum'])) $harga = 25000;
        if ($tingkat == 'provinsi') $harga = 50000;
        if ($tingkat == 'nasional') $harga = 100000;
        if ($tingkat == 'internasional') $harga = 250000;

        $kodeTransaksi = 'PUB-WINLY-' . strtoupper(Str::random(6));

        DB::table('transactions')->insert([
            'user_id' => Auth::id(),
            'competition_id' => $lomba->id,
            'kode_transaksi' => $kodeTransaksi,
            'tipe_transaksi' => 'publikasi_lomba',
            'total_bayar' => $harga,
            'status_pembayaran' => 'berhasil',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lomba->update([
            'status' => 'aktif'
        ]);

        return redirect()->route('penyelenggara.dashboard')->with('success', 'Pembayaran berhasil dikonfirmasi dan dicatat di sistem! Lomba Anda sekarang AKTIF.');
    }

    // 9. Verifikasi Pendaftaran Peserta
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sukses,gagal'
        ]);

        $registration = Registration::findOrFail($id);

        $registration->update([
            'status_pembayaran' => $request->status
        ]);

        $pesan = $request->status === 'sukses' ? 'Peserta berhasil diverifikasi! ✅' : 'Pendaftaran peserta ditolak. ❌';
        return back()->with('success', $pesan);
    }

    // 10. Saklar Tutup/Buka Pendaftaran Manual
    public function toggleStatus(Request $request, $id)
    {
        $lomba = Competition::where('user_id', Auth::id())->findOrFail($id);
        $isTutup = $request->has('is_pendaftaran_tutup');

        $lomba->update([
            'is_pendaftaran_tutup' => $isTutup
        ]);

        $pesan = $isTutup
            ? 'Rem Darurat ditarik: Pendaftaran lomba berhasil DITUTUP!'
            : 'Saklar dimatikan: Pendaftaran lomba kembali DIBUKA!';

        return back()->with('success', $pesan);
    }

    // 11. Halaman Statistik & Laporan
    public function statistik()
    {
        $user = Auth::user();
        
        // 1. Ambil semua lomba milik panitia
        $competitions = Competition::where('user_id', $user->id)->latest()->get();
        $competitionIds = $competitions->pluck('id')->toArray();

        // 2. Ambil semua registrasi terkait lomba tersebut beserta relasinya
        $allRegistrations = Registration::with(['user.profile', 'field'])
            ->whereHas('field', function ($query) use ($competitionIds) {
                $query->whereIn('competition_id', $competitionIds);
            })->get();

        // ==========================================
        // DATA GRAFIK 1: Pemasukan & Jalur
        // ==========================================
        // Asumsi nilai kolom di DB adalah 'gratis' dan 'berbayar'
        $jalurGratis = $allRegistrations->where('jalur_pendaftaran', 'gratis')->count();
        $jalurBerbayar = $allRegistrations->whereIn('jalur_pendaftaran', ['berbayar', 'premium'])->count(); 
        $totalPendapatan = $allRegistrations->whereIn('status_pembayaran', ['sukses', 'lolos', 'lunas'])->sum(function ($reg) {
            return $reg->field->harga ?? 0;
        });

        // ==========================================
        // DATA GRAFIK 2: Tren Pendaftaran 14 Hari Terakhir
        // ==========================================
        $tanggalMulai = Carbon::now()->subDays(13)->startOfDay();
        $trenData = $allRegistrations->where('created_at', '>=', $tanggalMulai)
            ->groupBy(function ($reg) {
                return Carbon::parse($reg->created_at)->format('Y-m-d');
            });

        $labelTren = [];
        $dataTren = [];
        
        // Looping mundur 14 hari agar tanggal yang kosong tetap terisi angka 0
        for ($i = 0; $i < 14; $i++) {
            $tgl = Carbon::now()->subDays(13 - $i)->format('Y-m-d');
            $labelTren[] = Carbon::parse($tgl)->format('d M');
            $dataTren[] = isset($trenData[$tgl]) ? $trenData[$tgl]->count() : 0;
        }

        // ==========================================
        // DATA GRAFIK 3: Kinerja Verifikasi per Lomba
        // ==========================================
        $labelLomba = [];
        $dataSukses = [];
        $dataPending = [];
        $dataGagal = [];

        foreach ($competitions as $lomba) {
            // Potong judul agar label di bawah grafik tidak kepanjangan
            $labelLomba[] = Str::limit($lomba->judul_lomba, 15);
            $regsLomba = $allRegistrations->where('field.competition_id', $lomba->id);
            
            $dataSukses[] = $regsLomba->whereIn('status_pembayaran', ['sukses', 'lolos', 'lunas'])->count();
            $dataPending[] = $regsLomba->whereIn('status_pembayaran', ['menunggu', 'menunggu_verifikasi'])->count();
            $dataGagal[] = $regsLomba->where('status_pembayaran', 'gagal')->count();
        }

        // ==========================================
        // DATA GRAFIK 4: Top 5 Instansi
        // ==========================================
        $instansiCounts = [];
        foreach ($allRegistrations as $reg) {
            // Cek field instansi / asal_instansi
            $instansi = $reg->user->profile->asal_instansi ?? $reg->user->profile->instansi ?? 'Umum / Lainnya';
            if (!isset($instansiCounts[$instansi])) {
                $instansiCounts[$instansi] = 0;
            }
            $instansiCounts[$instansi]++;
        }
        
        // Urutkan dari yang terbanyak dan potong ambil 5 teratas
        arsort($instansiCounts);
        $topInstansi = array_slice($instansiCounts, 0, 5);
        
        $labelInstansi = array_keys($topInstansi);
        $dataInstansi = array_values($topInstansi);

        // Lempar semua data super lengkap ini ke View baru
        return view('penyelenggara.statistik', compact(
            'user',
            'jalurGratis', 'jalurBerbayar', 'totalPendapatan',
            'labelTren', 'dataTren',
            'labelLomba', 'dataSukses', 'dataPending', 'dataGagal',
            'labelInstansi', 'dataInstansi'
        ));
    }
}