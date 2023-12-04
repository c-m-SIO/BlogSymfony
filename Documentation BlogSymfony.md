# Documentation Installation Blog Symfony

## Sommaire
L'installation se fait en plusieurs étapes

- Apache
- Php
- Composer
- Déploiement


## Apache
Installer la dernière version de Apache2
```
sudo apt-get update
sudo apt-get install -y apache2
sudo systemctl enable apache2
```

## Php

Installer la version 8.2 de php et ses extensions (Ctype, iconv, PCRE, Session, SimpleXML, Tokenizer)

```sh
sudo dpkg -l | grep php | tee packages.txt

sudo apt install apt-transport-https lsb-release ca-certificates wget -y
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg 
sudo sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
sudo apt update

# Expand the curly braces with all extensions necessary.
sudo apt install php8.2 php8.2-cli php8.2-{bz2,mysql,curl,mbstring,intl}

sudo apt install libapache2-mod-php8.2
sudo apt install php8.2-fpm

sudo a2enconf php8.2-fpm

# When upgrading from older PHP version:
sudo a2disconf php8.1-fpm

## Remove old packages
sudo apt purge php8.1*
```





## Déploiement

### Téléchargement
Une fois tous les composants nécessaires installés, il ne reste plus qu'à déployer le projet.

Premièrement il faut télécharger le projet disponible sur github à l'adresse: ```https://github.com/c-m-SIO/blogSymfonyCours.git``` 

### Base de données
Ensuite il faut créer une base de données MariaDb en local (cours de cybersecu de 1ere année les mecs !!!).
Pour connecter la BDD au projet, il faut aller dans le fichier ```.env```, décommenter la ligne 28 et y insérer les bonnes informations:
```sh
DATABASE_URL="mysql://NomUtilisateur:MotDePasse@addresse:port/NomDelaBDD?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

### Redirection
Dernière étape du déploiement il faut rediriger l'url vers l'affichage du blog.
Pour cela, aller dans le fichier ``etc/apache2/sites-available`` et modifier le fichier ``000-default.conf``.
Ajouter le code:
```sh
    DocumentRoot Chemin_du_projet/public
    <Directory /chemin_du_projet/public>
        AllowOverride None
        Require all granted
        FallbackResource /index.php
    </Directory>
```
Lien de la documentation symfony (si besoin): ``https://symfony.com/doc/current/setup/web_server_configuration.html``.

## Composer
```sh
apt install wget php-cli php-xml php-zip php-mbstring unzip -y
wget -O composer-setup.php https://getcomposer.org/installer
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer --version
```
Dans le fichier du projet:
```sh
composer require
```

## Charger la base de données
Dans le fichier du projet, ouvrir un cmd et exécuter les commandes suivantes:
```sh
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

# Terminé !
> "Félicitations UwU"
![image](https://ih1.redbubble.net/image.985111156.7333/flat,750x,075,f-pad,750x1000,f8f8f8.jpg)


## Les commentaires des utilisateurs:
> "Une super documentation faite avec amour"
Lana Rhoades

> "Superbe documentation, très claire, on sent la passion"
Amouranth

> "Une documentation comme on n'en fait plus, à bon entendeur..."
Ludovic Mery
