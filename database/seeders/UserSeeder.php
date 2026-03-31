<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $agencies = Agency::query()->get()->keyBy('type');

        $users = [
            [
                'name' => 'مدير النظام',
                'email' => 'admin@cleanstreets.test',
                'phone' => '0500000001',
                'password' => 'password',
                'role' => 'super_admin',
                'agency_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'مراجع البلاغات',
                'email' => 'reviewer@cleanstreets.test',
                'phone' => '0500000002',
                'password' => 'password',
                'role' => 'reviewer',
                'agency_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'المراقب الميداني',
                'email' => 'inspector@cleanstreets.test',
                'phone' => '0500000003',
                'password' => 'password',
                'role' => 'inspector',
                'agency_id' => $agencies->get('municipality')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'مسؤول البلدية',
                'email' => 'municipality-admin@cleanstreets.test',
                'phone' => '0500000004',
                'password' => 'password',
                'role' => 'municipality_admin',
                'agency_id' => $agencies->get('municipality')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'مسؤول المرور',
                'email' => 'traffic-admin@cleanstreets.test',
                'phone' => '0500000005',
                'password' => 'password',
                'role' => 'traffic_admin',
                'agency_id' => $agencies->get('traffic')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'موظف التدوير',
                'email' => 'recycling-user@cleanstreets.test',
                'phone' => '0500000006',
                'password' => 'password',
                'role' => 'agency_user',
                'agency_id' => $agencies->get('recycling')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'منسق النقل',
                'email' => 'transport-user@cleanstreets.test',
                'phone' => '0500000007',
                'password' => 'password',
                'role' => 'agency_user',
                'agency_id' => $agencies->get('transport')?->id,
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::query()->firstOrNew([
                'email' => $userData['email'],
            ]);

            $user->forceFill([
                ...$userData,
                'email_verified_at' => now(),
            ])->save();
        }
    }
}
