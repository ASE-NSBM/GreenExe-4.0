@extends('layouts.app')

@section('title', 'Page not found — '.config('greenexe.event.name'))

@section('content')
    @include('partials.error-page', [
        'code' => '404',
        'eyebrow' => 'Error 404',
        'titleItalic' => 'This page',
        'title' => 'took a wrong turn',
        'lead' => 'The page you asked for is not here. It may have moved, or the link that brought you here may be out of date.',
        'actions' => [['label' => 'Back to home', 'url' => route('home'), 'primary' => true], ['label' => 'Read the FAQ', 'url' => route('faq')]],
    ])
@endsection
