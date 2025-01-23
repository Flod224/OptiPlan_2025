<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;//

class Professeurs extends Model
{
    use Notifiable;
    use HasFactory;
    

    protected $fillable = [
        'user_id',
        'grade',
        'specialities_ids', // Ajout de la nouvelle colonne
    ];

    /**
     * Relation plusieurs-à-plusieurs avec Specialities
     */
    public function specialities()
    {
        return $this->belongsToMany(Speciality::class, 'professeur_specialite', 'professeur_id', 'speciality_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Accesseur pour récupérer les IDs des spécialités sous forme de tableau
    public function getSpecialitiesIdsAttribute($value)
    {
        return json_decode($value, true); // Décode le JSON en tableau PHP
    }

    // Mutateur pour enregistrer les IDs des spécialités sous forme de JSON
    public function setSpecialitiesIdsAttribute($value)
    {
        $this->attributes['specialities_ids'] = json_encode($value); // Encode le tableau en JSON
    }
    /**
     * Relation avec le modèle `Grades`.
     */
    public function grade()
    {
        return $this->hasOne(Grades::class, 'grade','id');
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
