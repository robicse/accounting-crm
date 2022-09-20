@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            </ul>
        </div>
        <div class="row">
            @if(!empty($stores))
                @foreach($stores as $key => $store)

                    <div class="col-md-4">
                        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                            <div class="info">
                                <h4><a href="{{ url('stock-summary/'.$store->id) }}">{{$store->name}}</a></h4>
                                <p><b>Show Stock Summary</b></p>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif
        </div>
    </main>
@endsection


