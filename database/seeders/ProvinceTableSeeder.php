<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
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
                'eng_name' => 'Province 1',
                'status' => '1',
            ],
            [
                'eng_name' => 'Province 2',
                'status' => '1',
            ],
            [
                'eng_name' => 'Bagmati',
                'status' => '1',
            ],
            [
                'eng_name' => 'Gandaki',
                'status' => '1',
            ],
            [
                'eng_name' => 'Province 5',
                'status' => '1',
            ],
            [
                'eng_name' => 'Karnali',
                'status' => '1',
            ],
            [
                'eng_name' => 'Province 7',
                'status' => '1',
            ]
        ];
        \DB::table('provinces')->insert($data);
    }
}
