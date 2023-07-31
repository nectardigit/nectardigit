<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            /*  'role-list',
            'role-create',
            'role-edit',
            'role-delete',
             */
            ['id' => 1, 'name' => 'user-list'],
            ['id' => 2, 'name' => 'user-create'],
            ['id' => 3, 'name' => 'user-edit'],
            ['id' => 4, 'name' => 'user-delete'],

            ['id' => 5, 'name' => 'menu-list'],
            ['id' => 6, 'name' => 'menu-create'],
            ['id' => 7, 'name' => 'menu-edit'],
            ['id' => 8, 'name' => 'menu-delete'],

            ['id' => 9, 'name' => 'slider-list'],
            ['id' => 10, 'name' => 'slider-create'],
            ['id' => 11, 'name' => 'slider-edit'],
            ['id' => 12, 'name' => 'slider-delete'],

            ['id' => 13, 'name' => 'information-list'],
            ['id' => 14, 'name' => 'information-create'],
            ['id' => 15, 'name' => 'information-edit'],
            ['id' => 16, 'name' => 'information-delete'],

            ['id' => 17, 'name' => 'feature-list'],
            ['id' => 18, 'name' => 'feature-create'],
            ['id' => 19, 'name' => 'feature-edit'],
            ['id' => 20, 'name' => 'feature-delete'],

            ['id' => 21, 'name' => 'testimonial-list'],
            ['id' => 22, 'name' => 'testimonial-create'],
            ['id' => 23, 'name' => 'testimonial-edit'],
            ['id' => 24, 'name' => 'testimonial-delete'],

            ['id' => 25, 'name' => 'faq-list'],
            ['id' => 26, 'name' => 'faq-create'],
            ['id' => 27, 'name' => 'faq-edit'],
            ['id' => 28, 'name' => 'faq-delete'],

            ['id' => 29, 'name' => 'tag-list'],
            ['id' => 30, 'name' => 'tag-create'],
            ['id' => 31, 'name' => 'tag-edit'],
            ['id' => 32, 'name' => 'tag-delete'],

            ['id' => 33, 'name' => 'blog-list'],
            ['id' => 34, 'name' => 'blog-create'],
            ['id' => 35, 'name' => 'blog-edit'],
            ['id' => 36, 'name' => 'blog-delete'],

            ['id' => 37, 'name' => 'contact-list'],
            ['id' => 38, 'name' => 'contact-view'],
            ['id' => 39, 'name' => 'contact-edit'],
            ['id' => 40, 'name' => 'contact-delete'],

            ['id' => 41, 'name' => 'profile-list'],
            ['id' => 42, 'name' => 'profile-create'],
            ['id' => 43, 'name' => 'profile-edit'],
            ['id' => 44, 'name' => 'profile-delete'],

            ['id' => 45, 'name' => 'advertisementposition-list'],
            ['id' => 46, 'name' => 'advertisementposition-create'],
            ['id' => 47, 'name' => 'advertisementposition-edit'],
            ['id' => 48, 'name' => 'advertisementposition-delete'],

            ['id' => 49, 'name' => 'advertisement-list'],
            ['id' => 50, 'name' => 'advertisement-create'],
            ['id' => 51, 'name' => 'advertisement-edit'],
            ['id' => 52, 'name' => 'advertisement-delete'],

//            ['id' => 53, 'name' => 'migrateOldDb-list'],
//            ['id' => 54, 'name' => 'migrateOldDb-create'],
//            ['id' => 55, 'name' => 'migrateOldDb-edit'],
//            ['id' => 56, 'name' => 'migrateOldDb-delete'],

            ['id' => 57, 'name' => 'fetchTable-list'],
            ['id' => 58, 'name' => 'fetchTable-view'],
            ['id' => 59, 'name' => 'fetchTable-edit'],
            ['id' => 60, 'name' => 'fetchTable-delete'],
