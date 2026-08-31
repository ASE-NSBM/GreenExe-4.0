@extends('layouts.app')

@section('title', 'Page expired — '.config('greenexe.event.name'))

@section('content')
    @include('partials.error-page', [
        'code' => '419',
        'eyebrow' => 'Error 419',
        'titleItalic' => 'This page',
        'title' => 'has expired',
        'lead' => 'Your session timed out before the form was submitted. Nothing was saved. Open the form again and your details can be re-entered.',
        'actions' => [['label' => 'Start registration again', 'url' => route('register'), 'primary' => true], ['label' => 'Back to home', 'url' => route('home')]],
    ])
@endsection
