<?php
// app/Models/Rental.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_code',
        'user_id',
        'unit_id',
        'start_date',
        'end_date',
        'return_date',
        'total_price',
        'late_fee',
        'status',
        'purpose',
        'processed_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'return_date' => 'date',
        'total_price' => 'decimal:2',
        'late_fee' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isOverdue()
    {
        return $this->status === 'overdue';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function getRentalDays()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getLateDays()
    {
        if (!$this->return_date && $this->end_date->lt(now())) {
            return $this->end_date->diffInDays(now());
        }

        if ($this->return_date && $this->end_date->lt($this->return_date)) {
            return $this->end_date->diffInDays($this->return_date);
        }

        return 0;
    }

    public function getTotalAmount()
    {
        return $this->total_price + $this->late_fee;
    }

    public function getFormattedTotalPrice()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getFormattedLateFee()
    {
        return 'Rp ' . number_format($this->late_fee, 0, ',', '.');
    }

    public function getFormattedTotalAmount()
    {
        return 'Rp ' . number_format($this->getTotalAmount(), 0, ',', '.');
    }

    public function checkOverdue()
    {
        if ($this->isActive() && $this->end_date->lt(now())) {
            $this->update([
                'status' => 'overdue',
                'late_fee' => $this->unit->calculateLateFee($this->getLateDays())
            ]);
            return true;
        }
        return false;
    }

    public function completeRental($processedBy)
    {
        $this->update([
            'return_date' => now(),
            'status' => 'completed',
            'processed_by' => $processedBy,
        ]);

        // Update unit status to available
        $this->unit->update(['status' => 'available']);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('rental_code', 'like', "%{$search}%")
            ->orWhere('purpose', 'like', "%{$search}%")
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('unit', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rental) {
            if (empty($rental->rental_code)) {
                $rental->rental_code = 'RENT-' . strtoupper(uniqid());
            }
        });

        static::created(function ($rental) {
            // Update unit status to occupied when rental is created
            if ($rental->unit) {
                $rental->unit->update(['status' => 'occupied']);
            }
        });

        static::updated(function ($rental) {
            // Update unit status when rental is completed or cancelled
            if ($rental->isCompleted() || $rental->isCancelled()) {
                $rental->unit->update(['status' => 'available']);
            }
        });
    }
}
