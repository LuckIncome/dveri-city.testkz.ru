<?php $__env->startSection('meta_description',$description); ?>
<?php $__env->startSection('seo_title',$seoTitle); ?>
<?php $__env->startSection('meta_keywords',$keywords); ?>
<?php $__env->startSection('content'); ?>
    <div class="catalog-page def-page">
        <div class="pre-header">
            <div class="container"> <?php echo $__env->make('partials.breadcrumbs',['title'=> 'Каталог'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <h1>Каталог товаров</h1>
            </div>
        </div>
        <div class="container catalog">
            <div class="row">
                <?php $__currentLoopData = $catalog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="block <?php if(($key%2) !=0): ?> white <?php endif; ?> col-4">
                        <div class="inner no-border">
                            <div class="image"><span></span> <a href="/catalog/<?php echo e($subcategory->slug); ?>">
                                    <picture>
                                        <source srcset="<?php echo e(str_replace('.' . pathinfo(\Voyager::image($subcategory->image),PATHINFO_EXTENSION), '.webp', \Voyager::image($subcategory->image))); ?>"
                                                type="image/webp">
                                        <source srcset="<?php echo e(Voyager::image($subcategory->image)); ?>" type="image/jpeg">
                                        <img src="<?php echo e(Voyager::image($subcategory->image)); ?>" alt="<?php echo e($subcategory->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?>">
                                    </picture>
                                </a></div>
                            <div class="text"><h5 class="title"><?php echo e($subcategory->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?></h5>
                                <p class="description"><?php echo e($subcategory->getTranslatedAttribute('description',$locale,$fallbackLocale)); ?></p><a
                                        href="/catalog/<?php echo e($subcategory->slug); ?>" class="more">Подробнее</a></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="featured-products pb-5">
            <nav>
                <div class="container">
                    <div class="nav nav-tabs align-items-end" id="nav-tab" role="tablist"><a
                                class="nav-item nav-link active" id="nav-new-tab" data-toggle="tab" href="#nav-new"
                                role="tab" aria-controls="nav-new" aria-selected="true">Новинки</a> <a
                                class="nav-item nav-link" id="nav-hit-tab" data-toggle="tab" href="#nav-hit" role="tab"
                                aria-controls="nav-hit" aria-selected="false">Хиты продаж</a> <a class="nav-item nav-link"
                                                                                                 id="nav-action-tab"
                                                                                                 data-toggle="tab"
                                                                                                 href="#nav-action"
                                                                                                 role="tab"
                                                                                                 aria-controls="nav-action"
                                                                                                 aria-selected="false">Акции</a>
                    </div>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-new" role="tabpanel"
                     aria-labelledby="nav-new-tab">
                    <div class="tab-slider">
                        <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                            <span>1/3</span> <a class="nextSlide">Next</a></div>
                        <div class="content"> <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="item">
                                    <div class="image"><a
                                                href="<?php echo e(route('product.show',[$newProduct->category->slug,$newProduct->slug])); ?>">
                                            <picture>
                                                <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small')))['extension'],'webp',Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small')))); ?>"
                                                        type="image/webp">
                                                <source srcset="<?php echo e(Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small'))); ?>"
                                                        type="image/jpeg">
                                                <img src="<?php echo e(Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small'))); ?>"
                                                     alt="<?php echo e($newProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?>">
                                            </picture>
                                        </a></div>
                                    <div class="text"><a
                                                href="<?php echo e(route('product.show',[$newProduct->category->slug,$newProduct->slug])); ?>"
                                                class="name"><?php echo e($newProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?></a>
                                        <span class="category"><?php echo e($newProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?>

                                            -<?php echo e($newProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)); ?></span>
                                        <hr>
                                        <div class="price"> <?php if(!$newProduct->sale_price): ?> <span><?php echo e(number_format($newProduct->regular_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <?php else: ?> <span class="old-price"><?php echo e(number_format($newProduct->regular_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <span class="new-price"><?php echo e(number_format($newProduct->sale_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <?php endif; ?> </div>
                                    </div>
                                </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-hit" role="tabpanel"
                     aria-labelledby="nav-hit-tab">
                    <div class="tab-slider">
                        <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                            <span>1/3</span> <a class="nextSlide">Next</a></div>
                        <div class="content"> <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featuredProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="item">
                                    <div class="image"><a
                                                href="<?php echo e(route('product.show',[$featuredProduct->category->slug,$featuredProduct->slug])); ?>">
                                            <picture>
                                                <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small')))['extension'],'webp',Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small')))); ?>"
                                                        type="image/webp">
                                                <source srcset="<?php echo e(Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small'))); ?>"
                                                        type="image/jpeg">
                                                <img src="<?php echo e(Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small'))); ?>"
                                                     alt="<?php echo e($featuredProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?>">
                                            </picture>
                                        </a></div>
                                    <div class="text"><a
                                                href="<?php echo e(route('product.show',[$featuredProduct->category->slug,$featuredProduct->slug])); ?>"
                                                class="name"><?php echo e($featuredProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?></a>
                                        <span class="category"><?php echo e($featuredProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?>

                                            -<?php echo e($featuredProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)); ?></span>
                                        <hr>
                                        <div class="price"> <?php if(!$featuredProduct->sale_price): ?> <span><?php echo e(number_format($featuredProduct->regular_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <?php else: ?> <span class="old-price"><?php echo e(number_format($featuredProduct->regular_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <span class="new-price"><?php echo e(number_format($featuredProduct->sale_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <?php endif; ?> </div>
                                    </div>
                                </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-action" role="tabpanel"
                     aria-labelledby="nav-action-tab">
                    <div class="tab-slider">
                        <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                            <span>1/3</span> <a class="nextSlide">Next</a></div>
                        <div class="content"> <?php $__currentLoopData = $saleProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saleProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="item">
                                    <div class="image"><a
                                                href="<?php echo e(route('product.show',[$saleProduct->category->slug,$saleProduct->slug])); ?>">
                                            <picture>
                                                <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small')))['extension'],'webp',Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small')))); ?>"
                                                        type="image/webp">
                                                <source srcset="<?php echo e(Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small'))); ?>"
                                                        type="image/jpeg">
                                                <img src="<?php echo e(Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small'))); ?>"
                                                     alt="<?php echo e($saleProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?>">
                                            </picture>
                                        </a></div>
                                    <div class="text"><a
                                                href="<?php echo e(route('product.show',[$saleProduct->category->slug,$saleProduct->slug])); ?>"
                                                class="name"><?php echo e($saleProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?></a>
                                        <span class="category"><?php echo e($saleProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)); ?>

                                            -<?php echo e($saleProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)); ?></span>
                                        <hr>
                                        <div class="price"> <?php if(!$saleProduct->sale_price): ?> <span><?php echo e(number_format($saleProduct->regular_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <?php else: ?> <span class="old-price"><?php echo e(number_format($saleProduct->regular_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <span class="new-price"><?php echo e(number_format($saleProduct->sale_price,0 ,'', ' ')); ?>

                                                <span class="valute">₸</span></span> <?php endif; ?> </div>
                                    </div>
                                </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/products/catalog.blade.php ENDPATH**/ ?>