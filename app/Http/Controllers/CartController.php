<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderEntity;
use App\OrderProduct;
use App\Payment;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Paybox\Pay\Facade as Paybox;

class CartController extends Controller
{
    public function addToCart($productId)
    {
        $product = Product::with('options')->whereId($productId)->first();
        if ($product->sale_price) {
            $price = $product->sale_price;
        } else {
            $price = $product->regular_price;
        }
        \Cart::add(['id' => $product->id, 'name' => $product->slug, 'quantity' => 1, 'price' => $price,
            'attributes' => [
                'thumbnail' => $product->thumb,
                'name' => $product->name,
                'stock_count' => $product->stock_count,
                'is_new' => $product->is_new,
                'options' => $product->options,
                'regular_price' => ($product->sale_price) ? $product->regular_price : false,
                'link' => '/catalog/' . $product->category->slug . '/' . $product->slug
            ]]);
        $cart = \Cart::getContent();
        return response()->json(['cart' => $cart]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCart(Request $request)
    {
        if ($request->get('itemQty') == 0) {
            \Cart::remove($request->get('itemId'));
        } else {
            \Cart::update($request->get('itemId'), ['quantity' => ['relative' => false, 'value' => $request->get('itemQty')]]);
        }

        $products = \Cart::getContent();
        $subtotal = \Cart::getTotal();
        $itemsCount = \Cart::getTotalQuantity();
        foreach ($products as $product) {
            $product->attributes['image_link'] = \Voyager::image($product->attributes['thumbnail']);
        }
        return response()->json(['products' => $products, 'subtotal' => $subtotal, 'itemsCount' => $itemsCount]);
    }

    public function removeFromCart(Request $request)
    {
        \Cart::remove($request->get('itemId'));

        $products = \Cart::getContent();
        $subtotal = \Cart::getTotal();
        $itemsCount = \Cart::getTotalQuantity();
        foreach ($products as $product) {
            $product->attributes['image_link'] = \Voyager::image($product->attributes['thumbnail']);
        }
        return response()->json(['products' => $products, 'subtotal' => $subtotal, 'itemsCount' => $itemsCount]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $cart = \Cart::getContent();
        $subtotal = \Cart::getSubTotal();
        $cartItems = $cart->count();

        return view('cart.index', compact('cart', 'subtotal', 'cartItems'));
    }

    public function getCartContent()
    {
        $products = \Cart::getContent();
        $subtotal = \Cart::getTotal();
        $itemsCount = \Cart::getTotalQuantity();
        foreach ($products as $product) {
            $product->attributes['image_link'] = \Voyager::image($product->attributes['thumbnail']);
        }
        return response()->json(['products' => $products, 'subtotal' => $subtotal, 'itemsCount' => $itemsCount]);
    }

    public function getCartItems()
    {
        return response()->json(['cartItems' => \Cart::getTotalQuantity()]);
    }

    public function destroyCart()
    {
        \Cart::clear();
        return response()->json(['products' => null, 'subtotal' => 0, 'itemsCount' => 0]);
    }

    public function checkoutIndex()
    {
        if (\Cart::isEmpty()) {
            return redirect(route('cart.index'));
        }
        return view('cart.checkout');
    }

    public function checkoutSubmit(Request $request)
    {
        $isEntity = ($request->has('is-entity') && $request->get('is-entity') == 'on');
        $companyFields = [];
        $address = '';
        foreach ($request->keys() as $key) {
            if (strpos($key, 'company') !== false) {
                $companyFields[$key] = $request->get($key);
            }
            if (strpos(strtolower($key), 'address') !== false) {
                $address = $request->get($key);
            }
        }
        $email = $request->get('email');
        $name = $request->get('name');
        $phone = $request->get('phone');
        $payment_type = $request->get('payment');
        $delivery_type = $request->get('delivery');
        $comments = $request->get('comments');
        $total = \Cart::getTotal();
        if ($total > 0) {
            $order = new Order();
            $order->user_email = $email;
            $order->user_name = $name;
            $order->user_phone = $phone;
            $order->order_comments = $comments;
            $order->is_entity = $isEntity;

            $order->user_address = $address;

            $order->payment_type = $payment_type;
            $order->delivery_type = $delivery_type;

            $order->amount = $total;
            $order->confirmed = in_array($request->get('payment'), ['cash', 'card']);
            $order->save();

            if (count($companyFields) && $isEntity) {
                $orderEntity = new OrderEntity();
                $orderEntity->order_id = $order->id;
                $orderEntity->name = $companyFields['companyName'];
                $orderEntity->bin = $companyFields['companyBin'];
                $orderEntity->bik = $companyFields['companyBik'];
                $orderEntity->iik = $companyFields['companyIik'];
                $orderEntity->address = $companyFields['companyAddress'];
                $orderEntity->save();
            }

            $products = \Cart::getContent();

            foreach ($products as $product) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product['id'];
                $orderProduct->product_count = $product['quantity'];
                $orderProduct->product_price = $product['price'];
                $orderProduct->save();
            }

            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->amount = $total;
            $payment->type = $payment_type;
            $payment->confirmed = in_array($request->get('payment'), ['cash', 'card']);
            $payment->save();

            if ($order->confirmed) {
                $orderedProducts = [];
                foreach ($order->orderProducts as $orderProduct) {
                    $orderProduct->product->stock_count = $orderProduct->product->stock_count - $orderProduct->product_count;
                    $orderProduct->product->update();
                    $product = Product::find($orderProduct->product_id);
                    $product->setAttribute('qty', $orderProduct->product_count);
                    $product->setAttribute('product_price', $orderProduct->product_price);
                    $orderedProducts[] = $product;
                }

                $users = User::where('role_id', 1)->select('email')->get()->pluck('email')->toArray();
                $firstUser = $users[0];
                if (($key = array_search($firstUser, $users)) !== false) {
                    unset($users[$key]);
                }

                \Mail::send('emails.newOrder', ['order' => $order, 'products' => $orderedProducts, 'payment' => $payment], function ($m) use ($users, $firstUser) {
                    $m->to($firstUser)
                        ->cc($users)
                        ->subject('Новый заказ с сайта DveriCity');
                });

                \Mail::send('emails.thanksOrder', ['order' => $order, 'products' => $orderedProducts, 'payment' => $payment], function ($m) use ($order) {
                    $m->to($order->user_email)
                        ->subject('Ваш заказ с сайта Dveri-City.kz');
                });
            }

            if (in_array($request->get('payment'), ['cash', 'card'])) {
                \Cart::clear();
                return redirect()->route('cart.checkout.thanks', $order->id);
            } else {
                return $this->cardPay($order);
            }

        } else {
            return redirect()->route('cart.index');
        }

    }

    private function cardPay($order)
    {
        $order = Order::find($order->id);

        $paybox = new Paybox();
        $paybox->merchant->id = Payment::MERCHANT_ID;
        $paybox->merchant->secretKey = Payment::SECRET_KEY;
        $paybox->merchant->salt = 'j7aBIZrlGrbLroEo';
        $paybox->config->currency = 'KZT';
        $paybox->config->resultUrl = config('app.url') . '/api/online/saveTransaction';
        $paybox->config->successUrl = config('app.url') . '/online/successTransaction';
        $paybox->config->stateUrl = config('app.url') . '/api/online/stateTransaction';
        $paybox->config->stateUrlMethod = 'POST';
        $paybox->config->successUrlMethod = 'POST';
        $paybox->config->failureUrl = config('app.url') . '/online/failureTransaction';
        $paybox->config->failureUrlMethod = "POST";
        $paybox->config->siteUrl = config('app.url');
        $paybox->order->id = $order->id;
        $paybox->order->description = 'Покупка с сайта Dveri-city.kz';
        $paybox->order->amount = $order->amount;
        $paybox->customer->userEmail = $order->user_email;
        $paybox->customer->phone = (int)filter_var($order->user_phone, FILTER_SANITIZE_NUMBER_INT);;

        $paybox->config->isTestingMode = false;

        if ($paybox->init()) {
            header('Location:' . $paybox->redirectUrl);
        }
        exit;
    }

    public function checkoutThanks($orderId)
    {
        $order = Order::find($orderId);
        if (!$order->confirmed) {
            return redirect()->route('cart.checkout');
        }

        \Cart::clear();

        $orderedProducts = [];
        foreach ($order->orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            $product->setAttribute('qty', $orderProduct->product_count);
            $product->setAttribute('product_price', $orderProduct->product_price);
            $orderedProducts[] = $product;
        }

        return view('cart.thanks', compact('order', 'orderedProducts'));
    }
}
