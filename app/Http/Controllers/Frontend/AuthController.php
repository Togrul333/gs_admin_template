<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use App\Services\PayriffService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

//    public function loginForm()
//    {
//        return view('frontend.auth.login');
//    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            if (auth('web')->attempt($credentials)) {
                $url = redirect_url_by_user();
                if (!$request->ajax()) {
                    return redirect()->route($url);
                }
                return $this->jsonSuccess(trans('backend.messages.success.login'), [
                    'redirect' => route($url),
                ]);
            }
            return $this->jsonError('', [
                'message' => trans('backend.messages.warning.login'),
                'message_error' => trans('backend.messages.warning.login')
            ], 500);
        } catch (Exception $e) {
            Log::channel('frontend')->error($e->getMessage());
            return $this->jsonError('', [
                'message' => trans('backend.messages.warning.login'),
                'message_error' => trans('backend.messages.warning.login')
            ], 500);
        }
    }

    public function registerForm()
    {
        $packages = Package::get();
        return view('frontend.auth.register_form', compact('packages'));
    }

    public function register(RegisterRequest $request, PayriffService $paymentGateway)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $user = User::create([
                'full_name' => $data['full_name'],
                'number' => $data['number'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            DB::commit();
            Auth::login($user);

            if (isset($data['package_id']) && $data['package_id'] !== 'null') {
                $package = Package::find($data['package_id']);
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
                return $this->jsonSuccess(trans('backend.messages.success.login'), [
                    'redirect' => $paymentUrl,
                ]);
            }

            return $this->jsonSuccess(trans('backend.messages.success.login'), [
                'redirect' => route('frontend.dashboard'),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Auth::logout();
            dd($e->getMessage());
            Log::channel('frontend')->error($e->getMessage());
            return $this->jsonError('', [
                'message_error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            auth('web')->logout();
            return redirect(route('frontend.login.form'))->withSuccess(trans('backend.messages.success.logout'));
        } catch (Exception $e) {
            Log::channel('backend')->error($e->getMessage());
            return back()->withError(trans('backend.messages.error.logout'));
        }
    }
}
