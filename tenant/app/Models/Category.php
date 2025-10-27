<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    // Relasi ke MeetingRoom (Many-to-Many)
    public function meetingRooms()
    {
        return $this->belongsToMany(MeetingRoom::class, 'category_meeting_room');
    }
}