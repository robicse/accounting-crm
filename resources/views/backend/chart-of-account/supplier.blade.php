@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Supplier</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('party.create') !!}" class="btn btn-sm btn-primary" type="button">Add Supplier</a></li>
            </ul>
        </div>
{{--        <div class="card-body">--}}
{{--            <form action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">--}}
{{--                @csrf--}}
{{--                <input type="file" name="file" class="form-control">--}}
{{--                <br>--}}
{{--                <button class="btn btn-success" id="submit" onclick="sendMessage(); clearInput();">Import data</button>--}}
{{--                <a class="btn btn-warning" href="{{ route('customer.export') }}">Export Data</a>--}}
{{--                <a  class=" btn btn-info btn-sm" onclick="modal_customer()" data-toggle="modal">Sample Import</a>--}}
{{--            </form>--}}
{{--        </div>--}}
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Supplier Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th width="10%">Type</th>
                            <th width="15%">Name</th>
                            <th width="15%">Phone</th>
                            <th width="15%">Email</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parties as $key => $party)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $party->type}}</td>
                            <td>{{ $party->name}}</td>
                            <td>{{ $party->phone}}</td>
                            <td>{{ $party->email}}</td>
                            <td>
                                <a href="{{ route('party.edit',$party->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('party.destroy',$party->id) }}" >
                                   @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" style="margin-left: 5px" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                    <!-- Credit Sale -->
                    <div id="customar_modal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color:green; color: white">
                                    <h4>Sample Import</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div id="customerErrr3" class="alert hide"> </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="panel panel-bd lobidrag">
                                                <div class="panel-body">
                                                    <img src="{{asset('uploads/product/honey.jpg')}}" alt="" style="width:100%;height: 100%">
                                                </div>
                                            </div>
                                        </div>
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
        $('#submit').click(function(){
            if($('#submit').val() == ''){
                alert('Import can not be left blank');
            }
            return false;
        });
        function modal_customer(){
            $('#customar_modal').modal('show');
        }
    </script>
@endpush
