# Hangman (le jeu du pendu)

## Description

Hangman is a word guessing game.
The program chooses a word randomly, and the player has to guess this word.
The number of characters to be guessed is indicated to the player via underscores.
The player proposes one character at a time, without accents. If it is contained in the word to be guessed, it replaces the corresponding underscore.
The player is allowed 6 mistakes to find the word.
**The game is in French**.

Here are the different files of the project:

- `"index.php"` : main controller of the game containing all logic
- `"hangman.php"` : library containing the functions necessary for the proper functioning of the game.
- `"index.phtml"` : the view of the project

## Principles

The logic of the program is structured as follows:

1. At the beginning of the game (first round), a word is randomly chosen by the program from DICO, the dictionary of pre-recorded words. The index is memorized, and it is written in a hidden field of the form to find it in subsequent rounds.

2. Also recorded in the form (in a hidden field) are the proposals made by the player since the start of the game, in the form of a string containing all the letters entered so far. This string is, of course, empty at the beginning of the game.

3. When the player enters a letter in the only available field, this letter is retrieved and added to the list of his or her proposals.

4. We create the character string that serves as a clue to the player to know the position of the letters he or she has already found. Unfound letters are replaced by '_' (underscore). To do this, we simply compare the word to be found with the player's list of proposals. For example, if the word to be found is ``cheval`` and the player has already proposed the letters ``aeiscl``, we will obtain the string ``c_e_al``. This string is identified by "cluestring" throughout the program. It is displayed in the final HTML to help the player.

5. We count the player's mistakes with an algorithm similar to the one used to create the cluestring. Example: keeping ``cheval`` as the word to find and ``aeiscl`` as the player's proposals, the program will find that the player has made 2 mistakes. This number is vital since it allows us to know when the player has lost and, above all, to display the correct image for the hangman ("0.svg" for 0 errors, "1.svg" for 1 error, etc.)

6. We check if the player has lost, if there are 6 errors or more.

7. We check if the player has won, if there are no more '_' in the cluestring.

8. Just for cleanliness, the program offers to change the CSS class of cluestring if it is too long, to avoid exceeding the edges of the screen.