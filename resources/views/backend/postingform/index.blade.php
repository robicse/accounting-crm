@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Posting </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('postingForm.create') !!}" class="btn btn-sm btn-primary" type="button">Add Posting </a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Posting Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">#Id</th>
                        <th>Date</th>
                        <th>Voucher Type</th>
                        <th>Voucher No</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($postingForms as $key => $posting)

                        @php
                            $current_transactions = \Illuminate\Support\Facades\DB::table('posting_forms')
                        ->where('voucher_type_id',$posting->voucher_type_id)
                        ->where('voucher_no',$posting->voucher_no)
                        ->first();
                        @endphp
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $posting->posting_date}}</td>
                        <td>
                            @php
                                echo \App\VoucherType::where('id',$posting->voucher_type_id)->pluck('name')->first();
                            @endphp
                        </td>
                        <td> @php
                                echo \App\VoucherType::where('id',$posting->voucher_type_id)->pluck('name')->first();
                            @endphp -{{ $current_transactions->voucher_no}}</td>
                        <td>
                            <a href="{{ url('account/posting-invoice/'.$posting->voucher_type_id.'/'.$posting->voucher_no) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px">print</a>
                            <a href="{{ url('account/posting-edit/'.$posting->voucher_type_id.'/'.$posting->voucher_no) }}" class="btn btn-sm btn-info float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{ url('account/posting-delete/'.$posting->voucher_type_id.'/'.$posting->voucher_no.'/'.$posting->id) }}">
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


