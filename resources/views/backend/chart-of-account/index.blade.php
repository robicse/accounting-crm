@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
{{--        <div class="app-title">--}}
{{--            <div>--}}
{{--                <h1><i class=""></i> All COA</h1>--}}
{{--            </div>--}}
{{--            <ul class="app-breadcrumb breadcrumb">--}}
{{--                <li class="breadcrumb-item"> <a href="{!! route('ChartOfAccount.create') !!}" class="btn btn-sm btn-primary" type="button">Add COA</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}

        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">COA Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-responsive table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th width="10%">Group 1</th>
                            <th width="15%">Group 2</th>
                            <th width="15%">Group 3</th>
                            <th width="15%">Group 4</th>
{{--                            <th width="15%">Action</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($chartOfAcc as $key => $coa)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $coa->group_1}}</td>
                            <td>{{ $coa->group_2}}</td>
                            <td>{{ $coa->group_3}}</td>
                            <td>{{ $coa->group_4}}</td>
\
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                    <!-- Credit Sale -->
{{--                    <div id="customar_modal" class="modal fade" role="dialog">--}}
{{--                        <div class="modal-dialog modal-md">--}}
{{--                            <div class="modal-content">--}}
{{--                                <div class="modal-header" style="background-color:green; color: white">--}}
{{--                                    <h4>Sample Import</h4>--}}
{{--                                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--                                </div>--}}
{{--                                <div class="modal-body">--}}
{{--                                    <div id="customerErrr3" class="alert hide"> </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12 col-md-12">--}}
{{--                                            <div class="panel panel-bd lobidrag">--}}
{{--                                                <div class="panel-body">--}}
{{--                                                    <img src="{{asset('uploads/sample.jpg')}}" alt="" style="width:100%;height: 100%">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>

        </div>
    </main>
@endsection


@push('js')
    <script>
        // $('#submit').click(function(){
        //     if($('#myMessage').val() == ''){
        //         alert('Input can not be left blank');
        //     }
        //     return true;
        // });


        function modal_customer(){
            $('#customar_modal').modal('show');
        }
    </script>
@endpush
