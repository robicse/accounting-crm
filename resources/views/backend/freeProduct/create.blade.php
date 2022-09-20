@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Add Free Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('free-products.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Free Product</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add Free Product</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('free-products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Name <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Image <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input type="file" id="image" name="image" class="form-control-file">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Description</label>
                            <div class="col-md-8">
                                <textarea  id="description" rows="3" name="description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Status <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">active</option>
                                    <option value="2">inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Free Product</button>
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
        $('#phone').keyup(function (){
            var phone = $(this).val();
            $.ajax({
                url :  "{{URL('check-phone-number')}}",
                method : "get",
                data : {
                    phone : phone
                },
                success : function (res){
                    console.log(res)
                    if(res.data == 'Found'){
                        $('#phone').val('')
                        alert('Phone Number already exists, please add another!')
                        return false
                    }
                },
                error : function (err){
                    console.log(err)
                }

            })

        })
    </script>
@endpush
