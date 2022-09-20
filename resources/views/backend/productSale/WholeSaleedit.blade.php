@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Whole Sale Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('productSales.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Whole Sale Product</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Whole Sale Product</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productWholeSales.update',$productSale->id) }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="stock_id" value="{{$stock_id}}">
                        <div class="form-group row" @if(Auth::user()->roles[0]->name == 'User') style="display: none" @endif>
                            <label class="control-label col-md-3 text-right">Store  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="store_id" id="store_id" class="form-control" >
                                    <option value="">Select One</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{$store->id == $productSale->store_id ? 'selected' : ''}}>{{$store->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Party  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="party_id" id="party_id" class="form-control select2">
                                    <option value="">Select One</option>
                                    @foreach($parties as $party)
                                        <option value="{{$party->id}}" {{$party->id == $productSale->party_id ? 'selected' : ''}}>{{$party->name}}.{{$party->phone}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Service Provider   <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="provider_id" id="provider_id" class="form-control select2">
                                    <option value="">Select One</option>
                                    @foreach($providers as $provider)
                                        <option value="{{$provider->id}}" {{$provider->id == $productSale->provider_id ? 'selected' : ''}}>{{$provider->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Payment Type  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="payment_type" id="payment_type" class="form-control" >
                                    <option value="Cash" {{'Cash' == $transaction->payment_type ? 'selected' : ''}}>Cash</option>
                                    <option value="Check" {{'Check' == $transaction->payment_type ? 'selected' : ''}}>Check</option>
                                </select>
                                <span>&nbsp;</span>
                                <input type="text" name="check_number" id="check_number" class="form-control" value="{{$transaction->check_number}}" placeholder="Check Number">
                                <span>&nbsp;</span>
                                <input type="text" name="check_date" id="check_date" class="datepicker form-control" value="{{$transaction->check_date}}" placeholder="Issue Deposit Date ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right"> Online Platform</label>
                            <div class="col-md-4">
                                <select name="online_platform_id" id="online_platform_id" class="form-control">
                                    <option value="" >Select One</option>
                                    @foreach($online_platforms as $online_platform)
                                        <option value="{{$online_platform->id}}" {{$online_platform->id == $productSale->online_platform_id ? 'selected' : ''}}>{{$online_platform->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="online_platform_invoice_no" id="online_platform_invoice_no" class="form-control" value="{{ $productSale->online_platform_invoice_no}}" placeholder="Invoice No">
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label class="control-label col-md-3 text-right" style="color: red">Transport/Labour</label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <input type="text" name="transport_cost" class="form-control" value="{{$productSale->transport_cost}}" placeholder="Transport Cost">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Transport Area</label>
                            <div class="col-md-8">
                                <input type="text" name="transport_area"  value="{{$productSale->transport_area}}" class="form-control" placeholder="Transport Area">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Date <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <input type="date" name="date" class="form-control" value="{{$productSale->date}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Note</label>
                            <div class="col-md-8">
                                <input type="text" name="note" class="form-control" value="{{$productSale->note}}" placeholder="Note">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Reference Name</label>
                            <div class="col-md-8">
                                <input type="text" name="reference_name" class="form-control" value="{{$productSale->reference_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Descriptions</label>
                            <div class="col-md-8">
                                <textarea name="conditions" id="conditions" class="form-control"  rows="3">{!! $productSale->conditions!!}</textarea>
                            </div>
                        </div>
                        <div class="table-responsive">
                            {{--<input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Product">--}}
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th style="display: none">Category</th>
                                    <th style="display: none">Sub Category</th>
                                    <th>Brand</th>
                                    <th style="display: none">Unit</th>
                                    <th>Return</th>
                                    <th>Stock Qty</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                                </thead>
                                @php
                                    $store_total_amount = 0;
                                @endphp
                                <tbody class="neworderbody">
                                @foreach($productSaleDetails as $key => $productSaleDetail)
                                    @php
                                        $current_stock = \App\Stock::where('product_id',$productSaleDetail->product_id)->latest()->pluck('current_stock')->first();
                                        $current_row = $key+1;
                                        $store_total_amount += $productSaleDetail->qty*$productSaleDetail->price;
                                    @endphp
                                    <tr>
                                        <td width="30%">
{{--                                            <select class="form-control product_id select2" name="product_id[]" onchange="getval({{$current_row}},this);" required>--}}
{{--                                                <option value="">Select  Product</option>--}}
{{--                                                @foreach($products as $product)--}}
{{--                                                    <option value="{{$product->id}}" {{$product->id == $productSaleDetail->product_id ? 'selected' : ''}}>{{$product->name}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
                                            <input type="text" class="form-control" value="{{$productSaleDetail->product->name}}" readonly>
                                            <input type="hidden" name="product_id[]" id="product_id" class="form-control" value="{{$productSaleDetail->product->id}}">
                                            <input type="hidden" class="form-control" name="product_Sale_detail_id[]" value="{{$productSaleDetail->id}}" >
                                        </td>
                                        <td width="12%" style="display: none">
                                            <div id="product_category_id_{{$current_row}}">
                                                <select class="form-control product_category_id" name="product_category_id[]" readonly required>
                                                    <option value="">Select  Category</option>
                                                    @foreach($productCategories as $productCategory)
                                                        <option value="{{$productCategory->id}}" {{$productCategory->id == $productSaleDetail->product_category_id ? 'selected' : ''}}>{{$productCategory->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td width="12%" style="display: none">
                                            <div id="product_sub_category_id_{{$current_row}}">
                                                <select class="form-control product_sub_category_id" name="product_sub_category_id[]" readonly>
                                                    <option value="">Select  Sub Category</option>
                                                    @foreach($productSubCategories as $productSubCategory)
                                                        <option value="{{$productSubCategory->id}}" {{$productSubCategory->id == $productSaleDetail->product_sub_category_id ? 'selected' : ''}}>{{$productSubCategory->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td width="14%">
                                            <div id="product_brand_id_{{$current_row}}">
                                                <select class="form-control product_brand_id" name="product_brand_id[]" readonly required>
                                                    <option value="">Select  Brand</option>
                                                    @foreach($productBrands as $productBrand)
                                                        <option value="{{$productBrand->id}}" {{$productBrand->id == $productSaleDetail->product_brand_id ? 'selected' : ''}}>{{$productBrand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td style="display: none">
                                            <div id="product_unit_id_{{$current_row}}">
                                                <select class="form-control product_unit_id" name="product_unit_id[]" readonly required>
                                                    <option value="">Select  Unit</option>
                                                    @foreach($productUnits as $productUnit)
                                                        <option value="{{$productUnit->id}}" {{$productUnit->id == $productSaleDetail->product_unit_id ? 'selected' : ''}}>{{$productUnit->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td width="12%">
                                            <select name="return_type[]" id="return_type_id_{{$current_row}}" class="form-control" >
                                                <option value="returnable"  {{'returnable' == $productSaleDetail->return_type ? 'selected' : ''}}>returnable</option>
                                                <option value="not returnable" {{'not returnable' == $productSaleDetail->return_type ? 'selected' : ''}}>not returnable</option>
                                            </select>
                                        </td>
                                        <td width="12%">
                                            <input type="number" id="stock_qty_1" class="stock_qty form-control" name="stock_qty[]" value="{{$current_stock}}" readonly >
                                        </td>
                                        <td width="10%">
                                            <input type="text" min="1" max="" class="qty form-control" name="qty[]" value="{{$productSaleDetail->qty}}" required >
                                        </td>
                                        <td width="12%">
                                            <input type="text" min="0" max="" class="price form-control" name="price[]" value="{{$productSaleDetail->price}}" required >
                                        </td>
                                        <td width="12%">
                                            <input type="text" class="amount form-control" name="sub_total[]" value="{{$productSaleDetail->sub_total}}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                @php
                                    $vat = ($store_total_amount*$productSale->vat_amount)/100;
                                    $after_vat_amount = $store_total_amount + $vat;
                                    $after_transport = $after_vat_amount + $productSale->transport_cost;
                                    if($productSale->discount_type == 'flat'){
                                        $discount = $productSale->discount_amount;
                                    }else{
                                        $discount = ($after_transport*$productSale->discount_amount)/100;
                                    }
                                    $after_discount_amount = $after_transport - $discount;
                                @endphp
                                <tr>
                                    <th>
                                        Sub Total Amount:
                                        <input type="text" id="store_total_amount" class="form-control" value="{{$store_total_amount}}" readonly>
                                    </th>
                                    <th>
                                        After Vat Amount:
                                        <input type="number" class="form-control" id="after_vat_amount" value="{{$after_vat_amount}}"readonly>
                                    </th>
                                    <th>
                                        After Trans:
                                        <input type="text" id="after_transport" class="form-control"  value="{{$after_transport}}" readonly>
                                    </th>
                                    <th>
                                        After Dis:
                                        <input type="text" id="after_discount_amount" class="form-control" value="{{$after_discount_amount}}" readonly>
                                    </th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr>

                                    <th>
                                        Vat(Percentage):
                                        <input type="number" class="form-control" name="vat_amount" id="vat_amount" onkeyup="priceCalculation('')" value="{{$productSale->vat_amount}}">
                                    </th>

                                    <th >
                                        Transport/Labour:
                                        <input type="text" id="transport" name="transport_cost" class="form-control" placeholder="Transport Cost" onkeyup="priceCalculation('')" value="{{$productSale->transport_cost}}">
                                    </th>

                                    <th>
                                        Type:
                                        <select name="discount_type" id="discount_type" class="form-control" onchange="priceCalculation('')">
                                            <option value="flat" {{'flat' == $productSale->discount_type ? 'selected' : ''}}>flat</option>
                                            <option value="percentage" {{'percentage' == $productSale->discount_type ? 'selected' : ''}}>percentage</option>
                                        </select>
                                    </th>
                                    <th>
                                        Discount:
                                        <input type="text" id="discount_amount" class="discount_amount form-control" name="discount_amount" onkeyup="priceCalculation('')" value="{{$productSale->discount_amount}}">
                                    </th>
                                    <th>
                                        Total:
                                        <input type="hidden" id="store_total_amount" class="form-control" value="{{$productSale->total_amount}}">
                                        <input type="text" id="total_amount" class="form-control" name="total_amount" value="{{$productSale->total_amount}}">
                                    </th>
                                    <th >
                                        Paid Amount:
                                        <input type="text" id="paid_amount" class="getmoney form-control" name="paid_amount" onkeyup="paidAmount('')" value="{{$productSale->paid_amount}}">
                                    </th>
                                    <th>
                                        Due Amount:
                                        <input type="text" id="due_amount" class="backmoney form-control" name="due_amount" value="{{$productSale->due_amount}}">
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="table-responsive" style="display:none;">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th >ID</th>
                                        <th>Free Product <small class="requiredCustom">*</small></th>

                                    </tr>
                                    </thead>
                                    <tbody class="neworderbody1">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th >ID</th>
                                                <th>Free Product <small class="requiredCustom">*</small></th>

                                            </tr>
                                            </thead>
                                            <tbody class="neworderbody1">
                                            @foreach($freeProductDetails as $key=>$freeProductDetail)
                                                <tr>
                                                    <td width="5%" class="no1">{{$key+1}}</td>
                                                    <td style="display: none"><input class="form-control" type="hidden" name="free_product_detail_id[]" value="{{$freeProductDetail->id}}"></td>
                                                    <td >
                                                        <select class="form-control free_product_id select2" name="free_product_id[]" id="free_product_id_1"  onchange="getval1(1,this);">
                                                            <option value="">Select One</option>
                                                            @foreach($freeProducts as $freeProduct)
                                                                <option value="{{$freeProduct->id}}" {{$freeProduct->id ==$freeProductDetail->free_product_id ? 'selected' : '' }}>{{$freeProduct->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>


                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-8">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Product Sales</button>
                                </div>
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
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'conditions' );
        function totalAmount(){
            var t = 0;
            $('.amount').each(function(i,e){
                var amt = $(this).val()-0;
                t += amt;
            });
            $('#store_total_amount').val(t);
            $('#total_amount').val(t);
            $('#due_amount').val(t);
        }

        function totalAmount(){
            var t = 0;
            $('.amount').each(function(i,e){
                var amt = $(this).val()-0;
                t += amt;
            });
            $('#store_total_amount').val(t);

            var vat_amount = $('#vat_amount').val();
            //console.log('vat_amount= ' + vat_amount);
            //console.log('vat_amount= ' + typeof vat_amount);
            vat_amount = (vat_amount);
            var vat_subtraction = (t*vat_amount)/100;
            //console.log('vat_subtraction= ' + vat_subtraction);
            //console.log('vat_subtraction= ' + typeof vat_subtraction);
            var after_vat_amount = t+vat_subtraction
            $('#after_vat_amount').val(after_vat_amount);

            var transport = $('#transport').val();
            //console.log('transport= ' + transport);
            //console.log('transport= ' + typeof transport);
            transport = parseFloat(transport);
            var after_transport = after_vat_amount + transport;
            $('#after_transport').val(after_transport);

            var discount_type = $('#discount_type').val();
            var store_total_amount = $('#store_total_amount').val();
            //console.log('store_total_amount= ' + store_total_amount);
            //console.log('store_total_amount= ' + typeof store_total_amount);
            store_total_amount = parseFloat(store_total_amount);
            //console.log('total= ' + typeof store_total_amount);
            var discount_amount = $('#discount_amount').val();
            //console.log('discount_amount= ' + discount_amount);
            //console.log('discount_amount= ' + typeof discount_amount);
            discount_amount = parseFloat(discount_amount);
            //console.log('discount_amount= ' + discount_amount);
            //console.log('discount_amount= ' + typeof discount_amount);

            if(discount_type == 'flat'){
                var discount = (store_total_amount+transport) - discount_amount ;
                var final_amount = discount ;
            }
            else{
                var discount = ((store_total_amount+transport)*discount_amount)/100;
                var final_amount = (store_total_amount+vat_subtraction+transport) - discount ;
            }
            //console.log('discount= ' + discount);
            //console.log('discount= ' + typeof discount);
            //console.log('final_amount= ' + final_amount);
            //console.log('final_amount= ' + typeof final_amount);

            var after_discount_amount = after_transport - discount;
            $('#after_discount_amount').val(final_amount);

            $('#total_amount').val(final_amount);

            var paid_amount = $('#paid_amount').val();
            paid_amount = parseFloat(paid_amount);
            //console.log('paid_amount= ' + paid_amount);
            //console.log('paid_amount= ' + typeof paid_amount);

            $('#due_amount').val(final_amount - paid_amount);

        }


        //onkeyup
        function priceCalculation(){
            var discount_type = $('#discount_type').val();

            var store_total_amount = $('#store_total_amount').val();
            //console.log('store_total_amount= ' + store_total_amount);
            //console.log('store_total_amount= ' + typeof store_total_amount);
            store_total_amount = parseFloat(store_total_amount);
            //console.log('total= ' + typeof store_total_amount);

            var vat_amount = $('#vat_amount').val();
            //console.log('vat_amount= ' + vat_amount);
            //console.log('vat_amount= ' + typeof vat_amount);
            vat_amount = (vat_amount);
            var vat_subtraction = (store_total_amount*vat_amount)/100;
            //console.log('vat_subtraction= ' + vat_subtraction);
            //console.log('vat_subtraction= ' + typeof vat_subtraction);
            var after_vat_amount = store_total_amount+vat_subtraction
            $('#after_vat_amount').val(after_vat_amount);

            var transport = $('#transport').val();
            //console.log('transport= ' + transport);
            //console.log('transport= ' + typeof transport);
            transport = parseFloat(transport);
            var after_transport = after_vat_amount + transport;
            $('#after_transport').val(after_transport);

            var discount_amount = $('#discount_amount').val();
            //console.log('discount_amount= ' + discount_amount);
            //console.log('discount_amount= ' + typeof discount_amount);
            discount_amount = parseFloat(discount_amount);
            //console.log('discount_amount= ' + discount_amount);
            //console.log('discount_amount= ' + typeof discount_amount);

            if(discount_type == 'flat'){
                var discount = (store_total_amount+vat_subtraction+transport) - discount_amount ;
                var final_amount = discount ;
            }
            else{
                var discount = ((store_total_amount+vat_subtraction+transport)*discount_amount)/100;
                var final_amount = (store_total_amount+vat_subtraction+transport) - discount ;
            }
            //console.log('discount= ' + discount);
            //console.log('discount= ' + typeof discount);
            //console.log('final_amount= ' + final_amount);
            //console.log('final_amount= ' + typeof final_amount);
            if(discount_amount == 0){
                var after_discount_amount = after_transport;
            }else{
                var after_discount_amount = after_transport - discount;
            }
            $('#after_discount_amount').val(after_discount_amount);

            $('#total_amount').val(final_amount);

            var paid_amount = $('#paid_amount').val();
            paid_amount = parseFloat(paid_amount);
            //console.log('paid_amount= ' + paid_amount);
            //console.log('paid_amount= ' + typeof paid_amount);

            $('#due_amount').val(final_amount - paid_amount);
        }
        // onkeyup
        function paidAmount(){
            console.log('okk');
            var total = $('#total_amount').val();
            console.log('total= ' + total);
            console.log('total= ' + typeof total);

            var paid_amount = $('#paid_amount').val();
            console.log('paid_amount= ' + paid_amount);
            console.log('paid_amount= ' + typeof paid_amount);

            var due = total - paid_amount;
            console.log('due= ' + due);
            console.log('due= ' + typeof due);

            $('.backmoney').val(due);
        }

        $('.add').click(function () {
            var productCategory = $('.product_category_id').html();
            var productSubCategory = $('.product_sub_category_id').html();
            var productBrand = $('.product_brand_id').html();
            var productUnit = $('.product_unit_id').html();
            var product = $('.product_id').html();
            var n = ($('.neworderbody tr').length - 0) + 1;
            var tr = '<tr><td class="no">' + n + '</td>' +
                '<td width="18%"><select class="form-control product_id select2" name="product_id[]" id="product_id_'+n+'" onchange="getval('+n+',this);" required>' + product + '</select></td>' +
                '<td style="display: none"><div id="product_category_id_'+n+'"><select class="form-control product_category_id select2" name="product_category_id[]" required>' + productCategory + '</select></div></td>' +
                '<td style="display: none"><div id="product_sub_category_id_'+n+'"><select class="form-control product_sub_category_id select2" name="product_sub_category_id[]" required>' + productSubCategory + '</select></div></td>' +
                '<td style="display: none"><div id="product_brand_id_'+n+'"><select class="form-control product_brand_id select2" name="product_brand_id[]" id="product_brand_id_'+n+'" required>' + productBrand + '</select></div></td>' +
                '<td><div id="product_unit_id_'+n+'"><select class="form-control product_unit_id select2" name="product_unit_id[]" id="product_unit_id_'+n+'" required>' + productUnit + '</select></div></td>' +
                '<td><input type="number" min="1" max="" class="qty form-control" name="qty[]" required></td>' +
                '<td><input type="text" min="1" max="" class="price form-control" name="price[]" id="price_" value="" required></td>' +
                '<td><input type="number" min="0" value="0" max="100" class="dis form-control" name="discount[]" required></td>' +
                '<td><input type="text" class="amount form-control" name="sub_total[]" required></td>' +
                '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';

            $('.neworderbody').append(tr);

            //initSelect2();

            $('.select2').select2();

        });
        $('.add1').click(function () {
            var freeProduct = $('.free_product_id').html();
            var n = ($('.neworderbody1 tr').length - 0) + 1;
            var tr = '<tr><td class="no1">' + n + '</td>' +
                '<td><select class="form-control free_product_id select2" name="free_product_id[]" id="free_product_id_'+n+'">' + freeProduct + '</select></td>' +
                '<td><input type="button" class="btn btn-danger delete1" value="x"></td></tr>';

            $('.neworderbody1').append(tr);

            //initSelect2();

            $('.select2').select2();

        });

        $('.neworderbody').delegate('.delete', 'click', function () {
            $(this).parent().parent().remove();
            totalAmount();
        });

        $('.neworderbody').delegate('.qty, .price', 'keyup', function () {
            var gr_tot = 0;
            var tr = $(this).parent().parent();
            if(tr.find('.qty').val() && isNaN(tr.find('.qty').val())){
                alert("Must input numbers");
                tr.find('.qty').val('')
                return false;
            }
            var qty = tr.find('.qty').val() - 0;
            var stock_qty = tr.find('.stock_qty').val() - 0;
            if(qty > stock_qty){
                alert('You have limit cross of stock qty!');
                tr.find('.qty').val(0)
            }

            //var dis = tr.find('.dis').val() - 0;
            var price = tr.find('.price').val() - 0;

            //var total = (qty * price) - ((qty * price)/100);
            //var total = (qty * price) - ((qty * price * dis)/100);
            //var total = price - ((price * dis)/100);
            //var total = price - dis;
            var total = (qty * price);

            tr.find('.amount').val(total);
            //Total Price
            $(".amount").each(function() {
                isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
            });
            var final_total = gr_tot;
            console.log(final_total);
            var discount = $("#discount_amount").val();
            var final_total     = gr_tot - discount;
            //$("#total_amount").val(final_total.toFixed(2,2));
            $("#total_amount").val(final_total);
            var t = $("#total_amount").val(),
                a = $("#paid_amount").val(),
                e = t - a;
            //$("#remaining_amnt").val(e.toFixed(2,2));
            $("#due_amount").val(e);
            totalAmount();
        });

        $('#hideshow').on('click', function(event) {
            $('#content').removeClass('hidden');
            $('#content').addClass('show');
            $('#content').toggle('show');

        });


        // ajax
        function getval(row,sel)
        {
            //alert(row);
            //alert(sel.value);
            var current_row = row;
            var current_product_id = sel.value;

            $.ajax({
                url : "{{URL('product-relation-data')}}",
                method : "get",
                data : {
                    current_product_id : current_product_id
                },
                success : function (res){
                    //console.log(res)
                    console.log(res.data)
                    //console.log(res.data.categoryOptions)
                    $("#product_category_id_"+current_row).html(res.data.categoryOptions);
                    $("#product_sub_category_id_"+current_row).html(res.data.subCategoryOptions);
                    $("#product_brand_id_"+current_row).html(res.data.brandOptions);
                },
                error : function (err){
                    console.log(err)
                }
            })
        }

        $(function() {
            <?php
            if($transaction->payment_type == 'Cash'){
            ?>
            $('#check_number').hide();
            $('#check_date').hide();
            <?php } ?>
            $('#payment_type').change(function(){
                if($('#payment_type').val() == 'Check') {
                    $('#check_number').show();
                    $('#check_date').show();
                } else {
                    $('#check_number').val('');
                    $('#check_number').hide();
                    $('#check_date').hide();
                }
            });
        });
        // $(function() {
        //
        //     $('#online_platform').change(function(){
        //         if($('#online_platform').val() == 'online_invoice') {
        //             $('#online_platform_invoice_no').show();
        //         } else {
        //             $('#online_platform_invoice_no').val('');
        //             $('#online_platform_invoice_no').hide();
        //         }
        //     });
        // });
    </script>
@endpush