//
//            ['id' => 61, 'name' => 'env-list'],
//            ['id' => 62, 'name' => 'env-create'],
//            ['id' => 63, 'name' => 'env-edit'],
//            ['id' => 64, 'name' => 'env-delete'],

            ['id' => 65, 'name' => 'news-list'],
            ['id' => 66, 'name' => 'news-create'],
            ['id' => 67, 'name' => 'news-edit'],
            ['id' => 68, 'name' => 'news-delete'],

            ['id' => 69, 'name' => 'reporter-list'],
            ['id' => 70, 'name' => 'reporter-create'],
            ['id' => 71, 'name' => 'reporter-edit'],
            ['id' => 72, 'name' => 'reporter-delete'],

            ['id' => 73, 'name' => 'guest-list'],
            ['id' => 74, 'name' => 'guest-create'],
            ['id' => 75, 'name' => 'guest-edit'],
            ['id' => 76, 'name' => 'guest-delete'],

            ['id' => 77, 'name' => 'blogCategory-list'],
            ['id' => 78, 'name' => 'blogCategory-create'],
            ['id' => 79, 'name' => 'blogCategory-edit'],
            ['id' => 80, 'name' => 'blogCategory-delete'],

            ['id' => 81, 'name' => 'designation-list'],
            ['id' => 82, 'name' => 'designation-create'],
            ['id' => 83, 'name' => 'designation-edit'],
            ['id' => 84, 'name' => 'designation-delete'],

            ['id' => 85, 'name' => 'team-list'],
            ['id' => 86, 'name' => 'team-create'],
            ['id' => 87, 'name' => 'team-edit'],
            ['id' => 88, 'name' => 'team-delete'],

            ['id' => 89, 'name' => 'newsenglish-publish'],
            ['id' => 90, 'name' => 'newsenglish-create'],
            ['id' => 91, 'name' => 'newsenglish-update'],
            ['id' => 92, 'name' => 'newsenglish-delete'],

            ['id' => 93, 'name' => 'newsnepali-publish'],
            ['id' => 94, 'name' => 'newsnepali-create'],
            ['id' => 95, 'name' => 'newsnepali-update'],
            ['id' => 96, 'name' => 'newsnepali-delete'],

            ['id' => 97, 'name' => 'video-list'],
            ['id' => 98, 'name' => 'video-create'],
            ['id' => 99, 'name' => 'video-edit'],
            ['id' => 100, 'name' => 'video-delete'],

            ['id' => 97, 'name' => 'subscriber-list'],
            ['id' => 98, 'name' => 'subscriber-create'],
            ['id' => 99, 'name' => 'subscriber-edit'],
            ['id' => 100, 'name' => 'subscriber-delete'],

            ['id' => 101, 'name' => 'roles-list'],
            ['id' => 102, 'name' => 'roles-create'],
            ['id' => 103, 'name' => 'roles-edit'],
            ['id' => 104, 'name' => 'roles-delete'],


            ['id' => 105, 'name' => 'mediaLibrary-list'],
            ['id' => 106, 'name' => 'advertisement-sort'],
            ['id' => 107, 'name' => 'advertisement-publish'],

            ['id' => 108, 'name' => 'horoscope-list'],
            ['id' => 109, 'name' => 'horoscope-create'],
            ['id' => 110, 'name' => 'horoscope-edit'],
            ['id' => 111, 'name' => 'horoscope-delete'],

            ['id' => 112, 'name' => 'clients-list'],
            ['id' => 113, 'name' => 'clients-create'],
            ['id' => 114, 'name' => 'clients-edit'],
            ['id' => 115, 'name' => 'clients-delete'],

            ['id' => 116, 'name' => 'container-list'],
            ['id' => 117, 'name' => 'container-create'],
            ['id' => 118, 'name' => 'container-edit'],
            ['id' => 119, 'name' => 'container-delete'],

            ['id' => 120, 'name' => 'counter-list'],
            ['id' => 121, 'name' => 'counter-create'],
            ['id' => 122, 'name' => 'counter-edit'],
            ['id' => 123, 'name' => 'counter-delete'],


            ['id' => 124, 'name' => 'gallery-list'],
            ['id' => 125, 'name' => 'gallery-create'],
            ['id' => 126, 'name' => 'gallery-edit'],
            ['id' => 127, 'name' => 'gallery-delete'],

            ['id' => 128, 'name' => 'gallerycategory-list'],
            ['id' => 129, 'name' => 'gallerycategory-create'],
            ['id' => 130, 'name' => 'gallerycategory-edit'],
            ['id' => 131, 'name' => 'gallerycategory-delete'],

            ['id' => 132, 'name' => 'notice-list'],
            ['id' => 133, 'name' => 'notice-create'],
            ['id' => 134, 'name' => 'notice-edit'],
            ['id' => 135, 'name' => 'notice-delete'],

        ];
        foreach ($permissions as $permission) {
            $menu = new Permission();
            if ($menu->where('id', $permission['id'])->count() > 0) {
                $menu = $menu->where('id', $permission['id'])->first();
            }
            $menu->fill($permission);
            $menu->save();
        }
    }
}
