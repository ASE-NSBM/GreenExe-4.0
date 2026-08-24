<?php

/*
|--------------------------------------------------------------------------
| GreenExE 4.0 Competition Settings
|--------------------------------------------------------------------------
|
| Organiser-confirmed values live here (SRS section 18). Update these once
| the final competition rules are approved; nothing else needs to change.
|
*/

return [

    'event' => [
        'name' => env('GREENEXE_EVENT_NAME', 'GreenExE 4.0'),
        'concept' => 'Smart Green City',
        'tagline' => 'An enhanced smart-city experience inspired by NSBM Green University.',
        'organizer' => 'Association of Software Engineering (ASE)',
        'brand' => 'Pandora',
        'university' => 'NSBM Green University',
    ],

    'contact' => [
        'email' => env('GREENEXE_CONTACT_EMAIL', 'greenexe@ase.example'),
        'phone' => env('GREENEXE_CONTACT_PHONE', '+94 00 000 0000'),
        'address' => 'NSBM Green University, Mahenwatta, Pitipana, Homagama, Sri Lanka',
        'socials' => [
            'facebook' => env('GREENEXE_FACEBOOK_URL', '#'),
            'instagram' => env('GREENEXE_INSTAGRAM_URL', '#'),
            'linkedin' => env('GREENEXE_LINKEDIN_URL', '#'),
        ],
    ],

    // Team-size limits must be confirmed by organisers before production.
    'team' => [
        'min_members' => (int) env('GREENEXE_MIN_MEMBERS', 2),
        'max_members' => (int) env('GREENEXE_MAX_MEMBERS', 5),
    ],

    'registration' => [
        'open' => (bool) env('GREENEXE_REGISTRATION_OPEN', true),
        'closes_at' => env('GREENEXE_REGISTRATION_CLOSES_AT'),
    ],

    'categories' => [
        'smart-energy' => 'Smart Energy',
        'smart-mobility' => 'Smart Transportation & Mobility',
        'smart-water-waste' => 'Smart Water & Waste Management',
        'smart-buildings' => 'Smart Buildings & Infrastructure',
        'environmental-monitoring' => 'Environmental Monitoring',
        'connected-services' => 'Connected Digital Services',
        'other' => 'Other Sustainable Innovation',
    ],

];
