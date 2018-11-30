<?php

$password = $_GET['password'];

echo password_hash($password,PASSWORD_DEFAULT);

?>