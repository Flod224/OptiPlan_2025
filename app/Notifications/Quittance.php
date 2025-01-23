<?php

namespace App\Notifications;

use App\Http\Controllers\PdfController;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Quittance extends Notification
{
    use Queueable;

    public $nomStudent;
    public $prenomStudent;
    public $matricule;
    public $niveau_etude;
    public $filiere;
    public $theme;
    public $qrcode;

    /**
     * Create a new notification instance.
     */
    public function __construct($nomStudent, $prenomStudent, $matricule, $theme, $filiere, $niveau_etude, $qrcode)
    {
        $this->nomStudent = $nomStudent;
        $this->prenomStudent = $prenomStudent;
        $this->matricule = $matricule;
        $this->theme = $theme;
        $this->filiere = $filiere;
        $this->niveau_etude = $niveau_etude;
        $this->qrcode = $qrcode;
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
        $quittance = new PdfController();
        $pdfContent = $quittance->quittancePdf([
            'nomStudent' => $this->nomStudent,
            'prenomStudent' => $this->prenomStudent,
            'matricule' => $this->matricule,
            'theme' => $this->theme,
            'filiere' => $this->filiere,
            'niveau_etude' => $this->niveau_etude,
            'qrcode' => $this->qrcode,
        ]);

        return (new MailMessage)
            ->subject('Confirmation de dépôt de mémoire')
            ->line('Bonjour cher(e) ' . $this->prenomStudent . ' ' . $this->nomStudent . ',')
            ->line('Votre mémoire a été déposé avec succès sur notre plateforme.')
            ->line('Veuillez télécharger le fichier ci-joint qui sera ajouter à votre dossier lors du dépôt physique du mémoire')
            ->attachData($pdfContent, $this->prenomStudent.'_'. $this->nomStudent . '.pdf', [
                'mime' => 'application/pdf',
             ]);
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
