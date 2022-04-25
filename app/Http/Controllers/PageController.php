<?php

namespace App\Http\Controllers;

use App\Category;
use App\Contact;
use App\Page;
use App\Partner;
use App\Post;
use App\Sale;
use App\Seopage;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getPage($slug)
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $page = Page::whereSlug($slug)->first();
        $seo_page = Seopage::where('slug', \Request::url());
        if ($seo_page->exists()) {
            $seoTitle = $page->seo_title ? $page->seo_title : ($seo_page->first()->meta_title ? $seo_page->first()->meta_title : $page->title);
            $keywords = $page->meta_keywords ? $page->meta_keywords : ($seo_page->first()->meta_keywords ? $seo_page->first()->meta_keywords : '');
            $description = $page->meta_description ? $page->meta_description : ($seo_page->first()->meta_description ? $seo_page->first()->meta_description : '');
            $seoText = $page->description ? $page->description : ($seo_page->first()->content ? $seo_page->first()->content : '');
        } else {
            $seoTitle = $page->seo_title ? $page->seo_title : $page->title;
            $keywords = $page->meta_keywords ? $page->meta_keywords : '';
            $description = $page->meta_description ? $page->meta_description : '';
            $seoText = $page->description ? $page->description : '';
        }

        $page->setAttribute('seo_title', $seoTitle);
        $page->setAttribute('meta_keywords', $keywords);
        $page->setAttribute('meta_description', $description);
        $page = $page->translate($locale, $fallbackLocale);
        if ($page->slug=='contacts'){
            $contacts = Contact::whereActive(true)->orderBy('sort_id')->get();
            return view('pages.contacts',compact('page','contacts'));
        }
        return view('pages.show', compact('page'));
    }

    public function getPartnersPage()
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $partners = Partner::with('translations')->get();
        $partners = $partners->translate($locale,$fallbackLocale);
        return view('pages.partners',compact('partners'));
    }

    public function setLocale($locale)
    {

        if (in_array($locale, config()->get('app.locales'))) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }

    public function sitemap()
    {
        $categories = Category::with('translations')->whereNotNull('parent_id')->get();
        $sales = Sale::with('translations')->where('status', Post::PUBLISHED)->get();
        return view('sitemap', compact('categories', 'sales'));
    }

    public function popupCallback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $users = User::where('role_id', 1)->select('email')->get()->pluck('email')->toArray();
            $firstUser = $users[0];
            if (($key = array_search($firstUser, $users)) !== false) {
                unset($users[$key]);
            }
//
//            $text = "Новая заявка на обратный звонок\n"
//                . "<b>Имя:</b>\n"
//                . "$request->name\n"
//                . "<b>Телефон:</b>\n"
//                . "$request->phone\n"
//                . "<b>Интересующая услуга:</b> \n"
//                . $request->get('serviceType');
//
//
//            Telegram::sendMessage([
//                'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
//                'parse_mode' => 'HTML',
//                'text' => $text
//            ]);

            Mail::send('emails.callback', [
                'name' => $request->name,
                'phone' => $request->phone,
            ], function ($m) use ($users, $firstUser) {
                $m->to($firstUser)
                    ->cc($users)
                    ->subject('Новая заявка на Обратный звонок');
            });
        }

        return response()->json(['success' => true]);

    }
}
