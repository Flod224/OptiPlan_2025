<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jury extends Model
{
    protected $table = 'jury';
    protected $fillable = [
        'president',
        'examinateur',
        'rapporteur',
    ];
    
    public function presidents()
    {
        return $this->belongsTo(Professeurs::class, 'president', 'id');
    }
    public function examinateurs()
    {
        return $this->belongsTo(Professeurs::class, 'examinateur', 'id');
    }
    public function rapporteurs()
    {
        return $this->belongsTo(Professeurs::class, 'rapporteur', 'id');
    }
 

   
    
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
