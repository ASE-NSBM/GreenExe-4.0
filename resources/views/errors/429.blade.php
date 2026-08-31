@extends('layouts.app')

@section('title', 'Too many requests — '.config('greenexe.event.name'))

@section('content')
    @include('partials.error-page', [
        'code' => '429',
        'eyebrow' => 'Error 429',
        'titleItalic' => 'That was',
        'title' => 'a bit too fast',
        'lead' => 'Too many requests arrived from this connection in a short time. Wait a moment, then try again.',
        'actions' => [['label' => 'Back to home', 'url' => route('home'), 'primary' => true]],
    ])
@endsection
