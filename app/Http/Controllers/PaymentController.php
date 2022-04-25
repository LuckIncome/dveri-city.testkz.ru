<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Paybox\Pay\Facade as Paybox;

class PaymentController extends Controller
{
    public function saveTransaction(Request $request)
    {
        \Log::info(json_encode($request->all()));

        $orderId = $request->get('pg_order_id');
        $payment = Payment::where('order_id',$orderId)->first();
        $payment->payment_id = $request->get('pg_payment_id');
        $payment->save();

        return response()->json(['pg_status' => 'ok', 'pg_salt' => $request->get('pg_salt'), 'pg_sig' => $request->get('pg_sig')]);
    }

    public function confirmOrder($orderId,$paymentId)
    {
        $paymentStatus = $this->checkPaymentStatus($orderId, $paymentId);
        if ($paymentStatus == 'ok') {
            $order = Order::find($orderId);
            if ($order->confirmed) {
                return redirect(route('cart.checkout.thanks', $orderId));
            }
            $order->confirmed = true;
            $order->save();

            $payment = Payment::where('order_id',$orderId)->first();
            $payment->order_id = $order->id;
            $payment->confirmed = true;
            $payment->payment_id = $paymentId;
            $payment->save();

            \Cart::clear();

            if (!session()->exists('orderId_timestamp')){
                session()->put('orderId_timestamp', $orderId.'_'.Carbon::now()->timestamp);
            }
            $this->sendEmailSuccess($order);

            return redirect(route('cart.checkout.thanks', $orderId));
        } elseif ($paymentStatus == 'pending') {
            return redirect(route('cart.checkout.awaiting', [$orderId, $paymentId]));
        } else {
            return redirect(route('cart.checkout'));
        }
    }


    public function successTransaction(Request $request)
    {
        return $this->confirmOrder($request->get('pg_order_id'), $request->get('pg_payment_id'));

    }

    public function checkPaymentStatus($orderId, $paymentId)
    {
        $paybox = new Paybox();
        $paybox->getMerchant()
            ->setId(Payment::MERCHANT_ID)
            ->setSecretKey(Payment::SECRET_KEY);
        $paybox->getPayment()
            ->setId($paymentId);

        $paybox->order->id = $orderId;

        return $paybox->getStatus();
    }

    public function checkOrderPaymentStatus($orderId, $paymentId)
    {
        $locale = session()->get('locale');
        $paybox = new Paybox();
        $paybox->getMerchant()
            ->setId(Payment::MERCHANT_ID)
            ->setSecretKey(Payment::SECRET_KEY);
        $paybox->getPayment()
            ->setId($paymentId);

        $paybox->order->id = $orderId;
        $statusId = $paybox->getStatus();
        switch ($statusId) {
            case 'pending':
                $status = ($locale=='ru') ? 'В ожидании оплаты' : 'Төлемді күтуде';
                break;
            case 'ok':
                $status = ($locale=='ru') ? 'Оплачено. Сейчас вы автоматически перейдете на страницу успешного заказа' : 'Төлем өтті. Қазір сіз автоматты түрде сәтті тапсырыс бетіне ауысасыз';
                break;
            case 'failed':
                $status = ($locale=='ru') ? 'Платеж не прошел' : 'Төлем өтпеді';
                break;
            case 'partial':
                $status = ($locale=='ru') ? 'Платеж не выполнен' : 'Төлем жасалынбады';
                break;
            default:
                $status = ($locale=='ru') ? 'Платеж не выполнен' : 'Төлем жасалынбады';
                break;
        }

        return response()->json(['paymentStatus' => $status, 'paymentStatusId' => $statusId]);
    }

    public function failureTransaction(Request $request)
    {
       return $this->confirmOrder($request->get('pg_order_id'), $request->get('pg_payment_id'));
    }

    public function checkoutAwaiting($orderId, $paymentId)
    {
        $paymentStatus = $this->checkPaymentStatus($orderId, $paymentId);
        if ($paymentStatus == 'ok') {
            $order = Order::find($orderId);
            if ($order->confirmed) {
                return redirect(route('cart.checkout.thanks', $orderId));
            }
            $order->confirmed = true;
            $order->save();

            $payment = Payment::where('order_id',$orderId)->first();
            $payment->order_id = $order->id;
            $payment->confirmed = true;
            $payment->payment_id = $paymentId;
            $payment->save();

            \Cart::clear();
            if (!session()->exists('orderId_timestamp')){
                session()->put('orderId_timestamp', $orderId.'_'.Carbon::now()->timestamp);
            }
            $this->sendEmailSuccess($order);

            return redirect(route('cart.checkout.thanks', $orderId));
        } elseif ($paymentStatus == 'pending') {
            return view('cart.awaiting', compact('orderId', 'paymentId', 'paymentStatus'));
        } else {
            return redirect(route('cart.checkout'));
        }

    }

    public function sendEmailSuccess($order)
    {
        $orderedProducts = [];
        foreach ($order->orderProducts as $orderProduct) {
            $orderProduct->product->stock_count = $orderProduct->product->stock_count - $orderProduct->product_count;
            $orderProduct->product->update();
            $product = Product::find($orderProduct->product_id);
            $product->setAttribute('qty', $orderProduct->product_count);
            $product->setAttribute('product_price', $orderProduct->product_price);
            $orderedProducts[] = $product;
        }

        $payment = $order->payment;

        $users = User::where('role_id', 1)->select('email')->get()->pluck('email')->toArray();
        

        \Mail::send('emails.newOrder', ['order' => $order, 'products' => $orderedProducts, 'payment' => $payment], function ($m) use ($users) {
            $m->to($users)
                ->subject('Новый заказ с сайта DveriCity');
        });

        \Mail::send('emails.thanksOrder', ['order' => $order, 'products' => $orderedProducts, 'payment' => $payment], function ($m) use ($order) {
            $m->to($order->user_email)
                ->subject('Ваш заказ с сайта Dveri-City.kz');
        });
    }

}
