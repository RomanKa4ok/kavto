<?php
session_start();
if (isset($_POST['logout']))
{

    unset($_SESSION['admin']);
    session_destroy();
    header('Location: http://kavto.local');
}