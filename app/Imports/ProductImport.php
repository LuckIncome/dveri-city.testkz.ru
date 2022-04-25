<?php

namespace App\Imports;

use App\Category;
use App\Product;
use App\ProductOption;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function model(array $row)
    {
        $chars = explode(';', $row['Характеристики']);
        $arrayChars = [];
        foreach ($chars as $char) {
            $name = explode('__', $char)[0];
            $value = explode('__', $char)[1];
            $arrayChars[] = ['name' => $name, 'value' => $value];
        }

        $product = Product::updateOrCreate([
            'name' => $row['Название'],
            'brand' => $row['Бренд'],
            'category_id' => Category::where('name', $row['Категория'])->exists() ? Category::where('name', $row['Категория'])->first()->id : 0,
            'regular_price' => $row['Цена'],
            'sale_price' => $row['Скидочная цена'],
            'thumb' => $row['Фото'],
            'images' => json_encode(explode(';', $row['Галерея'])),
            'excerpt' => $row['Описание'],
            'slug' => Product::slugify($row['Название']),
            'stock_count' => $row['Остаток'],
            'sku' => $row['Артикул'],
            'variation_id' => serialize(explode(';', $row['Вариации'])),
            'featured' => ($row['Хит'] == 'Да'),
            'is_new' => ($row['Новинка'] == 'Да'),
            'meta_description' => 'Купить ' . $row['Название'] . ' по лучшим ценам в компании Dveri-city',
            'meta_keywords' => $row['Название'],
            'seo_title' => 'Купить ' . $row['Название'],
            'characteristics' => serialize($arrayChars),
        ]);

        $optionsRu = explode(';', $row['Опции']);

        foreach ($optionsRu as $k => $option) {
            if (ProductOption::where('product_id', $product->id)->where('option', explode('__', $option)[0])->exists()) {
                $productOption = ProductOption::where('product_id', $product->id)->where('option', explode('__', $option)[0])->first();
            } else {
                $productOption = new ProductOption();
            }
            $productOption->option = explode('__', $option)[0];
            $productOption->value = explode('__', $option)[1];
            $productOption->value_color = array_key_exists(2, explode('__', $option)) ? explode('__', $option)[2] : null;
            $productOption->product_id = $product->id;
            $productOption->save();
        }

        return $product;
    }
}
