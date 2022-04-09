<?php

// We use this function to check the data and make it secure.
function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8'); // ENT_QUOTES will convert both single and double quotes.
}