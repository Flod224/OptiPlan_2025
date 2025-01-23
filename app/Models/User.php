<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'matricule',
        'sexe',
        'phone',
        'password',
        'changedPassword',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function etudiant()
    {
        return $this->hasOne(Etudiants::class, 'user_id');
    }
    public function professeur()
    {
        return $this->hasOne(Professeurs::class, 'user_id');
    }


    /**
     * Boot method for the model.
     * Automatically generate UUID for the id when creating a new user.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Génère un UUID unique
            }
        });
    }
    public $incrementing = false;
    protected $keyType = 'string'; // Utiliser UUID comme clé primaire

}

