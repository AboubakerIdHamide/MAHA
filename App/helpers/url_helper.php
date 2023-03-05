<?php
// Simple page redirect
function redirect($page = ""){
  ob_start();
  header('location: '.URLROOT.'/'.$page);
  ob_end_clean();
}