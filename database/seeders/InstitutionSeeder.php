<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
            [
                'name' => 'Yayasan Karya Bakti Surakarta',
                'description' => null,
                'link' => 'https://example.com',
            ],
            [
                'name' => 'Politeknik ATMI',
                'description' => null,
                'link' => 'https://example.com',
            ],
            [
                'name' => 'PT ATMI Solo',
                'description' => null,
                'link' => 'https://example.com',
            ],
            [
                'name' => 'PT IGI',
                'description' => null,
                'link' => 'https://example.com',
            ],
            [
                'name' => 'PT ADE',
                'description' => null,
                'link' => 'https://example.com',
            ],
            [
                'name' => 'PT BIZDEC',
                'description' => null,
                'link' => 'https://example.com',
            ],
        ];

        foreach ($institutions as $institution) {
            Institution::firstOrCreate(
                ['name' => $institution['name']],
                $institution
            );
        }
    }
}
