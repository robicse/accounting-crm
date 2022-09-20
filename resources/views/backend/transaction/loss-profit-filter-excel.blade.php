@if(!empty($stores))
    @foreach($stores as $store)
<table class="table table-bordered mt-3">
    <thead>
    <tr>
        <th>{{$store->name}}</th>
        @php
            $start_date =Request::segment(2);
            $end_date =Request::segment(3);

            if($start_date != '' && $end_date != ''){
                $custom_start_date = $start_date.' 00:00:00';
                $custom_end_date = $end_date.' 00:00:00';

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
        @endphp
        @foreach($productPurchaseDetails as $key => $productPurchaseDetail)
            @php
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

                    if($sale_total_qty > 0){
                        $loss_or_profit = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                        $current_loss_or_profit += $loss_or_profit;
                        $sum_loss_or_profit += $loss_or_profit;
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
                }
            @endphp
        @endforeach
    </tr>
    </thead>
</table>
<table>
    <thead>
    <tr>
        <th>Sum Product Based Loss/Profit: </th>
        <th>
            @if($sum_loss_or_profit > 0)
                Profit: {{number_format($sum_loss_or_profit, 2, '.', '')}}
            @else
                Loss: {{number_format($sum_loss_or_profit, 2, '.', '')}}
            @endif
        </th>
    </tr>
    <tr>
        <th>Expense:</th>
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
        <th>Final Loss/Profit:</th>
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
    @endforeach
@endif
