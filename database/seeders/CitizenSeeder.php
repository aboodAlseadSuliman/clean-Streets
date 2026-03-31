<?php

namespace Database\Seeders;

use App\Models\Citizen;
use Illuminate\Database\Seeder;

class CitizenSeeder extends Seeder
{
    public function run(): void
    {
        $citizens = [
            [
                'full_name' => 'أحمد صالح القحطاني',
                'phone' => '0551000001',
                'whatsapp_phone' => '0551000001',
                'email' => 'ahmad.citizen@example.com',
                'preferred_contact_method' => 'whatsapp',
                'notes' => 'يفضل التواصل مساءً.',
            ],
            [
                'full_name' => 'سارة محمد الدوسري',
                'phone' => '0551000002',
                'whatsapp_phone' => '0551000002',
                'email' => 'sara.citizen@example.com',
                'preferred_contact_method' => 'phone',
                'notes' => null,
            ],
            [
                'full_name' => 'عبدالله ناصر الحربي',
                'phone' => '0551000003',
                'whatsapp_phone' => null,
                'email' => 'abdullah.citizen@example.com',
                'preferred_contact_method' => 'phone',
                'notes' => 'سبق أن قدم بلاغًا مشابهًا.',
            ],
            [
                'full_name' => 'نورة علي العتيبي',
                'phone' => '0551000004',
                'whatsapp_phone' => '0551000004',
                'email' => 'noura.citizen@example.com',
                'preferred_contact_method' => 'email',
                'notes' => null,
            ],
            [
                'full_name' => 'فهد خالد الشهري',
                'phone' => '0551000005',
                'whatsapp_phone' => '0551000005',
                'email' => 'fahad.citizen@example.com',
                'preferred_contact_method' => 'whatsapp',
                'notes' => null,
            ],
            [
                'full_name' => 'ريم يوسف الغامدي',
                'phone' => '0551000006',
                'whatsapp_phone' => null,
                'email' => 'reem.citizen@example.com',
                'preferred_contact_method' => 'phone',
                'notes' => 'طلبت تحديثًا بعد الإزالة.',
            ],
        ];

        foreach ($citizens as $citizenData) {
            Citizen::query()->updateOrCreate(
                ['phone' => $citizenData['phone']],
                $citizenData,
            );
        }
    }
}
