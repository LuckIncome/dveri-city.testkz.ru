<?php $__env->startSection('seo_title','Оформление заказа'); ?><?php $__env->startSection('meta_keywords','Оформление заказа'); ?><?php $__env->startSection('meta_description','Оформление заказа'); ?><?php $__env->startSection('content'); ?>
    <div class="checkout-page def-page" data-ng-controller="CartController as cart">
        <div class="pre-header" data-ng-init="cart.initCart()">
            <div class="container"><h1>Оформление заказа</h1></div>
        </div>
        <div class="container" data-ng-init="cc.init()">
            <div class="row">
                <div class="content col-12">
                    <form action="<?php echo e(route('cart.checkout.submit')); ?>" method="POST"><?php echo e(csrf_field()); ?>

                        <div class="checkout-content">
                            <div class="checkout-block row">
                                <div class="checkout-data col-6">
                                    <div class="contact details">
                                        <div class="header-info"><strong>Контактные данные</strong> <span>Поля, отмеченные *, обязательны для заполнения</span>
                                        </div>
                                        <div class="custom-control custom-checkbox"><input type="checkbox"
                                                                                           class="custom-control-input"
                                                                                           data-ng-checked="isEntity"
                                                                                           data-ng-model="isEntity"
                                                                                           id="customCheck"
                                                                                           name="is-entity"
                                                                                           data-ng-change="cart.changeEntity()">
                                            <label class="custom-control-label" for="customCheck">Я представитель
                                                юридического лица</label></div>
                                        <div class="input-block" data-ng-if="isEntity"><label for="company-name">Название
                                                компании *</label> <input id="company-name" type="text"
                                                                          name="companyName" class="form-control"
                                                                          required></div>
                                        <div class="input-block" data-ng-if="isEntity"><label for="company-bin">БИН
                                                *</label> <input id="company-bin" type="text" name="companyBin"
                                                                 class="form-control" required></div>
                                        <div class="input-block" data-ng-if="isEntity"><label for="company-bik">БИК
                                                *</label> <input id="company-bik" type="text" name="companyBik"
                                                                 class="form-control" required></div>
                                        <div class="input-block" data-ng-if="isEntity"><label for="company-iik">ИИК
                                                (KZT) *</label> <input id="company-ikk" type="text" name="companyIik"
                                                                       class="form-control" required></div>
                                        <div class="input-block"><label for="checkout-name">Имя *</label> <input
                                                    id="checkout-name" type="text" name="name" class="form-control"
                                                    required></div>
                                        <div class="input-block"><label for="checkout-phone">Телефон *</label> <input
                                                    id="checkout-phone" type="tel" name="phone" class="form-control"
                                                    required></div>
                                        <div class="input-block"><label for="checkout-email">E-mail *</label> <input
                                                    id="checkout-email" type="email" name="email" class="form-control"
                                                    required></div>
                                    </div>
                                    <div class="delivery details">
                                        <div class="header-info"><strong>Доставка</strong> <br>
                                       <p></p> <span>* Доставка курьером осущетвляется при 100% оплате заказа или online-оплате</span></p></div>
                                        <div class="input-block top-0"><strong>Способ доставки</strong>
                                            <div class="delivery-radios">
                                                <div class="custom-control custom-radio"><input type="radio"
                                                                                                class="custom-control-input"
                                                                                                id="deliveryCourier"
                                                                                                name="delivery"
                                                                                                value="courier" checked>
                                                    <label class="custom-control-label"
                                                           for="deliveryCourier">Курьер</label></div>
                                                <div class="custom-control custom-radio"><input type="radio"
                                                                                                class="custom-control-input"
                                                                                                id="selfDelivery"
                                                                                                name="delivery"
                                                                                                value="self"> <label
                                                            class="custom-control-label" for="selfDelivery">Самовывоз с
                                                        магазина</label></div>
                                            </div>
                                        </div>
                                        <div class="input-block" data-ng-if="!isEntity"><label for="checkout-address">Ваш
                                                адрес</label> <input id="checkout-address" type="text" name="address"
                                                                     class="form-control"></div>
                                        <div class="input-block" data-ng-if="isEntity"><label for="company-address">Юридический
                                                адрес *</label> <input id="company-address" type="text"
                                                                       name="companyAddress" class="form-control"
                                                                       required></div>
                                        <div class="input-block align-top"><label for="checkout-comments">Комментарий к
                                                заказу</label> <textarea class="form-control" id="checkout-comments"
                                                                         rows="3" name="comments"></textarea></div>
                                    </div>
                                    <div class="payment details">
                                        <div class="header-info"><strong>Сумма к оплате</strong></div>
                                        <div class="input-block top-0"><strong>Сумма заказа</strong>
                                            <div class="payment-total"><span>Цена:</span>
                                                <p>{{cart.total}}<span class="valute">₸</span></p></div>
                                        </div>
                                        <div class="input-block align-top"><strong>Способ оплаты</strong>
                                            <div class="payment-radios">
                                                <div class="custom-control custom-radio"><input type="radio"
                                                                                                class="custom-control-input"
                                                                                                id="paymentCash"
                                                                                                name="payment"
                                                                                                value="cash" checked>
                                                    <label class="custom-control-label" for="paymentCash">Наличными</label></div>
                                                <div class="custom-control custom-radio"><input type="radio"
                                                                                                class="custom-control-input"
                                                                                                id="paymentCard"
                                                                                                name="payment"
                                                                                                value="card"> <label
                                                            class="custom-control-label" for="paymentCard">Платёжной
                                                        картой</label></div>
                                                <div class="custom-control custom-radio"><input type="radio"
                                                                                                class="custom-control-input"
                                                                                                id="paymentOnline"
                                                                                                name="payment"
                                                                                                value="online"> <label
                                                            class="custom-control-label" for="paymentOnline">Online-оплата</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="total col-5 offset-1">
                                    <div class="cart-items">
                                        <div class="item" data-ng-repeat="product in cart.products">
                                            <div class="image col-3"><img
                                                        data-ng-src="{{product.attributes.image_link}}" src="#"
                                                        alt="{{product.attributes.name}}"></div>
                                            <div class="name col-4"><strong>{{product.attributes.name}}</strong></div>
                                            <div class="price col-3"><span>Цена:</span>
                                                <p class="old-price"
                                                   data-ng-if="product.attributes.regular_price">{{product.attributes.regular_price}}
                                                    <span class="valute">₸</span></p>
                                                <p class="new-price">{{product.price}}<span class="valute">₸</span></p>
                                            </div>
                                            <div class="count col-2"><p>{{product.quantity}}шт *</p></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-bottom">
                            <div class="row">
                                <div class="back col-2"><a href="<?php echo e(route('cart.index')); ?>">Вернуться</a></div>
                                <div class="steps col-5 offset-3">
                                    <ul>
                                        <li>Корзина</li>
                                        <li class="arrow"><span class="fa fa-angle-right"></span></li>
                                        <li class="active">Оформление заказа</li>
                                        <li class="arrow"><span class="fa fa-angle-right"></span></li>
                                        <li>Завершение</li>
                                    </ul>
                                </div>
                                <div class="next col-2">
                                    <button type="submit" class="submit-btn">Оформить заказ</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/cart/checkout.blade.php ENDPATH**/ ?>