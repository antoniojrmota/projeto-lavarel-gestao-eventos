@extends('layouts.main')

@section('title', 'HDC Eventos')

@section('content')

    <div id="search-container" class="col-md-12">
        <h1>Busque um evento</h1>
        <form action="/" method="GET">
            <input type="text" id="search" name="search" class="form-control" placeholder="Procurar...">
        </form>
    </div>
    <div id="events-container" class="col-md-12">
        @if ($search)
            <h2>Buscando por: {{ $search }}</h2>
        @else
            <h2>Próximos Eventos</h2>
        @endif
        <p class="subtitle">Veja os eventos dos próximos dias</p>
        <div id="cards-container" class="row">
            @foreach ($eventos as $evento)
                <div class="card col-md-3">
                    <img src="/assets/img/eventos/{{ $evento->image }}" alt="{{ $evento->title }}">
                    <div class="card-body">
                        <p class="card-date">{{ date('d/m/Y', strtotime($evento->date)) }}</p>
                        <h5 class="card-title">{{ $evento->title }}</h5>
                        <p class="card-participants">X Participantes</p>
                        <a href="/eventos/{{ $evento->id }}" class="btn btn-primary">Saber mais</a>
                    </div>
                </div>
            @endforeach
            @if (!count($eventos) && $search)
                <p>Não foi possível encontrar nenhum evento com {{ $search }}! <a href="/">Ver todos</a></p>
            @elseif(!count($eventos))
                <p>Não há eventos disponíveis</p>
            @endif
        </div>
    </div>

@endsection
