<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />
    <title>Programme détaillé des soutenances </title>
</head>
<style>

    header{
        display: flex;
        justify-content: center;
        gap: 1cm;
    }

    .textSection{
        margin-top: -5%;
        text-align: center;
        font-size: 10px;
    }
    .logo{
        margin-top: 1%;
        position: relative;
    }
    .logo1 {
        float: right;
        position: absolute;
        margin-top: -4.5cm;
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
        height: 0.5cm;
        text-align: center;
        border: 1px solid #000;
        font-size: 10px;
    }
    td{
        height: 0.75cm;
        border: 1px solid #000;
        text-align: center;
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
            <img src={{ public_path("logo_uac.png") }} alt="logo_uac" />
        </div>

        <div class="textSection">
            <h5>RÉPUBLIQUE DU BÉNIN</h5>
            <h5>MINISTÈRE DE L'ENSEIGNEMENT SUPÉRIEUR ET DE LA RECHERCHE SCIENTIFIQUE</h5>
            <h5>UNIVERSITÉ D'ABOMEY - CALAVI </h5>

            <h5> INSTITUT DE FORMATON ET DE RECHERCHE EN INFORMATIQUE </h5>
            <h6>BP 526 Cotonou Tel : +229 55 023 070 / 53 973 080 </h6>
            <h6><a href="">htpps://www.ifri-uac.bj</a> Courriel : <a href="">contact@ifri.uac.bj</a></h6>

        </div>

        <div class="logo logo1">
            <img src={{public_path("ifri1_logo.png")}} alt="logo_ifri" />
        </div>
    </header>
    <br>

    {{-- <div class="watermark">
        <p>DefenseScheduler</p>
    </div> --}}
    <main>
        @php
            use Carbon\Carbon;
        @endphp

        <table class="content-table" aria-describedby="infos">
            <thead>
                <tr>
                    <th rowspan="2"> N° </th>
                    <th rowspan="2"> Nom & Prénoms (Enseignants) </th>
                    @for ($i = 1; $i <= $nombreDeJours; $i++)
                        <th colspan="10">Jour {{ $i }}</th>
                    @endfor
                </tr>
                <tr>
                    @for ($i = 1; $i <= $nombreDeJours; $i++)
                        @for ($j = 1; $j <= 10; $j++)
                            <th>H{{ $j }}</th>
                        @endfor
                    @endfor
                </tr>
            </thead>
            <tbody>
            
                @foreach($professeurs as $profs)
                    <tr>
                        <td> {{$loop->iteration}} </td>
                        <td>
                            @switch($profs->gradeProfesseur->nom)
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
                                    {{$profs->gradeProfesseur->nom ?? 'M. '}}
                            @endswitch
                            {{$profs->nom}} {{$profs->prenom}}
                        </td>
                        @php
                            $sessionStart = Carbon::parse($session->session_start);
                        @endphp
                        @for ($i = 1; $i <= $nombreDeJours; $i++)
                            @for ($j = 1; $j <= 10; $j++)
                                <td>
                                    @php
                                        $found = false;
                                        $profId = $profs->id;
                                    @endphp
                                    @if(isset($programmation[$profId]) && isset($programmation[$profId]['programmation']))
                                        @foreach($programmation[$profId]['programmation'] as $programme)
                                            @if($programme['jour'] == $sessionStart->copy()->addDays($i - 1)->format('Y-m-d') && $programme['heure'] == "H$j")
                                                @php
                                                    $salleNom = $programme['salle'];
                                                    $salleId = $programme['salleId'];
                                                @endphp
                                                {{'S' . $salleId }}
                                                @php
                                                    $found = true;
                                                @endphp
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                    @unless($found)
                                        X
                                    @endunless
                                </td>
                            @endfor
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        <br><br>
        <br><br>
        Légendes :
        <ul>
            @foreach($salles as $salle)
            <li>
                S{{$salle->id}} => {{$salle->nom}}
            </li>
            @endforeach
            @foreach($horaires as $horaire)
            <li>
                {{$horaire->nom}} => {{$horaire->debut}} - {{$horaire->fin}}
            </li>
            @endforeach
        </ul>
        
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
