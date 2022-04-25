<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Exportable;

/**
 * App\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $product_count
 * @property int $product_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereProductCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct query()
 */
class OrderProduct extends Model
{
    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
