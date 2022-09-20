@extends('backend._partial.dashboard')
@push('css')
{{--    <style>--}}
{{--        @media screen {--}}
{{--            #printSection {--}}
{{--                display: none;--}}
{{--            }--}}
{{--        }--}}

{{--        @media print {--}}
{{--            body * {--}}
{{--                visibility:hidden;--}}
{{--            }--}}
{{--            #printSection, #printSection * {--}}
{{--                visibility:visible;--}}
{{--            }--}}
{{--            #printSection {--}}
{{--                position:absolute;--}}
{{--                left:0;--}}
{{--                top:0;--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}
@endpush
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product POS Sale</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productPosSales.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product POS Sales</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">

                <h3 class="tile-title">Product POS Sales Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th>Sale User</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
    {{--                        <th>Payment Type</th>--}}
                            <th>Total Amount</th>
    {{--                        <th>Paid Amount</th>--}}
                            <th>Date</th>
                            <th>Due Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productPosSales as $key => $productSale)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $productSale->user->name}}</td>
                            <td>{{ $productSale->invoice_no}}</td>
                            <td>{{ $productSale->party->name}}</td>
    {{--                        <td>{{ $productSale->payment_type}}</td>--}}
                            <td>{{ $productSale->total_amount}}</td>
    {{--                        <td>{{ $productSale->paid_amount}}</td>--}}
                            <td>{{ $productSale->created_at}}</td>
                            <td>
                                {{ $productSale->due_amount}}
                                @if($productSale->total_amount != $productSale->paid_amount)
                                    <a href="" class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#exampleModal-<?= $productSale->id;?>"> Pay Due</a>
                                @endif
                            </td>
                            <td class="d-inline-flex">
                                <a href="{{url('product-pos-sales-invoice/'.$productSale->id.'/'.'list')}}" target="__blank" class="btn btn-sm btn-warning" style="margin-left: 5px" type="button">Print</a>
                                <a href="{{ route('productSales.show',$productSale->id) }}" class="btn btn-sm btn-info float-left" style="margin-left: 5px">Show</a>
                                <a href="{{ route('productSales.edit',$productSale->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('productSales.destroy',$productSale->id) }}" >
                                   @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-{{$productSale->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Pay Due</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('pay.due')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="due">Enter Due Amount</label>
                                                <input type="hidden" class="form-control" name="product_sale_id" value="{{$productSale->id}}">
                                                <input type="number" class="form-control" id="due" aria-describedby="emailHelp" name="new_paid" min="" max="{{$productSale->due_amount}}" placeholder="Enter Amount">
                                            </div>
                                            <div class="form-group">
                                                <label for="payment_type">Payment Type</label>
                                                <select name="payment_type" id="payment_type" class="form-control" required>
                                                    <option value="">Select One</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Check">Check</option>
                                                </select>
                                                <span>&nbsp;</span>
                                                <input type="text" name="check_number" id="check_number" class="form-control" placeholder="Check Number">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @push('js')
                                    <script>
                                        $(function() {
                                            $('#check_number').hide();
                                            $('#payment_type').change(function(){
                                                if($('#payment_type').val() == 'Check') {
                                                    $('#check_number').show();
                                                } else {
                                                    $('#check_number').val('');
                                                    $('#check_number').hide();
                                                }
                                            });
                                        });
                                    </script>
                                @endpush
                            </div>
                        </div>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                </div>
            </div>

        </div>

    </main>
@endsection




