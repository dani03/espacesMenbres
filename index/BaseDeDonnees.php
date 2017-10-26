<?php
function connect_data_base(){
  try {
     $bdd = new PDO('mysql:host=localhost;dbname=espaceMenbres;charset=utf8', 'phpmyadmin','root');
  } catch (Exception $e) {
    die($e->getMessage());
  }
  return $bdd;
}

















 ?>
