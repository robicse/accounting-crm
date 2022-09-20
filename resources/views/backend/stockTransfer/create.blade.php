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
                <h1><i class=""></i> Add Stock Transfer</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('stockTransfers.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Stock Transfer</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add Stock Transfer</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('stockTransfers.store') }}">
                        @csrf
                        <div class="form-group row" @if(Auth::user()->roles[0]->name == 'User') style="display: none" @endif>
                            <label class="control-label col-md-3 text-right">From Store  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="from_store_id" id="from_store_id" class="form-control" >
                                    <option value="">Select</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{Auth::user()->roles[0]->name == 'User' ? 'selected':''}}>{{$store->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" @if(Auth::user()->roles[0]->name == 'User') style="display: none" @endif>
                            <label class="control-label col-md-3 text-right">To Store  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="to_store_id" id="to_store_id" class="form-control" >
                                    <option value="">Select</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{Auth::user()->roles[0]->name == 'User' ? 'selected':''}}>{{$store->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Delivery Services</label>
                            <div class="col-md-8">
                                <select name="delivery_service_id" id="delivery_service_id" class="form-control" >
                                    <option value="">Select One</option>
                                    @if(!empty($deliveryServices))
                                        @foreach($deliveryServices as $deliveryService)
                                            <option value="{{$deliveryService->id}}">{{$deliveryService->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Delivery Services Charge</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="delivery_service_charge" value="" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Remarks</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="remarks"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Note</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="note" placeholder="Write Note" />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Product">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th >ID</th>
                                    <th>Product <small class="requiredCustom">*</small></th>
{{--                                    <th>Category</th>--}}
                                    <th style="display: none">Sub Category</th>
                                    <th>Brand</th>
                                    <th>Stock Qty</th>
                                    <th>Qty <small class="requiredCustom">*</small></th>
                                    <th>Price <small class="requiredCustom">*</small></th>
                                    <th>MRP Price <small class="requiredCustom">*</small></th>
                                    <th>WholeSale Price <small class="requiredCustom">*</small></th>
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
                                    <td width="10%">
                                        <div  id="product_brand_id_1">
                                            <select class="form-control product_brand_id select2" name="product_brand_id[]" required>
                                                <option value="">Select  Brand</option>
                                                @foreach($productBrands as $productBrand)
                                                    <option value="{{$productBrand->id}}">{{$productBrand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td width="8%">
                                        <input type="number" id="stock_qty_1" class="stock_qty form-control" name="stock_qty[]" value="" readonly >
                                    </td>
                                    <td width="8%">
                                        <input type="text" min="1" max="" class="qty form-control" name="qty[]" value="" required >
                                    </td>
                                    <td width="10%">
                                        <input type="number" id="price_1" min="1" max="" class="price form-control" name="price[]" value="" readonly required >
                                    </td>
                                    <td width="10%">
                                        <input type="text" id="mrp_price_1" min="1" max="" class="form-control" name="mrp_price[]" value="" required >
                                    </td>
                                    <td width="10%">
                                        <input type="text" id="wholeSale_price_1" min="1" max="" class="form-control" name="wholeSale_price[]" value="" required >
                                    </td>
                                    <td width="10%">
                                        <input type="text" class="amount form-control" name="sub_total[]">
                                    </td>
                                </tr>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>
                                        <select style="display: none" name="discount_type" id="discount_type" class="form-control" >
                                            <option value="flat" selected>flat</option>
                                            <option value="percentage">percentage</option>
                                        </select>
                                    </th>
                                    <th>
                                        {{--                                    Discount Amount:--}}
                                        <input style="display: none" type="text" id="discount_amount" class="form-control" name="discount_amount" onkeyup="discountAmount('')" value="0">
                                    </th>
                                    <th colspan="2">
                                        {{--                                    Paid Amount:--}}
                                        <input style="display: none" type="text" id="paid_amount" class="getmoney form-control" onkeyup="paidAmount('')" name="paid_amount" value="0">
                                    </th>
                                    <th colspan="2">
                                        {{--                                    Due Amount:--}}
                                        <input style="display: none" type="text" id="due_amount" class="backmoney form-control" name="due_amount">
                                    </th>
                                    <th>
                                        Total:
                                        <input type="hidden" id="store_total_amount" class="form-control">
                                        <input type="text" id="total_amount" class="form-control" name="total_amount">
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="form-group row">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-8">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Stock Transfer</button>
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
            $('#store_total_amount').val(t);
            $('#total_amount').val(t);
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
            store_total_amount = parseInt(store_total_amount);
            console.log('total= ' + typeof store_total_amount);

            var discount_amount = $('#discount_amount').val();
            console.log('discount_amount= ' + discount_amount);
            console.log('discount_amount= ' + typeof discount_amount);
            discount_amount = parseInt(discount_amount);
            console.log('discount_amount= ' + typeof discount_amount);

            if(discount_type == 'flat'){
                var final_amount = store_total_amount - discount_amount;
            }
            else{
                var per = (total*discount_amount)/100;
                var final_amount = store_total_amount-per;
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

        // function totalAmount(){
        //     var t = 0;
        //     $('.amount').each(function(i,e){
        //         var amt = $(this).val()-0;
        //         t += amt;
        //     });
        //     $('#total_amount').val(t);
        //     //$('#paid_amount').val(0);
        //     //$('#due_amount').val(0);
        // }
        $(function () {
            // $('#discount_amount').change(function(){
            //     var discount_type = $('#discount_type').val();
            //     var total = $('#total_amount').val();
            //     var getmoney = $(this).val();
            //     if(discount_type == 'flat'){
            //         var t = total - getmoney;
            //     }
            //     else{
            //         var per = (total*getmoney)/100;
            //         var t = total-per;
            //     }
            //     $('#total_amount').val(t);
            // });
            // $('.getmoney').change(function(){
            //     var total = $('#total_amount').val();
            //     var getmoney = $(this).val();
            //     var t = total - getmoney;
            //     $('.backmoney').val(t);
            // });
            $('.add').click(function () {
                var productCategory = $('.product_category_id').html();
                var productSubCategory = $('.product_sub_category_id').html();
                var productBrand = $('.product_brand_id').html();
                var product = $('.product_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control product_id select2" name="product_id[]" id="product_id_'+n+'" onchange="getval('+n+',this);" required>' + product + '</select></td>' +
                    '<td style="display: none"><div id="product_category_id_'+n+'"><select class="form-control product_category_id select2" name="product_category_id[]" required>' + productCategory + '</select></div></td>' +
                    // '<td style="display: none"><div id="product_sub_category_id_'+n+'"><select class="form-control product_sub_category_id select2" name="product_sub_category_id[]" required>' + productSubCategory + '</select></div></td>' +
                    '<td><div id="product_brand_id_'+n+'"><select class="form-control product_brand_id select2" name="product_brand_id[]" id="product_brand_id_'+n+'" required>' + productBrand + '</select></div></td>' +
                    '<td><input type="number" id="stock_qty_'+n+'" class="stock_qty form-control" name="stock_qty[]"></td>' +
                    '<td><input type="number" min="1" max="" class="qty form-control" name="qty[]" required></td>' +
                    '<td><input type="text" id="price_'+n+'" min="1" max="" class="price form-control" name="price[]" value="" readonly required></td>' +
                    '<td><input type="text" id="mrp_price_'+n+'" min="1" max="" class="form-control" name="mrp_price[]" value="" required></td>' +
                    '<td><input type="text" id="wholeSale_price_'+n+'" min="1" max="" class="form-control" name="wholeSale_price[]" value="" required></td>' +
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
            var store_id = $('#from_store_id').val();
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
                    url : "{{URL('product-Transfersale-relation-data')}}",
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
                        $("#price_"+current_row).val(res.data.price);
                        $("#mrp_price_"+current_row).val(res.data.mrp_price);
                        $("#wholeSale_price_"+current_row).val(res.data.wholeSale_price);
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
                },
                error: function(xhr)
                {
                    alert('failed!');
                }
            });
        });

        function hidemodal() {
            var x = document.getElementById("customar_modal");
            x.style.display = "none";
        }
    </script>
@endpush


