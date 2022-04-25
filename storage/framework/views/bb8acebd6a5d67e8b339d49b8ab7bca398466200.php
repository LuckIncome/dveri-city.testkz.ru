<?php $__env->startSection('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height: 100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }

        b, strong {
            font-weight: 600;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i>
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="<?php if(isset($dataTypeContent->id)): ?><?php echo e(route('orders.update', $dataTypeContent->id)); ?><?php else: ?><?php echo e(route('voyager.orders.store')); ?><?php endif; ?>"
              method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            <?php if(isset($dataTypeContent->id)): ?>
                <?php echo e(method_field("PUT")); ?>

            <?php endif; ?>
            <?php echo e(csrf_field()); ?>


            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <?php if(count($errors) > 0): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-dollar"></i> Заказ № <?php echo e($dataTypeContent->id); ?>

                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                    </div>


                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Товары : </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php $__currentLoopData = $dataTypeContent->orderProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="product"
                                     style="width: 100%;float: left;border-top:1px solid #ccc;padding-top: 10px;margin-bottom: 10px">
                                    <div class="product-info" style="width: 40%;float: left;">
                                        <img style="width: 25%;float: left;max-height: 80px;object-fit:scale-down"
                                             src="<?php echo e(Voyager::image($orderProduct->product->thumb)); ?>"
                                             alt="<?php echo e($orderProduct->product->name); ?>">
                                        <div class="info"
                                             style="width: 40%;float: left;margin-left: 10px;">
                                            <a href="/admin/products/<?php echo e($orderProduct->product->id); ?>">
                                                <p class="name"><?php echo e($orderProduct->product->name); ?></p>
                                            </a>
                                            <?php $__currentLoopData = $orderProduct->product->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="attribute">
                                                    <strong><?php echo e($option->option); ?></strong>
                                                    <span><?php echo e($option->value); ?></span>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="quantity" style="width: 30%;float: left;margin-top: 20px">
                                        <p class="countText">Кол-во: <b><?php echo e($orderProduct->product_count); ?></b></p>
                                    </div>
                                    <div class="product-price" style="width: 30%;float: left;margin-top: 20px">
                                        <p class="cost">
                                <span class="sale-price price">Цена:   <b><?php echo e($orderProduct->product_price); ?></b> <span
                                            class="currency">₸</span></span>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-group" style="width: 20%;float: right;">
                                <strong>Общая Сумма: </strong>
                                <p><?php echo e(number_format($dataTypeContent->amount,0,'',' ')); ?> тг</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Комментарии к заказу : </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <p><?php echo e($dataTypeContent->order_comments); ?></p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <!-- ### INFO DATA ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Информация о заказе</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <strong>Сумма заказа</strong>
                                <p><?php echo e(number_format($dataTypeContent->amount,0,'',' ')); ?> тг</p>
                            </div>
                            <div class="form-group">
                                <strong>Способ оплаты</strong>
                                <?php if($dataTypeContent->payment_type == 'cash'): ?>
                                    <p>Наличными при получении</p>
                                <?php elseif($dataTypeContent->payment_type == 'card'): ?>
                                    <p>Картой при получении</p>
                                <?php else: ?>
                                    <p>Онлайн оплата (Оплачено)</p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <strong>Способ доставки</strong>
                                <p><?php echo e(($dataTypeContent->delivery_type == 'self') ? 'Самовывоз': 'Доставка'); ?></p>
                            </div>
                            <div class="form-group">
                                <label style="width: 100%;">
                                    <span class="panel-desc">Статус</span>
                                    <select name="status" class="form-control">
                                        <option <?php if($dataTypeContent->status == 0): ?> selected <?php endif; ?> value="0">Новый
                                            заказ
                                        </option>
                                        <option <?php if($dataTypeContent->status == 1): ?> selected <?php endif; ?> value="1">
                                            Выполняется
                                        </option>
                                        <option <?php if($dataTypeContent->status == 2): ?> selected <?php endif; ?> value="2">Выполнен
                                        </option>
                                        <option <?php if($dataTypeContent->status == 3): ?> selected <?php endif; ?> value="3">Отменен
                                        </option>
                                        <option <?php if($dataTypeContent->status == 4): ?> selected <?php endif; ?> value="4">Возврат
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- ### CLIENT DATA ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">Данные клиента :
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <strong>Покупатель :</strong>
                                <p><?php echo e($dataTypeContent->is_entity ? 'Юридическое лицо' : 'Физическое лицо'); ?></p>
                            </div>
                            <?php if($dataTypeContent->is_entity): ?>
                                <div class="form-group">
                                    <strong>Название Компании :</strong>
                                    <p><?php echo e($dataTypeContent->orderEntity->name); ?></p>
                                </div>
                                <div class="form-group">
                                    <strong>БИН :</strong>
                                    <p><?php echo e($dataTypeContent->orderEntity->bin); ?></p>
                                </div>
                                <div class="form-group">
                                    <strong>БИК :</strong>
                                    <p><?php echo e($dataTypeContent->orderEntity->bik); ?></p>
                                </div>
                                <div class="form-group">
                                    <strong>ИИК :</strong>
                                    <p><?php echo e($dataTypeContent->orderEntity->iik); ?></p>
                                </div>
                                <div class="form-group">
                                    <strong>Юр.Адрес :</strong>
                                    <p><?php echo e($dataTypeContent->orderEntity->address); ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <strong>Эл. почта :</strong>
                                <p><?php echo e($dataTypeContent->user_email); ?></p>
                            </div>
                            <div class="form-group">
                                <strong>Имя получателя :</strong>
                                <p><?php echo e($dataTypeContent->user_name); ?></p>
                            </div>
                            <div class="form-group">
                                <strong>Мобильный телефон:</strong>
                                <p><?php echo e($dataTypeContent->user_phone); ?></p>
                            </div>
                            <div class="form-group">
                                <strong>Адрес:</strong>
                                <p><?php echo e($dataTypeContent->user_address); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                <?php if(isset($dataTypeContent->id)): ?>Обновить <?php else: ?> <i
                        class="icon wb-plus-circle"></i> Новый заказ <?php endif; ?>
            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

            <?php if($isModelTranslatable): ?>
            $('.side-body').multilingual({"editing": true});
            <?php endif; ?>
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/vendor/voyager/orders/edit-add.blade.php ENDPATH**/ ?>