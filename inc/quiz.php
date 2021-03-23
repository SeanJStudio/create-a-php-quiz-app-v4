<?php

/**
 * quiz.php
 * Author: Sean Johnson
 * 
 * Main logic to run a quiz
 */

// Start the session
session_start();

// Include our questions to ask
include("generate_questions.php");

$totalQuestions = NUM_OF_QUESTIONS;
$show_score = false;
$toast = null;

/**
 * Checks and keeps track of whether or not the answer was correct.
 * This only runs if we arent looking to replay
 */
if($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST["replay"])){
    if($_POST["answer"] == $_SESSION["questions"][$_POST["index"]]["correctAnswer"]){
        $toast = "Well done!";
        ++$_SESSION["totalCorrect"];
    } else {
        $toast = "Bummer! That was incorrect";
    }
}

// re-initialize our used indexes and amount correct as session variables
if(!isset($_SESSION["used_indexes"])){
    $_SESSION["used_indexes"] = [];
    $_SESSION["totalCorrect"] = 0;
}

/**
 * Update our session variables depending on if we are at the end or the
 * beginning of the quiz
 */
if(count($_SESSION["used_indexes"]) == $totalQuestions){
    $_SESSION["used_indexes"] = [];
    $show_score = true;
} else {
    $show_score = false;
    if(count($_SESSION["used_indexes"]) == 0){
        $toast = "";
        $_SESSION["totalCorrect"] = 0;
        $_SESSION["questions"] = getRandomQuestions();
    }

    do{$index = array_rand($_SESSION["questions"]);}
    while(in_array($index, $_SESSION["used_indexes"]));

    $question = $_SESSION["questions"][$index];
    array_push($_SESSION["used_indexes"], $index);
    $answers = [
        $question["correctAnswer"],
        $question["firstIncorrectAnswer"],
        $question["secondIncorrectAnswer"]
    ];
    
    shuffle($answers);
}