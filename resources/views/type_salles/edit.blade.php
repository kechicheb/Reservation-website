@extends('layouts.app')


@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12 ">

            <h3>Modifier type salle</h3>






        </div>



    </div>
    <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.salles') }}">
        <i class="fa-solid fa-reply-all"></i> Retour</a>
    <div class="row " style="background-color: #fff;">

        <div class="col mt-3 mb-2">
                <form action="{{ route('admin.type_salle.update',$type_salle->id) }}" method="POST" enctype="multipart/form-data">
                    @if (Session::get('Typesuccess'))
                        <div class="alert alert-success">
                            {{ Session::get('Typesuccess') }}
                        </div>
                    @endif
                    @if (Session::get('Typefail'))
                        <div class="alert alert-danger">
                            {{ Session::get('Typefail') }}
                        </div>
                    @endif
                    @csrf
                    @method('PUT')


                    <div class="form-group">
                        <label for="exampleFormControlInput1">Type salle </label>
                        <input type="text" name="type_salle" class="form-control" placeholder="Type salle" value="{{$type_salle->type_salle}}">
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
