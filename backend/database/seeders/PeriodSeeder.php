<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    private array $data = [
        [

            "time" => "08h - 09h",
        ],
        [

            "time" => "09h - 10h",
        ],
        [

            "time" => "10h - 11h",
        ],
        [

            "time" => "11h - 12h",
        ],
        [

            "time" => "12h - 13h",
        ],
        [

            "time" => "13h - 14h",
        ],
        [

            "time" => "14h - 15h",
        ],
        [

            "time" => "15h - 16h",
        ],
        [

            "time" => "16h - 17h",
        ],
        [

            "time" => "17h - 18h",
        ],
        [

            "time" => "18h - 19h",
        ],
        [

            "time" => "19h - 20h",
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect($this->data)->map(function (array $data): Period {
            return Period::create($data);
        });
    }
}
