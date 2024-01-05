<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderTime;
use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutRequest;
use App\Models\Order;
use App\Models\Package;
use App\Services\PayriffService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{


    public function package(CheckoutRequest $request, PayriffService $paymentGateway)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $package = Package::find($data['package_id']);
            $user = auth()->user();
            $order = Order::create([
                'total_amount' => $package->price,
                'email' => $user->email,
                'user_id' => $user->id,
                'package_id' => $package->id,
                'order_status_id' => OrderType::PENDING,
                'ip_address' => ipfind(),
            ]);

            $paymentPageUrl = $paymentGateway->createOrder(
                $order->total_amount,             // amount
                $order->id,    // description
                'AZN',             // currency
                'AZ',               // language
                route('frontend.checkout.approved'),   // aprroveUrl
                route('frontend.checkout.canceled'),   // cancelUrl
                route('frontend.checkout.declined')   // declineUrl
            );
            DB::commit();

            $paymentUrl = $paymentPageUrl->paymentUrl;

            $order_id = $paymentPageUrl->orderId;
            $session_id = $paymentPageUrl->sessionId;

            $order->update([
                'order_id' => $order_id,
                'session_id' => $session_id,
            ]);
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            DB::rollback();
            info($e->getMessage());
            return view('frontend.payment.error');
        }
    }


    public function approved(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!empty($data['code']) && $data['code'] == '00000') {
                $order_id = $data['payload']['orderDescription'];
                $order = Order::findOrFail($order_id);
                $option = $order->package->expiration_date;
                switch ($option) {
                    case OrderTime::FOR_A_MONTH:
                        $order->expiration_date = now()->addMonths(1);
                        break;
                    case OrderTime::FOR_3_MONTHS:
                        $order->expiration_date = now()->addMonths(3);
                        break;
                    case OrderTime::FOR_A_YEAR:
                        $order->expiration_date = now()->addYears(1);
                        break;

                    default:
                        $order->expiration_date = null;
                        break;
                }
                $order->order_status_id = \App\Enums\OrderType::APPROVED;
                $order->save();
            }
        }

        return view('frontend.payment.success');
    }

    public function declined(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!empty($data['code']) && $data['code'] != '00000') {
                $order_id = $data['payload']['orderDescription'];
                $order = Order::findOrFail($order_id);
                $order->update(['order_status_id' => \App\Enums\OrderType::FAILED]);
            }
        }

        return view('frontend.payment.error');
    }

    public function canceled(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!empty($data['code']) && $data['code'] != '00000') {
                $order_id = $data['payload']['orderDescription'];
                $order = Order::findOrFail($order_id);
                $order->update(['order_status_id' => \App\Enums\OrderType::CANCELLED]);
            }
        }

        return view('frontend.payment.error');
    }
}
