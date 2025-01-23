<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />
    <title>Soutenances par salles </title>
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
        width: 1cm;
        text-align: center;
        border: 1px solid #000;
        font-size: 10px;
    }
    td{
        height: 0.75cm;
        border: 1px solid #000;
        text-align: center;
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
    .line-break {
        margin: 0;
        padding: 0;
    }
    .page-break {
        page-break-before: always;
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

    <main>
        @php
            use Carbon\Carbon;
        @endphp
        @foreach ($programmation as $salleData)
            <table class="content-table" aria-describedby="infos">
                <thead>
                    <tr>
                        <th>Salle</th>
                        <th>Jury</th>
                        <th>Jour et Heure</th>
                        <th>Etudiant & Thème</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salleData['soutenances'] as $soutenance)
                        <tr>
                            <td>{{ $salleData['salle'] }}</td>
                            <td>
                                @foreach (explode(', ', $soutenance['jury']) as $juryMember)
                                    <p class="line-break">{{ $juryMember }}</p>
                                @endforeach
                            </td>
                            <td>Jour: {{ Carbon::parse($soutenance['jour'])->translatedFormat('d F Y') }}<br>Heure: {{ $soutenance['heure'] }}</td>
                            <td>{{ $soutenance['etudiant'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <div class="page-break"></div>
        @endforeach
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
