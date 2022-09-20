@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Transaction</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb" style="margin-bottom: 20px">
                <li class="breadcrumb-item"><a class="btn btn-warning" href="{{ route('transaction.export') }}">Export Data</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <div>
                    <h1><i class=""></i> All Transaction</h1>
                </div>
                <form class="form-inline" action="{{ url('transaction-list/'.$store_id) }}" style="margin-bottom: 20px">
                    <div class="form-group col-md-4">
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" value="{{$start_date}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" class="form-control" value="{{$end_date}}">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-success">Advanced Search</button>
                        <a href="{{ url('transaction-list/'.$store_id) }}" class="btn btn-primary" type="button">Reset</a>
                    </div>
                </form>

{{--                @if(!empty($stores))--}}
{{--                    @foreach($stores as $store)--}}
{{--                        <div class="col-md-12">--}}
{{--                            <h1 class="text-center">{{$store->name}}</h1>--}}
{{--                        </div>--}}
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">SL NO</th>
                                    <th width="10%">User</th>
                                    <th width="15%">Date</th>
                                    <th width="15%">Party</th>
                                    <th width="15%">Transaction Type</th>
                                    <th width="15%">Payment Type</th>
                                    <th width="15%">Amount</th>

                                </tr>
                                </thead>
                                <tbody>
{{--                                @php--}}
{{--                                    $transactions = \App\Transaction::where('store_id',$store->id)->latest()->get();--}}
{{--                                @endphp--}}
                                @if(!empty($transactions))
                                    @foreach($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $transaction->user->name}}</td>
                                            <td>{{ $transaction->created_at}}</td>
                                            <td>{{ $transaction->party ? $transaction->party->name : ''}}</td>
                                            @if($transaction->transaction_type == 'sale')
                                            <td>{{ $transaction->transaction_type}} .{{ $transaction->sale_type}} </td>
                                            @else
                                            <td>{{ $transaction->transaction_type}}</td>
                                            @endif
                                            <td>
                                                {{ $transaction->payment_type}}
                                                @if($transaction->payment_type == 'Check')
                                                    ( {{$transaction->check_number}} )
                                                @endif
                                            </td>
                                            <td>{{ $transaction->amount}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="tile-footer">
                            </div>
                        </div>
{{--                    @endforeach--}}
{{--                @endif--}}
            </div>

        </div>
    </main>
@endsection


