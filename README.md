<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



---

# Projet Laravel

Ce projet est une application web Laravel. Ce README vous guidera à travers l'installation, la configuration, et le démarrage de l'application.


## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Pinite37/DefenseSchedulerIFRI-optimaid.git
```

### 2. Installation de Laravel

####  Windows (Powershell)

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows'))
```
#### Linux

```bash
/bin/bash -c "$(curl -fsSL https://php.new/install/linux)"
```
#### MacOS

```bash
/bin/bash -c "$(curl -fsSL https://php.new/install/mac)"

```
Puis, redemarrer le terminal ou ouvrez un nouveau terminal puis taper

```bash
composer global require laravel/installer
```
### 3. Installer les dépendances
Allez dans le repertoire du projet et taper :

```bash
composer install
```

### 3. Configurer le fichier `.env`

Dans le fichier `.env`, configurez votre base de données. Par exemple, si vous utilisez MySQL, vous devez modifier ces lignes avec vos informations de base de données :

```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_bdd
DB_USERNAME=nom_utilisateur
DB_PASSWORD=mot_de_passe
```
NB :Ces informations sur la base de données  sont optionnelles pour démarrer l'application

#### Identifiants de connexion 
Les identifiants de connexion pour le superadmin se trouvent dans le fichier .env que vous pouvez modifier

```
SUPER_USER_NAME=admin
SUPER_USER_EMAIL=admin@example.com
SUPER_USER_PASSWORD=admin
SUPER_USER_MATRICULE=ADMIN007

```

Identifiants par defaut :

MAIL: admin@example.com
PASSWORD: admin

Après modification , taper la commande

```bash
php artisan db:seed
```


### 4. Générer la clé d'application

```bash
php artisan key:generate
```
## Base de données

### 1. Exécuter les migrations

Les migrations permettent de créer les tables nécessaires pour l'application dans la base de données.

```bash
php artisan migrate
```

### 2. Exécuter les seeders

Les seeders permettent de remplir la base de données avec des données initiales, comme la création d’un super utilisateur.

```bash
php artisan db:seed
```

## Démarrage de l'application

### 1. Démarrer le serveur de développement

Une fois l'installation terminée et la base de données configurée, lancez l'application avec la commande suivante :

```bash
php artisan serve
```

L'application sera disponible par défaut à l'adresse [http://localhost:8000](http://localhost:8000).


## Accéder à l'application

- **URL principale** : [http://localhost:8000](http://localhost:8000)
- **Compte Super Utilisateur** : Utilisez les identifiants créés via le seeder ou configurez-les manuellement dans la base de données.

## Tests

Pour exécuter les tests, utilisez la commande :

```bash
php artisan test
```

---

**Note :** Pour les environnements de production, vous devrez configurer un serveur web (Apache/Nginx) et ajuster les paramètres de production dans le fichier `.env`.

---

## Aide

Si vous rencontrez des problèmes, vérifiez la documentation officielle de [Laravel](https://laravel.com/docs) ou contactez l'administrateur du projet.

