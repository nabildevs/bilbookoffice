<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    // Generate api key
    public static function generateApiKey()
    {
        $prefix = 'API';

        do {
            $randString = $prefix . mt_rand(1000000, 999999);
        } while (self::where('key', $randString)->exists());

        return $randString;
    }
}
