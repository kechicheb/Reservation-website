<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>
  <link rel="stylesheet" href="{{url('css/normalize.css')}}" />
  <link rel="stylesheet" href="{{url('css/reservation.css')}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('css/all.min.css')}}" />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />

  <script src="https://kit.fontawesome.com/787e0eb937.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="row">
        {{-- <div class="col-md-4 offset-md-4" style="margin-top: 45px;"> --}}
            <div class="col">
              <h4>User Register</h4><hr>
              <form action="{{ route('admin.store') }}" method="post" autocomplete="off">




                @csrf

                  <div class="form-group">
                      <label for="nom_prenom">Nom et Prenom</label>
                      <input type="text" class="form-control" name="nom_prenom" placeholder="Enter full name" >
                      <span class="text-danger">@error('nom_prenom'){{ $message }} @enderror</span>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                </div>
                  <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Enter password" value="{{ old('password') }}">
                      <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                  </div>

                <div class="form-group">
            <label for="telephone">Phone</label>
            <input type="number" class="form-control" name="telephone" placeholder="phone" >
            <span class="text-danger">@error('telephone'){{ $message }} @enderror</span>





                  <div class="form-group">
                      <button type="submit" class="btn btn-success">Save</button>
                  </div>
                  <br>
                  {{-- <a href="{{ route('user.login') }}">I already have an account</a> --}}
              </form>
        </div>
    </div>
</div>
</body>

</html>
