<?php 

namespace Modules\Order\DTOs;

use Illuminate\Support\Collection;
use Modules\Order\Models\Order;

readonly class OrderDto
{

    public function __construct(
        public int $orderId,
        public float $totalInCents,
        public string $localizedTotal,
        public string $url,
        public Collection $lines
    ){

    }
    public static function fromEloguentModel(Order $order):self{
        return new self($order->id, $order->total_in_cents, $order->localizedTotal(),$order->url(),OrderLinesDto::fromEloquentCollection($order->lines));
    }
}