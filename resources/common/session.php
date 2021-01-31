<?php

$database = new Db();
$db = $database->connect();

$session = new Session($db);