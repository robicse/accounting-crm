@extends('backend._partial.dashboard')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
    <main class="app-content">
        <div class="col-md-12">

            @if(session('response'))
                <div class="alert alert-success">
                    {{ session('response') }}
                </div>
            @endif


            <div class="tile">
                {{--<h3 class="tile-title">Accounts</h3>--}}
                <div class="col-sm-4" style="width: 33.33333333%;height:180px; float: left;">
                    <h2>Clean Tech Engineering</h2>
                    <p style="margin: 0px">Corporate Office :Corporate Office :Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                    <p style="margin: 0px"><b>Phone</b>:02-58052342, 01701-666 606, 01701-666 601, 01711-991 851 </p>
                    <p style="margin: 0px"> <b>Email</b>: Cleantechbd17@gmail.com</p>
                </div>

                <div class="col-sm-4" style="text-align: center; width: 33.33333333%; float: left;">
                    <h1>Receipt Payment</h1>
                    <h5>For The Period Of {{ $date_from }} to {{ $date_to }}</h5>
                </div>
                <div class="col-sm-4" style="text-align: right; width: 33.33333333%; float: left;">
                    From Date : {{ $date_from }}
                    <br/>
                    To Date : {{ $date_to }}
                    <br>

                </div>
                <div class="table-responsive" style="margin-top: 240px">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="10%">Date</th>
                        <th width="20%">Description</th>
{{--                        <th width="10%">Voucher Type</th>--}}
                        <th width="10%">Voucher NO</th>
                        <th width="12%">Receipt</th>
                        <th width="12%">Payment</th>
{{--                        <th width="12%">Balance</th>--}}
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
                                $pre_particulars = "To balance b/d (Previous Balance)";
                                $sum_debit += $PreBalance;
                            }else{
                                $pre_particulars = "By balance b/d (Previous Balance)";
                                $sum_credit += $PreBalance;
                            }
                        @endphp
                        <tr style="background-color: #b5b5b5">
                            <td>{{ $first_day }}</td>
                            <td>{{ $pre_particulars }}</td>
                            <td>{{ $preDebCre == 'De' ? number_format($PreBalance,2,'.',',') : '' }}</td>
                            <td>{{ $preDebCre == 'Cr' ? number_format($PreBalance,2,'.',',') : '' }}</td>
{{--                            <td>{{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}</td>--}}
                        </tr>
                    @endif
                    @foreach($general_ledger_infos as $key => $general_ledger_info)
                        @php
                            $debit = $general_ledger_info->debit;
                            $credit = $general_ledger_info->credit;

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
                            <td>{{ $general_ledger_info->posting_date }}</td>
                            <td>{{ $general_ledger_info->description }}</td>
{{--                            <td>--}}
{{--                                @php--}}
{{--                                    echo \App\VoucherType::where('id',$general_ledger_info->voucher_type_id)->pluck('name')->first();--}}
{{--                                @endphp--}}
{{--                            </td>--}}
                            <td>@php
                                    echo \App\VoucherType::where('id',$general_ledger_info->voucher_type_id)->pluck('name')->first();
                                @endphp - {{ $general_ledger_info->voucher_no }}</td>
                            <td>{{ number_format($debit,2,'.',',') }}</td>
                            <td>{{ number_format($credit,2,'.',',') }}</td>
{{--                            <td>{{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}</td>--}}
                        </tr>
                    @endforeach
                    @if($sum_debit !=$sum_credit)
                        @php
                            if($sum_debit > $sum_credit)
                            {
                                $final_debit_credit = $sum_debit;
                                $particulars =  "By balance c/d (Final Balance)";
                            }else{
                                $final_debit_credit = $sum_credit;
                                $particulars = "To balance c/d (Final Balance)";
                            }

                        @endphp
                        <tr style="background-color: #b5b5b5">
                            <td>{{ $last_day }}</td>
                            <td>{{ $particulars }}</td>
{{--                            <td>&nbsp;</td>--}}
{{--                            <td>&nbsp;</td>--}}
                            <td>&nbsp;</td>
                            <td>{{ $sum_credit > $sum_debit ? number_format($PreBalance,2,'.',',') : '' }}</td>
                            <td>{{ $sum_debit > $sum_credit ? number_format($PreBalance,2,'.',',') : '' }}</td>

                        </tr>
                    @endif
                    <tr>

{{--                        <td></td>--}}
{{--                        <td></td>--}}
                        <td></td>
                        <td align="right">Total</td>
                        <td>{{ number_format($sum_debit,2,'.',',') }}</td>
                        <td>{{ number_format($sum_credit,2,'.',',') }}</td>


                    </tr>
                    </tbody>
                </table>
                </div>
            </div>

                <div class="text-center">
                    <button onclick="window.print()" target="_blank"  id="printPageButton" class=" btn btn-sm btn-primary float-left">Print</button>
{{--                    <a href="{{ url('account/general-ledger-invoice/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
                </div>
        </div>
    </main>

@endsection

@section('footer')

    <script src="{{asset('js/form.js')}}"></script>

    {{--<script>--}}
    {{--$('#create-form').function({--}}
    {{--formReset: false,--}}
    {{--redirectPath: location.href,--}}
    {{--});--}}
    {{--</script>--}}
@section('other')
    <script>
        // $('button').load(function(){
        //     $('submit').modal('show');
        //  });

        $("form").on('submit', function(){
            $('.modal').show();
        })
    </script>
@endsection

@endsection
