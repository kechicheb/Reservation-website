<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Site de réservation</title>

    <!-- Scripts -->


    <!--Font google open sans-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;700;900&family=Mochiy+Pop+P+One&family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />


    <!-- Style bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>


    <!-- Style css -->

    <link rel="stylesheet" href="{{ url('css/enseignant.css') }}" />

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/787e0eb937.js" crossorigin="anonymous"></script>


</head>

<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  fixed-top bg-light shadow-sm text-dark ">

            {{-- <div class="container-fluid"> --}}
            <div class="container">
                <span class="navbar-brand " >
                    <img style="height: 50px; width:50px; border-radius:25px;" src="{{ url('images/LogoNTIC.png') }}"
                        alt="">
                </span>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto ">

                        <li
                            class="nav-item {{ Route::currentRouteName() == 'enseignant.consultationReservation' ? 'active-link' : '' }} ">
                            <a class="nav-link" href="{{ route('enseignant.consultationReservation') }}">
                                <i class="fa-regular fa-calendar-days"></i>
                                Consultaion
                            </a>
                        </li>
                        <li
                            class="nav-item  {{ Route::currentRouteName() == 'enseignant.reservations' ? 'active-link' : '' }}">
                            <a class="nav-link " href="{{ route('enseignant.reservations') }}">
                                <i class="fa-solid fa-eye  "></i>
                                Mes réservations
                            </a>
                        </li>


                        <li
                            class="nav-item dropdown {{ Route::currentRouteName() == 'enseignant.reservation.create' ? 'active-link' : '' }}  {{ Route::currentRouteName() == 'enseignant.reservationM.create' ? 'active-link' : '' }} ">
                            <a id="navbarDropdown" class="nav-link  dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa-solid fa-calendar-plus text-dark "></i>
                                Réserver
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item " href="{{ route('enseignant.reservation.create') }}">
                                    Salle
                                </a>
                                </a>

                                <a class="dropdown-item " href="{{ route('enseignant.reservationM.create') }}">
                                    Matériel
                                </a>

                            </div>
                        </li>






                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li
                            class="nav-item {{ Route::currentRouteName() == 'enseignant.enseignant.passedit' ? 'active-link' : '' }}">
                            <a class="nav-link "
                                href="{{ route('enseignant.enseignant.passedit', Auth::user()->matricule) }}">
                                <i class="fa-solid fa-user "></i>

                                Profil
                            </a>

                        </li>
                        <!-- Authentication Links -->
                        @guest
                        @else
                            <li style=" cursor:pointer;"
                                class="nav-item {{ Route::currentRouteName() == 'logout' ? 'active-link' : '' }} "><a
                                    href="{{ route('logout') }}" class="nav-link  "
                                    onclick="event.preventDefault();     document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-arrow-right-from-bracket "></i>
                                    Déconnecter

                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 ">
            @yield('content')
        </main>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
        <script src="{{ url('js/profil.js') }}"></script>




    </div>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
        integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

</body>

</html>
