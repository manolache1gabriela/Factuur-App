<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    protected $fillable = ['name', 'address', 'btw_number', 'add_btw'];
    use HasFactory;
    public function invoice():HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}