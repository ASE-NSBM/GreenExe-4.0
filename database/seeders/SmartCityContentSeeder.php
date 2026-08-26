<?php

namespace Database\Seeders;

use App\Models\SmartCityContent;
use Illuminate\Database\Seeder;

class SmartCityContentSeeder extends Seeder
{
    /**
     * The nine Smart Green City pillars from SRS section 1.3.
     */
    public function run(): void
    {
        $vision = [
            [
                'title' => 'An enhanced smart-city environment',
                'description' => 'NSBM Green University is the inspiration for a city where green spaces, intelligent infrastructure, connectivity and automation work together.',
                'icon' => '🏙️',
            ],
            [
                'title' => 'Technology serving sustainability',
                'description' => 'The event experience should show how technology transforms a green environment into a connected, efficient, intelligent and sustainable city.',
                'icon' => '🌍',
            ],
        ];

        // Each pillar is stored as a lead sentence followed by its points, one
        // per line. Views split on the line breaks, so organisers can add or
        // remove points from the dashboard without a schema change.
        $pillars = [
            [
                'Smart buildings and connected infrastructure',
                'Buildings that sense, adapt and share data across the campus network.',
                ['Occupancy and climate sensing in every block', 'Shared building data on one campus network', 'Predictive maintenance instead of fixed schedules'],
                '🏢',
            ],
            [
                'Green and sustainable environment',
                'Landscapes, biodiversity and low-impact design at the centre of the city.',
                ['Green roofs and planted corridors', 'Habitat and biodiversity monitoring', 'Low-impact materials and construction'],
                '🌳',
            ],
            [
                'Smart energy and efficient resource use',
                'Renewable generation, storage and demand-aware consumption.',
                ['On-site solar generation and storage', 'Load shifted to match supply', 'Live consumption visible to everyone'],
                '⚡',
            ],
            [
                'Smart transportation and mobility',
                'Clean, shared and intelligently routed movement across the city.',
                ['Electric and shared campus transport', 'Routing that reacts to demand', 'Safe walking and cycling routes'],
                '🚌',
            ],
            [
                'Smart water and waste management',
                'Monitored water networks, recycling and circular waste handling.',
                ['Leak detection across the network', 'Rainwater capture and reuse', 'Sorted, tracked and recycled waste'],
                '💧',
            ],
            [
                'Environmental monitoring',
                'Air, noise, water and climate sensing that guides decisions.',
                ['Distributed air and noise sensors', 'Open environmental dashboards', 'Alerts when thresholds are crossed'],
                '📡',
            ],
            [
                'Connected digital services',
                'Unified services for students, staff and visitors.',
                ['One identity across every service', 'Campus information in real time', 'Accessible on any device'],
                '🔗',
            ],
            [
                'Automation and intelligent systems',
                'Systems that respond without waiting for manual instruction.',
                ['Lighting and climate that self-adjust', 'Automated safety and security responses', 'Decisions supported by live data'],
                '🤖',
            ],
            [
                'Innovation for sustainable urban living',
                'New ideas that make sustainable living the easier choice.',
                ['Student-led sustainability projects', 'Ideas tested on a living campus', 'Solutions that scale beyond the university'],
                '💡',
            ],
        ];

        foreach ($vision as $index => $item) {
            SmartCityContent::updateOrCreate(
                ['section' => 'vision', 'title' => $item['title']],
                [
                    'description' => $item['description'],
                    'icon' => $item['icon'],
                    'sort_order' => $index,
                    'is_published' => true,
                ]
            );
        }

        foreach ($pillars as $index => [$title, $lead, $points, $icon]) {
            $description = implode('
', array_merge([$lead], $points));

            foreach (['pillar', 'highlight'] as $section) {
                SmartCityContent::updateOrCreate(
                    ['section' => $section, 'title' => $title],
                    [
                        'description' => $description,
                        'icon' => $icon,
                        'sort_order' => $index,
                        'is_published' => true,
                    ]
                );
            }
        }
    }
}
