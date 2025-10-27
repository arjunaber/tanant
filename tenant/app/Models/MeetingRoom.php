<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    use HasFactory;

    protected $fillable = ['kode_ruangan', 'nama_ruangan', 'deskripsi', 'status'];

    // Relasi ke kategori (Many-to-Many)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_meeting_room');
    }
}