<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfesseurLogin extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $nom;
    public $prenom;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param string $email
     * @param string $password
     */
    
}
