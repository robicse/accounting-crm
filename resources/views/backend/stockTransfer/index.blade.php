@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Stock Transfer</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('stockTransfers.create') !!}" class="btn btn-sm btn-primary" type="button">Add Stock Transfer</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">

                <h3 class="tile-title">Product Stock Transfer Table</h3>
                <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped" style="width:100%;overflow-x:auto;">
                    <thead>
                    <tr>
                        <th width="5%">#Id</th>
                        <th>Invoice NO</th>
                        <th>User</th>
                        <th>From Store</th>
                        <th>To Store</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stockTransfers as $key => $stockTransfer)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $stockTransfer->invoice_no}}</td>
                        <td>{{ $stockTransfer->user->name}}</td>
                        <td>{{ $stockTransfer->from_store->name}}</td>
                        <td>{{ $stockTransfer->to_store->name}}</td>
                        <td>{{ $stockTransfer->send_remarks}}</td>
                        <td class="d-inline-flex">
                            <a href="{{ route('stockTransfers.show',$stockTransfer->id) }}" class="btn btn-sm btn-info float-left">Show</a>
                            <a href="{{ route('stock.transfer.invoice',$stockTransfer->id) }}" class="btn btn-sm btn-primary float-left">invoice</a>
{{--                            <form method="post" action="{{ route('stockTransfers.destroy',$stockTransfer->id) }}" >--}}
{{--                               @method('DELETE')--}}
{{--                                @csrf--}}
{{--                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>--}}
{{--                            </form>--}}
                        </td>
                    </tr>
                    <!-- Modal -->
{{--                    <div class="modal fade" id="exampleModal-{{$stockTransfer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                        <div class="modal-dialog" role="document">--}}
{{--                            <div class="modal-content">--}}
{{--                                <div class="modal-header">--}}
{{--                                    <h5 class="modal-title" id="exampleModalLabel">Pay Due</h5>--}}
{{--                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                        <span aria-hidden="true">&times;</span>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                                <div class="modal-body">--}}
{{--                                    <form action="{{route('pay.due')}}" method="post">--}}
{{--                                        @csrf--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="due">Enter Due Amount</label>--}}
{{--                                            <input type="hidden" class="form-control" name="product_sale_id" value="{{$stockTransfers->id}}">--}}
{{--                                            <input type="number" class="form-control" id="due" aria-describedby="emailHelp" name="new_paid" min="" max="{{$stockTransfers->due_amount}}" placeholder="Enter Amount">--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                        @endforeach
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>

        </div>
    </main>
@endsection


