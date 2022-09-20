@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Add Customer Support</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('customer_complain.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Customer Support</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add Customer Support</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('customer_complain.store') }}">
                        @csrf
                        <div class="row">
                            <label class="control-label">Date <span style="color: red">*</span></label>
                            <div class="col-md-5">
                                <input class="form-control " type="date" placeholder="Date" name="date">
                            </div>
                            <label class="control-label ">Name <span style="color: red">*</span></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" placeholder="Name" name="name" required>
                            </div>

                        </div>
                        <div class="row" style="margin-top: 22px">
                            <label class="control-label">Phone<span style="color: red">*</span></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" placeholder="Phone" name="phone" required>
                            </div>
                            <label class="control-label">Address <span style="color: red">*</span></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" placeholder="Address" name="address" required>

                            </div>
                        </div>
                        <div class="row" style="margin-top: 22px">
                            <label class="control-label">Review <span style="color: red">*</span></label>
                            <div class="col-md-5">
                                <textarea class="form-control" rows="4" name="description" placeholder="Enter Complains" ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8" style="margin-top: 20px">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Online Platform</button>
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


