<?php
//Must have
require("mob.class.php");

//CASE 2 - mob/npc
//Initialize a folder (tmsrv/run/npc)
$acc=new account("./example_npc");

//Find and open a account to class scope
$acc->read("Aberes","mob");//mob load entire file weight

//Give you a array containing all char informations
$readed_mob=$acc->account_char('mob');

echo "<!DOCTYPE html><hr1>Second example - NPC/MOB Account</hr1>";
//var_dump array returned
echo nl2br(print_r($readed_mob,true));
?>
