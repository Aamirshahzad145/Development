<?php

namespace App\Http\Controllers;

use DB;
use Stripe\Plan;
// use Stripe\Subscription;
use App\Models\plans;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Facades\Auth;

use Stripe\Stripe;
use Stripe\Customer;

class SuscriptionController extends Controller
{
    public function showplan()
    {
        return view('plans.plan');
    }
    public function saveplan(Request $request)
    {
        //-----config->services->stripe[] = 'stripe' here we can use any stripe key---//
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // dd($request);
        $amount = ($request->amount * 100);
        // Plan::create([
        //     'amount' => $amount,
        //     'currency' => $request->currency,
        //     'interval'=>$request->billing_period,
        //     'product' => [
        //         'name' => $request->plan_name,
        //     ]


        // ]);

        try{

            $plan = Plan::create([
                'amount' => $amount,
                'currency' => $request->currency,
                'interval'=>$request->billing_period,
                'interval_count' =>$request->interval_count,
                'product' => [
                    'name' => $request->plan_name,
                ]
    
    
            ]);
        }

        catch(\Exception $ex){
            dd($ex->getMessage());
        }

        // dd($plan);
        plans::create([
          'plan_id' => $plan->id,
          'plan_name' => $request->plan_name,
          'price' => $request->amount,
          'currency' => $plan->currency,
          'billing_method' => $plan->interval,
          'interval_count' => $plan->interval_count,
        ]);
        return 'Success';
    }

    public function showallPlan()
    {
        $id = Auth::user()->id;
        $sub_month[] = null;
        $sub_year[] = null;

        // $subscriptions = DB::table('subscriptions')
        //                     ->rightJoin('plans', 'subscriptions.stripe_price', '=', 'plans.plan_id')
        //                     ->where('user_id', '=', 'id')
        //                     ->orwhere('plans.billing_method', '=', 'month')
        //                     ->orwhere('plans.billing_method', '=', 'year')
        //                     ->select('plans.billing_method')
        //                     ->get();
        //                     dump($subscriptions);
        //                     foreach ($subscriptions as $data) {
        //                         $amir[] = $data->billing_method;
        //                     }
        // dd($amir);


        $subscription_month = Subscription::where('user_id', $id)->get();
        foreach ($subscription_month as $item_month) {
            $sub[] = $item_month->stripe_price ;
        }
        // dump($sub_month);
        // $subscription_year = Subscription::where('user_id', $id)->get();
        // foreach ($subscription_year as $item_year) {
        //     $sub_year[] = $item_year->stripe_price;
        // }
        // dd($sub_year);
        $basic_monthly = Plans::where('plan_name', '=', 'Basic')
                                ->where('billing_method', 'month')->first();
        $professional_monthly = Plans::where('plan_name', '=', 'Professional')
                               ->where('billing_method', 'month')->first();
        $enterprise_monthly = Plans::where('plan_name', '=', 'Enterprise')
                                ->where('billing_method', 'month')->first();
        $basic_yearly = Plans::where('plan_name', '=', 'Basic')
                                ->where('billing_method', 'year')->first();
        $professional_yearly = Plans::where('plan_name', '=', 'Professional')
                                ->where('billing_method', 'year')->first();
        $enterprise_yearly = Plans::where('plan_name', '=', 'Enterprise')
                                ->where('billing_method', 'year')->first();
        return view('plans.allPlan',['basic_monthly' => $basic_monthly, 'professional_monthly' => $professional_monthly, 'enterprise_monthly' => $enterprise_monthly, 'sub' => $sub, 'basic_yearly' => $basic_yearly, 'professional_yearly' => $professional_yearly, 'enterprise_yearly' => $enterprise_yearly]);
    }
    public function chackoutPlan(Request $request, $planid)
    {
        // dd($request);
        $user = Auth::user();
        // dd($user);
        $plan = Plans::where('plan_id', '=', $planid)->first();
        if(!$plan){
            return back()->withErrors([
                'message' => 'Plan not found'
            ]);
        }
        // dd($plan);
        return view('dashboard', ['plan' => $plan, 'intent' => $user->createSetupIntent()]);
    }

    public function processPlan(Request $request)
    {
        // dd($request);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // dd($request->all());
        $user = Auth::user();
        // $user = Cashier::findBillable($stripeId);
        $user->createOrGetStripeCustomer();
        $paymentMethod = null;
        $paymentMethod = $request->payment_method;
        if($paymentMethod != null){
            $paymentMethod  =  $user->addpaymentmethod($paymentMethod);
        }
        $plan = $request->plan_id;
        $name = Plans::where('plan_id', '=', $request->plan_id)->first();
        $data = $name->plan_name;
        // dd($data);
        try {
            $user->newSubscription(
                $data, $plan,
            )->create($paymentMethod != null ? $paymentMethod->id : '');
        }

        catch (\Exception $ex){
            return back()->withErrors([
                'error'=>'Unable To Create Subscription Due To This error: '.$ex->getMessage()
            ]);
        }
        $request->session()->flash('alert-success','You have successfully created a new subscription');
        // session()->flash('status', 'Some success message');
        return redirect()->route('subscription.show');
        // dd($paymentMethod);
        // return 'Success!';
    }

    Public function subscriptionshow()
    {
        // dd('connected');
        $user_id = Auth::user()->id;
        // dd($user_id);    
        $subscription = Subscription::where('user_id', $user_id)->get();
        // dd($subscription);
        return view('Subscription.subscription_table',['subscription' => $subscription]);
    }

    Public function cancelsubscription(Request $request)
    {
        // dd($request->all());
        $subscriptionName = $request->subscriptionName;
        // $subscriptionName = Subscription::where('id', $request)->get();
        // dd($subscriptionName);
        $user = Auth()->user();
        if($subscriptionName){
            $user->subscription($subscriptionName)->cancel();
            return "subscription cancelled";
        }
    }

    public function resumesubscription(Request $request)
    {
        // dd($request->all());
        $subscriptionName = $request->subscriptionName;
        // $subscriptionName = Subscription::where('id', $request)->get();
        // dd($subscriptionName);
        $user = Auth()->user();
        if($subscriptionName)
        {
            $user->subscription($subscriptionName)->resume();
            return "subscription resumed";
        }
    }
}