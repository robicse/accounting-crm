@extends('backend._partial.dashboard')
<style>
    #rcorners2 {
        border-radius: 25px;
        border: 2px solid black;
        padding: 5px;
        width: 30%;
        height:50px;
        margin-left: 270px;
        margin-top: 20px;
        text-align: center;
    }
</style>
@section('content')
    <main class="app-content">
        <div class="col-md-12">

            @if(session('response'))
                <div class="alert alert-success">
                    {{ session('response') }}
                </div>
            @endif


            <div class="tile">
                {{--<h3 class="tile-title">Accounts</h3>--}}
{{--                <div class="col-sm-3" style="width: 33.33333333%;height:180px; float: left;">--}}
{{--                    Company Info--}}
{{--                </div>--}}
                <div class="col-md-8" style="text-align: center; margin-left: 100px">
                    <h2>StarIT LTD</h2>
{{--                    <p style="margin: 0px">Corporate Housekeeping & Facility Management Service Provider</p>--}}
                    <p style="margin: 0px">
                       BBTOA Building,4th Floor,Road no:9 ,South Kallyanpur, Mirpur,Dhaka-1207
                    </p>
                    <p style="margin: 0px"><b>Phone</b>:+88028091125 <span>, <b>Email</b>:info@123@starit.com, </span> <span><b>Web</b> :www.123starir.com</span> </p>
                    <h2 id="rcorners2">Debit Voucher</h2>
                </div>
                <div class="col-md-4" style="text-align: right; float: right;margin-top: -58px ">
                   Transaction NO : {{$transaction}}
                    <br/>
                   Date : {{ $date_to }}
                </div>

                <div style="margin-top: 30px">
                    <p>Debit A/C: {{$general_ledger}}</p>
                    <p>Head of Account: {{$acc_name}}</p>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="70%" style="text-align: center">PARTICULARS</th>
                        <th width="30%" style="text-align: center">Taka</th>
{{--                        <th width="15%"  rowspan="3">Paisa</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $sum_debit = 0;
                        //$sum_credit = 0;
                        $final_debit_credit = 0;
                        $flag = 0;
                        $first_day = date('Y-m-01',strtotime($date_from));
                        $last_day = date('Y-m-t',strtotime($date_from));
                    @endphp

                    @foreach($general_ledger_infos as $key => $general_ledger_info)
                        @php
                            $debit = $general_ledger_info->debit;
                            //$credit = $general_ledger_info->credit;

                            $sum_debit  += $debit;
                            //$sum_credit += $credit;
                        @endphp
                        <tr>
                            <td>{{ $general_ledger_info->transaction_description }}</td>
                            <td>{{ number_format($debit,2,'.',',') }}</td>
{{--                            <td></td>--}}
                        </tr>
                    @endforeach
                    <tr>
                        <td align="right">Total</td>
                        <td>{{ number_format($sum_debit,2,'.',',') }}</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
                <div class="text-center">
                    <a href="{{ url('account/debit-voucher-print/'.$general_ledger.'/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>
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
