<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Vos informations de connexion</title>
</head>
<body>
    <p>Bienvenue, cher(e) {{ $nom }} {{ $prenom }},</p>

    <p>Voici vos informaions de connexion</p>
    <p>Adresse e-mail : {{ $email }}</p>
    <p>Mot de passe : <strong>{{ $password }}</strong></p>
    
    <p>Veuillez conserver votre mot de passe en toute sécurité. Ne le partagez pas avec d'autres personnes.</p>

    <p>Vous pouvez utiliser ces informations pour vous connecter à la plateforme DefenseScheduler. </p>

    <p>Merci et bonne journée !</p>
    
</body>
</html>
