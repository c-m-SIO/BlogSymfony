<h1 class="code-line" data-line-start=0 data-line-end=1 ><a id="Documentation_Installation_Blog_Symfony_0"></a>Documentation Installation Blog Symfony</h1>
<h2 class="code-line" data-line-start=2 data-line-end=3 ><a id="Sommaire_2"></a>Sommaire</h2>
<p class="has-line-data" data-line-start="3" data-line-end="4">L’installation se fait en plusieurs étapes</p>
<ul>
<li class="has-line-data" data-line-start="5" data-line-end="6">Apache</li>
<li class="has-line-data" data-line-start="6" data-line-end="7">Php</li>
<li class="has-line-data" data-line-start="7" data-line-end="8">Composer</li>
<li class="has-line-data" data-line-start="8" data-line-end="9">Déploiement</li>
</ul>
<h2 class="code-line" data-line-start=11 data-line-end=12 ><a id="Apache_11"></a>Apache</h2>
<p class="has-line-data" data-line-start="12" data-line-end="13">Installer la dernière version de Apache2</p>
<pre><code class="has-line-data" data-line-start="14" data-line-end="18">sudo apt-get update
sudo apt-get install -y apache2
sudo systemctl enable apache2
</code></pre>
<h2 class="code-line" data-line-start=19 data-line-end=20 ><a id="Php_19"></a>Php</h2>
<p class="has-line-data" data-line-start="21" data-line-end="22">Installer la version 8.2 de php et ses extensions (Ctype, iconv, PCRE, Session, SimpleXML, Tokenizer)</p>
<pre><code class="has-line-data" data-line-start="24" data-line-end="45" class="language-sh">sudo dpkg <span class="hljs-operator">-l</span> | grep php | tee packages.txt

sudo apt install apt-transport-https lsb-release ca-certificates wget -y
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg 
sudo sh -c <span class="hljs-string">'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" &gt; /etc/apt/sources.list.d/php.list'</span>
sudo apt update

<span class="hljs-comment"># Expand the curly braces with all extensions necessary.</span>
sudo apt install php8.<span class="hljs-number">2</span> php8.<span class="hljs-number">2</span>-cli php8.<span class="hljs-number">2</span>-{bz2,mysql,curl,mbstring,intl}

sudo apt install libapache2-mod-php8.<span class="hljs-number">2</span>
sudo apt install php8.<span class="hljs-number">2</span>-fpm

sudo a2enconf php8.<span class="hljs-number">2</span>-fpm

<span class="hljs-comment"># When upgrading from older PHP version:</span>
sudo a2disconf php8.<span class="hljs-number">1</span>-fpm

<span class="hljs-comment">## Remove old packages</span>
sudo apt purge php8.<span class="hljs-number">1</span>*
</code></pre>
<h2 class="code-line" data-line-start=50 data-line-end=51 ><a id="Dploiement_50"></a>Déploiement</h2>
<h3 class="code-line" data-line-start=52 data-line-end=53 ><a id="Tlchargement_52"></a>Téléchargement</h3>
<p class="has-line-data" data-line-start="53" data-line-end="54">Une fois tous les composants nécessaires installés, il ne reste plus qu’à déployer le projet.</p>
<p class="has-line-data" data-line-start="55" data-line-end="56">Premièrement il faut télécharger le projet disponible sur github à l’adresse: <code>https://github.com/c-m-SIO/blogSymfonyCours.git</code></p>
<h3 class="code-line" data-line-start=57 data-line-end=58 ><a id="Base_de_donnes_57"></a>Base de données</h3>
<p class="has-line-data" data-line-start="58" data-line-end="60">Ensuite il faut créer une base de données MariaDb en local (cours de cybersecu de 1ere année les mecs !!!).<br>
Pour connecter la BDD au projet, il faut aller dans le fichier <code>.env</code>, décommenter la ligne 28 et y insérer les bonnes informations:</p>
<pre><code class="has-line-data" data-line-start="61" data-line-end="63" class="language-sh">DATABASE_URL=<span class="hljs-string">"mysql://NomUtilisateur:MotDePasse@addresse:port/NomDelaBDD?serverVersion=10.11.2-MariaDB&amp;charset=utf8mb4"</span>
</code></pre>
<h3 class="code-line" data-line-start=64 data-line-end=65 ><a id="Redirection_64"></a>Redirection</h3>
<p class="has-line-data" data-line-start="65" data-line-end="68">Dernière étape du déploiement il faut rediriger l’url vers l’affichage du blog.<br>
Pour cela, aller dans le fichier <code>etc/apache2/sites-available</code> et modifier le fichier <code>000-default.conf</code>.<br>
Ajouter le code:</p>
<pre><code class="has-line-data" data-line-start="69" data-line-end="76" class="language-sh">    DocumentRoot Chemin_du_projet/public
    &lt;Directory /chemin_du_projet/public&gt;
        AllowOverride None
        Require all granted
        FallbackResource /index.php
    &lt;/Directory&gt;
</code></pre>
<p class="has-line-data" data-line-start="76" data-line-end="77">Lien de la documentation symfony (si besoin): <code>https://symfony.com/doc/current/setup/web_server_configuration.html</code>.</p>
<h2 class="code-line" data-line-start=78 data-line-end=79 ><a id="Composer_78"></a>Composer</h2>
<pre><code class="has-line-data" data-line-start="80" data-line-end="85" class="language-sh">apt install wget php-cli php-xml php-zip php-mbstring unzip -y
wget -O composer-setup.php https://getcomposer.org/installer
php composer-setup.php --install-dir=/usr/<span class="hljs-built_in">local</span>/bin --filename=composer
composer --version
</code></pre>
<p class="has-line-data" data-line-start="85" data-line-end="86">Dans le fichier du projet:</p>
<pre><code class="has-line-data" data-line-start="87" data-line-end="89" class="language-sh">composer require
</code></pre>
<h2 class="code-line" data-line-start=90 data-line-end=91 ><a id="Charger_la_base_de_donnes_90"></a>Charger la base de données</h2>
<p class="has-line-data" data-line-start="91" data-line-end="92">Dans le fichier du projet, ouvrir un cmd et exécuter les commandes suivantes:</p>
<pre><code class="has-line-data" data-line-start="93" data-line-end="97" class="language-sh">php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
</code></pre>
<h1 class="code-line" data-line-start=98 data-line-end=99 ><a id="Termin__98"></a>Terminé !</h1>
