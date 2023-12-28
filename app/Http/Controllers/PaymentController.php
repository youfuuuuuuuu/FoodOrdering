<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use App\Models\myOrder;
use Auth;
use DB;
use Notification;
use App\Models\myCart;

class PaymentController extends Controller
{
    public function paymentPost(Request $request)
    {
	       
	Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->sub*100,   // RM10  10=10 cen 10*100=1000 cen
                "currency" => "MYR",
                "source" => $request->stripeToken,
                "description" => "This payment is testing purpose of southern online shopping",
        ]);
    $newOrder=myOrder::Create([           //Create order after payment has been made
        'paymentStatus'=>'Done',
        'userID'=>Auth::id(),
        'orderDate'=>now()->format('d-m-y'),      //d-m-y = day,month,year 
        'amount'=>$request->sub,
    ]);
    $orderID=DB::table('my_orders')->where('userID','=',Auth::id())
    ->orderBy('created_at','desc')->first();           //Retrieve orderID
    $items=$request->input('cid');
    foreach($items as $item=>$value){
        $cart=myCart::find($value);
        $cart->orderID=$orderID->id;
        $cart->save();
    }
    (new CartController)->cartItem();
    $email=Auth::user()->email;   //send to
    Notification::route('mail',$email)->notify(new
    \App\Notifications\orderPaid($email));

    return back();
    }
}