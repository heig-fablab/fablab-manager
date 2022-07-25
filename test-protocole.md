# Protocole de test

## But
Réaliser et suivre les tests système avant de déployer en production et tester la production.

## Prologue
Si vous testez en production, le site est accessible ici: \
https://tb22-berney.heig-vd.ch/

## 1. Authentification

- [x] **1.1** :
Si vous n'êtes pas connecté à HEIG-VD, vous êtes redirigé vers une url comme celle-ci: \
https://accounts2.heig-vd.ch/auth/realms/HEIG-VD/protocol/openid-connect/auth?...

- [x] **1.2** :
Entrer des mauvais identifiants, il doit vous afficher une erreur indiquant que vos identifiants sont incorrects.
Ainsi que redemander à nouveau vos identifiants.

- [x] **1.3** :
Entrer vos identifiants HEIG-VD correctement, il doit vous rediriger vers la page d'accueil avec le chemin: /user-jobs

### Première authentification

- [x] **1.4** :
Lors de la première connexion, vous devez avoir toutes les notifications activées, vérifiez-les sur l'url: \
https://tb22-berney.heig-vd.ch/settings \
Toutes les switches de notifications doivent être activées.

## 2. Overlay de l'interface

Prérequis:
Être connecté avec un nouveau compte.

- [x] **2.1** :
La première page sur laquelle arrive l'utilisateur est la page des demandes en cours (/user-jobs). La table est vide au début, elle affiche "Aucune donnée disponible".
- [x] **2.2** :
La barre latérale est affichée au démarrage. Cliquer plusieurs fois sur l'icône en haut à gauche. La barre doit basculer entre affichée et masquée. La barre doit "comprimer" le contenu de la page.
- [x] **2.3** :
- Cliquer sur le prénom de l'utilisateur en haut à droite. Un menu déroulant avec comme seul élément "Se déconnecter" doit s'afficher.
- [x] **2.4** :
Cliquer sur le logo HEIG-VD en haut à gauche. Il doit contenir un lien vers "/user-jobs". Vérifier qu'il fonctionne.
- [x] **2.5** :
Cliquer sur la cloche en haut à droite. Elle doit elle aussi contenir un lien vers "/user-jobs". Vérifier qu'il fonctionne.
La cloche doit toujours indiquer le nombre de demandes notifiées.

## 3. Interface du client
Ces essais doivent être faits depuis un compte client.

### Menu

- [x] **3.1** :
Dans la barre latérale de gauche, il doit y avoir uniquement les éléments suivants (de haut en bas) :
  - Nouvelle demande
  - Travaux réalisables
  - Mes commandes
  - Paramètres

### Nouvelle demande

- [x] **3.2** :
Cliquer sur "Nouvelle demande". La page ne change pas. Une fenêtre modale avec comme titre "Formulaire de nouvelle demande" doit apparaître.
Le formulaire comporte les champs "Type de travail", "Titre du travail", Fichiers à joindre", "Échéance" et "Commentaires éventuels".
L'ouverture d'un formulaire de cette façon doit comporter des champs vides.
- [x] **3.2.1** :
Si l'utilisateur clique en dehors de la fenêtre modale, il ne doit rien se passer.
- [x] **3.2.2** :
S'il clique sur "Annuler", la fenêtre se ferme.
- [x] **3.2.3** :
Si le type de travail n'est pas encore sélectionné, le champ "Fichiers à joindre" est désactivé.

- [x] **3.2.4** :
Cliquer sur "Soumettre" en ayant gardé les champs vides. Les champs "Type de travail", "Titre du travail" et "Échéance" se mettent en erreur.
- [x] **3.2.5** :
Cliquer sur le champ "Type de travail" et en sélectionner un. Cliquer sur "Soumettre". Les champs "Fichiers à joindre", "Titre du travail" et "Échéance" doivent se mettre en erreur.

Pour que le champ des fichiers ne soit plus en erreur, y joindre un ou plusieurs fichiers dont au moins un d'entre eux doit avoir un des bons types.
- [x] **3.2.6** :
L'utilisateur doit pouvoir ajouter des fichiers en cliquant sur le champ, ou en faisant un drag and drop des fichiers sur le champ.
- [x] **3.2.7** :
  - Si au moins un fichier qui comporte le bon type (le type est indiqué) est ajouté, le champ "Fichiers à joindre" n'est plus en erreur.
- [x] **3.2.8** :
  - Si aucun des fichiers n'est du bon type, l'erreur persiste.
- [x] **3.2.9** :
  - Si les fichiers dépassent 5 MB au total, le champ est en erreur.
