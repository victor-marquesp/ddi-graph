<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <a class="navbar-brand" href="{{ route('welcome') }}">
            DDIGraph
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            {{-- Navegação --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a
                        class="nav-link active"
                        aria-current="page"
                        href="{{ route('welcome') }}"
                    >
                        Home
                    </a>
                </li>

                @auth
                    <li class="nav-item"></li>   
                    <a
                        class="nav-link active"
                        aria-current="page"
                        href="{{ route('classifications.index') }}"
                    >
                        Classificações
                    </a> 
                    <li class="nav-item"></li>   
                    <a
                        class="nav-link active"
                        aria-current="page"
                        href="{{ route('drugs.index') }}"
                    >
                        Remédios
                    </a> 
                    <li class="nav-item"></li>   
                    <a
                        class="nav-link active"
                        aria-current="page"
                        href="{{ route('interactions.index') }}"
                    >
                        Interações
                    </a> 
                    <li class="nav-item"></li>   
                    <a
                        class="nav-link active"
                        aria-current="page"
                        href="{{ route('users.index') }}"
                    >
                        Users
                    </a> 
                @endauth
            </ul>

            {{-- Autenticação --}}
            <ul class="navbar-nav mb-2 mb-lg-0">
                @auth
                     <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-person-circle"></i>
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">
                                    Perfil
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST">
                                    @csrf

                                    <button type="submit" class="dropdown-item">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a href="{{ route('auth.login.form') }}" class="btn btn-outline">
                            Login (ADM)
                        </a>
                    </li>
                @endguest                

            </ul>

        </div>
    </div>
</nav>