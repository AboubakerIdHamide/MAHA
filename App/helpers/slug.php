<?php

function slug($title) {
    // Convert the title to lowercase
    $slug = strtolower($title);
    
    // Replace spaces with dashes
    $slug = str_replace(' ', '-', $slug);
    
    // Remove special characters and anything that's not a letter, number, dash, or underscore
    $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
    
    // Remove multiple dashes if any
    $slug = preg_replace('/-+/', '-', $slug);
    
    // Trim dashes from the beginning and end of the slug
    $slug = trim($slug, '-');
    
    return $slug;
}

function reverseSlug($slug) {
    // Replace dashes with spaces
    $title = str_replace('-', ' ', $slug);
    
    // Convert the first character of each word to uppercase
    $title = ucwords($title);

    return $title;
}