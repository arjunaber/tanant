<?php
// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Relationships
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'category_unit');
    }

    // Methods
    public function getUnitsCount()
    {
        return $this->units()->count();
    }

    public function getAvailableUnitsCount()
    {
        return $this->units()->where('status', 'available')->count();
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }
}
