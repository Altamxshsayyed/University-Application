<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $classes = ['5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th'];

        for ($i = 0; $i < 50; $i++) {
            DB::table('students')->insert([
                'student_name' => $faker->name,
                'class_teacher_id' => rand(1, 10),
                'class' => $classes[array_rand($classes)],
                'admission_date' => $faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
                'yearly_fees' => $faker->randomFloat(2, 1000, 10000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
        }
    }
}
