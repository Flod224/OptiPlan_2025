<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planning de soutenance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Planning des soutenances pour la session {{ $session_id }}</h1>
    <table>
        <thead>
            <tr>
                <th>Jour</th>
                <th>Horaire</th>
                <th>Salle</th>
                <th>Type</th>
                <th>Etudiant</th>
                <th>Président</th>
                <th>Examinateur</th>
                <th>Rapporteur</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plannings as $planning)
                <tr>
                    <td>{{ $planning['jour'] }}</td>
                    <td>{{ $planning['horaire'] }}</td>
                    <td>{{ $planning['salle'] }}</td>
                    <td>{{ $planning['type'] }}</td>
                    <td>{{ $planning['etudiant'] }}</td>
                    <td>{{ $planning['jury']['president'] }}</td>
                    <td>{{ $planning['jury']['examinateur'] }}</td>
                    <td>{{ $planning['jury']['rapporteur'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
