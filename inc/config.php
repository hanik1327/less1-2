<?php
session_start();

require('rb-mysql.php');

R::setup('mysql:host=localhost;dbname=less','root',''); //mysql host dbname dbuser dbpass

if(!R::testConnection()) die('NoDBConnect');

R::ext('xdispense', function( $type ){
  return R::getRedBean()->dispense( $type );
});

?>
