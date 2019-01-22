<?php
session_start();

if(empty($_SESSION)){
    header('location:index.php');
} else {
    include('header.php');
}
?>