<?php $__env->startSection('meta_description',$category->meta_description); ?><?php $__env->startSection('seo_title',$category->seo_title); ?><?php $__env->startSection('meta_keywords',$category->meta_keywords); ?><?php $__env->startSection('content'); ?>
    <div class="catalog-page def-page" data-ng-controller="CatalogController as cat">
        <div class="pre-header">
            <div class="container"> <?php echo $__env->make('partials.breadcrumbs',['title'=> 'Каталог'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <h1>Каталог товаров</h1>
            </div>
        </div>
        <div class="container" data-ng-init="cat.initFunctions('<?php echo e($category->slug); ?>')">
            <div class="row">
                <div class="sidebar col-3">
                    <div class="filter"><p class="title main">Фильтр</p>
                        <div class="category-select"> <?php if($category->slug !=='aksessuary'): ?> <select name="category"
                                                                                                   onchange="cat.refreshCategory(this.value)"> <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="/catalog/<?php echo e($cat->slug); ?>"
                                            <?php if($category->id==$cat->id): ?> selected <?php endif; ?>><?php echo e($cat->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select> <?php endif; ?> </div>
                        <div class="type price-range"><p class="title">Цена (тг)</p><a class="collapseBtn"
                                                                                       data-toggle="collapse"
                                                                                       href="#collapsePriceRange"
                                                                                       role="button"
                                                                                       aria-expanded="true"
                                                                                       aria-controls="collapsePriceRange">
                                <i class="fa fa-chevron-down"></i> </a>
                            <div class="collapse show" id="collapsePriceRange">
                                <div class="inputs">
                                    <div class="price-min"><input type="text" data-ng-model="cat.filters.price.min"/>
                                        <span>тг</span></div>
                                    <span>—</span>
                                    <div class="price-max"><input type="text" data-ng-model="cat.filters.price.max"/>
                                        <span>тг</span></div>
                                </div>
                                <div data-rzslider data-rz-slider-model="cat.filters.price.min"
                                     data-rz-slider-high="cat.filters.price.max"
                                     data-rz-slider-options="cat.filters.price.options"></div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-block" data-ng-repeat="(categoryKey, category) in cat.filters"
                         data-ng-if="categoryKey !='price'" data-ng-init="cat.filter[category]={}">
                        <hr class="row">
                        <div class="filter">
                            <div class="type color"><p class="title"
                                                       data-ng-if="categoryKey !='brand'">{{categoryKey}}</p>
                                <p class="title" data-ng-if="categoryKey=='brand'">Бренд</p><a class="collapseBtn"
                                                                                               data-toggle="collapse"
                                                                                               data-ng-href="#collapse-{{$index}}"
                                                                                               role="button"
                                                                                               aria-expanded="true"
                                                                                               aria-controls="collapse-{{$index}}">
                                    <i class="fa fa-chevron-down"></i> </a>
                                <div class="collapse show" id="collapse-{{$index}}">
                                    <div class="checkboxes">
                                        <div class="box custom-control custom-checkbox"
                                             data-ng-repeat="(key, value) in category | filtersLimitTo: category.filtersLimit"
                                             data-ng-if="key !='filtersLimit'"><label> <input type="checkbox"
                                                                                              class="custom-control-input"
                                                                                              name="example1"
                                                                                              data-ng-model="cat.filters[categoryKey][key]">
                                                <span class="custom-control-label">{{key}}</span></label> <span
                                                    class="count">{{(cat.filtered_products | filter:key:true).length}}</span>
                                        </div>
                                        <a class="more" data-ng-show="cat.showMoreFilter(category)"
                                           data-ng-click="category.filtersLimit=category.length">Показать больше <i
                                                    class="fa fa-chevron-down"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div></div>
                <div class="content col-9">
                    <div class="sorting">
                        <div class="sort"><p>Сортировка</p><select class="sort-type" data-ng-model="cat.orderExpression"
                                                                   data-ng-change="cat.changeOrderExpression(cat.orderExpression)">
                                <option value="is_new" data-ng-selected="cat.orderExpression=='is_new'">Сначала
                                    новинки
                                </option>
                                <option value="featured" data-ng-selected="cat.orderExpression=='featured'">По
                                    популярности
                                </option>
                                <option value="price" data-ng-selected="cat.orderExpression=='price'">Сначала дешевые
                                </option>
                                <option value="-price" data-ng-selected="cat.orderExpression=='-price'">Сначала
                                    дорогие
                                </option>
                            </select></div>
                        <div class="limit"><p>Товаров на странице</p>
                            <ul>
                                <li data-ng-class="{'active' : cat.pageSize==12}"><a
                                            data-ng-click="cat.changePageSize(12)">12</a></li>
                                <li data-ng-class="{'active' : cat.pageSize==24}"><a
                                            data-ng-click="cat.changePageSize(24)">24</a></li>
                                <li data-ng-class="{'active' : cat.pageSize==48}"><a
                                            data-ng-click="cat.changePageSize(48)">48</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-sort-mob"><select class="sort-type" data-ng-model="cat.orderExpression"
                                                         data-ng-change="cat.changeOrderExpression(cat.orderExpression)">
                            <option value="is_new" data-ng-selected="cat.orderExpression=='is_new'">Сначала новинки
                            </option>
                            <option value="featured" data-ng-selected="cat.orderExpression=='featured'">По
                                популярности
                            </option>
                            <option value="price" data-ng-selected="cat.orderExpression=='price'">Сначала дешевые
                            </option>
                            <option value="-price" data-ng-selected="cat.orderExpression=='-price'">Сначала дорогие
                            </option>
                        </select> <a class="filter-btn" data-ng-click="cat.refreshSlider()">Фильтр</a></div>
                    <div class="loader" data-ng-if="cat.loading"></div>
                    <div class="products" data-ng-if="cat.products.length">
                        <div class="col-3"
                             data-ng-repeat="product in cat.filtered_products=(cat.products | filter:cat.updateFilters) | orderBy:cat.orderExpression | limitTo:cat.pageSize:(cat.currentPage - 1) * cat.pageSize track by product.id">
                            <div class="item">
                                <div class="image"><span data-ng-if="product.is_new"
                                                         data-ng-class="product.is_new ? 'new flash' : 'flash'">Новинка</span>
                                    <span data-ng-if="product.sale_price !='0' && !product.is_new"
                                          data-ng-class="product.is_new ? 'sale flash' : 'flash'">Акция</span> <a
                                            data-ng-href="{{product.link}}">
                                        <picture>
                                            <source srcset="#" data-ng-srcset="{{product.thumb_link}}"
                                                    type="image/webp">
                                            <source srcset="#" data-ng-srcset="{{product.image_link}}"
                                                    type="image/jpeg">
                                            <img data-ng-src="{{product.image_link}}" src="#" alt="{{product.name}}">
                                        </picture>
                                    </a></div>
                                <div class="text"><a data-ng-href="{{product.link}}" class="name">{{product.name}}</a>
                                    <hr>
                                    <span class="priceLabel">Цена:</span>
                                    <div class="price" data-ng-if="product.sale_price !='0'"><span class="old-price">{{product.regular_price}}
                                            <span class="valute">₸</span></span> <span class="new-price">{{product.sale_price}}
                                            <span class="valute">₸</span></span></div>
                                    <div class="price" data-ng-if="product.sale_price=='0'"><span class="regular-price">{{product.regular_price}}
                                            <span class="valute">₸</span></span></div>
                                </div>
                                <div class="btns"><a class="add-to-cart" data-ng-click="cat.addToCart(product)"
                                                     data-ng-if="product.stock_count && !product.inCart">Купить</a> <a
                                            href="<?php echo e(route('cart.index')); ?>" class="add-to-cart"
                                            data-ng-if="product.stock_count && product.inCart">В корзину</a>
                                    <p class="out-of-stock" data-ng-if="!product.stock_count">Нет в наличии</p><a
                                            class="add-to-compare" data-ng-if="!product.inCompare"
                                            data-ng-click="cat.addToCompare(product)"></a> <a
                                            class="add-to-compare active" data-ng-if="product.inCompare"
                                            data-ng-click="cat.deleteCompareItem(product)"></a></div>
                            </div>
                        </div>
                    </div>
                    <ul data-ng-if="cat.filtered_products.length > cat.pageSize" data-uib-pagination
                        data-total-items="cat.filtered_products.length" data-ng-model="cat.currentPage"
                        data-max-size="4" data-template-url="/js/angular/templates/pagination.html"
                        class="pagination-sm" data-boundary-link="false" data-rotate="false"
                        data-items-per-page="cat.pageSize"></ul>
                    <div class="products" data-ng-if="!cat.products.length && !cat.loading"><p class="col-4">В данной
                            категории еще нет товаров</p></div>
                    <div class="text-description">
                        <?php echo $category->seoText; ?>

                    </div>
                </div>
            </div>
        </div><?php echo $__env->make('partials.modalFilterCatalog', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/products/index.blade.php ENDPATH**/ ?>