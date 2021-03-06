<?php

declare(strict_types=1);

namespace Tipoff\Fees\Models;

use Tipoff\Locations\Models\Location;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class LocationFee extends BaseModel
{
    use HasCreator;
    use HasUpdater;
    use HasPackageFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bookingFee()
    {
        return $this->belongsTo(Fee::class, 'booking_fee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productFee()
    {
        return $this->belongsTo(Fee::class, 'product_fee_id');
    }
}
