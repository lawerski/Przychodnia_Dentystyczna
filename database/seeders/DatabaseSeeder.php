<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Dentist;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = 50;
        $dentists = 20;
        $services = 100;
        $reviews = 200;
        $coupons = 10;
        $reservations = 50;
        if ($users < $dentists) {
            // There can't be more dentists than users
            // setting dentists count to users count instead
            $dentists = $users;
        }
        User::factory()->count($users)->create();
        Dentist::factory()->count($dentists)->withMaxPossibleUserId($users)->create();
        Service::factory()->count($services)->withMaxPossibleDoctorId($dentists)->create();
        Review::factory()->count($reviews)->withMaxPossibleUserId($users)->withMaxPossibleDoctorId($dentists)->create();
        Coupon::factory()->count($coupons)->withMaxPossibleUserId($users)->withMaxPossibleServiceId($services)->create();
        Reservation::factory()->count($reservations)->withMaxPossibleUserId($users)->withMaxPossibleServiceId($services)->create();

        User::factory()->create([
            'username' => 'AdminUser',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'password' => bcrypt('1234'), // password
            'type' => 'admin',
        ]);
    }
}
