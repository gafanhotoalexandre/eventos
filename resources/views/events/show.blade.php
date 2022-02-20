@extends('layouts.main')

@section('title', $event->title)

@section('content')

<div class="col-md-10 offset-md-1">
    <div class="row">

        <div id="image-container" class="col-md-6">
            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}"
                class="img-fluid">
        </div>

        <div id="info-container" class="col-md-6">
            <h1>{{ $event->title }}</h1>

            <p class="event-city">
                <ion-icon name="location-outline"></ion-icon> {{ $event->city }}
            </p>
            <p class="events-participants">
                <ion-icon name="people-outline"></ion-icon> {{ count($event->users) }} Participantes
            </p>
            <p class="event-owner">
                <ion-icon name="star-outline"></ion-icon> {{ $event->user->name }}
            </p>

            @if (! $hasUserJoined)
                <form action="{{ route('events.join-events', ['id' => $event->id]) }}" method="post">
                    @csrf
                    <a href="{{ route('events.join-events', ['id' => $event->id]) }}"
                        id="event-submit" class="btn btn-primary"
                        onclick="event.preventDefault();
                        this.closest('form').submit()">Confirmar Presença</a>
                </form>
            @else
                <p class="already-joined-msg">Você está participando deste evento!</p>
            @endif

            <h3>O evento conta com:</h3>
            <ul id="items-list">
                @foreach ($event->items as $item)
                    <li><ion-icon name="play-outline"></ion-icon><span>{{ $item }}</span></li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-12" id="description-container">
            <h3>Sobre o Evento:</h3>
            <p class="event-description">{{ $event->description }}</p>
        </div>

    </div>
</div>

@endsection