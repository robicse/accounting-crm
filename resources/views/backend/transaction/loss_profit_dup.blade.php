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
                    <form class="form-inline" action="{{ URL('transaction-loss-profit-dup/'.$store_id) }}">
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
                            <a href="{!! URL('transaction-loss-profit-dup/'.$store_id) !!}" class="btn btn-primary" type="button">Reset</a>
                        </div>
                    </form>
                <?php
                $store = DB::table('stores')->where('id',$store_id)->first();
              //  dd($store);
                ?>
                <div>&nbsp;</div>
{{--                @if(!empty($stores))--}}
{{--                    @foreach($stores as $store)--}}
                        <div class="col-md-12">
                            <h1 class="text-center">{{$store->name}}</h1>

                              @php
                             $sum_loss_or_profit = 0;
                             $product_sale_return_amount = product_sale_return($store->id,$start_date,$end_date);
                             $product_sale_amount = product_sale($store->id,$start_date,$end_date);
                             $product_purchase = product_purchase($store->id,$start_date,$end_date);
                             $product_purchase_return = product_purchase_return($store->id,$start_date,$end_date);

                              $net_sale = $product_sale_amount - $product_sale_return_amount;
                              $payment_against_purchase = $product_purchase + $product_purchase_return;
                              $sum_loss_or_profit = $net_sale - $payment_against_purchase;
                              //dd($sum_loss_or_profit)

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
                                    <th colspan="10">Final Loss/Profit:</th>
                                    <th>
                                        @if($sum_loss_or_profit > 0)
                                            Profit: {{number_format($sum_loss_or_profit , 2, '.', '')}}
                                        @else
                                            Loss: {{number_format($sum_loss_or_profit, 2, '.', '')}}
                                        @endif
                                    </th>
                                </tr>
                                </thead>
                            </table>
                            <div class="tile-footer">
                            </div>
                        </div>
{{--                    @endforeach--}}
{{--                @endif--}}
            </div>

        </div>
    </main>
@endsection


