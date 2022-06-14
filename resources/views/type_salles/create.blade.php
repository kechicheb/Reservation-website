@extends('layouts.app')


@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12 ">

            <h3>Ajouter type salle</h3>






        </div>



    </div>
    <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.salles') }}">
        <i class="fa-solid fa-reply-all"></i> Retour</a>
    <div class="row " style="background-color: #fff;">
       
        <div class="col mt-3 mb-2">
                <form action="{{ route('admin.type_salle.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="exampleFormControlInput1">Type salle </label>
                        <input type="text" name="type_salle" class="form-control" placeholder="Type salle">
                        <span class="text-danger">
                            @error('type_salle')
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
@endsection
