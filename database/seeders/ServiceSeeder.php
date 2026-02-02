<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Web & App' => [
                'Web & App Development',
                'Web & App Design',
                'API Integration',
            ],
            'Digital Marketing' => [
                'Social Media Marketing',
                'Search Engine Marketing',
                'Content Strategy',
            ],
            'Cyber Security' => [
                'Network Security',
                'Threat Assessment',
                'Data Protection',
            ],
            'Graphic Designing' => [
                'Logo Design',
                'Branding',
                'UI/UX Illustration',
            ],
            'IOT Solutions' => [
                'Smart Automation',
                'Sensor Integration',
                'Industrial IOT',
            ],
            'Others' => [
                'SEO Optimization',
                'Devops Engineering',
                'SQA Testing',
            ],
        ];

        foreach ($services as $categoryName => $serviceList) {

            $category = ServiceCategory::where('name', $categoryName)->first();

            foreach ($serviceList as $service) {
                Service::create([
                    'service_category_id' => $category->id,
                    'name' => $service,
                    'slug' => str()->slug($service),
                    'description' => $service . ' professional service',
                ]);
            }
        }
    }
}
