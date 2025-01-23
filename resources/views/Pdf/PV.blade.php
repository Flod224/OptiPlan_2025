<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation Enseignant</title>
    <style>
        body {
            margin-top: 10px;
            padding: 20px 20px 0px 20px;
        }
        
        header{
            display: flex;
            justify-content: center;
            gap: 1cm;
        }
        
        .logo{
            margin-top: 1%;
            position: relative;
        }

        .logo1 {
            float: right;
            position: absolute;
            margin-top: -1.1cm;
        }
        .logo img{
            height: 3rem;
        }

        .header-text {
            text-align: center;
            margin-top: -3cm;
        }
        
        .header-text h1 {
            font-size: 13px;
            font-weight: normal;
            margin: 0;
        }
        
        .header-text h2 {
            font-size: 13px;
            font-weight: normal;
            margin: 0;
        }
        
        .header-text p {
            font-size: 13px;
            margin: 0;
        }
        
        .content {
            margin: 20px 0 5px 0;
        }
        
        .content h3,.content h4 {
            font-size: 16px;
            text-align: center;
            font-weight: 600;
        }
        
        .content p {
            margin: 10px 0;
            font-size: 14px;
        }
        
        .appreciations p{
            line-height: 2;
        }

        .signatures-table {
            width: 100%;
            margin-top: 100px;
            margin-left: 0.65cm;
            border-collapse: collapse;
        }
        .signatures-table td {
            width: 33.33%;
            text-align: center;
            font-size: 13px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <header id="header">
        <div class="logo">
            <img style="height: 4em;" src="{{ public_path('logo_uac.png') }}" alt="Logo UAC">
        </div>
        <div class="header-text">
            <h1>UNIVERSITÉ D’ABOMEY-CALAVI</h1>
            <h2>INSTITUT DE FORMATION ET DE RECHERCHE EN INFORMATIQUE</h2>
            <p>BP 526 Cotonou Tel: 21 14 19 88</p>
        </div>
        <div class="logo logo1">
            <img src="{{ public_path('ifri1_logo.png') }}" alt="Logo IFRI">
        </div>
    </header>

    <div class="content">
        <br>
        <h3>PROCES VERBAL DE SOUTENANCE DE LICENCE PROFESSIONNELLE</h3>
        <p>Date : {{ $date }}</p>
        <p>Nom et prénoms du candidat : {{ $nomPrenom }}</p>
        <p>Date et lieu de naissance : {{ $dateLieuNaissance }}</p>
        <p>Numéro matricule : {{ $numMatricule }}</p>
        <p>Spécialité : {{ $specialite }}</p>
        <p>Promotion : {{ $promotion }}</p>
        <p>Tel : {{ $tel }}</p>
        <p>Thème : {{ $theme }}</p><br>

        <h4>APPRECIATIONS/SUGGESTIONS/RECOMMANDATIONS/NOTE SUR 20</h4>
        <div class="appreciations">
            <p>
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                ………………………………………………………………………………………………………………………………
                <br>Ont signé (nom et qualité dans le jury)
            </p>
        </div>
        
        <table class="signatures-table">
            <tr>
                <td>{{$examinateur}} <br>(Examinateur)</td>
                <td>{{$president}} <br>(Président)</td>
                <td>{{$rapporteur}} <br>(Rapporteur)</td>
            </tr>
        </table>
    </div>
</body>
</html>
