<?php

namespace App\Exports;

use App\Order;
use App\OrderProduct;
use App\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings ,WithMapping
{
    use Exportable;

    public function __construct(string $from,string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }


    /**
     * @var OrderProduct $verified
     * @return  array
     */

    public function map($verified): array
    {
        return [
            $verified->order_id,
            $verified->stext,
            $verified->payment_type,
            $verified->delivery_type,
            $verified->product->name,
            $verified->options,
            $verified->product_count,
            $verified->product_price,
            $verified->is_entity,
            $verified->order->user_name,
            $verified->order->user_phone,
            $verified->order->user_email,
            $verified->order->user_address,
            Carbon::parse($verified->created_at)->format('d.m.Y H:i')
        ];
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#Заказа',
            'Статус заказа',
            'Форма оплаты',
            'Способ доставки',
            'Наименование товара',
            'Опции товара',
            'Количество(шт)',
            'Цена Товара (тг)',
            'Клиент',
            'Имя',
            'Телефон',
            'Email',
            'Адрес заказа',
            'Дата создания заказа'
        ];
    }

    public function collection()
    {
        $fromDate = Carbon::parse($this->from)->startOfDay();
        $toDate = Carbon::parse($this->to)->endOfDay();
        $orderedProducts = OrderProduct::whereBetween('created_at', [$fromDate, $toDate])->get();

        foreach ($orderedProducts as $orderedProduct) {
            $order = Order::find($orderedProduct->order_id);
            if ($order->confirmed) {
                switch ($order->status) {
                    case 0:
                        $stext = 'Новый заказ';
                        break;
                    case 1:
                        $stext = 'Выполняется';
                        break;
                    case 2:
                        $stext = 'Выполнен';
                        break;
                    case 3:
                        $stext = 'Отменен';
                        break;
                    case 4:
                        $stext = 'Возврат';
                        break;
                    default:
                        $stext = 'Не определен';
                }
                $orderedProduct->setAttribute('stext', $stext);
                $orderedProduct->setAttribute('verified', true);
                $orderedProduct->setAttribute('payment_type', ($order->payment_type == 'cash') ? 'Наличный расчет' : ($order->payment_type == 'card') ? 'Картой при получении' : 'Онлайн оплата картой');
                $orderedProduct->setAttribute('delivery_type', ($order->delivery_type == 'self') ? 'Самовывоз' : 'Курьер');
                $orderedProduct->setAttribute('is_entity', ($order->is_entity) ? 'Юридическое лицо' : 'Физическое лицо');
                $product = Product::find($orderedProduct->product_id);
                $orderedProduct->setAttribute('product', $product);
                $orderedProduct->setAttribute('order', $order);
                $orderedProduct->setAttribute('options', implode('; ', array_map(
                    function ($v, $k) {
                        return sprintf("%s:%s", $k, $v);
                    },
                    $orderedProduct->product->options->pluck('value', 'option')->toArray(),
                    array_keys($orderedProduct->product->options->pluck('value', 'option')->toArray())
                )));
            }
        }
        $verifieds = $orderedProducts->where('verified', true);

        return $verifieds;
    }
}
