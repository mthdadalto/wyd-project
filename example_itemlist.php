<?php
error_reporting(E_ERROR | E_PARSE);
//Must have
require("itemlist.class.php");

echo "<!DOCTYPE html><hr1>Example - itemlist</hr1><br>";

//load full itemlist
//Initialize a itemlist (tmsrv/run/itemlist.csv)
$itemlist=new itemlist("./", "127.0.0.1", "root", "password", "wyd-project");
echo $itemlist->read_to_db();

?>
