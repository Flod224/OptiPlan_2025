<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Soutenance;
use App\Models\AvailabilityTeachers;
use App\Models\AvailabilityRooms;
 
class Sessions extends Model
{
    protected $fillable = [
        'nom',
        'session_start_PreSout',
        'session_end_PreSout',
        'session_start_Sout',
        'session_end_Sout',
        'nb_soutenance_max_prof',
        'grademin_licence',
        'grademin_master',
    ];
 
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
    public function soutenances()
{
    return $this->hasMany(Soutenance::class, 'session_id');
}
public function rooms()
{
    return $this->hasMany(AvailabilityRooms::class, 'session_id');
}
public function teachers()
{
    return $this->hasMany(AvailabilityTeachers::class, 'session_id');
}
 
    public $incrementing = false; // Désactiver l'incrémentation automatique
    protected $keyType = 'string'; // Spécifier que la clé primaire est une chaîne
}
