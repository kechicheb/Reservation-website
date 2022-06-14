@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 ">

                <h3>Ajouter créneau</h3>






            </div>



        </div>
        <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.creneaus') }}">
            <i class="fa-solid fa-reply-all"></i> Retour</a>

        <div class="row " style="background-color: #fff;">

            <div class="col mt-3 mb-2">
                <form action="{{ route('admin.creneau.store') }}" method="POST" enctype="multipart/form-data">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    @csrf

                    <div class="form-group">
                        <label for="exampleFormControlInput1"> Début de créneau </label>
                        <input type="time" name="start" class="form-control">
                        <span class="text-danger">
                            @error('start')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Fin de créneau </label>
                        <input type="time" name="end" class="form-control">
                        <span class="text-danger">
                            @error('end')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">

                        <button class="btn btn-success" type="submit">sauvegarder</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    </div>
@endsection
