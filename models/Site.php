<?php

namespace app\models;

use Yii;
class Site extends \yii\db\ActiveRecord
{
//----------------------------------------------------------
	public static function rusdat($dat,$withtime=0) { 
	$time='';
		if ($withtime>0) {
			$time=substr($dat,11,8);
			if ($time) $time=' ('.$time.')';
			else $time='';
		}
		
          return ($dat>0)?(substr($dat,8,2).".".substr($dat,5,2).".".substr($dat,0,4).$time):"";

        }
//-----------------------------------------------------
	public static function ntocmonth($m) { 

		switch($m) {
		    case  "1" : $ret="Январь";break;
		    case  "2" : $ret="Февраль";break;
		    case  "3" : $ret="Март";break;
		    case  "4" : $ret="Апрель";break;
		    case  "5" : $ret="Май";break;
		    case  "6" : $ret="Июнь";break;
		    case  "7" : $ret="Июль";break;
		    case  "8" : $ret="Август";break;
		    case  "9" : $ret="Сентябрь";    break;
		    case  "10" : $ret="Октябрь";break;
		    case  "11" : $ret="Ноябрь";break;
		    case  "12" : $ret="Декабрь";break;
		    default:$ret='';
		}
		return $ret;
	}
	public function ntocmonthrod($m) { 

		switch($m) {
		    case  "1" : $ret="января";break;
		    case  "2" : $ret="февраля";break;
		    case  "3" : $ret="марта";break;
		    case  "4" : $ret="апреля";break;
		    case  "5" : $ret="мая";break;
		    case  "6" : $ret="июня";break;
		    case  "7" : $ret="июля";break;
		    case  "8" : $ret="августа";break;
		    case  "9" : $ret="сентября";    break;
		    case  "10" : $ret="октября";break;
		    case  "11" : $ret="ноября";break;
		    case  "12" : $ret="декабря";break;
		    default:$ret='';
		}
		return $ret;
	}
//------------------------------------------
	public static  function rusdnned($m) { 

		switch($m) {
		    case  "1" : $ret="Пн";break;
		    case  "2" : $ret="Вт";break;
		    case  "3" : $ret="Ср";break;
		    case  "4" : $ret="Чт";break;
		    case  "5" : $ret="Пт";break;
		    case  "6" : $ret="Сб";break;
		    case  "7" : $ret="Вс";break;
		    default:$ret='';
		}
		return $ret;
	}
//***************************************
//***************************************
function summa_pro($num) {

	$snum='|'.sprintf('% 15.2f',$num);
	$pro=' ';
	$s=' ';
	$j=4;

	if ($num==0) { $ret=' Ноль pублей ноль копеек'; }
	else {
		$pos= strpos($snum,'.');
		$cel= '  '+($pos==0)?$snum:substr($snum,0,$pos);
		while ((substr($snum,1,3))==='   ') {
			$j--;
			$snum='|'.substr($snum,4);
		}

		for ($i=3*$j; $i>=3;  $i=$i-3) {
			$pro='|'.substr($cel,-$i,3);
			if (substr($pro,1,3)!=0) {
//				$s.=($pro.'+'.$i.'++');
            			$s.=(Site::str3($pro,($i==6)?0:1));
            			switch ($i) {
               				case 12:  $s.=(' '.Site::sklon('миллиаpд',1,$pro)); break;
					case 9:   $s.=(' '.Site::sklon('миллион',1,$pro)); break;
					case 6:   $s.=(' '.Site::sklon('тысяч',0,$pro));
            			} 
         		}
		}
      		$tt= substr($pro,1);
		$i= (int) ($tt%10);

//print '6==='.$tt.'=='.$i.'='.($tt%100).'='.$s.'<br>';
		if     (($j==0) && ($i==0)) { $s.=' ноль pублей'; }
		elseif ($i==0) { $s.=' pублей'; }
      		elseif ($i==1) { $s.=((($tt%100)>10)&&(($tt%100)<20))?' pублей':' pубль';}
      		elseif ($i<5) { $s.=(((($tt%100)>10)&&(($tt%100)<20))?' pублей':' pубля'); }
      		else { $s.=' pублей' ;}
//$ret=('7====='.$s.'<br>');
		$pro=substr($snum,-2,2);

      		if ($pro=='00') {$s=$s.' ноль'; }
      		else { $s.=(' '.$pro); }

      		$i= (int) ($pro%10);
      		if     ($i==0) { 
			$s.=' копеек'; 
//		} elseif ($i==2) { 
//			$s.=' копейки'; 
		} elseif ($i==1) { 
			$s.=(((($pro%100)>10)&&(($pro%100)<20))?' копеек':' копейкa'); 
		} elseif ($i<5)  { 
			$s.=(((($pro%100)>10)&&(($pro%100)<20))?' копеек':' копейки'); 
		} else { 
			$s.=' копеек' ;
		}
	}
	$ret=trim($s);

 	return($ret);
// 	return(upper(left($s,1))+substr($s,2));
//  	return ucfirst($ret);
}

//***************************************
function str3($str,$rod) {
     $ot=''; $prom=''; $sot='';

  //--------обработка сотен-----------------
  if (strlen(''.$str)>3) {
     $prom= '|'.substr($str,1,1);
     switch ($prom) {
        case '|0': break;
        case '| ': break;
        case '|1': $ot=$ot.' сто'; break;
        case '|2': $ot=$ot.' двести'; break;
        default :  $sot=((0+substr($prom,1,1)) < 5)?'ста':'cот'; 
                  $ot.=Site::name_number($prom,$rod).$sot;
     }
     $str= '|'.substr($str,2);
  }

  	$prom= '|'.substr($str,1,1);
	$str = '|'.substr($str,2,1);
	if (($prom=='|0')|| ($prom=='| ')) { 
		$ot.=Site::name_number($str,$rod); // только единицы
	}  elseif ($prom=='|1') {
	        switch ($str) {
			case '|0': $ot.=' десять'; break;
			case '|2': $ot.=(Site::name_number($str,0).'надцать'); break;
			case '|3': $ot.=(Site::name_number($str,0).'надцать'); break;
//			default  : $ot.=(substr(Site::name_number($str,1),0,strlen(Site::name_number($str,1))-1).'надцать');
			default  : $ot.=(substr(Site::name_number($str,1),0,strlen(Site::name_number($str,1))).'надцать');
		}
	} else { 
		$tt=substr($prom,1);
		$ot=$ot.(($tt==4)?' соpок': 
                        (($tt==9)?' девяносто':
                        (($tt<4) ? Site::name_number($prom,1).'дцать':
                        (($tt<9) ? Site::name_number($prom,0).'десят':''))));
                        $ot.=Site::name_number($str,$rod);
  	}
return $ot;
}
//*****************************************
function name_number($number,$rod) {

/* возвpащает словом название цифpы number
 * в женском pоде, если rod=0
 * в мужском pоде в пpотивном случае
 */
 switch ($number) { 
   case '|0': $ret=''; break;
   case '|1': $ret=($rod==0)?' одна':' один';break;
   case '|2': $ret=($rod==0)?' две':' два';break;
   case '|3': $ret=' тpи'; break;
   case '|4': $ret=' четыpе'; break;
   case '|5': $ret=' пять'; break;
   case '|6': $ret=' шесть'; break;
   case '|7': $ret=' семь'; break;
   case '|8': $ret=' восемь'; break;
   case '|9': $ret=' девять'; break;
   default: $ret=''; break;
  }
return $ret;
}
//********************************************
function sklon($s,$rod,$num) {
	$ret='';
	$tt=substr($num,1);
	$n = (int) $tt%10;
	if ((($tt%100)>9)&&(($tt%100)<=20)) { 
		$ret.=($s.(($rod==1)?'ов':'')); 
	} elseif ($n==1) { 
		$ret.=($s.(($rod==1)?'':'а')); 
	} elseif ((($n<5)&&($n>0))) {
		$ret.=($s.(($rod==1)?'а':'и'));
	} else { 
		$ret.=($s.(($rod==1)?'ов':'')); 
	}

  return $ret;
}
//----------------------------------------------------------
        public function listotdel() {   

		$command=Yii::app()->db->createCommand();
		$command->select('kod,fullname');
		$command->from('otdels');
//		$command->where(array('and','tab=:tab','type_e=:ot' ), array(':tab'=>$_tab,':ot'=>"ОТ")); 
		$command->order('pp,fullname');

	$rows = $command->queryAll();
	$listotdel=array(); 
	foreach($rows as $row) {
		$listotdel[$row['kod']]=$row['fullname'];
	}
	$listotdel[999]='--Все отделы--';
	return ($listotdel);
}

//--------------------------------------------------------------
        public function listmesaz() {   

	for ($i=0,$listmesaz=array();$i++,$listmesaz[$i]=Site::ntocmonth($i); $i<13);
	$listmesaz[0]='--Не выбран';
	$listmesaz[999]='--Все месяцы--';
	return ($listmesaz);
}
//-----------------------------------------------------------
	public function protokol($obj,$key_id,$newvalue,$bef=array()) {
		foreach($newvalue as $key=>$value) {
			$oldvalue=(!isset($bef[$key]))?'':$bef[$key];
			if (($key!='lastedit') and ($oldvalue!=$value)) {
				$log=new Log_edit;
//print $obj.'  = = > '.$key.'  = = > '.$oldvalue.'  = = > '.$value.'<br/>';
//				$this->create_time=$this->update_time=time();

				$log->obj=$obj;
				$log->field=$key;
				$log->key_id=$key_id;
				$log->oldvalue=$oldvalue;
				$log->newvalue=$value;
				$log->coper=Yii::app()->user->id;
				if(!$log->save()) ;
			} 
		}
	
	}

//-----------------------------------------------------
	public function rusvrem($dat,$withtime=0) { 
	$time='';
		if ($withtime>0) {
			$time=substr($dat,11,8);
			if ($time) $time=' ('.$time.')';
			else $time='';
		}
		
          return ($dat>0)?(substr($dat,11,8)):"";

        }
//-------------------------------------------------------
public static function russnils($dat) {
	 
	$sim=array ("-"," ");
	$dates=str_replace($sim, "", $dat);
          return ($dates)?(substr($dates,0,3)."-".substr($dates,3,3)."-".substr($dates,6,3)." ".substr($dates,9,2)):"";
        }

//-------------------------------------------------------
//-------------------------------------------------
        public function rustel($tel='') {   

		$ret='';
	$atel=preg_split("/[\s,]+/", trim($tel)); //explode($tel);
//print strlen($atel[0]);
	if ((count($atel)<1) or strlen($atel[0])<5) $ret=trim($tel);
	else {
		foreach($atel as $ct) {
			if(strlen($ret)!=0) $ret.=', ';

			if(strlen($ct)<6) $ret.=substr($ct,0,1).'-'.substr($ct,1,2).'-'.substr($ct,3);
			elseif(strlen($ct)<11) $ret.=substr($ct,0,3).'-'.substr($ct,3,3).'-'.substr($ct,6);
			else $ret.=substr($ct,0,1).'-'.substr($ct,1,3).'-'.substr($ct,4,3).'-'.substr($ct,7);
		}
	}
	return ($ret);
}
//----------------------------------------------------------
	public function rusdatvrem($dat) { 
		$ret=($dat>0)?('<b>'.substr($dat,8,2).".".substr($dat,5,2).".".substr($dat,0,4).'</b>'):"";
		if (strlen($dat)>10) 
	          	$ret.=(' <small>'.substr($dat,11).'</small>');
		
		return ($ret);

        }
//----------------------------------------------------------
	public static function torusdat($dat) { 

//          return ($dat>0)?(substr($dat,8,2).".".substr($dat,5,2).".".substr($dat,0,4)):"";
          return ($dat>0)?(substr($dat,8,2)."".substr($dat,5,2)."".substr($dat,0,4)):"";

        }
//----------------------------------------------------------
	public static function fromrusdat($dat) { 

//          return ($dat>0)?(substr($dat,6,4)."-".substr($dat,3,2)."-".substr($dat,0,2)):"";
          return ($dat>0)?(substr($dat,4,4)."-".substr($dat,2,2)."-".substr($dat,0,2)):"";

        }
//----------------------------------------------------------
//-------------------------------------------------------

}