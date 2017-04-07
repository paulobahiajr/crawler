@extends('layout.layout')
@section('content')

    <h1 class="text-center">
        Lista de Licitações CNPQ
    </h1>

    @foreach($data as $item)
        @if ($loop->first || $loop->iteration === 5 || $loop->iteration === 9 || $loop->iteration === 13)
            <div class="row row-eq-height">
                @endif
                <div class="col-md-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $item->origin }} - {{ $item->title }}</h3>
                        </div>
                        <div class="panel-body">
                            <h6>Abertura: <b>{{ $item->starting_date }}</b>
                                Publicação: <b>{{ $item->publish_date }}</b></h6>
                            <p>{{ $item->object }}</p>
                        </div>
                        <div class="panel-footer">
                            @foreach($item->attachments as $attach)
                            <a href="{{ $attach["File"] }}" class="card-link">{{ $attach["Name"] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if ($loop->iteration === 4 || $loop->iteration === 8 || $loop->iteration === 12 || $loop->last)
            </div>
        @endif
    @endforeach

    {{ $data->links() }}
@endsection
