@extends('layouts.app')

@section('content')
    <div class="z-home-page container-fluid">
        <div class="row justify-content-center">
            <div class="z-container col-md-12" style="background-image: url('{{ asset('img/study_bg.jpg') }}')">
                <h2>Étudiez en toute zenitude avec</h2>
                <h1>Zearn</h1>
                <div class="buttons">
                    @guest
                        <a class="z-btn-login btn" href="{{ route('login') }}">Connexion</a>
                        <a class="z-btn-register btn btn-outline" href="{{ route('register') }}">Inscription</a>
                    @else
                        @if(Auth::user()->role === 'student')
                            <a class="z-btn-student btn" href="{{ route('homeStudent') }}">Voir les formations</a>
                        @elseif(Auth::user()->role === 'professor')
                            <a class="z-btn-professor btn" href="{{ route('professor.index') }}">Accéder à mes formations</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
