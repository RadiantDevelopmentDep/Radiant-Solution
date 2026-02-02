<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web & App',
            'Digital Marketing',
            'Cyber Security',
            'Graphic Designing',
            'IOT Solutions',
            'Others',
        ];

        foreach ($categories as $cat) {
            ServiceCategory::create([
                'name' => $cat,
                'slug' => str()->slug($cat),
                'status' => 1,
            ]);
        }
    }
}
