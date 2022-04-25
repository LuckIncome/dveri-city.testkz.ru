<?php

namespace App\Http\Controllers\Backend;

use App\Exports\OrdersExport;
use App\Imports\ProductImport;
use App\Order;
use App\Product;
use App\ProductOption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class ProductsController extends VoyagerBaseController
{
    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = \Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        $variants = Product::all();

        return \Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'variants'));
    }

    public function update(Request $request, $id)
    {
        $name = json_decode($request->get('name_i18n'));
        $excerpt = json_decode($request->get('excerpt_i18n'));
        $seo_title = json_decode($request->get('seo_title_i18n'));
        $meta_keywords = json_decode($request->get('meta_keywords_i18n'));
        $meta_description = json_decode($request->get('meta_description_i18n'));
        $product = Product::find($id);
        $product->name = $name->ru;
        $product->brand = $request->get('brand');
        $product->sku = trim($request->get('sku'));
        $product->category_id = $request->get('category_id');
        $product->regular_price = $request->get('regular_price');
        $product->sale_price = $request->get('sale_price');
        $product->excerpt = $excerpt->ru;
        $product->meta_description = strlen($meta_description->ru) > 1 ? $meta_description->ru : 'Купить ' . $name->ru . ' по лучшим ценам в компании Dveri-city';
        $product->meta_keywords = strlen($meta_keywords->ru) > 1 ? $meta_keywords->ru : $name->ru;
        $product->seo_title = strlen($seo_title->ru) > 1 ? $seo_title->ru : 'Купить ' . $name->ru;
        $product->featured = ($request->has('featured') && $request->get('featured') == 'on') ? true : false;
        $product->is_new = ($request->has('is_new') && $request->get('is_new') == 'on') ? true : false;
        $product->is_nestan = ($request->has('is_nestan') && $request->get('is_nestan') == 'on') ? true : false;
        $product->stock_count = $request->get('stock_count');
        $product->slug = $request->get('slug');
        if ($request->has('variations')) {
            $product->variation_id = serialize($request->get('variations'));
        }
        if (!file_exists(public_path('storage/products/' . date('FY') . '/'))) {
            mkdir(public_path('storage/products/' . date('FY') . '/'));
        }

        if ($request->has('thumb')) {

            $image = $request->file('thumb');
            $filename = '/products/' . date('FY') . '/' . \Str::random();
            $result_img = \Image::make($image->getRealPath())->encode($image->getClientOriginalExtension(), 100);
            $result_imgWeb = \Image::make($image->getRealPath())->encode('webp');
            $result_thumb = \Image::make($image->getRealPath())->resize(null, 90, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $result_thumbWeb = \Image::make($image->getRealPath())->encode('webp')->resize(null, 90, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
//            \Storage::disk(config('voyager.storage.disk'))->put($filename . '.' . $image->getClientOriginalExtension(), (string)$result_img, 'public');
//            \Storage::disk(config('voyager.storage.disk'))->put($filename . '-small.'. $image->getClientOriginalExtension(), (string)$result_thumb, 'public');
//            \Storage::disk(config('voyager.storage.disk'))->put($filename . '-small.webp', (string)$result_thumbWeb, 'public');

            $result_img->save(storage_path('app/public/') . $filename . '.' . $image->getClientOriginalExtension());
            $result_imgWeb->save(storage_path('app/public/') . $filename . '.webp');
            $result_thumb->save(storage_path('app/public/') . $filename . '-small.' . $image->getClientOriginalExtension());
            $result_thumbWeb->save(storage_path('app/public/') . $filename . '-small.webp');

            $product->thumb = $filename . '.' . $image->getClientOriginalExtension();
        }

        if ($request->has('interior_img')) {

            $images = $request->file('interior_img');
            $filenames = [];
            foreach ($images as $image) {
                $name = '/products/' . date('FY') . '/' . \Str::random();
                $filenames[] = $name . '.' . $image->getClientOriginalExtension();
                $result_img = \Image::make($image->getRealPath())->encode($image->getClientOriginalExtension(), 100);
                $result_imgWeb = \Image::make($image->getRealPath())->encode($image->getClientOriginalExtension(), 100)->encode('webp');
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '.' . $image->getClientOriginalExtension(), (string)$result_img, 'public');
                $result_img->save(storage_path('app/public/').$name.'.'.$image->getClientOriginalExtension());
                $result_imgWeb->save(storage_path('app/public/').$name.'.webp');

            }
            $product->interior_img = json_encode($filenames);
        }

        if ($request->has('images')) {

            $images = $request->file('images');

            $filenames = [];
            foreach ($images as $image) {
                $name = '/products/' . date('FY') . '/' . \Str::random();
                $result = \Image::make($image->getRealPath());
                $resultWeb = \Image::make($image->getRealPath())->encode('webp');
                $result_thumb = \Image::make($image->getRealPath())->resize(null, 90, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $result_thumbWeb = \Image::make($image->getRealPath())->encode('webp')->resize(null, 90, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $filenames[] = $name . '.' . $image->getClientOriginalExtension();
                $result->save(storage_path('app/public/') . $name . '.' . $image->getClientOriginalExtension());
                $resultWeb->save(storage_path('app/public/') . $name . '.webp');
                $result_thumb->save(storage_path('app/public/') . $name . '-small.' . $image->getClientOriginalExtension());
                $result_thumbWeb->save(storage_path('app/public/') . $name . '-small.webp');
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '.' . $image->getClientOriginalExtension(), (string)$result, 'public');
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '-small.'. $image->getClientOriginalExtension(), (string)$result_thumb, 'public');
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '-small.webp', (string)$result_thumbWeb, 'public');
            }

            $product->images = json_encode($filenames);


        }


        $charsRu = [];
        $charvaluesRu = [];
        $characteristicsRu = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'charRu_value') !== false) {
                $charvaluesRu[] = $request->get($key);
            }
            if (strpos($key, 'charRu') !== false && strpos($key, 'charRu_value') === false) {
                $charsRu[] = $request->get($key);
            }
        }
        foreach ($charsRu as $k => $char) {
            $characteristicsRu[] = ['name' => $charsRu[$k], 'value' => $charvaluesRu[$k]];
        }

        $product->characteristics = serialize($characteristicsRu);
        $product->update();

        $charsKz = [];
        $charvaluesKz = [];
        $characteristicsKz = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'charKz_value') !== false) {
                $charvaluesKz[] = $request->get($key);
            }
            if (strpos($key, 'charKz') !== false && strpos($key, 'charKz_value') === false) {
                $charsKz[] = $request->get($key);
            }
        }
        foreach ($charsKz as $k => $char) {
            $characteristicsKz[] = ['name' => $charsKz[$k], 'value' => $charvaluesKz[$k]];
        }
        $name = json_decode($request->get('name_i18n'));
        $excerpt = json_decode($request->get('excerpt_i18n'));
        $seo_title = json_decode($request->get('seo_title_i18n'));
        $meta_keywords = json_decode($request->get('meta_keywords_i18n'));
        $meta_description = json_decode($request->get('meta_description_i18n'));

        $productT = $product->translate('kz');
        $productT->characteristics = serialize($characteristicsKz);
        $productT->name = $name->kz;
        $productT->excerpt = $excerpt->kz;
        $productT->meta_description = $meta_description->kz;
        $productT->meta_keywords = $meta_keywords->kz;
        $productT->seo_title = $seo_title->kz;
        $productT->save();

        $optionsRu = [];
        $valuesRu = [];
        $colorsRu = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'option_valueRu') !== false && strpos($key, 'colorRu') === false) {
                $valuesRu[] = $request->get($key);
            }
            if (strpos($key, 'optionRu') !== false && strpos($key, 'option_valueRu') === false) {
                $optionsRu[] = $request->get($key);
            }

            if (strpos($key, 'colorRu') !== false) {
                $colorsRu[] = $request->get($key);
            }

        }

        $optionsKz = [];
        $valuesKz = [];
        $colorsKz = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'option_valueKz') !== false && strpos($key, 'colorKz') === false) {
                $valuesKz[] = $request->get($key);
            }
            if (strpos($key, 'optionKz') !== false && strpos($key, 'option_valueKz') === false) {
                $optionsKz[] = $request->get($key);
            }

            if (strpos($key, 'colorKz') !== false) {
                $colorsKz[] = $request->get($key);
            }

        }

        foreach ($optionsRu as $k => $option) {
            if ($product->hasOption($option)) {
                $productOption = ProductOption::where('product_id', $product->id)->where('option', $option)->first();
            } else {
                $productOption = new ProductOption();
            }
            $productOption->product_id = $product->id;
            $productOption->option = $option;
            $productOption->value = $valuesRu[$k];
            if (count($colorsRu) > 0) {
                $productOption->value_color = $colorsRu[$k];
            }
            $productOption->save();
            if (count($optionsKz) && count($valuesKz) && array_key_exists($k, $optionsKz)) {
                $productOptionT = $productOption->translate('kz');
                $productOptionT->option = $optionsKz[$k];
                $productOptionT->value = $valuesKz[$k];
                if (count($colorsKz) > 0) {
                    $productOptionT->value_color = $colorsKz[$k];
                }
                $productOptionT->save();
            }
        }
        $variations = $request->get('variations');
        if ($request->has('variations')) {
            $items = Product::whereIn('sku', $request->get('variations'))->get();
            foreach ($items as $item) {
                $subVars = $variations;
                if ($item && ($key = array_search($item->sku, $subVars)) !== false) {
                    unset($subVars[$key]);
                }
                $subVars[] = (string)$product->sku;
                $item->variation_id = serialize(array_values($subVars));
                $item->update();
            }

        }

        return redirect()
            ->route("voyager.products.index")
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " {$product->name}",
                'alert-type' => 'success',
            ]);
    }

    public function store(Request $request)
    {
        $name = json_decode($request->get('name_i18n'));
        $excerpt = json_decode($request->get('excerpt_i18n'));
        $seo_title = json_decode($request->get('seo_title_i18n'));
        $meta_keywords = json_decode($request->get('meta_keywords_i18n'));
        $meta_description = json_decode($request->get('meta_description_i18n'));

        $product = new Product();
        $product->name = $name->ru;
        $product->brand = $request->get('brand');
        $product->sku = trim($request->get('sku'));
        $product->category_id = $request->get('category_id');
        $product->regular_price = $request->get('regular_price');
        $product->sale_price = $request->get('sale_price');
        $product->excerpt = $excerpt->ru;
        $product->meta_description = strlen($meta_description->ru) > 1 ? $meta_description->ru : 'Купить ' . $name->ru . ' по лучшим ценам в компании Dveri-city';
        $product->meta_keywords = strlen($meta_keywords->ru) > 1 ? $meta_keywords->ru : $name->ru;
        $product->seo_title = strlen($seo_title->ru) > 1 ? $seo_title->ru : 'Купить ' . $name->ru;
        $product->featured = ($request->has('featured') && $request->get('featured') == 'on') ? true : false;
        $product->is_new = ($request->has('is_new') && $request->get('is_new') == 'on') ? true : false;
        $product->is_nestan = ($request->has('is_nestan') && $request->get('is_nestan') == 'on') ? true : false;
        $product->stock_count = $request->get('stock_count');
        $product->slug = $request->get('slug');
        if ($request->has('variations')) {
            $product->variation_id = serialize($request->get('variations'));
        }

        if (!file_exists(public_path('storage/products/' . date('FY') . '/'))) {
            mkdir(public_path('storage/products/' . date('FY') . '/'));
        }

        if ($request->has('thumb')) {

            $image = $request->file('thumb');
            $filename = '/products/' . date('FY') . '/' . \Str::random();
            $result_img = \Image::make($image->getRealPath());
            $result_imgWeb = \Image::make($image->getRealPath())->encode('webp');
            $result_thumb = \Image::make($image->getRealPath())->resize(null, 90, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $result_thumbWeb = \Image::make($image->getRealPath())->encode('webp')->resize(null, 90, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
//            \Storage::disk(config('voyager.storage.disk'))->put($filename . '.' . $image->getClientOriginalExtension(), (string)$result_img, 'public');
//            \Storage::disk(config('voyager.storage.disk'))->put($filename . '-small.'. $image->getClientOriginalExtension(), (string)$result_thumb, 'public');
//            \Storage::disk(config('voyager.storage.disk'))->put($filename . '-small.webp', (string)$result_thumbWeb, 'public');
            $result_img->save(storage_path('app/public/') . $filename . '.' . $image->getClientOriginalExtension());
            $result_imgWeb->save(storage_path('app/public/') . $filename . '.webp');
            $result_thumb->save(storage_path('app/public/') . $filename . '-small.' . $image->getClientOriginalExtension());
            $result_thumbWeb->save(storage_path('app/public/') . $filename . '-small.webp');

            $product->thumb = $filename . '.' . $image->getClientOriginalExtension();
        }

        if ($request->has('interior_img')) {

            $images = $request->file('interior_img');
            $filenames = [];
            foreach ($images as $image) {
                $name = '/products/' . date('FY') . '/' . \Str::random();
                $filenames[] = $name . '.' . $image->getClientOriginalExtension();
                $result_img = \Image::make($image->getRealPath());
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '.' . $image->getClientOriginalExtension(), (string)$result_img, 'public');
                $result_img->save(storage_path('app/public/').$name.'.'.$image->getClientOriginalExtension());
            }
            $product->interior_img = json_encode($filenames);
        }

        if ($request->has('images')) {

            $images = $request->file('images');

            $filenames = [];
            foreach ($images as $image) {
                $name = '/products/' . date('FY') . '/' . \Str::random();
                $result = \Image::make($image->getRealPath());
                $resultWeb = \Image::make($image->getRealPath())->encode('webp');
                $result_thumb = \Image::make($image->getRealPath())->resize(null, 90, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $result_thumbWeb = \Image::make($image->getRealPath())->encode('webp')->resize(null, 90, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $filenames[] = $name . '.' . $image->getClientOriginalExtension();
                $result->save(storage_path('app/public/') . $name . '.' . $image->getClientOriginalExtension());
                $resultWeb->save(storage_path('app/public/') . $name . '.webp');
                $result_thumb->save(storage_path('app/public/') . $name . '-small.' . $image->getClientOriginalExtension());
                $result_thumbWeb->save(storage_path('app/public/') . $name . '-small.webp');
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '.' . $image->getClientOriginalExtension(), (string)$result, 'public');
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '-small.' . $image->getClientOriginalExtension(), (string)$result_thumb, 'public');
//                \Storage::disk(config('voyager.storage.disk'))->put($name . '-small.webp', (string)$result_thumbWeb, 'public');
            }

            $product->images = json_encode($filenames);


        }


        $charsRu = [];
        $charvaluesRu = [];
        $characteristicsRu = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'charRu_value') !== false) {
                $charvaluesRu[] = $request->get($key);
            }
            if (strpos($key, 'charRu') !== false && strpos($key, 'charRu_value') === false) {
                $charsRu[] = $request->get($key);
            }
        }
        foreach ($charsRu as $k => $char) {
            $characteristicsRu[] = ['name' => $charsRu[$k], 'value' => $charvaluesRu[$k]];
        }

        $product->characteristics = serialize($characteristicsRu);
        $product->save();

        $charsKz = [];
        $charvaluesKz = [];
        $characteristicsKz = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'charKz_value') !== false) {
                $charvaluesKz[] = $request->get($key);
            }
            if (strpos($key, 'charKz') !== false && strpos($key, 'charKz_value') === false) {
                $charsKz[] = $request->get($key);
            }
        }
        foreach ($charsKz as $k => $char) {
            $characteristicsKz[] = ['name' => $charsKz[$k], 'value' => $charvaluesKz[$k]];
        }

        $name = json_decode($request->get('name_i18n'));
        $excerpt = json_decode($request->get('excerpt_i18n'));
        $seo_title = json_decode($request->get('seo_title_i18n'));
        $meta_keywords = json_decode($request->get('meta_keywords_i18n'));
        $meta_description = json_decode($request->get('meta_description_i18n'));

        $productT = $product->translate('kz');
        $productT->characteristics = serialize($characteristicsKz);
        $productT->name = $name->kz;
        $productT->excerpt = $excerpt->kz;
        $productT->meta_description = $meta_description->kz;
        $productT->meta_keywords = $meta_keywords->kz;
        $productT->seo_title = $seo_title->kz;
        $productT->save();

        $optionsRu = [];
        $valuesRu = [];
        $colorsRu = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'option_valueRu') !== false && strpos($key, 'colorRu') === false) {
                $valuesRu[] = $request->get($key);
            }
            if (strpos($key, 'optionRu') !== false && strpos($key, 'option_valueRu') === false) {
                $optionsRu[] = $request->get($key);
            }

            if (strpos($key, 'colorRu') !== false) {
                $colorsRu[] = $request->get($key);
            }

        }

        $optionsKz = [];
        $valuesKz = [];
        $colorsKz = [];
        foreach ($request->keys() as $key) {
            if (strpos($key, 'option_valueKz') !== false && strpos($key, 'colorKz') === false) {
                $valuesKz[] = $request->get($key);
            }
            if (strpos($key, 'optionKz') !== false && strpos($key, 'option_valueKz') === false) {
                $optionsKz[] = $request->get($key);
            }

            if (strpos($key, 'colorKz') !== false) {
                $colorsKz[] = $request->get($key);
            }

        }

        foreach ($optionsRu as $k => $option) {
            $productOption = new ProductOption();
            $productOption->product_id = $product->id;
            $productOption->option = $option;
            $productOption->value = $valuesRu[$k];
            if (count($colorsRu) > 0) {
                $productOption->value_color = $colorsRu[$k];
            }
            $productOption->save();
            if (count($optionsKz) && count($valuesKz) && array_key_exists($k, $optionsKz)) {
                $productOptionT = $productOption->translate('kz');
                $productOptionT->option = $optionsKz[$k];
                $productOptionT->value = $valuesKz[$k];
                if (count($colorsKz) > 0) {
                    $productOptionT->value_color = $colorsKz[$k];
                }
                $productOptionT->save();
            }

        }

        $variations = $request->get('variations');
        if ($request->has('variations')) {
            $items = Product::whereIn('sku', $request->get('variations'))->get();
            foreach ($items as $item) {
                $subVars = $variations;
                if ($item && ($key = array_search($item->sku, $subVars)) !== false) {
                    unset($subVars[$key]);
                }
                $subVars[] = (string)$product->sku;
                $item->variation_id = serialize(array_values($subVars));
                $item->update();
            }
        }

        return redirect()
            ->route("voyager.products.index")
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " {$product->name}",
                'alert-type' => 'success',
            ]);
    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = \Voyager::model('DataType')->where('slug', '=', $slug)->first();


        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        $dataTypeContent->setAttribute('optionsRu', $dataTypeContent->options->translate('ru', 'ru'));
        $dataTypeContent->setAttribute('optionsKz', $dataTypeContent->options->translate('kz', 'ru'));
        $dataTypeContent->setAttribute('charsRu', unserialize($dataTypeContent->getTranslatedAttribute('characteristics', 'ru', 'ru')));
        $dataTypeContent->setAttribute('charsKz', unserialize($dataTypeContent->getTranslatedAttribute('characteristics', 'kz', 'ru')));
        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }


        $variants = Product::where('id', '!=', $dataTypeContent->id)
            ->get();

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }


        return \Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'variants'));
    }

    public function orderUpdate(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        $order->status = $request->get('status');
        $order->update();

        return redirect()->route('voyager.orders.index')->with([
            'message' => __('voyager::generic.successfully_updated') . " {$order->name}",
            'alert-type' => 'success',
        ]);
    }


    public
    function exportToExcel(Request $request)
    {
        $fromDate = Carbon::parse($request->get('from'))->startOfDay();
        $toDate = Carbon::parse($request->get('to'))->endOfDay();
        $filename = $fromDate->format('dmY') . '-' . $toDate->format('dmY');

        return \Excel::download(new OrdersExport($fromDate, $toDate), $filename . '.xlsx');
    }

    public function importToExcel(Request $request)
    {
        $uploadedFile = $request->file('file-input');
        $filename = $uploadedFile->getClientOriginalName();
        $path = '/products/' . date('FY') . '/';

        \Storage::disk(config('voyager.storage.disk'))->putFileAs($path, $uploadedFile, $filename);

        if (!in_array($uploadedFile->getClientOriginalExtension(), ['csv', 'xlsx', 'xls'])) {
            return back()->with(['message' => 'Выберите excel файл формата xls',
                'alert-type' => 'error',]);
        } else {
            \Excel::import(new ProductImport(), storage_path('app/public/products/' . date('FY') . '/') . $filename);

            \Storage::disk(config('voyager.storage.disk'))->delete($path . $filename);
            return redirect()->back()->with(['message' => 'Импорт успешно завершен',
                'alert-type' => 'success',]);
        }

    }

    public function attachProductImages()
    {
        $products = Product::whereNotNull('thumb')->get();
        foreach ($products as $product) {
            $mainFile = public_path('storage') . $product->thumb;
            $mainPath = pathinfo($mainFile)['dirname'] . '/' . pathinfo($mainFile)['filename'];
            $xt = pathinfo($mainFile)['extension'];
            $filePath = str_replace('.' . $xt, '', $product->thumb);

            if (!file_exists($mainPath . '-small.' . $xt)) {
                $result_thumb = \Image::make($mainFile)->encode('jpg')->resize(null, 90, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                \Storage::disk(config('voyager.storage.disk'))->put($filePath . '-small.' . $xt, (string)$result_thumb, 'public');

            }
            if (!file_exists($mainPath . '-small.webp')) {
                $result_thumbWeb = \Image::make($mainFile)->encode('webp')->resize(null, 90, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                \Storage::disk(config('voyager.storage.disk'))->put($filePath . '-small.webp', (string)$result_thumbWeb, 'public');
            }
        }
        return redirect()->back()->with(['message' => 'Связка фото-товар успешно завершен',
            'alert-type' => 'success',]);
    }

    public function restoreMetaData()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product->meta_description = 'Купить ' . $product->name . ' по лучшим ценам в компании Dveri-city';
            $product->meta_keywords = $product->name;
            $product->seo_title = 'Купить ' . $product->name;
            $product->update();
        }
    }

}
