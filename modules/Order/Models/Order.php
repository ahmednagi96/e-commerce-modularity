<?php 

namespace Modules\Order\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Payment\Models\Payment;

class Order extends Model{

    protected $table = "orders";
    protected $fillable = [
        "user_id",
        "total_in_cents",
        "status",
        "payment_id",
        "payment_method"
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function lines():HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function payments():HasMany{
        
        return $this->hasMany(Payment::class);
    }
    public function lastPayment():HasOne{
        return $this->payments()->one()->latest();
    }
}