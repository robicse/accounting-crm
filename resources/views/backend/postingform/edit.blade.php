@extends('backend._partial.dashboard')
<style>
    .requiredCustom{
        font-size: 20px;
        color: red;
    }
</style>

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Posting </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('posting.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Posting </a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Posting </h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('account/posting-form-update/'.$postingForms[0]->voucher_type_id.'/'.$postingForms[0]->voucher_no)}}">
                        @csrf
{{--                        @method('PUT')--}}
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <div class="col-md-12 form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label text-right">Voucher Type <small class="requiredCustom">*</small></label>
                                            <select class="form-control select2 " name="voucher_type_id" id="voucher_type_id" required>
                                                <option value="">Select Voucher Type</option>
                                                @foreach($voucherTypes as $voucherType)
                                                    <option value="{{$voucherType->id}}"{{ $voucherType->id == $postingForms [0]->voucher_type_id ? 'selected' : '' }}>{{$voucherType->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label text-right">Voucher No <small class="requiredCustom">*</small></label>
                                            <input type="number" name="voucher_no" id="voucher_no" class="form-control" value="{{$postingForms[0] ->voucher_no}}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label ">Description <small class="requiredCustom">*</small></label>
                                            <textarea type="text" min="1" max="" rows="3" class="form-control" name="description"> {!! $postingForms[0]->description !!}</textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label text-right">Date  <small class="requiredCustom">*</small></label>
                                            <input type="hidden" name="posting_form_id" id="posting_form_id" value="{{$postingForms[0]->id}}" class="datepicker form-control">
                                            <input type="text" name="date" class="datepicker form-control" value="{{$postingForms[0]->posting_date}}">
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </table>
{{--                        <input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More Product">--}}
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th >ID</th>
                                <th>Account Name <small class="requiredCustom">*</small></th>
                                <th>Ledger Name <small class="requiredCustom">*</small></th>
                                <th>Debit/Credit <small class="requiredCustom">*</small></th>
                                <th>Amount <small class="requiredCustom">*</small></th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody class="neworderbody">
                            @foreach($postingFormsDetails as $key => $postingFormsDetail)
                            <tr>
                                <td width="5%" class="no">{{$key+1}}</td>
                                <td width="30%">
                                    <input type="hidden" class="form-control" name="posting_form_details_id[]" value="{{$postingFormsDetail->id}}" >
                                    <select class="form-control account_id select2" name="account_id[]" id="account_id_{{$key+1}}" onchange="getval({{$key+1}},this);" required>
                                        <option value="">Select Account Name</option>
                                        @foreach($chartOfAccounts as $account)
                                            <option value="{{$account->id}}" {{ $postingFormsDetail->chart_of_account_id == $account->id ? 'selected' : ''}}>{{$account->group_1}}.{{$account->group_2}}.{{$account->group_3}}.{{$account->group_4}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td id="ledger_id_{{$key+1}}"  width="30%">
                                    <select class="form-control ledger_id select2" name="ledger_id[]" id="ledger_id_{{$key+1}}" onchange="getLedgerListByAccountName({{$key+1}},this);"  required>
                                        <option value="">Select Legder Name</option>
                                        @php
                                            $edited_ledgers = \App\Ledger::where('chart_of_account_id',$postingFormsDetail->chart_of_account_id)->get();
                                        @endphp
                                        @foreach($edited_ledgers as $ledger)
                                            <option value="{{$ledger->id}}" {{ $postingFormsDetail->ledger_id == $ledger->id ? 'selected' : ''}}>{{$ledger->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control debit_or_credit select2" name="debit_or_credit[]" id="debit_or_credit_1" required>
                                        <option value="">Select One</option>
                                        <option value="debit" {{ $postingFormsDetail->debit != Null ? 'selected' : ''}}>Debit</option>
                                        <option value="credit" {{$postingFormsDetail->credit != Null ? 'selected' : '' }}>Credit</option>

                                    </select>
                                </td>
                                <td>
                                    <input type="number" min="1" max="" class="price form-control" name="amount[]" value="{{ $postingFormsDetail->debit == Null ? $postingFormsDetail->credit : $postingFormsDetail->debit  }}" required>
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
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Posting</button>
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

        function totalAmount(){
            var t = 0;
            $('.amount').each(function(i,e){
                var amt = $(this).val()-0;
                t += amt;
            });
            $('#total_amount').val(t);
        }
        $(function () {
            $('.getmoney').change(function(){
                var total = $('#total_amount').val();
                var getmoney = $(this).val();
                var t = total - getmoney;
                $('.backmoney').val(t);
            });
            $('.add').click(function () {
                var service = $('.account_id').html();
                var ledger = $('.ledger_id').html();
                var debit_or_credit = $('.debit_or_credit').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td width="20%"><select class="form-control account_id select2" name="account_id[]" id="account_id_'+n+'" onchange="getval('+n+',this);" required>' + service + '</select></td>' +
                    '<td  width="20%"><select class="form-control ledger_id select2" name="ledger_id[]" id="ledger_id_'+n+'" onchange="getLedgerListByAccountName('+n+',this);" required>' + ledger + '</select></td>' +
                    '<td><select class="form-control debit_or_credit select2" name="debit_or_credit[]" id="debit_or_credit_'+n+'"  required>' + debit_or_credit + '</select></td>' +
                    '<td><input type="text" min="1" max="" class="price form-control" name="amount[]" value="" required></td>' +
                    // '<td><textarea type="text" class="form-control" rows="3" name="transaction_description[]" required></textarea></td>' +
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
                var tr = $(this).parent().parent();
                var qty = tr.find('.qty').val() - 0;
                var price = tr.find('.price').val() - 0;

                var total = (qty * price);

                tr.find('.amount').val(total);
                totalAmount();
            });

            $('#hideshow').on('click', function(event) {
                $('#content').removeClass('hidden');
                $('#content').addClass('show');
                $('#content').toggle('show');
            });



        });

        // ajax
        function getval(row,sel)
        {
            //alert(row);
            //alert(sel.value);
            var current_row = row;
            var current_chart_of_account_id = sel.value;

            $.ajax({
                url : "{{URL('ledger-data')}}",
                method : "get",
                data : {
                    current_chart_of_account_id : current_chart_of_account_id
                },
                success : function (res){
                    //console.log(res)
                    console.log(res.data)
                    $("#ledger_id_"+current_row).html(res.data.ledgerOptions);

                },
                error : function (err){
                    console.log(err)
                }
            })
        }



        $(function() {
            $('#check_number').hide();
            $('#payment_type').change(function(){
                if($('#payment_type').val() == 'check') {
                    $('#check_number').show();
                } else {
                    $('#check_number').val('');
                    $('#check_number').hide();
                }
            });
        });

        // ajax
        function getLedgerListByAccountName(row,sel)
        {
            alert(row);
            //alert(sel.value);
            {{--var current_row = row;--}}
            {{--var current_chart_of_account_id = sel.value;--}}

            {{--$.ajax({--}}
            {{--    url : "{{URL('ledger-data')}}",--}}
            {{--    method : "get",--}}
            {{--    data : {--}}
            {{--        current_chart_of_account_id : current_chart_of_account_id--}}
            {{--    },--}}
            {{--    success : function (res){--}}
            {{--        //console.log(res)--}}
            {{--        console.log(res.data)--}}
            {{--        $("#ledger_id_"+current_row).html(res.data.ledgerOptions);--}}

            {{--    },--}}
            {{--    error : function (err){--}}
            {{--        console.log(err)--}}
            {{--    }--}}
            {{--})--}}
        }

        $('#voucher_type_id').on('change',function (){
            // alert();
            var current_voucher_type_id = $('#voucher_type_id').val();
            //var current_voucher_no = $('#voucher_no').val();
            var current_posting_form_id = $('#posting_form_id').val();
            
            
            $.ajax({
                url : "{{URL('get-voucher-number-edit')}}",
                method : "get",
                data : {
                    current_voucher_type_id : current_voucher_type_id,
                    //current_voucher_no : current_voucher_no,
                    current_posting_form_id : current_posting_form_id,
                },
                success : function (res){
                    //console.log(res)
                    console.log(res.data)
                    $("#voucher_no").val(res.data);
                },
                error : function (err){
                    console.log(err)
                }
            })

        });
    </script>
@endpush


