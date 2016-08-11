<?php
/*
 * WYD Account/mob file management class
 * Developer: Matheus Dadalto
 * OpenSource
 * Version: 0.1
 * @2016
 */


class account {
    private $path="./";
	public $account;
	public $account_status;
	private $initial;
	public $data;
	private $account_attr=array();
	private $char_struct=array();

	//Point to account path
	function __construct($path){
	    if(!is_dir($path)){return false;}
	    $this->path=$path;
	}

	//Read a account content to $data
	public function read($account, $mode="full"){
	    $this->initial=$account[0];
	    if(!file_exists($this->path.'/'.$account[0].'/'.$account)){
	        return false;
	    }
	    $this->account=$account;
	    $res=@fopen($this->path.'/'.$account[0].'/'.$account,"r");
	    switch ($mode){
	        case 'full':
	           $read=@fread($res, 4292);
	           $this->data=strtoupper(trim(bin2hex($read)));
	           break;
	        case 'primary':
	            $read=@fread($res, 32);
	            $this->data=strtoupper(trim(bin2hex($read)));
	           break;
	        case 'mob':
	            $read=@fread($res, 756);
	            $this->data=strtoupper(trim(bin2hex($read)));
	           break;
	    }
	    fclose($res);
	    return true;
	}

	//Load all char informations
	public function account_char_all(){
	    for($i=0;$i<4;$i++){
	        $char[$i] = $this->account_char($i);
	    }
	    return array_filter($char);
	}

	//Load one char informations
	public function account_char($number){
	    return $this->read_mob(substr($this->data,416+(1512*$number),1512));
	}

	//Return char informations by data to $char
	protected function read_mob($data){
	    if(strlen($data)!=1512){return false;}
	    $name=hex2bin(explode('00',substr($data, 0, 24))[0]);
	    if($name==""){return false;}
	    $attr=array(
	        "name"     =>$name,
	        "race"     =>$this->hex2num(substr($data, 32,2)),
	        "merchant" =>$this->hex2num(substr($data, 34,2)),
	        "class"    =>$this->hex2num(substr($data, 40,2)),

	        "gold"     =>$this->hex2num(substr($data, 48,8)),
	        "exp"      =>$this->hex2num(substr($data, 56,8)),
	        "cordx"    =>$this->hex2num(substr($data, 64,4)),
	        "cordy"    =>$this->hex2num(substr($data, 68,4)),
	        "level"    =>$this->hex2num(substr($data, 72,4))+1,

	        "defence"  =>$this->hex2num(substr($data, 76,4)),
	        "atack"    =>$this->hex2num(substr($data, 80,4)),

	        "str"      =>$this->hex2num(substr($data, 104,4)),
	        "int"      =>$this->hex2num(substr($data, 108,4)),
	        "dex"      =>$this->hex2num(substr($data, 112,4)),
	        "con"      =>$this->hex2num(substr($data, 116,4)),

	        "skill"    =>array(    $this->hex2num(substr($data, 120,2)),
	                               $this->hex2num(substr($data, 122,2)),
	                               $this->hex2num(substr($data, 124,2)),
	                               $this->hex2num(substr($data, 126,2)) ),

	        "hp_max" =>$this->hex2num(substr($data, 144,4)),
	        "hp_now" =>$this->hex2num(substr($data, 148,4)),
	        "mp_max" =>$this->hex2num(substr($data, 152,4)),
	        "mp_now" =>$this->hex2num(substr($data, 156,4)),

	        "frag_now" =>$this->hex2num(substr($data, 1454,2)),
	        "frag_max" =>$this->hex2num(substr($data, 1458,2)),

	        "pt_attr"  =>$this->hex2num(substr($data, 1472,4)),
	        "pt_espec" =>$this->hex2num(substr($data, 1476,4)),
	        "pt_skill" =>$this->hex2num(substr($data, 1480,4)),

	        "hp_regen" =>$this->hex2num(substr($data, 1500,2)),
	        "mp_regen" =>$this->hex2num(substr($data, 1502,2)),

	        "res1"     =>$this->hex2num(substr($data, 1504,2)),
	        "res2"     =>$this->hex2num(substr($data, 1506,2)),
	        "res3"     =>$this->hex2num(substr($data, 1508,2)),
	        "res4"     =>$this->hex2num(substr($data, 1510,2))
	    );
	    for($i=0;$i<64;$i++){
	        $item=substr($data, 440+(16*$i),4);
	       if($item=="0000"){continue;}
	       $box[$i]=array(
	           "item"=>$this->hex2num($item),
	           "att1"=>$this->hex2num(substr($data, 444+(16*$i),2)),
	           "val1"=>$this->hex2num(substr($data, 446+(16*$i),2)),
	           "att2"=>$this->hex2num(substr($data, 448+(16*$i),2)),
	           "val2"=>$this->hex2num(substr($data, 450+(16*$i),2)),
	           "att3"=>$this->hex2num(substr($data, 452+(16*$i),2)),
	           "val3"=>$this->hex2num(substr($data, 454+(16*$i),2)),
	       );
	    }

	    return $char_ready=array("attr"=>$attr,'box'=>$box);
	}

	//Save account content
	abstract function save(){
	    if($this->consistence()){
	        //save
	        $this->close();
	        return true;
	    }
	    else{
	        return false;
	    }
	}

	//Verify account badsize
	protected function consistence(){
	        if(strlen($this->data)==4292){
	            return true;
	        }
	        else{
	            return false;
	        }
	}

	//Clean and flush memory
	public function close(){
	    unset($this);
	}

	public function invhex($data){
	    $t=strlen($data);
	    if($t%2){
	        $data="0".$data;
	    }
	    $d="";
	    for($i=0;$i<=$t;$i+=2){
	        $d.=substr($data,($t-$i),2);
	    }
	    return $d;
	}

	public function hex2num($data){
	    return hexdec($this->invhex($data));
	}

	public function num2hex($data){
	    return $this->invhex(dechex($data));
	}
}
?>
