@if(!empty($stores))
    @foreach($stores as $store)
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Clean Tech Engineering</th>
                    </tr>
                    <tr>
                        <th>ID#</th>
                        <th>Stock Type</th>
                        <th>Product</th>
                        <th>Previous Stock</th>
                        <th>Stock In</th>
                        <th>Stock Out</th>
                        <th>Current Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stocks = \App\Stock::where('store_id',$store->id)->get();
                    @endphp
                    @if(!empty($stocks))
                        @foreach($stocks as $key => $stock)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $stock->store->name}}</td>
                                <td>{{ $stock->stock_type}}</td>
                                <td>{{ $stock->product->name}}</td>
                                <td>{{ $stock->previous_stock}}</td>
                                <td>{{ $stock->stock_in}}</td>
                                <td>{{ $stock->stock_out}}</td>
                                <td>{{ $stock->current_stock}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    @endforeach
@endif
