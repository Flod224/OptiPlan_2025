<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Speciality extends Model
{
    use HasFactory;
    protected $tables ="specialities";

    protected $fillable = ['name'];

    /**
     * Relation avec les étudiants (Un étudiant a une spécialité).
     */
    public function students()
    {
        return $this->hasMany(Etudiants::class, 'speciality_id');
    }

    /**
     * Relation avec les enseignants (Un enseignant peut avoir plusieurs spécialités).
     */
  

    public function professeurs()
    {
        return $this->belongsToMany(Professeurs::class, 'professeur_specialite', 'speciality_id', 'professeur_id');
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
