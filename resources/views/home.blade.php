@extends('partials.app')@section('meta_description',$description)@section('seo_title',$seoTitle)@section('meta_keywords',$keywords)@section('content')
    <div class="home-slider">
        <div class="slider">
            <div class="sliderContent"> @foreach($slidersT as $slider)
                    <div class="item @if(!json_decode($slider->image_gallery)) centered @endif">
                        <div class="slide-text-block justify-content-end">
                            <div class="slide-text">
                                <h2>{{$slider->getTranslatedAttribute('title',$locale,$fallbackLocale)}}</h2>
                                <p>{{$slider->getTranslatedAttribute('description',$locale,$fallbackLocale)}}</p>
                                <a rel="nofollow" href="{{$slider->button_link}}"
                                   class="slide-more @if(strlen($slider->button_link) < 2) callback-btn @endif">{{$slider->getTranslatedAttribute('button',$locale,$fallbackLocale)}}</a>
                                @if(json_decode($slider->image_gallery))
                                    <div class="slide-galery">
                                        @foreach(json_decode($slider->image_gallery) as $item)
                                            <a
                                                    href="{{Voyager::image($item)}}" class="fb"
                                                    data-fancybox="gallery-{{$slider->id}}">
                                                <picture class="slide-gallery-img">
                                                    <source srcset="{{str_replace(pathinfo(Voyager::image($slider->getThumbnail($item, 'small')),PATHINFO_EXTENSION),'webp',Voyager::image($slider->getThumbnail($item, 'small')))}}"
                                                            type="image/webp">
                                                    <source srcset="{{Voyager::image($slider->getThumbnail($item, 'small'))}}"
                                                            type="image/jpeg">
                                                    <img style="object-position: right;" src="{{Voyager::image($slider->getThumbnail($item, 'small'))}}"
                                                         alt="{{$slider->getTranslatedAttribute('title',$locale,$fallbackLocale)}}- Галерея">
                                                </picture>
                                                <span></span> </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <picture class="slide-img-block">
                            <source srcset="{{str_replace(pathinfo(Voyager::image($slider->image),PATHINFO_EXTENSION),'webp',Voyager::image($slider->image))}}"
                                    type="image/webp">
                            <source srcset="{{Voyager::image($slider->image)}}" type="image/jpeg">
                            <img style="object-position: right;" src="{{Voyager::image($slider->image)}}"
                                 alt="{{$slider->getTranslatedAttribute('title',$locale,$fallbackLocale)}}"></picture>
                    </div>@endforeach </div>
            @if($slidersT->count() > 1)
                <div class="container jcc">
                    <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                        <span>1/3</span>
                        <a class="nextSlide">Next</a></div>
                </div>
            @endif
        </div>
    </div>
    <div class="featured-products">
        <nav>
            <div class="container">
                <div class="nav nav-tabs align-items-end" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-new-tab" data-toggle="tab" href="#nav-new" role="tab" aria-controls="nav-new" aria-selected="true">Новинки</a>
                    <a class="nav-item nav-link" id="nav-hit-tab" data-toggle="tab" href="#nav-hit" role="tab" aria-controls="nav-hit" aria-selected="false">Хиты продаж</a>
                    <a class="nav-item nav-link" id="nav-action-tab" data-toggle="tab" href="#nav-action" role="tab" aria-controls="nav-action" aria-selected="false">Акции</a>
                    {{--<a class="nav-item nav-link" id="nav-nestan-tab" data-toggle="tab" href="#nav-nestan" role="tab" aria-controls="nav-nestan" aria-selected="false">Нестандартные</a>--}}
                </div>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-new" role="tabpanel"
                 aria-labelledby="nav-new-tab">{{--<a href="#" class="show-more">Все новинки</a>--}}
                <div class="tab-slider">
                    <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                        <span>1/3</span> <a class="nextSlide">Next</a></div>
                    <div class="content"> @foreach($newProducts as $newProduct)
                            <div class="item">
                                <div class="image"><a
                                            href="{{route('product.show',[$newProduct->category->slug,$newProduct->slug])}}">
                                        <picture>
                                            <source srcset="{{str_replace(pathinfo(Voyager::image($newProduct->thumb),PATHINFO_EXTENSION),'webp',Voyager::image($newProduct->thumb))}}"
                                                    type="image/webp">
                                            <source srcset="{{Voyager::image($newProduct->thumb)}}"
                                                    type="image/jpeg">
                                            <img src="{{Voyager::image($newProduct->thumb)}}"
                                                 alt="{{$newProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}">
                                        </picture>
                                    </a></div>
                                <div class="text"><a
                                            href="{{route('product.show',[$newProduct->category->slug,$newProduct->slug])}}"
                                            class="name">{{$newProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}</a>
                                    <span class="category">{{$newProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)}}
                                        -{{$newProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)}}</span>
                                    <hr>
                                    <div class="price"> @if(!$newProduct->sale_price) <span>{{number_format($newProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> @else <span class="old-price">{{number_format($newProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> <span class="new-price">{{number_format($newProduct->sale_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> @endif </div>
                                </div>
                            </div>@endforeach </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-hit" role="tabpanel"
                 aria-labelledby="nav-hit-tab">{{--<a href="#" class="show-more">Все хиты продаж</a>--}}
                <div class="tab-slider">
                    <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                        <span>1/3</span> <a class="nextSlide">Next</a></div>
                    <div class="content"> @foreach($featuredProducts as $featuredProduct)
                            <div class="item">
                                <div class="image"><a
                                            href="{{route('product.show',[$featuredProduct->category->slug,$featuredProduct->slug])}}">
                                        <picture>
                                            <source srcset="{{str_replace(pathinfo(Voyager::image($featuredProduct->thumb),PATHINFO_EXTENSION),'webp',Voyager::image($featuredProduct->thumb))}}"
                                                    type="image/webp">
                                            <source srcset="{{Voyager::image($featuredProduct->thumb)}}"
                                                    type="image/jpeg">
                                            <img src="{{Voyager::image($featuredProduct->thumb)}}"
                                                 alt="{{$featuredProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}">
                                        </picture>
                                    </a></div>
                                <div class="text"><a
                                            href="{{route('product.show',[$featuredProduct->category->slug,$featuredProduct->slug])}}"
                                            class="name">{{$featuredProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}</a>
                                    <span class="category">{{$featuredProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)}}
                                        -{{$featuredProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)}}</span>
                                    <hr>
                                    <div class="price"> @if(!$featuredProduct->sale_price) <span>{{number_format($featuredProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> @else <span class="old-price">{{number_format($featuredProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> <span class="new-price">{{number_format($featuredProduct->sale_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> @endif </div>
                                </div>
                            </div>@endforeach </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-action" role="tabpanel"
                 aria-labelledby="nav-action-tab">{{--<a href="#" class="show-more">Все акции</a>--}}
                <div class="tab-slider">
                    <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                        <span>1/3</span> <a class="nextSlide">Next</a></div>
                    <div class="content"> @foreach($saleProducts as $saleProduct)
                            <div class="item">
                                <div class="image"><a
                                            href="{{route('product.show',[$saleProduct->category->slug,$saleProduct->slug])}}">
                                        <picture>
                                            <source srcset="{{str_replace(pathinfo(Voyager::image($saleProduct->thumb),PATHINFO_EXTENSION),'webp',Voyager::image($saleProduct->thumb))}}"
                                                    type="image/webp">
                                            <source srcset="{{Voyager::image($saleProduct->thumb)}}"
                                                    type="image/jpeg">
                                            <img src="{{Voyager::image($saleProduct->thumb)}}"
                                                 alt="{{$saleProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}">
                                        </picture>
                                    </a></div>
                                <div class="text"><a
                                            href="{{route('product.show',[$saleProduct->category->slug,$saleProduct->slug])}}"
                                            class="name">{{$saleProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}</a>
                                    <span class="category">{{$saleProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)}}
                                        -{{$saleProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)}}</span>
                                    <hr>
                                    <div class="price"> @if(!$saleProduct->sale_price) <span>{{number_format($saleProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> @else <span class="old-price">{{number_format($saleProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> <span class="new-price">{{number_format($saleProduct->sale_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> @endif </div>
                                </div>
                            </div>@endforeach </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-nestan" role="tabpanel" aria-labelledby="nav-nestan-tab">{{--<a href="#" class="show-more">Все акции</a>--}}
                <div class="tab-slider">
                    <div class="sliderArrows main justify-content-center">
                        <a class="prevSlide">Previous</a>
                        <span>1/3</span>
                        <a class="nextSlide">Next</a>
                    </div>
                    <div class="content">
                        
                        {{--@foreach($nestanProducts as $nestanProduct)
                            <div class="item">
                                <div class="image">
                                    <a href="{{route('product.show',[$nestanProduct->category->slug,$nestanProduct->slug])}}">
                                        <picture>
                                            <source srcset="{{str_replace(pathinfo(Voyager::image($nestanProduct->thumb),PATHINFO_EXTENSION),'webp',Voyager::image($nestanProduct->thumb))}}"
                                                    type="image/webp">
                                            <source srcset="{{Voyager::image($nestanProduct->thumb)}}"
                                                    type="image/jpeg">
                                            <img src="{{Voyager::image($nestanProduct->thumb)}}"
                                                 alt="{{$nestanProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}">
                                        </picture>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="{{route('product.show',[$nestanProduct->category->slug,$nestanProduct->slug])}}" class="name">{{$nestanProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}</a>
                                    <span class="category">
                                        {{$nestanProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)}}-{{$nestanProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)}}
                                    </span>
                                    <hr>
                                    <div class="price">
                                        @if(!$nestanProduct->sale_price)
                                            <span>{{number_format($nestanProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span>
                                        @else
                                            <span class="old-price">{{number_format($nestanProduct->regular_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span> <span class="new-price">{{number_format($nestanProduct->sale_price,0 ,'', ' ')}}
                                            <span class="valute">₸</span></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach--}}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="catalog container"><h3>Каталог</h3>
        <div class="row"> @foreach($catalog->subcategories as $key=>$subcategory)
                <div class="block @if(($key%2) !=0) white @endif col-4">
                    <div class="inner">
                        <div class="image"><span></span> <a href="/catalog/{{$subcategory->slug}}">
                                <picture>
                                    <source srcset="{{str_replace(pathinfo(Voyager::image($subcategory->image),PATHINFO_EXTENSION),'webp',Voyager::image($subcategory->image))}}"
                                            type="image/webp">
                                    <source srcset="{{Voyager::image($subcategory->image)}}" type="image/jpeg">
                                    <img src="{{Voyager::image($subcategory->image)}}" alt="{{$subcategory->name}}">
                                </picture>
                            </a></div>
                        <div class="text"><h5 class="title">{{$subcategory->name}}</h5>
                            <p class="description">{{$subcategory->description}}</p><a
                                    href="/catalog/{{$subcategory->slug}}" class="more">Подробнее</a></div>
                    </div>
                </div>@endforeach </div>
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
        <div class="row"> @foreach($furniture->subcategories as $key=>$subcategory)
                <div class="block @if(($key%2)==0) white @endif col-4">
                    <div class="inner">
                        <div class="image"><span></span> <a href="/catalog/{{$subcategory->slug}}">
                                <picture>
                                    <source srcset="{{str_replace(pathinfo(Voyager::image($subcategory->image),PATHINFO_EXTENSION),'webp',Voyager::image($subcategory->image))}}"
                                            type="image/webp">
                                    <source srcset="{{Voyager::image($subcategory->image)}}" type="image/jpeg">
                                    <img src="{{Voyager::image($subcategory->image)}}" alt="{{$subcategory->name}}">
                                </picture>
                            </a></div>
                        <div class="text"><h5 class="title">{{$subcategory->name}}</h5>
                            <p class="description">{{$subcategory->description}}</p><a
                                    href="/catalog/{{$subcategory->slug}}" class="more">Подробнее</a></div>
                    </div>
                </div>@endforeach </div>
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
                    <div class="row"> @foreach($renders as $render)
                            <div class="block col-3 d-flex flex-wrap justify-content-start"><img
                                        src="{{Voyager::image($render->image)}}" alt="{{$render->title}}- Dvericity">
                                <h4>{{$render->title}}</h4>
                                <p>{{$render->description}}</p></div>@endforeach </div>
                </div>
            </div>
        </div>
    </div>
    <div class="articles-block container">
        <div class="title-block d-flex justify-content-between"><h3>Новости</h3> <a href="{{route('posts.index')}}"
                                                                                    class="more">Посмотреть все
                новости</a></div>
        <div class="articles">
            <div class="row"> @foreach($posts as $post)
                    <div class="article col-3"><p
                                class="date">{{Carbon\Carbon::parse($post->created_at)->format('d.m.Y')}}</p><a
                                href="{{route('posts.show',$post->slug)}}" class="title">{{$post->title}}</a>
                        <p class="excerpt">{{$post->excerpt}}</p></div>@endforeach </div>
        </div>
    </div>@include('partials.modalVideo')@endsection