<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Salles extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'localisation',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Génération de l'UUID
            }
        });
    }

    public $incrementing = false; // Désactiver l'incrémentation automatique
    protected $keyType = 'string'; // Spécifier que la clé primaire est une chaîne
}
