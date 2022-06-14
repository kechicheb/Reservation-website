@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="jumbotron">
                    <h1 class="display-4">Modifier Salle</h1>
                    <a class="btn btn-success" href="{{ route('admin.salles') }}"> Tout les salles</a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('admin.salle.update', $salle->id) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="exampleFormControlInput1">Code Salle </label>
                        <input type="text" name="code_salle" value="{{ $salle->code_salle }}" class="form-control">
                        <span class="text-danger">
                            @error('code_salle')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <select id="type_salle" name="type_salle" class="form-control">
                            @foreach ($type_salles as $item)
                                <option value="{{ $item->type_salle }}">{{ $item->type_salle }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('type_salle')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Capacité </label>
                        <input type="text" value="{{ $salle->capacite }}" name="capacite" class="form-control">
                        <span class="text-danger">
                            @error('capacite')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Etage </label>
                        <input type="text" value="{{ $salle->etage }}" name="etage" class="form-control">
                        <span class="text-danger">
                            @error('etage')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="special"
                            {{ $salle->special == 'spécial' ? 'checked' : '' }}>
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
