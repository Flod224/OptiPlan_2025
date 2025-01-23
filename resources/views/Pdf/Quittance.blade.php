<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quittance</title>
</head>

<style>
  .bg{
    background-image: url('{{public_path("background.png")}}');
    padding: 0;
    margin: 0;
  }
  .corps {
    background: #F5F5F567;
    display: block;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 18cm;
    margin: 3cm auto;
    color: #001028;
    font-family: Arial, sans-serif;
    font-size: 12px;
    font-family: Arial;
    overflow: hidden;
  }
  header {
    padding: 10px 0;
    margin-bottom: 10px;
  }

  .optimaid {
    text-align: center;
    font-size: 50px;
    color: blue;
    opacity: 0.5;
  }

  h1 {
    border-top: 1px solid  #5D6975;
    border-bottom: 1px solid  #5D6975;
    color: #5D6975;
    font-size: 2.4em;
    line-height: 1.4em;
    font-weight: normal;
    text-align: center;
    margin: 0 0 20px 0;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
  }

  table tr:nth-child(2n-1) td {
    background: #F5F5F5;
  }


  table th {
    padding: 5px 20px;
    color: #5D6975;
    border-bottom: 1px solid #C1CED9;
    white-space: nowrap;        
    font-weight: bold;
  }

  table .infos {
    text-align: left;
  }

  table td {
    padding: 20px;
  }

  table td.infos {
    font-size: 0.8em;
    text-align: center;
  }



  footer {
    color: #5D6975;
    width: 100%;
    bottom: 0;
    border-top: 1px solid #C1CED9;
    padding: 8px 0;
    text-align: center;
  }

</style>

<body class="bg">
  <div class="corps">
    <div class="optimaid">DefenseScheduler</div>
  
    <header class="text">
      <h1>Confirmation de dépôt de dossier</h1>
    </header>

    <main>
        <table aria-describedby="infos">
          <thead>
            <tr>
              <th>Matricule</th>
              <th>Nom et Prénoms</th>
              <th>Cycle - Filière</th>
              <th>Thème</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="infos">{{$matricule}}</td>
              <td class="infos">{{$prenomStudent}} {{$nomStudent}}</td>
              <td class="infos">{{$niveau_etude}} - {{$filiere}}</td>
              <td class="infos">{{$theme}}</td>
            </tr>
          </tbody>
        </table>
    </main>

    <div class="qrcode" style="margin-left: 40%;">
      <img src="data:image/png;base64,{{ base64_encode($qrcode) }}" alt="Code QR">
    </div>
    
    <br>
    <footer>
        Fait le {{ date('Y-m-d') }} à {{ date('H:i:s') }}
    </footer>
          
  </div>
</body>
</html>