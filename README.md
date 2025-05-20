# Atelier-des-Jeux
Ce projet a été réalisé dans le cadre de mes études. Ma mission principale a été la conception et la réalisation d’un logiciel de gestion de demandes d’assistance (Helpdesk) destiné aux utilisateurs et à l’équipe technique d'une entreprise.

## Objectif du projet

Le projet consiste à développer un logiciel en PHP permettant aux utilisateurs de soumettre des demandes d’assistance et à l'équipe technique de les gérer en fonction de leur statut : **ouvert**, **en cours** ou **fermé**.

Les fonctionnalités principales sont les suivantes :
- Création de tickets d’assistance par les utilisateurs
- Consultation et gestion des tickets par les techniciens (mise à jour du statut)
- Système de connexion sécurisé pour les techniciens
- Système de log pour la traçabilité des actions
- Interface responsive et soignée avec utilisation de CSS

## Fonctionnalités

## 1. Page d’accueil
La page d’accueil présente un accès simple aux utilisateurs et aux techniciens. Elle permet d'accéder à la création de tickets pour les utilisateurs et à la gestion des tickets pour les techniciens.
![image](https://github.com/user-attachments/assets/2701396e-d138-458d-bbf9-93b66e00fa3b)

## 2. Demande d’assistance pour les utilisateurs
Les utilisateurs peuvent soumettre une demande d’assistance en remplissant un formulaire avec les informations nécessaires à la gestion de l’incident. Ils doivent spécifier la catégorie de la demande à l’aide d’un menu déroulant (ex. : Problème matériel, Problème logiciel, etc.). Après avoir soumis la demande, un numéro de ticket est généré et affiché à l’utilisateur.

(La selection "home" permet de revenir à la page d'accueil)
![image](https://github.com/user-attachments/assets/8c7e02de-156a-475d-9cc6-2f2c4f17965b)

## 3. Système de connexion
Un système de login avec identifiant et mot de passe est en place pour accéder à la gestion des tickets. Seuls les techniciens peuvent se connecter pour gérer les tickets et modifier leur statut.

## 4. Gestion des tickets
Les techniciens ont accès à un panneau d’administration où les tickets sont affichés avec leur statut (ouvert, en cours, fermé). Ils peuvent consulter chaque ticket et modifier son statut en un clic. La couleur du statut change automatiquement pour une meilleure lisibilité.

En raison d'un problème technique avec la base de données, je ne peux pas vous montrer la fonction en détails de ce script. Cela sera mis à jour une fois le problème traité.

![image](https://github.com/user-attachments/assets/4918f94c-21e9-4252-84f5-520013ab6564)

## 5. Consultation et modification des tickets
Les techniciens peuvent consulter les détails de chaque ticket et, si nécessaire, ajouter des commentaires ou modifier les informations. Ils peuvent aussi changer le statut du ticket pour refléter l’avancement de l’intervention.

## 6. Création de comptes techniciens
Un panneau d'administration permet aux administrateurs de créer des comptes pour les techniciens, leur attribuant un identifiant et un mot de passe.
En raison d'un problème technique avec la base de données, une fois de plus, je ne peux pas vous montrer la fonction en détails de ce script. Cela sera mis à jour une fois le problème traité.

![image](https://github.com/user-attachments/assets/7bccef48-f559-4394-af72-4d5be566b4de)

## 7. Système de logs
Tous les événements importants (création d’un ticket, modification de statut, connexion, etc.) sont enregistrés dans un système de logs afin d'assurer la traçabilité et d'identifier les actions effectuées par les utilisateurs et techniciens.

## 8. Sécurité (inactif)

## 9. Interface responsive (inactif)

## 10. Mise en page (inactif)

## Languages utilisés

- **Langage de programmation** : PHP
- **Base de données** : MySQL
- **Front-end** : HTML, CSS
- **Système de gestion des sessions** : PHP 
- **Système de logs** : Fichier de logs en texte brut
