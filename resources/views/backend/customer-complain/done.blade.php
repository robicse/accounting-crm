@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Complete Customer Support</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('customer_complain.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Customer Support</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Complete Customer Support</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('customer_complain_complete',$customer_complains->id) }}">
                        @csrf

                        <div class="row" style="margin-top: 22px;display: none">
                            <label class="control-label">Phone</label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" placeholder="Phone" name="phone" value="{{$customer_complains->phone}}">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 22px">
                            <label class="control-label">Status</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" placeholder="Status" name="status" value="{{$customer_complains->status }}">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8" style="margin-top: 20px">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Customer Complaint</button>
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


