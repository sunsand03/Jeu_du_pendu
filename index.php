<?php

//charge le fichier hangman contenant les fonctions et le fichier de débug
require_once './lib/hangman.php';
require_once './lib/debug.php';

// VARIABLES NÉCESSAIRES
$lettre = ' ';       // LA LETTRE QUI VIENT D'ÊTRE SAISIE PAR L'UTILISATEUR (SI PAS LE PREMIER ROUND)
$propositions   = '';       // CHAÎNE DE CARACTÈRES REGROUPANT L'ENSEMBLE DE TOUTES LES PROPOSITIONS FAITES PAR LE JOUEUR JUSQU'ICI
$index          = 0;       // INDEX DU MOT À TROUVER DANS LE DICTIONNAIRE DICO

$word = "";       // LE MOT À TROUVÉ CHOISI ALÉATOIREMENT DANS LE DICO ET RETROUVÉ À CHAQUE TOUR GRÂCE À L'INDEX
$clueString     = '';       // LA CHAÎNE À AFFICHER AU JOUEUR POUR LUI INDIQUER L'ENPLACEMENT DES LETTRES DÉJÀ TROUVÉES (LES LETTRES NON TROUVÉES SONT REPLACÉES PAR DES '_')
$nbErrors       = 0;        // NOMBRE D'ERREURS FAITES JUSQU'ICI PAR LE JOUEUR (À 6, C'EST GAME OVER)
$lost           = false;    // TRUE SI LE JOUEUR A PERDU
$won            = false;    // TRUE SI LE JOUEUR A GAGNÉ
$clueCSSClass   = '';       // CLASSE CSS À AJOUTER À LA CLUESTRING ON FONCTION DE LA LONGUEUR DU MOT (POUR QUE CELA RENTRE DANS L'ÉCRAN)

// *********************

// *********************

// SI LA LETTRE EXISTE DANS $_POST (envoie du formulaire)
if (isset($_POST['lettre'])){
    // RÉCUPÉRER LA LETTRE DANS UNE VARIABLE
    $lettre = $_POST['lettre'];
}
    // PASSER LA LETTRE EN MINUSCULE
    $lettre = strtolower($lettre);
    // SI ON A SAISI PLUS DE 1 CARACTÈRE
    if (strlen($lettre)>1){
        // VIDER LA VARIABLE LETTRE
        $lettre = '';
    }    
    // FIN SI

    // SI LA LETTRE NE FAIT PAS PARTIE DES LETTRES AUTORISÉES (ALPHABET)
    if (!preg_match("/^[a-zA-Z]$/", $lettre)) {
    
        // VIDER LA VARIABLE LETTRE
        $lettre = '';
    }    
    // FIN SI
// FIN SI


// SI L'INDEX DU MOT A TROUVER EXISTE DANS $_POST
if (isset($_POST['index'])) {
    // RÉCUPÉRER L'INDEX DANS UNE VARIABLE
    $index = $_POST['index'];
}
// FIN SI

// SI "PROPOSITIONS" EXISTE DANS $_POST
if (isset($_POST['propositions'])) {
    // RÉCUPÉRER "PROPOSITIONS" DANS UNE VARIABLE
    $propositions = $_POST['propositions'];
}
// FIN SI
 
// SI ON COMMENCE LA PARTIE (index est égal à -1)
if ($index === -1) {
    // CHOISIR UN MOT AU HASARD EST LE STOCKER DANS UNE VARIABLE
    $word = getRandomWord();
    // RECUPERER L'INDEX DU MOT ET LE STOCKER DANS UNE VARIABLE
    $index = getIndexOfWord($word);
    // ATTENTION, CETTE VARAIBLE DEVRA ÊTRE STOCKÉE DANS LE HTML SOU LA FORME D'UN INPUT TYPE HIDDEN
    // POUR POUVOIR ÊTRE RETROUVÉ PLUS TARD LORS DES ROUNDS SUIVANTS
}    
// FIN SI


// LA LETTRE QUE L'UTILISATEUR VIENT DE SAISIR N'EST PAS DÉJÀ DANS LES PROPOSITIONS PRÉCÉDENTES
if (strpos($propositions, $lettre) === false) {
    // CONCATÉNER CETTE LETTRE AUX PROPOSITIONS PRÉCÉDENTES
    $propositions .= $lettre;
}

// FIN SI


// RÉCUPÉRER LE MOT DANS LE DICO EN UTILISANT L'INDEX
$word = DICO[$index]; 
// CRÉER LA "CLUESTERING" EN REMPLACANT, DANS LE MOT, LES LETTRES NON TROUVÉES PAR DES '_' (APPEL À LA FONCTION getClueString() )
$clueString = getClueString($word, $propositions);
// RÉCUPÉRER LE NOMBRE D'ERREURS DU JOUEUR (APPEL À LA FONCTION countErrors() )
$nbErrors = countErrors($word, $propositions);

// SI ON A 6 ERREURS OU PLUS,
if ($nbErrors >= 6) {
    // ON A PERDU, METTRE LA BONNE VARIABLE À TRUE
    $lost = true;
}
// FIN SI


// SI IL N'Y A PLUS DE '_' DANS LA CLUESTRING
if (strpos($clueString, '_') === false) {
    // ON A GAGNÉ, METTRE LA BONNE VARIABLE À TRUE
    $won = false;
}
// FIN SI



// SI LE MOT FAIT PLUS DE 9 CARACTÈRES
if (strlen($word) > 9) {
    // ECRIRE 'clue-small' DANS $clueCSSClass
    $clueCSSClass = 'clue-small';
}   
// FIN SI
    
// SI LE MOT FAIT PLUS DE 12 CARACTÈRES
if (strlen($word) > 12) {    
    // ECRIRE 'clue-tiny' DANS $clueCSSClass
    $clueCSSClass = 'clue-tiny';
}
// FIN SI

// d($lost);
d($won);


// CHARGEMENT DE LA VUE
include './templates/index.phtml';