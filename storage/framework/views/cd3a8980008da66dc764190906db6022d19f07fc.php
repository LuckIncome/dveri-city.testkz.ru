<?php $__env->startSection('seo_title','Корзина'); ?><?php $__env->startSection('meta_keywords','Корзина'); ?><?php $__env->startSection('meta_description','Корзина'); ?><?php $__env->startSection('content'); ?>
    <div class="cart-page def-page" data-ng-controller="CartController as cart">
        <div class="pre-header">
            <div class="container"><h1>Корзина</h1></div>
        </div>
        <div class="container" data-ng-init="cart.initCart()">
            <div class="row">
                <div class="content col-12">
                    <div class="cart-content"><a class="clear-cart" data-ng-click="cart.clearCart()"
                                                 data-ng-if="cart.cartItemsCount > 0">Очистить список</a>
                        <div class="cart-items">
                            <div class="item" data-ng-repeat="product in cart.products">
                                <div class="image col-2"><img data-ng-src="{{product.attributes.image_link}}" src="#"
                                                              alt="{{product.attributes.name}}"></div>
                                <div class="info col-3"><a data-ng-href="{{product.attributes.link}}"
                                                           class="name">{{product.attributes.name}}</a>
                                    <p class="desc">Одна из самых популярных дверей у наших клиентов, она сочетает в
                                        себе все достоинства современных входных дверей.</p>
                                    <div class="attrs-mob"><p data-ng-repeat="option in product.attributes.options">
                                            <span>{{option.option}}:</span> {{option.value}}</p></div>
                                    <div class="price-mob"><span>Цена:</span>
                                        <p class="old-price"
                                           data-ng-if="product.attributes.regular_price">{{product.attributes.regular_price}}
                                            <span class="valute">₸</span></p>
                                        <p class="new-price">{{product.price}}<span class="valute">₸</span></p></div>
                                </div>
                                <div class="attributes col-2">
                                    <div class="attribute" data-ng-repeat="option in product.attributes.options"
                                         data-ng-class="option.option.toLowerCase()=='цвет' ? 'color' : ''">
                                        <strong>{{option.option}}:</strong>
                                        <div class="variants"><span data-ng-if="option.option.toLowerCase()=='цвет'"
                                                                    data-ng-style="{background: option.option.toLowerCase()=='цвет' ? '#'+option.value_color : 'none'}"></span>
                                            <span data-ng-if="option.option.toLowerCase() !='цвет'">{{option.value}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="price col-2"><span>Цена:</span>
                                    <p class="old-price"
                                       data-ng-if="product.attributes.regular_price">{{product.attributes.regular_price}}
                                        <span class="valute">₸</span></p>
                                    <p class="new-price">{{product.price}}<span class="valute">₸</span></p></div>
                                <div class="count col-2">
                                    <div class="counter"><span class="minus"
                                                               data-ng-click="cart.removeQuantity(product)">—</span>
                                        <input type="number" min="0" data-ng-value="{{product.quantity}}"
                                               data-ng-model="product.quantity"> <span class="plus"
                                                                                       data-ng-click="cart.addQuantity(product)">+</span>
                                    </div>
                                </div>
                                <div class="remove col-1"><a data-ng-click="cart.deleteItem(product)">Удалить</a></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="cart-bottom">
                                <div class="back col-2"><a href="<?php echo e(route('products.index')); ?>">Вернуться</a></div>
                                <div class="total col-3"><span>Общая сумма заказа:</span>
                                    <p>{{cart.subtotal}}<span class="valute">₸</span></p></div>
                                <div class="steps col-5">
                                    <ul>
                                        <li class="active">Корзина</li>
                                        <li class="arrow"><span class="fa fa-angle-right"></span></li>
                                        <li>Оформление заказа</li>
                                        <li class="arrow"><span class="fa fa-angle-right"></span></li>
                                        <li>Завершение</li>
                                    </ul>
                                </div>
                                <div class="next col-2" data-ng-if="cart.cartItemsCount > 0"><a
                                            href="<?php echo e(route('cart.checkout')); ?>">Далее</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/cart/index.blade.php ENDPATH**/ ?>