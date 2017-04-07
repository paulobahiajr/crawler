@extends('layout.layout')
@section('content')

    <h1 class="text-center">
        Lista de Serviços
    </h1>

    <div class="row index-grid">
        <div class="col-sm-6 col-md-3 text-center">
            <div class="text-center">
                <div class="img">
                    <img src="https://upload.wikimedia.org/wikipedia/pt/7/71/Cnpq-logo.jpg" width="100%">
                </div>
                <a href="{{ url('cnpq/crawl') }}">
                    <div class="btn btn-success">
                        Minar dados
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
