@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Sale Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('productSales.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Sale Product</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Sale Product</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productSales.update',$productSale->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store  <small class="text-danger">*</small></label>
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
                            <label class="control-label col-md-3 text-right">Party  <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <select name="party_id" id="party_id" class="form-control select2">
                                    <option value="">Select One</option>
                                    @foreach($parties as $party)
                                        <option value="{{$party->id}}" {{$party->id == $productSale->party_id ? 'selected' : ''}}>{{$party->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Payment Type  <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <select name="payment_type" id="payment_type" class="form-control" >
                                    <option value="">Select One</option>
                                    <option value="Cash" {{'Cash' == $productSale->payment_type ? 'selected' : ''}}>Cash</option>
                                    <option value="Check" {{'Check' == $productSale->payment_type ? 'selected' : ''}}>Check</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Delivery Services  <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <select name="delivery_service" id="delivery_service" class="form-control" >
                                    <option value="">Select One</option>
                                    <option value="Sundorban Kuriar Service" {{'Sundorban Kuriar Service' == $productSale->delivery_service ? 'selected' : ''}}>Sundorban Kuriar Service</option>
                                    <option value="SA Paribahan" {{'SA Paribahan' == $productSale->delivery_service ? 'selected' : ''}}>SA Paribahan</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            {{--<input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Product">--}}
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Brand</th>
                                    <th>Returnable</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                                </thead>
                                <tbody class="neworderbody">
                                @foreach($productSaleDetails as $key => $productSaleDetail)
                                    <tr>
                                        @php
                                            $current_row = $key+1;
                                        @endphp
                                        <td>
                                            <select class="form-control product_id select2" name="product_id[]" onchange="getval({{$current_row}},this);" required>
                                                <option value="">Select  Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}" {{$product->id == $productSaleDetail->product_id ? 'selected' : ''}}>{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" class="form-control" name="product_Sale_detail_id[]" value="{{$productSaleDetail->id}}" >
                                        </td>
                                        <td>
                                            <div id="product_category_id_{{$current_row}}">
                                                <select class="form-control product_category_id" name="product_category_id[]" readonly required>
                                                    <option value="">Select  Category</option>
                                                    @foreach($productCategories as $productCategory)
                                                        <option value="{{$productCategory->id}}" {{$productCategory->id == $productSaleDetail->product_category_id ? 'selected' : ''}}>{{$productCategory->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div id="product_sub_category_id_{{$current_row}}">
                                                <select class="form-control product_sub_category_id" name="product_sub_category_id[]" readonly>
                                                    <option value="">Select  Sub Category</option>
                                                    @foreach($productSubCategories as $productSubCategory)
                                                        <option value="{{$productSubCategory->id}}" {{$productSubCategory->id == $productSaleDetail->product_sub_category_id ? 'selected' : ''}}>{{$productSubCategory->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div id="product_brand_id_{{$current_row}}">
                                                <select class="form-control product_brand_id" name="product_brand_id[]" readonly required>
                                                    <option value="">Select  Brand</option>
                                                    @foreach($productBrands as $productBrand)
                                                        <option value="{{$productBrand->id}}" {{$productBrand->id == $productSaleDetail->product_brand_id ? 'selected' : ''}}>{{$productBrand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="return_type[]" id="return_type_id_{{$current_row}}" class="form-control" >
                                                <option value="returnable"  {{'returnable' == $productSaleDetail->return_type ? 'selected' : ''}}>returnable</option>
                                                <option value="not returnable" {{'not returnable' == $productSaleDetail->return_type ? 'selected' : ''}}>not returnable</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" min="1" max="" class="qty form-control" name="qty[]" value="{{$productSaleDetail->qty}}" required >
                                        </td>
                                        <td>
                                            <input type="number" min="1" max="" class="price form-control" name="price[]" value="{{$productSaleDetail->price}}" required >
                                        </td>
                                        <td>
                                            <input type="text" class="amount form-control" name="sub_total[]" value="{{$productSaleDetail->sub_total}}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2">
                                        Discount Type:
                                        <select name="discount_type" id="discount_type" class="form-control" >
                                            <option value="flat" {{'flat' == $productSale->return_type ? 'selected' : ''}}>flat</option>
                                            <option value="percentage" {{'percentage' == $productSale->return_type ? 'selected' : ''}}>percentage</option>
                                        </select>
                                    </th>
                                    <th colspan="2">
                                        Discount Amount:
                                        <input type="text" class="discount_amount form-control" name="discount_amount" value="{{$productSale->discount_amount}}">
                                    </th>
                                    <th colspan="2">
                                        Total:
                                        <input type="text" class="amount form-control" name="total_amount" value="{{$productSale->total_amount}}">
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>
                                </tfoot>
                            </table>
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
    <script>

        function totalAmount(){
            var t = 0;
            $('.amount').each(function(i,e){
                var amt = $(this).val()-0;
                t += amt;
            });
            $('.total').html(t);
        }
        $(function () {
            $('.getmoney').change(function(){
                var total = $('.total').html();
                var getmoney = $(this).val();
                //var t = getmoney - total;
                var t = total - getmoney;
                var t_final_val = t.toFixed(2);
                $('.backmoney').val(t_final_val);
                $('.total').val(total);
            });
            $('.add').click(function () {
                var productCategory = $('.product_category_id').html();
                var productSubCategory = $('.product_sub_category_id').html();
                var productBrand = $('.product_brand_id').html();
                var product = $('.product_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control product_id select2" name="product_id[]" id="product_id_'+n+'" onchange="getval('+n+',this);" required>' + product + '</select></td>' +
                    '<td><div id="product_category_id_'+n+'"><select class="form-control product_category_id select2" name="product_category_id[]" required>' + productCategory + '</select></div></td>' +
                    '<td><div id="product_sub_category_id_'+n+'"><select class="form-control product_sub_category_id select2" name="product_sub_category_id[]" required>' + productSubCategory + '</select></div></td>' +
                    '<td><div id="product_brand_id_'+n+'"><select class="form-control product_brand_id select2" name="product_brand_id[]" id="product_brand_id_'+n+'" required>' + productBrand + '</select></div></td>' +
                    '<td><input type="number" min="1" max="" class="qty form-control" name="qty[]" required></td>' +
                    '<td><input type="text" min="1" max="" class="price form-control" name="price[]" value="" required></td>' +
                    //'<td><input type="number" min="0" value="0" max="100" class="dis form-control" name="discount[]" required></td>' +
                    '<td><input type="text" class="amount form-control" name="sub_total[]" required></td>' +
                    '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';

                $('.neworderbody').append(tr);

                //initSelect2();

                $('.select2').select2();

            });
            $('.neworderbody').delegate('.delete', 'click', function () {
                $(this).parent().parent().remove();
                totalAmount();
            });

            $('.neworderbody').delegate('.qty, .price', 'keyup', function () {
                var tr = $(this).parent().parent();
                var qty = tr.find('.qty').val() - 0;
                //var dis = tr.find('.dis').val() - 0;
                var price = tr.find('.price').val() - 0;

                //var total = (qty * price) - ((qty * price)/100);
                //var total = (qty * price) - ((qty * price * dis)/100);
                //var total = price - ((price * dis)/100);
                //var total = price - dis;
                var total = (qty * price);

                tr.find('.amount').val(total);
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

    </script>
@endpush


