<header class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbar">
                    <a href="{{ route('events.index') }}" class="navbar-brand">
                        <img src="{{ asset('img/hdcevents_logo.svg') }}" alt="Somos uma comunidade">
                    </a>
        
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('events.index') }}" class="nav-link">Eventos</a>
                        </li>
        
        
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('events.create') }}" class="nav-link">Criar Eventos</a>
                            </li>
        
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">Meus Eventos</a>
                            </li>
        
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                            class="nav-link">Sair</a>
                                </form>
                            </li>
                        @endauth
        
                        @guest                    
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Entrar</a>
                            </li>
        
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Cadastrar</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        
        </div>
    </div>
</header>