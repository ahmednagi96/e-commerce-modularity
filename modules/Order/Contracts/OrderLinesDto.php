<?php 

namespace Modules\Order\Contracts;
use Illuminate\Support\Collection;
use Modules\Order\OrderLine;


readonly class OrderLinesDto
{
    public function __construct(
        public int $productId,
        public int $quantity
    )
    {
    }
    public static function fromEloquentModel(OrderLine $orderLine): OrderLinesDto
    {
        return new OrderLinesDto($orderLine->product_id, $orderLine->quantity);
    }
    public static function fromEloquentCollection(Collection $orderLines): Collection
    {
        return $orderLines->map(function (OrderLine $orderLine) {
            return self::fromEloquentModel($orderLine);
        })->collect();
    }
}