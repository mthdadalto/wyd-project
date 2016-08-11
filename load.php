<?php
require("mob.class.php");
$conta=new account("./cont/account");
$conta->read("etaa","full");
echo nl2br(print_r($conta->account_char_all(),true));
?>