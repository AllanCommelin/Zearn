@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center text-uppercase">Formation</h2>
                <h1 class="text-center text-uppercase">{{ $lesson->name }}</h1>
                <hr>
               @foreach ($sessions as $session)
                    @php setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); @endphp
                    <div class="card d-inline-block m-2 w1-3">
                        <div class="card-body">
                            <h4 class="h5 card-title font-weight-bolder pt-4">
                                {{ \Carbon\Carbon::parse($session->start_datetime)->formatLocalized('%A %d %B %Y')  }}
                            </h4>
                            <h5 class="h5 card-subtitle font-weight-bold mb-2 text-muted">
                                {{ \Carbon\Carbon::parse($session->start_datetime)->formatLocalized('%H:%M') }}
                                -
                                {{ \Carbon\Carbon::parse($session->end_datetime)->formatLocalized('%H:%M') }}
                            </h5>
                            <div class="d-flex align-items-end justify-content-between pt-2">
                                <p class="mb-0">
                                    <span class="card-link">Salle : {{ $session->nb_classroom }}</span><br>
                                    <span class="card-link">Place : {{ count($session->students) }}/20</span>
                                </p>
                                @if (in_array($session->id, $sessions_sub))
                                    <form action="{{ route('sessionUnsubscribe', $session->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning">Se désinscrire</button>
                                    </form>

                                @else
                                    <form action="{{ route('sessionSubscribe') }}" method="POST">
                                        @csrf
                                        <input type="text" name="session_id" hidden value="{{ $session->id }}">
                                        <button type="submit" class="btn btn-success">S'inscrire</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