- [x] **3.2.10** :
  - Si plusieurs fichiers sont présents dans le champ, le bouton en forme de croix à droite permet de vider la sélection du champ.

Pour que le champ de la date d'échéance ne soit plus en erreur, il faut cliquer dessus et sélectionner une date dans le calendrier.
- [x] **3.2.11** :
L'utilisateur ne doit pas pouvoir sélectionner de dates dans le passé.
- [x] **3.2.12** :
L'utilisateur ne doit pas pouvoir sélectionner une date avant 5 jours que le jour actuel.

- [x] **3.2.13** :
Le champ "Commentaires éventuels" est optionnel : il ne doit jamais être en erreur et peut être laissé vide.

- [x] **3.2.14** :
Tant que des champs sont en erreur, le bouton "Soumettre" ne doit pas envoyer la demande. 
- [x] **3.2.15** :
Si au moins un champ est en erreur, le bouton "Soumettre" ne doit avoir comme effet que de vérifier les champs.
- [x] **3.2.16** :
S'il n'y a plus d'erreurs, cliquer sur le bouton de soumission doit désactiver ce dernier et le mettre en état de chargement.
- [x] **3.2.17** :
Si la demande n'a pas été correctement reçue par le serveur, le bouton de soumission doit se réactiver et n'est plus en état de chargement. 
Une notification doit apparaître en haut à droite de l'écran en indiquant une erreur.
- [x] **3.2.18** :
Si la demande a été correctement reçue par le serveur, le formulaire doit se fermer et une notification doit apparaître en haut à droite de l'écran en indiquant la réussite de l'envoi.

- [x] **3.2.19** :
Une limite de 10 demandes en parallèle est fixée, pour éviter les abus. \
Si la limite est atteinte, il ne doit plus être possible de déposer de nouvelles demandes, jusqu'à ce qu'une demande soit terminée et effacée. \
Quand la limite est atteinte, le formulaire doit être désactivé. \
- Un overlay de verrouillage doit être affiché par-dessus, en indiquant que la limite est atteinte. 
- Un bouton "Annuler" figure sur cet affichage. 
- Si l'utilisateur clique dessus, le formulaire et l'overlay de verrouillage doivent se fermer. 
- Ce verrouillage doit persister tant que la limite est atteinte.
  
Dans tous les cas, une demande ne doit pas pouvoir être envoyée s'il reste des champs en erreur. \
Quand une demande est soumise et reçue, elle doit être ajoutée dans la table de la page "Mes commandes". \
Vérifier qu'elle ait bien été ajoutée dans la base de données, ainsi que ses fichiers et timeline events.

### Page Travaux réalisables

- [x] **3.3** :
- [x] **3.3.1** :
Cliquer sur "Travaux réalisables". La page doit changer (/job-categories). Les catégories de travaux disponibles doivent être affichés.
- [x] **3.3.2** :
Si l'utilisateur clique sur une des images, le formulaire de demandes doit s'ouvrir. La catégorie de travail correspondant doit être pré-rempli.
- [x] **3.3.3** :
Si l'utilisateur clique sur la "carte" de la catégorie de travail, le formulaire de demandes doit s'ouvrir. La catégorie de travail correspondant doit être pré-rempli.
- [x] **3.3.4** :
Les travaux doivent être contenus dans une liste à deux colonnes, si la taille de l'écran le permet.
- [x] **3.3.5** :
Chaque élément de la liste doit contenir une image à gauche, et à droite le titre de la catégorie de travail et une description.

### Page Mes commandes

- [x] **3.4** :
Cliquer sur "Mes commandes". La page doit changer (/user-jobs).
- [x] **3.4.1** :
Une table contenant les demandes déposées par l'utilisateur doit apparaître. Si elle est vide, elle doit afficher "Aucune donnée disponible".
- [x] **3.4.2** :
Une demande notifiée doit avoir un point d'exclamation en haut à droite de son statut. 
Le nombre indiqué sur la cloche en haut à droite de l'écran doit toujours correspondre au nombre de demandes notifiées.
- [x] **3.4.3** :
La table doit avoir les colonnes suivantes :
  - Travail
  - Date de création
  - Échéance
  - Responsable
  - Statut

