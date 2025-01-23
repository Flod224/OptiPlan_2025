<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Barryvdh\DomPDF\Facade\PDF;  // Importer la façade PDF pour l'utilisation de DomPDF

class PlanningNotification extends Notification
{
    use Queueable;

    protected $planning;
    protected $type;
 

    // Le constructeur reçoit les données du planning, le type, le PDF et le nom de fichier
    public function __construct($planning, $type)
    {
        $this->planning = $planning;
        $this->type = $type;
      
    }

    public function via($notifiable)
    {
        return ['mail']; // Spécifiez les canaux de notification (ex. : 'mail', 'database', 'sms', etc.)
    }
    /**
     * La méthode de notification par e-mail.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
{
    $jury = $this->getJuryDetails();
    $mailMessage = new MailMessage();
    
    if ($notifiable->role == 0) { // Si l'utilisateur est un étudiant
        $mailMessage->subject('Détails de votre soutenance')
            ->greeting('Bonjour ' . $notifiable->nom)
            ->line('Voici les informations de votre soutenance pour le ' . $this->planning['jour'] . ' :')
            ->line('Horaire : ' . $this->planning['horaire'])
            ->line('Salle : ' . $this->planning['salle'])
            ->line('Type : ' . $this->planning['type'])
            ->line('Étudiant : ' . $this->planning['etudiant'])
            ->line('--------  Jury  --------')
            ->line('Président : ' . $jury['president'])
            ->line('Examinateur : ' . $jury['examinateur'])
            ->line('Rapporteur : ' . $jury['rapporteur'])
            ->line('Merci de vérifier les informations.');
    } else { // Si l'utilisateur est un professeur
        if (empty($notifiable->email)) {
            // Si l'email du professeur est vide, on ne tente pas l'envoi
            return $mailMessage->line('Email non valide pour l\'envoi de la notification.');
        }

        $mailMessage->subject('Planning de votre soutenance')
            ->greeting('Bonjour Madame/Monsieur ' . $notifiable->nom)
            ->line('Voici le planning de soutenance :');

        // Ajout du tableau HTML contenant le planning
        $mailMessage->line($this->generatePlanningTableHtml($this->planning))
            ->line('Merci pour votre participation.');
    }

    return $mailMessage;
}

    
    /**
     * Générer un tableau HTML pour afficher les détails du planning.
     *
     * @param array $plannings
     * @return string
     */
    protected function generatePlanningTableHtml($plannings)
    {
        $table = '<table border="1" style="border-collapse: collapse; width: 100%;">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th>Jour</th>';
        $table .= '<th>Horaire</th>';
        $table .= '<th>Salle</th>';
        $table .= '<th>Type</th>';
        $table .= '<th>Étudiant</th>';
        $table .= '<th>Président</th>';
        $table .= '<th>Examinateur</th>';
        $table .= '<th>Rapporteur</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        
        foreach ($plannings as $planning) {
            $jury = $this->getJuryDetails();
            $table .= '<tr>';
            $table .= '<td>' . ($planning['jour'] ?? 'Inconnu') . '</td>';
            $table .= '<td>' . ($planning['horaire'] ?? 'Inconnu') . '</td>';
            $table .= '<td>' . ($planning['salle'] ?? 'Inconnu') . '</td>';
            $table .= '<td>' . ($planning['type'] ?? 'Inconnu') . '</td>';
            $table .= '<td>' . ($planning['etudiant'] ?? 'Inconnu') . '</td>';
            $table .= '<td>' . $jury['president'] . '</td>';
            $table .= '<td>' . $jury['examinateur'] . '</td>';
            $table .= '<td>' . $jury['rapporteur'] . '</td>';
            $table .= '</tr>';
        }
    
        $table .= '</tbody>';
        $table .= '</table>';
    
        return $table;
    }
    
    

    /**
     * Récupérer les détails du jury (président, examinateur, rapporteur).
     *
     * @return array
     */
    protected function getJuryDetails()
    {
        $president = $this->getMemberName($this->planning['jury']['president']);
        $examinateur = $this->getMemberName($this->planning['jury']['examinateur']);
        $rapporteur = $this->getMemberName($this->planning['jury']['rapporteur']);

        return [
            'president' => $president,
            'examinateur' => $examinateur,
            'rapporteur' => $rapporteur,
        ];
    }

    /**
     * Récupérer le nom complet d'un membre du jury.
     *
     * @param  mixed  $juryMember
     * @return string
     */
    protected function getMemberName($juryMember)
    {
        if ($juryMember && isset($juryMember->user)) {
            return $juryMember->user->nom . ' ' . $juryMember->user->prenom;
        }

        return 'Inconnu'; // Si le membre n'est pas défini
    }

    /**
     * La méthode de notification par la base de données ou autre moyen (comme un tableau).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'planning' => $this->planning,
            'type' => $this->type,
        ];
    }
}
