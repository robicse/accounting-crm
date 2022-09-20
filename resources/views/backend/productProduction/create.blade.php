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
                <h1><i class=""></i> Add Production Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('productProductions.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Production Product</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add Production Product</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productProductions.store') }}">
                        @csrf

                        <div class="table-responsive">
                            <input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Product">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th >ID</th>
                                    <th>Raw Product <small class="requiredCustom">*</small></th>
                                    <th style="display: none">Category</th>
{{--                                    <th>Sub Category</th>--}}
                                    <th>Brand</th>
                                    <th>Stock Qty</th>
                                    <th>Used Qty (Stock Out) <small class="requiredCustom">*</small></th>
                                    <th style="display: none">Production</th>
                                    <th>Costing Price <small class="requiredCustom">*</small></th>
                                    <th>Sub Total</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody class="neworderbody">
                                <tr>
                                    <td width="5%" class="no">1</td>
                                    <td width="20%">
                                        <select class="form-control product_id select2" name="product_id[]" id="product_id_1" onchange="getval(1,this);" required>
                                            <option value="">Select  Product</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="display: none">
                                        <div id="product_category_id_1">
                                            <select class="form-control product_category_id select2" name="product_category_id[]"  required>
                                                <option value="">Select  Category</option>
                                                @foreach($productCategories as $productCategory)
                                                    <option value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
{{--                                    <td width="12%">--}}
{{--                                        <div id="product_sub_category_id_1">--}}
{{--                                            <select class="form-control product_sub_category_id select2" name="product_sub_category_id[]">--}}
{{--                                                <option value="">Select  Sub Category</option>--}}
{{--                                                @foreach($productSubCategories as $productSubCategory)--}}
{{--                                                    <option value="{{$productSubCategory->id}}">{{$productSubCategory->name}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
                                    <td width="12%">
                                        <div id="product_brand_id_1">
                                            <select class="form-control product_brand_id select2" name="product_brand_id[]" required>
                                                <option value="">Select  Brand</option>
                                                @foreach($productBrands as $productBrand)
                                                    <option value="{{$productBrand->id}}">{{$productBrand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td width="12%">
                                        <input type="number" id="stock_qty_1" class="stock_qty form-control" name="stock_qty[]" value="" readonly >
                                    </td>
                                    <td width="12%">
                                        <input type="number" min="1" max="" class="qty form-control" name="qty[]" value="" required >
                                    </td>
                                    <td width="8%" style="display: none">
                                        <input type="text" min="1" max="" class="qty form-control" name="production[]" value="">
                                    </td>
                                    <td width="15%">
                                        <input type="number" id="price_1" min="1" max="" class="price form-control" name="price[]" value="" required >
                                    </td>
                                    <td width="15%">
                                        <input type="text" class="amount form-control" name="sub_total[]">
                                    </td>
                                </tr>

                                </tbody>

                            </table>

                            <div>&nbsp;</div>




                            <div id="myRadioGroup" style="text-align: center">
                                <input type="radio" name="products" checked="checked" value="2"  /> Existing Finish Goods Product
                                <input type="radio" name="products" value="3" /> New Finish Goods Product

                                <div>&nbsp;</div>


                                <div class="form-group row" @if(Auth::user()->roles[0]->name == 'User') style="display: none" @endif>
                                    <label class="control-label col-md-3 text-right">Store  <small class="requiredCustom">*</small></label>
                                    <div class="col-md-8">
                                        <select name="store_id" id="store_id" class="form-control" >
                                            {{--                                    <option value="">Select One</option>--}}
                                            @foreach($stores as $store)
                                                <option value="{{$store->id}}" {{Auth::user()->roles[0]->name == 'User' ? 'selected':''}}>{{$store->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none">
                                    <label class="control-label col-md-3 text-right">Payment Type  <small class="requiredCustom">*</small></label>
                                    <div class="col-md-8">
                                        <select name="payment_type" id="payment_type" class="form-control">
                                            <option value="">Select One</option>
                                            <option value="Cash" selected>Cash</option>
                                            <option value="Check">Check</option>
                                        </select>
                                        <span>&nbsp;</span>
                                        <input type="text" name="check_number" id="check_number" class="form-control" placeholder="Check Number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 text-right">Date <small class="requiredCustom">*</small></label>
                                    <div class="col-md-8">
                                        <input type="text" name="date" class="datepicker form-control" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>

                                <div id="Products2" class="desc">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Existing FG Product <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <select name="existing_product_id" id="existing_product_id" class="form-control">
                                                <option value="">Select One</option>
                                                @foreach($finishGoodProducts as $finishGoodProduct)
                                                    <option value="{{$finishGoodProduct->id}}">{{$finishGoodProduct->name}}</option>
                                                @endforeach()
                                            </select>
                                            @if ($errors->has('existing_product_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('existing_product_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Qty (Stock In) <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('existing_qty') ? ' is-invalid' : '' }}" type="text" placeholder="Stock IN Qty" name="existing_qty" id="existing_qty">
                                            @if ($errors->has('existing_qty'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('existing_qty') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Price <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('existing_price') ? ' is-invalid' : '' }}" type="text" placeholder="Price" name="existing_price" id="existing_price">
                                            @if ($errors->has('existing_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('existing_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">M.R.P Price <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('existing_mrp_price') ? ' is-invalid' : '' }}" type="text" placeholder="M.R.P Price" name="existing_mrp_price" id="existing_mrp_price">
                                            @if ($errors->has('existing_mrp_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('existing_mrp_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div id="Products3" class="desc" style="display: none;">
                                    <div class="form-group row" style="display: none">
                                        <label class="control-label col-md-3 text-right">Product Type <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <select name="product_type" id="product_type" class="form-control">
                                                <option value="Finish Goods" selected>Finish Goods</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">FG Product Name <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" placeholder="Name" name="name" id="name">
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">FG Product Model <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" type="text" placeholder="Model" name="model" id="model">
                                            @if ($errors->has('model'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('model') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Final FG Product Name <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="final_name" id="final_name" readonly>
                                            <span><strong>ProductName.ProductModel</strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">FG Qty (Stock In) <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('new_qty') ? ' is-invalid' : '' }}" type="text" placeholder="Stock IN Qty" name="new_qty" id="new_qty">
                                            @if ($errors->has('new_qty'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('new_qty') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Price <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('new_price') ? ' is-invalid' : '' }}" type="text" placeholder="Price" name="new_price" id="new_price">
                                            @if ($errors->has('new_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('new_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">M.R.P Price <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('new_mrp_price') ? ' is-invalid' : '' }}" type="text" placeholder="M.R.P Price" name="new_mrp_price" id="new_mrp_price">
                                            @if ($errors->has('new_mrp_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('new_mrp_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Product Category <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <select name="new_product_category_id" id="new_product_category_id" class="form-control">
                                                <option value="">Select One</option>
                                                @foreach($productCategories as $productCategory)
                                                    <option value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                                                @endforeach()
                                            </select>
                                            @if ($errors->has('new_product_category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('new_product_category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Product Brand <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <select name="new_product_brand_id" id="new_product_brand_id" class="form-control">
                                                <option value="">Select One</option>
                                                @foreach($productBrands as $productBrand)
                                                    <option value="{{$productBrand->id}}">{{$productBrand->name}}</option>
                                                @endforeach()
                                            </select>
                                            @if ($errors->has('new_product_brand_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('new_product_brand_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Product Unit <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <select name="new_product_unit_id" id="new_product_unit_id" class="form-control">
                                                <option value="">Select One</option>
                                                @foreach($productUnits as $productUnit)
                                                    <option value="{{$productUnit->id}}">{{$productUnit->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('new_product_unit_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('new_product_unit_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Description</label>
                                        <div class="col-md-8">
                                            <textarea rows="4" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" type="text" placeholder="description" name="description"> </textarea>
                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Image <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input type="file" id="image" name="image" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Barcode <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control{{ $errors->has('barcode') ? ' is-invalid' : '' }}" type="text" placeholder="Barcode" name="barcode" id="barcode">
                                            @if ($errors->has('barcode'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('barcode') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 text-right">Status <span style="color: red">*</span></label>
                                        <div class="col-md-8">
                                            <select name="status" id="status" class="form-control">
                                                <option value="1">Stock In</option>
                                                <option value="0">Stock Out</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-8">
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

@endsection

@push('js')
    <script>

        function totalAmount(){
            var t = 0;
            $('.amount').each(function(i,e){
                var amt = $(this).val()-0;
                t += amt;
            });
            $('#total_amount').val(t);

        }
        $(function () {
            $('.getmoney').change(function(){
                var total = $('#total_amount').val();
                var getmoney = $(this).val();
                var t = total - getmoney;
                $('.backmoney').val(t);
            });
            $('.add').click(function () {
                var productCategory = $('.product_category_id').html();
                var productSubCategory = $('.product_sub_category_id').html();
                var productBrand = $('.product_brand_id').html();
                var product = $('.product_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control product_id select2" name="product_id[]" id="product_id_'+n+'" onchange="getval('+n+',this);" required>' + product + '</select></td>' +
                    '<td style="display: none"><div id="product_category_id_'+n+'"><select class="form-control product_category_id select2" name="product_category_id[]" required>' + productCategory + '</select></div></td>' +
                    // '<td><div id="product_sub_category_id_'+n+'"><select class="form-control product_sub_category_id select2" name="product_sub_category_id[]" required>' + productSubCategory + '</select></div></td>' +
                    '<td><div id="product_brand_id_'+n+'"><select class="form-control product_brand_id select2" name="product_brand_id[]" id="product_brand_id_'+n+'" required>' + productBrand + '</select></div></td>' +
                    '<td><input type="number" id="stock_qty_'+n+'" class="stock_qty form-control" name="stock_qty[]" readonly></td>' +
                    '<td><input type="number" min="1" max="" class="qty form-control" name="qty[]" required></td>' +
                    '<td style="display: none"><input type="text" min="1" max="" class="production form-control" name="production[]"></td>' +
                    '<td><input type="text" id="price_'+n+'" min="1" max="" class="price form-control" name="price[]" value="" required></td>' +
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
                var gr_tot = 0;
                var tr = $(this).parent().parent();
                var qty = tr.find('.qty').val() - 0;
                var stock_qty = tr.find('.stock_qty').val() - 0;
                if(qty > stock_qty){
                    alert('You have limit cross of stock qty!');
                    tr.find('.qty').val(0)
                }

                var price = tr.find('.price').val() - 0;


                var total = (qty * price);

                tr.find('.amount').val(total);
                //Total Price
                $(".amount").each(function() {
                    isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
                });
                var final_total = gr_tot;
                console.log(final_total);

                $("#total_amount").val(final_total);

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

                $.ajax({
                    url : "{{URL('product-production-relation-data')}}",
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



        $(document).ready(function() {
            $("input[name$='products']").click(function() {
                var test = $(this).val();

                $("div.desc").hide();
                $("#Products" + test).show();
            });
        });

        $('#name').keyup(function(){
            var name = $('#name').val();
            var model = $('#model').val();

            var final_name = name + '.' + model
            $('#final_name').val(final_name);
        })

        $('#model').keyup(function(){
            var name = $('#name').val();
            var model = $('#model').val();

            if(name == ''){
                alert('Name is empty!');
                $('#model').val('');
            }

            var final_name = name + '.' + model
            $('#final_name').val(final_name);
        })
    </script>
@endpush