- [x] **3.4.4** :
La table doit pouvoir afficher un nombre variable de demandes par page (5, 10, 15, tous) et doit pouvoir changer de page (page du tableau) grâce aux outils de navigation en bas à droite de la table.
- [x] **3.4.5** :  
La table doit pouvoir être triée selon une seule colonne à la fois, si l'utilisateur clique sur le nom de la colonne en question. \
La flèche qui doit apparaître indique le sens du tri : ascendant ou descendant.
- [x] **3.4.6** :
Par défaut, la table doit être triée par statut. Le tri doit se faire automatiquement dès qu'une demande est notifiée/dénotifiée.
- Pour la colonne "Travail", le tri doit être réalisé dans l'ordre alphabétique des catégories de travail.
- Pour les colonnes "Date de création" et "Échéance", le tri doit être fait par ordre chronologique.
- Pour la colonne "Responsable", le tri doit être fait par ordre alphabétique.
- Pour la colonne "Statut", le tri doit être réalisé en fonction de l'ordre d'avancent : "Nouveau" > "Assigné" > "En cours" > "En pause" > "Terminé". 
- Les demandes notifiées doivent apparaître avant les autres, dans le bon ordre.

- [x] **3.4.7** :
Des tooltips doivent apparaître si l'utilisateur positionne son curseur sur les valeurs de certaines colonnes :
  - Pour les colonnes "Date de création" et "Échéance", le tooltip doit indiquer la date au format JJ/MM/AAAA.
  - Pour la colonne "Responsable", le tooltip doit indiquer le nom complet (prénom + nom) du technicien assigné, si c'est le cas. 

- [x] **3.4.8** :
Si la demande n'est pas encore assignée (statut "Nouveau"), la colonne "Responsable" doit être indiquée "Inconnu". Sinon, elle contient le nom du technicien.

### Informations / Suivi de la demande

#### Données de la demande
- [x] **3.4.9** :
Cliquer sur une demande (ligne de la table). Une fenêtre modale présentant les détails de la demande doit s'ouvrir.
- [x] **3.4.10** :
Si l'utilisateur clique en dehors de la fenêtre modale ou sur l'icône en forme de croix en haut à gauche, elle doit se fermer.
- [x] **3.4.11** :
Quand l'utilisateur ferme la fenêtre modale des détails, la demande ne doit plus être notifiée et elle doit se faire trier.
- [x] **3.4.12** :
Si la demande n'est pas encore assignée, seuls le tableau et le stepper sont visibles. \
Un message indiquant "Le chat et la timeline seront disponibles dès que cette demande aura été assignée à un technicien" doit être affiché en bas au milieu de la fenêtre modale.
- [x] **3.4.13** :
La fenêtre modale doit contenir en premier un tableau contenant la demande en question. Cette table contient les colonnes suivantes :
  - Travail
  - Identifiant unique
  - Date de création
  - Échéance
  - Responsable
  - Statut
  - Fichiers
  - Commentaire
- [x] **3.4.14** :
La colonne "Fichiers" doit contenir un bouton avec écrit dessus "Afficher". 
  - Si l'utilisateur clique dessus, une liste des noms des fichiers associés à la demande doit apparaître.
  - Si l'utilisateur clique sur un nom de fichier, le fichier doit être téléchargé par le navigateur.
  - Si le fichier est de type pdf ou image, un nouvel onglet est ouvert dans le navigateur, qui affiche l'image ou le pdf.
  - Il ne doit pas y avoir plusieurs fois le même nom de fichier. Seules les dernières versions des fichiers sont disponibles.

- [x] **3.4.15** :
Si un commentaire a été ajouté dans le formulaire lors de la création de la demande, la case de la colonne "Commentaire" doit avoir un bouton avec un icone. Sinon, la case affiche "Aucun".
  - Si l'utilisateur clique dessus, une petite fenêtre modale ayant comme titre "Commentaire" doit apparaître. Le commentaire est affiché sous le titre.
  - Si l'utilisateur clique en dehors, la fenêtre de commentaire doit se fermer.

#### Stepper

- [x] **3.4.16** :
En dessous du tableau, il doit y avoir un stepper. Ce stepper doit indiquer l'état d'avancement du travail. Une étape terminée doit être symbolisée par un symbole vu.
Voici les conditions que doivent remplir les étapes du stepper pour avoir le vu :
  - Étape 1 : Demande créée : le statut vaut "Nouveau", "Assigné", "En cours", "En pause" ou "Terminé".
  - Étape 2 : Technicien assigné : le statut vaut "Assigné", "En cours", "En pause" ou "Terminé".
  - Étape 3 : Début du travail : le statut vaut "En cours" ou "Terminé".
  - Étape 3 : Problème : le statut vaut "En pause".
  - Étape 4 : Travail terminé : le statut vaut "Terminé".

#### Chatbox

- [x] **3.4.17** :
En dessous du stepper, à gauche, il doit y avoir la chatbox de messagerie. 
  - Elle ne doit être visible que si le travail est assigné à un technicien.
  - La chatbox doit contenir un champ de texte avec écrit "Votre message..." en indice. A droite de ce champ de texte doit se trouver un bouton en forme d'avion en papier qui sert de bouton d'envoi.
