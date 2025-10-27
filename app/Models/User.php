<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function processedRentals()
    {
        return $this->hasMany(Rental::class, 'processed_by');
    }

    // Methods - TAMBAHKAN METHOD INI
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function getActiveRentalsCount()
    {
        return $this->rentals()
            ->whereIn('status', ['active', 'overdue'])
            ->count();
    }

    public function canRentAnotherUnit()
    {
        return $this->getActiveRentalsCount() < 2;
    }
}