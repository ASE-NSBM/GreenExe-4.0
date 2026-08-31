@extends('layouts.app')

@section('title', 'Not allowed — '.config('greenexe.event.name'))

@section('content')
    @include('partials.error-page', [
        'code' => '403',
        'eyebrow' => 'Error 403',
        'titleItalic' => 'You do not have',
        'title' => 'access to this',
        'lead' => 'This area is restricted to GreenExE organisers. If you believe you should have access, contact the organising team.',
        'actions' => [['label' => 'Back to home', 'url' => route('home'), 'primary' => true], ['label' => 'Contact the organisers', 'url' => route('contact')]],
    ])
@endsection
