<?php

// convert special characters to html
function escape($html) { 
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"); 
}

?>