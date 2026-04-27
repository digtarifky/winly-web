<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Registration;
use App\Models\CompetitionField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    // 1. Memproses Pendaftaran
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari form
        $request->validate([
            'field_id' => 'required|exists:competition_fields,id',
            'jalur' => 'required|in:gratis,berbayar',
            'bukti_follow' => 'required_if:jalur,gratis|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_share' => 'required_if:jalur,gratis|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_komentar' => 'required_if:jalur,gratis|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil data bidang untuk mendapatkan competition_id
        $bidang = CompetitionField::findOrFail($request->field_id);

        // 3. cek redudansi user
        $sudahDaftar = Registration::where('user_id', Auth::id())
            ->where('competition_field_id', $bidang->id)
            ->exists();

        if ($sudahDaftar) {
            return back()->withErrors('Gagal: Kamu sudah terdaftar di bidang ini sebelumnya!');
        }

        // 4. Simpan gambar bukti ke public
        $pathFollow = $request->hasFile('bukti_follow') ? $request->file('bukti_follow')->store('bukti_pendaftaran', 'public') : null;
        $pathShare = $request->hasFile('bukti_share') ? $request->file('bukti_share')->store('bukti_pendaftaran', 'public') : null;
        $pathKomentar = $request->hasFile('bukti_komentar') ? $request->file('bukti_komentar')->store('bukti_pendaftaran', 'public') : null;

        // 5. Simpan data pendaftaran ke Database
        $registration = Registration::create([
            'user_id' => Auth::id(),
            'competition_id' => $bidang->competition_id,
            'competition_field_id' => $bidang->id,
            'jalur_pendaftaran' => $request->jalur,
            'bukti_follow' => $pathFollow,
            'bukti_share' => $pathShare,
            'bukti_komentar' => $pathKomentar,
            'status_pembayaran' => $request->jalur === 'gratis' ? 'sukses' : 'menunggu',
        ]);


        // 6. LOGIKA PINTAR: Redirect berdasarkan Jalur
        // ======================================================
        if ($request->jalur === 'gratis') {
            $linkWa = $bidang->link_wa ?? 'https://wa.me/';
            return redirect()->away($linkWa);
        } else {
            return redirect()->route('peserta.payment', $registration->id);
        }
    }

    // 2. Menampilkan Halaman Pembayaran Peserta 
    public function payment($id)
    {
        $registration = Registration::with('field.competition')->findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan tagihan Anda.');
        }

        return view('payment', compact('registration'));
    }

    // 3. Memproses Konfirmasi Pembayaran
    public function confirmPayment($id)
    {
        $registration = Registration::with('field')->findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $harga = $registration->field->harga;
        $competitionId = $registration->field->competition_id;
        $kodeTransaksi = 'CUS-WINLY-' . strtoupper(Str::random(6));

        DB::beginTransaction();
        try {
            // 1. Catat ke tabel Transactions
            DB::table('transactions')->insert([
                'user_id' => Auth::id(),
                'competition_id' => $competitionId,
                'kode_transaksi' => $kodeTransaksi,
                'tipe_transaksi' => 'pendaftaran_lomba',
                'total_bayar' => $harga,
                'status_pembayaran' => 'berhasil',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $registration->update([
                'status_pembayaran' => 'sukses'
            ]);

            DB::commit();

            return redirect()->route('competitions')->with('success', 'Pembayaran berhasil! Anda telah resmi terdaftar di perlombaan ini.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
}
