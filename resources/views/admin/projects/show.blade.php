@extends('layouts.admin')

@section('content')
    <div class="text-center">
        <ul class="list-unstyled">
            <li>
                <h3>Titolo del progetto:</h3>
                <p>
                    {{ $project->title }}
                </p>
            </li>
            <li>
                <h3>Anteprima:</h3>
                @if ($project->preview_img)
                    <img class="ms-show-img" src="{{ asset('storage/' . $project->preview_img) }}"
                        alt="Anteprima progetto non disponibile">
                @else
                    <img class="ms-show-img border border-black"
                        src="{{ asset('img/h9pqRmsIwC1KOxfYbxgyvAFotT7SuEuNHayFtPir.png') }}"
                        alt="Anteprima progetto non disponibile">
                @endif

            </li>
            <li>
                <h3>Tipologia del progetto:</h3>
                <p>
                    {{ $project->type ? $project->type->name : 'Nessuna tipologia associata' }}
                </p>
            </li>
            <li>
                <h3>Tecnologie associate:</h3>
                <ul class="list-unstyled">
                    @forelse ($project->technologies as $technology)
                        <li>
                            {{ $technology->name }}
                        </li>
                    @empty
                        <li>
                            Nessuna tecnologia associata
                        </li>
                    @endforelse
                </ul>
            </li>
            <li>
                <h4>Data di inizio progetto:</h4>
                <p>
                    {{ $project->start_date }}
                </p>
            </li>
            <li>
                <h4>Data di fine progetto:</h4>
                <p>
                    {{ $project->end_date }}
                </p>
            </li>
            <li>
                <h4>Descrizione:</h4>
                <p>
                    {{ $project->description }}
                </p>
            </li>
        </ul>
    </div>
@endsection
