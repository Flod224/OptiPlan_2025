<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à la Soutenance de Thèse</title>
    <style>
        body {
          font-family: 'Arial', sans-serif;
          margin: 40px;
          font-size: 12px;
        }
      
        .invitation {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            position: relative;
        }
        
        .date {
            text-align: right;
            margin-bottom: 20px;
            padding-right: 15px;
    
        }
        
        .content, .closing {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .subject {
            font-weight: bold;
            margin-top: 1cm;
            padding: 15px;
    
        }
        
        .content {
            text-align: justify;
        }
        
        strong {
            font-weight: bold;
        }
      
    </style>
</head>

<body>
  <div class="invitation">
    <div>
      <img style="width: 100%;" src={{ public_path('entete.jpeg') }} alt="">
    </div>
    <br><br>
    <?php
        use Carbon\Carbon;
        Carbon::setLocale('fr');
        $date = Carbon::now()->translatedFormat('d F Y');
    ?>

    <p class="date">Abomey-Calavi, le <strong>{{ $date }}</strong></p>
    
    <div style="display: flex; justify-content: center; justify-items: center; margin-left: 8cm;">
      <p class="recipient">
        <strong>Le Directeur Adjoint,</strong><br>
        Chargé des Affaires Académiques<br><br>
        <strong>A</strong><br>
        {{$sexe}} {{$prenomProf}} {{$nomProf}}<br>
      </p>
    </div>
    
    
    <p class="subject"><strong><u>Objet :</u></strong> Invitation aux soutenances de la vague de {{$month}} {{$year}}</p>
    
    <p class="content">
        {{$sexe}} {{$prenomProf}} {{$nomProf}}, <br><br>
        J'ai l'honneur de porter à votre connaissance que vous êtes retenu(e) comme membre du jury de soutenances de mémoire de Licence à l'Institut de Formation et de Recherche en Informatique(IFRI) de l'Université d'Abomey-Calavi. <br><br>
        Ces soutenances auront lieu du <strong>lundi 24 au vendredi 28 {{$month}} {{$year}} </strong>.<br><br>
        Par la présente, je vous invite à prendre part au jury de soutenances et vous remercie par avance de votre collaboration.
    </p>
    
    <p class="closing">
        Veuillez agréer, {{$sexe}} {{$prenomProf}} {{$nomProf}}, l'expression de nos meilleurs sentiments.<br><br>
    </p>

    <p style="padding: 15px; font-size: 10px; font-weight: bold;">
        PJ : 
        <ul style="font-size: 10px;">
          {{-- <li>
              programme des pré-soutenances
          </li> --}}
          <li>
              documents de mémoire
          </li>
        </ul>
         
    </p>
    
    <p style="margin-top: 100px; font-size: 12px; margin-bottom: 55px; margin-left: 400px; margin-right: 25px;">Professeur Gaston EDAH</p>
    <div style="margin-left: 20%;">
        <img src={{ public_path('drapeau.png') }} alt="">
    </div>
  </div>
</body>
</html>
