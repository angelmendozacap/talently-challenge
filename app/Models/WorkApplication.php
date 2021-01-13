<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'phase_id' => 'integer',
    ];

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
}
