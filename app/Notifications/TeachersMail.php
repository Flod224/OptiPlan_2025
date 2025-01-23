<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeachersMail extends Notification
{
    use Queueable;

    public $nomProf;
    public $prenomProf;
    public $nomStudent;
    public $prenomStudent;
    public $theme;
    public $emailProf;

    /**
     * Create a new notification instance.
     */
    public function __construct($nomProf, $prenomProf, $nomStudent, $prenomStudent, $theme)
    {
        $this->nomProf = $nomProf;
        $this->prenomProf = $prenomProf;
        $this->nomStudent = $nomStudent;
        $this->prenomStudent = $prenomStudent;
        $this->theme = $theme;
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
            ->line('Nous tenons à vous informer que l\'étudiant '. $this->nomStudent .' ' . $this->prenomStudent . ' travaillant sur le thème '. $this->theme . ' vous a désigné comme étant son maitre mémoire. ')
            ->line('Aucune action n\'est exigée de votre part')
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
            // Vous pouvez ajouter ici d'autres données si nécessaire
        ];
    }
}
