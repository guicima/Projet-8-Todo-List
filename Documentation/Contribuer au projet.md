# Contribuer au projet

Merci de penser à vouloir nous aider ! Sur quoi souhaiteriez-vous travailler ?

- [Avant de démarrer](#-Avant-de-démarrer)
- [Outils de travail recommandés](#-Outils-de-travail-recommandés)
- [Git](#-Git)
- [Je veux améliorer la documentation pour développeurs](#-Je-veux-améliorer-la-documentation-pour-développeurs)
- [Je veux proposer une nouvelle fonctionnalité](#-Je-veux-proposer-une-nouvelle-fonctionnalité)
- [Je veux corriger un problème](#-Je-veux-corriger-un-problème)
- [J'ai fini mes modifications, je voudrais les proposer](#-J'ai-fini-mes-modifications,-je-voudrais-les-proposer)

## Avant de démarrer

Ce projet utilise Git, l'outil de gestion de version le plus utilisé au monde. Pour l'installer et découvrir l'outil,
rendez-vous sur [le site officiel (en anglais)](https://git-scm.com). 

1. La première chose à faire est de [forker le repository](https://help.github.com/articles/fork-a-repo/).

2. Récupérez le code de votre fork.

3. Installez ensuite le projet en suivant [les instructions d'installation](docs/1-Installer-le-projet-en-local.md).

4. Lorsque nous travaillons avec Git, nous utilisons un processus de développement basé sur "une branche par fonctionnalité/bug".
   La première chose à faire une fois que votre projet est installé est donc de créer une branche pour votre travail.
   
   Imaginons par exemple que vous souhaitez travailler sur l'issue 1500 qui résous un problème d'affichage sur l'accueil.
   Vous pourriez suivre les étapes suivantes:
   
   - Récupérer le code le plus récent du projet principal (`git pull git@github.com/guicima/Projet-8-Todo-List.git`)
   - Commenter sur l'issue 1500 que vous commencez à travailler dessus
   - Créer une nouvelle branche, nommée par exemple `6000-fix-home-display`, dans votre fork (`git branch 6000-fix-home-display`).
     Le nom de la branche ne nous importe pas mais vous permettra de travailler sur plusieurs problèmes en même temps si vous le souhaitez. Nous vous conseillons d'inclure le numéro de l'issue en préfixe.
   - Une fois votre code écrit, l'envoyer sur votre fork (`git push`) et une fois votre modification terminée,
     créer une pull request pour proposer vos modifications au repository principal.

Vous voilà prêt à contribuer !


## Outils de travail recommandés

### Git

- Github a créé un outil en ligne de commande appelé **hub** qui est très pratique pour cloner des repositories
  et créer des pull requests. Essayez-le sur [https://hub.github.com](https://hub.github.com).
- Si vous utilisez Bash (sous Linux ou Mac OS), essayez
  [l'autocomplétion Git](https://git-scm.com/book/en/v2/Git-in-Other-Environments-Git-in-Bash) qui vous facilitera
  la vie jour après jour.
- Si vous utilisez Zsh (sous Linux ou Mac OS), essayez [oh-my-zsh](https://github.com/robbyrussell/oh-my-zsh)
  avec le plugin git qui lui aussi vous facilitera énormément la vie.
- Si vous travaillez sous Windows, nous vous recommandons d'utiliser [Cmder](http://cmder.net/) qui émule une console pour vous fournir plus de possibilités qu'avec la console de base de Windows. Vous pouvez aussi utiliser le [sous-système Ubuntu intégré nativement à Windows](https://blogs.msdn.microsoft.com/wsl/2016/04/22/windows-subsystem-for-linux-overview/).

## Je veux améliorer la documentation pour développeurs

Si vous souhaitez améliorer la documentation pour développeurs, il y a certaines choses à savoir :

- La documentation pour développeurs est disponible dans le dossier `docs`
- Pour de grosses modifications, il est généralement préférable d'ouvrir une issue pour discuter des modifications
- Nous essayons de garder le document README.md léger et de l'utiliser comme un point d'entrée vers le reste de la documentation
- Quand vous ajoutez ou modifiez de la documentation, essayez de mettre en place une navigation simple entre les documents

Pour travailler concrètement sur la documentation, créez une
[pull request](https://help.github.com/articles/about-pull-requests/) et proposez votre modification. Essayez d'expliquer dans cette pull request en quoi cette modification est utile.

## Je veux proposer une nouvelle fonctionnalité

Vous avez une idée de fonctionnalité ? N'hésitez pas à la proposer à nos équipes !

Pour cela, la première chose à faire est de vérifier que cette idée n'a pas déjà été proposée. Allez sur la liste des [issues du projet](https://github.com/guicima/Projet-8-Todo-List/issues) et recherchez si votre idée n'a pas déjà été proposée.
Si c'est le cas et qu'elle n'a pas été acceptée, vous comprendrez probablement pourquoi, et si c'est le cas mais qu'elle est en cours de développement, vous pourrez apporter votre opinion sur le sujet en commentant sur l'issue.

Si votre idée n'a jamais été proposée, alors n'hésitez pas à la proposer. Pour cela, créez une
[nouvelle issue](https://github.com/guicima/Projet-8-Todo-List/issues/new) en décrivant votre idée. 

La meilleure manière pour décrire votre idée est de décrire son fonctionnement final et à quoi l'interface devrait ressembler. Vous pouvez en plus décrire votre idée en terme de "user story":

> En tant que [acteur], je voudrais pouvoir [action], afin de [intérêt].

N'hésitez pas à ajouter des captures d'écrans de ce à quoi vous avez pensé ou à décrire les comportements attendus dans le détail. Si besoin, nous vous poserons des questions dans l'issue afin de détailler tous les cas possibles.

Si vous êtes un développeur et que vous souhaitez travailler sur votre idée, n'hésitez pas à lier votre idée à une [pull request](https://help.github.com/articles/about-pull-requests/) pour démarrer votre travail. Notez cependant que nous devrons valider votre idée avant d'accepter votre code.


## Je veux corriger un problème

Pour corriger un problème, la première chose à faire est de vérifier que ce problème n'a pas déjà été résolu sans être encore déployé en production. Allez sur la liste des [issues du projet](https://github.com/guicima/Projet-8-Todo-List/issues) et recherchez si votre problème n'a pas déjà été signalé.

Si c'est le cas et qu'il n'a pas été résolu, vous comprendrez probablement pourquoi, et si c'est le cas mais qu'il est en cours de développement, vous pourrez apporter votre opinion sur le sujet en commentant sur l'issue.

Si vous n'avez pas trouvé de signalement de votre problème, vous pouvez alors créez une
[nouvelle issue](https://github.com/guicima/Projet-8-Todo-List/issues/new) en y décrivant le bug.

Si vous êtes un développeur et que vous souhaitez travailler sur le problème, n'hésitez pas à créer une [pull request](https://help.github.com/articles/about-pull-requests/) pour démarrer votre travail et à lire la [documentation pour développeurs](../README.md) qui vous aidera à comprendre l'organisation technique du projet.

## J'ai fini mes modifications, je voudrais les proposer

Maintenant que vous avez terminé votre travail, vous devez simplement le "pusher" sur votre "fork" et créer une pull request sur le repository principal (https://github.com/guicima/Projet-8-Todo-List).

Lorsque vous ouvrirez cette pull request, automatiquement, les tests automatisés et d'autres outils seront lancés pour tester, analyser et vérifier votre code (ce processus s'appelle l'intégration continue).

Si les tests automatisés ne se passent pas correctement (si vous avez un croix rouge en face de
`continuous-integration/travis-ci/pr`), alors vous devez corriger votre code. Vous pouvez cliquer sur "Details" pour comprendre le problème. Pour réenvoyer du code dans la pull request, réexécutez simplement un push sur votre fork.
Tant que Travis aura une croix rouge, nous ne pourrons pas accepter votre code dans le projet principal.

Si d'autres outils ont une croix rouge, nous ne serons pas aussi stricts qu'avec Travis, mais nous vous demanderons peut-être des modifications. Il ne faut pas prendre mal ces demandes, nous souhaitons simplement toujours garder un haut niveau de qualité dans notre code.

Pour améliorer votre pull request et lui donner plus de chances d'être acceptée, nous vous recommandons les choses suivantes :

- Suivez les façons de faire de Symfony (http://symfony.com/doc/current/best_practices/index.html) là où vous le pouvez
- Ajoutez à votre code des tests automatisés qui échoueraient sans votre code et qui fonctionnent avec
- Mettez à jour la documentation pour développeurs par rapport à votre modification

Une fois votre code prêt et qu'il passe avec succès les différents tests automatisés, vous devez finir par quelques petites choses avant que nous puissions accepter votre pull request :

- vous devrez rebaser votre pull request sur `master` pour éviter les conflits
- vous devrez squasher vos commits en un seul commit pour améliorer la lisibilité de notre historique Git