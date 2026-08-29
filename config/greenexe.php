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
        'email' => env('GREENEXE_CONTACT_EMAIL', 'ase@nsbm.ac.lk'),
        'phone' => env('GREENEXE_CONTACT_PHONE', '+94 71 872 9888'),
        'address' => 'NSBM Green University, Mahenwatta, Pitipana, Homagama, Sri Lanka',
        'map_url' => env('GREENEXE_MAP_URL', 'https://maps.google.com/?q=NSBM+Green+University'),
        'website' => env('GREENEXE_WEBSITE_URL', 'https://asensbm.live'),
        // Order here is the order the icons appear. Only verified, active

        'socials' => [
            'linkedin' => env('GREENEXE_LINKEDIN_URL', 'https://www.linkedin.com/company/asensbm'),
            'facebook' => env('GREENEXE_FACEBOOK_URL', 'https://www.facebook.com/ase.nsbm/'),
            'instagram' => env('GREENEXE_INSTAGRAM_URL', 'https://www.instagram.com/ase.nsbm/'),
        ],
    ],


    'organizer' => [
        'short_name' => 'ASE',
        'name' => 'Association of Software Engineering',
        'summary' => 'The official student body representing Software Engineering undergraduates at NSBM Green University.',
        'tagline' => 'Empowering innovation through technology and community.',
        'vision' => 'To be the leading student organization that nurtures innovation and technical excellence among Software Engineering undergraduates.',
        'mission' => 'To create an inclusive community that bridges academia and industry through meaningful events, workshops, and competitions.',
        'why' => 'A competition turns ideas into working solutions. GreenExE gives student teams a real problem, teammates to solve it with, and a deadline that pushes the work past the classroom.',
        'affiliation' => 'NSBM Green University',
        /*
        | Organizer statistics. Left empty on purpose: show a number only once
        | ASE confirms it (SRS 18). Each entry is ['value' => '500+', 'label' => 'Members'].
        | The stats row is hidden while this array is empty.
        */
        'stats' => array_values(array_filter([
            // ['value' => '500+', 'label' => 'Members'],
            // ['value' => '20+', 'label' => 'Events'],
            // ['value' => '2015', 'label' => 'Founded'],
        ])),
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

    'committee' => [
        [
            'name' => 'Samsudeen Ashad',
            'role' => 'President',
            'email' => 'samsudeenashad@gmail.com',
            'image' => '/team/ashad.jpg',
        ],
        [
            'name' => 'Nethum Bashitha',
            'role' => 'Vice President',
            'email' => 'bashithanethum4@gmail.com',
            'image' => '/team/nethum.jpg',
        ],
        [
            'name' => 'Dilara Wickramanayake',
            'role' => 'Vice President',
            'email' => 'dilarawickramanayake@gmail.com',
            'image' => '/team/dilara.jpg',
        ],
        [
            'name' => 'Hirushi Nethmini',
            'role' => 'Secretary',
            'email' => 'hirushinethmini5@gmail.com',
            'image' => '/team/hirushi.jpeg',
        ],
    ],

    'development_team' => [
        [
            'name' => 'Samsudeen Ashad',
            'role' => 'President',
            'image' => '/team/ashad.jpg',
        ],
        [
            'name' => 'Rashmika Fernando',
            'role' => 'Chief Technical Affairs & Organizing Lead',
            'image' => '/team/rashmika.jpg',
        ],
        [
            'name' => 'Zenith Ivan',
            'role' => 'Development Lead — Powerteam',
            'image' => '/team/zenith.jpg',
        ],
        [
            'name' => 'Himath Bandara',
            'role' => 'Development Lead — 24 Batch',
            'image' => '/team/himath.jpg',
        ],
        [
            'name' => 'Shamika Keshan',
            'role' => 'Development Lead — 25 Batch',
            'image' => '/team/keshan.jpg',
        ],
        [
            'name' => 'Ramiru Wanigathunga',
            'role' => 'Development Lead — 26 Batch',
            'image' => '/team/ramiru.jpg',
        ],
    ],

];
