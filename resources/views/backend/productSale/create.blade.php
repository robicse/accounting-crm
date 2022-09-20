@extends('backend._partial.dashboard')
<style>
    .requiredCustom{
        font-size: 20px;
        color: red;
        margin-top: 20px;
    }
</style>
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Add Sales Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb" style="display:inline!important;white-space:nowrap;" >
                <li>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary col-sm" type="button" >Add Product</a>
                    <a href="{{ route('productSales.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Sales Product</a>
                </li>
            </ul>
            <br>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add Sales Product</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productSales.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Party  <small class="requiredCustom">*</small></label>
                            <div class="col-md-6">
                                <select name="party_id" id="customer" class="form-control select2" required>
                                    <option value="">Select One</option>
                                    @foreach($parties as $party)
                                        <option value="{{$party->id}}">{{$party->name}}.{{$party->phone}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3"><a type="button" class="test btn btn-primary btn-sm" onclick="modal_customer()" data-toggle="modal"><i class="fa fa-plus"></i></a></div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right"  @if(Auth::user()->roles[0]->name == 'User') style="display: none" @endif> Store  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="store_id" id="store_id" class="form-control" required>
                                    <option value="">Select One</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{Auth::user()->roles[0]->name == 'User' ? 'selected':''}}>{{$store->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label  col-md-3 text-right">Payment Type  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="payment_type" id="payment_type" class="form-control" required>
                                    <option value="Cash" selected >Cash</option>
                                    <option value="Check">Check</option>
                                </select>
                                <span>&nbsp;</span>
                                <span>&nbsp;</span>
                                <input type="text" name="check_number" id="check_number" class="form-control" placeholder="Check Number">
                                <span>&nbsp;</span>
                                <input type="text" name="check_date" id="check_date" class="datepicker form-control" placeholder="Issue Deposit Date ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right"> Online Platform</label>
                            <div class="col-md-4">
                                <select name="online_platform_id" id="online_platform_id" class="form-control">
                                    <option value="" >Select One</option>
                                    @foreach($online_platforms as $online_platform)
                                        <option value="{{$online_platform->id}}" >{{$online_platform->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="online_platform_invoice_no" id="online_platform_invoice_no" class="form-control" placeholder="Invoice No">
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label class="control-label col-md-3 text-right" style="color: red">Transport/Labour</label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <input type="text" name="transport_cost" class="form-control" placeholder="Transport Cost" >--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Transport Area</label>
                            <div class="col-md-8">
                                <input type="text" name="transport_area" class="form-control" placeholder="Transport Area">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Date <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <input type="text" name="date" class="datepicker form-control" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Note</label>
                            <div class="col-md-8">
                                <input type="text" name="note" class="form-control" placeholder="Note">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Reference Name</label>
                            <div class="col-md-8">
                                <input type="text" name="reference_name" class="form-control" placeholder="Reference Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Descriptions</label>
                            <div class="col-md-8">
                                <textarea name="conditions" id="conditions" class="form-control"  rows="3"></textarea>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Product">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>

                                    <th >ID</th>
                                    <th>Product <small class="requiredCustom">*</small></th>
                                    <th style="display: none">Category</th>
                                    <th style="display: none">Sub Category</th>
                                    <th style="display: none">Brand</th>
                                    <th style="display: none">Unit</th>
                                    <th>Return</th>
                                    <th>Stock Qty</th>
                                    <th>Qty <small class="requiredCustom">*</small></th>
                                    <th>Price <small class="requiredCustom">*</small></th>
                                    <th>Sub Total</th>
                                    <th>Action</th>

                                </tr>
                                </thead>

                                <tbody class="neworderbody">
                                <tr>
                                    <td width="5%" class="no">1</td>
                                    <td width="15%">
                                        <select class="form-control product_id select2" name="product_id[]" id="product_id_1" onchange="getval(1,this);" required>
                                            <option value="">Select  Product</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%" style="display: none">
                                        <div id="product_category_id_1">
                                            <select class="form-control product_category_id select2" name="product_category_id[]"  required>
                                                <option value="">Select  Category</option>
                                                @foreach($productCategories as $productCategory)
                                                    <option value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td style="display: none">
                                        <div id="product_sub_category_id_1">
                                            <select class="form-control product_sub_category_id select2" name="product_sub_category_id[]">
                                                <option value="">Select  Sub Category</option>
                                                @foreach($productSubCategories as $productSubCategory)
                                                    <option value="{{$productSubCategory->id}}">{{$productSubCategory->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td style="display: none">
                                        <div id="product_brand_id_1">
                                            <select class="form-control product_brand_id select2" name="product_brand_id[]" required>
                                                <option value="">Select  Brand</option>
                                                @foreach($productBrands as $productBrand)
                                                    <option value="{{$productBrand->id}}">{{$productBrand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td  style="display: none">
                                        <div id="product_unit_id_1">
                                            <select class="form-control product_unit_id select2" name="product_unit_id[]" required>
                                                <option value="">Select Unit</option>
                                                @foreach($productUnits as $productUnit)
                                                    <option value="{{$productUnit->id}}">{{$productUnit->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td width="12%">
                                        <select name="return_type[]" id="return_type_id_1" class="form-control" >
                                            <option value="returnable" selected>returnable</option>
                                            <option value="not returnable">not returnable</option>
                                        </select>
                                    </td>
                                    <td width="12%">
                                        <input type="number" id="stock_qty_1" class="stock_qty form-control" name="stock_qty[]" value="" readonly >
                                    </td>
                                    <td width="12%">
                                        <input type="text" min="1" max="" class="qty form-control" name="qty[]" value="" required >
                                    </td>
                                    <td width="12%">
                                        <input type="text" id="price_1" min="1" max="" class="price form-control" name="price[]" value="" required >
                                    </td>
                                    <td width="12%">
                                        <input type="text" class="amount form-control" id="sub_total" name="sub_total[]">
                                    </td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>


                                    <th >
                                        Vat(Percentage):
                                        <input type="text" class="form-control" name="vat_amount" id="vat_amount" onblur="vatAmount('')">
                                    </th>
                                    <th >
                                        Transport/Labour:
                                        <input type="text" id="transport" name="transport_cost" class="form-control" placeholder="Transport Cost" onblur="transportCost('')" value="0">
                                    </th>
                                    <th width="10%">
                                        Type:
                                        <select name="discount_type" id="discount_type" class="form-control" >
                                            <option value="flat" selected>flat</option>
                                            <option value="percentage">percentage</option>
                                        </select>
                                    </th>
                                    <th>
                                        Discount:
                                        <input type="text" id="discount_amount" class="form-control" name="discount_amount" onkeyup="discountAmount('')" value="0">
                                    </th>


                                    <th >
                                        Total:
                                        <input type="hidden" id="store_total_amount" class="form-control">
                                        <input type="text" id="total_amount" class=" form-control" name="total_amount">
                                    </th>
                                    <th width="15%">
                                        Paid Amount:
                                        <input type="text" id="paid_amount" class="getmoney form-control" onkeyup="paidAmount('')" name="paid_amount" value="0">
                                    </th>
                                    <th width="15%">
                                        Due Amount:
                                        <input type="text" id="due_amount" class="backmoney form-control" name="due_amount">
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="table-responsive" style="display:none;">
                                <input type="button" class="btn btn-primary add1 " style="margin-left: 57px;" value="Add Free Product">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Free Product <small class="requiredCustom">*</small></th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody class="neworderbody1">
                                    <tr>
                                        <td width="5%" class="no1">1</td>
                                        <td style="display: none"><input class="form-control" type="hidden" name="product_sale_id"></td>
                                        <td width="20%">
                                            <select class="form-control free_product_id select2" name="free_product_id[]" id="free_product_id_1" >
                                                <option value="">Select One</option>
                                                @foreach($freeProducts as $freeProduct)
                                                    <option value="{{$freeProduct->id}}">{{$freeProduct->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">

                                </label>
                                <div class="col-md-8">
{{--                                    <label class="checkbox-inline"><input type="checkbox" name="print_now" value="1" style="margin-right: 5px;height: 24px;width: 30px;"><span style="height: 30px;background-color: green;padding: 10px;border-radius: 3px;">Redirect Print Page</span></label>--}}
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Product Sale</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>

        <!-- Credit Sale -->
        <div id="customar_modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:green; color: white">
                        <h4>customer</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="customerErrr3" class="alert hide"> </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="panel panel-bd lobidrag">
                                    <div class="panel-body">
                                        <form action="{{ route('parties.store.new') }}" id="customer_insert" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Name <small class="requiredCustom">*</small></label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="hidden" name="type" value="customer">
                                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" placeholder="Customer Name" name="name" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Phone<small class="requiredCustom">*</small></label>
                                                <div class="col-md-8">
                                                    <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" placeholder="Customer Phone" name="phone" id="phone" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Email</label>
                                                <div class="col-md-8">
                                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="Customer Email" name="email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Address<small class="requiredCustom">*</small></label>
                                                <div class="col-md-8">
                                                    <textarea rows="5" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" type="text" placeholder="Customer Address" name="address" required></textarea>
                                                    @if ($errors->has('address'))
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3"></label>
                                                <div class="col-md-8">
                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Party</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        // onkeyup
        // function vatAmount(){
        //     var sub_total = $('#total_amount').val();
        //     console.log('sub_total= ' + sub_total);
        //     console.log('sub_total= ' + typeof sub_total);
        //     sub_total = parseInt(sub_total);
        //
        //     var vat_amount = $('#vat_amount').val();
        //     console.log('vat_amount= ' + vat_amount);
        //     console.log('vat_amount= ' + typeof vat_amount);
        //     vat_amount = (vat_amount);
        //
        //     var vat_subtraction = (sub_total*vat_amount)/100;
        //     console.log('vat_subtraction= ' + vat_subtraction);
        //     console.log('vat_subtraction= ' + typeof vat_subtraction);
        //
        //     var grand_total =( sub_total + vat_subtraction);
        //     console.log('grand_total= ' + grand_total);
        //     console.log('grand_total= ' + typeof grand_total);
        //     grand_total = (grand_total);
        //
        //     $('#show_vat_amount').val(vat_subtraction);
        //     $('#store_total_amount').val(grand_total);
        //     $('#total_amount').val(grand_total);
        //     $('#due_amount').val(grand_total);
        // }

        // onblur
        function vatAmount(){
           //  var sub_total = $('#sub_total').val();
           //  console.log('sub_total= ' + sub_total);
           //  console.log('sub_total= ' + typeof sub_total);
           //  var vat_amount = parseInt($('#vat_amount').val()).toFixed(2);
           //  console.log('vat_amount= ' + vat_amount);
           //  console.log('vat_amount= ' + typeof vat_amount);
           //  var vat_subtraction = parseInt((sub_total*vat_amount)/100);
           //  console.log('vat_subtraction= ' + vat_subtraction);
           //  console.log('vat_subtraction= ' + typeof vat_subtraction);
           //  var grand_total = (sub_total + vat_subtraction);
           //  // console.log(grand_total);
           // // var vat_subtraction = parseFloat(vat_subtraction).toFixed(2);
           //  var grand_total = parseInt(grand_total).toFixed(2);
           //  //$('#vat_amount').val(vat_subtraction);
           //  //$('#discount_amount').val(discount_amount);
           //  $('#grand_total').val(grand_total);
           //  $('#total_amount').val(grand_total);
           //  $('#due_amount').val(grand_total);



                var sub_total = $('#store_total_amount').val();
                console.log('sub_total= ' + sub_total);
                console.log('sub_total= ' + typeof sub_total);
                sub_total = parseFloat(sub_total);

                var vat_amount = $('#vat_amount').val();
                console.log('vat_amount= ' + vat_amount);
                console.log('vat_amount= ' + typeof vat_amount);
                vat_amount = (vat_amount);

                var vat_subtraction = (sub_total*vat_amount)/100;
                console.log('vat_subtraction= ' + vat_subtraction);
                console.log('vat_subtraction= ' + typeof vat_subtraction);

                var transport = $('#transport').val();
                console.log('transport= ' + transport);
                console.log('transport= ' + typeof transport);
                transport = parseFloat(transport);

                var grand_total =( sub_total + vat_subtraction + transport);
                console.log('grand_total= ' + grand_total);
                console.log('grand_total= ' + typeof grand_total);
                grand_total = (grand_total);

                $('#show_vat_amount').val(vat_subtraction);
                $('#store_total_amount').val(grand_total);
                $('#total_amount').val(grand_total);
                $('#due_amount').val(grand_total);



        }
        function transportCost(){

            var sub_total = $('#store_total_amount').val();
            console.log('sub_total= ' + sub_total);
            console.log('sub_total= ' + typeof sub_total);
            sub_total = parseFloat(sub_total);

            var transport = $('#transport').val();
            console.log('transport= ' + transport);
            console.log('transport= ' + typeof transport);
            transport = parseFloat(transport);

                var grand_total =( sub_total + transport);
                console.log('grand_total= ' + grand_total);
                console.log('grand_total= ' + typeof grand_total);
                grand_total = parseFloat(grand_total);

                $('#total_amount').val(grand_total);
                $('#due_amount').val(grand_total);
               // $('#store_total_amount').val(grand_total);



        }
        // onkeyup
        function discountAmount(){
            var discount_type = $('#discount_type').val();

            //var total = $('#total_amount').val();
            //console.log('total= ' + total);
            //console.log('total= ' + typeof total);
            //total = parseInt(total);
            //console.log('total= ' + typeof total);

            var store_total_amount = $('#store_total_amount').val();
            console.log('store_total_amount= ' + store_total_amount);
            console.log('store_total_amount= ' + typeof store_total_amount);
            store_total_amount = parseFloat(store_total_amount);
            console.log('total= ' + typeof store_total_amount);

            var discount_amount = $('#discount_amount').val();
            console.log('discount_amount= ' + discount_amount);
            console.log('discount_amount= ' + typeof discount_amount);
            discount_amount = parseFloat(discount_amount);
            console.log('discount_amount= ' + discount_amount);
            console.log('discount_amount= ' + typeof discount_amount);

            var transport = $('#transport').val();
            console.log('transport= ' + transport);
            console.log('transport= ' + typeof transport);
            transport = parseFloat(transport);

            if(discount_type == 'flat'){
                var final_amount = (store_total_amount+transport) - discount_amount ;
            }
            else{
                var per = ((store_total_amount+transport)*discount_amount)/100;
                var final_amount = store_total_amount - per +transport ;
            }
            console.log('final_amount= ' + final_amount);
            console.log('final_amount= ' + typeof final_amount);

            $('#total_amount').val(final_amount);
            $('#due_amount').val(final_amount);
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

        $(function () {
            $('.add').click(function () {
                var productCategory = $('.product_category_id').html();
                var productSubCategory = $('.product_sub_category_id').html();
                var productBrand = $('.product_brand_id').html();
                var productUnit = $('.product_unit_id').html();
                var product = $('.product_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control product_id select2" name="product_id[]" id="product_id_'+n+'" onchange="getval('+n+',this);" required>' + product + '</select></td>' +
                    '<td style="display: none" width="30%"><div id="product_category_id_'+n+'"><select class="form-control product_category_id select2" name="product_category_id[]" required>' + productCategory + '</select></div></td>' +
                    '<td style="display: none"><div id="product_sub_category_id_'+n+'"><select class="form-control product_sub_category_id select2" name="product_sub_category_id[]" required>' + productSubCategory + '</select></div></td>' +
                    '<td style="display: none"><div id="product_brand_id_'+n+'"><select class="form-control product_brand_id select2" name="product_brand_id[]" id="product_brand_id_'+n+'" required>' + productBrand + '</select></div></td>' +
                    '<td style="display: none"><div id="product_unit_id_'+n+'"><select class="form-control product_unit_id select2" name="product_unit_id[]" id="product_unit_id_'+n+'" required>' + productUnit + '</select></div></td>' +
                    '<td><select name="return_type[]" id="return_type_id_'+n+'" class="form-control" ><option value="returnable" selected>returnable</option><option value="not returnable">not returnable</option></select></td>' +
                    '<td><input type="number" id="stock_qty_'+n+'" class="stock_qty form-control" name="stock_qty[]" readonly></td>' +
                    '<td><input type="text" min="1" max="" class="qty form-control" name="qty[]" required></td>' +
                    '<td><input type="text" id="price_'+n+'" min="1" max="" class="price form-control" name="price[]" value="" required></td>' +
                    //'<td><input type="number" min="0" value="0" max="100" class="dis form-control" name="discount[]" required></td>' +
                    '<td><input type="text" class="amount form-control" name="sub_total[]" required></td>' +
                    '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';

                $('.neworderbody').append(tr);

                //initSelect2();

                $('.select2').select2();

            });1
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

            $('.neworderbody1').delegate('.delete1', 'click', function () {
                $(this).parent().parent().remove();
                // totalAmount();
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



        });


        // ajax
        function getval(row,sel)
        {
            var store_id = $('#store_id').val();
            if(store_id){
                //console.log(store_id)
                //alert(row);
                //alert(sel.value);
                var current_row = row;
                var current_product_id = sel.value;
                if(current_row > 1){
                    var previous_row = current_row - 1;
                    var previous_product_id = $('#product_id_'+previous_row).val();
                    if(previous_product_id === current_product_id){
                        $('#product_id_'+current_row).val('');
                        alert('You selected same product, Please selected another product!');
                        return false
                    }
                }

                $.ajax({
                    url : "{{URL('product-sale-relation-data')}}",
                    method : "get",
                    data : {
                        store_id : store_id,
                        current_product_id : current_product_id,
                    },
                    success : function (res){
                        //console.log(res)
                        console.log(res.data)
                        //console.log(res.data.categoryOptions)
                        $("#product_category_id_"+current_row).html(res.data.categoryOptions);
                        $("#product_sub_category_id_"+current_row).html(res.data.subCategoryOptions);
                        $("#product_brand_id_"+current_row).html(res.data.brandOptions);
                        $("#product_unit_id_"+current_row).html(res.data.unitOptions);
                        $("#stock_qty_"+current_row).val(res.data.current_stock);
                        $("#price_"+current_row).val(res.data.mrp_price);
                    },
                    error : function (err){
                        console.log(err)
                    }
                })
            }else{
                alert('Please select first store!');
                location.reload();
            }
        }
        function modal_customer(){
            $('#customar_modal').modal('show');
        }

        //new customer insert
        $("#customer_insert").submit(function(e){
            e.preventDefault();
            //var customerMess    = $("#customerMess3");
            //var customerErrr    = $("#customerErrr3");
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function()
                {
                    //customerMess.removeClass('hide');
                    //customerErrr.removeClass('hide');
                },
                success: function(data)
                {
                    console.log(data);
                    if (data.exception) {
                        customerErrr.addClass('alert-danger').removeClass('alert-success').html(data.exception);
                    }else{
                        $('#customer').append('<option value = "' + data.id + '"  selected> '+ data.name + ' </option>');
                        console.log(data.id);
                        $("#customar_modal").modal('hide');
                    }
                    console.log(data)
                },
                error: function(xhr)
                {
                    alert('failed!');
                }
            });
        });
        $('#phone').keyup(function (){
            var phone = $(this).val();
            $.ajax({
                url :  "{{URL('check-phone-number')}}",
                method : "get",
                data : {
                    phone : phone
                },
                success : function (res){
                    console.log(res)
                    if(res.data == 'Found'){
                        $('#phone').val('')
                        alert('Phone Number already exists, please add another!')
                        return false
                    }
                },
                error : function (err){
                    console.log(err)
                }

            })

        })

        function hidemodal() {
            var x = document.getElementById("customar_modal");
            x.style.display = "none";
        }

        $(function() {
            $('#check_number').hide();
            $('#check_date').hide();
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

        // function transportCost(){
        //     var price = $('#transport').val();
        //     // tr.find('.amount').val(price);
        //     // tr.find('.backmoney').val(price);
        //     // totalAmount();
        //
        //     $('#total_amount').val(price);
        //     $('#due_amount').val(price);
        // }


        {{--$(function() {--}}
        {{--    $('#online_platform_invoice_no').hide();--}}
        {{--    $('#online_platform_id').change(function(){--}}
        {{--        if($('#online_platform_id').val() == {{$online_platform->name}}) {--}}
        {{--            $('#online_platform_invoice_no').show();--}}
        {{--        } else {--}}
        {{--            $('#online_platform_invoice_no').val('');--}}
        {{--            $('#online_platform_invoice_no').hide();--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
    </script>
@endpush




