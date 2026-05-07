<?php

namespace App\Exports;

use App\Models\Registration;
use App\Models\Competition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesertaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $organizerId;
    protected $rowNumber = 0;

    // Menangkap ID Panitia saat class dipanggil
    public function __construct($organizerId)
    {
        $this->organizerId = $organizerId;
    }

    // Mengambil data dari database
    public function collection()
    {
        $competitionIds = Competition::where('user_id', $this->organizerId)->pluck('id')->toArray();

        return Registration::with(['user.profile', 'field.competition'])
            ->whereHas('field', function ($query) use ($competitionIds) {
                $query->whereIn('competition_id', $competitionIds);
            })
            ->where('status_pembayaran', 'sukses') // HANYA AMBIL YANG VALID
            ->latest()
            ->get();
    }

    // Membuat Judul Kolom (Header) di Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'No. WhatsApp',
            'Asal Instansi',
            'Nama Lomba',
            'Bidang',
            'Jalur',
            'Tanggal Daftar'
        ];
    }

    // Memetakan isi data per baris
    public function map($registration): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $registration->user->profile->nama_lengkap ?? '-',
            $registration->user->profile->no_wa ?? '-',
            $registration->user->profile->asal_instansi ?? '-',
            $registration->field->competition->judul_lomba ?? '-',
            $registration->field->nama_bidang ?? 'Umum',
            strtoupper($registration->jalur),
            $registration->created_at->format('d-m-Y H:i'),
        ];
    }
}