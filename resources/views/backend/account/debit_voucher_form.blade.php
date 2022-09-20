@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i>Debit Voucher</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Debit Voucher</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('account.debit_voucher') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">General Ledger Head</label>
                            <div class="col-md-3">
                                <select class="form-control select2" name="general_ledger" id="general_ledger">
                                    <option value="">Select One</option>
                                    @foreach($general_ledger_account_nos as $general_ledger_account_no)
                                        <option value="{{ $general_ledger_account_no->HeadCode }}">{{ $general_ledger_account_no->HeadName }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('general_ledger'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('general_ledger') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">From</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_from" required>
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
                                <input type="date" class="form-control-sm" name="date_to" required>
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
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
    <!-- select2-->
    <script src="{!! asset('backend/js/plugins/select2.min.js') !!}"></script>
{{--    <script>--}}
{{--        $('.select2').select2();--}}

{{--        $(document).ready(function(){--}}
{{--            $('#general_ledger').change(function(){--}}
{{--                var general_ledger = $('#general_ledger').val();--}}
{{--                /*console.log(general_ledger);*/--}}

{{--                $.ajax({--}}
{{--                    url : "{{ URL('/get-transaction-head') }}/"+general_ledger,--}}
{{--                    method : 'get',--}}
{{--                    success : function(data){--}}
{{--                        /*console.log(data);*/--}}
{{--                        $('#transaction_head').html(data.response);--}}
{{--                        $('#transaction_head').show();--}}
{{--                    }--}}
{{--                });--}}
{{--            })--}}
{{--        });--}}
{{--    </script>--}}
@endsection


