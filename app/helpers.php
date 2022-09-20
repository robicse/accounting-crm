<?php

use App\Stock;
use App\StockMinusLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('product_sale_return')) {
    function product_sale_return($store_id,$start_date= null, $end_date= null)
    {
        if($start_date != null && $end_date != null){
            $productSaleReturn = DB::table('product_sale_returns')
                ->select( DB::raw('SUM(total_return_amount) as total_return'))
                ->where('store_id',$store_id)
                ->where('created_at','>=',$start_date.' 00:00:00')
                ->where('created_at','<=',$end_date.' 23:59:59')
                ->first();
        }else{
            $productSaleReturn = DB::table('product_sale_returns')
                ->select( DB::raw('SUM(total_return_amount) as total_return'))
                ->where('store_id',$store_id)
                ->first();
        }

        $sum_total_sale_return = 0;
        if($productSaleReturn){
            $sum_total_sale_return = $productSaleReturn->total_return;
        }
//dd($sum_total_sale_return);
        return $sum_total_sale_return;
    }
}
if (!function_exists('product_sale')) {
    function product_sale($store_id,$start_date= null, $end_date= null)
    {
        if($start_date != null && $end_date != null){
            $productSale = DB::table('product_sales')
                ->select( DB::raw('SUM(total_amount) as total'))
                ->where('store_id',$store_id)
                ->where('created_at','>=',$start_date.' 00:00:00')
                ->where('created_at','<=',$end_date.' 23:59:59')
                ->first();
        }else{
            $productSale = DB::table('product_sales')
                ->select( DB::raw('SUM(total_amount) as total'))
                ->where('store_id',$store_id)
                ->first();
        }

        $sum_total_sale = 0;
        if($productSale){
            $sum_total_sale = $productSale->total;
        }
//dd($sum_total_sale);
        return $sum_total_sale;
    }
}
if (!function_exists('product_purchase')) {
    function product_purchase($store_id,$start_date= null, $end_date= null)
    {
        if($start_date != null && $end_date != null){
            $productPurchase = DB::table('product_purchases')
                ->select( DB::raw('SUM(total_amount) as total'))
                ->where('store_id',$store_id)
                ->where('created_at','>=',$start_date.' 00:00:00')
                ->where('created_at','<=',$end_date.' 23:59:59')
                ->first();
        }else{
            $productPurchase = DB::table('product_purchases')
                ->select( DB::raw('SUM(total_amount) as total'))
                ->where('store_id',$store_id)
                ->first();
        }

        $sum_total_purchase = 0;
        if($productPurchase){
            $sum_total_purchase = $productPurchase->total;
        }
//dd($sum_total_purchase);
        return $sum_total_purchase;
    }
}

if (!function_exists('product_purchase_return')) {
    function product_purchase_return($store_id,$start_date= null, $end_date= null)
    {
        if($start_date != null && $end_date != null){
            $productPurchaseReturn = DB::table('product_purchase_returns')
                ->select( DB::raw('SUM(total_return_amount) as total_amount'))
                ->where('store_id',$store_id)
                ->where('created_at','>=',$start_date.' 00:00:00')
                ->where('created_at','<=',$end_date.' 23:59:59')
                ->first();
        }else{
            $productPurchaseReturn = DB::table('product_purchase_returns')
                ->select( DB::raw('SUM(total_return_amount) as total_amount'))
                ->where('store_id',$store_id)
                ->first();
        }

        $sum_total_purchase_return = 0;
        if($productPurchaseReturn){
            $sum_total_purchase_return = $productPurchaseReturn->total_amount;
        }
//dd($sum_total_purchase_return);
        return $sum_total_purchase_return;
    }
}


if (!function_exists('product_sale_return_discount')) {
    function product_sale_return_discount($store_id,$start_date= null, $end_date=null)
    {
        if($start_date != null && $end_date != null){
            $productSaleReturnDiscount = DB::table('product_sale_returns')
                ->where('store_id',$store_id)
                ->where('created_at','>=',$start_date.' 00:00:00')
                ->where('created_at','<=',$end_date.' 23:59:59')
                ->select( DB::raw('SUM(discount_amount) as total_discount'))
                ->first();
        }else{
            $productSaleReturnDiscount = DB::table('product_sale_returns')
                ->select( DB::raw('SUM(discount_amount) as total_discount'))
                ->where('store_id',$store_id)
                ->first();
        }


        $sum_total_return_discount = 0;
        if($productSaleReturnDiscount){
            $sum_total_return_discount = $productSaleReturnDiscount->total_discount;
        }

        return $sum_total_return_discount;
    }
}


