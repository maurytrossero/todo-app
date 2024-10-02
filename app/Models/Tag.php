<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Si deseas definir el nombre de la tabla
    protected $table = 'tags';

    // Definir los campos que son asignables en masa
    protected $fillable = ['name'];

    // Relación de una tag a muchas notas
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    }
