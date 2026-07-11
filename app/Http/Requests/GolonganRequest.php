<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GolonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $golonganId = $this->route('golongan');
        return [
            'kode' => 'required|string|max:10|unique:golongan,kode,' . $golonganId,
            'nama_golongan' => 'required|string|max:50',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_makan' => 'required|numeric|min:0',
            'tunjangan_transport' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode golongan wajib diisi',
            'kode.unique' => 'Kode golongan sudah terdaftar',
            'nama_golongan.required' => 'Nama golongan wajib diisi',
            'gaji_pokok.required' => 'Gaji pokok wajib diisi',
            'gaji_pokok.min' => 'Gaji pokok tidak boleh kurang dari 0',
            'tunjangan_makan.required' => 'Tunjangan makan wajib diisi',
            'tunjangan_transport.required' => 'Tunjangan transport wajib diisi',
        ];
    }
}
