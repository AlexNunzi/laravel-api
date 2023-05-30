@extends('layouts.admin')

@section('content')
    <div class="text-center">
        <ul class="list-unstyled">
            <li>
                <h3>Nome della tipologia:</h3>
                <p>
                    {{ $type->name }}
                </p>
            </li>
        </ul>
    </div>
@endsection
