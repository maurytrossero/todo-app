<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // Define los atributos que se pueden asignar masivamente
    protected $fillable = [
        'user_id', // Asegúrate de incluir user_id si lo estás utilizando
        'title',
        'description',
        'due_date', // Campo adicional para la fecha de vencimiento
        'tag_id', // Añade tag_id aquí
        'image',    // Campo adicional para la imagen opcional
    ];

   //Relación muchos a muchos con el modelo Tag
   public function user()
{
    return $this->belongsTo(User::class);
}

    
    // Relación de muchas notas a una tag
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
