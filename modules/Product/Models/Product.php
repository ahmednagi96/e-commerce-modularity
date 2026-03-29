<?php 

namespace  Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\Models\OrderLine;
use Modules\Product\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    protected static function newFactory():ProductFactory
    {
        return new ProductFactory();  
    }
 
    protected $fillable = ["name","price_in_cents","stock"];

    public function lines():HasMany
    {
        return $this->hasMany(OrderLine::class);
    }
}