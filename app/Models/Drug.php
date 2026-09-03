<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Drug extends Model {

    /** @use HasFactory<\Database\Factories\DrugFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'classification_id'
    ];

    public function classification() : BelongsTo {
        return $this->belongsTo(Classification::class);
    }
}
