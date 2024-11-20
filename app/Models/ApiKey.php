<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    // Generate api key
    public static function generateApiKey()
    {
        do {
            $randString = Str::random(32);
        } while (self::where('key', $randString)->exists());

        return $randString;
    }

    // Store api key
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->key)) {
                $model->key = self::generateApiKey();
            }
        });
    }
}