if(!function_exists('check_sale_return_qty')) {
    function check_sale_return_qty($store_id,$product_id,$sale_invoice_no)
    {
        $sale_return_qty = DB::table('product_sale_return_details')
            ->join('product_sale_returns','product_sale_return_details.product_sale_return_id','product_sale_returns.id')
            ->where('product_sale_returns.store_id',$store_id)
            ->where('product_sale_returns.sale_invoice_no',$sale_invoice_no)
            ->where('product_sale_return_details.product_id',$product_id)
            ->select(DB::raw('sum(product_sale_return_details.qty) as total_sale_return_qty'))
            ->first();

        return $sale_return_qty->total_sale_return_qty;

    }
}
if(!function_exists('check_sale_return_price')) {
    function check_sale_return_price($store_id,$product_id,$sale_invoice_no)
    {
        $sale_return_price = DB::table('product_sale_return_details')
            ->join('product_sale_returns','product_sale_return_details.product_sale_return_id','product_sale_returns.id')
            ->where('product_sale_returns.store_id',$store_id)
            ->where('product_sale_returns.sale_invoice_no',$sale_invoice_no)
            ->where('product_sale_return_details.product_id',$product_id)
            ->select(DB::raw('sum(product_sale_return_details.return_price) as total_sale_return_price'))
            ->first();

        return $sale_return_price->total_sale_return_price;

    }
}
if (!function_exists('check_purchase_return_qty')) {
    function check_purchase_return_qty($store_id,$product_id,$purchase_invoice_no)
    {
        $purchase_return_qty = DB::table('product_purchase_return_details')
            ->join('product_purchase_returns','product_purchase_return_details.product_purchase_return_id','product_purchase_returns.id')
            ->where('product_purchase_returns.store_id',$store_id)
            ->where('product_purchase_returns.purchase_invoice_no',$purchase_invoice_no)
            ->where('product_purchase_return_details.product_id',$product_id)
            ->select(DB::raw('sum(product_purchase_return_details.qty) as total_purchase_return_qty'))
            ->first();

        return $purchase_return_qty->total_purchase_return_qty;
    }
}
if (!function_exists('check_purchase_return_price')) {
    function check_purchase_return_price($store_id,$product_id,$purchase_invoice_no)
    {
        $purchase_return_price = DB::table('product_purchase_return_details')
            ->join('product_purchase_returns','product_purchase_return_details.product_purchase_return_id','product_purchase_returns.id')
            ->where('product_purchase_returns.store_id',$store_id)
            ->where('product_purchase_returns.purchase_invoice_no',$purchase_invoice_no)
            ->where('product_purchase_return_details.product_id',$product_id)
            ->select(DB::raw('sum(product_purchase_return_details.return_price) as total_purchase_return_price'))
            ->first();

        return $purchase_return_price->total_purchase_return_price;
    }
}


if (!function_exists('current_stock_row')) {
    function current_stock_row($store_id,$stock_type,$product_id)
    {
        return $current_stock_row = \App\Stock::where('store_id',$store_id)
            ->where('stock_type',$stock_type)
           // ->where('stock_product_type',$stock_product_type)
            ->where('product_id',$product_id)
            ->latest()->first();
    }
}

if (!function_exists('get_product_name_by_product_id')) {
    function get_product_name_by_product_id($product_id)
    {
        return \App\Product::where('id',$product_id)->pluck('name')->first();
    }
}

if (!function_exists('get_store_name_by_store_id')) {
    function get_store_name_by_store_id($store_id)
    {
        return \App\Store::where('id',$store_id)->pluck('name')->first();
    }
}

