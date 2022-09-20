@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content" >
        <div class="app-title">
            <div>
                <h1><i class=""></i> Add Services For this Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSales.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12" >
            <div class="tile">
                <h3 class="tile-title">Add Services</h3>
                <div class="table-responsive">
                    <input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Services">
                    <form method="post" action="{{ route('productSales-store-services') }}">
                        @csrf

                    <table id="example1" class="table table-bordered table-striped"  style="height: 100px">

                        <thead>
                        <tr>
                            <th >ID</th>
                            <th>Product</th>
{{--                            <th>Brand</th>--}}
                            <th>Qty</th>
                            <th>Price</th>
{{--                            <th>Sub Total</th>--}}
                            <th>Services</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Duration</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody class="neworderbody">
                            <tr>
                                <td width="5%" class="no">1</td>
                                <td style="display: none"><input class="form-control" type="hidden" name="product_sale_detail_id" value="{{$productSaleDetail->id}}"></td>

                                <td> <input class="form-control" type="hidden" name="product_id[]" value="">{{$productSaleDetail->product->name}}</td>
                                <td>{{$productSaleDetail->qty}}</td>
                                <td>{{$productSaleDetail->price}}</td>
{{--                                <td>{{$productSaleDetail->sub_total}}</td>--}}
                                <td width="20%">
                                    <select class="form-control service_id select2" name="service_id[]" id="service_id_" required>
                                        <option value="">Select  Service</option>
                                        @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="date" name="start_date[]" class="form-control"  id="start_date_" value="{{date('Y-m-d')}}"></td>
                                <td><input type="date" name="end_date[]" class="form-control"  id="end_date_" value="{{date('Y-m-d')}}"></td>
                                <td>
                                    <input type="number" name="duration[]" class="form-control"  id="duration_1" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group row">
                        <label class="control-label col-md-3">

                        </label>
                        <div class="col-md-8" style="margin-top: 50px">
                            <button class="btn btn-primary" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Services For This Product</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('js')
    <script>
        $(function () {
            $('.add').click(function () {
                var productCategory = $('.product_category_id').html();
                var productSubCategory = $('.product_sub_category_id').html();
                var productBrand = $('.product_brand_id').html();
                var productUnit = $('.product_unit_id').html();
                var service = $('.service_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    // '<td></td>' +
                    '<td><select class="form-control service_id select2" name="service_id[]" id="service_id_'+n+'" required>' + service + '</select></td>' +
                    '<td><input type="date" class="form-control" name="start_date[]" id="start_date_" value=\"{{date('Y-m-d')}}\" required></td>' +
                    '<td><input type="date" class="form-control" name="end_date[]" id="end_date_" value=\"{{date('Y-m-d')}}\" required></td>' +
                    '<td><input type="number" class=" form-control" name="duration[]" id="duration_'+n+'" ></td>' +
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
    </script>
@endpush
