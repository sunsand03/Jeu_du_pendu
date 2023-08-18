<?php

// charge le fichier de débug
require_once 'debug.php';

// Dictionnaire contenant la liste des mots à deviner
const DICO = [
    'carabistouille',
    'calembredaine',
    'bilevesée',
    'coxigrue',
    'cacochyme',
    'prolégomène',
    'calembour',
    'parthénogenèse',
    'antépénultième',
    'aréopage',
    'paracétamol',
    'cucurbitacées',
    'coloquinte',
    'vernaculaire'
];

/**
 * Renvoie un mot choisi aléatoirement dans le  DICO
 *
 * @return string Un mot du dictionnaire DICO
 */
function getRandomWord():string{
    
    $word = DICO[array_rand(DICO,1)];
    return $word;
}

/**
 * Renvoie la position d'un mot dans le DICO
 *
 * @param string $word Le mot à chercher dans le DICO
 * @return integer L'index du mot dans le DICO
 */
function getIndexOfWord(string $word):int|false{
    $index = array_search($word, DICO);
    return $index;
}

/**
 * Renvoie le nombre de lettres erronées dans les propositions du joueurs
 * 
 * @param string $propositions Toutes les lettres tapées par le joueur jusqu'ici
 * @param string $word Le mot à trouver
 * @return integer Le nombre de lettres erronées
 */
function countErrors(string $word,string $propositions): int{
// retire les accents contenus dans $word et $propositions et les mets en minuscule
$word = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $word));
$propositions = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $propositions));

// Initialise $errors à 0
$errors = 0;

// Convertit $propositions en tableaux de lettres
$propositionsArray = str_split($propositions);

// Pour chaque lettre dans les propositions
foreach ($propositionsArray as $letter) {
    // Si la lettre n'est pas dans le mot
    if (strpos($word, $letter) === false) {
        $errors++;
    }
}

return $errors;
}

/**
 * Renvoie une chaîne représentant les lettres déjà trouvées dans le mot
 * Chaque lettre non trouvée est remplacée par un '_' (undescore)
 * Ex : 
 * getClueString('aer','partie') // Renvoie '_ar__e'
 * getClueString('aeup','pause') // Renvoie 'pau_e'
 * ATTENTION ! IL VA, LA AUSSI, FALLOIR TROUVER COMMENT RETIRER TOUS LES ACCENTS À TROUVER 
 *
 * @param string $propositions Les lettres tapées par le joueur jusqu'ici
 * @param string $word Le mot à trouver
 * @return string La chaîne d'indices finale
 */
function getClueString(string $propositions, string $word): string{
    // retire les accents contenus dans $word et les met en minuscule
    $word = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $word));

     // Initier une chaîne vide pour le mot indice
     $clueString = '';
 
     // Pour chaque lettre dans le mot à trouver $word
     for ($i = 0; $i < strlen($word); $i++) {
         // Si la lettre est dans les propositions
         if (strpos($propositions, $word[$i]) !== false) {
             // Ajouter la lettre au mot indice
             $clueString .= $word[$i];
         } else {
             // Sinon, ajouter un underscore
             $clueString .= '_';
         }
     }
 
     // Renvoyer le mot indice
     return $clueString;
}


 

// //tests
// $word = getRandomWord();
// // $word = "encracer";
// echo "mot à deviner :". $word . "\n";
// // $index = getIndexOfWord($word);
// // echo "index du mot dans le dico : ".$index . "\n";
// $propositions = "enrace";
// $nb_errors = countErrors($propositions,$word);
// echo " Il y a ". $nb_errors. " erreurs". "\n";
// $test = getClueString($propositions,$word);
// echo $test . "\n"; 