if (!function_exists('update_stock_for_edit_sale_stock')) {
    function update_stock_for_edit_sale_stock($id,$store_id,$stock_type,$new_request_qty,$invoice_sale_qty,$previous_current_stock,$product_id)
    {
        if($new_request_qty > $invoice_sale_qty){
            $stock_in = 0;
            $stock_out = $new_request_qty - $invoice_sale_qty;
            $current_stock = $previous_current_stock - $stock_out;
            $sale_type = 'Sale Qty Increased For Edit Stock';
        }else{
            $stock_in =  $invoice_sale_qty - $new_request_qty;
            $stock_out = 0;
            $current_stock = $previous_current_stock + $stock_in;
            $sale_type = 'Sale Qty Decreased For Edit Stock';
        }

        $stock_row = new Stock();
        $stock_row->ref_id = $id;
        $stock_row->user_id = Auth::id();
        $stock_row->store_id = $store_id;
        $stock_row->product_id = $product_id;
        $stock_row->sale_type = $sale_type;
        $stock_row->stock_type = $stock_type;
        $stock_row->previous_stock = $previous_current_stock;
        $stock_row->stock_in = $stock_in;
        $stock_row->stock_out = $stock_out;
        $stock_row->current_stock = $current_stock;
        $stock_row->date = date('Y-m-d');
        if($stock_row->save()){
            return true;
        }else{
            return false;
        }

    }
}

if (!function_exists('update_stock_for_edit_purchase_stock')) {
    function update_stock_for_edit_purchase_stock($id,$store_id,$stock_type,$new_request_qty,$invoice_purchase_qty,$previous_current_stock,$product_id)
    {
        if($new_request_qty > $invoice_purchase_qty){
            $stock_in = $new_request_qty - $invoice_purchase_qty;
            $stock_out = 0;
            $current_stock = $previous_current_stock + $stock_in;
            $sale_type = 'Purchase Qty Increased For Edit Stock';
        }else{
            $stock_in =  0;
            $stock_out = $invoice_purchase_qty - $new_request_qty;
            $current_stock = $previous_current_stock - $stock_out;
            $sale_type = 'Purchase Qty Decreased For Edit Stock';
        }

        $stock_row = new Stock();
        $stock_row->ref_id = $id;
        $stock_row->user_id = Auth::id();
        $stock_row->store_id = $store_id;
        $stock_row->product_id = $product_id;
        $stock_row->sale_type = $sale_type;
        $stock_row->stock_type = $stock_type;
        $stock_row->previous_stock = $previous_current_stock;
        $stock_row->stock_in = $stock_in;
        $stock_row->stock_out = $stock_out;
        $stock_row->current_stock = $current_stock;
        $stock_row->date = date('Y-m-d');
        if($stock_row->save()){
            return true;
        }else{
            return false;
        }

    }
}

if (!function_exists('delete_stock_and_sync_for_edit_sale_stock')) {
    function delete_stock_and_sync_for_edit_sale_stock($id,$previous_store_id,$new_store_id,$stock_type,$new_request_qty,$previous_current_stock,$product_id)
    {
        $stock = Stock::where('ref_id',$id)
            ->where('store_id',$previous_store_id)
            ->where('product_id',$product_id)
            ->where('stock_type','sale')
            ->first();
        if(!empty($stock)){
            product_store_stock_sync_after_delete_stock($product_id, $previous_store_id,$stock->id);
            $stock->delete();
        }

        $current_stock = $previous_current_stock - $new_request_qty;
        $sale_type = 'Sale Stock Qty Updated For Store Changed';

        $stock_row = new Stock();
        $stock_row->ref_id = $id;
        $stock_row->user_id = Auth::id();
        $stock_row->store_id = $new_store_id;
        $stock_row->product_id = $product_id;
        $stock_row->sale_type = $sale_type;
        $stock_row->stock_type = $stock_type;
        $stock_row->previous_stock = $previous_current_stock;
        $stock_row->stock_in = 0;
        $stock_row->stock_out = $new_request_qty;
        $stock_row->current_stock = $current_stock;
        $stock_row->date = date('Y-m-d');
        if($stock_row->save()){
            return true;
        }else{
            return false;
        }

    }
}

