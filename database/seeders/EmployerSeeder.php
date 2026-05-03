<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployerSeeder extends Seeder
{
    public function run(): void
    {
        $employers = [
            [
                'user' => [
                    'name'  => 'Remera Sector',
                    'email' => 'admin@remerasector.gov.rw',
                ],
                'employer' => [
                    'name'                => 'Remera Sector',
                    'tin_number'          => '100000001',
                    'registration_number' => 'GOV-REM-001',
                    'sector'              => 'public_administration',
                    'address'             => 'Remera Sector Office, Gasabo',
                    'district'            => 'Gasabo',
                    'province'            => 'Kigali City',
                    'phone'               => '+250788100001',
                    'email'               => 'info@remerasector.gov.rw',
                    'website'             => 'https://www.remerasector.gov.rw',
                    'description'         => 'Local government administrative unit responsible for service delivery in Remera Sector, Gasabo District.',
                    'status'              => 'verified',
                ],
            ],
            [
                'user' => [
                    'name'  => 'CCI Rwanda',
                    'email' => 'admin@ccirwanda.rw',
                ],
                'employer' => [
                    'name'                => 'CCI Rwanda',
                    'tin_number'          => '100000002',
                    'registration_number' => 'BPO-CCI-002',
                    'sector'              => 'bpo_call_center',
                    'address'             => 'KG 9 Ave, Kigali Heights, Kigali',
                    'district'            => 'Gasabo',
                    'province'            => 'Kigali City',
                    'phone'               => '+250788100002',
                    'email'               => 'info@ccirwanda.rw',
                    'website'             => 'https://www.ccirwanda.rw',
                    'description'         => 'Leading BPO and call centre operator providing customer engagement solutions across Africa.',
                    'status'              => 'verified',
                ],
            ],
            [
                'user' => [
                    'name'  => 'Grand Legacy Hotel',
                    'email' => 'admin@grandlegacyhotel.rw',
                ],
                'employer' => [
                    'name'                => 'Grand Legacy Hotel',
                    'tin_number'          => '100000003',
                    'registration_number' => 'HTL-GLD-003',
                    'sector'              => 'hospitality_tourism',
                    'address'             => 'KN 3 Ave, Nyarugenge, Kigali',
                    'district'            => 'Nyarugenge',
                    'province'            => 'Kigali City',
                    'phone'               => '+250788100003',
                    'email'               => 'reservations@grandlegacyhotel.rw',
                    'website'             => 'https://www.grandlegacyhotel.rw',
                    'description'         => 'Premium hospitality establishment offering conference facilities, accommodation and dining in Kigali.',
                    'status'              => 'verified',
                ],
            ],
            [
                'user' => [
                    'name'  => 'Prideconnect Travel and Tours Ltd',
                    'email' => 'admin@prideconnect.rw',
                ],
                'employer' => [
                    'name'                => 'Prideconnect Travel and Tours Ltd',
                    'tin_number'          => '100000004',
                    'registration_number' => 'TRV-PRC-004',
                    'sector'              => 'hospitality_tourism',
                    'address'             => 'KG 11 Ave, Remera, Kigali',
                    'district'            => 'Gasabo',
                    'province'            => 'Kigali City',
                    'phone'               => '+250788100004',
                    'email'               => 'info@prideconnect.rw',
                    'website'             => 'https://www.prideconnect.rw',
                    'description'         => 'Full-service travel and tours company specialising in inbound tourism, safaris and MICE services across Rwanda and East Africa.',
                    'status'              => 'verified',
                ],
            ],
        ];

        foreach ($employers as $entry) {
            // Create (or find) the owner user account
            $user = User::firstOrCreate(
                ['email' => $entry['user']['email']],
                [
                    'name'     => $entry['user']['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'employer',
                    'is_active' => true,
                ]
            );

            // Create (or find) the employer record linked to that user
            Employer::firstOrCreate(
                ['tin_number' => $entry['employer']['tin_number']],
                array_merge($entry['employer'], ['user_id' => $user->id])
            );
        }
    }
}