@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="col-md-12">
            <div class="tile">

                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <select name="store_id" id="store_id" class="form-control" required>
                                    @if(!empty($stores))
                                        @foreach($stores as $store)
                                            <option value="{{$store->id}}">{{$store->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6  input-group">
                                <input id="kode" type="text" class="form-control" name="kode" autofocus required>
                                <span class="input-group-btn">
                                <button onclick="showProduct()" type="button" class="btn btn-info">Show Product</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Session::get('product_sale_id'))

                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            {{--                            <a href="{{url('pos/print/'.Session::get('product_sale_id').'/'.'now')}}" class="btn btn-sm btn-primary" type="button">Print Now</a>--}}
{{--                            <a href="{{url('pos/print_pos/'.Session::get('product_sale_id').'/'.'now')}}" target="_blank" class="btn btn-sm btn-primary printNow" type="button">Print Now</a>--}}
                            <a href="{{url('product-pos-sales-invoice/'.Session::get('product_sale_id').'/'.'now')}}" target="_blank" class="btn btn-sm btn-primary printNow" type="button">Print Now</a>
                            <a href="{{url('pos/print/'.Session::get('product_sale_id').'/'.'latter')}}" class="btn btn-sm btn-warning printLatter" type="button">Print Latter</a>
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <div class="col-md-12" id="loadForm"></div>
                </div>

            </div>
        </div>
    </main>
    @include('backend.productPosSale.product')
    @include('backend.productPosSale.member')
@endsection

@push('js')
    <script>

        function loadData(id){
            var store_id = $('#store_id').val();
            console.log(store_id);
            $.ajax({
                url : "{{ URL('/selectedform') }}/" + id + "/" + store_id,
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
            });
        }

        /*One way on blur*/
        {{--$(function(){--}}
        {{--    $('.tabel-produk').DataTable();--}}
        {{--    loadData(barcode=null)--}}

        {{--    $('#kode').change(function(){--}}
        {{--        var barcode = $('#kode').val();--}}
        {{--        if(barcode){--}}
        {{--            $.ajax({--}}
        {{--                url : "{{URL('add-to-cart')}}",--}}
        {{--                method : "get",--}}
        {{--                data : {--}}
        {{--                    barcode : barcode--}}
        {{--                },--}}
        {{--                success : function (res){--}}
        {{--                    console.log(res)--}}
        {{--                    $('#kode').val('').focus();--}}
        {{--                    loadData(barcode)--}}
        {{--                },--}}
        {{--                error : function (err){--}}
        {{--                    console.log(err)--}}
        {{--                }--}}
        {{--            })--}}
        {{--        }else{--}}
        {{--            alert('No Barcode Found!');--}}
        {{--            location.reload();--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
        /*One way on blur*/



        (function () {
            $('.tabel-produk').DataTable();
            loadData(barcode=null)

            /*automatically call after two seconds*/
            var timeout = {};
            var update = function () {
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    var barcode = $('#kode').val();
                    var store_id = $('#store_id').val();
                    console.log(barcode);
                    if(barcode)
                    {
                        $.ajax({
                            url : "{{URL('add-to-cart')}}",
                            method : "get",
                            data : {
                                barcode : barcode,
                                store_id : store_id
                            },
                            success : function (res){
                                console.log(res)
                                $('#kode').val('').focus();
                                loadData(barcode)
                                if(res.response.product_check_exists == 'No Product Found!')
                                    toastr.warning('no product found using this code!')
                                else if(res.response.product_check_exists == 'No Product Stock Found!')
                                    toastr.warning('no product found using this code OR Store!')
                                else
                                    toastr.success('successfully added to cart')
                            },
                            error : function (err){
                                console.log(err)
                            }
                        })
                    }
                }, 1000);
            };

            $('input#kode').keyup(update);
            $('input#kode').change(update);
            /*automatically call after two seconds*/



            $('.printNow').click(function (){
                // location.reload();
                $('.printNow').hide();
                $('.printLatter').hide();
            })

        }());


        // onblur
        // function vatAmount(){
        //     var sub_total = $('#sub_total').val();
        //     var vat_amount = parseFloat($('#vat_amount').val()).toFixed(2);
        //     var vat_subtraction = (sub_total*vat_amount)/100;
        //     var grand_total = sub_total - vat_subtraction;
        //     var vat_subtraction = parseFloat(vat_subtraction).toFixed(2);
        //     var grand_total = parseFloat(grand_total).toFixed(2);
        //     $('#vat_amount').val(vat_subtraction);
        //     //$('#discount_amount').val(discount_amount);
        //     $('#grand_total').val(grand_total);
        //     $('#due_amount').val(grand_total);
        // }

        // onkeyup
        function vatAmount(){
            var sub_total = $('#sub_total').val();
            console.log('sub_total= ' + sub_total);
            console.log('sub_total= ' + typeof sub_total);
            sub_total = parseInt(sub_total);

            var vat_amount = $('#vat_amount').val();
            console.log('vat_amount= ' + vat_amount);
            console.log('vat_amount= ' + typeof vat_amount);
            vat_amount = parseInt(vat_amount);

            var vat_subtraction = (sub_total*vat_amount)/100;
            console.log('vat_subtraction= ' + vat_subtraction);
            console.log('vat_subtraction= ' + typeof vat_subtraction);

            var grand_total = sub_total + vat_subtraction;
            console.log('grand_total= ' + grand_total);
            console.log('grand_total= ' + typeof grand_total);
            grand_total = parseInt(grand_total);

            $('#show_vat_amount').val(vat_subtraction);
            $('#store_grand_total').val(grand_total);
            $('#grand_total').val(grand_total);
            $('#due_amount').val(grand_total);
        }


        // onblur
        // function discountAmount(){
        //     var sub_total = $('#sub_total').val();
        //     var grand_total = $('#grand_total').val();
        //     var discount_amount = parseFloat($('#discount_amount').val()).toFixed(2);
        //     if(grand_total > 0){
        //         var grand_total = grand_total - discount_amount;
        //     }else{
        //         var grand_total = sub_total - discount_amount;
        //     }
        //     var grand_total = parseFloat(grand_total).toFixed(2);
        //     $('#discount_amount').val(discount_amount);
        //     $('#grand_total').val(grand_total);
        //     $('#due_amount').val(grand_total);
        // }

        // onkeyup
        function discountAmount(){
            //var sub_total = $('#sub_total').val();
            //console.log('sub_total= ' + sub_total);
            //console.log('sub_total= ' + typeof sub_total);

            var store_grand_total = $('#store_grand_total').val();
            console.log('store_grand_total= ' + store_grand_total);
            console.log('store_grand_total= ' + typeof store_grand_total);

            var discount_amount = $('#discount_amount').val();
            console.log('discount_amount= ' + discount_amount);
            console.log('discount_amount= ' + typeof discount_amount);

            var grand_total = store_grand_total - discount_amount;
            console.log('grand_total=' + grand_total);
            console.log('grand_total=' + typeof grand_total);

            $('#discount_amount').val(discount_amount)
            $('#grand_total').val(grand_total);
            $('#due_amount').val(grand_total);
        }

        // onblur
        // function paidAmount(){
        //     console.log('okk');
        //     var grand_total = $('#grand_total').val();
        //     var paid_amount = parseFloat($('#paid_amount').val()).toFixed(2);
        //     var due_amount = grand_total - paid_amount;
        //     var due_amount = parseFloat(due_amount).toFixed(2);
        //     $('#paid_amount').val(paid_amount);
        //     $('#due_amount').val(due_amount);
        // }

        // onkeyup
        function paidAmount(){
            console.log('okk');
            var grand_total = $('#grand_total').val();
            var paid_amount = $('#paid_amount').val();
            var due_amount = grand_total - paid_amount;
            var due_amount = due_amount;
            $('#paid_amount').val(paid_amount);
            $('#due_amount').val(due_amount);
        }



        function deleteCart(rowId) {
            if (confirm("Are you sure, delete this item!")) {
                $.ajax({
                    url: "{{ URL('/delete-cart-product') }}/" + rowId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data)
                        loadData(barcode)
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
            }
        }

        function deleteAllCart() {
            if (confirm("Are you sure, delete all item!")) {
                $.ajax({
                    url: "{{ URL('/delete-all-cart-product') }}",
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data)
                        loadData(barcode)
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
            }
        }

        // function updateCart(rowId){
        //     var test = $("input:text").val();
        //     console.log(test);
        //
        // }




        function showProduct(){
            $('#modal-produk').modal('show');
        }

        function selectItem(kode){
            $('#kode').val(kode);
            $('#modal-produk').modal('hide');

            /*additional*/
            //setTimeout(function () {
            var barcode = $('#kode').val();
            var store_id = $('#store_id').val();
            console.log(barcode);
            if(barcode)
            {
                $.ajax({
                    url : "{{URL('add-to-cart')}}",
                    method : "get",
                    data : {
                        barcode : barcode,
                        store_id : store_id
                    },
                    success : function (res){
                        console.log(res)
                        $('#kode').val('').focus();
                        loadData(barcode)
                        if(res.response.product_check_exists == 'No Product Found!')
                            toastr.warning('no product found using this code!')
                        else if(res.response.product_check_exists == 'No Product Stock Found!')
                            toastr.warning('no product found using this code OR Store!')
                        else
                            toastr.success('successfully added to cart')
                    },
                    error : function (err){
                        console.log(err)
                    }
                })
            }
            //}, 1000);
            /*additional*/
        }

        function showMember(){
            $('#modal-member').modal('show');
        }

        function selectMember(kode){
            $('#modal-member').modal('hide');
            $('#member').val(kode);
            $('#diterima').val(0).focus().select();
        }

        // $(function() {
        //     $('#check_number').hide();
        //     $('#payment_type').change(function(){
        //         console.log('okk');
        //         if($('#payment_type').val() == 'Check') {
        //             $('#check_number').show();
        //         } else {
        //             $('#check_number').val('');
        //             $('#check_number').hide();
        //         }
        //     });
        // });

        function productType(){
            var arr = $('#payment_type').val();
            if(arr == "Check"){ $("#check_number").removeAttr("readonly"); }
            if(arr == "Cash"){ $("#check_number").attr("readonly", "readonly"); }
        }

    </script>
@endpush()