if (!function_exists('delete_stock_and_sync_for_edit_purchase_stock')) {
    function delete_stock_and_sync_for_edit_purchase_stock($id,$previous_store_id,$new_store_id,$stock_type,$new_request_qty,$previous_current_stock,$product_id)
    {
        $stock = Stock::where('ref_id',$id)
            ->where('store_id',$previous_store_id)
            ->where('product_id',$product_id)
            ->where('stock_type','purchase')
            ->first();
        if(!empty($stock)){
            product_store_stock_sync_after_delete_stock($product_id, $previous_store_id,$stock->id);
            $stock->delete();
        }

        $current_stock = $previous_current_stock + $new_request_qty;
        $sale_type = 'Purchase Stock Qty Updated For Store Changed';

        $stock_row = new Stock();
        $stock_row->ref_id = $id;
        $stock_row->user_id = Auth::id();
        $stock_row->store_id = $new_store_id;
        $stock_row->product_id = $product_id;
        $stock_row->sale_type = $sale_type;
        $stock_row->stock_type = $stock_type;
        $stock_row->previous_stock = $previous_current_stock;
        $stock_row->stock_in = $new_request_qty;
        $stock_row->stock_out = 0;
        $stock_row->current_stock = $current_stock;
        $stock_row->date = date('Y-m-d');
        if($stock_row->save()){
            return true;
        }else{
            return false;
        }

    }
}

if (!function_exists('stock_minus_log')) {
    function stock_minus_log($action_module,$action_done,$action_remarks)
    {
        $stock_minus_log = new StockMinusLog();
        $stock_minus_log->user_id=Auth::user()->id;
        $stock_minus_log->action_module=$action_module;
        $stock_minus_log->action_done=$action_done;
        $stock_minus_log->action_remarks=$action_remarks;
        $stock_minus_log->action_date=date('Y-m-d');
        if($stock_minus_log->save()){
            return true;
        }else{
            return false;
        }

    }
}

