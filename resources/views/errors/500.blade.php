@extends('layouts.app')

@section('title', 'Server error — '.config('greenexe.event.name'))

@section('content')
    @include('partials.error-page', [
        'code' => '500',
        'eyebrow' => 'Error 500',
        'titleItalic' => 'Something',
        'title' => 'went wrong',
        'lead' => 'An unexpected error stopped this page from loading. The organising team has been notified — please try again shortly.',
        'actions' => [['label' => 'Back to home', 'url' => route('home'), 'primary' => true], ['label' => 'Contact the organisers', 'url' => route('contact')]],
    ])
@endsection
