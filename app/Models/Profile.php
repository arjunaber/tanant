<?php
// app/Models/Profile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'identity_number',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Methods
    public function getFormattedPhone()
    {
        return $this->phone ?: 'Belum diisi';
    }

    public function getFormattedAddress()
    {
        return $this->address ?: 'Belum diisi';
    }

    public function getFormattedIdentityNumber()
    {
        return $this->identity_number ?: 'Belum diisi';
    }
}
