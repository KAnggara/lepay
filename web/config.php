<?php

/**
 * using mysqli_connect for database connection
 */

$databaseHost = '203.161.184.89';
$databaseName = 'sopfurni_wapi';
$databaseUsername = 'sopfurni_wapi';
$databasePassword = 'l26xJdQBbO1I';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
