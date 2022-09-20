@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Sale Replace Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('productSaleReplacement.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Sale Product</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Sale Replace Product</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productSaleReplacement.update',$productSaleReplacement->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row" @if(Auth::user()->roles[0]->name == 'User') style="display: none" @endif>
                            <label class="control-label col-md-3 text-right">Store  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="store_id" id="store_id" class="form-control" disabled>
                                    <option value="">Select One</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{$store->id == $productSaleReplacement->store_id ? 'selected' : ''}}>{{$store->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Party  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="party_id" id="party_id" class="form-control select2" disabled>
                                    <option value="">Select One</option>
                                    @foreach($parties as $party)
                                        <option value="{{$party->id}}" {{$party->id == $productSaleReplacement->party_id ? 'selected' : ''}}>{{$party->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label class="control-label col-md-3 text-right">Date <small class="requiredCustom">*</small></label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <input type="text" name="date" class="datepicker form-control" value="{{date('Y-m-d')}}">--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="table-responsive">
                            {{--<input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Product">--}}
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Replace pQty</th>
                                    <th>Reason</th>
                                </tr>
                                </thead>
                                <tbody class="neworderbody">
                                @foreach($productSaleReplacementDetails as $key => $productSaleReplacementDetail)
                                    <tr>
                                        @php
                                            $current_row = $key+1;
                                        @endphp
                                        <td width="12%">
                                            @php
                                                echo $product_name = \Illuminate\Support\Facades\DB::table('products')
                                            ->where('id',$productSaleReplacementDetail->product_id)
                                            ->pluck('name')
                                            ->first();
                                            @endphp
                                            <input type="hidden" class="form-control" name="product_id[]" value="{{$productSaleReplacementDetail->product_id}}" >
                                            <input type="hidden" class="form-control" name="product_Sale_replacement_detail_id[]" value="{{$productSaleReplacementDetail->id}}" >
                                        </td>
                                        <td width="8%">
                                            <input type="text" min="1" max="" class="qty form-control" name="replace_qty[]" value="{{$productSaleReplacementDetail->replace_qty}}" required >
                                        </td>
                                        <td width="8%">
                                            <textarea rows="3" class="form-control" name="reason[]">{{$productSaleReplacementDetail->reason}}</textarea>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            <div class="form-group row">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-8">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Product Sales Replace</button>
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

        $(function () {
            $('.add').click(function () {
                var product = $('.product_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control product_id select2" name="product_id[]" id="product_id_'+n+'" onchange="getval('+n+',this);" required>' + product + '</select></td>' +
                    '<td><input type="number" min="1" max="" class="qty form-control" name="qty[]" required></td>' +
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


