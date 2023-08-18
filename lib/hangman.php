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
function countErrors(string $propositions, string $word): int{
    

    // retire les accents contenus dans $word et $propositions et les mets en minuscule
    $comparaison = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $word));
    $propositions = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $propositions));

    // Initialise $errors à 0
    $errors = 0;

    // Convertit $propositions en tableaux de lettres
    $propositionsArray = str_split($propositions);
   
    // Convertit $comparaison en tableau de lettres
    $comparaisonArray = str_split($comparaison);
    
    // Pour chaque lettre dans les propositions
    foreach ($propositionsArray as $index => $letter) {
        // Si la lettre n'est pas à la même position dans le mot
        if ($comparaisonArray[$index] !== $letter) {
            $errors++;
        }        
    }
    // Si les mots n'ont pas la même longueur, compte le reste des lettres comme erreurs
    $errors += abs(strlen($propositions) - strlen($word));

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
    // Supprime les accents du mot à trouver $word
     $word = iconv('UTF-8', 'ASCII//TRANSLIT', $word);

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


 

//tests
$word = getRandomWord();
// $word = "encracer";
echo "mot à deviner :". $word . "\n";
// $index = getIndexOfWord($word);
// echo "index du mot dans le dico : ".$index . "\n";
$propositions = "enrace";
$nb_errors = countErrors($propositions,$word);
echo " Il y a ". $nb_errors. " erreurs". "\n";
$test = getClueString($propositions,$word);
echo $test . "\n"; 