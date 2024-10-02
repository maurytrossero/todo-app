<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define las tags
        $tags = [
            ['name' => 'Familia'],
            ['name' => 'Trabajo'],
            ['name' => 'Salud y Bienestar'],
            ['name' => 'Estudios'],
            ['name' => 'Hobbies'],
            ['name' => 'Viajes'],
            ['name' => 'Otros'], // Opción por defecto
        ];


        // Inserta las etiquetas en la tabla 'tags'
        DB::table('tags')->insert($tags);
    }
}
