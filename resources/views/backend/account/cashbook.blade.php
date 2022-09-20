@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Cash Book</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Cash Book</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('account.cashbook') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">From</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_from" value="{{ $date_from }}" id="demoDate" required>
                                @if ($errors->has('date_from'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_from') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">To</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_to" value="{{ $date_to }}" required />
                                @if ($errors->has('date_to'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_to') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>View
                                </button>
                            </div>
                        </div>
                    </form>
                    <h5 align="center">Cash Book Report from date {{ $date_from }} to date {{ $date_to }}</h5>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="10%">Date</th>
                            <th width="30%">Description</th>
                            <th width="10%">Voucher Type</th>
                            <th width="10%">Voucher NO</th>
                            <th width="10%">Debit</th>
                            <th width="10%">Credit</th>
                            <th width="10%">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sum_debit = 0;
                            $sum_credit = 0;
                            $final_debit_credit = 0;
                            $flag = 0;
                            $first_day = date('Y-m-01',strtotime($date_from));
                            $last_day = date('Y-m-t',strtotime($date_from));
                        @endphp
                        @if($PreBalance > 0)
                            @php
                                if( ($PreBalance > 0) && ($preDebCre == 'De') )
                                {
                                    $pre_particulars = "To balance b/d";
                                    $sum_debit += $PreBalance;
                                }else{
                                    $pre_particulars = "By balance b/d";
                                    $sum_credit += $PreBalance;
                                }
                            @endphp
                            <tr style="background-color: red;">
                                <td>{{ $first_day }}</td>
                                <td>{{ $pre_particulars }}</td>
                                <td>{{ $preDebCre == 'De' ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                <td>{{ $preDebCre == 'Cr' ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                <td>{{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}</td>
                            </tr>
                        @endif

                        @if(!empty($cash_data_results))
                            @foreach($cash_data_results as $key => $cash_data_result)
                                @php
                                    $debit  = $cash_data_result->debit;
                                    $credit = $cash_data_result->credit;

                                    $sum_debit  += $debit;
                                    $sum_credit += $credit;



                                    if($debit > $credit)
                                        $curRowDebCre = 'De';
                                    else
                                        $curRowDebCre = 'Cr';

                                    //dd($preDebCre);

                                    if($preDebCre == 'De/Cr' && $flag == 0)
                                    {
                                        $preDebCre = $curRowDebCre;
                                        $flag = 1;
                                    }

                                    if($preDebCre == 'De' && $curRowDebCre == 'De')
                                    {
                                        /*if($PreBalance > $debit)
                                        {
                                            $PreBalance = $PreBalance - $debit;
                                        }else{
                                            $PreBalance = $debit - $PreBalance;
                                        }*/
                                        $PreBalance += $debit;
                                        $preDebCre = 'De';
                                    }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                                        if($PreBalance > $credit)
                                        {
                                            $PreBalance = $PreBalance - $credit;
                                            $preDebCre = 'De';
                                        }else{
                                            $PreBalance = $credit - $PreBalance;
                                            $preDebCre = 'Cr';
                                        }
                                    }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                                        if($PreBalance > $debit)
                                        {
                                            $PreBalance = $PreBalance - $debit;
                                            $preDebCre = 'Cr';
                                        }else{
                                            $PreBalance = $debit - $PreBalance;
                                            $preDebCre = 'De';
                                        }
                                    }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                                        /*if($PreBalance > $credit)
                                        {
                                            $PreBalance = $PreBalance - $credit;
                                        }else{
                                            $PreBalance = $credit - $PreBalance;
                                        }*/
                                        $PreBalance += $credit;
                                        $preDebCre = 'Cr';
                                    }else{

                                    }

                                @endphp

                                <tr>
                                    <td>{{ $cash_data_result->date }}</td>
                                    <td>{{ $cash_data_result->transaction_description }}</td>
                                    <td>
                                        @php
                                            echo \App\VoucherType::where('id',$cash_data_result->voucher_type_id)->pluck('name')->first();
                                        @endphp
                                    </td>
                                    <td>{{ $cash_data_result->voucher_no }}</td>
                                    <td>{{ number_format($debit,2,'.',',') }}</td>
                                    <td>{{ number_format($credit,2,'.',',') }}</td>
                                    <td>
                                        {{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        @if($sum_debit !=$sum_credit)
                            @php
                                if($sum_debit > $sum_credit)
                                {
                                    $final_debit_credit = $sum_debit;
                                    $particulars = "By balance c/d";
                                }else{
                                    $final_debit_credit = $sum_credit;
                                    $particulars = "To balance c/d";
                                }

                            @endphp
                            <tr style="background-color: red;">
                                <td>{{ $last_day }}</td>
                                <td>{{ $particulars }}</td>
                                <td>{{ $particulars }}</td>
                                <td>{{ $sum_credit > $sum_debit ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                <td>{{ $sum_debit > $sum_credit ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endif
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="float: right">Total</td>
                            <td>{{ number_format($sum_debit,2,'.',',') }}</td>
                            <td>{{ number_format($sum_credit,2,'.',',') }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>
                        </div>
                </div>
                <div class="tile-footer">
                </div>
            </div>
{{--            <div class="text-center">--}}
{{--                <a href="{{ url('account/cashbook-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
{{--            </div>--}}
        </div>
    </main>

    <!-- select2-->
    <script src="{!! asset('backend/js/plugins/select2.min.js') !!}"></script>
    <script src="{!! asset('backend/js/plugins/bootstrap-datepicker.min.js') !!}"></script>
    <script>
        $('.select2').select2();
    </script>
@endsection


