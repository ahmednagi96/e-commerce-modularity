<?php

namespace Modules\Order\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Order\Exceptions\OrderMissingOrderLinesExcException;
use Modules\Payment\Models\Payment;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;

class Order extends Model
{
    

    protected $table = "orders";
    protected $fillable = [
        "user_id",
        "total_in_cents",
        "status",
    ];


    public const PENDING = "pending";
    public const COMPLETED = "completed";


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class, "order_id");
    }

    public function payments(): HasMany
    {

        return $this->hasMany(Payment::class);
    }
    public function lastPayment(): HasOne
    {
        return $this->payments()->one()->latest();
    }
    public function url(): string
    {
        return route("order::orders.show", $this);
    }


    /**  @return self */
    public static function startForUser(int $userId): self
    {
        return  self::make(
            [
                "user_id" => $userId,
                "status" => self::PENDING
            ]
        );
    }

    /** @param CartItemCollection<CartItem> $items */
    /** @return void */
    public function addOrderLinesFromCartItems(CartItemCollection $items): void
    {
        foreach($items->items() as $item){
            $this->lines->push(OrderLine::make([
                "product_id"=>$item->productDto->id,
                "quantity"=>$item->quantity,
                "product_price_in_cents"=>$item->productDto->priceInCents,
            ]));
        }
    
        $this->total_in_cents=$this->lines->sum(fn(OrderLine $orderLine)=>$orderLine->quantity * $orderLine->product_price_in_cents);
    }
    
    
    /** @return void */
    /** @throws  OrderMissingOrderLinesExcException */
    public function fulfill(): void
    {
        if ($this->lines->isEmpty()) {
            throw OrderMissingOrderLinesExcException::forOrder();
        }
    
        $this->status = self::COMPLETED;
        $this->save();
    
        $this->lines()->saveMany($this->lines);
    }
    
    
}
