@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i>Loss Profit </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    @if($start_date != '' && $end_date != '')
                        <a class="btn btn-warning" href="{{ url('loss-profit-filter-export/'.$start_date."/".$end_date) }}">Export Data</a>
                    @else
                        <a class="btn btn-warning" href="{{ route('loss.profit.export') }}">Export Data</a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Loss Profit Table</h3>
                    <form class="form-inline" action="{{ route('transaction.lossProfit') }}">
                        <div class="form-group col-md-4">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" class="form-control" value="{{$start_date}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" class="form-control"  value="{{$end_date}}">
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{!! route('transaction.lossProfit') !!}" class="btn btn-primary" type="button">Reset</a>
                        </div>
                    </form>
                <div>&nbsp;</div>
                @if(!empty($stores))
                    @foreach($stores as $store)
                        <div class="col-md-12">
                            <h1 class="text-center">{{$store->name}}</h1>

                            @php
                                $custom_start_date = $start_date.' 00:00:00';
                                $custom_end_date = $end_date.' 00:00:00';

                                /*if($start_date != '' && $end_date != ''){
                                    $productPurchaseDetails = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_purchases.store_id',$store->id)
                                    ->where('product_purchases.created_at','>=',$custom_start_date)
                                    ->where('product_purchases.created_at','<=',$custom_end_date)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->get();
                                }else{
                                    $productPurchaseDetails = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_purchases.store_id',$store->id)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->get();
                                }


                                $sum_loss_or_profit = 0;

                            @foreach($productPurchaseDetails as $key => $productPurchaseDetail)

                                    $loss_or_profit = 0;
                                    $current_loss_or_profit = 0;
                                    $sale_total_qty = 0;
                                    $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;

                                    // sale
                                    $sale_total_qty = 0;
                                    $sale_total_amount = 0;
                                    $sale_average_price = 0;

                                    $productSaleDetails = DB::table('product_sale_details')
                                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                        ->where('product_id',$productPurchaseDetail->product_id)
                                        ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                        ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                        ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                        ->groupBy('product_id')
                                        ->groupBy('product_category_id')
                                        ->groupBy('product_sub_category_id')
                                        ->groupBy('product_brand_id')
                                        ->first();

                                    if(!empty($productSaleDetails))
                                    {
                                        $sale_total_qty = $productSaleDetails->qty;
                                        $sale_total_amount = $productSaleDetails->sub_total;
                                        $sale_average_price = $productSaleDetails->sub_total/$productSaleDetails->qty;
//dd($sale_average_price);
                                        if($sale_total_qty > 0){
                                            $loss_or_profit = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                            $current_loss_or_profit += $loss_or_profit;
                                            $sum_loss_or_profit += $loss_or_profit;
                                            //dd($loss_or_profit);
                                        }
                                    }

                                    // sale return
                                    $sale_return_total_qty = 0;
                                    $sale_return_total_amount = 0;
                                    $sale_return_average_price = 0;

                                    $productSaleReturnDetails = DB::table('product_sale_return_details')
                                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                        ->where('product_id',$productPurchaseDetail->product_id)
                                        ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                        ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                        ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                        ->groupBy('product_id')
                                        ->groupBy('product_category_id')
                                        ->groupBy('product_sub_category_id')
                                        ->groupBy('product_brand_id')
                                        ->first();

                                    if(!empty($productSaleReturnDetails))
                                    {
                                        $sale_return_total_qty = $productSaleReturnDetails->qty;
                                        $sale_return_total_amount = $productSaleReturnDetails->price;
                                        $sale_return_average_price = $sale_return_total_amount/$productSaleReturnDetails->qty;

                                        if($sale_return_total_qty > 0){
                                            $loss_or_profit = $sale_return_average_price - ($purchase_average_price*$sale_return_total_qty);
                                            $current_loss_or_profit -= $loss_or_profit;
                                            $sum_loss_or_profit -= $loss_or_profit;
                                        }
                                    }*/
                                $sum_purchase_price = 0;
                                $sum_sale_price = 0;
                                $sum_sale_return_price = 0;
                                $sum_loss_or_profit = 0;
                                $current_loss_or_profit = 0;

                                $productPurchaseDetails = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_purchases.store_id',$store->id)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->get();

                                if(!empty($productPurchaseDetails)){
                                    foreach($productPurchaseDetails as $key => $productPurchaseDetail){
                                        $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                        $sum_purchase_price += $productPurchaseDetail->sub_total;

                                        // sale
                                        if($start_date != '' && $end_date != ''){
                                            $productSaleDetails = DB::table('product_sale_details')
                                            ->join('product_sales','product_sale_details.product_sale_id','product_sales.id')
                                                ->select('product_sale_details.product_id','product_sale_details.product_category_id','product_sale_details.product_sub_category_id','product_sale_details.product_brand_id', DB::raw('SUM(product_sale_details.qty) as qty'), DB::raw('SUM(product_sale_details.price) as price'), DB::raw('SUM(product_sale_details.sub_total) as sub_total'))
                                                ->where('product_sale_details.product_id',$productPurchaseDetail->product_id)
                                                ->where('product_sale_details.product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sale_details.product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_sale_details.product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->where('product_sale_details.created_at','>=',$custom_start_date)
                                                ->where('product_sale_details.created_at','<=',$custom_end_date)
                                                ->where('product_sales.store_id',$store->id)
                                                ->groupBy('product_sale_details.product_id')
                                                ->groupBy('product_sale_details.product_category_id')
                                                ->groupBy('product_sale_details.product_sub_category_id')
                                                ->groupBy('product_sale_details.product_brand_id')
                                                ->first();
                                        }else{
                                            $productSaleDetails = DB::table('product_sale_details')
                                            ->join('product_sales','product_sale_details.product_sale_id','product_sales.id')
                                                ->select('product_sale_details.product_id','product_sale_details.product_category_id','product_sale_details.product_sub_category_id','product_sale_details.product_brand_id', DB::raw('SUM(product_sale_details.qty) as qty'), DB::raw('SUM(product_sale_details.price) as price'), DB::raw('SUM(product_sale_details.sub_total) as sub_total'))
                                                ->where('product_sale_details.product_id',$productPurchaseDetail->product_id)
                                                ->where('product_sale_details.product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sale_details.product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_sale_details.product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->where('product_sales.store_id',$store->id)
                                                ->groupBy('product_sale_details.product_id')
                                                ->groupBy('product_sale_details.product_category_id')
                                                ->groupBy('product_sale_details.product_sub_category_id')
                                                ->groupBy('product_sale_details.product_brand_id')
                                                ->first();
                                        }

                                        if(!empty($productSaleDetails))
                                        {
                                            $sale_total_qty = $productSaleDetails->qty;
                                            $sum_sale_price = $productSaleDetails->sub_total;
                                            $sale_average_price = $productSaleDetails->sub_total/$productSaleDetails->qty;

                                            if($sale_total_qty > 0){
                                                $loss_or_profit = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                                $current_loss_or_profit += $loss_or_profit;
                                                $sum_loss_or_profit += $loss_or_profit;
                                                //dd($sum_loss_or_profit);

                                            }
                                        }



                                        // sale return
                                        if($start_date != '' && $end_date != ''){
                                            $productSaleReturnDetails = DB::table('product_sale_return_details')
                                                ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                                ->where('product_id',$productPurchaseDetail->product_id)
                                                ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->where('created_at','>=',$custom_start_date)
                                                ->where('created_at','<=',$custom_end_date)
                                                ->groupBy('product_id')
                                                ->groupBy('product_category_id')
                                                ->groupBy('product_sub_category_id')
                                                ->groupBy('product_brand_id')
                                                ->first();
                                        }else{
                                            $productSaleReturnDetails = DB::table('product_sale_return_details')
                                            ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                            ->where('product_id',$productPurchaseDetail->product_id)
                                            ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                            ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                            ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                            ->groupBy('product_id')
                                            ->groupBy('product_category_id')
                                            ->groupBy('product_sub_category_id')
                                            ->groupBy('product_brand_id')
                                            ->first();
                                        }

                                        if(!empty($productSaleReturnDetails))
                                        {
                                            $sale_return_total_qty = $productSaleReturnDetails->qty;
                                            $sale_return_total_amount = $productSaleReturnDetails->price;
                                            $sum_sale_return_price += $productSaleReturnDetails->price;
                                            $sale_return_average_price = $sale_return_total_amount/$productSaleReturnDetails->qty;

                                            if($sale_return_total_qty > 0){
                                                $amount = $sale_return_average_price - ($purchase_average_price*$sale_return_total_qty);
                                                if($amount > 0){
                                                    $sum_loss_or_profit -= $amount;
                                                }else{
                                                    $sum_loss_or_profit += $amount;
                                                }
                                            }
                                        }


                                    }

                                    // sale discount
                                    if($start_date != '' && $end_date != ''){
                                        $discount= DB::table('product_sales')
                                            ->select( DB::raw('SUM(discount_amount) as total_discount_amount'))
                                            ->where('product_sales.created_at','>=',$custom_start_date)
                                            ->where('product_sales.created_at','<=',$custom_end_date)
                                            ->where('product_sales.store_id',$store->id)
                                            ->first();
                                    }else{
                                        $discount= DB::table('product_sales')
                                            ->where('product_sales.store_id',$store->id)
                                            ->select( DB::raw('SUM(discount_amount) as total_discount_amount'))
                                            ->first();
                                    }
                                    if($discount){
                                        $sum_loss_or_profit -=$discount->total_discount_amount ;
                                    }
                                }

                                $productPurchaseDetailsArr = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->where('product_purchases.store_id',$store->id)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->pluck('product_id')
                                    ->toArray();

                            //dd($productPurchaseDetailsArr);

                            $stockTransferDetails = DB::table('stock_transfer_details')
                                    ->join('stock_transfers','stock_transfers.id','=','stock_transfer_details.stock_transfer_id')
                                    ->select('stock_transfer_details.product_id','stock_transfer_details.product_category_id','stock_transfer_details.product_sub_category_id','stock_transfer_details.product_brand_id', DB::raw('SUM(stock_transfer_details.qty) as qty'), DB::raw('SUM(stock_transfer_details.price) as price'), DB::raw('SUM(stock_transfer_details.sub_total) as sub_total'))
                                    ->where('stock_transfers.to_store_id',$store->id)
                                    ->groupBy('stock_transfer_details.product_id')
                                    ->groupBy('stock_transfer_details.product_category_id')
                                    ->groupBy('stock_transfer_details.product_sub_category_id')
                                    ->groupBy('stock_transfer_details.product_brand_id')
                                    ->get();

                            if(!empty($stockTransferDetails)){
                                    foreach($stockTransferDetails as $key => $productPurchaseDetail){
                                        $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                        $sum_purchase_price += $productPurchaseDetail->sub_total;

                                        // sale
                                        if($start_date != '' && $end_date != ''){
                                            $productSaleDetails = DB::table('product_sale_details')
                                            ->join('product_sales','product_sale_details.product_sale_id','product_sales.id')
                                                ->select('product_sale_details.product_id','product_sale_details.product_category_id','product_sale_details.product_sub_category_id','product_sale_details.product_brand_id', DB::raw('SUM(product_sale_details.qty) as qty'), DB::raw('SUM(product_sale_details.price) as price'), DB::raw('SUM(product_sale_details.sub_total) as sub_total'))
                                                ->where('product_sale_details.product_id',$productPurchaseDetail->product_id)
                                                ->where('product_sale_details.product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sale_details.product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_sale_details.product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->where('product_sale_details.created_at','>=',$custom_start_date)
                                                ->where('product_sale_details.created_at','<=',$custom_end_date)
                                                ->where('product_sales.store_id',$store->id)
                                                ->groupBy('product_sale_details.product_id')
                                                ->groupBy('product_sale_details.product_category_id')
                                                ->groupBy('product_sale_details.product_sub_category_id')
                                                ->groupBy('product_sale_details.product_brand_id')
                                                ->first();
                                        }else{
                                            $productSaleDetails = DB::table('product_sale_details')
                                            ->join('product_sales','product_sale_details.product_sale_id','product_sales.id')
                                                ->select('product_sale_details.product_id','product_sale_details.product_category_id','product_sale_details.product_sub_category_id','product_sale_details.product_brand_id', DB::raw('SUM(product_sale_details.qty) as qty'), DB::raw('SUM(product_sale_details.price) as price'), DB::raw('SUM(product_sale_details.sub_total) as sub_total'))
                                                ->where('product_sale_details.product_id',$productPurchaseDetail->product_id)
                                                ->where('product_sale_details.product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sale_details.product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_sale_details.product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->where('product_sales.store_id',$store->id)
                                                ->groupBy('product_sale_details.product_id')
                                                ->groupBy('product_sale_details.product_category_id')
                                                ->groupBy('product_sale_details.product_sub_category_id')
                                                ->groupBy('product_sale_details.product_brand_id')
                                                ->first();
                                        }

                                        if(!empty($productSaleDetails))
                                        {
                                            $sale_total_qty = $productSaleDetails->qty;
                                            $sum_sale_price = $productSaleDetails->sub_total;
                                            $sale_average_price = $productSaleDetails->sub_total/$productSaleDetails->qty;

                                            if($sale_total_qty > 0){
                                                $loss_or_profit = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                                $current_loss_or_profit += $loss_or_profit;
                                                $sum_loss_or_profit += $loss_or_profit;
                                                //dd($sum_loss_or_profit);

                                            }
                                        }

                                        // sale return
                                        if($start_date != '' && $end_date != ''){
                                            $productSaleReturnDetails = DB::table('product_sale_return_details')
                                                ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                                ->where('product_id',$productPurchaseDetail->product_id)
                                                ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->where('created_at','>=',$custom_start_date)
                                                ->where('created_at','<=',$custom_end_date)
                                                ->groupBy('product_id')
                                                ->groupBy('product_category_id')
                                                ->groupBy('product_sub_category_id')
                                                ->groupBy('product_brand_id')
                                                ->first();
                                        }else{
                                            $productSaleReturnDetails = DB::table('product_sale_return_details')
                                            ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                            ->where('product_id',$productPurchaseDetail->product_id)
                                            ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                            ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                            ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                            ->groupBy('product_id')
                                            ->groupBy('product_category_id')
                                            ->groupBy('product_sub_category_id')
                                            ->groupBy('product_brand_id')
                                            ->first();
                                        }

                                        if(!empty($productSaleReturnDetails))
                                        {
                                            $sale_return_total_qty = $productSaleReturnDetails->qty;
                                            $sale_return_total_amount = $productSaleReturnDetails->price;
                                            $sum_sale_return_price += $productSaleReturnDetails->price;
                                            $sale_return_average_price = $sale_return_total_amount/$productSaleReturnDetails->qty;

                                            if($sale_return_total_qty > 0){
                                                $amount = $sale_return_average_price - ($purchase_average_price*$sale_return_total_qty);
                                                if($amount > 0){
                                                    $sum_loss_or_profit -= $amount;
                                                }else{
                                                    $sum_loss_or_profit += $amount;
                                                }
                                            }
                                        }


                                    }

                                    // sale discount
                                    if($start_date != '' && $end_date != ''){
                                        $discount= DB::table('product_sales')
                                            ->select( DB::raw('SUM(discount_amount) as total_discount_amount'))
                                            ->where('product_sales.created_at','>=',$custom_start_date)
                                            ->where('product_sales.created_at','<=',$custom_end_date)
                                            ->where('product_sales.store_id',$store->id)
                                            ->first();
                                    }else{
                                        $discount= DB::table('product_sales')
                                            ->where('product_sales.store_id',$store->id)
                                            ->select( DB::raw('SUM(discount_amount) as total_discount_amount'))
                                            ->first();
                                    }
                                    if($discount){
                                        $sum_loss_or_profit -=$discount->total_discount_amount ;
                                    }
                                }

                                @endphp
                            <table>
                                <thead>
                                <tr>
                                    <th colspan="10">Sum Product Based Loss/Profit: </th>
                                    <th>
                                        @if($sum_loss_or_profit > 0)
                                            Profit: {{number_format($sum_loss_or_profit, 2, '.', '')}}
                                        @else
                                            Loss: {{number_format($sum_loss_or_profit, 2, '.', '')}}
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="10">Expense:</th>
                                    <th>
                                        @php
                                            if($start_date != '' && $end_date != ''){
                                                $total_expense = \App\Expense::where('date','>=',$start_date)->where('date','<=',$end_date)->where('store_id',$store->id)->sum('amount');
                                            }else{
                                                $total_expense = \App\Expense::where('store_id',$store->id)->sum('amount');
                                            }
                                        @endphp
                                        {{number_format($total_expense, 2, '.', '')}}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="10">Final Loss/Profit:</th>
                                    <th>
                                        @if($sum_loss_or_profit > 0)
                                            Profit: {{number_format($sum_loss_or_profit - $total_expense, 2, '.', '')}}
                                        @else
                                            Loss: {{number_format($sum_loss_or_profit + $total_expense, 2, '.', '')}}
                                        @endif
                                    </th>
                                </tr>
                                </thead>
                            </table>
                            <div class="tile-footer">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </main>
@endsection


