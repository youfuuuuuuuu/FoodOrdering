<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use App\Models\myCart;
use Auth;    //user model
use Session;

class CartController extends Controller
{
    public function views(){
        $viewsAll=myCart::all();
        return views('myCart')->with('carts',$viewsAll);
    }

    public function delete($id) {
        $deleteCart=myCart::find($id);
        $deleteCart->delete();
        (new CartController)->cartItem();
        return redirect()->route('myCart');
    }
    

    public function __construct(){
        $this->middleware('auth');  //require login
    }

    public function add(){
        $r=request();     //get all form input value
        $add=myCart::create([

            'productID'=>$r->id,
            'quantity'=>$r->quantity,
            'orderID'=>'',
            'userID'=>Auth::id(),
        ]);
        (new CartController)->cartItem();
        Session::flash('success',"Item added to cart!");
        return redirect()->route('myCart');
    }

    public function showMyCart(){
        $cart=DB::table('my_carts')
        ->leftjoin('products','products.id','=','my_carts.productID')
        ->select('my_carts.quantity as cartQty','my_carts.id as cid','products.*')
        ->where('my_carts.orderID','=','')
        ->where('my_carts.userID','=',Auth::id())
        ->get();
        return view('myCart')->with('carts',$cart);
    }

    public function cartItem(){
        $cartItem=0;
        $noItem=DB::table('my_carts')->leftjoin('products','products.id','=','my_carts.productID')
        ->select(DB::raw('count(*) as count_item'))
        ->where('my_carts.orderID','=','')
        ->where('my_carts.userID','=',Auth::id())
        ->groupBy('my_carts.userID')
        ->first();
        if($noItem){
            $cartItem=$noItem->count_item;
        }
        Session()->put('cartItem',$cartItem);
    }
}
