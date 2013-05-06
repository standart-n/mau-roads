<?php class work {

function checkBase(&$q) { $s=""; $i=0; $q->more=false; $q->script="";
	if ($q->url->category=="balloon") {
		$s.=$this->balloon($q);
	}
	if (($q->url->category=="map") || ($q->url->category=="list")) { 
		$sql=$q->sql->table($q);
		$query=ibase_query($q->fdb_it,$sql);
		while ($r=ibase_fetch_object($query)) {
			$q->validate->row($r);
			$q->validate->setDate($r->DOCDATE);
			$q->validate->setDate($r->DATE_OFF);
			$q->validate->setDate($r->DATE_ON_PLAN);
			if ($q->url->category=="map") {
				$q->script.=$q->tpl_maps->scriptContent($q,$r,$i+$q->url->last);
			}
			if ($q->url->category=="list") {
				$s.=$q->tpl_main->line($q,$r,$i+$q->url->last);
				if ($i>20) break;
			}
			$i++;
		}
	}
	$q->count=$i;
	if ($i>20) { $q->more=true; }
	return $s;
}

function balloon(&$q) { $s="";
	$sql=$q->sql->balloon($q);
	$query=ibase_query($q->fdb_it,$sql);
	$r=ibase_fetch_object($query);
	$q->validate->row($r);
	$q->validate->setDate($r->DOCDATE);
	$q->validate->setDate($r->DATE_OFF);
	$q->validate->setDate($r->DATE_ON_PLAN);
	$s.=$q->tpl_main->lineInfo($q,$r,time(),false);
	//$s.=$r->SISPOLNITEL;
	return $s;	
}

function checkTotal(&$q) { $s="";
	$sql=$q->sql->getTotal($q);
	$query=ibase_query($q->fdb_it,$sql);
	while ($r=ibase_fetch_object($query)) {
		$q->validate->total($r);
		$s.=$q->tpl_main->total($q,$r);
	}
	return $s;
}

function getList(&$q,$key) { $s=""; $ms=array();
	$sql=$q->sql->getList($q,$key);
	$query=ibase_query($q->fdb_it,$sql);
	while ($r=ibase_fetch_object($query)) {
		$ms[]=$q->validate->strForList($r->$key);
	}
	$q->$key=$ms;	
}

function checkDIRECTION(&$q) { $s="";
	$this->getList($q,"DIRECTION");
	$s=$q->tpl_main->select("УК","direction",$q->DIRECTION);
	return $s;
}

function checkCTP(&$q) { $s="";
	$this->getList($q,"CTP");
	$s=$q->tpl_main->select("ЦТП","ctp",$q->CTP);
	return $s;
}

function checkSSERVICE(&$q) { $s="";
	$this->getList($q,"SSERVICE");
	$s=$q->tpl_main->select("Услуга","service",$q->SSERVICE);
	return $s;
}

function checkSREGION(&$q) { $s="";
	$this->getList($q,"SREGION");
	$s=$q->tpl_main->select("Район","sector",$q->SREGION);
	return $s;
}

function checkSTREET(&$q) { $s="";
	$this->getList($q,"STREET");
	$s=$q->tpl_main->select("Улица","street",$q->STREET);
	return $s;
}

function checkNOMER(&$q) { $s="";
	$this->getList($q,"NOMER");
	$s=$q->tpl_main->select("Дом","home",$q->NOMER);
	return $s;
}

function checkScript(&$q) { $scH=""; $scF=""; $sc="";
	if ($q->url->category=="map") {
		$scH=$q->tpl_maps->scriptHeader();
		$scF=$q->tpl_maps->scriptFooter();
		$sc=$scH.$q->script.$scF;
	}
	return $sc;
}

function checkTR(&$q) { $s="";
	$s=$q->tpl_main->tr();
	return $s;
}


} ?>
