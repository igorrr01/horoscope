@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Вибрать знак зодиака</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($zodiacs as $zodiac)
                    <div>{{ $zodiac->zodiac_translate }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
