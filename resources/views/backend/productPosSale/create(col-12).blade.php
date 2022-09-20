@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="col-md-12">
            <div class="tile">
                <div class="form-group row">
                    <label for="totalrp" class="col-md-2 control-label">Barcode</label>
                    <div class="col-md-10  input-group">
                        <input id="kode" type="text" class="form-control" name="kode" autofocus required>
                        <span class="input-group-btn">
                                <button onclick="showProduct()" type="button" class="btn btn-info">Show Product</button>
                            </span>
                    </div>
                </div>

                {{--                <form class="form-keranjang">--}}
                {{--                    {{ csrf_field() }} {{ method_field('PATCH') }}--}}
                {{--                    <table class="table table-striped tabel-penjualan">--}}
                {{--                        <thead>--}}
                {{--                        <tr>--}}
                {{--                            <th width="30">No</th>--}}
                {{--                            <th>Barcode</th>--}}
                {{--                            <th>Product Name</th>--}}
                {{--                            <th align="right">Price</th>--}}
                {{--                            <th>Quantity</th>--}}
                {{--                            <th>Discount</th>--}}
                {{--                            <th align="right">Sub Total</th>--}}
                {{--                            <th width="100">Action</th>--}}
                {{--                        </tr>--}}
                {{--                        </thead>--}}
                {{--                        <tbody></tbody>--}}
                {{--                    </table>--}}
                {{--                </form>--}}
                {{--                <div class="row">--}}
                {{--                    <div class="col-md-8">--}}
                {{--                        <div id="tampil-bayar" style="background: #dd4b39; color: #fff; font-size: 80px; text-align: center; height: 120px"></div>--}}
                {{--                        <div id="tampil-terbilang" style="background: #3c8dbc; color: #fff; font-size: 25px; padding: 10px"></div>--}}
                {{--                    </div>--}}

                {{--                    <div class="col-md-4">--}}
                {{--                        <form class="form form-horizontal form-penjualan" method="post" action="transaksi/simpan">--}}
                {{--                            {{ csrf_field() }}--}}
                {{--                            <input type="hidden" name="idpenjualan" value="">--}}
                {{--                            <input type="hidden" name="total" id="total">--}}
                {{--                            <input type="hidden" name="totalitem" id="totalitem">--}}
                {{--                            <input type="hidden" name="bayar" id="bayar">--}}

                {{--                            <div class="form-group row">--}}
                {{--                                <label for="totalrp" class="col-md-4 control-label">Total</label>--}}
                {{--                                <div class="col-md-8">--}}
                {{--                                    <input type="text" class="form-control" id="totalrp" readonly>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                            <div class="form-group row">--}}
                {{--                                <label for="member" class="col-md-4 control-label">Customer</label>--}}
                {{--                                <div class="col-md-8">--}}
                {{--                                    <div class="input-group">--}}
                {{--                                        <input id="member" type="text" class="form-control" name="member" value="0">--}}
                {{--                                        <span class="input-group-btn">--}}
                {{--                                          <button onclick="showMember()" type="button" class="btn btn-info">...</button>--}}
                {{--                                        </span>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                            <div class="form-group row">--}}
                {{--                                <label for="diskon" class="col-md-4 control-label">Discount</label>--}}
                {{--                                <div class="col-md-8">--}}
                {{--                                    <input type="text" class="form-control" name="diskon" id="diskon" value="0" readonly>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                            <div class="form-group row">--}}
                {{--                                <label for="bayarrp" class="col-md-4 control-label">Total</label>--}}
                {{--                                <div class="col-md-8">--}}
                {{--                                    <input type="text" class="form-control" id="bayarrp" readonly>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                            <div class="form-group row">--}}
                {{--                                <label for="diterima" class="col-md-4 control-label">Paid</label>--}}
                {{--                                <div class="col-md-8">--}}
                {{--                                    <input type="number" class="form-control" value="0" name="diterima" id="diterima">--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                            <div class="form-group row">--}}
                {{--                                <label for="kembali" class="col-md-4 control-label">Due</label>--}}
                {{--                                <div class="col-md-8">--}}
                {{--                                    <input type="text" class="form-control" id="kembali" value="0" readonly>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                            <div class="box-footer">--}}
                {{--                                <button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Save</button>--}}
                {{--                            </div>--}}

                {{--                        </form>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="col-md-12" id="loadForm"></div>
            </div>
        </div>
    </main>
    @include('backend.productPosSale.product')
    @include('backend.productPosSale.member')
@endsection

@push('js')
    <script>

        function loadData(id){
            $.ajax({
                url : "{{ URL('/selectedform') }}/" + id,
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
                    console.log(barcode);
                    if(barcode)
                    {
                        $.ajax({
                            url : "{{URL('add-to-cart')}}",
                            method : "get",
                            data : {
                                barcode : barcode
                            },
                            success : function (res){
                                console.log(res)
                                $('#kode').val('').focus();
                                loadData(barcode)
                                if(res.response.product_check_exists == 'No Product Found!')
                                    toastr.warning('no product found using this code!')
                                else if(res.response.product_check_exists == 'No Product Stock Found!')
                                    toastr.warning('no product found using this code!')
                                else
                                    toastr.success('successfully added to cart')
                            },
                            error : function (err){
                                console.log(err)
                            }
                        })
                    }
                }, 2000);
            };

            $('input#kode').keyup(update);
            $('input#kode').change(update);
            /*automatically call after two seconds*/

        }());


        // function vatAmount(){
        //     var sub_total = $('#sub_total').val();
        //     var vat_amount = parseFloat($('#vat_amount').val()).toFixed(2);
        //     var grand_total = sub_total - vat_amount;
        //     var grand_total = parseFloat(grand_total).toFixed(2);
        //     $('#vat_amount').val(vat_amount);
        //     //$('#discount_amount').val(discount_amount);
        //     $('#grand_total').val(grand_total);
        //     $('#due_amount').val(grand_total);
        // }


        function discountAmount(){
            var sub_total = $('#sub_total').val();
            var discount_amount = parseFloat($('#discount_amount').val()).toFixed(2);
            var grand_total = sub_total - discount_amount;
            var grand_total = parseFloat(grand_total).toFixed(2);
            $('#discount_amount').val(discount_amount);
            $('#grand_total').val(grand_total);
            $('#due_amount').val(grand_total);
        }

        function paidAmount(){
            console.log('okk');
            var grand_total = $('#grand_total').val();
            var paid_amount = parseFloat($('#paid_amount').val()).toFixed(2);
            var due_amount = grand_total - paid_amount;
            var due_amount = parseFloat(due_amount).toFixed(2);
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
            setTimeout(function () {
                var barcode = $('#kode').val();
                console.log(barcode);
                if(barcode)
                {
                    $.ajax({
                        url : "{{URL('add-to-cart')}}",
                        method : "get",
                        data : {
                            barcode : barcode
                        },
                        success : function (res){
                            console.log(res)
                            $('#kode').val('').focus();
                            loadData(barcode)
                            toastr.success('successfully added to cart');
                        },
                        error : function (err){
                            console.log(err)
                        }
                    })
                }
            }, 1000);
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

    </script>
@endpush()
