<?php

/**
 * Debug function
 */
function debug( $var, $text = ''){

    // DISPLAYS A TABLE OR OBJECT
    if (is_array($var) ||  is_object($var)){
        if ($text){
            echo $text . ' : ' . '<br>';
        }

        echo '<pre>';
        print_r($var);
        echo '</pre>';
    } else {

        // BOOLEAN MANAGEMENT
        if ($var === true){
            $var = ('true');
        }
        if ($var === false){
            $var = ('false');
        }

        // DISPLAYS JUST A SINGLE VARIABLE
        if ($text){
            echo $text . ' : ' . $var. '<br>';
        } else {
            echo $var. '<br>';
        }
    }
}

/**
 * shortcut to the debug function
 */
function d( $var,  $text = ''){
    debug($var, $text);
}