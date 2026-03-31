<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Neighborhood;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            [
                'name' => 'المنطقة الشمالية',
                'code' => 'north',
                'neighborhoods' => [
                    ['name' => 'الروضة', 'code' => 'north-rawda'],
                    ['name' => 'النفل', 'code' => 'north-nakheel'],
                    ['name' => 'الندى', 'code' => 'north-nada'],
                ],
            ],
            [
                'name' => 'المنطقة الوسطى',
                'code' => 'central',
                'neighborhoods' => [
                    ['name' => 'الملز', 'code' => 'central-malaz'],
                    ['name' => 'السليمانية', 'code' => 'central-sulaimania'],
                    ['name' => 'الضباب', 'code' => 'central-dabab'],
                ],
            ],
            [
                'name' => 'المنطقة الجنوبية',
                'code' => 'south',
                'neighborhoods' => [
                    ['name' => 'الشفا', 'code' => 'south-shifa'],
                    ['name' => 'العزيزية', 'code' => 'south-azizia'],
                    ['name' => 'بدر', 'code' => 'south-badr'],
                ],
            ],
        ];

        foreach ($districts as $districtData) {
            $district = District::query()->updateOrCreate(
                ['code' => $districtData['code']],
                [
                    'name' => $districtData['name'],
                    'code' => $districtData['code'],
                ],
            );

            foreach ($districtData['neighborhoods'] as $neighborhoodData) {
                Neighborhood::query()->updateOrCreate(
                    ['code' => $neighborhoodData['code']],
                    [
                        'district_id' => $district->id,
                        'name' => $neighborhoodData['name'],
                        'code' => $neighborhoodData['code'],
                    ],
                );
            }
        }
    }
}
