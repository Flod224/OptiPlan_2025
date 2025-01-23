<?php

namespace App\Notifications;

use App\Http\Controllers\PdfController;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnvoiProgrammeStudents extends Notification
{
    use Queueable;

    public $lienWhatsapp;
    public $type;
    public $month;
    public $soutenances;
    public $soutenancesGroupedByExaminateurPresident;
    public $filieresParExaminateurPresident;
    public $value;
    public $year;
    public $session;

    /**
     * Create a new notification instance.
     */
    public function __construct($lienWhatsapp, $type, $month, $soutenances, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $year ,$session)
    {
        $this->lienWhatsapp = $lienWhatsapp;
        $this->type = $type;
        $this->month = $month;
        $this->soutenances = $soutenances;
        $this->soutenancesGroupedByExaminateurPresident = $soutenancesGroupedByExaminateurPresident;
        $this->filieresParExaminateurPresident = $filieresParExaminateurPresident;
        $this->value = $value;
        $this->year = $year;
        $this->session = $session;
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
        $programme = new PdfController();
        if($this->type === "pre")
        {
            $pdfContent = $programme->preSoutenancePdfEtu($this->session,$this->type,$this->soutenancesGroupedByExaminateurPresident,$this->filieresParExaminateurPresident,$this->value,$this->month,$this->year);
        } else
        {
            $pdfContent = $programme->soutenancePdfEtu($this->session,$this->type,$this->soutenances,$this->value,$this->month,$this->year);
        }

        return (new MailMessage)
            ->subject('IFRI - UAC : '. $this->value . ' '. $this->month . ' '.$this->year )
            ->line('Mr / Mme')
            ->line('Merci de trouver ci dessous le lien destiné au groupe whatsapp des étudiants programmés pour les '. $this->value .' de ' . $this->month . ' ' . $this->year . '. Ce groupe a été créé afin de faciliter les échanges avec les étudiants et la scolarité.')
            ->line('Lien WhatsApp : '. $this->lienWhatsapp)
            ->line('NB: Ce lien est personnel et strictement réservé aux étudiants ayant déposés leurs dossiers et autorisés pour les soutenances de la session de ' . $this->month . ' ' . $this->year .'.')
            ->line('Cordialement ! ')
            ->line('DefenseScheduler, Service Scolarité & Examens (IFRI -UAC)')
            ->attachData($pdfContent, $this->value.'_'. $this->month .'_'. $this->year . '.pdf', [
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
