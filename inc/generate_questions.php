<?php

/**
 * generate_questions.php
 * Author: Sean Johnson
 * 
 * A collection of functions to dynamically create random questions of
 * addition which can easily be customized to your liking.
 */

/**
 * Initialize constants for question complexity.
 * Modify these constants to change how you would like the quiz to behave
 */
define("NUM_OF_QUESTIONS", 10);
define("MIN_NUM_TO_ADD", 0);
define("MAX_NUM_TO_ADD", 100);
define("ANSWER_VARIATION", 10);

// Returns a random integer between MIN_NUM_TO_ADD and MAX_NUM_TO_ADD inclusive
function getRandomNumber(){
    return rand(MIN_NUM_TO_ADD, MAX_NUM_TO_ADD);
}

/**
 * Takes an answer of type integer as a paramater and returns a random integer
 * that is equal to the answer + or - ANSWER_VARIATION but not the answer itself
 */
function getIncorrectAnswer($answer){
    do{
        $randomNumber = $answer + rand(-ANSWER_VARIATION, ANSWER_VARIATION);
    }while($randomNumber === $answer || $randomNumber < MIN_NUM_TO_ADD);

    return $randomNumber;
}

/**
 * Returns a random question as an associative array that ensures that each
 * answer for the user to select is unique
 */
function getRandomQuestion(){

    $leftAdder = getRandomNumber();
    $rightAdder = getRandomNumber();
    $correctAnswer = $leftAdder + $rightAdder;

    $firstIncorrectAnswer = getIncorrectAnswer($correctAnswer);

    do{$secondIncorrectAnswer = getIncorrectAnswer($correctAnswer);
    } while($secondIncorrectAnswer === $firstIncorrectAnswer);

    $question = [
        "leftAdder" => $leftAdder,
        "rightAdder" => $rightAdder,
        "correctAnswer" => $correctAnswer,
        "firstIncorrectAnswer" => $firstIncorrectAnswer,
        "secondIncorrectAnswer" => $secondIncorrectAnswer
    ];

    return $question;
}

// Returns a multi-dimensional array of questions the size of NUM_OF_QUESTIONS
function getRandomQuestions(){
    $questions = [];

    for($i = 0; $i < NUM_OF_QUESTIONS; ++$i)
        $questions[] = getRandomQuestion();
        
    return $questions;
}