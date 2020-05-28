@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="text-center text-uppercase">Formations</h1>
            <hr>
            @foreach ($lessons as $lesson)
                <div class="card d-inline-block m-2 w1-3">
                    <div class="card-body">
                        <h5 class="card-title pt-4">{{ $lesson->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $lesson->professor->first_name }} {{ $lesson->professor->last_name }}
                        </h6>
                        <div class="d-flex justify-content-between pt-2">
                            <span class="card-link">Nombre de session : <b>{{ count($lesson->sessions) }}</b></span>
                            <a href="{{route('lessonSessions', $lesson->id)}}" class="card-link">Voir plus <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $lessons->links() }}
        </div>
    </div>
</div>
@endsection
