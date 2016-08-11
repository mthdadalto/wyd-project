<?php
//Must have
require("mob.class.php");

//CASE 1 - Player account
//Initialize a folder (dbsrv/run/account)
$acc=new account("./example_account");

//Find and open a account to class scope
$acc->read("etaa","full");//full load entire file weight and primary load just account and password

//You are ready to access primary information from account
echo nl2br(print_r($acc->account_primary,true));

//Give you a array containing all char informations
$readed_chars=$acc->account_char_all();
/*
You can use $acc->account_char(0) to return first char only [0,1,2,3]
if don't exist will retun false
*/

echo "<!DOCTYPE html><hr1>First example - Player Account</hr1><br>";
//var_dump array returned
echo nl2br(print_r($readed_chars,true));

?>
