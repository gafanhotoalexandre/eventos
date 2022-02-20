@extends('layouts.main')

@section('title', 'Criar Evento')

@section('content')

<section class="container-fluid">
    <div class="row">
        
        <div id="event-create-container" class="col-md-6 offset-md-3">
            <h1>Crie o seu evento</h1>
            
            <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="image">Imagem do Evento:</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>

                <div class="form-group">
                    <label for="title">Evento:</label>
                    <input type="text" name="title" id="title" class="form-control"
                        placeholder="Nome do evento">
                </div>

                <div class="form-group">
                    <label for="date">Data:</label>
                    <input type="date" name="date" id="date" class="form-control">
                </div>

                <div class="form-group">
                    <label for="city">Cidade:</label>
                    <input type="text" name="city" id="city" class="form-control"
                        placeholder="Local do evento">
                </div>

                <div class="form-group">
                    <label for="title">O evento é privado?</label>
                    <select name="private" id="private" class="form-control">
                        <option value="0">NÃO</option>
                        <option value="1">SIM</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" class="form-control"
                        placeholder="O que vai acontecer no evento?"></textarea>
                </div>

                <div class="form-group">
                    <label for="title">Adicione itens de infraestrutura:</label>
                
                    <div class="form-check">
                        <input type="checkbox" name="items[]" class="form-check-input"
                            value="Cadeiras" id="chairs">
                        <label for="chairs">Cadeiras</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="items[]" class="form-check-input"
                            value="Palco" id="stage">
                        <label for="stage">Palco</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="items[]" class="form-check-input"
                            value="Cerveja Grátis" id="free_beer">
                        <label for="free_beer">Cerveja Grátis</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="items[]" class="form-check-input"
                            value="Open food" id="open_food">
                        <label for="open_food">Open food</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="items[]" class="form-check-input"
                            value="Brindes" id="gifts">
                        <label for="gifts">Brindes</label>
                    </div>
                </div>

                <input type="submit" value="Criar Evento" class="btn btn-primary">
            </form>
        </div>
        
    </div>
</section>

@endsection