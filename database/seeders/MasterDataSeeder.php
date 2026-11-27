<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $intimate = Category::firstOrCreate(['slug' => 'intimate'], ['name' => 'Intimate']);
        $wedding = Category::firstOrCreate(['slug' => 'wedding'], ['name' => 'Wedding']);
        $outdoor = Category::firstOrCreate(['slug' => 'outdoor'], ['name' => 'Outdoor']);
        $floral = Category::firstOrCreate(['slug' => 'floral'], ['name' => 'Floral']);
        $display = Category::firstOrCreate(['slug' => 'display'], ['name' => 'Display']);
        $lighting = Category::firstOrCreate(['slug' => 'lighting'], ['name' => 'Lighting']);

        // Paket Utama
        Package::updateOrCreate(['slug' => 'paket-bronze'], [
            'category_id' => $intimate->id,
            'type' => 'package',
            'name' => 'Paket Bronze',
            'tagline' => 'Konsep intimate sederhana',
            'price' => 800000,
            'normal_price' => 1000000,
            'features' => ['Backdrop minimalis 2.5 x 3 meter', '2 Unit Lighting Spotlight', 'Rangkaian bunga semi-artificial', '2 Kursi Pengantin', 'Karpet dekorasi'],
            'is_active' => true,
        ]);

        Package::updateOrCreate(['slug' => 'paket-silver'], [
            'category_id' => $wedding->id,
            'type' => 'package',
            'name' => 'Paket Silver',
            'tagline' => 'Konsep elegan dan modern',
            'price' => 1200000,
            'normal_price' => 1500000,
            'features' => ['Seluruh fasilitas Bronze', '2 Standing Flower', 'Lighting gantung & LED', 'Bunga semi-fresh import', 'Meja akad nikah & kursi'],
            'is_active' => true,
        ]);

        Package::updateOrCreate(['slug' => 'paket-gold'], [
            'category_id' => $wedding->id,
            'type' => 'package',
            'name' => 'Paket Gold',
            'tagline' => 'Dekorasi premium dan eksklusif',
            'price' => 2000000,
            'normal_price' => 2500000,
            'features' => ['Panggung 4-6 meter', 'Full bunga fresh import', 'Backdrop & sofa wedding eksklusif', 'Lighting ambient lengkap', 'Full styling tema'],
            'is_active' => true,
        ]);

        // Add-on
        Package::updateOrCreate(['slug' => 'standing-flower'], [
            'category_id' => $floral->id,
            'type' => 'addon',
            'name' => 'Standing Flower',
            'price' => 350000,
            'description' => 'Rangkaian bunga segar tambahan per titik.',
            'is_active' => true,
        ]);

        Package::updateOrCreate(['slug' => 'welcome-sign'], [
            'category_id' => $display->id,
            'type' => 'addon',
            'name' => 'Welcome Sign',
            'price' => 250000,
            'description' => 'Papan sambutan akrilik/kayu custom nama pengantin.',
            'is_active' => true,
        ]);


        $customer = \App\Models\User::where('role', 'customer')->first();
        $bronze = \App\Models\Package::where('slug', 'paket-bronze')->first();

        if ($customer && $bronze && !\App\Models\Reservation::exists()) {
            $res = \App\Models\Reservation::create([
                'reservation_code' => 'RSV-20261127-0001',
                'user_id' => $customer->id,
                'event_date' => now()->addDays(14)->toDateString(),
                'event_time' => '10:00',
                'venue_name' => 'Gedung Serbaguna Kemang',
                'venue_address' => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
                'concept_notes' => 'Nuansa Minimalis Warm White & Peach Floral',
                'total_amount' => $bronze->price,
                'status' => 'menunggu',
            ]);

            \App\Models\ReservationDetail::create([
                'reservation_id' => $res->id,
                'package_id' => $bronze->id,
                'price' => $bronze->price,
                'quantity' => 1,
                'subtotal' => $bronze->price,
            ]);
        }
    }
}