<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Grades extends Model
{
    protected $fillable = [
        'nom',
    ];

    public function professeurs()
{
    return $this->hasMany(Professeurs::class, 'grade');
}



}
