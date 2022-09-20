@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content" >
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Sale</h1>
            </div>
        </div>

        <div class="tile" >
            <form class="form-inline" action="{{ route('productSales.index') }}">
                @csrf
                <div class="form-group col-md-3">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" class=" form-control" value="{{$start_date}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" class=" form-control" value="{{$end_date}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="sale_type">Sale Type:</label>
                    <select name="sale_type" class="form-control" style="width: 180px;">
                        <option>All</option>
                        <option value="Retail Sale" {{ $sale_type == 'Retail Sale'? 'selected':''}}>Retail Sale</option>
                        <option value="Whole Sale" {{ $sale_type == 'Whole Sale'? 'selected':''}}>Whole Sale</option>
                    </select>
                    {{--                        <input type="text" name="reference_name" class=" form-control" value="{{$reference_name}}">--}}
                </div>
                <div class="form-group col-md-3">
                    <label for="reference_name">Reference Name:</label>
                    <input type="text" name="reference_name" class=" form-control" value="{{$reference_name}}">
                </div>
                <div class="form-group col-md-3 text-center" style="margin-left: 385px; margin-top: 25px;">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a href="{!! route('productSales.index') !!}" class="btn btn-primary" type="button">Reset</a>
                </div>
            </form>

            <h3 class="tile-title">Product Sales Table</h3>
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-responsive">

                    <thead>
                    <tr>
                        <th width="5%">SL NO</th>
                        <th>Sale User</th>
                        <th>Date</th>
                        <th>Invoice No</th>
                        <th width="5%">Customer</th>
                        <th>Sale Type</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Reference Name</th>
                        <th>Provider</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $sum_total_amount = 0;
                        $sum_paid_amount = 0;
                        $sum_due_amount = 0;
                    @endphp
                    @if(!empty($productSales))
                        @foreach($productSales as $key => $productSale)
                            @php
                                $sum_total_amount += ($productSale->total_amount);
                                $sum_paid_amount += ( $productSale->paid_amount );
                                $sum_due_amount += $productSale->due_amount;
                            @endphp
                            @php
                                $totalAmount =(($productSale->total_amount +$productSale->transport_cost));
                                //$DueAmount =( $productSale->due_amount +$productSale->transport_cost);
                                $paid_amount =( $productSale->paid_amount +$productSale->transport_cost);
                                $return = \App\ProductSaleReturn::where('sale_invoice_no',$productSale->invoice_no)->first()

                            @endphp
                            <tr>
                                <td>{{ ($key+1 )}}</td>
                                <td>{{ $productSale->user->name}}</td>
                                <td>{{ $productSale->date}}</td>
                                <td>
                                    {{ $productSale->invoice_no}}
                                    @if($return)
                                        <span class="badge badge-danger"> Returned </span>
                                    @endif
                                </td>
                                @if(!empty($productSale->party->name))
                                    <td>{{ $productSale->party->name}}.{{ $productSale->party->phone}}</td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{ $productSale->sale_type}}</td>
                                <td>{{ $productSale->total_amount}}</td>
                                <td>{{ $productSale->paid_amount}}</td>
                                <td>
                                    {{ $productSale->due_amount}}
                                    @if($productSale->total_amount != $productSale->paid_amount)
                                        <a href="" class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#exampleModal-<?= $productSale->id;?>"> Pay Due</a>
                                    @endif
                                </td>
                                <td>{{ $productSale->reference_name}}</td>
                                @if(!empty($productSale->provider->name))
                                    <td>{{ $productSale->provider->name}}</td>
                                @else
                                    <td></td>
                                @endif
                                <td>
                                    <a href="{{ route('productSales.show',$productSale->id) }}" class="btn btn-sm btn-info float-left" style="margin-left: 5px">Show</a>
                                    <a href="{!! route('productSales-invoice',$productSale->id) !!}" target="__blank" class="btn btn-sm btn-warning" style="margin-left: 5px" type="button">Invoice Print</a><br>
                                    <a href="{!! route('productSales-Challaninvoice',$productSale->id) !!}" target="__blank" class="btn btn-sm btn-warning" style="margin-left: 5px;margin-top: 5px" type="button">Challan Print</a>

                                    @if( $productSale->sale_type == 'Whole Sale')
                                        <a href="{{ route('productWholeSales.edit',$productSale->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px;margin-top: 5px"><i class="fa fa-edit"></i></a>
                                    @else
                                        <a href="{{ route('productSales.edit',$productSale->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px;margin-top: 5px"><i class="fa fa-edit"></i></a>
                                    @endif
                                    <form method="post" action="{{ route('productSales.destroy',$productSale->id) }}" >
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" style="margin-left: 5px;margin-top: 5px" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
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
                                                        <option value="Cash" selected>Cash</option>
                                                        <option value="Check">Check</option>
                                                    </select>
                                                    <span>&nbsp;</span>
                                                    <input type="text" name="check_number" id="check_number" class="form-control" placeholder="Check Number">
                                                    <span>&nbsp;</span>
                                                    <input type="date" name="check_date" id="check_date" class=" form-control" placeholder="Issue Deposit Date ">
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
                                        </script>
                                    @endpush
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="tile-footer text-right">
                <h3><strong><span style="margin-right: 50px;">Total Amount: {{$sum_total_amount}}</span></strong></h3>
                <h3><strong><span style="margin-right: 50px;">Paid Amount: {{$sum_paid_amount}}</span></strong></h3>
                <h3><strong><span style="margin-right: 50px;">Due Amount: {{$sum_due_amount}}</span></strong></h3>
            </div>
        </div>


    </main>
@endsection


