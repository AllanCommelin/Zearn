@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center text-uppercase">Sessions à venir</h2>
                <hr>
                @foreach ($student_sessions as $student_session)
                    @if(!$student_session->session->completed)
                    @php setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); @endphp
                    <div class="card d-inline-block m-2 w1-3 position-relative">
                        <div class="text-right px-4 py-2">
                            Salle : {{ $student_session->session->nb_classroom }}
                        </div>
                        <div class="card-body text-center">
                            <h4 class="h5 card-title font-weight-bolder pt-2">
                                {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%A %d %B %Y')  }}
                            </h4>
                            <h5 class="h5 card-subtitle font-weight-bold mb-2 text-muted">
                                {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%H:%M') }}
                                -
                                {{ \Carbon\Carbon::parse($student_session->session->end_datetime)->formatLocalized('%H:%M') }}
                            </h5>
                            <div class="d-flex align-items-end justify-content-between pt-2">
                                <p class="mb-0 text-left">
                                    <span class="card-link font-weight-bolder text-uppercase">{{ $student_session->session->lesson->name }}</span><br>
                                    <span class="card-link">{{ $student_session->session->lesson->professor->first_name }} {{ $student_session->session->lesson->professor->last_name }}</span>
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
                    @if($student_session->session->completed)
                        @php setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); @endphp
                        <div class="card d-inline-block m-2 w1-3">
                            <div class="card-body text-center">
                                <div class="text-right py-2">
                                    Note : {{ $student_session->student_mark ?? 'À venir' }}
                                </div>
                                <h4 class="h5 card-title font-weight-bolder pt-4">
                                    {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%A %d %B %Y')  }}
                                </h4>
                                <h5 class="h5 card-subtitle font-weight-bold mb-2 text-muted">
                                    {{ \Carbon\Carbon::parse($student_session->session->start_datetime)->formatLocalized('%H:%M') }}
                                    -
                                    {{ \Carbon\Carbon::parse($student_session->session->end_datetime)->formatLocalized('%H:%M') }}
                                </h5>
                                <div class="d-flex align-items-end justify-content-between pt-2">
                                    <p class="mb-0 text-left">
                                        <span class="card-link font-weight-bolder text-uppercase">{{ $student_session->session->lesson->name }}</span><br>
                                        <span class="card-link">{{ $student_session->session->lesson->professor->first_name }} {{ $student_session->session->lesson->professor->last_name }}</span>
                                    </p>
                                    <span data-toggle="modal" data-target="#reportModal{{$student_session->id}}" class="cursor-pointer">Compte rendu <i class="fas fa-long-arrow-alt-right"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="reportModal{{$student_session->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Compte rendu</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            {{ $student_session->session->report }}
                                        </p>
                                        <i class="text-right">{{ $student_session->session->lesson->professor->first_name }} {{ $student_session->session->lesson->professor->last_name }}</i>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
