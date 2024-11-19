<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    // Generate unique transaction id
    public static function generateUniqueTrxId()
    {
        $prefix = 'TR';

        do {
            $randString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randString)->exists());

        return $randString;
    }

    // Relations
    public function officeSpace(): BelongsTo
    {
        return $this->belongsTo(OfficeSpace::class, 'office_space_id');
    }
}
