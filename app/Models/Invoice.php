<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_number',
        'client_id',
        'data'
    ];

    protected $appends = ['expired_at'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getExpiredAtAttribute()
    {
        return $this->created_at->addMonth()->format('d/m/Y');
    }

    public function getDataAttribute($value)
    {
        return json_decode($value, true);
    }
}
