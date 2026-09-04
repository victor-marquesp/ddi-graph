<?php

namespace App\Models;

use App\Enums\Severity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model {

    /** @use HasFactory<\Database\Factories\InteractionFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'drugA_id',
        'drugB_id',
        'severity',
        'description'
    ];

    protected $casts = [
        'severity' => Severity::class
    ];

    public function drugA() : BelongsTo {
        return $this->belongsTo(Drug::class, 'drugA_id');
    }

    public function drugB() : BelongsTo {
        return $this->belongsTo(Drug::class, 'drugB_id');
    }
    
}
