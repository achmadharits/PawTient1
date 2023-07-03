<?php

namespace Database\Seeders;

use App\Models\JenisKonsultasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKonsultasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'jenis' => 'Endodontik'
            ],
            [
                'jenis' => 'Ortodontik'
            ],
        ];
        
        foreach ($data as $value) {
            JenisKonsultasi::insert(
                [
                    'jenis' => $value['jenis'],
                ]
            );
        }
    }
}
