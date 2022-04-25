<header data-ng-controller="HeaderController as hc">
    <div class="menu">
        <div class="container main">
            <div class="align-content-between row">
                <div class="col-6">
                    <nav class="navbar-expand-md navbar-light">
                        <div class="collapse navbar-collapse"
                             id="navbarNavDropdown"><?php echo e(menu('frontend','bootstrap')); ?></div>
                    </nav>
                </div>
                <div class="col-6 row">
                    <div class="phones-header col-7"><a
                                href="tel:<?php echo e(str_replace(' ','',setting('site.phone-1'))); ?>"><span><?php echo e(explode(' ',setting('site.phone-1'))[0]); ?><?php echo e(explode(' ',setting('site.phone-1'))[1]); ?></span><?php echo e(explode(' ',setting('site.phone-1'))[2]); ?>

                        </a>
                        <a href="tel:<?php echo e(str_replace(' ','',setting('site.phone-2'))); ?>"><span><?php echo e(explode(' ',setting('site.phone-2'))[0]); ?><?php echo e(explode(' ',setting('site.phone-2'))[1]); ?></span><?php echo e(explode(' ',setting('site.phone-2'))[2]); ?>

                        </a></div>
                    <div class="callback-header col-5"><a class="callback-btn">Заказать звонок</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-block" data-ng-init="hc.init()">
        <div class="container">
            <div class="d-flex"><a class="hamb" onclick="openNav()"></a>
                <div id="mobMenuNav" class="sidenav"><span class="close-menu" onclick="closeNav()"> <svg width="25"
                                                                                                         height="18"
                                                                                                         viewBox="0 0 17 16"
                                                                                                         fill="none"
                                                                                                         xmlns="https://www.w3.org/2000/svg"><path
                                    d="M1 1L16.5 16.5" stroke="#989898"/><path d="M16.5 1L1 16.5"
                                                                               stroke="#989898"/> </svg></span>
                    <div class="search">
                        <form id="searchHeaderMobile" data-ng-controller="SearchController as sc"><input type="text"
                                                                                                         name="search"
                                                                                                         class="searchBox"
                                                                                                         data-ng-model="searchInput"
                                                                                                         autocomplete="off">
                            <button type="submit" class="submit-btn" data-ng-click="sc.searchByInput(searchInput)">
                                Найти
                            </button>
                            <div class="items"><a data-ng-repeat="item in sc.searchItems track by $index" class="item"
                                                  data-ng-href="{{item.full_link}}">{{item.item}}:
                                    <span>{{item.name}}</span> </a>
                                <p data-ng-if="sc.searchItems.length < 1">По вашему запросу ничего не найдено.</p></div>
                        </form>
                    </div><?php echo e(menu('frontend')); ?>

                    <div class="cls-block">
                        <div class="social"><a rel="nofollow" href="<?php echo e(setting('site.insta-link')); ?>" target="_blank"><img
                                        src="/images/instagram.svg" alt="Instagram Dveri City"></a></div>
                       <!--<div class="langs">
                            <ul>
                                <?php $__currentLoopData = config()->get('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(app()->getLocale()==$lang): ?>
                                        <li><?php echo e($lang=='ru' ? 'Рус' : 'Каз'); ?></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo e(route('locale.set', $lang)); ?>"><?php echo e($lang=='ru' ? 'Рус' : 'Каз'); ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>-->
                    </div>
                </div>
                <div class="logo align-content-start"><a href="/">
                        <picture>
                            <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image(setting('site.logo')))['extension'],'webp',Voyager::image(setting('site.logo')))); ?>"
                                    type="image/webp">
                            <source srcset="<?php echo e(Voyager::image(setting('site.logo'))); ?>" type="image/jpeg">
                            <img src="<?php echo e(Voyager::image(setting('site.logo'))); ?>" alt="logo dveri city">
                        </picture>
                    </a>
                    <p class="logo-text"><?php echo e(setting('site.description')); ?></p></div>
                <div class="search">
                    <form id="searchHeader" data-ng-controller="SearchController as sc"><input type="text" name="search"
                                                                                               class="searchBox"
                                                                                               data-ng-model="searchInput"
                                                                                               autocomplete="off">
                        <button type="submit" class="submit-btn" data-ng-click="sc.searchByInput(searchInput)">Найти
                        </button>
                        <div class="items"><a data-ng-repeat="item in sc.searchItems track by $index" class="item"
                                              data-ng-href="{{item.full_link}}">{{item.item}}:
                                <span>{{item.name}}</span> </a>
                            <p data-ng-if="sc.searchItems.length < 1">По вашему запросу ничего не найдено.</p></div>
                    </form>
                </div>
                <div class="cls-block">
                    <div class="social"><a rel="nofollow" href="<?php echo e(setting('site.insta-link')); ?>" target="_blank"><img
                                    src="/images/instagram.svg" alt="Instagram Dveri City"></a></div>
                   <!-- <div class="langs">
                        <ul> <?php $__currentLoopData = config()->get('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if(app()->getLocale()==$lang): ?>
                                <li><?php echo e($lang=='ru' ? 'Рус' : 'Каз'); ?></li><?php else: ?>
                                <li><a href="<?php echo e(route('locale.set', $lang)); ?>"><?php echo e($lang=='ru' ? 'Рус' : 'Каз'); ?></a>
                                </li><?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </ul>
                    </div>-->
                    <div class="cart-btns">
                        <div class="compare-header"><a href="<?php echo e(route('compare.index')); ?>" class="compare"> <span
                                        data-ng-class="hc.compareItems > 0 ? 'hasItems' : '' ">{{hc.compareItems}}</span>
                            </a></div>
                        <div class="cart-header" data-ng-controller="CartController as cart"><a class="cart"
                                                                                                data-ng-init="cart.getCartContent()">
                                <span data-ng-class="hc.cartItems > 0 ? 'hasItems' : '' ">{{hc.cartItems}}</span> </a>
                            <div class="mini-cart">
                                <div class="content">
                                    <div class="item" data-ng-repeat="product in cart.products">
                                        <div class="image"><img data-ng-src="{{product.attributes.image_link}}" src="#"
                                                                alt="{{product.attributes.name}}"></div>
                                        <div class="info">
                                            <div class="name"><a
                                                        data-ng-href="{{product.attributes.link}}"><strong>{{product.attributes.name}}</strong></a>
                                                <p>Одна из самых популярных дверей у наших клиентов</p></div>
                                            <div class="price"><span>Цена:</span>
                                                <p data-ng-if="product.attributes.regular_price"
                                                   class="old-price">{{product.attributes.regular_price}}<span
                                                            class="valute">₸</span></p>
                                                <p class="new-price">{{product.price}}<span class="valute">₸</span></p>
                                            </div>
                                        </div>
                                        <div class="remove"><a data-ng-click="cart.deleteItem(product)"></a></div>
                                    </div>
                                </div>
                                <div class="checkout">
                                    <div class="total"><span>Итого:</span>
                                        <p>{{cart.subtotal}}<span class="valute">₸</span></p></div>
                                    <div class="button"><a href="<?php echo e(route('cart.index')); ?>">Перейти в корзину</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/partials/header.blade.php ENDPATH**/ ?>