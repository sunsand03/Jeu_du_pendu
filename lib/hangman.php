<?php

// loads the debug file
require_once 'debug.php';

// Dictionary containing the list of words to guess
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
    'vernaculaire',
    'xylophone',
    'awalé',
    'coccyx',
    'whisky',
    'constitution',
    'cornée', 
    'rubéfier',
    'épigone',
    'laudatif',
    'ocelle',
    'pétrichor',
    'hypoténuse',
    'ouroboros',
    'mélopée',
    'syllogisme',
    'cordiforme'
];

/**
 * Returns a word randomly selected in the DICO
 *
 * @return string A word from the DICO 
 */
function getRandomWord(): string
{
    $randomIndex = array_rand(DICO);
    $word = DICO[$randomIndex];
    return $word;
}

/**
 * Returns the position of a word in the DICO
 *
 * @param string $word The word to find in the DICO
 * @return integer The index of the word in the DICO
 */
function getIndexOfWord(string $word): int|false
{
    $index = array_search($word, DICO);
    return $index;
}


/**
 * Returns the number of wrong letters in the player’s proposals
 * 
 * @param string $propositions All letters typed by the player so far
 * @param string $word The word to find
 * @return integer The number of wrong letters
 */
function countErrors(string $word, string $propositions): int
{
    // removes accents from $word and $propositions and lowercase
    $word = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $word));
    $propositions = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $propositions));

    // Initializes $errors to 0
    $errors = 0;

    // Converts $proposals to letter tables
    $propositionsArray = str_split($propositions);

    // For each letter in the proposals
    foreach ($propositionsArray as $letter) {
        // If the letter is not in the word
        if (strpos($word, $letter) === false) {
            $errors++;
        }
    }

    return $errors;
}

/**
 * Returns a string representing letters already found in the word
 * Each letter not found is replaced by a '_' (undescore)
 * Ex : 
 * getClueString('aer','partie') // Return '_ar__e'
 * getClueString('aeup','pause') // Return 'pau_e' 
 *
 * @param string $propositions The letters typed by the player so far
 * @param string $word The word to find
 * @return string The final chain of indices
 */
function getClueString(string $propositions, string $word): string
{
    //stores the length of the word to guess 
    $originalLength = mb_strlen($word, 'UTF-8');
    
    // A correspondence table to remove accents
    $transliterationArray = [
        'é' => 'e',
        'è' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'à' => 'a',
        'ù' => 'u',
        'ü' => 'u',        
        'ï' => 'i',
        'ö' => 'o'    
    ];
    //replaces special characters if found
    $wordWithoutAccents = strtr($word, $transliterationArray);

    // represents each character of the word to be found by an underscore
    $clueString = str_repeat('_', $originalLength);

    // for each character
    for ($i = 0; $i < $originalLength; $i++) {
        //Get part of string
        $character = mb_substr($word, $i, 1, 'UTF-8');
        $characterWithoutAccent = mb_substr($wordWithoutAccents, $i, 1, 'UTF-8');

        //if match found, replace the undercore with the character
        if (strpos($propositions, $characterWithoutAccent) !== false) {
            $clueString = mb_substr_replace($clueString, $character, $i, 1, 'UTF-8');
        }
    }

    return $clueString;
}

/**
 * Takes a multibyte string $string and replaces a substring within it with another string $replacement
 *
 * @param [type] $string The original string to modify
 * @param [type] $replacement The string to be inserted instead of the substring
 * @param [type] $start The starting index from which the substring begins to be repla
 * @param [type] $length The length of the substring to be replaced
 * @param [type] $encoding The character coding
 * @return void
 */
function mb_substr_replace($string, $replacement, $start, $length = null, $encoding = null) {
    // specify a character encoding if null
    if ($encoding === null) {
        $encoding = mb_internal_encoding();
    }

    // defines the length of $length if null
    if ($length === null) {
        $length = mb_strlen($string, $encoding) - $start;
    }    

    // return the replaced chain
    return mb_substr($string, 0, $start, $encoding) . $replacement . mb_substr($string, $start + $length, null, $encoding);
}    





 

 