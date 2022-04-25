<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Voyager\ContentTypes\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerSettingsController as BaseVoyagerSettingsController;
use TCG\Voyager\Http\Controllers\ContentTypes\Checkbox;
use TCG\Voyager\Http\Controllers\ContentTypes\Coordinates;
use TCG\Voyager\Http\Controllers\ContentTypes\File;
use TCG\Voyager\Http\Controllers\ContentTypes\MultipleCheckbox;
use App\Http\Controllers\Voyager\ContentTypes\MultipleImage;
use TCG\Voyager\Http\Controllers\ContentTypes\Password;
use TCG\Voyager\Http\Controllers\ContentTypes\Relationship;
use TCG\Voyager\Http\Controllers\ContentTypes\SelectMultiple;
use TCG\Voyager\Http\Controllers\ContentTypes\Text;
use TCG\Voyager\Http\Controllers\ContentTypes\Timestamp;
use TCG\Voyager\Traits\AlertsMessages;

class VoyagerSettingsController extends BaseVoyagerSettingsController
{

    public function store(Request $request)
    {
        // Check permission
        $this->authorize('add', Voyager::model('Setting'));

        $key = implode('.', [Str::slug($request->input('group')), $request->input('key')]);
        $key_check = Voyager::model('Setting')->where('key', $key)->get()->count();

        if ($key_check > 0) {
            return back()->with([
                'message'    => __('voyager::settings.key_already_exists', ['key' => $key]),
                'alert-type' => 'error',
            ]);
        }

        $lastSetting = Voyager::model('Setting')->orderBy('order', 'DESC')->first();

        if (is_null($lastSetting)) {
            $order = 0;
        } else {
            $order = intval($lastSetting->order) + 1;
        }

        $request->merge(['order' => $order]);
        $request->merge(['value' => '']);
        $request->merge(['key' => $key]);

        Voyager::model('Setting')->create($request->except('setting_tab'));

        request()->flashOnly('setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_created'),
            'alert-type' => 'success',
        ]);
    }

    public function update(Request $request)
    {
        // Check permission
        $this->authorize('edit', Voyager::model('Setting'));

        $settings = Voyager::model('Setting')->all();

        foreach ($settings as $setting) {
            $content = $this->getContentBasedOnType($request, 'settings', (object) [
                'type'    => $setting->type,
                'field'   => str_replace('.', '_', $setting->key),
                'group'   => $setting->group,
            ], $setting->details);

            if ($setting->type == 'image' && $content == null) {
                continue;
            }

            if ($setting->type == 'file' && $content == null) {
                continue;
            }

            $key = preg_replace('/^'.Str::slug($setting->group).'./i', '', $setting->key);

            $setting->group = $request->input(str_replace('.', '_', $setting->key).'_group');
            $setting->key = implode('.', [Str::slug($setting->group), $key]);
            $setting->value = $content;
            $setting->save();
        }

        request()->flashOnly('setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_saved'),
            'alert-type' => 'success',
        ]);
    }

    public function getContentBasedOnType(Request $request, $slug, $row, $options = null)
    {
        switch ($row->type) {
            /********** PASSWORD TYPE **********/
            case 'password':
                return (new Password($request, $slug, $row, $options))->handle();
            /********** CHECKBOX TYPE **********/
            case 'checkbox':
                return (new Checkbox($request, $slug, $row, $options))->handle();
            /********** MULTIPLE CHECKBOX TYPE **********/
            case 'multiple_checkbox':
                return (new MultipleCheckbox($request, $slug, $row, $options))->handle();
            /********** FILE TYPE **********/
            case 'file':
                return (new File($request, $slug, $row, $options))->handle();
            /********** MULTIPLE IMAGES TYPE **********/
            case 'multiple_images':
                return (new MultipleImage($request, $slug, $row, $options))->handle();
            /********** SELECT MULTIPLE TYPE **********/
            case 'select_multiple':
                return (new SelectMultiple($request, $slug, $row, $options))->handle();
            /********** IMAGE TYPE **********/
            case 'image':
                return (new Image($request, $slug, $row, $options))->handle();
            /********** DATE TYPE **********/
            case 'date':
                /********** TIMESTAMP TYPE **********/
            case 'timestamp':
                return (new Timestamp($request, $slug, $row, $options))->handle();
            /********** COORDINATES TYPE **********/
            case 'coordinates':
                return (new Coordinates($request, $slug, $row, $options))->handle();
            /********** RELATIONSHIPS TYPE **********/
            case 'relationship':
                return (new Relationship($request, $slug, $row, $options))->handle();
            /********** ALL OTHER TEXT TYPE **********/
            default:
                return (new Text($request, $slug, $row, $options))->handle();
        }
    }
}
