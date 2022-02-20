@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    
<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus Eventos</h1>
    <p class="lead">{{ $user->name }}</p>
</div>

<section class="col-md-10 offset-md-1 dashboard-events-container">
    @if (count($events) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Participantes</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                <a href="{{ route('events.show', ['id' => $event->id]) }}">{{ $event->title }}</a>
                            </td>
                            <td>{{ count($event->users) }}</td>
                            <td>
                                <a href="{{ route('events.edit', ['id' => $event->id]) }}"
                                    class="btn btn-info edit-btn"><ion-icon name="create-outline"></ion-icon> Editar</a>
                                    
                                <form action="{{ route('events.destroy', ['id' => $event->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Deseja deletar o evento?')"
                                        class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon> Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Você ainda não tem eventos, <a href="{{ route('events.create') }}">criar eventos</a>.</p>
    @endif
</section>

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Eventos que estou participando</h1>
</div>
<section class="col-md-10 offset-md-1 dashboard-events-container">
    @if (count($eventsAsParticipant) > 0)
    
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Participantes</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($eventsAsParticipant as $event)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                <a href="{{ route('events.show', ['id' => $event->id]) }}">{{ $event->title }}</a>
                            </td>
                            <td>{{ count($event->users) }}</td>
                            <td>
                                <form method="post" action="{{ route('events.leave-events', ['id' => $event->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><ion-icon name="close-outline"></ion-icon>Sair do Evento</button>
                                    {{-- <a href="{{ route('events.leave-events', ['id' => $event->id]) }}"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit()">Sair do Evento</a> --}}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <p>Você ainda não está participando de nenhum evento, <a href="{{ route('events.index') }}">veja todos os eventos</a>.</p>
    @endif
</section>


@endsection