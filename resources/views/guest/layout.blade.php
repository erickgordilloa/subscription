<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Erick Gordillo Ayala">
    <title>{{ config('app.name', 'Cafe') }}</title>
    <meta name="keyword" content="Software, Suscripcion, Botón de pago">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <script type="text/javascript" src="{{ asset('../assets/scripts/main.js') }} "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="../../vendor/toastr/toastr.min.js"></script>
    <script src="{{ asset('../daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('../daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('../js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('../js/jquery.inputmask.js')  }}"></script>
    @yield('js')

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('../main.css') }}" rel="stylesheet"></head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="../../vendor/toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('../css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('../font-awesome/css/font-awesome.min.css') }}">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('../daterangepicker/daterangepicker.css') }}">
    <style type="text/css">
        .vertical-nav-menu li a.active {
            background: #3490dc;
            text-decoration: none;
            color: white;
        }
        #formulario label[tipo="error"]{
            display: none;
            font-size: 12px;
            color: #fe0000;
        }
    </style>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="custom-logo" idth="30" height="30" class="d-inline-block align-top" src="https://paqucafe.com/wp-content/uploads/2021/07/paqu-logo.png"/>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto"  style="margin-top: 14px;">
                @guest
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif --}}
                    @else
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('suscriptor.suscripciones') ? 'active' : '' }}" href="{{ route('suscriptor.suscripciones') }}">{{ __('Suscripciones') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('suscriptor.pedidos') ? 'active' : '' }}" href="{{ route('suscriptor.pedidos') }}">{{ __('Pedidos') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('card.index') ? 'active' : '' }}" href="{{ route('card.index') }}">{{ __('Tarjetas') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('suscriptor.pedidos') ? 'active' : '' }}" href="{{ route('card.index') }}">{{ __('Pagos') }}</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} 
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Perfil</a>
                          <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">Cerrar sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>

                    
                    @endguest

               
              </ul>
              <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
              </form>
            </div>
          </nav>
       
        


        <main role="main" class="py-4">
                @yield('content')
        </main>

        <footer class="principal">
            <div class="container">
                <div class="row p-4">
                    <div class="col-xs-6 text-center">
                        <p class="text">Todos los derechos reservados | Desarrollado por P’AQU 2022 | <a class="text" href="{{ route('terminos') }}" target="_blank">Términos & condiciones</a></p>
                    </div>
                    <div class="col-xs-6 text-center">
                        <ul class="nav-principal">
                        <li><a class="text" href="https://www.facebook.com/iglesia.samborondon/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                        <li><a class="text" href="https://www.instagram.com/alianzasamborondon_ias/"  target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a class="text" href="https://twitter.com/AlianzaSamboron"  target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a class="text" href="https://www.youtube.com/user/AlianzaSamborondon1"  target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</body>

    
    