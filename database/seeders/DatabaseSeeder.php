<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Renato',
            'email' => 'renatodev001@gmail.com',
            'password' => 'password',
        ]);

        // Crie algumas tags
        $t1 = \App\Models\Tag::create(['name' => 'Lançamento', 'slug' => 'lancamento', 'color' => 'purple']);
        $t2 = \App\Models\Tag::create(['name' => 'Promoção', 'slug' => 'promocao', 'color' => 'red']);
        $t3 = \App\Models\Tag::create(['name' => 'Eco-Friendly', 'slug' => 'eco', 'color' => 'green']);

        // Associe ao primeiro produto
        $p = \App\Models\Product::first();
        if ($p) {
            $p->tags()->attach([$t1->id, $t3->id]);
        }
    }
}
