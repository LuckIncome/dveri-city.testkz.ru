@extends('partials.app')
@section('meta_description',$description)
@section('seo_title',$seoTitle)
@section('meta_keywords',$keywords)
@section('content')
    <div class="catalog-page def-page">
        <div class="pre-header">
            <div class="container"> @include('partials.breadcrumbs',['title'=> 'Каталог']) <h1>Каталог товаров</h1>
            </div>
        </div>
        <div class="container catalog">
            <div class="row">
                @foreach($catalog as $key=>$subcategory)
                    <div class="block @if(($key%2) !=0) white @endif col-4">
                        <div class="inner no-border">
                            <div class="image"><span></span> <a href="/catalog/{{$subcategory->slug}}">
                                    <picture>
                                        <source srcset="{{str_replace('.' . pathinfo(\Voyager::image($subcategory->image),PATHINFO_EXTENSION), '.webp', \Voyager::image($subcategory->image))}}"
                                                type="image/webp">
                                        <source srcset="{{Voyager::image($subcategory->image)}}" type="image/jpeg">
                                        <img src="{{Voyager::image($subcategory->image)}}" alt="{{$subcategory->getTranslatedAttribute('name',$locale,$fallbackLocale)}}">
                                    </picture>
                                </a></div>
                            <div class="text"><h5 class="title">{{$subcategory->getTranslatedAttribute('name',$locale,$fallbackLocale)}}</h5>
                                <p class="description">{{$subcategory->getTranslatedAttribute('description',$locale,$fallbackLocale)}}</p><a
                                        href="/catalog/{{$subcategory->slug}}" class="more">Подробнее</a></div>
                        </div>
                    </div>
                @endforeach
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
                     aria-labelledby="nav-new-tab">{{--<a href="#" class="show-more">Все новинки</a>--}}
                    <div class="tab-slider">
                        <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                            <span>1/3</span> <a class="nextSlide">Next</a></div>
                        <div class="content"> @foreach($newProducts as $newProduct)
                                <div class="item">
                                    <div class="image"><a
                                                href="{{route('product.show',[$newProduct->category->slug,$newProduct->slug])}}">
                                            <picture>
                                                <source srcset="{{str_replace(pathinfo(Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small')))['extension'],'webp',Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small')))}}"
                                                        type="image/webp">
                                                <source srcset="{{Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small'))}}"
                                                        type="image/jpeg">
                                                <img src="{{Voyager::image($newProduct->getThumbnail($newProduct->thumb, 'small'))}}"
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
                                                <source srcset="{{str_replace(pathinfo(Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small')))['extension'],'webp',Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small')))}}"
                                                        type="image/webp">
                                                <source srcset="{{Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small'))}}"
                                                        type="image/jpeg">
                                                <img src="{{Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small'))}}"
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
                                                <source srcset="{{str_replace(pathinfo(Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small')))['extension'],'webp',Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small')))}}"
                                                        type="image/webp">
                                                <source srcset="{{Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small'))}}"
                                                        type="image/jpeg">
                                                <img src="{{Voyager::image($saleProduct->getThumbnail($saleProduct->thumb, 'small'))}}"
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
            </div>
        </div>
@endsection