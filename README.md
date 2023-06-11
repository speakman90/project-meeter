# Projet Holo.
***
Pre-requis : Docker
***

Git clone le projet avec la commande => `git clone git@github.com:speakman90/project-meeter.git`

Ce placer dans le dossier de l'application puis lancer la commande => `docker compose up --build`.

Une fois le container installer et en fonctionnement lance la commande => `docker exec -it php bash`
Ce qui permet de rentré dans le container ou se situe le projet.

Pour finir lancer les commande suivante dans l'orde =>
1. `composer install`
2. `npm install`
3. `npm run dev`

Vous pouvez maintenant accèdez à l'application.
en fesant http://localhost/

Le compte administrateur :
- `mail : pierre@test.com`
- `mot de passe : 12345678`