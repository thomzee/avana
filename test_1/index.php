<?php

$string = "a (b c (d e (f) g) h) i (j k)";
$openParenthesis = 2;

/**
 * The function below to find the closing parenthesis position
 *
 * @param $string
 * @param $openParenthesis
 *
 * @return void
 */
function findCloseParenthesis($string, $openParenthesis)
{
    $string = str_replace(' ', '', $string);
    echo "Given string is $string and opening parenthesis position at $openParenthesis\n";

    $depth = 1;
    $arrayChars = str_split($string);

    for ($i=$openParenthesis; $i<sizeof($arrayChars); $i++) {
        if ($arrayChars[$i] == '(') {
            $depth++;
        } elseif ($arrayChars[$i] == ')') {
            $depth--;
            if ($depth == 0) {
                $pos = $i+1;
                echo "The closing parenthesis position found at $pos\n";
                break;
            }
        }
    }
}

findCloseParenthesis($string, $openParenthesis);