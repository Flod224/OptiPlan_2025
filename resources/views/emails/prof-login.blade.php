<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Vos informations de connexion</title>
</head>
<body>
    <p>Bienvenue, cher(e) enseignant(e) {{ $nom }} {{ $prenom }},</p>

    <p>Voici vos informations de connexion :</p>
    <p>Adresse e-mail : {{ $email }}</p>
    <p>Mot de passe : <strong>{{ $password }}</strong></p>

    <p>Veuillez conserver votre mot de passe en toute sécurité. Ne le partagez pas avec d'autres personnes.</p>

    <p>Vous pouvez utiliser ces informations pour accéder à la plateforme DefenseScheduler et gérer vos responsabilités académiques.</p>

    <p>Merci et bonne journée !</p>
</body>
</html>