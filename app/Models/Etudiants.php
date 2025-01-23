<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Etudiants extends Authenticatable
{
    protected $table = 'etudiants';
    use Notifiable;

    protected $fillable = [
        'user_id',
        'niveau_etude',
        'filiere',
        'speciality_id',
        'birthday',
        'file',
        'theme',
        'maitre_memoire',
        'sendmail',
        'mail_prof',
        'confirm_prof',
        'is_ready',
    ];

    /**
     * Boot function to automatically generate UUIDs.
     */
    public function professeur()
    {
        return $this->belongsTo(Professeurs::class, 'maitre_memoire', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function specialities()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id', 'id');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Génération de l'UUID si l'id est vide
            }
        });
    }
    public function soutenances()
    {
        return $this->hasMany(Soutenance::class, 'etudiant_id');
    }

    public $incrementing = false;
    protected $keyType = 'string'; // Utiliser UUID comme clé primaire

}
