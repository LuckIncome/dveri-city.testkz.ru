<?php $__env->startSection('meta_description',$description); ?><?php $__env->startSection('seo_title',$seoTitle); ?><?php $__env->startSection('meta_keywords',$keywords); ?><?php $__env->startSection('content'); ?>
    <div class="home-slider">
        <div class="slider">
            <div class="sliderContent"> <?php $__currentLoopData = $slidersT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item <?php if(!json_decode($slider->image_gallery)): ?> centered <?php endif; ?>">
                        <div class="slide-text-block justify-content-end">
                            <div class="slide-text">
                                <h2><?php echo e($slider->getTranslatedAttribute('title',$locale,$fallbackLocale)); ?></h2>
                                <p><?php echo e($slider->getTranslatedAttribute('description',$locale,$fallbackLocale)); ?></p>
                                <a rel="nofollow" href="<?php echo e($slider->button_link); ?>"
                                   class="slide-more <?php if(strlen($slider->button_link) < 2): ?> callback-btn <?php endif; ?>"><?php echo e($slider->getTranslatedAttribute('button',$locale,$fallbackLocale)); ?></a>
                                <?php if(json_decode($slider->image_gallery)): ?>
                                    <div class="slide-galery">
                                        <?php $__currentLoopData = json_decode($slider->image_gallery); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a
                                                    href="<?php echo e(Voyager::image($item)); ?>" class="fb"
                                                    data-fancybox="gallery-<?php echo e($slider->id); ?>">
                                                <picture class="slide-gallery-img">
                                                    <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($slider->getThumbnail($item, 'small')),PATHINFO_EXTENSION),'webp',Voyager::image($slider->getThumbnail($item, 'small')))); ?>"
                                                            type="image/webp">
                                                    <source srcset="<?php echo e(Voyager::image($slider->getThumbnail($item, 'small'))); ?>"
                                                            type="image/jpeg">
                                                    <img style="object-position: right;" src="<?php echo e(Voyager::image($slider->getThumbnail($item, 'small'))); ?>"
                                                         alt="<?php echo e($slider->getTranslatedAttribute('title',$locale,$fallbackLocale)); ?>- Галерея">
                                                </picture>
                                                <span></span> </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <picture class="slide-img-block">
                            <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($slider->image),PATHINFO_EXTENSION),'webp',Voyager::image($slider->image))); ?>"
                                    type="image/webp">
                            <source srcset="<?php echo e(Voyager::image($slider->image)); ?>" type="image/jpeg">
                            <img style="object-position: right;" src="<?php echo e(Voyager::image($slider->image)); ?>"
                                 alt="<?php echo e($slider->getTranslatedAttribute('title',$locale,$fallbackLocale)); ?>"></picture>
                    </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
            <?php if($slidersT->count() > 1): ?>
                <div class="container jcc">
                    <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                        <span>1/3</span>
                        <a class="nextSlide">Next</a></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="featured-products">
        <nav>
            <div class="container">
                <div class="nav nav-tabs align-items-end" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-new-tab" data-toggle="tab" href="#nav-new" role="tab" aria-controls="nav-new" aria-selected="true">Новинки</a>
                    <a class="nav-item nav-link" id="nav-hit-tab" data-toggle="tab" href="#nav-hit" role="tab" aria-controls="nav-hit" aria-selected="false">Хиты продаж</a>
                    <a class="nav-item nav-link" id="nav-action-tab" data-toggle="tab" href="#nav-action" role="tab" aria-controls="nav-action" aria-selected="false">Акции</a>
                    
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
                                            <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($newProduct->thumb),PATHINFO_EXTENSION),'webp',Voyager::image($newProduct->thumb))); ?>"
                                                    type="image/webp">
                                            <source srcset="<?php echo e(Voyager::image($newProduct->thumb)); ?>"
                                                    type="image/jpeg">
                                            <img src="<?php echo e(Voyager::image($newProduct->thumb)); ?>"
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
                                            <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($featuredProduct->thumb),PATHINFO_EXTENSION),'webp',Voyager::image($featuredProduct->thumb))); ?>"
                                                    type="image/webp">
                                            <source srcset="<?php echo e(Voyager::image($featuredProduct->thumb)); ?>"
                                                    type="image/jpeg">
                                            <img src="<?php echo e(Voyager::image($featuredProduct->thumb)); ?>"
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
                                            <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($saleProduct->thumb),PATHINFO_EXTENSION),'webp',Voyager::image($saleProduct->thumb))); ?>"
                                                    type="image/webp">
                                            <source srcset="<?php echo e(Voyager::image($saleProduct->thumb)); ?>"
                                                    type="image/jpeg">
                                            <img src="<?php echo e(Voyager::image($saleProduct->thumb)); ?>"
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
            <div class="tab-pane fade" id="nav-nestan" role="tabpanel" aria-labelledby="nav-nestan-tab">
                <div class="tab-slider">
                    <div class="sliderArrows main justify-content-center">
                        <a class="prevSlide">Previous</a>
                        <span>1/3</span>
                        <a class="nextSlide">Next</a>
                    </div>
                    <div class="content">
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="catalog container"><h3>Каталог</h3>
        <div class="row"> <?php $__currentLoopData = $catalog->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="block <?php if(($key%2) !=0): ?> white <?php endif; ?> col-4">
                    <div class="inner">
                        <div class="image"><span></span> <a href="/catalog/<?php echo e($subcategory->slug); ?>">
                                <picture>
                                    <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($subcategory->image),PATHINFO_EXTENSION),'webp',Voyager::image($subcategory->image))); ?>"
                                            type="image/webp">
                                    <source srcset="<?php echo e(Voyager::image($subcategory->image)); ?>" type="image/jpeg">
                                    <img src="<?php echo e(Voyager::image($subcategory->image)); ?>" alt="<?php echo e($subcategory->name); ?>">
                                </picture>
                            </a></div>
                        <div class="text"><h5 class="title"><?php echo e($subcategory->name); ?></h5>
                            <p class="description"><?php echo e($subcategory->description); ?></p><a
                                    href="/catalog/<?php echo e($subcategory->slug); ?>" class="more">Подробнее</a></div>
                    </div>
                </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
    </div>
    <div class="laminat-block container">
        <div class="row">
            <div class="col-7"><h3>Ламинат и плинтус</h3>
                <p class="main-desc">Среди современных отделочных материалов для пола большим спросом пользуется
                    ламинат. Цена на многослойную доску доступная, а технические характеристики высокие.</p>
                <div class="text-block"><p>Материал наделен достаточной жесткостью и прочностью, имеет длительный
                        эксплуатационный срок. Обладает хорошими теплоизоляционными, звукоизоляционными свойствами. <br>Отличается
                        разнообразием расцветок, декоративным оформлением.</p>
                    <p>Из обширного ассортимента всегда можно выбрать, а затем купить ламинат нужного варианта.</p>
                    <strong>Длительность эксплуатационного срока напольного покрытия обеспечивается:</strong>
                    <ul class="advantages">
                        <li>влагостойким защитным слоем</li>
                        <li>высоким классом износостойкости</li>
                        <li>высоким классом износостойкости.</li>
                        <li>влагостойким защитным слоем</li>
                    </ul>
                    <ul class="more-btns">
                        <li><a href="/catalog/plintus" class="more">Показать все плинтуса</a></li>
                        <li><a href="/catalog/laminat" class="more">Показать все ламинаты</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-5">
                <div class="image-block">
                    <div class="main">
                        <picture>
                            <source srcset="/images/img8.webp" type="image/webp">
                            <source srcset="/images/img8.jpg" type="image/jpeg">
                            <img src="/images/img8.jpg" alt="Ламинат и плинтус"></picture>
                    </div>
                    <div class="secondary justify-content-end align-content-end">
                        <picture>
                            <source srcset="/images/img5.webp" type="image/webp">
                            <source srcset="/images/img5.jpg" type="image/jpeg">
                            <img src="/images/img5.jpg" alt="Ламинат и плинтус"></picture>
                        <picture>
                            <source srcset="/images/img6.webp" type="image/webp">
                            <source srcset="/images/img6.jpg" type="image/jpeg">
                            <img src="/images/img6.jpg" alt="Ламинат и плинтус"></picture>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="catalog furniture container"><h3>Фурнитура</h3>
        <div class="row"> <?php $__currentLoopData = $furniture->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="block <?php if(($key%2)==0): ?> white <?php endif; ?> col-4">
                    <div class="inner">
                        <div class="image"><span></span> <a href="/catalog/<?php echo e($subcategory->slug); ?>">
                                <picture>
                                    <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($subcategory->image),PATHINFO_EXTENSION),'webp',Voyager::image($subcategory->image))); ?>"
                                            type="image/webp">
                                    <source srcset="<?php echo e(Voyager::image($subcategory->image)); ?>" type="image/jpeg">
                                    <img src="<?php echo e(Voyager::image($subcategory->image)); ?>" alt="<?php echo e($subcategory->name); ?>">
                                </picture>
                            </a></div>
                        <div class="text"><h5 class="title"><?php echo e($subcategory->name); ?></h5>
                            <p class="description"><?php echo e($subcategory->description); ?></p><a
                                    href="/catalog/<?php echo e($subcategory->slug); ?>" class="more">Подробнее</a></div>
                    </div>
                </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
    </div>
    <div class="about-block">
        <div class="container">
            <div class="row">
                <div class="col-6"><h3>О нас</h3>
                    <div class="info-text"><p>Двери-Сити - молодая организация, которая занимается продажей входных,
                            тамбурных и межкомнатных дверей. У нас вы можете найти дверь на любой вкус, которая впишется
                            в любой дизайн интерьера.</p>
                        <p>Марка Российских металлических входных дверей "Бульдорс" известна многим. Мы являемся
                            официальным дилером этой компании в городе Алматы, что позволяет держать нам самые низкие
                            цены на этот тип дверей.</p>
                        <p>Приобретая дверь у нас, вы можете заказать также доставку и установку.</p><a
                                href="/page/about" class="more">Подробнее</a></div>
                </div>
                <div class="col-6 video-play">
                    <div class="video-block"><span>О производстве <br>дверей «Бульдорс»</span> <a class="play"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="advantages-block">
        <div class="outer">
            <div class="inner">
                <div class="container">
                    <div class="row"> <?php $__currentLoopData = $renders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $render): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="block col-3 d-flex flex-wrap justify-content-start"><img
                                        src="<?php echo e(Voyager::image($render->image)); ?>" alt="<?php echo e($render->title); ?>- Dvericity">
                                <h4><?php echo e($render->title); ?></h4>
                                <p><?php echo e($render->description); ?></p></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="articles-block container">
        <div class="title-block d-flex justify-content-between"><h3>Новости</h3> <a href="<?php echo e(route('posts.index')); ?>"
                                                                                    class="more">Посмотреть все
                новости</a></div>
        <div class="articles">
            <div class="row"> <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="article col-3"><p
                                class="date"><?php echo e(Carbon\Carbon::parse($post->created_at)->format('d.m.Y')); ?></p><a
                                href="<?php echo e(route('posts.show',$post->slug)); ?>" class="title"><?php echo e($post->title); ?></a>
                        <p class="excerpt"><?php echo e($post->excerpt); ?></p></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
        </div>
    </div><?php echo $__env->make('partials.modalVideo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/home.blade.php ENDPATH**/ ?>