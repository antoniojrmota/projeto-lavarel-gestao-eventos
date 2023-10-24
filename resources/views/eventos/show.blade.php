@extends('layouts.main')

@section('title', $evento->title)

@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="/assets/img/eventos/{{ $evento->image }}" class="img-fluid" alt="{{ $evento->title }}">
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{ $evento->title }}</h1>
                <p class="events-participants"><ion-icon name="people-outline"></ion-icon> {{ count($evento->users) }} </p>
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon> {{ $eventoOwner['name'] }}</p>
                @if (!$hasUserJoined)
                    <form action="/eventos/join/{{ $evento->id }}" method="POST">
                        @csrf
                        <a href="/eventos/join/{{ $evento->id }}" class="btn btn-primary" id="event-submit"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            Confirmar Presença
                        </a>
                    </form>
                @else
                    <p class="already-joined-msg">Você já está participando deste evento!</p>
                @endif
                <h3>O evento conta com:</h3>
                <ul id="itemns-list">
                    @foreach ($evento->items as $item)
                        <li>
                            <ion-icon name="play-outline"></ion-icon> <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12" id="description-container">
                <h3>Sobre o Evento:</h3>
                <p class="event-description">
                    {{ $evento->description }}
                </p>
            </div>
        </div>
    </div>

@endsection
