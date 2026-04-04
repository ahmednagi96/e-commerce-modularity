<?php 

namespace Modules\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Models\Product;

class OrderLine extends Model
{

    protected $table = "order_lines";

    protected $fillable = [
        "order_id","product_id","quantity","product_price_in_cents"
    ];

   public function order():BelongsTo{
    return $this->belongsTo(Order::class);
   }
   public function product():BelongsTo{
        return $this->belongsTo(Product::class);
   }
}