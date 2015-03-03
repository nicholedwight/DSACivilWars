<?php

$Db = Database::getInstance();
$battles = new Battles($Db);

$allData = $battles->getAllData();
echo "<pre>";
var_dump($allData);
