@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="h6">Formation</p>
                <p class="h1">Créer une formation</p>
                <div class="card mt-5">
                    <div class="card-body">
                        <form action="{{ route('store_lesson') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input value="{{ old('name') }}" type="text" class="@error('name') is-invalid @enderror form-control" id="name" name="name" aria-describedby="Nom de formation" placeholder="Entrez le nom de la formation">
                                @error('name')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="professor_id">Professeur Responsable</label>
                                <select class="@error('professor_id') is-invalid @enderror form-control" id="professor_id" name="professor_id">
                                    @foreach($professors as $professor)
                                        <option value="{{ $professor->id }}">{{ $professor->last_name.' '.$professor->first_name }}</option>
                                    @endforeach
                                </select>
                                @error('professor_id')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
