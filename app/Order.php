<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property int $id
 * @property string $user_email
 * @property string $user_name
 * @property string $user_phone
 * @property string $payment_type
 * @property string $delivery_type
 * @property string|null $order_comments
 * @property int $amount
 * @property int $confirmed
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeliveryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereOrderComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserPhone($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderProduct[] $orderProducts
 * @property-read \App\Payment $payment
 * @property int|null $user_id
 * @property int $is_raffle
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereIsRaffle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @property-read int|null $order_products_count
 * @property string|null $user_address
 * @property int $is_entity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereIsEntity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserAddress($value)
 * @property-read \App\OrderEntity $orderEntity
 */
class Order extends Model
{
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orderEntity()
    {
        return $this->hasOne(OrderEntity::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function raffleUser()
    {
        return ($this->is_raffle) ? $this->hasOne(RaffleUser::class) : null;
    }
}