- [x] **3.4.18** :
  - La touche "Enter" doit avoir le même effet que le bouton d'envoi si le champ de texte à le focus.
- [x] **3.4.19** :
  - Si l'utilisateur clique sur le bouton et que le message est vide, rien ne doit se passer.
- [x] **3.4.20** :
  - Si l'utilisateur clique sur le bouton et qu'il a rempli le champ de texte, le message est envoyé. Il doit apparaître dans la chatbox, du côté droit, en dessous des autres messages.
- [x] **3.4.21** :
  - Si le champ de texte n'est pas vide, un bouton en forme de croix doit apparaître à gauche du bouton d'envoi. Si on clique dessus, le texte doit être effacé.
- [x] **3.4.22** :
  - Si les messages ne datent pas du même jour, il doit y avoir un délimiteur qui apparaît entre les deux messages de dates différentes. Ce délimiteur doit afficher la date en format JJ/MM/AAAA.
- [x] **3.4.23** :
  - Les messages envoyés doivent apparaître à droite, en bleu. Les messages reçus doivent apparaître à gauche, en gris.
- [x] **3.4.24** :
  - Les messages doivent être affichés par ordre chronologique.

- [x] **3.4.25** :
Les messages ont un système de notification propre à eux même. Un délimiteur doit apparaître en indiquant "Nouveaux messages" entre l'ancien et le nouveau message reçu.
  - Si l'utilisateur n'est pas sur la fenêtre modale de détails lorsqu'il reçoit un message, le délimiteur doit apparaître quand il ouvrira la fenêtre.
  - Si l'utilisateur est sur la fenêtre modale de détails lorsqu'il reçoit un message et qu'il n'en a pas envoyé depuis que la fenêtre est ouverte, le délimiteur doit apparaître.
  - Si l'utilisateur est sur la fenêtre modale de détails lorsqu'il reçoit un message et qu'il en a lui-même envoyé depuis que la fenêtre est ouverte, le délimiteur ne doit pas apparaître.

#### Timeline
- [x] **3.4.26** :
À droite de la chatbox doit se trouver la timeline. Elle ne doit être visible que si le travail est assigné à un technicien.
Les évènements de la timeline doivent avoir la date et l'heure de leur apparition et contenir une description :
  - Création de la demande : ça doit toujours être le premier évènement de la timeline. Il doit apparaître automatiquement lors de la dépose d'une demande.
  - Ajout du fichier "{nomFichier}" Version 1 : indique qu'un fichier a été ajouté pour la première fois. Il doit apparaître quand un nouveau fichier est ajouté par un des deux acteurs.
  - Modification du fichier "{nomFichier}" Version {n} : indique qu'un fichier a été écrasé et mis à jour. Il doit apparaître quand un fichier est écrasé par un des deux acteurs. Le numéro de version moins 1 correspond au nombre de fois qu'il a été écrasé.
  - Changement de statut : {statut} : indique que le status a été changé. Il doit apparaître quand le technicien change le statut de la demande.

- [x] **3.4.27** :
Les évènements de la timeline doivent apparaître par ordre chronologique.
- [x] **3.4.28** :
En bas de la timeline doit se trouver le champ "Fichiers à joindre". Il doit fonctionner exactement comme pour le même champ du formulaire.
À droite du champ doit se trouver un bouton en forme de flèche montante qui sert de bouton d'envoi.
- [x] **3.4.29** :
Si l'utilisateur clique sur le bouton et qu'il n'y a pas de fichiers sélectionnés, rien ne doit se passer.
- [x] **3.4.30** :
Si l'utilisateur clique sur le bouton et qu'il a rempli la sélection, les fichiers sont envoyés. Les évènements liés aux fichiers doivent apparaître en notifiés dans la timeline. Ils doivent aussi être disponibles depuis la colonne "Fichiers" du tableau.
- [x] **3.4.31** :
Si la sélection n'est pas vide, un bouton en forme de croix doit apparaître à gauche du bouton d'envoi. Si on clique dessus, la sélection doit être effacée.

#### Demande terminée
- [x] **3.4.32** :
Si la demande possède le statut "Terminé", un long bouton vert doit apparaître tout en haut de la fenêtre modale. Le texte du bouton doit indiquer "Terminer la demande".
- [x] **3.4.33** :
Si l'utilisateur clique dessus, une nouvelle fenêtre modale avec comme titre "Terminer la demande" doit s'ouvrir. Le texte doit indiquer à l'utilisateur que le travail est terminé et qu'il peut désormais en disposer.
- [x] **3.4.34** :
Il doit y avoir un "rating" de 6 étoiles qui doit être vide à l'apparition de la fenêtre.
- [x] **3.4.35** :
  - Si l'utilisateur clique sur le rating, il doit pouvoir sélectionner 1 à 6 étoiles.
