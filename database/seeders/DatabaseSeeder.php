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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = 250;
        $dentists = 20;
        $services = 100;
        $reviews = 200;
        $coupons = 10;
        $reservations = 5000;
        if ($users < $dentists) {
            // There can't be more dentists than users
            // setting dentists count to users count instead
            $dentists = $users;
        }
        // Users password is set to 'password'
        User::factory()->count($users)->create();
        Dentist::factory()->count($dentists)->withMaxPossibleUserId($users)->create();
        Service::factory()->count($services)->withMaxPossibleDentistId($dentists)->create();
        Review::factory()->count($reviews)->withMaxPossibleUserId($users)->withMaxPossibleDentistId($dentists)->create();
        Coupon::factory()->count($coupons)->withMaxPossibleUserId($users)->withMaxPossibleServiceId($services)->create();
        Reservation::factory()->count($reservations)->withMaxPossibleUserId($users)->withMaxPossibleServiceId($services)->create();

        User::factory()->create([
            'id' => 999,
            'username' => 'Admin',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'password' => bcrypt('1234'), // password
            'type' => 'admin',
        ]);
    }
}
