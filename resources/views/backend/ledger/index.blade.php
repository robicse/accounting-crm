@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Ledger </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('Ledger.create') !!}" class="btn btn-sm btn-primary" type="button">Add Ledger </a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Ledger Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">#Id</th>
                        <th>Name</th>
                        <th width="40%">Account Head</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ledgers as $key => $ledger)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $ledger->name}}</td>
                        <td>{{ $ledger->COA->group_1}}.{{ $ledger->COA->group_2}}.{{ $ledger->COA->group_3}}.{{ $ledger->COA->group_4}}</td>

                        <td>
                            <a href="{{ route('Ledger.edit',$ledger->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{ route('Ledger.destroy',$ledger->id) }}" >
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
                </div>

            </div>

        </div>
    </main>
@endsection


