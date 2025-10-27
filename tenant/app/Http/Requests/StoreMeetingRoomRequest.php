<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sudah di-handle middleware admin
    }

    public function rules(): array
    {
        return [
            'kode_ruangan' => 'required|unique:meeting_rooms,kode_ruangan',
            'nama_ruangan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}