<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $plan = null;
        return view('dashboard', ['plan' => $plan, 'intent' => $user->createSetupIntent()]);
    }

    public function singlecharge(Request $request)
    {
        $amount = $request->amount*100;
        $paymentMethod = $request->payment_method;
        $user = Auth()->user();
        $user->CreateOrGetStripeCustomer();
        $paymentMethod = $user->addPaymentMethod($paymentMethod);
        $user->charge($amount, $paymentMethod->id);
        return redirect()->back();

    }
}
