<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />
    <title>Programme des Soutenances</title>
</head>
<style>

    header{
        display: flex;
        justify-content: center;
        gap: 1cm;
    }

    .textSection{
        text-align: center;
    }
    .logo{
        margin-top: 1%;
        position: relative;
    }
    .logo1 {
        float: right;
        position: absolute;
        margin-top: -5cm;
    }
    .logo img{
        height: 3rem;
    }
    main {
        display: flex;
        justify-content: center;
    }
    .content-table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
        border: 1px solid #000;
    }
    th{
        text-align: center;
        height: 1cm;
        border: 1px solid #000;
        font-size: 10px;
    }
    td{
        height: 1.5cm;
        border: 1px solid #000;
        padding: : 15px;
        font-size: 10px;
    }

    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-25deg);
        opacity: 0.3;
        font-size: 65px;
        color: black;
        letter-spacing: .4cm;
        z-index: -1;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    li{
        list-style: none;
        margin-bottom: 5px;
    }
    @page {
        margin: 50px;
    }
    body {
        margin: 0;
        padding: 0;
        counter-reset: page;
    }

</style>
<body>
    <header>
        <div class="logo">
            <img style="height: 4em;" alt="" src="{{ public_path("logo_uac.png") }}">
        </div>

        <div class="textSection">
            <h6> INSTITUT DE FORMATON ET DE RECHERCHE EN INFORMATIQUE DE L'UNIVERSITÉ D'ABOMEY-CALAVI <br><br> ************ <br><br> <h5> {{ $value }} DE MEMOIRES DE LICENCE SESSION DE {{ $month }} {{ $year }} </h5></h6>
        </div>
        
        <div class="logo logo1">
            <img alt="" src="{{ public_path("ifri1_logo.png") }}">
        </div>
    </header>

    {{-- <div class="watermark">
        <p>DefenseScheduler</p>
    </div> --}}
    <main>

        <table class="content-table" aria-describedby="infos">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Matricule</th>
                    <th>Nom & Prénoms / Thème </th>
                    <th>Grade <br> Spécialité</th>
                    <th>Date - Horaire -<br> Salle</th>
                    <th>Encadreur</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($soutenances as $index => $soutenance)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $soutenance->etudiant->users->matricule }}</td>
                        <td>{{ $soutenance->etudiant->users->nom }} {{ $soutenance->etudiant->users->prenom }} <br> <br> <u>Thème:</u> {{ $soutenance->etudiant->theme }}</td>
                        <td>
                            @switch($soutenance->etudiant->niveau_etude)
                                @case('Licence')
                                    LP
                                    @break
                        
                                @case('Master')
                                    MP
                                    @break
                        
                                @default
                                    {{ $soutenance->etudiant->niveau_etude }}
                            @endswitch - {{ $soutenance->etudiant->filiere }}</td>
                        <td>
                            {{ ucfirst(\Carbon\Carbon::parse($soutenance->jour)->isoFormat('dddd D MMMM Y', 'Do MMMM Y')) }}
                            <br> 
                            @switch($soutenance->horaire->nom)
                                @case('H1')
                                    08H - 09H
                                    @break
                                @case('H2')
                                    09H - 10H
                                    @break
                                @case('H3')
                                    10H - 11H
                                    @break
                                @case('H4')
                                    11H - 12H
                                    @break
                                @case('H5')
                                    12H - 13H
                                    @break
                                @case('H6')
                                    13H - 14H
                                    @break
                                @case('H7')
                                    14H - 15H
                                    @break
                                @case('H8')
                                    15H - 16H
                                    @break
                                @case('H9')
                                    16H - 17H
                                    @break
                                @case('H10')
                                    17H - 18H
                                    @break
                                @default
                                    {{ $soutenance->horaire->nom }}
                            @endswitch
                            <br> 
                            {{ $soutenance->salle->nom }}
                        </td>
                        <td> 
                            @switch($soutenance->etudiant->professeur->gradeProfesseur->nom)
                                @case('Professeur')
                                    Prof.
                                    @break
                        
                                @case('Docteur')
                                    Dr
                                    @break

                                @case('Ingénieur')
                                    Ing.
                                    @break
                                @default
                                    {{$soutenance->etudiant->professeur->gradeProfesseur->nom ?? 'M. '}}
                            @endswitch
                            {{ $soutenance->etudiant->professeur->prenom }} {{ $soutenance->etudiant->professeur->nom }}</td>
                    </tr>
                @endforeach

            </tbody>

        </table>
    </main>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                if ($PAGE_COUNT > 1) {
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $size = 10;
                    $pageText = $PAGE_NUM . " / " . $PAGE_COUNT;
                    $pdf->text(555, 810, $pageText, $font, $size); // Position of "Page X of Y" at the bottom center
                }
            ');
        }
    </script>
</body>
</html>