- [x] **3.4.36** :
  - Si l'utilisateur clique en dehors de la fenêtre modale, il ne doit rien se passer.
- [x] **3.4.37** :
  - Si l'utilisateur clique sur le bouton "Annuler", la fenêtre modale doit se fermer.
- [x] **3.4.38** :
  - Si l'utilisateur n'a pas mis d'étoiles, le bouton "Valider" est désactivé.
- [x] **3.4.39** :
  - Si l'utilisateur a mis 1 à 6 étoiles, le bouton "Valider" est activé.

- [x] **3.4.40** :
Quand l'utilisateur clique sur le bouton "Valider", ce dernier doit se mettre en mode chargement tant qu'il n'y a pas eu de réponse du serveur. \
S'il n'y a pas eu d'erreur, toutes les fenêtres modales doivent se fermer et une notification en haut à droite de l'écran doit apparaître pour indiquer qu'il n'y a pas eu de problème. \
La demande ne doit plus figurer dans la table des demandes. \
En cas d'erreur, la fenêtre modale reste ouverte et une notification en haut à droite de l'écran doit apparaître pour indiquer qu'il y a eu un problème.

### Page Paramètres

- [x] **3.5** :
Cliquer sur "Paramètres". La page doit changer (/settings). Deux cartes doivent apparaître. La première, en haut, doit contenir des informations du compte :
  - Prénom
  - Nom
  - Addresse mail
  - Demandes en cours

- [x] **3.5.1** :
Le nombre de demandes en cours doit correspondre au nombre de demandes qui figurent dans la table de la page "Mes commandes".
- [x] **3.5.2** :
Sur la deuxième carte doivent apparaître les paramètres de notifications :
  - Notifications par mail
  - Nouveau statut
  - Nouveaux messages
  - Nouveaux fichiers

- [x] **3.5.3** :
À droite de chaque paramètre doit se trouver un switch. Chaque switch sert à activer/désactiver un critère pour l'envoi d'un email de notification.
- [x] **3.5.4** :
Si l'utilisateur clique dessus, la valeur du switch doit changer à l'écran et dans la base de données, et la colonne "notify_email_updated_at" doit prendre la valeur du temps actuel. \
Vérifier que ce soir bien le cas dans la base de données.
- [x] **3.5.5** :
Quand un switch est changé, il doit se mettre en mode chargement tant que la modification n'a pas été faite dans la base de données.
- [x] **3.5.6** :
- Si une erreur survient, une notification en haut à droite de l'écran doit apparaître, en indiquant l'erreur. Le switch doit automatiquement se remettre dans son ancien état.
- [x] **3.5.7** :
Le switch "Notifications par mail" sert à activer ou désactiver les trois autres switches.
  - Si le switch "Notifications par mail" est activé par l'utilisateur, les trois autres doivent s'activer.
  - Si le switch "Notifications par mail" est désactivé par l'utilisateur, les trois autres doivent se désactiver.
  - Si au moins un des trois autres switches sont activés, le switch "Notifications par mail" doit s'activer automatiquement. L'activation automatique ne doit pas modifier les autres switchs.
  - Si aucun des trois autres switches ne sont activés, le switch "Notifications par mail" doit se désactiver automatiquement. La désactivation automatique ne doit pas modifier les autres switchs.

## 4. Interface du technicien
Ces essais doivent être faits depuis un compte technicien.

### Menu
- [x] **4.1** :
Dans la barre latérale de gauche, il doit y avoir uniquement les éléments suivants (de haut en bas) :
  - Nouvelle demande
  - Travaux réalisables
  - Mes commandes
  - Commandes clients
  - Paramètres

Seul la page "Commandes clients" est nouvelle, les autres sont les mêmes que pour le client, car un technicien est également un client.
La page "Mes commandes" changent un peu, car la possibilité de modifier le statut d'un travail est ajouté.

### Page Mes commandes
- [x] **4.3** :
Cliquer sur "Mes commandes". La page doit changer (/user-jobs). Une table contenant les demandes assignées par l'utilisateur doit apparaître. Si elle est vide, elle doit afficher "Aucune donnée disponible".
L'interface de la table doit être identique que pour le client.
Cliquer sur une demande (ligne de la table). Une fenêtre modale présentant les détails de la demande doit s'ouvrir. L'interface de la fenêtre modale des détails doit être identique que pour le client, à quelques différences près.

