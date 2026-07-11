<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenggajianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $komponenGajiId = $this->route('penggajian');

        return [
            'pegawai_id'          => 'required|exists:pegawai,id',
            'bulan'                => 'required|integer|min:1|max:12',
            'tahun'                => 'required|integer|min:2020|max:2100',
            'tunjangan_lainnya'    => 'nullable|numeric|min:0',
            'potongan_absensi'     => 'nullable|numeric|min:0',
            'potongan_lainnya'     => 'nullable|numeric|min:0',
            'status'               => 'required|in:draft,diproses,selesai',
            'tanggal_gaji'         => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'pegawai_id.required' => 'Pegawai wajib dipilih',
            'pegawai_id.exists'   => 'Pegawai tidak valid',
            'bulan.required'      => 'Bulan wajib diisi',
            'tahun.required'      => 'Tahun wajib diisi',
            'status.required'     => 'Status wajib dipilih',
            'tanggal_gaji.required' => 'Tanggal gaji wajib diisi',
        ];
    }
}