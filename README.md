# SnowTrick
projet openclassroom mini blog 

ce projet nécéssite une suite logiciel permettant de créer un environnement de développement local comme Wamp pour Windows par exemple. 
lancer le serveur local.

Sur la page du lien github, copier le lien du repository github.

ouvrir une boite de commande , se placer dans le dossier WWW de wamp et jouer la commande : git clone https://github.com/AurelienDemblans/SnowTrick.git

créer un fichier .env.local , copier coller dans .env.local l'ensemble du fichier .env

dans .env.local remplacer les variables APP_SECRET et DATABASE_URL par les valeurs correspondant à votre environnement pour la base de donnée et générer une clé pour le APP_SECRET (sur ce site par exemple https://it-tools.tech/token-generator?length=32)

se placer sur le dossier "snowtrick"
jouer la commande : composer install (avant vérifier que composer est bien installer sur l'ordinateur)

le projet devrait être correctement installé. 

Vous pouvez le lancer avec symfony server:start.

vous pouvez ensuite vous rendre à l'adresse **http://127.0.0.1:8000/accueil** dans votre navigateur