#### Changement de statut
- [x] **4.3.1** :
La colonne "Statut" doit contenir un bouton avec écrit dessus le statut actuel, uniquement si le statut actuel ne vaut pas "Terminé", dans quel cas il ne doit pas y avoir de bouton. 
- [x] **4.3.2** :
Si l'utilisateur clique dessus, une fenêtre modale avec comme titre "Changer le statut" doit s'ouvrir.
- [x] **4.3.3** :
Cette fenêtre modale doit contenir un sélecteur avec initialement écrit dessus "Nouveau statut...". \
En dessous, un texte doit afficher la description du statut sélectionné, avec comme texte initial "Description du statut...".
- [x] **4.3.4** :
Si l'utilisateur clique en dehors de la fenêtre modale, il ne doit rien se passer.
- [x] **4.3.5** :
Si l'utilisateur clique sur le bouton "Annuler", la fenêtre modale doit se fermer.
- [x] **4.3.6** :
Si l'utilisateur n'a pas sélectionné de nouveau statut, le bouton "Modifier" doit être désactivé.
- [x] **4.3.7** :
Si l'utilisateur a sélectionné un nouveau statut, le bouton "Modifier" doit s'activer.

- [x] **4.3.8** :
En fonction du statut actuel, la liste des statuts du sélecteur doit s'adapter en conséquence :
  - Assigné : "En cours", "En pause" et "Terminé".
  - En cours : "En pause" et "Terminé".
  - En pause : "En cours" et "Terminé".

- [x] **4.3.9** :
Quand l'utilisateur clique sur le bouton "Modifier", ce dernier doit se mettre en mode chargement tant qu'il n'y a pas eu de réponse du serveur. \
S'il n'y a pas eu d'erreur, la fenêtre modale doit se fermer et une notification en haut à droite de l'écran doit apparaître pour indiquer qu'il n'y a pas eu de problème. \
Le statut doit avoir changé dans le tableau et un nouvel évènement de type "statut" doit apparaître dans la timeline. \
En cas d'erreur, la fenêtre modale reste ouverte et une notification en haut à droite de l'écran doit apparaître pour indiquer qu'il y a eu un problème.

### Page Commandes clients

- [x] **4.4** :
Cliquer sur "Commandes clients". La page doit changer (/unassigned-jobs). \
Un tableau contenant les demandes non-assignées des clients doit apparaître. \
Si elle est vide, elle doit afficher "Aucune donnée disponible".
Juste en dessus de cette table doit se trouver un bouton avec écrit dessus "Assigner". La table doit avoir les colonnes suivantes :
  - Travail
  - Date de création
  - Échéance
  - Client
  - Commentaire

