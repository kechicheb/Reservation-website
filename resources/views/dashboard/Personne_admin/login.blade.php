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

    </style>

    <head>

    <body>
        <div class="container">

            <div class=" row justify-content-center align-items-center ">
                <div>
                    <img style="width: 100px; height:100px;  border-radius:50px"
                        src="{{ url('images/LogoNTIC.png') }}" alt="">

                </div>

            </div>
            <div class="row justify-content-center align-items-center mt-4">

                <div class="col-md-4 col-12  col-sm-6 ">
                    <h4 style="text-align: center;"> Personne administrateur </h4>
                    <hr>
                    <form action="{{ route('Personne_admin.check') }}" method="post">
                        @if (Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}
                            </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="email"><strong>Email</strong></label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="Entrer l'adresse e-mail" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="password"><strong>Mot de passe</strong></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Entrer le mot de passe" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <a href="{{ route('Personne_admin.forgot.password.form') }}" class="text-dark">
                            mot de passe oublié ?</a>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-success w-100">Connexion</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
        <script src="{{ url('js/login.js') }}"></script>
    </body>

</html>
