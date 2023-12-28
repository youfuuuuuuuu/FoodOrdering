<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function add(){
        $r=request();//get all form input value
        if($r->file('product-image')!=''){
            $image=$r->file('product-image');
            $image->move('images',$image->getClientOriginalName());   //images is the location  ￥              
            $imageName=$image->getClientOriginalName();
        }else{
            $imageName="empty.jpg";
        }
        $addproduct=Product::create([
            'name'=>$r->productName,
            'description'=>$r->description,
            'price'=>$r->price,
            'quantity'=>$r->quantity,
            'image'=>$imageName,
            'categoryID'=>$r->categoryID,
        ]);
        return redirect()->route('showProduct');
    }

    public function view(){                       //$viewAll=Product::all(); run SQL select * from products
        $viewAll=Product::paginate(10);            //$viewAll=Product::paginate(8); run SQL select (8) from products
        return view('showProduct')->with('products',$viewAll);
    }

    public function delete($id){
        $deleteProduct=Product::find($id);
        $deleteProduct->delete();
        return redirect()->route('showProduct');
    }

    public function edit($id){
        $editProduct=Product::all()->where('id',$id);
        return view('editProduct')->with('products',$editProduct);
    }

    public function update(){
        $r=request();//get all form input value
        $product=Product::find($r->pid);
        if($r->file('product-image')!=''){
            $image=$r->file('product-image');
            $image->move('images',$image->getClientOriginalName());
            $imageName=$image->getClientOriginalName();
            $product->image=$imageName;
        }
        $product->name=$r->productName;
        $product->description=$r->description;
        $product->price=$r->price;
        $product->categoryID=$r->categoryID;
        $product->quantity=$r->quantity;
        $product->save();
        return redirect()->route('showProduct');
    }

    public function showDetail($id){
        $showProduct=Product::all()->where('id',$id);
        return view('productDetails')->with('products',$showProduct);
    }

    public function search(){
        $r=request();
        $keyword=$r->keyword;
        $product=DB::table('products')->where('name','like','%'.$keyword.'%')->paginate(10);
        return view('showAllProduct')->with('products',$product);   //Select * from products where name like '%$keyword%'
    }

    public function productList(){
        $showProduct=Product::all();
        return view('showAllProduct')->with('products',$showProduct);
    }

    public function mainDish(){
        $showProduct=Product::all()->where('categoryID','=','1');
        return view('mainDish')->with('products',$showProduct);
    }

    public function sideDish(){
        $showProduct=Product::all()->where('categoryID','=','2');
        return view('sideDish')->with('products',$showProduct);
    }

    public function beverage(){
        $showProduct=Product::all()->where('categoryID','=','3');
        return view('beverage')->with('products',$showProduct);
    }

    public function dessert(){
        $showProduct=Product::all()->where('categoryID','=','4');
        return view('dessert')->with('products',$showProduct);
    }

    public function helpAndSupport(){
        $showProduct=Product::all();
        return view('helpAndSupport')->with('products',$showProduct);
    }
}