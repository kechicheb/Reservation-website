Les étapes pour le déploiment de notre code
Tout d'abord, les environnements suivants doivent être installés:
-Wamp ou Xampp
-Laravel
-Composer
1-Setup site-de-réseravtion
2-Ouvrir cmd dans site-de-réseravtion
3-Composer install
4-Exécutez la commande suivante :" cp .env.example .env "
5-Créer la base de données du projet dans phpMyAdmin ou tout autre gestionnaire de SGBD
6-Ouvrez le .env et configurez les paramètres suivants:
DB-CONNECTION=mysql
DB-HOST=127.0.0.1
DB-PORT= mettre le port de la base de données (la valeur par défaut est 3306) 
DB-DATABASE=/* mettre le nom de la base de données 
DB-USERNAME=/* mettre le nom d'utilisateur de la base de données
DB-PASSWORD=  mettre le mot de passe de la base de données 
7-Exécuter la commande suivant:" php artisan migrate"
8-Exécuter la commande suivant:" php artisan db:seed --class=AdminSeeder"
9-Exécuter la commande suivant:" php artisan serve"
10-Il affiche le message suivant :
11-Démarrage du serveur de développement Laravel: http://127.0.0.1:8000
\clearpage
L'email et le mot de passe par défaut de l'administrateur est:
 admin@gmail.com ; Aqwzsxedc@1212@
 admin1@gmail.com ; Zsxedcrfv@1313@
 admin2@gmail.com ; Edcrfvtgb@1414@

