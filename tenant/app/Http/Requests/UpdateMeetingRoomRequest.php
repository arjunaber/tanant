<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('meeting_room')->id;
        return [
            'kode_ruangan' => 'required|unique:meeting_rooms,kode_ruangan,' . $id,
            'nama_ruangan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}