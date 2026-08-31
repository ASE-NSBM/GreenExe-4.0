@extends('layouts.app')

@section('title', 'Back shortly — '.config('greenexe.event.name'))

@section('content')
    @include('partials.error-page', [
        'code' => '503',
        'eyebrow' => 'Maintenance',
        'titleItalic' => 'We are',
        'title' => 'briefly offline',
        'lead' => 'GreenExE is down for scheduled maintenance and will return shortly. Registrations already submitted are safe.',
        'actions' => [],
    ])
@endsection
