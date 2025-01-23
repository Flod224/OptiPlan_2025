<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AvailabilityTeachers extends Model
{
    protected $table = 'availabilityTeachers';
    protected $fillable = [
        'jour',
        'horaire_id',
        'prof_id',
        'session_id',
        'type_soutenance',
    ];

    // Relation avec les professeurs
    public function professeur()
    {
        return $this->belongsTo(Professeurs::class, 'prof_id', 'id');
    }

     /**
     * Relation avec le modèle `Sessions`.
     */
    public function session()
    {
        return $this->belongsTo(Sessions::class, 'session_id', 'id');
    }

    /**
     * Relation avec `Horaires`.
     */
    public function horaires()
    {
        return $this->belongsTo(Horaires::class,'horaire_id', 'id');
    }
     /**
     * Boot function to automatically generate UUIDs.
     */
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

