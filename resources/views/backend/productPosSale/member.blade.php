<div class="modal" id="modal-member" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
            <h3 class="modal-title">Customer</h3>
        </div>

        <div class="modal-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parties as $data)
                    <tr>
                        <th>{{ $data->phone }}</th>
                        <th>{{ $data->name }}</th>
                        <th>{{ $data->address }}</th>
                        <th>{{ $data->email }}</th>
                        <th><a onclick="selectMember({{ $data->id }})" class="btn btn-primary"><i class="fa fa-check-circle"></i> Select</a></th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        </div>
    </div>
</div>
