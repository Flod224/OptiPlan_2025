<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeachersDispoMail extends Notification
{
    use Queueable;

    public $nomProf;
    public $prenomProf;
    public $nameSession;
    public $typeSout;
    public $jours ;

    /**
     * Create a new notification instance.
     */
    public function __construct($nomProf, $prenomProf, $nameSession, $typeSout, $jours)
    {
        $this->nomProf = $nomProf;
        $this->prenomProf = $prenomProf;
        $this->nameSession = $nameSession;
        $this->typeSout = $typeSout;
        $this->jours = $jours;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('DefenseScheduler')
            ->line('Bonjour cher(e) ' . $this->prenomProf . ' ' . $this->nomProf . ',')
            ->line('Nous aimerions bien connaître votre disponibilité pour la vague de '.$this->typeSout. '( '.$this->nameSession.' ) qui se déroulera les '.$this->jours)
            ->line('Veuillez contacter le Directeur Adjoint de l\'Institut de Formation et de Recherche en Informatique(IFRI) pour lui communiquer vos disponibilités');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
