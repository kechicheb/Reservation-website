@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 ">

                <h3>Ajouter salle</h3>






            </div>



        </div>

        <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.salles') }}">
            <i class="fa-solid fa-reply-all"></i> Retour</a>
        <div class="row " style="background-color: #fff;">
            {{-- <div class="col-12 mt-3 mb-2">

                <h4> Ajouter salle </h4>
                <hr>
            </div> --}}
            <div class="col mt-3 mb-2">
                <form action="{{ route('admin.salle.store') }}" method="POST" enctype="multipart/form-data">
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
                        <select id="type_salle" name="type_salle" class="form-control">
                            @foreach ($type_salles as $item)
                                <option value="{{ $item->type_salle }}">
                                    {{ $item->type_salle }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('type_salle')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Code Salle </label>
                        <input type="text" name="code_salle" class="form-control" placeholder="Code salle">
                        <span class="text-danger">
                            @error('code_salle')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>




                    <div class="form-group">
                        <label for="exampleFormControlInput1">Capacité </label>
                        <input type="text" name="capacite" class="form-control" placeholder="Capacité">
                        <span class="text-danger">
                            @error('capacite')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Etage </label>
                        <input type="text" name="etage" class="form-control" placeholder="Etage">
                        <span class="text-danger">
                            @error('etage')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group form-check">


                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="special" style="width: 18px; height:16px;">
                        <label class="form-check-label" for="exampleCheck1">Spécial</label>
                        <span class="text-danger">
                            @error('special')
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
