<!DOCTYPE HTML>
<html>
<head>
    <title>Новый заказ с сайта</title>
</head>
<body>
<h1>Новый заказ # <?php echo e($order->id); ?> от <?php echo e($order->user_name); ?></h1>
<br>
<p style="font-weight: 600; font-size: 18px">Личные данные клиента :</p>
<p>Покупатель : <?php echo e($order->is_entity ? 'Юридическое лицо' : 'Физическое лицо'); ?></p>
<?php if($order->is_entity): ?>
    <p>Название Компании : <?php echo e($order->orderEntity->name); ?></p>
    <p>БИН : <?php echo e($order->orderEntity->bin); ?></p>
    <p>БИК : <?php echo e($order->orderEntity->bik); ?></p>
    <p>ИИК : <?php echo e($order->orderEntity->iik); ?></p>
    <p>Юр.Адрес : <?php echo e($order->orderEntity->address); ?></p>
<?php endif; ?>
<p>ФИО : <?php echo e($order->user_name); ?></p>
<p>Телефон : <?php echo e($order->user_phone); ?></p>
<p>Email : <?php echo e($order->user_email); ?></p>
<p>Адрес доставки : <?php echo e($order->user_address); ?></p>
<p>Сумма заказа : <?php echo e(number_format($order->amount,0,","," ")); ?> тг</p>
<p>Статус оплаты заказа : <span
            style="font-weight: 600;text-transform: uppercase"><?php echo e(($payment->type == 'cash') ? 'Оплата при доставке' : (($payment->type == 'card') ? 'Картой при получении' : 'Online оплата')); ?></span>
</p>
<table style="margin-bottom: 20px;width: 80%">
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td style="border: 1px solid #ccc;width: 110px">
                <img style="width: 100px"
                     src="<?php echo e(Voyager::image($product->getThumbnail($product->thumb,'small'))); ?>"
                     class=""/>
            </td>
            <td style="border: 1px solid #ccc">
                <p style="font-weight: 600;"><?php echo e($product->name); ?></p>
                <p><?php echo e($product->brand); ?></p>
                <?php $__currentLoopData = $product->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($option->option); ?>: <?php echo e($option->value); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
            <td style="border: 1px solid #ccc">
                <div>
                    <p style="font-weight: 600;"><?php echo e($product->qty); ?> шт</p>
                </div>
            <td style="border: 1px solid #ccc">
                <p style="font-weight: 600;"><?php echo e(number_format($product->product_price,0,","," ")); ?> тг</p>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
</body>
</html><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/emails/newOrder.blade.php ENDPATH**/ ?>