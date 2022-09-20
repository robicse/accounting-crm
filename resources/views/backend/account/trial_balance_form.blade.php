@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Trial Balance</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <form method="post" action="{{ route('account.trial_balance') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="control-label col-md-3 text-right">From</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control-sm" name="date_from" value="" id="demoDate" required>
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
                            <input type="date" class="form-control-sm" name="date_to" value="" required />
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
                <div class="tile-footer">
                </div>
            </div>

        </div>
    </main>
@endsection


