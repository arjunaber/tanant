<?php
// app/Models/Unit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'price_per_day',
        'status',
        'capacity',
        'facilities',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'capacity' => 'integer',
    ];

    // Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_unit');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function activeRental()
    {
        return $this->hasOne(Rental::class)
            ->whereIn('status', ['active', 'overdue']);
    }

    // Methods
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isOccupied()
    {
        return $this->status === 'occupied';
    }

    public function isUnderMaintenance()
    {
        return $this->status === 'maintenance';
    }

    public function getStatusBadge()
    {
        switch ($this->status) {
            case 'available':
                return '<span class="text-xs font-medium text-green-800 bg-green-100 px-2 py-1 rounded">Tersedia</span>';
            case 'occupied':
                return '<span class="text-xs font-medium text-red-800 bg-red-100 px-2 py-1 rounded">Ditempati</span>';
            case 'maintenance':
                return '<span class="text-xs font-medium text-yellow-800 bg-yellow-100 px-2 py-1 rounded">Perawatan</span>';
            default:
                return '<span class="text-xs font-medium text-gray-800 bg-gray-100 px-2 py-1 rounded">Unknown</span>';
        }
    }

    public function getFormattedPrice()
    {
        return 'Rp ' . number_format($this->price_per_day, 0, ',', '.');
    }

    public function getCategoryNames()
    {
        return $this->categories->pluck('name')->implode(', ');
    }

    public function getFacilitiesArray()
    {
        return $this->facilities ? explode(', ', $this->facilities) : [];
    }

    public function calculateRentalPrice($days)
    {
        return $this->price_per_day * $days;
    }

    public function calculateLateFee($lateDays)
    {
        return $this->price_per_day * 0.2 * $lateDays; // 20% per hari
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    public function scopeWithCategory($query, $categoryName)
    {
        return $query->whereHas('categories', function ($q) use ($categoryName) {
            $q->where('categories.name', 'like', "%{$categoryName}%");
        });
    }
}
