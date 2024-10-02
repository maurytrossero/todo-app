<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Asegúrate de importar la clase Hash

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crea un usuario de prueba con contraseña encriptada
        User::factory()->create([
            'name' => 'Mauricio Trossero',
            'email' => 'maurytrossero@gmail.com',
            'password' => Hash::make('36001479'), 
        ]);
        
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'administrador@admin.com',
            'password' => Hash::make('m36001479'), 
        ]);

        // Llama al TagsTableSeeder para crear las etiquetas
        $this->call(TagsTableSeeder::class);
    }
}
