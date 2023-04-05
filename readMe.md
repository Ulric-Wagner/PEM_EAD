## PEM EAD
Ce projet réalisé en PHP à pour objectif la création d'un porail de publication de cours et d'évaluation.

La partie gestion des utilisateurs jusqu'à la publication et la consultation de cours à pu être réalisée
en revanche par manque de temps la partie évaluation reste inachevée.


## Installation
Pour tester le projet vous pouvez utiliser un serveur WAMP sur windows, certaine fonctionalités de sécurisation
ne seront pas actives comme le HTTPS qui est bien sur indispenssable lors de la mise en production mais la sécurisation du
serveur n'entre pas dans le périmètre de ce projet.

le fichier pemead.sql est à importer dans la base de donnée.
les paramètre de connexion sont à modifier dans le fichier ini/bdd.ini .

L'accès au site n'est possible qu'en utilisant le nom de domaine autorisé,
il faut paramètrer ce nom de domaine dans le fichier ini/allowed_domains.ini
Pour un test en local en l'absence de dns veuillez saisir l'adresse 127.0.0.1 dans ce fichier ou configuer
le nom de domaine dans le fichier host de votre machine.

## Mise en service

La première page qui s'affiche lors de la connexion au portail est celle de login.
Aucun n'utilisateur n'étant encore créé il est nécéssaire de s'enregister.

Le premier utilisateur à s'enregistrer devient alors l'Administrateur du portail.
Charge à cet administrateur de créer le contenue qui permettra au futurs utilisateurs de s'enregistrer.


## Role de l'administrateur

L'administrateur va devoir réaliser quelques actions pour mettre en service la plateforme.

Il est d'abord nécéssaire de créer une architecture correspondant à votre besoin.

Vous devez dans un premier temps depuis la page "Bureau" créer des groupement d'instruction, puis ensuite des cours qui seront
ratacher à ces groupements.

Une fois ces cours créé de nouveaux utilisateurs pourons s'enregistrer en tant qu'instructeur du groupement créé.

L'administrateur devra alors valider ou rejeter ces utilisateur depuis le panneau de gestion des comptes.
Il devra également désigner un instructeur comme pilote de cours pour un des cours créés au préalable.

Lors de chaque enregistrement de nouvelle utilisateur l'administrateur à la charge de les valider, une vignette indiquera le nombre
de compte en attente de validation.

## Role des pilotes de cours

Il peut y avoir plusieurs pilote pour un cours afin de permettre aux adjoint de réaliser les taches de pilote de cours.
Les pilote de cours sont également associé au role d'instructeurs, les briques dédiés à ces fonctions seront alors disponible dans
le bureau.

Le pilote de cours à la charge de créer des promotions qui seront associés à un cours.
La création de ces promotion est nécéssaire pour que les élèves puissent s'enregistrer.

Il devra également valider les supports de cours publié par matière par les instructeurs,
une vignette indiquera la présence de document à valider

## Role des instructeurs

Les instructeurs sont charger de la création de matières.
Les instructeurs ont pour mission d'importer des support de cours dans le SI, ces supports de cours pourront enssuite
être associés à une matière en tant que document.
Ces documents seront soumis à la validation des pilotes de cours puis mis à disposition des élèves.

Il est possible de générer des évaluations, le projet n'ayant pu être abouti elles ne seront pas utilisés.
Libre à vous de reprendre le projet pour finaliser cette partie.

## Role des élèves

Les cours sont à disposition des élèves en fonction du cours suivi.
Les évaluations ne sont pas disponibles.



### NB:
la librairie phpoffice\phpspreadsheet à été implémentée dans le projet mais n'est pas encore utilisée.
Elle devait servir pour générer les copies des élèves à l'issue des évaluations afin de les mettre à disposition dans l'interface
instructeurs.