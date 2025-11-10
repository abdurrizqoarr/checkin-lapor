<?php

namespace App\Exports;

use App\Models\CheckinLogs;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CheckinLogsExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected $start;

    protected $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = CheckinLogs::query()
            ->join('users', 'checkin_logs.user_id', '=', 'users.id') // join ke tabel users
            ->join('point_qr', 'checkin_logs.point_qr_id', '=', 'point_qr.id') // join ke tabel users
            ->select(
                'checkin_logs.id',
                'checkin_logs.user_id',
                'users.name as user_name',      // ambil nama user
                'point_qr.nama_point',
                'checkin_logs.point_qr_id',
                'checkin_logs.waktu_checkin',
                'checkin_logs.foto_bukti',
                'checkin_logs.latitude',
                'checkin_logs.longitude',
                'checkin_logs.ip'
            );

        if ($this->start && $this->end) {
            $query->whereBetween('checkin_logs.waktu_checkin', [$this->start, $this->end]);
        }

        $data = $query->get();

        // Ubah kolom foto_bukti menjadi URL publik
        $data->transform(function ($item) {
            $item->foto_bukti = $item->foto_bukti
                ? env('APP_URL').Storage::url($item->foto_bukti)
                : null;

            return $item;
        });

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'User Name',          // kolom baru dari join
            'Lokasi',          // kolom baru dari join
            'Point QR ID',
            'Waktu Check-in',
            'Foto Bukti (URL)',
            'Latitude',
            'Longitude',
            'IP Address',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // membuat baris header (baris 1) menjadi bold
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