- [x] **4.4.1** :
Le tableU doit pouvoir afficher un nombre variable de demandes par page, tout comme celle des demandes assignées. Le tri doit aussi se faire de la même manière. \
- [x] **4.4.2** :
Par défaut, la table doit être triée par date de création (les plus anciennes d'abord). \ 
Si une demande est ajoutée par un client alors que l'utilisateur se trouve sur cette page, la nouvelle demande apparaît en haut du tableau.
- [x] **4.4.3** :
Des tooltips doivent apparaître si l'utilisateur positionne son curseur sur les valeurs de certaines colonnes :
  - Pour les colonnes "Date de création" et "Échéance", le tooltip doit indiquer la date au format JJ/MM/AAAA.
  - Pour la colonne "Client", le tooltip doit indiquer le nom complet (prénom + nom) du client.

- [x] **4.4.4** :
La colonne "Commentaire" doit fonctionner de la même manière que sur la fenêtre modale des détails d'une demande, à savoir un icOne qui ouvre une nouvelle petite fenêtre modale.
- [x] **4.4.5** :
À la différence du tableau des demandes assignées, celle-ci doit avoir une checkbox devant le type de travail. \
L'utilisateur doit pouvoir cocher et décocher les checkbox.
- [x] **4.4.6** :
Si aucune des checkbox n'est cochée, le bouton "Assigner" doit être désactivé.
- [x] **4.4.7** :
Si au moins une des checkbox est cochée, le bouton "Assigner" doit s'activer.

- [x] **4.4.8** :
Quand l'utilisateur clique sur le bouton "Assigner", une fenêtre modale de confirmation doit s'ouvrir. Le texte doit indiquer le nombre de demandes cochées.
- [x] **4.4.9** :
Si l'utilisateur clique en dehors de la fenêtre de confirmation, elle doit se fermer.
- [x] **4.4.10** :
Si l'utilisateur clique sur le bouton "Annuler", la fenêtre de confirmation doit se fermer.

- [x] **4.4.11** :  
Quand l'utilisateur clique sur le bouton "Valider", ce dernier doit se mettre en mode chargement tant qu'il n'y a pas eu de réponse du serveur. \ 
S'il n'y a pas eu d'erreur, toutes les demandes cochées doivent disparaître de la table et doivent se retrouver dans la table des demandes assignées sous "Mes commandes" et une notification en haut à droite de l'écran doit apparaître pour indiquer qu'il n'y a pas eu de problème. \
La fenêtre modale doit se fermer. En cas d'erreur, une notification en haut à droite de l'écran doit apparaître pour indiquer qu'il y a eu un problème.
 
## 6. Websockets
Ces essais doivent être faits avec deux PC différents, ou bien un seul avec deux fenêtres, en navigation privée et normale. \
Je recommande d'utiliser deux PC, car les deux écrans sont toujours visibles au même moment

### Connexion au websockets

Si vous êtes en développement, les tests suivants peuvent être réaliser:
- [ ] **1.5** :
  Ouvrir d'abord le navigateur en navigation privée et accéder au site. \
  Dans le .env du backend, mettre APP_ENV=local. \
  Remplacer dans l'URL "/welcome" par "/laravel-websockets".
  Une interface pour visualiser le trafic du serveur websocket va s'afficher.
  Prendre le port 6001 et cliquer sur "Connect".
  Réouvrir le navigateur (en navigation normale) pour accéder au site et s'y connecter depuis un compte client pour accéder à la page principale.
  Dans l'interface du serveur websocket, il doit y avoir des évènements de type "subscribed" et "occupied" aux channels suivants:
  - message.channel.{username}
  - job.channel.{username}. 
  - job.workers si c'est un technicien \
  {username} correspond à l'identifiant de l'utilisateur dans la base de données (clé principale).
  Fermer la fenêtre de navigation normale. Des évènements de type "vacated" doivent apparaître.

### Interactions en temps réel
- [ ] **6.1** :
Se connecter avec un compte client et un compte technicien. Marche à suivre :
 1. Le technicien doit être sur la page "Commandes clients", qui doit être vide.
 2. Le client dépose un certain nombre de nouvelles demandes, une de chaque catégorie si possible. Au fur et à mesure que les demandes sont déposées, le tableau du technicien doit se remplir et afficher les demandes du client.
 3. Le client peut ouvrir et fermer la fenêtre modale des détails de chaque demande pour se débarrasser des icônes de notification (!). Il ouvre la même fenêtre sur la demande qui va être assignée.
 4. Le technicien s'assigne la demande. La demande doit disparaître de la table et doit se retrouver dans la table des demandes assignées sur la page "Mes commandes".
 5. Pour le client, au moment où la demande est assignée, la chatbox et la timeline doivent apparaître en temps réel. Un nouveau statut est ajouté dans la timeline, pour les deux acteurs.
 6. Vérifier que l'échange de messages fonctionne.
 7. Vérifier que l'ajout de fichiers fonctionne. Les nouveaux fichiers doivent apparaître en temps réel dans la liste déroulante des fichiers et des évènements de la timeline doivent être ajoutés.
 8. Le technicien fait changer le statut de la demande. Le stepper doit changer en temps réel et des évènements de la timeline doivent être ajoutés.
 9. Quand un statut change, le vérifier qu'il change aussi dans la colonne "Statut" du premier tableau, en ayant la fenêtre des détails fermée. Le tri doit s'opérer dans la table à chaque changement.
 10. Quand le technicien impose le statut "Terminé", le bouton "Terminer la demande" doit apparaître en temps réel chez le client.
 11. Quand le client supprime la demande, sa fenêtre modale des détails ainsi que celle du technicien doivent se fermer. La demande ne doit plus figurer sur aucune des tables.

Il est important de vérifier que l'interface change en temps réel. Si la demande est effacée par le client, la fenêtre des détails doit se fermer chez les deux acteurs.
Il faut s'assurer que les demandes soient bien notifiées quand il y a des changements.

- [ ] **6.2** :
Se connecter avec deux comptes techniciens différents. Il faut avoir quelques demandes non assignées pour ces essais. Marche à suivre :
 1. Les techniciens doivent être sur la page "Commandes clients", qui doit contenir des demandes.
 2. Les techniciens cochent la même demande puis cliquent sur "Assigner". Seul l'un des deux clique sur Valider. La fenêtre de validation doit se fermer chez les deux. La demande doit disparaître de la table chez les deux.
 3. Le premier technicien coche deux demandes et clique sur "Assigner". Le second n'en coche qu'une des deux et se l'assigne. Le premier technicien doit voir que la valeur est passée de 2 à 1 dans le texte de la fenêtre de validation.

Il est important de vérifier que la table est synchronisée chez tous les techniciens. Si deux techniciens veulent s'assigner la même demande, c'est le plus rapide qui gagne. \ 
La fenêtre modale de validation doit s'adapter en temps réel à ces changements. Si toutes les demandes cochées sont retirées, la fenêtre de validation doit se fermer.

## 7. Emails de notification
En développement, les emails sont envoyés après 20 secondes, en production après 30 minutes.

- [x] **7.1** :
Se connecter avec un compte client et un compte technicien. Marche à suivre :
 1. S'assurer que les paramètres mail du client soient tous activés. Le client reste sur cette page et ne doit pas aller ouvrir les détails de ses demandes.
 2. Le technicien prend une demande du client et lui envoie 3 messages, ajoute 1 fichier et change le statut de la demande. Le client doit recevoir un mail indiquant les mêmes changements.
 3. Refaire la même procédure que ci-dessus, sauf que cette fois le client doit ouvrir et fermer la fenêtre des détails de la demande avant le délai de 20 secondes ou 30 minutes. Aucun mail ne doit être reçu du client.
 4. Refaire la même procédure, mais en ayant désactivé les paramètres de notification du client avant, puis après les modifications. Aucun mail ne doit être reçu du client.
 5. Vérifier que si plusieurs demandes changent, toutes ces demandes doivent apparaître dans le mail et chaque demande doit indiquer quels éléments ont changé.

Il est important de vérifier que les éléments qui apparaissent dans le mail correspondent bien aux éléments notifiés dans l'interface. \ 
Vérifier dans la fenêtre des détails après avoir reçu le mail. \
Le système fonctionne de la même manière pour alerter le technicien. 
Vérifier que ce soit le cas. \
Quand un mail est envoyé, tous les éléments notifiés de toutes les demandes sont pris en compte. 
Vérifier que ce soit le cas.

- [x] **7.2** :
Se connecter avec un compte client et un compte technicien. Marche à suivre :
  1. Désactiver tous les paramètres de notification du client.
  2. Le technicien prend une demande du client et lui envoie 1 message, ajoute 1 fichier et change le statut de la demande. Aucun mail ne doit être reçu du client.
  3. Le client active seulement les notifications pour les nouveaux statuts et les nouveaux fichiers.
  4. Le technicien prend une demande du client et ajoute 1 message. Aucun mail ne doit être reçu du client.
  5. Le client active les notifications pour les nouveaux messages.
  6. Le technicien prend une demande du client et ajoute 1 message. Le client doit recevoir un mail indiquant tous les changements.

Cette procédure peut être répétée en changeant le paramètre testé :
  - Le client active seulement les notifications pour les nouveaux statuts et les nouveaux messages, pour tester les fichiers.
  - Le client active seulement les notifications pour les nouveaux fichiers et les nouveaux messages, pour tester les statuts.

Il est important de vérifier que les conditions d'envoi sont bien respectées. \
Si l'utilisateur ne désire pas être averti par mail des nouveaux messages, les changements de statuts et l'ajout de fichiers ne doivent pas envoyer de mail, etc.

## 8. Test d'URL

- [x] **8.1** :
Tester d'entrer une url / un chemin qui n'existe pas à la fin de l'url de base, il doit vous afficher une page 404.
Par exemple: https://tb22-berney.heig-vd.ch/test

- [x] **8.2** :
Essayer d'entrer l'url suivante:
https://tb22-berney.heig-vd.ch/ \
La page "Mes commandes" doit être affichée.

- [x] **8.3** :
Essayer d'entrer l'url suivante:
https://tb22-berney.heig-vd.ch/user-jobs \
La page "Mes commandes" doit être affichée.

- [x] **8.4** :
Essayer d'entrer l'url suivante:
https://tb22-berney.heig-vd.ch/job-categories \
La page "Travaux réalisables" doit être affichée.

- [x] **8.5** :
En tant que technicien ou admin, essayer d'entrer l'url suivante:
https://tb22-berney.heig-vd.ch/unassigned-jobs \
La page "Commandes clients" doit être affichée.

- [x] **8.6** :
En tant que technicien ou admin, essayer d'entrer l'url suivante:
https://tb22-berney.heig-vd.ch/unassigned-jobs \
L'utilisateur doit être redirigé sur la page "Mes commandes".

- [x] **8.7** :
En tant que technicien ou admin, essayer d'entrer l'url suivante:
https://tb22-berney.heig-vd.ch/settings \
La page "Paramètres" doit être affichée.
