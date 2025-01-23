<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Soutenance extends Model
{
    protected $table = 'soutenance';
    protected $fillable = [
        'jour',
        'state',
        'etudiant_id',
        'jury_id',
        'session_id',
        'horaire_id',
        'salle_id',
        'type',
      
    ];

    // Relation avec les étudiants
    public function etudiant()
    {
        return $this->belongsTo(Etudiants::class, 'etudiant_id', 'id');
    }

    // Relation avec le jury
    public function jury()
    {
        return $this->belongsTo(Jury::class, 'jury_id', 'id');
    }

    // Relation avec la session
    public function session()
    {
        return $this->belongsTo(Sessions::class, 'session_id', 'id');
    }

    // Relation avec l'horaire
    public function horaire()
    {
        return $this->belongsTo(Horaires::class, 'horaire_id', 'id');
    }

    // Relation avec la salle
    public function salle()
    {
        return $this->belongsTo(Salles::class, 'salle_id', 'id');
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
