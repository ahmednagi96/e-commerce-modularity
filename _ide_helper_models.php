<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payment\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace Modules\Order{
/**
 * @property int $id
 * @property string|null $payment_id
 * @property string|null $payment_method
 * @property int $user_id
 * @property numeric $total_in_cents
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Payment\Models\Payment|null $lastPayment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Order\OrderLine> $lines
 * @property-read int|null $lines_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payment\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotalInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace Modules\Order{
/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $product_price_in_cents
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Order\Order|null $order
 * @property-read \Modules\Product\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine whereProductPriceInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderLine whereUpdatedAt($value)
 */
	class OrderLine extends \Eloquent {}
}

namespace Modules\Payment\Models{
/**
 * @property int $id
 * @property string $payment_id
 * @property \Modules\Payment\PaymentProvider $payment_gateway
 * @property string $status
 * @property numeric $total_in_cents
 * @property int $user_id
 * @property int $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereTotalInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUserId($value)
 */
	class Payment extends \Eloquent {}
}

namespace Modules\Product\Models{
/**
 * @property int $id
 * @property string $name
 * @property numeric $price_in_cents
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\Product\Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePriceInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