if (!function_exists('product_store_stock_sync')) {
    function product_store_stock_sync($product_id, $store_id)
    {
        $stock_data = Stock::where('product_id', $product_id)->where('store_id', $store_id)->get();
        $row_count = count($stock_data);
        if ($row_count > 0) {
            $store_previous_row_current_stock = null;
            $stock_in_flag = 0;
            $stock_out_flag = 0;

            foreach ($stock_data as $key => $data) {

                $id = $data->id;
                $previous_stock = $data->previous_stock;
                $stock_in = $data->stock_in;
                $stock_out = $data->stock_out;
                $current_stock = $data->current_stock;

                if ($key == 0) {
//                    echo 'row_id =>'.$id.'<br/>';
//                    echo 'product_id =>'.$product_id.'<br/>';
//                    echo 'store_id =>'.$store_id.'<br/>';
//
//                    echo 'store_previous_row_current_stock '.$store_previous_row_current_stock.'<br/>';
//                    echo 'this_row_current_stock =>'.$current_stock.'<br/>';
//                    echo '<br/>';


                    $stock = Stock::find($id);
                    $stock->previous_stock = 0;
                    $stock->current_stock = $stock_in;
                    $affectedRow = $stock->update();
                    if ($affectedRow) {
//                        echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                        echo '<br/>';
                        $current_stock = $stock->current_stock;
                    }

                } else {
//                    echo 'row_id =>'.$id.'<br/>';
//                    echo 'product_id =>'.$product_id.'<br/>';
//                    echo 'store_id =>'.$store_id.'<br/>';
//
//                    echo 'store_previous_row_current_stock '.$store_previous_row_current_stock.'<br/>';
//                    echo 'this_row_current_stock =>'.$current_stock.'<br/>';
//                    echo '<br/>';

                    // update part
                    if ($stock_in > 0) {
                        if ($stock_in_flag == 1) {
                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock + $stock_in;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else if ($previous_stock != $store_previous_row_current_stock) {
                            $stock_in_flag = 1;

                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock + $stock_in;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else {
//                            echo 'this_row_current_stock => nothing => '.$stock_in.'<br/>';
//                            echo '<br/>';
                        }
                    } else if ($stock_out > 0) {
                        if ($stock_out_flag == 1) {
                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock - $stock_out;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'This Row('.$id.') Current Stock => updated => ' . $stock_out . '<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else if ($previous_stock != $store_previous_row_current_stock) {
                            $stock_out_flag = 1;

                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock - $stock_out;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'This Row('.$id.') Current Stock => updated =>' . $stock_out . '<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else {
//                            echo 'this_row_current_stock => nothing => '.$stock_out.'<br/>';
//                            echo '<br/>';
                        }
                    } else {
//                        echo 'this_row_current_stock => nothing<br/>';
//                        echo '<br/>';
                    }
//                    echo '<br/>';
                }
                $store_previous_row_current_stock = $current_stock;
            }
        } else {
//            echo 'no found!'.'<br/>';
        }
    }
}

if (!function_exists('product_store_stock_sync_after_delete_stock')) {
    function product_store_stock_sync_after_delete_stock($product_id, $store_id,$stock_id)
    {
        $stock_data = Stock::where('product_id', $product_id)->where('store_id', $store_id)->where('id', '>',$stock_id)->get();
        $row_count = count($stock_data);
        if ($row_count > 0) {
            $store_previous_row_current_stock = null;
            $stock_in_flag = 0;
            $stock_out_flag = 0;

            foreach ($stock_data as $key => $data) {

                $id = $data->id;
                $previous_stock = $data->previous_stock;
                $stock_in = $data->stock_in;
                $stock_out = $data->stock_out;
                $current_stock = $data->current_stock;

                if ($key == 0) {
//                    echo 'row_id =>'.$id.'<br/>';
//                    echo 'product_id =>'.$product_id.'<br/>';
//                    echo 'store_id =>'.$store_id.'<br/>';
//
//                    echo 'store_previous_row_current_stock '.$store_previous_row_current_stock.'<br/>';
//                    echo 'this_row_current_stock =>'.$current_stock.'<br/>';
//                    echo '<br/>';


                    $stock = Stock::find($id);
                    $stock->previous_stock = 0;
                    $stock->current_stock = $stock_in;
                    $affectedRow = $stock->update();
                    if ($affectedRow) {
//                        echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                        echo '<br/>';
                        $current_stock = $stock->current_stock;
                    }

                } else {
//                    echo 'row_id =>'.$id.'<br/>';
//                    echo 'product_id =>'.$product_id.'<br/>';
//                    echo 'store_id =>'.$store_id.'<br/>';
//
//                    echo 'store_previous_row_current_stock '.$store_previous_row_current_stock.'<br/>';
//                    echo 'this_row_current_stock =>'.$current_stock.'<br/>';
//                    echo '<br/>';

                    // update part
                    if ($stock_in > 0) {
                        if ($stock_in_flag == 1) {
                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock + $stock_in;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else if ($previous_stock != $store_previous_row_current_stock) {
                            $stock_in_flag = 1;

                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock + $stock_in;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else {
//                            echo 'this_row_current_stock => nothing => '.$stock_in.'<br/>';
//                            echo '<br/>';
                        }
                    } else if ($stock_out > 0) {
                        if ($stock_out_flag == 1) {
                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock - $stock_out;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'This Row('.$id.') Current Stock => updated => ' . $stock_out . '<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else if ($previous_stock != $store_previous_row_current_stock) {
                            $stock_out_flag = 1;

                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock - $stock_out;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'This Row('.$id.') Current Stock => updated =>' . $stock_out . '<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        } else {
//                            echo 'this_row_current_stock => nothing => '.$stock_out.'<br/>';
//                            echo '<br/>';
                        }
                    } else {
//                        echo 'this_row_current_stock => nothing<br/>';
//                        echo '<br/>';
                    }
//                    echo '<br/>';
                }
                $store_previous_row_current_stock = $current_stock;
            }
        } else {
//            echo 'no found!'.'<br/>';
        }
    }
}


function sales_income_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Received againts Sales')
        ->groupBy('group_3')
        ->first();

    //dd($gl_pre_valance_data);


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('posting_form_details.group_3','Received againts Sales')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();
    //dd($general_ledger_infos);

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function service_income_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Received againts Services')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];


    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Received againts Services')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function inventory_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Inventory')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Inventory')
      //  ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
      ->where('posting_date', '<=',$date_from)
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function closing_inventory_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Inventory')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Inventory')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
      //->where('posting_date', '<=',$date_from)
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function purchase_account_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Purchase Account')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Purchase Account')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function purchase_installation_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Product Installation')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Product Installation')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function service_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Service Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Service Expenses')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function carrying_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Carrying Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Carrying Expenses')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function godwon_storage_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Godwon & Storage')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Godwon & Storage')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function miscellaneous_expense($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Miscellaneous Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Miscellaneous Expense')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function admin_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Admin Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Admin Expense')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function selling_MKT_Expense1_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Selling & MKT Expense(Com/Ins)')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Selling & MKT Expense(Com/Ins)')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function selling_MKT_Expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Selling & MKT Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Selling & MKT Expense')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function finance_charges_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Finance Charges')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Finance Charges')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function finance_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Finance Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Finance Expenses')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}


