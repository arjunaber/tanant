<?php
// app/Models/CategoryUnit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryUnit extends Pivot
{
    protected $table = 'category_unit';

    public $incrementing = true;

    protected $fillable = [
        'category_id',
        'unit_id',
    ];

    public $timestamps = true;
}
