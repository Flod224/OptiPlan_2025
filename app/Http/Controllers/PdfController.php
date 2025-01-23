<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

class PdfController extends Controller
{
    public function quittancePdf($data)
    {
        // Configurer les options pour Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Support HTML5
        $options->set('isPhpEnabled', true);        // Activer le PHP dans les vues Blade
        $options->set('chroot', realpath(''));      // Limiter l'accès aux fichiers
    
        // Instancier Dompdf avec les options configurées
        $dompdf = new Dompdf($options);
    
        // Charger la vue et injecter les données
        $html = view('Pdf.Quittance', $data)->render();
    
        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);
    
        // Définir la taille du papier (personnalisée ou A4)
        $dompdf->setPaper('A4', 'portrait'); // A4 en orientation portrait
    
        // Générer le PDF
        $dompdf->render();
    
        // Retourner le contenu binaire du PDF
        return $dompdf->output();
    }
    


    public function invitation($data)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $nomProf = $data[0];
        $prenomProf = $data[1];
        $sexe = $data[2];
        $month = strtolower($data[3]);
        $year = $data[4];

        $html = view('Pdf.Invitation', compact('nomProf','prenomProf','sexe', 'month', 'year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        // $dompdf->stream('invit.pdf', array('Attachment' => 0));

        return $dompdf->output();
    }
    public function preSoutenancePdf($idSess, $type, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.Pre_soutenance', compact('soutenancesGroupedByExaminateurPresident', 'filieresParExaminateurPresident', 'value', 'month', 'year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';

        $dompdf->render();
        return $dompdf->stream($filename);

    }
    public function preSoutenancePdfAvecJury($idSess, $type, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.Pre_soutenanceJury', compact('soutenancesGroupedByExaminateurPresident', 'filieresParExaminateurPresident', 'value', 'month', 'year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';
        // $dompdf->stream($filename, array('Attachment' => 0));

        $dompdf->render();

        return $dompdf->stream($filename);

    }
    public function preSoutenancePdfEns($idSess, $type, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.Pre_soutenanceJury', compact('soutenancesGroupedByExaminateurPresident', 'filieresParExaminateurPresident', 'value', 'month', 'year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';

        $dompdf->render();

        return $dompdf->output();

    }
    public function preSoutenancePdfEtu($idSess, $type, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.Pre_soutenance', compact('soutenancesGroupedByExaminateurPresident', 'filieresParExaminateurPresident', 'value', 'month', 'year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';

        $dompdf->render();

        return $dompdf->stream($filename);

    }
    public function soutenancePdfAvecJury($idSess, $type, $soutenances, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.SoutenanceJury', compact('idSess','type','soutenances','value','month','year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';

        $dompdf->render();

        return $dompdf->stream($filename);

    }
    public function soutenancePdf($idSess, $type, $soutenances, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.Soutenance', compact('idSess','type','soutenances','value','month','year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';

        $dompdf->render();

        return $dompdf->stream($filename);

    }
    public function soutenancePdfEns($idSess, $type, $soutenances, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.SoutenanceJury', compact('idSess','type','soutenances','value','month','year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';

        $dompdf->render();

        return $dompdf->output();

    }
    public function soutenancePdfEtu($idSess, $type, $soutenances, $value, $month, $year)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.Soutenance', compact('idSess','type','soutenances','value','month','year'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $type === 'pre' ? 'Présoutenance' : 'Soutenance';
        $filename .= '_' . $month . '_' . $year . '.pdf';

        $dompdf->render();

        return $dompdf->output();

    }
    public function pgDetaillePdf($professeurs, $salles, $horaires, $session, $nombreDeJours, $programmation)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.PgDetaille', compact('professeurs', 'salles', 'horaires', 'session', 'nombreDeJours','programmation'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Programme_detaille_des_soutenances.pdf';

        $dompdf->render();

        return $dompdf->stream($filename);

    }
    public function pgEnsPdf($professeurs, $salles, $horaires, $session, $nombreDeJours, $programmation)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.PgByEns', compact('professeurs', 'salles', 'horaires', 'session', 'nombreDeJours','programmation'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Programme_des_soutenances_par_enseignant.pdf';
        // $dompdf->stream($filename, array('Attachment' => 0));

        $dompdf->render();

        return $dompdf->stream($filename);

    }

    public function pgSallePdf($salles, $horaires, $session, $nombreDeJours, $programmation)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.PgByRooms', compact('salles', 'horaires', 'session', 'nombreDeJours','programmation'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Programme_des_soutenances_par_salle.pdf';
        // $dompdf->stream($filename, array('Attachment' => 0));

        $dompdf->render();

        return $dompdf->stream($filename);

    }
}
