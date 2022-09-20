@extends('backend._partial.dashboard')
<style>
    .requiredCustom{
        font-size: 20px;
        color: red;
        margin-top: 20px;
    }
</style>
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Sales Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Expenses</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Expenses</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                        <form method="post" action="{{ route('expenses.update',$expense->id) }}">
                            @method('PUT')
                            @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Costing Category  <small class="requiredCustom">*</small></label>
                            <div class="col-md-5">
                                <select name="office_costing_category_id" id="customer" class="form-control select2" required>
                                    <option value="">Select One</option>
                                    @foreach($officeCostingCategories as $officeCostingCategory)
                                        <option value="{{$officeCostingCategory->id}}" {{$expense->office_costing_category_id == $officeCostingCategory->id ? 'selected':''}}>{{$officeCostingCategory->name}} </option>
                                    @endforeach
                                </select>
                            </div>
{{--                            <div class="col-md-3"><a type="button" class="test btn btn-primary btn-sm" onclick="modal_customer()" data-toggle="modal"><i class="fa fa-plus"></i></a></div>--}}
                        </div>
{{--                        <div class="form-group row" @if(Auth::user()->roles[0]->name == 'User') style="display: none" @endif>--}}
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="store_id" id="store_id" class="form-control" >
{{--                                    <option value="">Select One</option>--}}
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{$expense->store_id == $store->id ? 'selected':''}}>{{$store->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Payment Type  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <select name="payment_type" id="payment_type" class="form-control" required>
                                    <option value="Cash" @if($expense->payment_type == 'Cash') selected @endif>Cash</option>
                                    <option value="Check" @if($expense->payment_type == 'Check') selected @endif>Check</option>
                                </select>
                                <span>&nbsp;</span>
                                <input type="text" name="check_number" id="check_number" class="form-control" value="{{$expense->check_number}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Amount  <small class="requiredCustom">*</small></label>
                            <div class="col-md-8">
                                <input type="text" name="amount" id="amount" class="form-control" value="{{$expense->amount}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Expense</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>

        <!-- Credit Sale -->
        <div id="customar_modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:green; color: white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="customerErrr3" class="alert hide"> </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="panel panel-bd lobidrag">
                                    <div class="panel-body">
                                        <form action="{{ route('parties.store.new') }}" id="customer_insert" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Name <small class="requiredCustom">*</small></label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="hidden" name="type" value="customer">
                                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" placeholder="Customer Name" name="name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Phone <small class="requiredCustom">*</small></label>
                                                <div class="col-md-8">
                                                    <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" placeholder="Customer Phone" name="phone">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Email <small class="requiredCustom">*</small></label>
                                                <div class="col-md-8">
                                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="Customer Email" name="email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 text-right">Address <small class="requiredCustom">*</small></label>
                                                <div class="col-md-8">
                                                    <textarea rows="5" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" type="text" placeholder="Customer Address" name="address"></textarea>
                                                    @if ($errors->has('address'))
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3"></label>
                                                <div class="col-md-8">
                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Party</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('js')
    <script>

        function modal_customer(){
            $('#customar_modal').modal('show');
        }

        //new customer insert
        $("#customer_insert").submit(function(e){
            e.preventDefault();
            //var customerMess    = $("#customerMess3");
            //var customerErrr    = $("#customerErrr3");
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function()
                {
                    //customerMess.removeClass('hide');
                    //customerErrr.removeClass('hide');
                },
                success: function(data)
                {
                    console.log(data);
                    if (data.exception) {
                        customerErrr.addClass('alert-danger').removeClass('alert-success').html(data.exception);
                    }else{
                        $('#customer').append('<option value = "' + data.id + '"  selected> '+ data.name + ' </option>');
                        console.log(data.id);
                        $("#customar_modal").modal('hide');
                    }
                },
                error: function(xhr)
                {
                    alert('failed!');
                }
            });
        });

        function hidemodal() {
            var x = document.getElementById("customar_modal");
            x.style.display = "none";
        }

        $(function() {
            <?php
            if($expense->payment_type == 'Cash'){
            ?>
            $('#check_number').hide();
            <?php } ?>
            $('#payment_type').change(function(){
                if($('#payment_type').val() == 'Check') {
                    $('#check_number').show();
                } else {
                    $('#check_number').val('');
                    $('#check_number').hide();
                }
            });
        });
    </script>
@endpush


