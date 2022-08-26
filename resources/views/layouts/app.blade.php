<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('header')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/app.scss'])
</head>
<body>
<div class="wrapper">
    <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            @auth
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                           aria-label="Open user menu">
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ Auth::user()->name }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                               class="dropdown-item">Выход</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                        <ul class="navbar-nav">


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('telegram.users') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg"
                                       class="icon icon-tabler icon-tabler-wave-saw-tool" width="24" height="24"
                                       viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                       stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <path d="M3 12h5l4 8v-16l4 8h5"></path>
                                  </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Пользователя
                                    </span>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('telegram.roles') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-exchange"
                                       width="24" height="24" viewBox="0 0 24 24" stroke-width="1.75"
                                       stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <circle cx="5" cy="18" r="2"></circle>
                                      <circle cx="19" cy="6" r="2"></circle>
                                      <path d="M19 8v5a5 5 0 0 1 -5 5h-3l3 -3m0 6l-3 -3"></path>
                                      <path d="M5 16v-5a5 5 0 0 1 5 -5h3l-3 -3m0 6l3 -3"></path>
                                  </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Заявки на смену роли
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('videos.all') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg"
                                       class="icon icon-tabler icon-tabler-brand-zoom" width="24" height="24"
                                       viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                       stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <path d="M17.011 9.385v5.128l3.989 3.487v-12z"></path>
                                      <path
                                          d="M3.887 6h10.08c1.468 0 3.033 1.203 3.033 2.803v8.196a0.991 .991 0 0 1 -.975 1.001h-10.373c-1.667 0 -2.652 -1.5 -2.652 -3l.01 -8.002a0.882 .882 0 0 1 .208 -.71a0.841 .841 0 0 1 .67 -.287z"></path>
                                  </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Видео
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('main.stats') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-watch-stats" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <rect x="6" y="6" width="12" height="12" rx="3"></rect>
                                      <path d="M9 18v3h6v-3"></path>
                                      <path d="M9 6v-3h6v3"></path>
                                      <path d="M9 14v-4"></path>
                                      <path d="M12 14v-1"></path>
                                      <path d="M15 14v-3"></path>
                                  </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Статистика
                                    </span>
                                </a>
                            </li>





                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-third" data-bs-toggle="dropdown"
                                   data-bs-auto-close="outside" role="button" aria-expanded="false">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                       width="24" height="24"
                                       viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                       stroke-linecap="round"
                                       stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <circle cx="9" cy="7" r="4"></circle>
                                      <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                      <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                  </svg>
                              </span>
                                    <span class="nav-link-title">
                                Настройки
                              </span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="{{ route('admin.users') }}">
                                        Список пользователей
                                    </a>
{{--                                    <a class="dropdown-item"--}}
{{--                                       href="{{ route('admin.created') }}">--}}
{{--                                        Создание пользователя--}}
{{--                                    </a>--}}
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </header>
    <div class="page-wrapper">
        <div class="position-absolute p-3 top-0 end-0" style="z-index: 11">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true"
                 data-bs-toggle="toast" data-bs-delay="3000">
                <div class="toast-header">
                    <strong class="me-auto">%title%</strong>
                    <button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    %messages%
                </div>
            </div>
        </div>
        <div class="container-xl">
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            @yield('header')
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                @yield('content')
            </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-lg-auto ms-lg-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item"><a href="#" class="link-secondary"></a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Zbara Dev &copy; 2022
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@vite(['resources/app.js'])
</body>
</html>
