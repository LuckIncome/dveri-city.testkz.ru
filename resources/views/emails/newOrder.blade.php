<!DOCTYPE HTML>
<html>
<head>
    <title>Новый заказ с сайта</title>
</head>
<body>
<h1>Новый заказ # {{$order->id}} от {{$order->user_name}}</h1>
<br>
<p style="font-weight: 600; font-size: 18px">Личные данные клиента :</p>
<p>Покупатель : {{$order->is_entity ? 'Юридическое лицо' : 'Физическое лицо'}}</p>
@if($order->is_entity)
    <p>Название Компании : {{$order->orderEntity->name}}</p>
    <p>БИН : {{$order->orderEntity->bin}}</p>
    <p>БИК : {{$order->orderEntity->bik}}</p>
    <p>ИИК : {{$order->orderEntity->iik}}</p>
    <p>Юр.Адрес : {{$order->orderEntity->address}}</p>
@endif
<p>ФИО : {{$order->user_name}}</p>
<p>Телефон : {{$order->user_phone}}</p>
<p>Email : {{$order->user_email}}</p>
<p>Адрес доставки : {{$order->user_address}}</p>
<p>Сумма заказа : {{number_format($order->amount,0,","," ")}} тг</p>
<p>Статус оплаты заказа : <span
            style="font-weight: 600;text-transform: uppercase">{{($payment->type == 'cash') ? 'Оплата при доставке' : (($payment->type == 'card') ? 'Картой при получении' : 'Online оплата')}}</span>
</p>
<table style="margin-bottom: 20px;width: 80%">
    @foreach($products as $product)
        <tr>
            <td style="border: 1px solid #ccc;width: 110px">
                <img style="width: 100px"
                     src="{{ Voyager::image($product->getThumbnail($product->thumb,'small'))}}"
                     class=""/>
            </td>
            <td style="border: 1px solid #ccc">
                <p style="font-weight: 600;">{{ $product->name }}</p>
                <p>{{ $product->brand}}</p>
                @foreach($product->options as $option)
                    <p>{{ $option->option}}: {{$option->value}}</p>
                @endforeach
            </td>
            <td style="border: 1px solid #ccc">
                <div>
                    <p style="font-weight: 600;">{{ $product->qty }} шт</p>
                </div>
            <td style="border: 1px solid #ccc">
                <p style="font-weight: 600;">{{number_format($product->product_price,0,","," ")}} тг</p>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>