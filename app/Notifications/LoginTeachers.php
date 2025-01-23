<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginTeachers extends Notification
{
    use Queueable;

    public $email;
    public $nom;
    public $prenom;
    public $password;
    /**
     * Create a new notification instance.
     */
    public function __construct($nom, $prenom, $email, $password)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
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
    public function toMail(object $notifiable): MailMessage
    {
        $motDePasse = $this->password;

        $url = url('/');

        return (new MailMessage)
            ->subject('Vos informations de connexion à la plateforme DefenseScheduler')
            ->line('Bonjour cher(e) ' . $this->prenom . ' ' . $this->nom . ',')
            ->line('Voici vos informations de connexion :')
            ->line('Adresse e-mail : ' . $this->email)
            ->line('Mot de passe : ' . $motDePasse)
            ->line('Vous pouvez utiliser ces informations pour vous connecter à la plateforme ')
            ->action('DefenseScheduler', $url)
            ->line('Pensez à le modifier une fois connecté.')
            ->line('Merci et bonne journée !');
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
