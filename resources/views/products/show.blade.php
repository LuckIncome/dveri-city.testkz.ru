@extends('partials.app')@section('seo_title',$product->seo_title ? $product->seo_title : $product->name)@section('meta_keywords',$product->meta_keywords)@section('meta_description',$product->meta_description)@section('content')
    <div class="product-page def-page" data-ng-controller="ProductController as pc">
        <div class="pre-header">
            <div class="container"> @include('partials.breadcrumbs',['title'=>'Каталог','subtitle'=> $product->name,'titleLink'=> route('products.index')])
                <h1>{{$product->name}}</h1></div>
        </div>
        <div class="container" data-ng-init="pc.init('{{$product->slug}}')">
            <div class="row">
                <div class="content">
                    <div class="product"> @if($product->interior_img && !empty(json_decode($product->interior_img)))
                            <div class="interior" data-ng-show="pc.activeInterior">
                                <div class="interiorBg">
                                    <div class="fix-center-img"><img id="interiorBgImg" class="fit-height"
                                                                     src="/images/interiors/m-interior-1.jpg"></div>
                                </div>
                                <div class="interiorContent">
                                    <div class="productImage"><img id="interiorImg" class="product"
                                                                   src="{{Voyager::image(json_decode($product->interior_img)[0])}}"
                                                                   alt="{{$product->name}}"></div>
                                    <div data-ng-show="pc.intOptionsActive" class="intOptions">
                                        <button type="button" class="round-button close-options"
                                                data-ng-click="pc.intOptionsActive=false">&times;
                                        </button>
                                        <div class="prod-interior">
                                            <div class="prod-interior__settings">
                                                <div class="interior-images">
                                                    @foreach(json_decode($product->interior_img) as $k=>$image)
                                                    <a class="interior-image @if($k == 0) active @endif"
                                                       data-img="{{ Voyager::image($image) }}"><img
                                                                src="{{ Voyager::image($image) }}"
                                                                alt="{{$product->name}}"></a>
                                                    @endforeach

                                                </div>
                                                <div class="prod-interior__settings-top">
                                                    <ul class="no-mark">
                                                        <li class="modern"><span>Modern</span></li>
                                                        <li class="pop"><span>Pop</span></li>
                                                        <li class="loft"><span>Loft</span></li>
                                                        <li class="classic"><span>Classic</span></li>
                                                    </ul>
                                                </div>
                                                <div class="prod-interior__settings-bottom">
                                                    <div class="interiors-line i--0"><a class="interior-item active"
                                                                                        data-img="/m-interior-1.jpg"><img
                                                                    src="/images/interiors/11a5303bb3e5625dd7f07100005972282b8dd4e8ddb4fd4a.jpg"
                                                                    alt="Интерьер Модерн-1"></a> <a
                                                                class="interior-item" data-img="/p-interior-1.jpg"><img
                                                                    src="/images/interiors/c32a325c0cc459a55cec779a94f27a4ba4c3961c9ec23cee.jpg"
                                                                    alt="Интерьер Поп-1"></a> <a class="interior-item"
                                                                                                 data-img="/l-interior-1.jpg"><img
                                                                    src="/images/interiors/bcdf193bdff796ecc565c9727aae7b0cb205d6b3de011e9c.jpg"
                                                                    alt="Интерьер Лофт-1"></a> <a class="interior-item"
                                                                                                  data-img="/c-interior-1.jpg"><img
                                                                    src="/images/interiors/caf2f4e1b28623c33e526d1a14f89f5dfe4b7098773240b1.jpg"
                                                                    alt="Интерьер Классика-1"></a></div>
                                                    <div class="interiors-line i--1"><a class="interior-item"
                                                                                        data-img="/m-interior-2.jpg"><img
                                                                    src="/images/interiors/50af03a18e6775d6650b1a2a248d363c68baf2d1f54b1b59.jpg"
                                                                    alt="Интерьер Модерн-2"></a> <a
                                                                class="interior-item" data-img="/p-interior-2.jpg"><img
                                                                    src="/images/interiors/d4532081558507c9931144878ea5cd4ad66584fc82e96baf.jpg"
                                                                    alt="Интерьер Поп-2"></a> <a class="interior-item"
                                                                                                 data-img="/l-interior-2.jpg"><img
                                                                    src="/images/interiors/5e653f35d913d31558ec45b2b6228c2bc1369b2399c05a6a.jpg"
                                                                    alt="Интерьер Лофт-2"></a> <a class="interior-item"
                                                                                                  data-img="/c-interior-2.jpg"><img
                                                                    src="/images/interiors/7f5402e0705488566e2123cec6ff9ef0e3ce4ffd4acd4531.jpg"
                                                                    alt="Интерьер Классика-2"></a></div>
                                                    <div class="interiors-line i--2"><a class="interior-item"
                                                                                        data-img="/m-interior-3.jpg"><img
                                                                    src="/images/interiors/6207f5b92b97f66222af64f8f6e19df6d826872781849cdb.jpg"
                                                                    alt="Интерьер Модерн-3"></a> <a
                                                                class="interior-item" data-img="/p-interior-3.jpg"><img
                                                                    src="/images/interiors/099a693c4cb2a76bbf87ab4042ca698a9ece9e3c94ae7577.jpg"
                                                                    alt="Интерьер Поп-3"></a> <a class="interior-item"
                                                                                                 data-img="/l-interior-3.jpg"><img
                                                                    src="/images/interiors/22e7b98c3e3c78abb51335f8f56f7fb7fac97d767af638c6.jpg"
                                                                    alt="Интерьер Лофт-3"></a> <a class="interior-item"
                                                                                                  data-img="/c-interior-3.jpg"><img
                                                                    src="/images/interiors/645ef03b4cf9f6d4472f7a21218dc2c82bbc75297ada653d.jpg"
                                                                    alt="Интерьер Классика-3"></a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="optsBtn" title="Выбрать интерьер" data-ng-if="!pc.intOptionsActive"
                                       data-ng-click="pc.intOptionsActive=true"><i class="fa fa-cog"></i></a> <a
                                            class="optsBtn minimize" data-ng-if="pc.activeInterior"
                                            data-ng-click="pc.activeInterior=false" title="Закрыть интерьер"><i
                                                class="fa fa-compress"></i></a></div>
                            </div>
                            <div class="switcher"><a class="interiorBtn"
                                                     data-ng-class="pc.activeInterior ? 'active' : ''"
                                                     data-ng-click="pc.showInterior()">Интерьер</a></div>@endif
                        <div class="main-info">
                            <div class="image"> @if($product->is_new || $product->sale_price !=0) @if($product->is_new)
                                    <span class="flash new">Новинка</span> @endif @if(!$product->is_new && $product->sale_price !=0)
                                    <span class="flash sale">Акция</span> @endif @endif
                                <ul class="main-slider">
                                    <li class="image" data-thumb="{{$productT->thumbnail}}"><a class="fb"
                                                                                               href="{{Voyager::image($product->thumb)}}"
                                                                                               data-fancybox="gallery-{{$product->id}}">
                                            <picture>
                                                <source srcset="{{$productT->thumbnail}}" type="image/webp">
                                                <source srcset="{{Voyager::image($productT->thumb)}}"
                                                        type="image/jpeg">
                                                <img src="{{Voyager::image($productT->thumb)}}"
                                                     alt="{{$product->name}}"></picture>
                                            <span class="zoomIn">Увеличить товар</span> </a>
                                    </li>@if($product->images && count(json_decode($product->images))) @foreach(json_decode($product->images) as $image)
                                        @if(strlen($image))
                                        <li class="image"
                                            data-thumb="{{str_replace(pathinfo(Voyager::image($productT->getThumbnail($image, 'small')), PATHINFO_EXTENSION),'webp',Voyager::image($productT->getThumbnail($image, 'small')))}}">
                                            <a class="fb" href="{{Voyager::image($image)}}"
                                               data-fancybox="gallery-{{$product->id}}">
                                                <picture>
                                                    <source srcset="{{str_replace(pathinfo(Voyager::image($image), PATHINFO_EXTENSION),'webp',Voyager::image($image))}}"
                                                            type="image/webp">
                                                    <source srcset="{{Voyager::image($image)}}"
                                                            type="image/jpeg">
                                                    <img src="{{Voyager::image($image)}}"
                                                         alt="{{$product->name}}"></picture>
                                                <span class="zoomIn">Увеличить товар</span> </a></li>
                                                @endif
                                                @endforeach @endif
                                </ul>
                            </div>
                            <div class="main-content">
                                <div class="attributes">
                                    @if($product->stock_count)
                                        <p class="stock instock">
                                            <i class="fa fa-check"></i> Есть в наличии</p>
                                    @else
                                        <p class="stock out-of-stock"><i class="fa fa-times"></i> Нет в наличии</p>
                                    @endif
                                    @if($product->variants) @foreach($product->variants as $key=>$variant) @if(in_array($key,['Цвет','Түсі']))
                                        <div class="attribute color"><strong>{{$key}}:</strong>
                                            <ul class="variants"> @foreach($variant->sortBy('value') as $option) @php $var=\App\Product::find($option->product_id); $var=$var->translate(session()->get('locale'),config('app.fallback_locale')); @endphp
                                                <li data-color="#{{$option->value_color}}"
                                                    @if($option->product_id==$product->id) class="active" @endif><a
                                                            style="background:#{{$option->value_color}}" title="{{$option->value}}"
                                                            href="{{($option->product_id !=$product->id) ? '/catalog/' .$var->category->slug.'/'.$var->slug : ''}}"><i
                                                                class="fa fa-check"></i></a></li>@endforeach </ul>
                                        </div>@else
                                        <div class="attribute select"><strong>{{$key}}:</strong>
                                            <ul class="variants"> @foreach($variant->sortBy('value') as $option) @php $var=\App\Product::find($option->product_id); $var=$var->translate(session()->get('locale'),config('app.fallback_locale')); @endphp
                                                <li @if($option->product_id==$product->id) class="active" @endif><a
                                                            href="{{($option->product_id !=$product->id) ? '/catalog/' .$var->category->slug.'/'.$var->slug : ''}}">{{$option->value}}</a>
                                                </li>@endforeach </ul>
                                        </div>@endif @endforeach @endif
                                    <div class="info-text"><p>{{strip_tags($product->excerpt)}}</p></div>
                                    <div class="add">
                                        <div class="price"><span>Цена:</span> @if(!$product->sale_price)
                                                <p>{{number_format($product->regular_price,0 ,'', ' ')}}<span
                                                            class="valute">₸</span></p>@else <p
                                                        class="old-price">{{number_format($product->regular_price,0 ,'', ' ')}}
                                                    <span class="valute">₸</span></p><p
                                                        class="new-price">{{number_format($product->sale_price,0 ,'', ' ')}}
                                                    <span class="valute">₸</span></p>@endif </div>
                                        <div class="btns"> @if($product->stock_count) <a class="add-to-cart"
                                                                                         data-ng-click="pc.addToCart({{$product->id}})"
                                                                                         data-ng-if="!pc.inCart">Купить</a>
                                            <a href="{{route('cart.index')}}" class="add-to-cart"
                                               data-ng-if="pc.inCart">Перейти в корзину</a> @endif <a
                                                    class="add-to-compare" data-ng-if="!pc.product.inCompare"
                                                    data-ng-click="pc.addToCompare({{$product->id}})"></a> <a
                                                    class="add-to-compare active" data-ng-if="pc.product.inCompare"
                                                    data-ng-click="pc.deleteCompare({{$product->id}})"></a></div>
                                    </div>
                                </div>
                                <div class="info-block">
                                    <div class="block"><strong>Доставка:</strong>
                                        <p>по Алмате</p></div>
                                    <div class="block"><strong>Оплата:</strong>
                                        <p>Наличными при получении</p>
                                        <p>Безналичными без/с НДС</p>
                                        <p>VISA | MASTERCARD</p></div>
                                    <div class="block"><strong>Гарантия:</strong>
                                        <p>Срок гарантии указан<br>в характеристиках</p></div>
                                    <div class="block"><strong>Обмен | возврат:</strong>
                                        <p>Обмен/возврат товара в течении<br>14 дней</p></div>
                                </div>
                            </div>
                        </div>
                        @if($product->chars)
                            <div class="characteristics"><strong>Основные характеристики</strong>
                                <div class="block">
                                    <div class="char"><strong>Артикул:</strong>
                                        <p>{{$product->sku}}</p></div>
                                    <div class="char"><strong>Бренд:</strong>
                                        <p>{{$product->brand}}</p></div>
                                    @foreach($product->chars as $char)
                                        <div class="char"><strong>{{$char['name']}}:</strong>
                                            <p>{{$char['value']}}</p></div>
                                    @endforeach </div>
                            </div>
                        @else
                            <div class="characteristics"><strong>Основные характеристики</strong>
                                <div class="block">
                                    <div class="char"><strong>Артикул:</strong>
                                        <p>{{$product->sku}}</p></div>
                                    <div class="char"><strong>Бренд:</strong>
                                        <p>{{$product->brand}}</p></div>
                                </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            <div class="related-products" id="nav-related">
                <div class="container related-header"><strong>С этим товаром покупают</strong>
                    <div class="buttons">{{--<a href="#" class="show-more">Все новинки</a>--}}
                        <div class="sliderArrows main justify-content-center"><a class="prevSlide">Previous</a>
                            <span>1/3</span> <a class="nextSlide">Next</a></div>
                    </div>
                </div>
                <div id="related-slider" class="tab-slider">
                    <div class="content"> @foreach($featuredProducts as $featuredProduct)
                            <div class="item">
                                <div class="image"><a
                                            href="{{route('product.show',[$featuredProduct->category->slug,$featuredProduct->slug])}}">
                                        <picture>
                                            <source srcset="{{$featuredProduct->thumbnail}}" type="image/webp">
                                            <source srcset="{{Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb,'small'))}}"
                                                    type="image/jpeg">
                                            <img src="{{Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb,'small'))}}"
                                                 alt="{{$featuredProduct->name}}"></picture>
                                    </a></div>
                                <div class="text"><a
                                            href="{{route('product.show',[$featuredProduct->category->slug,$featuredProduct->slug])}}"
                                            class="name">{{$featuredProduct->getTranslatedAttribute('name',$locale,$fallbackLocale)}}</a>
                                    <span class="category">{{$featuredProduct->category->getTranslatedAttribute('name',$locale,$fallbackLocale)}}
                                        -{{$featuredProduct->getTranslatedAttribute('brand',$locale,$fallbackLocale)}}</span>
                                    <hr>
                                    <div class="price"> @if(!$featuredProduct->sale_price)
                                            <p>{{number_format($featuredProduct->regular_price,0 ,'', ' ')}}<span
                                                        class="valute">₸</span></p>@else <p
                                                    class="old-price">{{number_format($featuredProduct->regular_price,0 ,'', ' ')}}
                                                <span class="valute">₸</span></p><p
                                                    class="new-price">{{number_format($featuredProduct->sale_price,0 ,'', ' ')}}
                                                <span class="valute">₸</span></p>@endif </div>
                                </div>
                            </div>@endforeach </div>
                </div>
            </div>
        </div>@endsection
