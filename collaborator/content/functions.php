<?php
        ## Check if a number is a counting number by checking if it
        ## is an integer primitive type, or if the string represents an integer as a string
        function is_int_val($data) {
                if (is_int($data) === true) return true;
                elseif (is_string($data) === true && is_numeric($data) === true) {
                        return (strpos($data, '.') === false);
                }
                return false;
        }
?>

