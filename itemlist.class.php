<?php
/*
 * WYD itemlist file management class
 * Developer: Matheus Dadalto
 * OpenSource
 * Version: 0.1
 * @2016
 */

error_reporting(E_ERROR | E_PARSE);
class itemlist {
  private $path="./";
  private $SQL;

	//Point to choose itemlist path like C:/WYD/tm/run
	function __construct($path, $host, $user, $password, $database){
	    $this->file=$path;
      $this->SQL = new PDO('mysql:host='.$host.
      ';dbname='.$database.
      ';charset=utf8',
      $user, $password);
    }

    public function create_from_db($table="itemlist"){

    }

    public function read_to_db($table="itemlist"){
      if(!file_exists($this->path)){return false;}
      $db=$this->SQL;
      $db->query('CREATE TABLE IF NOT EXISTS `'.$table.'` (
       `itemid` int(11) NOT NULL,
       `name` varchar(30) NOT NULL,
       `mesh` float NOT NULL,
       `rq_level` smallint(5) NOT NULL,
       `rq_str` smallint(5) NOT NULL,
       `rq_int` smallint(5) NOT NULL,
       `rq_dex` smallint(5) NOT NULL,
       `rq_con` smallint(5) NOT NULL,
       `unique` int(11) NOT NULL,
       `EF_PRICE` int(11) NOT NULL,
       `EF_POS` smallint(5) NOT NULL,
       `extreme` smallint(5) NOT NULL,
       `grade` smallint(5) NOT NULL,
       `n0` smallint(3) NOT NULL, `v0` smallint(3) NOT NULL,
       `n1` smallint(3) NOT NULL, `v1` smallint(3) NOT NULL,
       `n2` smallint(3) NOT NULL, `v2` smallint(3) NOT NULL,
       `n3` smallint(3) NOT NULL, `v3` smallint(3) NOT NULL,
       `n4` smallint(3) NOT NULL, `v4` smallint(3) NOT NULL,
       `n5` smallint(3) NOT NULL, `v5` smallint(3) NOT NULL,
       `n6` smallint(3) NOT NULL, `v6` smallint(3) NOT NULL,
       `n7` smallint(3) NOT NULL, `v7` smallint(3) NOT NULL,
       `n8` smallint(3) NOT NULL, `v8` smallint(3) NOT NULL,
       `n9` smallint(3) NOT NULL, `v9` smallint(3) NOT NULL,
       `n10` smallint(3) NOT NULL, `v10` smallint(3) NOT NULL,
       `n11` smallint(3) NOT NULL, `v11` smallint(3) NOT NULL,
       `modify_date` datetime,
       PRIMARY KEY (`itemid`)) ENGINE=MyISAM;');
      $this->SQL->query('TRUNCATE '.$table);

      $itemlist=file($path."itemlist.csv",FILE_SKIP_EMPTY_LINES);
      $c=0;
      foreach($itemlist as $item){
        $eitem = array();
        $eitem=explode(",",$item);

        $this->SQL->query("INSERT INTO `".$table."`
        (`itemid`, `name`, `mesh`, `rq_level`, `rq_str`, `rq_int`, `rq_dex`, `rq_con`,
        `unique`, `EF_PRICE`, `EF_POS`, `extreme`, `grade`,
        `n0`, `v0`, `n1`, `v1`, `n2`, `v2`, `n3`, `v3`, `n4`, `v4`, `n5`, `v5`, `n6`, `v6`,
        `n7`, `v7`, `n8`, `v8`, `n9`, `v9`, `n10`, `v10`, `n11`, `v11`, `modify_date`)
        VALUES (
        '".$eitem[0]."',
        '".$eitem[1]."',
        '".$eitem[2]."',
        '".$eitem[3]."', '".$eitem[4]."', '".$eitem[5]."', '".$eitem[6]."', '".$eitem[7]."',
        '".$eitem[8]."',
        '".$eitem[9]."',
        '".$eitem[10]."',
        '".$eitem[11]."',
        '".$eitem[12]."',
        '".$eitem[13]."', '".$eitem[14]."',
        '".$eitem[15]."', '".$eitem[16]."',
        '".$eitem[17]."', '".$eitem[18]."',
        '".$eitem[19]."', '".$eitem[20]."',
        '".$eitem[21]."', '".$eitem[22]."',
        '".$eitem[23]."', '".$eitem[24]."',
        '".$eitem[25]."', '".$eitem[26]."',
        '".$eitem[27]."', '".$eitem[28]."',
        '".$eitem[29]."', '".$eitem[30]."',
        '".$eitem[31]."', '".$eitem[32]."',
        '".$eitem[33]."', '".$eitem[34]."',
        '".$eitem[35]."', '".$eitem[36]."',
        CURRENT_TIME());");
        $c++;
      }
return $c;
	   }

   }
?>
