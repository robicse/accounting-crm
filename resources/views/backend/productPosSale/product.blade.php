<div class="modal" id="modal-produk" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Cart Product</h3>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Product Name</th>
                        <th>Purchase Price</th>
                        <th>Stock Qty</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $data)
                        <tr>
                            <th>{{ $data->barcode }}</th>
                            <th>
                                @php
                                    echo $product_name = \App\Product::where('id',$data->product_id)->pluck('name')->first();
                                @endphp
                            </th>
                            <th>
                                Tk.
                                @php
                                    echo $product_price = \App\ProductPurchaseDetail::where('product_id',$data->product_id)->latest()->pluck('mrp_price')->first();
                                @endphp
                            </th>
                            <th>
                                @php
                                    echo $product_current_stock = \App\Stock::where('product_id',$data->product_id)->latest()->pluck('current_stock')->first();
                                @endphp
                            </th>
                            <th><a onclick="selectItem('{{ $data->barcode }}')" class="btn btn-primary"><i class="fa fa-check-circle"></i> Select</a></th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
