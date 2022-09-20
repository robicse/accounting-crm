@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Customer Support</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('customer_complain.create') !!}" class="btn btn-sm btn-primary" type="button">Add  Customer Support</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title"> Customer Support</h3>
                <table id="example1" class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr>
                        <th width="5%">SL NO</th>
                        <th width="5%">Complain Id</th>
                        <th width="7%">Date</th>
                        <th width="10%">Name</th>
                        <th width="8%">Phone</th>
                        <th width="10%">Address </th>
                        <th width="20%">Review </th>
                        <th width="10%">Status </th>
                        <th width="15%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customer_complains as $key => $customer_complain)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>COMP{{ $customer_complain->id }}</td>
                        <td>{{ $customer_complain->date}}</td>
                        <td>{{ $customer_complain->name}}</td>
                        <td>{{ $customer_complain->phone}}</td>
                        <td>{{ $customer_complain->address}}</td>
                        <td>{{ $customer_complain->description}}</td>
                        <td>{{ $customer_complain->status}}</td>
                        <td>
                            <a href="{{ route('customer_complain.edit',$customer_complain->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('customer_complain.complete',$customer_complain->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px">complete</a>
                            <form method="post" action="{{ route('customer_complain.destroy',$customer_complain->id) }}" >
                               @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger" style="margin-left: 5px" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </main>
@endsection


