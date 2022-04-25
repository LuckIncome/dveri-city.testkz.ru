@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
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
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="@if(isset($dataTypeContent->id)){{ route('orders.update', $dataTypeContent->id) }}@else{{ route('voyager.orders.store') }}@endif"
              method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-dollar"></i> Заказ № {{$dataTypeContent->id}}
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
                            @foreach($dataTypeContent->orderProducts as $orderProduct)
                                <div class="product"
                                     style="width: 100%;float: left;border-top:1px solid #ccc;padding-top: 10px;margin-bottom: 10px">
                                    <div class="product-info" style="width: 40%;float: left;">
                                        <img style="width: 25%;float: left;max-height: 80px;object-fit:scale-down"
                                             src="{{Voyager::image($orderProduct->product->thumb)}}"
                                             alt="{{$orderProduct->product->name}}">
                                        <div class="info"
                                             style="width: 40%;float: left;margin-left: 10px;">
                                            <a href="/admin/products/{{$orderProduct->product->id}}">
                                                <p class="name">{{$orderProduct->product->name}}</p>
                                            </a>
                                            @foreach($orderProduct->product->options as $option)
                                                <div class="attribute">
                                                    <strong>{{$option->option}}</strong>
                                                    <span>{{$option->value}}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="quantity" style="width: 30%;float: left;margin-top: 20px">
                                        <p class="countText">Кол-во: <b>{{$orderProduct->product_count}}</b></p>
                                    </div>
                                    <div class="product-price" style="width: 30%;float: left;margin-top: 20px">
                                        <p class="cost">
                                <span class="sale-price price">Цена:   <b>{{$orderProduct->product_price}}</b> <span
                                            class="currency">₸</span></span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group" style="width: 20%;float: right;">
                                <strong>Общая Сумма: </strong>
                                <p>{{number_format($dataTypeContent->amount,0,'',' ')}} тг</p>
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
                                <p>{{$dataTypeContent->order_comments}}</p>
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
                                <p>{{number_format($dataTypeContent->amount,0,'',' ')}} тг</p>
                            </div>
                            <div class="form-group">
                                <strong>Способ оплаты</strong>
                                @if($dataTypeContent->payment_type == 'cash')
                                    <p>Наличными при получении</p>
                                @elseif($dataTypeContent->payment_type == 'card')
                                    <p>Картой при получении</p>
                                @else
                                    <p>Онлайн оплата (Оплачено)</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <strong>Способ доставки</strong>
                                <p>{{($dataTypeContent->delivery_type == 'self') ? 'Самовывоз': 'Доставка'}}</p>
                            </div>
                            <div class="form-group">
                                <label style="width: 100%;">
                                    <span class="panel-desc">Статус</span>
                                    <select name="status" class="form-control">
                                        <option @if($dataTypeContent->status == 0) selected @endif value="0">Новый
                                            заказ
                                        </option>
                                        <option @if($dataTypeContent->status == 1) selected @endif value="1">
                                            Выполняется
                                        </option>
                                        <option @if($dataTypeContent->status == 2) selected @endif value="2">Выполнен
                                        </option>
                                        <option @if($dataTypeContent->status == 3) selected @endif value="3">Отменен
                                        </option>
                                        <option @if($dataTypeContent->status == 4) selected @endif value="4">Возврат
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
                                <p>{{$dataTypeContent->is_entity ? 'Юридическое лицо' : 'Физическое лицо'}}</p>
                            </div>
                            @if($dataTypeContent->is_entity)
                                <div class="form-group">
                                    <strong>Название Компании :</strong>
                                    <p>{{$dataTypeContent->orderEntity->name}}</p>
                                </div>
                                <div class="form-group">
                                    <strong>БИН :</strong>
                                    <p>{{$dataTypeContent->orderEntity->bin}}</p>
                                </div>
                                <div class="form-group">
                                    <strong>БИК :</strong>
                                    <p>{{$dataTypeContent->orderEntity->bik}}</p>
                                </div>
                                <div class="form-group">
                                    <strong>ИИК :</strong>
                                    <p>{{$dataTypeContent->orderEntity->iik}}</p>
                                </div>
                                <div class="form-group">
                                    <strong>Юр.Адрес :</strong>
                                    <p>{{$dataTypeContent->orderEntity->address}}</p>
                                </div>
                            @endif
                            <div class="form-group">
                                <strong>Эл. почта :</strong>
                                <p>{{$dataTypeContent->user_email}}</p>
                            </div>
                            <div class="form-group">
                                <strong>Имя получателя :</strong>
                                <p>{{$dataTypeContent->user_name}}</p>
                            </div>
                            <div class="form-group">
                                <strong>Мобильный телефон:</strong>
                                <p>{{$dataTypeContent->user_phone}}</p>
                            </div>
                            <div class="form-group">
                                <strong>Адрес:</strong>
                                <p>{{$dataTypeContent->user_address}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($dataTypeContent->id))Обновить @else <i
                        class="icon wb-plus-circle"></i> Новый заказ @endif
            </button>
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif
        });
    </script>
@stop
