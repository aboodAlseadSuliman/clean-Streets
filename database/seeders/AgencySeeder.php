<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        $agencies = [
            [
                'name' => 'بلدية المدينة',
                'type' => 'municipality',
                'phone' => '0114000100',
                'email' => 'municipality@cleanstreets.test',
                'address' => 'المركز الرئيسي - شارع البلدية',
                'is_active' => true,
            ],
            [
                'name' => 'إدارة المرور',
                'type' => 'traffic',
                'phone' => '0114000200',
                'email' => 'traffic@cleanstreets.test',
                'address' => 'مبنى إدارة المرور - الطريق الدائري',
                'is_active' => true,
            ],
            [
                'name' => 'إدارة النقل والخدمات',
                'type' => 'transport',
                'phone' => '0114000300',
                'email' => 'transport@cleanstreets.test',
                'address' => 'مركز الخدمات اللوجستية',
                'is_active' => true,
            ],
            [
                'name' => 'شركة التدوير الحضري',
                'type' => 'recycling',
                'phone' => '0114000400',
                'email' => 'recycling@cleanstreets.test',
                'address' => 'المنطقة الصناعية الثانية',
                'is_active' => true,
            ],
            [
                'name' => 'لجنة حي الندى',
                'type' => 'district_committee',
                'phone' => '0114000500',
                'email' => 'district-committee@cleanstreets.test',
                'address' => 'مركز خدمات الحي',
                'is_active' => true,
            ],
        ];

        foreach ($agencies as $agencyData) {
            Agency::query()->updateOrCreate(
                ['type' => $agencyData['type']],
                $agencyData,
            );
        }
    }
}
