<?php

// loads hangman file containing functions and debug file
require_once './lib/hangman.php';
require_once './lib/debug.php';

// necessary variables
$letter = ' ';       // the letter that has just been entered by the user (if not the first round)
$proposals   = '';       // string of characters grouping all the proposals made by the player so far
$index = -1;       // index of the word to be found in the DICO dictionary

$word = "";       // the word found randomly chosen in the DICO 
$clueString     = '';       // the string to display to the player to indicate the placement of letters already found (letters not found are replaced by '_')
$nbErrors       = 0;        // number of mistakes made so far by the player (at 6, it’s game over)
$lost           = false;    // TRUE if the player has lost
$won            = false;    // TRUE if the player has won
$clueCSSClass   = '';       // css class to be added to the cluestring based on the length of the word (to fit in the screen)

// *********************

// if letter exists in $_post (form submission)
if (isset($_POST['letter'])){
    // retrieve the letter in a variable
    $letter = $_POST['letter'];
}
    // lower case
    $letter = strtolower($letter);
    // if more than 1 character
    if (strlen($letter)>1){
        // empty the letter variable
        $letter = '';
    }  
   
    // if the letter is not part of the authorized letters (alphabet)
    if (!preg_match("/^[a-zA-Z]$/", $letter)) {
    
        // empty the variable letter
        $letter = '';
    }    
    
// if the index of the word to be found exists in $_post
if (isset($_POST['index'])) {
    // retrieve the index in a variable
    $index = $_POST['index'];
}


// if "proposals" exists in $_post
if (isset($_POST['proposals'])) {
    // retrieve "proposals" in a variable
    $proposals = $_POST['proposals'];
}

 
// if you start the game (index is equal to -1)
if ($index === -1) {
// randomly pick a word and store it in a variable
$word = getRandomWord();
// retrieve the index of the word and store it in a variable
$index = getIndexOfWord($word);
}   

// if the letter that user just entered is not already in previous proposals
if (strpos($proposals, $letter) === false) {
    // concatenate this letter to previous proposals 
    $proposals .= $letter;
}

// retrieve the word in the DICO using the index
$word = DICO[$index]; 

// creates the "cluestering" by replacing, in the word, the letters not found by '_'
$clueString = getClueString($proposals, $word);
// retrieve the number of player errors 
$nbErrors = countErrors($word, $proposals);

// if there are 6 or more errors, the player has lost
if ($nbErrors >= 6) {    
    $lost = true;
}


// if there is no more '_' in the cluestring, the player has won
if (strpos($clueString, '_') === false) {    
    $won = true;
}


// if the word is more than 9 characters
if (strlen($word) > 9) {
    // write 'clue-small' in $cluecssclass
    $clueCSSClass = 'clue-small';
}   

    
// if the word is more than 12 characters
if (strlen($word) > 12) {    
    // write 'clue-tiny' in $clueCSSClass
    $clueCSSClass = 'clue-tiny';
}
;


// loads the view
include './templates/index.phtml';