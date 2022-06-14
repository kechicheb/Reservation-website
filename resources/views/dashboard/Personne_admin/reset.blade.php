<!DOCTYPE html>
<html>

<head>
    <title>Reservation WebSite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">

    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <style>
        body {
            display: flex;
            align-items: center;
        }

        * {
            font-family: "Open Sans", sans-serif;
        }

    </style>

    <head>

    <body>


        <div class="container">
            <div class="   row justify-content-center align-items-center">
                <div>
                    <img style="width: 100px; height:100px;  border-radius:50px"
                        src="{{ url('images/LogoNTIC.png') }}" alt="">

                </div>

            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-md-4 col-12  col-sm-6">
                    <h4 style="text-align: center;">Réinitialiser le mot de passe </h4>
                    <hr>
                    <form action="{{ route('Personne_admin.reset.password') }}" method="post" autocomplete="off">
                        @if (Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}
                            </div>
                        @endif
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="email"><strong>Email </strong></label>
                            <input type="text" class="form-control" name="email" placeholder="Entrer l'adresse e-mail"
                                value="{{ $email ?? old('email') }}">
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="password"><strong>Mot de passe</strong></label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Entrer le mot de passe" value="{{ old('password') }}">
                            <span class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="password"> <strong>Confirmer le mot de passe</strong></label>
                            <input type="password" class="form-control" name="cpassword"
                                placeholder="Entrer confirmer le mot de passe" value="{{ old('cpassword') }}">
                            <span class="text-danger">
                                @error('cpassword')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-success w-100">Réinitialiser</button>
                        </div>
                        <br>
                        <p class="text-dark"> Voulez-vous vous connecter ?
                            <a class="text-success" href="{{ route('Personne_admin.login') }}">Commencez ici !</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
        <script src="{{ url('js/login.js') }}"></script>

    </body>

</html>
