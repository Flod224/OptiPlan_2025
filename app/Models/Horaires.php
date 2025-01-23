<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Horaires extends Model
{
    // Les attributs qui peuvent être remplis massivement
    protected $fillable = [
        'nom',
        'debut',
        'fin',
    ];

    /**
     * Fonction boot pour générer automatiquement des UUID.
     */
    protected static function boot()
    {
        parent::boot();

        // Générer un UUID lorsque l'enregistrement est créé
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Génération de l'UUID si l'id est vide
            }
        });
    }

    // Désactiver l'auto-incrémentation des identifiants (car on utilise des UUID)
    public $incrementing = false;

    // Indiquer que la clé primaire est de type chaîne
    protected $keyType = 'string'; // UUID est une chaîne de caractères
}
