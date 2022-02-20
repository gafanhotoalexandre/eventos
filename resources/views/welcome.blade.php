@extends('layouts.main')

@section('title', '64Bit Events')

@section('content')

<div id="search-container" class="col-md-12">

    <h1>Busque um evento</h1>

    <form action="{{ route('events.index') }}" method="GET">
        <input type="text" name="search" id="search" class="form-control"
            placeholder="procurar...">
    </form>

</div>    

<div id="events-container" class="col-md-12">
    @if ($search)
        <h2>Buscando por: {{ $search }}</h2>
    @else
        <h2>Próximos eventos</h2>
        <p class="subtitle">Veja os eventos dos próximos dias</p>
    @endif
    
    <div id="cards-container" class="row">
        @foreach ($events as $event)

            <div class="card col-md-3">
                <img src="{{ asset($event->image) }}"  alt="{{ $event->title }}">
                <div class="card-body">
                    <p class="card-date">{{ date('d/m/Y', strtotime($event->date)) }}</p>
                    
                    <h5 class="card-title">{{ $event->title }}</h5>

                    <p class="card-participants">{{ count($event->users) }} participantes</p>

                    <a href="{{ route('events.show', ['id' => $event->id]) }}" class="btn btn-primary">Saiba mais</a>
                </div>
            </div>
        @endforeach

        @if (count($events) == 0 && $search)
            <p class="mx-3">
                Não foi possível encontrar nenhum evento com {{ $search }}!
                <a href="{{ route('events.index') }}">Ver todos.</a>
            </p>
        @elseif (count($events) == 0)
            <p class="mx-3">Não há eventos disponíveis.</p>
        @endif
    </div>
</div>

@endsection