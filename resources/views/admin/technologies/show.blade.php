@extends('layouts.admin')

@section('content')
    <div class="text-center">
        <ul class="list-unstyled">
            <li>
                <h3>Nome della tecnologia:</h3>
                <p>
                    {{ $technology->name }}
                </p>
            </li>
        </ul>
    </div>
@endsection
