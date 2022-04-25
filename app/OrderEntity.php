<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrderEntity
 *
 * @property int $id
 * @property int $order_id
 * @property string $name
 * @property string $bin
 * @property string $bik
 * @property string $iik
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereBik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereBin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereIik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderEntity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderEntity extends Model
{
    //
}
