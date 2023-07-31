<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Text;

class TextSeeder extends Seeder
{
    protected $texts = [
        [
            'key' => 'sliderTitle',
            'value' => 'Slider Title'
        ],
        [
            'key' => 'sliderDescription',
            'value' => 'Slider Description'
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('texts')->truncate();
        foreach ($this->texts as $index => $setting) {
            $result = Text::create($setting);
            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
        }
        $this->command->info('Inserted ' . count($this->texts) . ' records');
    }
}
