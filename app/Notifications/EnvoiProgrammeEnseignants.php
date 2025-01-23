<?php

namespace App\Notifications;

use App\Http\Controllers\PdfController;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnvoiProgrammeEnseignants extends Notification
{
    use Queueable;
    public $type;
    public $month;
    public $soutenances;
    public $soutenancesGroupedByExaminateurPresident;
    public $filieresParExaminateurPresident;
    public $value;
    public $year;
    public $session;
    public $nomProf;
    public $prenomProf;
    public $sexe;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $month, $soutenances, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $year ,$session, $nomProf, $prenomProf, $sexe)
    {
        $this->type = $type;
        $this->month = $month;
        $this->soutenances = $soutenances;
        $this->soutenancesGroupedByExaminateurPresident = $soutenancesGroupedByExaminateurPresident;
        $this->filieresParExaminateurPresident = $filieresParExaminateurPresident;
        $this->value = $value;
        $this->year = $year;
        $this->session = $session;
        $this->nomProf = $nomProf;
        $this->prenomProf = $prenomProf;
        $this->sexe = $sexe;
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
            $invitation = $programme->invitation([$this->nomProf, $this->prenomProf, $this->sexe, $this->month, $this->year]);
            $pdfContent = $programme->preSoutenancePdfEns($this->session,$this->type,$this->soutenancesGroupedByExaminateurPresident,$this->filieresParExaminateurPresident,$this->value,$this->month,$this->year);
        } else
        {
            $invitation = $programme->invitation([$this->nomProf, $this->prenomProf, $this->sexe, $this->month, $this->year]);
            $pdfContent = $programme->soutenancePdfEns($this->session,$this->type,$this->soutenances,$this->value,$this->month,$this->year);
        }

        return (new MailMessage)
            ->subject('IFRI - UAC : '. $this->value . ' '. $this->month . ' '.$this->year )
            ->line('Mr / Mme')
            ->line('Merci de trouver ci dessous le programme pour les '. $this->value .' de ' . $this->month . ' ' . $this->year . '.')
            ->line('Cordialement ! ')
            ->line('DefenseScheduler, Service Scolarité & Examens (IFRI -UAC)')
            ->attachData($pdfContent, $this->value.'_'. $this->month .'_'. $this->year . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->attachData($invitation, 'Invitation.pdf', [
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
