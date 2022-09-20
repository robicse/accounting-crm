@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Party</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('ChartOfAccount.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Party</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Party</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('ChartOfAccount.update',$coa->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Group 1 </label>
                            <div class="col-md-8">
                                <input type="text" id="group_1" name="group_1" value="{{$coa->group_1}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Group 2 </label>
                            <div class="col-md-8">
                                <input type="text" id="group_2" name="group_2" value="{{$coa->group_2}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Group 3</label>
                            <div class="col-md-8">
                                <input type="text" id="group_3" name="group_3" value="{{$coa->group_3}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Group 4</label>
                            <div class="col-md-8">
                                <input type="text" id="group_4" name="group_4" value="{{$coa->group_4}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Head Type</label>
                            <div class="col-md-8">
                                <input type="text" id="head_type" name="head_type" value="{{$coa->head_type}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Status </label>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" selected>active</option>
                                    <option value="2">inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save COA</button>
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


