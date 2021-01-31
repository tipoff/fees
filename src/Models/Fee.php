<?php

namespace Tipoff\Fees\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tipoff\Support\Models\BaseModel;

class Fee extends BaseModel
{
    use HasFactory;

    const APPLIES_TO_EACH = 'each';
    const APPLIES_TO_PRODUCT = 'product';
    const APPLIES_TO_BOOKING = 'booking';
    const APPLIES_TO_PARTICIPANT = 'participant';

    protected $guarded = ['id'];
    protected $casts = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fee) {
            if (auth()->check()) {
                $fee->creator_id = auth()->id();
            }
        });
        static::saving(function ($fee) {
            if (empty($fee->amount) && empty($fee->percent)) {
                throw new Exception('A fee must have either an amount or percent.');
            }
            if (! empty($fee->amount) && ! empty($fee->percent)) {
                throw new Exception('A fee cannot have both an amount & percent.');
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(config('fees.user_model'), 'creator_id');
    }

    public function locationBookingFees()
    {
        return $this->hasMany(config('fees.location_model'), 'booking_fee_id');
    }

    public function locationProductFees()
    {
        return $this->hasMany(config('fees.location_model'), 'product_fee_id');
    }

    public function bookings()
    {
        return $this->hasMany(config('fees.booking_model'));
    }
}
