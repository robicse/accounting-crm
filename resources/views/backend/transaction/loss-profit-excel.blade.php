@if(!empty($stores))
    @foreach($stores as $store)
        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>Clean Tech Engineering</th>
                @php
                    $productPurchaseDetails = DB::table('product_purchase_details')
                        ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                        ->where('product_purchases.store_id',$store->id)
                        ->groupBy('product_id')
                        ->groupBy('product_category_id')
                        ->groupBy('product_sub_category_id')
                        ->groupBy('product_brand_id')
                        ->get();


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
                        Profit: {{$sum_loss_or_profit}}
                    @else
                        Loss: {{$sum_loss_or_profit}}
                    @endif
                </th>
            </tr>
            <tr>
                <th>Expense:</th>
                <th>
                    @php
                        $total_expense = \App\Transaction::where('store_id',$store->id)->where('transaction_type','expense')->sum('amount');
                    @endphp
                    {{$total_expense}}
                </th>
            </tr>
            <tr>
                <th>Final Loss/Profit:</th>
                <th>
                    @if($sum_loss_or_profit > 0)
                        Profit: {{$sum_loss_or_profit - $total_expense}}
                    @else
                        Loss: {{$sum_loss_or_profit - $total_expense}}
                    @endif
                </th>
            </tr>
            </thead>
        </table>
    @endforeach
@endif