function additional_capital($date_from, $date_to){



    $income_sale =0;
    $income_service =0;

    $inventory =0;
    $purchase_account =0;
    $closing_inventory =0;
    $purchase_installation =0;
    $service_expense =0;
    $carrying_expense =0;
    $godwon_storage =0;
    $admin_expense =0;
    $selling_MKT_Expense1 =0;
    $selling_MKT_Expense =0;
    $finance_charges =0;
    $finance_expense =0;

    $get_sales_income_statement = sales_income_statement($date_from,$date_to);
    //dd($get_sales_income_statement);
    $income_sale +=$get_sales_income_statement['PreBalance'];
    //dd($income_sale);

    $get_service_income_statement = service_income_statement($date_from,$date_to);
    $income_service +=$get_service_income_statement['PreBalance'];

    $income =$income_service+$income_sale;

    $get_inventory_statement = inventory_statement($date_from,$date_to);
    $inventory +=$get_inventory_statement['PreBalance'];

    $get_purchase_account_statement = purchase_account1_statement($date_from,$date_to);
    if(!empty($get_purchase_account_statement))
    $purchase_account +=$get_purchase_account_statement->debit;

    $get_closing_inventory_statement = closing_inventory_statement($date_from,$date_to);
    $closing_inventory +=$get_closing_inventory_statement['PreBalance'];

    $inventory_purchase = $inventory + $purchase_account;
    $closing =  $inventory_purchase - $closing_inventory;

    $get_purchase_installation_statement = purchase_installation_statement($date_from,$date_to);
    $purchase_installation +=$get_purchase_installation_statement['PreBalance'];

    $get_service_expense_statement = service_expense_statement($date_from,$date_to);
    $service_expense +=$get_service_expense_statement['PreBalance'];

    $get_carrying_expense_statement = carrying_expense_statement($date_from,$date_to);
    $carrying_expense +=$get_carrying_expense_statement['PreBalance'];

    $get_godwon_storage_statement = godwon_storage_statement($date_from,$date_to);
    $godwon_storage +=$get_godwon_storage_statement['PreBalance'];

    $expense =$closing+$purchase_installation+$service_expense+$carrying_expense+$godwon_storage;
    $gross_profit =$income-$expense;
   // dd($expense);
    $get_admin_expense_statement = admin_expense_statement($date_from,$date_to);
    $admin_expense +=$get_admin_expense_statement['PreBalance'];

    $get_selling_MKT_Expense1_statement = selling_MKT_Expense1_statement($date_from,$date_to);
    $selling_MKT_Expense1 +=$get_selling_MKT_Expense1_statement['PreBalance'];

    $get_selling_MKT_Expense_statement = selling_MKT_Expense_statement($date_from,$date_to);
    $selling_MKT_Expense +=$get_selling_MKT_Expense_statement['PreBalance'];

    $get_finance_charges_statement = finance_charges_statement($date_from,$date_to);
    $finance_charges +=$get_finance_charges_statement['PreBalance'];

    $get_finance_expense_statement = finance_expense_statement($date_from,$date_to);
    $finance_expense +=$get_finance_expense_statement['PreBalance'];

    $indirecExpense = $admin_expense+$selling_MKT_Expense1+$selling_MKT_Expense+$finance_charges+$finance_expense;
    $net_profit =$gross_profit-$indirecExpense;





    $income_sale_for_equity =0;
    $income_service_for_equity =0;

    $purchase_account_for_equity =0;
    $purchase_installation_for_equity =0;
    $service_expense_for_equity =0;
    $carrying_expense_for_equity =0;
    $godwon_storage_for_equity =0;
    $admin_expense_for_equity =0;
    $selling_MKT_Expense1_for_equity =0;
    $selling_MKT_Expense_for_equity =0;
    $finance_charges_for_equity =0;
    $finance_expense_for_equity =0;

    $get_sales_income_statement_for_equity = sales_income_statement_for_equity($date_from,$date_to);
    $income_sale_for_equity +=$get_sales_income_statement_for_equity['PreBalance'];

    $get_service_income_statement_for_equity = service_income_statement_for_equity($date_from,$date_to);
    $income_service_for_equity +=$get_service_income_statement_for_equity['PreBalance'];

    $income_for_equity =$income_service_for_equity+$income_sale_for_equity;

    $get_purchase_account_statement_for_equity = purchase_account_statement_for_equity($date_from,$date_to);
    $purchase_account_for_equity +=$get_purchase_account_statement_for_equity['PreBalance'];

    $get_purchase_installation_statement_for_equity = purchase_installation_statement_for_equity($date_from,$date_to);
    $purchase_installation_for_equity +=$get_purchase_installation_statement_for_equity['PreBalance'];

    $get_service_expense_statement_for_equity = service_expense_statement_for_equity($date_from,$date_to);
    $service_expense_for_equity +=$get_service_expense_statement_for_equity['PreBalance'];

    $get_carrying_expense_statement_for_equity = carrying_expense_statement_for_equity($date_from,$date_to);
    $carrying_expense_for_equity +=$get_carrying_expense_statement_for_equity['PreBalance'];

    $get_godwon_storage_statement_for_equity = godwon_storage_statement_for_equity($date_from,$date_to);
    $godwon_storage_for_equity +=$get_godwon_storage_statement_for_equity['PreBalance'];

    $expense_for_equity =$purchase_account_for_equity+$purchase_installation_for_equity+$service_expense_for_equity+$carrying_expense_for_equity+$godwon_storage_for_equity;
    $gross_profit_for_equity =$income_for_equity-$expense_for_equity;

    $get_admin_expense_statement_for_equity = admin_expense_statement_for_equity($date_from,$date_to);
    $admin_expense_for_equity +=$get_admin_expense_statement_for_equity['PreBalance'];

    $get_selling_MKT_Expense1_statement_for_equity = selling_MKT_Expense1_statement_for_equity($date_from,$date_to);
    $selling_MKT_Expense1_for_equity +=$get_selling_MKT_Expense1_statement_for_equity['PreBalance'];

    $get_selling_MKT_Expense_statement_for_equity = selling_MKT_Expense_statement_for_equity($date_from,$date_to);
    $selling_MKT_Expense_for_equity +=$get_selling_MKT_Expense_statement_for_equity['PreBalance'];

    $get_finance_charges_statement_for_equity = finance_charges_statement_for_equity($date_from,$date_to);
    $finance_charges_for_equity +=$get_finance_charges_statement_for_equity['PreBalance'];

    $get_finance_expense_statement_for_equity = finance_expense_statement_for_equity($date_from,$date_to);
    $finance_expense_for_equity +=$get_finance_expense_statement_for_equity['PreBalance'];

    $indirecExpense_for_equity = $admin_expense_for_equity+$selling_MKT_Expense1_for_equity+$selling_MKT_Expense_for_equity+$finance_charges_for_equity+$finance_expense_for_equity;
    $net_profit_for_equity =$gross_profit_for_equity-$indirecExpense_for_equity;



    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Capital Account')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr',
        'get_data' => $net_profit,
        'from_data' => $net_profit_for_equity,
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Capital Account')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function opening_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<',$date_from)
        ->where('group_3','Capital Account')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

    if(!empty($gl_pre_valance_data))
    {
        //echo 'ok';exit;
        $debit = $gl_pre_valance_data->debit;
        $credit = $gl_pre_valance_data->credit;
        if($debit > $credit)
        {
            $PreBalance = $debit - $credit;
            $preDebCre = 'De';
        }else{
            $PreBalance = $credit - $debit;
            $preDebCre = 'Cr';
        }
    }

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Capital Account')
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->where('posting_date', '<',$date_from)
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}

function stock_minus_logs(){
    $accessLog = new StockMinusLog();
    $accessLog->user_id=Auth::user()->id;
    $accessLog->action_module='Brand';
    $accessLog->action_done='Create';
    $accessLog->action_remarks='Brand ID: ';
    $accessLog->action_date=date('Y-m-d');
    $accessLog->save();
    $insert_id = $accessLog->id;
    if($insert_id){
        return 1;
    }else{
        return 0;
    }
}


function check_stock_minus_logs_exists(){
    return StockMinusLog::get()->count();
}

?>
