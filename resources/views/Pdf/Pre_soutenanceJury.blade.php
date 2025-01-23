<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />
    <title>Programme des pré-soutenances avec jury</title>
    <style>
        header {
            display: flex;
            justify-content: center;
            gap: 1cm;
        }
        .textSection {
            text-align: center;
        }
        .logo {
            margin-top: 1%;
            position: relative;
        }
        .logo1 {
            float: right;
            position: absolute;
            margin-top: -5cm;
        }
        .logo img {
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
        th {
            text-align: center;
            height: 1cm;
            border: 1px solid #000;
            font-size: 10px;
        }
        td {
            height: 1.5cm;
            border: 1px solid #000;
            font-size: 10px;
            padding: 10px;
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
        li {
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
</head>
<body>
    <header id="header">
        <div class="logo">
            <img style="height: 4em;" src="{{ public_path('logo_uac.png') }}" alt="Logo UAC">
        </div>
        <div class="textSection">
            <h6>INSTITUT DE FORMATION ET DE RECHERCHE EN INFORMATIQUE DE L'UNIVERSITÉ D'ABOMEY-CALAVI <br><br> ************ <br><br> <h5>{{ $value }} DE MEMOIRES DE LICENCE SESSION DE {{ $month }} {{ $year }} AVEC JURY</h5></h6>
        </div>
        <div class="logo logo1">
            <img src="{{ public_path('ifri1_logo.png') }}" alt="Logo IFRI">
        </div>
    </header>
    {{-- <div class="watermark">
        DefenseScheduler
    </div> --}}
    <main>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Jury</th>
                    {{-- <th>Nom & Prénoms</th> --}}
                    <th>Spécialité</th>
                    <th>Date & Horaire</th>
                    <th>Salle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($soutenancesGroupedByExaminateurPresident as $examinateurPresident => $soutenancesExaminateurPresident)
                    <tr>
                        <td>
                            Président : 
                            @switch($filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['grade'])
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
                                    M. 
                            @endswitch
                            {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['prenom'] }} {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['nom'] }}<br>
                            Examinateur :
                            @switch($filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['grade'])
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
                                    M. 
                            @endswitch
                            {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['prenom'] }} {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['nom'] }} <br>
                        </td>
                        {{-- <td> --}}
                            @foreach ($soutenancesExaminateurPresident as $soutenance)
                                {{-- -{{ $soutenance->etudiant->users->nom }} {{ $soutenance->etudiant->users->prenom }} <br> --}}
                            @endforeach
                        {{-- </td> --}}
                        <td>
                            @php
                                $filieres = $filieresParExaminateurPresident[$examinateurPresident]['filieres']->implode(' ; ');
                                $niveaux_etude = $filieresParExaminateurPresident[$examinateurPresident]['niveau_etude']->implode(' ; ');
                                // if($niveaux_etude === 'Licence'){
                                //     $niveaux_etude = 'LP';
                                // } else if($niveaux_etude === 'Master') {
                                //     $niveaux_etude = 'MP';
                                // }
                                // $filieres_et_niveaux = $niveaux_etude . ' - ' . $filieres;
                                $filieres_et_niveaux = $filieres;
                            @endphp

                            {{ $filieres_et_niveaux }}
                        </td>                        
                        <td>
                            {{ \Carbon\Carbon::parse($soutenancesExaminateurPresident->first()->jour)->format('d/m/Y') }} <br><br>
                            @if ($soutenance->horaire->nom == "H1")
                            08H - 13H
                            @else
                            13H - 18H
                            @endif
                        </td>
                        <td>{{ $soutenancesExaminateurPresident->first()->salle->nom }}</td>
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
