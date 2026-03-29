<?php

namespace Modules\Payment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Models\Order;

class Payment extends Model
{
    protected $fillable = [
        "user_id",
        "order_id",
        "payment_id",
        "payment_gateway",
        "status",
        "total_in_cents"
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
