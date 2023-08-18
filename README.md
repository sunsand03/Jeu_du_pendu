###### PHP - algorithmie avancée
# Le jeu du pendu

## Énoncé

Cet exercice va vous permettre de recréer le jeu du pendu en PHP. Tout le programme est à implémenter dans les deux fichiers :

- `"index.php"` : contrôlleur principal du jeu contenant toute la logique
- `"hangman.php"` : librairie contenant quatre fonctions nécessaire au bon fonctionnement du jeu.

## Principes

La logique du programme s'articule comme ceci :

1. Au début de la partie (premier round), un mot est choisi aléatoirement par l'ordinateur dans un dictionnaire de mots pré-enregistrés. On en mémorise l'index, qui est écrit dans un champ caché du formulaire pour le retrouver lors des rounds suivants.

2. Sont aussi enregistrées dans le formulaires en champ caché, les propositions faites par le joueur depuis le début de la partie sous la forme d'une chaîne de caractère contenant toutes les lettres saisies depuis le début. Cette chaîne est, bien entendu, vide en début de partie.

3. Lorsque le joueur saisi une lettre dans le seul champ disponible, cette lettre est récupérée et ajoutée à la liste de ses propositions.

4. On crée la chaîne de caractère qui sert d'indice au joueur pour connaître la position des lettres qu'il a déjà trouvé. Les lettres non trouvées sont remplacer par des `'_'` (underscore). Pour cela, on compare simplement le mot à trouver avec la liste des propositions du joueur. Par exemple, si le mot à trouver est `cheval` et que le joueur à déjà propose les lettres `aeiscl`, on obtiendra la chaîne `c_e_al`. Cette chaîne est identifiée par `"cluestring"` dans tout le programme. Elle est affichée dans le html final pour aider le joueur.

5. On compte les erreurs du joueur avec un algorithme similaire à celui permettant la création de la cluestring. Eexemple : en gardant `cheval` comme mot à trouver et `aeiscl` comme propositions du joeurs, Le programme trouvera que le joueur à fit `2` erreurs. Ce nombre est vital puisqu'il permet de savoir quand le joueur à perdu et, surtout, d'afficher la bonne image pour le pendu (`"0.svg"` pour 0 erreur, `"1.svg"` pour 1 erreur, ...)

6. On vérifie si le joueur a perdu, si il y a 6 erreurs ou plus.

7. On vérifie si le joueur a gagné, si il n'y a plus de `'_'` dans la `cluestring`

8. Juste pour la propreté, le programme propose de changer la classe CSS de `cluestring` si celle-ci est trop longue, cela afin d'éviter de dépasser des bords de l'écran.

## Étapes conseillées

Commencez par implémenter les quatres fonctions du fichier `"hangman.php"`. Ce fichier ne contient pas de pseudo-code, mais les commentaires de documentation des fonctions sont suffisemment clairs pour que vous puissiez en déduire le code à écrire.

Ensuite, passez à `"index.php"`. Celui-ci est plus complexe. Aussi, tout le pseudo-code vous est fourni, à vous de trouver le code équivalent. Un soin particulier à été apporté au fait d'acoir une ligne de pseudo-code pour une ligne de code final. Ainsi, vous devriez pouvoir comprendre la logique du programme et être capable de l'implémenter par vous-même.

## À propos du PHTML

La vue `index.phtml` est disponible en deux versions :

- Le fichier `index.phtml`, bien que largement commenté, ne contient aucune trace de PHP, ce sera à vous d'injecter les bonnes variables PHP aux bons endroits et à implémenter les conditions pour afficher les bons morceaux de HTML au bon moment.
- Le fichier `index.ready.phtml` est prêt à l'emploi, pour ceux qui ne veulent pas s'embêter à écrire le PHP dans le template.

> Bonne chance !