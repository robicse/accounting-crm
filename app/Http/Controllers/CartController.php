<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductPurchaseDetail;
use App\Stock;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $barcode = $request->barcode;
        $store_id = $request->store_id;
        $data = array();
        if($barcode){
            $product_check_exists = Product::where('barcode',$barcode)->pluck('id')->first();
            if($product_check_exists){
                //$product_current_stock_check_exists = Stock::where('product_id',$product_check_exists)->latest()->pluck('current_stock')->first();
                $product_current_stock_check_exists = Stock::where('product_id',$product_check_exists)->where('store_id',$store_id)->latest()->pluck('current_stock')->first();
                if($product_current_stock_check_exists > 0){
                    $data['product_check_exists'] = 'Product Found!';
                    $product = DB::table('products')
                        ->where('barcode',$barcode)
                        ->first();

                    if(!empty($product)){
                        $price = ProductPurchaseDetail::where('product_id',$product->id)->latest()->pluck('mrp_price')->first();

                        $data['id'] = $product->id;
                        $data['name'] = $product->name;
                        $data['qty'] = 1;
                        $data['price'] = $price;
                        $data['options']['barcode'] = $barcode;
                        Cart::add($data);
                    }
                    $data['countCart'] = Cart::count();
                }else{
                    $data['product_check_exists'] = 'No Product Stock Found!';
                }
            }else{
                $data['product_check_exists'] = 'No Product Found!';
            }

        }
        return response()->json(['success'=> true, 'response'=>$data]);
    }

    public function deleteCartProduct($rowId){
        if($rowId){
            Cart::remove($rowId);
        }
        $info['success'] = true;
        echo json_encode($info);
    }

    public function deleteAllCartProduct(){

        Cart::destroy();
        $info['success'] = true;
        echo json_encode($info);
    }
}
