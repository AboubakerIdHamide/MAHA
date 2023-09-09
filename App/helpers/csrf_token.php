<?php

function csrf_token($token = null) {
    if($token){
        // Check if is a valid token
        if($token !== session('csrf_token')->get() || session('expired_at')->get() <= time()){
            session('csrf_token')->remove();
            session('expired_at')->remove();
            return false;
        }
        return true;
    }

    // Generate and set the token
    $token = bin2hex(openssl_random_pseudo_bytes(35));
    $expired_at = time() + 60 * 30;

    session('csrf_token')->set($token);
    session('expired_at')->set($expired_at);
}