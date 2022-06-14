@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 ">

                <h3>Modifier matériel</h3>






            </div>



        </div>
        <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.materiels') }}">
            <i class="fa-solid fa-reply-all"></i> Retour</a>



        <div class="row " style="background-color: #fff;">
           
            <div class="col mt-3 mb-2">
                <form action="{{ route('admin.materiel.update', $materiel->id) }}" method="POST"
                    enctype="multipart/form-data">
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
                    @method('PUT')

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Numéro série </label>
                        <input type="text" value="{{ $materiel->n_serie }}" name="n_serie" class="form-control"
                            placeholder="Numéro série">
                        <span class="text-danger">
                            @error('n_serie')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nom </label>
                        <input type="text" value="{{ $materiel->nom }}" name="nom" class="form-control"
                            placeholder="Nom">
                        <span class="text-danger">
                            @error('nom')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Marque </label>
                        <input type="text" name="marque" value="{{ $materiel->marque }}" class="form-control"
                            placeholder="Marque">
                        <span class="text-danger">
                            @error('marque')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"> Description </label>
                        <textarea placeholder="Description" class="form-control" name="desecription"
                            rows="3">{{ $materiel->desecription }}</textarea>
                        <span class="text-danger">
                            @error('desecription')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class="form-group">

                        <button class="btn btn-success" type="submit">Suavegarder</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
