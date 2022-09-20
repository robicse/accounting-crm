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


                    <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img src="{{asset('uploads/store/'.$store->logo)}}" alt="logo" height="60px" width="250px">
                                    <small class="float-right">Date: {{date('d-m-Y')}}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{{$store->name}}</strong><br>
                                    {{$store->address}}<br>
                                    Phone: {{$store->phone}}<br>
                                    Email:
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{$party->name}}</strong><br>
                                    {{$party->address}}<br>
                                    Phone: {{$party->phone}}<br>
                                    Email: {{$party->email}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #{{$productSale->invoice_no}}</b><br>
                                <br>
                                {{--                                        <b>Order ID:</b> 4F3S8J<br>--}}
                                {{--                                        <b>Payment Type:</b> {{$productSale->payment_type}}<br>--}}
                                {{--                                        <b>Delivery Service:</b> {{$productSale->delivery_service}}--}}
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL#</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $sum_sub_total = 0;
                                    @endphp
                                    @foreach($productSaleDetails as $key => $productSaleDetail)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$productSaleDetail->product->name}}</td>
                                            <td>{{$productSaleDetail->qty}}</td>
                                            <td>{{$productSaleDetail->price}}</td>
                                            <td>
                                                @php
                                                    $sub_total=$productSaleDetail->qty*$productSaleDetail->price;
                                                    $sum_sub_total += $sub_total;
                                                @endphp
                                                {{$sub_total}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                {{--                                        <p class="lead">Payment Methods:</p>--}}
                                {{--                                        <img src="{{asset('backend/dist/img/credit/visa.png')}}" alt="Visa">--}}
                                {{--                                        <img src="{{asset('backend/dist/img/credit/mastercard.png')}}" alt="Mastercard">--}}
                                {{--                                        <img src="{{asset('backend/dist/img/credit/american-express.png')}}" alt="American Express">--}}
                                {{--                                        <img src="{{asset('backend/dist/img/credit/paypal2.png')}}" alt="Paypal">--}}

                                {{--                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">--}}
                                {{--                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem--}}
                                {{--                                            plugg--}}
                                {{--                                            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.--}}
                                {{--                                        </p>--}}
                                <p class="lead">Payment Type:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    @if(!empty($transactions))
                                        <ul>
                                            @foreach($transactions as $transaction)
                                                <li>
                                                    {{$transaction->payment_type}}
                                                    @if($transaction->payment_type == 'Check')
                                                        ( Check Number: {{$transaction->check_number}} )
                                                    @endif
                                                    :
                                                    {{$transaction->amount}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                {{--                                        <p class="lead">Amount Due 2/22/2014</p>--}}
                                <p class="lead">Amount</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>
                                                {{$sum_sub_total}}
                                            </td>
                                        </tr>
                                        {{--                                                <tr>--}}
                                        {{--                                                    <th>Tax (9.3%)</th>--}}
                                        {{--                                                    <td>$10.34</td>--}}
                                        {{--                                                </tr>--}}
                                        <tr>
                                            <th>Discount:</th>
                                            <td>{{$productSale->discount_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount:</th>
                                            <td>{{$productSale->total_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th>Paid Amount:</th>
                                            <td>{{$productSale->paid_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th>Due Amount:</th>
                                            <td>{{$productSale->due_amount}}</td>
                                        </tr>
                                        {{--                                                <tr>--}}
                                        {{--                                                    <th>Previous Due Amount:</th>--}}
                                        {{--                                                    <td>--}}
                                        {{--                                                        @php--}}
                                        {{--                                                            $product_sale_dues = \App\ProductSale::query()--}}
                                        {{--                                                            ->select(DB::raw('SUM(due_amount) as due_amount'))--}}
                                        {{--                                                            ->where('id','<',$productSale->id)--}}
                                        {{--                                                            ->first();--}}

                                        {{--                                                            $previous_due_amount = $product_sale_dues->due_amount;--}}
                                        {{--                                                            if(!empty($previous_due_amount)){--}}
                                        {{--                                                                echo $previous_due_amount;--}}
                                        {{--                                                            }else{--}}
                                        {{--                                                                echo $previous_due_amount = 0;--}}
                                        {{--                                                            }--}}
                                        {{--                                                        @endphp--}}
                                        {{--                                                    </td>--}}
                                        {{--                                                </tr>--}}
                                        {{--                                                <tr>--}}
                                        {{--                                                    <th>Final Due Amount:</th>--}}
                                        {{--                                                    <td>{{$productSale->due_amount+$previous_due_amount}}</td>--}}
                                        {{--                                                </tr>--}}
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                        <h1 class="requiredCustom">
                            <span>* Outside product first add for syn stock and loss/profit management.</span>
                            <a href="{!! route('productPurchases.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Purchases</a>
                        </h1>
                        <input type="button" class="btn btn-primary add " style="float: right" value="Add More Sale Product">
                        <form method="post" action="{{ route('productSales.invoiceUpdate',$productSale->id) }}">
                            {{--                                    @method('PUT')--}}
                            @csrf

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th >ID</th>
                                    <th>Product <small class="requiredCustom">*</small></th>
                                    <th style="display: none">Category</th>
                                    <th style="display: none">Sub Category</th>
                                    <th>Brand</th>
                                    <th>Stock Qty</th>
                                    <th>Qty <small class="requiredCustom">*</small></th>
                                    <th >Price <small class="requiredCustom">*</small></th>
                                    <th colspan="2">Sub Total</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody class="neworderbody">
                                @if(!empty($productSaleDetails))
                                    @foreach($productSaleDetails as $key=>$productSaleDetail)
                                        @php
                                            $current_stock = \App\Stock::where('product_id',$productSaleDetail->product_id)->latest()->pluck('current_stock')->first();
                                        @endphp
                                        <tr>
                                            <td width="5%" class="no">{{$key+1}}</td>
                                            <td width="18%">
                                                <input type="hidden" name="store_id" id="store_id" value="{{$store->id}}">
                                                <select class="form-control product_id select2" name="product_id[]" id="product_id_1" onchange="getval(1,this);" required>
                                                    <option value="">Select  Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->id}}" {{$productSaleDetail->product_id == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="display: none">
                                                <div id="product_category_id_1">
                                                    <select class="form-control product_category_id select2" name="product_category_id[]"  required>
                                                        <option value="">Select  Category</option>
                                                        @foreach($productCategories as $productCategory)
                                                            <option value="{{$productCategory->id}}" {{$productSaleDetail->product_category_id == $productCategory->id ? 'selected' : ''}}>{{$productCategory->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="display: none">
                                                <div id="product_sub_category_id_1">
                                                    <select class="form-control product_sub_category_id select2" name="product_sub_category_id[]">
                                                        <option value="">Select  Sub Category</option>
                                                        @foreach($productSubCategories as $productSubCategory)
                                                            <option value="{{$productSubCategory->id}}" {{$productSaleDetail->product_sub_category_id == $productSubCategory->id ? 'selected' : ''}}>{{$productSubCategory->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td width="13%">
                                                <div id="product_brand_id_1">
                                                    <select class="form-control product_brand_id select2" name="product_brand_id[]" required>
                                                        <option value="">Select  Brand</option>
                                                        @foreach($productBrands as $productBrand)
                                                            <option value="{{$productBrand->id}}" {{$productSaleDetail->product_brand_id == $productBrand->id ? 'selected' : ''}}>{{$productBrand->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td width="10%">
                                                <input type="number" id="stock_qty_1" class="stock_qty form-control" name="stock_qty[]" value="{{$current_stock}}" readonly >
                                            </td>
                                            <td width="14%">
                                                <input type="number" min="1" max="" class="qty form-control" name="qty[]" value="{{$productSaleDetail->qty}}" required >
                                            </td>
                                            <td width="14%">
                                                <input type="number" id="price_1" min="1" max="" class="price form-control" name="price[]" value="{{$productSaleDetail->price}}" required >
                                            </td>
                                            <td  width="13%">
                                                <input type="text" class="amount form-control" name="sub_total[]" value="{{$productSaleDetail->sub_total}}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>
                                        Discount Type:
                                        <select name="discount_type" id="discount_type" class="form-control" >
                                            <option value="flat" {{$productSale->discount_type == 'flat' ? 'selected' : ''}}>flat</option>
                                            <option value="percentage" {{$productSale->discount_type == 'percentage' ? 'selected' : ''}}>percentage</option>
                                        </select>
                                    </th>
                                    <th>
                                        Discount Amount:
                                        <input type="text" id="discount_amount" class="form-control" name="discount_amount" onkeyup="discountAmount('')" value="{{$productSale->discount_amount}}">
                                    </th>
                                    <th>
                                        Total:
                                        <input type="hidden" id="store_total_amount" class="form-control" value="{{$productSale->total_amount}}">
                                        <input type="text" id="total_amount" class="form-control" name="current_total_amount" value="{{$productSale->total_amount}}">
                                    </th>
                                    <th colspan="2">
                                        Paid Amount:
                                        <input type="text" id="paid_amount" class="getmoney form-control" name="paid_amount" onkeyup="paidAmount('')" value="{{$productSale->paid_amount}}">
                                    </th>
                                    <th colspan="2">
                                        Due Amount:
                                        <input type="text" id="due_amount" class="backmoney form-control" name="due_amount" value="{{$productSale->due_amount}}">
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                    <td>
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Invoice</button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
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
                var per = (store_total_amount*discount_amount)/100;
                var final_amount = store_total_amount - per;
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
                var product = $('.product_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control product_id select2" name="product_id[]" id="product_id_'+n+'" onchange="getval('+n+',this);" required>' + product + '</select></td>' +
                    '<td style="display: none"><div id="product_category_id_'+n+'"><select class="form-control product_category_id select2" name="product_category_id[]" required>' + productCategory + '</select></div></td>' +
                    '<td style="display: none"><div id="product_sub_category_id_'+n+'"><select class="form-control product_sub_category_id select2" name="product_sub_category_id[]" required>' + productSubCategory + '</select></div></td>' +
                    '<td><div id="product_brand_id_'+n+'"><select class="form-control product_brand_id select2" name="product_brand_id[]" id="product_brand_id_'+n+'" required>' + productBrand + '</select></div></td>' +
                     '<td style="display: none"><select name="return_type[]" id="return_type_id_'+n+'" class="form-control" ><option value="returnable" selected>returnable</option><option value="not returnable">not returnable</option></select></td>' +
                    '<td><input type="number" id="stock_qty_'+n+'" class="stock_qty form-control" name="stock_qty[]" readonly></td>' +
                    '<td><input type="number" min="1" max="" class="qty form-control" name="qty[]" required></td>' +
                    '<td><input type="text" id="price_'+n+'" min="1" max="" class="price form-control" name="price[]" value="" required></td>' +
                    //'<td><input type="number" min="0" value="0" max="100" class="dis form-control" name="discount[]" required></td>' +
                    '<td width="13%"><input type="text" class="amount form-control" name="sub_total[]" required></td>' +
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


