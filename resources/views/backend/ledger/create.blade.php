@extends('backend._partial.dashboard')
<style>
    .requiredCustom{
        font-size: 20px;
        color: red;
    }
</style>

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Add Ledger </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('Ledger.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Ledger </a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add Ledger </h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('Ledger.store') }}">
                        @csrf
                        <div class="table-responsive">
                            <input type="button" class="btn btn-primary add " style="margin-left: 804px;" value="Add More">
                            <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th >ID</th>
                                <th>Account Name <small class="requiredCustom">*</small></th>
                                <th>Name <small class="requiredCustom">*</small></th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="neworderbody">
                            <tr>
                                <td width="5%" class="no">1</td>
                                <td>
                                    <select class="form-control account_id select2" name="chart_of_account_id[]" id="chart_of_account_id_1" required>
                                        <option value="">Select Account Name</option>
                                        @foreach($chartOfAccounts as $account)
                                            <option value="{{$account->id}}">{{$account->group_1}}.{{$account->group_2}}.{{$account->group_3}}.{{$account->group_4}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" min="1" max="" class="form-control" name="name[]" value="" required >
                                </td>
                            </tr>

                            </tbody>

                            <tfoot>

                            </tfoot>
                        </table>
                             <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Ledger</button>
                            </div>
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

        $(function () {
            $('.getmoney').change(function(){
                var total = $('#total_amount').val();
                var getmoney = $(this).val();
                var t = total - getmoney;
                $('.backmoney').val(t);
            });
            $('.add').click(function () {
                var service = $('.account_id').html();
                var debit_or_credit = $('.debit_or_credit').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control account_id select2" name="chart_of_account_id[]" id="chart_of_account_id_'+n+'" required>' + service + '</select></td>' +
                    '<td><input type="text" min="1" max="" class=" form-control" name="name[]" value="" required></td>' +
                    // '<td><textarea type="text" class="form-control" rows="3" name="transaction_description[]" required></textarea></td>' +
                    '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';

                $('.neworderbody').append(tr);

                //initSelect2();

                $('.select2').select2();

            });
            $('.neworderbody').delegate('.delete', 'click', function () {
                $(this).parent().parent().remove();
                totalAmount();
            });



            $('#hideshow').on('click', function(event) {
                $('#content').removeClass('hidden');
                $('#content').addClass('show');
                $('#content').toggle('show');
            });



        });






    </script>
@endpush


