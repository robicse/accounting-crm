@if(!empty($stores))
    @foreach($stores as $store)
<table class="table table-bordered mt-3">
    <thead>
    <tr>
        <th>Clean Tech Engineering</th>
    </tr>
    <tr>
        <th>#ID</th>
        <th>Invoice NO</th>
        <th>Store</th>
        <th>Delivery Service</th>
        <th>Delivery Service Charge</th>
    </tr>
    </thead>
    <tbody>
    @php
        $delivery_charges = \App\ProductSale::where('store_id',$store->id)->get();
    @endphp
    @if(!empty($delivery_charges))
        @foreach($delivery_charges as $key => $delivery_charge)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $delivery_charge->invoice_no}}</td>
                <td>{{ $delivery_charge->store->name}}</td>
                <td>{{ $delivery_charge->delivery_service}}</td>
                <td>{{ $delivery_charge->delivery_service_charge}}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
    @endforeach
@endif
