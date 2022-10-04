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
    <script type="text/javascript" src="{{ asset('/js/app.js') }} "></script>
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
    @yield('css')
    <link rel="stylesheet" href="{{ asset('../daterangepicker/daterangepicker.css') }}">
<body>
    <style type="text/css">
        .vertical-nav-menu li a.active {
    background: #3490dc;
    text-decoration: none;
    color: white;
}
#formulario label[tipo="error"]{
   /* margin-left: 45px;
    width: 90%;
    margin-bottom: 0px;*/
    display: none;
    font-size: 12px;
    color: #fe0000;
}
    </style>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    <div class="app-header header-shadow">
        <div class="app-header__logo">
            <div >
            {{ config('app.name', 'Suscripción') }}
            </div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
        </div>
        <div class="app-header__content">
            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                        <img width="42" class="rounded-circle" src="{{ asset('assets/images/avatars/1.png')}}" alt="">

                                    </a>
                                </div>
                            </div>
                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="widget-subheading">

                                </div>
                            </div>
                            <div class="widget-content-right header-user-info ml-3">


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>

                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   title="Salir" type="button" class="btn-shadow p-1 btn btn-primary">
                                    <i class="fa text-white fa-chevron-circle-right pr-1 pl-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>        </div>
        </div>
    </div>

    <div class="app-main">
        <div class="app-sidebar sidebar-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
            </div>
            <div class="scrollbar-sidebar ps ps--active-y">
                <div class="app-sidebar__inner">
                    <ul class="vertical-nav-menu metismenu">

                        <li class="app-sidebar__heading">MENÚ</li>
                        <li >
                            <a href="{{ route('home')}}" class="{{ Route::is('home') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-users"></i>
                                Personas
                            </a>
                        </li>
                        <li >
                            <a href="{{route('transaction')}}" class="{{ Route::is('transaction') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-display2"></i>
                                Transacciones
                            </a>
                        </li>
                        <li >
                            <a href="{{route('subscriptions')}}" class="{{ Route::is('subscriptions') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-ticket"></i>
                                Tipos de suscripción
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('usuarios') }}" class="{{ Route::is('usuarios') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-lock"></i>
                                Usuarios
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('settings') }}" class="{{ Route::is('settings') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-tools"></i>
                                Configuración
                            </a>
                        </li>



                        <li>
                            <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="metismenu-icon pe-7s-back-2"></i>
                                Cerrar Sesión
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 565px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 472px;"></div></div></div>
        </div>
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        @yield('title')
                    </div>
                    <div id="div_mensajes" class="d-none">
                        <p id="mensajes"></p>
                    </div>
                </div>

                    @yield('content')

            </div>
            <div class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-left">

                        </div>
                        <div class="app-footer-right">
                          Desarrollado por Erick Gordillo - ©Copyright 2020
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@yield('modal')
</body>
