<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EtudiantLogin extends Mailable
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
    public function __construct($nom, $prenom, $email, $password)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Vos informations de connexion')
            ->view('emails.etudiant-login');
    }
}
