@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            {{--<div>
                <h1><i class=""></i> Add Sales Product</h1>
            </div>--}}
            <!--<ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('productSales.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Sales Product</a>
                </li>
            </ul>-->
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Returnable Sales Product</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productSaleReturns.update',$productSaleReturn->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Invoice  <small class="requiredCustom">*</small></label>
                            <div class="col-md-5">
                                <input class="form-control" type="hidden" name="product_sale_return_id" value="{{$productSaleReturn->id}}">
                                <input class="form-control" type="text" name="sale_invoice_no" value="{{$productSaleReturn->sale_invoice_no}}" readonly>
                            </div>
                        </div>

                        <div class="tile-body tile-footer">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Received Quantity</th>
                                        <th>Return Quantity</th>
                                        <th>Amount</th>
                                        <th>Reason</th>
                                    </tr>
                                    </thead>
                                    <tbody class="neworderbody">
                                    @foreach($productSaleReturnDetails as $key => $productSaleReturnDetail)
                                        @php
                                            $key += 1;

                                            $sale_qty = \Illuminate\Support\Facades\DB::table('product_sale_details')
                                            ->join('product_sales','product_sales.id','product_sale_details.product_sale_id')
                                            ->where('product_sales.invoice_no',$productSaleReturn->sale_invoice_no)
                                            ->where('product_sale_details.product_id',$productSaleReturnDetail->product_id)
                                        ->pluck('product_sale_details.qty')
                                        ->first();
                                        @endphp
                                        <tr>
                                            <td width="5%" class="no">1</td>
                                            <td>
                                                <input class="form-control" type="hidden" name="product_sale_return_detail_id[]" value="{{$productSaleReturnDetail->id}}">
                                                <input class="form-control" type="hidden" name="product_id[]" value="{{$productSaleReturnDetail->product_id}}">
                                                {{$productSaleReturnDetail->product->name}}
                                            </td>
                                            <td>{{$sale_qty}}</td>
                                            <td>
                                                <input class="form-control" type="text" name="qty[]" value="{{$productSaleReturnDetail->qty}}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="price[]" value="{{$productSaleReturnDetail->price}}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" rows="3" name="reason[]">{{$productSaleReturnDetail->reason}}</textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">

                            </label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>

@endsection

@push('js')
    <script>
        $('#sale_invoice_no').change(function(){
            $('#loadForm').html('');
            var sale_id = $(this).val();
            console.log(sale_id);

            $.ajax({
                url : "{{ URL('/get-returnable-product') }}/" + sale_id,
                type: "GET",
                dataType: "json",
                success: function(data)
                {
                    console.log(data);
                    $('#loadForm').html(data);
                },
                /*error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }*/
                error: function (data) {
                    console.log(data);
                }
            })
        })
        function productType(){
            var arr = $('#payment_type').val();
            console.log(arr);
            if(arr == "Check"){ $("#check_number").removeAttr("readonly"); }
            if(arr == "Cash"){ $("#check_number").attr("readonly", "readonly"); }
        }
        // ajax
        function return_qty(row,sel) {

            var current_row = row;
            var current_return_qty = sel.value;
            //console.log('current_row = ' + current_row);
            //console.log('current_return_qty = ' + current_return_qty);
            //console.log('current_return_qty= ' + typeof current_return_qty);
            //var current_product_id = $('#product_id_'+current_row).val();
            var current_sale_qty = $('#qty_'+current_row).val();
            //console.log('current_sale_qty = ' + current_sale_qty);
            //console.log('current_sale_qty= ' + typeof current_sale_qty);
            current_return_qty = parseInt(current_return_qty);
            //console.log('current_return_qty= ' + typeof current_return_qty);
            current_sale_qty = parseInt(current_sale_qty);
            //console.log('current_sale_qty= ' + typeof current_sale_qty);
            if(current_return_qty > current_sale_qty){
                alert('You have limit cross of stock qty!');
                $('#return_qty_'+current_row).val(0);
            }
        }
    </script>
{{--    <script>--}}

{{--        // ajax--}}
{{--        function return_qty1(row,sel) {--}}
{{--            console.log('ooo');--}}
{{--            var current_row = row;--}}
{{--            var current_return_qty = sel.value;--}}
{{--            console.log(current_row);--}}
{{--            console.log(current_return_qty);--}}
{{--            //var current_product_id = $('#product_id_'+current_row).val();--}}

{{--            var current_sale_qty = $('#qty_'+current_row).val();--}}
{{--            if(current_return_qty > current_sale_qty){--}}
{{--                alert('You have limit cross of stock qty!');--}}
{{--                $('#return_qty_'+current_row).val(0);--}}
{{--            }--}}
{{--        }--}}

{{--        function productType(row,sel){--}}
{{--            var current_row = row;--}}
{{--            var arr = $('#payment_type_'+current_row).val();--}}
{{--            if(arr == "check"){ $("#check_number_"+current_row).removeAttr("readonly"); }--}}
{{--            if(arr == "Cash"){ $("#check_number_"+current_row).attr("readonly", "readonly"); }--}}
{{--        }--}}

{{--    </script>--}}
@endpush


