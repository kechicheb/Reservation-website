<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Site de réservation</title>
    <link rel="stylesheet" href="{{ url('css/normalize.css') }}" />
    <link rel="stylesheet" href="{{ url('css/reservation.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('css/all.min.css') }}" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;700;900&family=Mochiy+Pop+P+One&family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/787e0eb937.js" crossorigin="anonymous"></script>

</head>

<body>
    <!-- Start Header -->
    <div class="header" id="header">
        <div class="container">
            <span class="span1"> <img src="{{ url('images/logouniv.jpg') }}" alt=""></span>
            <span class="span2"> <img src="{{ url('images/LogoNTIC.png') }}" alt=""></span>

        </div>
    </div>
    <!-- End Header -->
    <!-- Start Landing -->
    <div class="landing">
        <div class="container">
            <div class="text">
                <h1 class="h1">Bienvenue sur notre site de réservation</h1>
                <p class="p">réservez facilement une salle, un amphi, et du materiel sur le créneau et date
                    qui vous convient.
                </p>
                <a class="commencez" href="{{ route('enseignant.login') }}">Commencer</a>
            </div>
            <div class="image">
                <img src="{{ url('images/landing.svg') }}" alt="" />
            </div>
        </div>
    </div>
    <!-- End Landing -->
    <div class="footer">
        <div class="container">
            <footer>
                <div class="first">
                    <p> Copyright &copy Site de réservation </p>
                </div>

                <div class="secound">
                    <div>
                        <p>Ce site réalisé par <span>Ahmed kechicheb</span> et <span>Oussama krim</span></p>
                    </div>

                    <div>
                        <p> <span>Ahmed kechicheb</span> : ahmed.kechicheb@univ-constantine2.dz
                        </p>
                    </div>
                    <div>
                        <p><span>Oussama krim</span> : oussama.krim@univ-constantine2.dz
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="{{ url('js/walcome.js') }}"></script>
</body>

</html>
