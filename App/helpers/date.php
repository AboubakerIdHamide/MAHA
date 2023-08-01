<?php

function isInSameWeekAsToday($givenDate) {
    // Get the current date (today)
    $today = new DateTime();

    // Create a DateTime object for the given date
    $givenDateTime = new DateTime($givenDate);

    // Check if the given date and today's date are in the same week
    return ($givenDateTime->format('W') === $today->format('W') && $givenDateTime->format('Y') === $today->format('Y'));
}
