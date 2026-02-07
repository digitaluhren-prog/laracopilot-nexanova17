<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Shëndetësi dhe Mjekësi',
                'slug' => 'shendetesi-dhe-mjekesi',
                'icon' => '🏥',
                'description' => 'Doktorë, klinika, farmaci, laboratorë, shërbime shëndetësore',
                'active' => true,
            ],
            [
                'name' => 'Shërbime Juridike',
                'slug' => 'sherbime-juridike',
                'icon' => '⚖️',
                'description' => 'Avokatë, noterë, këshilltar ligjor, shërbime juridike',
                'active' => true,
            ],
            [
                'name' => 'Arsim dhe Kurse',
                'slug' => 'arsim-dhe-kurse',
                'icon' => '📚',
                'description' => 'Shkolla, qendra mësimore, kurse gjuhësh, trajnime profesionale',
                'active' => true,
            ],
            [
                'name' => 'Ndërtim dhe Renovim',
                'slug' => 'ndertim-dhe-renovim',
                'icon' => '🏗️',
                'description' => 'Kompani ndërtimi, inxhinierë, rinovime, elektricistë, hidraulikë',
                'active' => true,
            ],
            [
                'name' => 'Automjete dhe Transport',
                'slug' => 'automjete-dhe-transport',
                'icon' => '🚗',
                'description' => 'Servis auto, shitje makinash, riparime, larje auto, transport',
                'active' => true,
            ],
            [
                'name' => 'Bukuri dhe Mirëqenie',
                'slug' => 'bukuri-dhe-mireqenie',
                'icon' => '💅',
                'description' => 'Sallone bukurie, spa, palestër, trajnerë personalë, wellness',
                'active' => true,
            ],
            [
                'name' => 'Ushqim dhe Pije',
                'slug' => 'ushqim-dhe-pije',
                'icon' => '🍽️',
                'description' => 'Restorante, kafera, pastiçeri, catering, dorëzim ushqimi',
                'active' => true,
            ],
            [
                'name' => 'Teknologji dhe IT',
                'slug' => 'teknologji-dhe-it',
                'icon' => '💻',
                'description' => 'Riparim kompjuterash, zhvillim software, web design, IT support',
                'active' => true,
            ],
            [
                'name' => 'Udhëtim dhe Turizëm',
                'slug' => 'udhetim-dhe-turizem',
                'icon' => '✈️',
                'description' => 'Agjenci udhëtimi, hotele, ture turistike, transport turistik',
                'active' => true,
            ],
            [
                'name' => 'Shërbime të Tjera',
                'slug' => 'sherbime-te-tjera',
                'icon' => '🔧',
                'description' => 'Shërbime të ndryshme që nuk kategorizohen në grupet e tjera',
                'active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('10 categories created successfully!');
    }
}