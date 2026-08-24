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

        $pillars = [
            ['Smart buildings and connected infrastructure', 'Buildings that sense, adapt and share data across the campus network.', '🏢'],
            ['Green and sustainable environment', 'Landscapes, biodiversity and low-impact design at the centre of the city.', '🌳'],
            ['Smart energy and efficient resource use', 'Renewable generation, storage and demand-aware consumption.', '⚡'],
            ['Smart transportation and mobility', 'Clean, shared and intelligently routed movement across the city.', '🚌'],
            ['Smart water and waste management', 'Monitored water networks, recycling and circular waste handling.', '💧'],
            ['Environmental monitoring', 'Air, noise, water and climate sensing that guides decisions.', '📡'],
            ['Connected digital services', 'Unified services for students, staff and visitors.', '🔗'],
            ['Automation and intelligent systems', 'Systems that respond without waiting for manual instruction.', '🤖'],
            ['Innovation for sustainable urban living', 'New ideas that make sustainable living the easier choice.', '💡'],
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

        foreach ($pillars as $index => [$title, $description, $icon]) {
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
