@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center text-uppercase">Sessions à venir</h2>
                <hr>
                @foreach ($student_sessions as $student_session)
                    @if($student_session->session->start_datetime > \Carbon\Carbon::now())
                    @php setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); @endphp
                    <div class="card d-inline-block m-2 w1-3">
                        <div class="card-body">
                            <h4 class="h5 card-title font-weight-bolder pt-4">
                                {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%A %d %B %Y')  }}
                            </h4>
                            <h5 class="h5 card-subtitle font-weight-bold mb-2 text-muted">
                                {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%H:%M') }}
                                -
                                {{ \Carbon\Carbon::parse($student_session->session->end_datetime)->formatLocalized('%H:%M') }}
                            </h5>
                            <div class="d-flex align-items-end justify-content-between pt-2">
                                <p class="mb-0">
                                    <span class="card-link">{{ $student_session->session->lesson->professor->first_name }}</span><br>
                                    <span class="card-link">{{ $student_session->session->lesson->professor->last_name }}</span>
                                </p>
                                <form action="{{ route('sessionUnsubscribe', $student_session->session_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning">Se désinscrire</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            <div class="col-12">
                <h2 class="text-center text-uppercase">Sessions terminées</h2>
                <hr>
                @foreach ($student_sessions as $student_session)
                    @if($student_session->session->start_datetime <= \Carbon\Carbon::now())
                        @php setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); @endphp
                        <div class="card d-inline-block m-2 w1-3">
                            <div class="card-body">
                                <h4 class="h5 card-title font-weight-bolder pt-4">
                                    {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%A %d %B %Y')  }}
                                </h4>
                                <h5 class="h5 card-subtitle font-weight-bold mb-2 text-muted">
                                    {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%H:%M') }}
                                    -
                                    {{ \Carbon\Carbon::parse($student_session->session->end_datetime)->formatLocalized('%H:%M') }}
                                </h5>
                                <div class="d-flex align-items-end justify-content-between pt-2">
                                    <p class="mb-0">
                                        <span class="card-link">Salle : {{ $student_session->session->nb_classroom }}</span><br>
                                        <span class="card-link">Place : {{ count($student_session->session->students) }}/20</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
