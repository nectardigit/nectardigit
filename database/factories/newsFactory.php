<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\news;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class newsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = news::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $img_data = [
            'https://source.unsplash.com/bUVwWCSiDss',
            'https://source.unsplash.com/9sgaZwWw-WA',
            'https://source.unsplash.com/XVOBr3F95RY',
            'https://source.unsplash.com/dFEls-KSI9A',
            'https://source.unsplash.com/St2zVK-Q_mU',
            'https://source.unsplash.com/OwqLxCvoVxI',
            'https://source.unsplash.com/qwe8TLRnG8k',
            'https://source.unsplash.com/5Mj4PO7KIFc',
            'https://source.unsplash.com/1Z2niiBPg5A',
            'https://source.unsplash.com/lsoogGC_5dg',
            'https://source.unsplash.com/oR0uERTVyD0',
            'https://source.unsplash.com/TFyi0QOx08c',
            'https://source.unsplash.com/xny2e95bvgA',
            'https://source.unsplash.com/Z0KjmjxUsKs',
            'https://source.unsplash.com/OgqWLzWRSaI',
            'https://source.unsplash.com/7mfSzu6_qvA',
            'https://source.unsplash.com/_brbffwqtRM',
            'https://source.unsplash.com/HVUpIbx7sTE',
            'https://source.unsplash.com/Uy1P7uztd0M',
            'https://source.unsplash.com/Z_6iR6b_GpI',
            'https://source.unsplash.com/2tX0ztS1YC0',
            'https://source.unsplash.com/22oXTvG3Fgk',
            'https://source.unsplash.com/dX2viJZtvuw',
            'https://source.unsplash.com/4VMr19ljQUA',
            'https://source.unsplash.com/vlXAcYROlKY'
        ];
        return [
            'title' =>[
                "np" => $this->faker->sentence,
                "en" =>$this->faker->sentence,
            ],
            'description' => [
                "np"=>$this->faker->paragraphs(4,true),
                "en" =>$this->faker->paragraph(4,true),

            ],
            'subtitle' => $this->faker->paragraph,
            'slug' => $this->faker->slug.'-'.rand(1111,9999),
            'tagLine' => $this->faker->title,
            'summary' => $this->faker->paragraph,
            'category' => rand(1, 20),
            'reporters' => rand(1, 2),
            'userId' => rand(1, 2),
            'publish_status' => '1',
            'view_count' => rand(0, 1000),
            'meta_title' => $this->faker->title,
            'meta_description' => $this->faker->paragraph,
            'meta_keyword' => $this->faker->title,
            'meta_keyphrase' => $this->faker->title,
            'created_by' => rand(1, 2),
            'img_url' => $img_data[rand(0, 24)],
            'published_at' => Carbon::now()->subdays(rand(1, 10)),
            'verified_at' => Carbon::now()->subdays(rand(1, 9)),
            'isBanner' => rand(1, 50) % 7 == 0 ? true : false,
            'showReporter' => rand(1, 5) % 2 == 0 ? '1' : '0',
            'showContent' => rand(1, 5) % 2 == 0 ? '1' : '0',
            'isFlashNews' => rand(1, 5) % 2 == 0 ? '1' : '0',
            'flashNewsOrder' => rand(1, 5) % 2 == 0 ? '1' : '0',
            'isVideo' => rand(1, 5) % 2 == 0 ? '1' : '0',
            'isFixed' => rand(1, 5) % 2 == 0 ? '1' : '0',
            'isBreaking' => rand(1, 5) % 2 == 0 ? '1' : '0',
            'isSpecial'=>rand(1,5) %2 == 0 ? '1' :'0',
            'isPhotoFeature'=>rand(1,5) %2 == 0 ? '1' :'0',
            'breakingNewsOrder' => rand(1, 5),

        ];
    }
}
