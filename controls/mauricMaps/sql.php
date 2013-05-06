<?php class sql {

function getTotal($q) { $s=""; $k="";
	$s.="SELECT ";
	$s.="sum(coalesce(SALL,0)) as SUM_SALL, ";
	$s.="sum(coalesce(RESIDENT,0)) as SUM_RESIDENT, ";
	$s.="sum(coalesce(COUNTAPARTMENT,0)) as SUM_COUNTAPARTMENT,  ";
	$s.="count(UUID) as COUNT_BUILDINGS ";
	$s.="FROM VW_BUILDINGS_WEB WHERE (1=1) ";
	if ($q->validate->direction($q)) { 
		$s.="AND (DIRECTION='".$q->validate->toWin($q->url->f_direction)."') ";
	}
	if ($q->validate->ctp($q)) { 
		$s.="AND (CTP='".$q->validate->toWin($q->url->f_ctp)."') ";
	}
	if ($q->validate->sector($q)) { 
		$s.="AND (SREGION='".$q->validate->toWin($q->url->f_sector)."') ";
	}
	if ($q->validate->street($q)) { 
		$s.="AND (STREET='".$q->validate->toWin($q->url->f_street)."') ";
	}
	if ($q->validate->home($q)) { 
		$s.="AND (NOMER='".$q->validate->toWin($q->url->f_home)."') ";
	}
	return $s;
}

function balloon(&$q) { $s="";
	$s.="SELECT * FROM VW_BUILDINGS_WEB WHERE (UUID='".$q->url->uuid."') ";
	//$q->alert=$k;
	return $s;
}

function table(&$q) { $s=""; $i=0; $k="";
	$q->validate->skipForSql($q->url->last);
	$s.="SELECT FIRST 10 SKIP ".$q->url->last." * FROM VW_BUILDINGS_WEB WHERE (1=1) ";
	if ($q->validate->direction($q)) { 
		$s.="AND 	(DIRECTION='".$q->validate->toWin($q->url->f_direction)."') ";
	}
	if ($q->validate->ctp($q)) { 
		$s.="AND (CTP='".$q->validate->toWin($q->url->f_ctp)."') ";
	}
	if ($q->validate->sector($q)) { 
		$s.="AND (SREGION='".$q->validate->toWin($q->url->f_sector)."') ";
	}
	if ($q->validate->street($q)) { 
		$s.="AND (STREET='".$q->validate->toWin($q->url->f_street)."') ";
	}
	if ($q->validate->home($q)) { 
		$s.="AND (NOMER='".$q->validate->toWin($q->url->f_home)."') ";
	}
	$s.="AND (STREET<>'') ";
	$s.="AND (STREET<>'-') ";
	$s.="AND (SREGION<>'') ";
	$s.="ORDER by STREET, SORTEDCAPTION ASC ";


	$k.="SELECT SKIP ".$q->url->last." * FROM VW_BUILDINGS_WEB WHERE (1=1) ";
	if ($q->validate->direction($q)) { 
		$k.="AND (DIRECTION='".($q->url->f_direction)."') ";
	}
	if ($q->validate->ctp($q)) { 
		$k.="AND (CTP='".($q->url->f_ctp)."') ";
	}
	if ($q->validate->service($q)) { 
		$k.="AND (SSERVICE='".($q->url->f_service)."') ";
	}
	if ($q->validate->sector($q)) { 
		$k.="AND (SREGION='".($q->url->f_sector)."') ";
	}
	if ($q->validate->street($q)) { 
		$k.="AND (STREET='".($q->url->f_street)."') ";
	}
	if ($q->validate->home($q)) { 
		$k.="AND (NOMER='".($q->url->f_home)."') ";
	}
	$k.="AND (STREET<>'') ";
	$k.="AND (STREET<>'-') ";
	$k.="AND (SREGION<>'') ";
	$k.="ORDER by STREET, SORTEDCAPTION ASC ";

	//$q->alert=$k;
	return $s;
}

function getList($q,$key) { $s=""; $k="";
	$s.="SELECT ".$key." FROM VW_BUILDINGS_WEB WHERE (1=1) ";
	if ($q->validate->direction($q)) { 
		$s.="AND (DIRECTION='".$q->validate->toWin($q->url->f_direction)."') ";
	}
	if ($q->validate->ctp($q)) { 
		$s.="AND (CTP='".$q->validate->toWin($q->url->f_ctp)."') ";
	}
	if ($q->validate->sector($q)) { 
		$s.="AND (SREGION='".$q->validate->toWin($q->url->f_sector)."') ";
	}
	if ($q->validate->street($q)) { 
		$s.="AND (STREET='".$q->validate->toWin($q->url->f_street)."') ";
	}
	if ($q->validate->home($q)) { 
		$s.="AND (NOMER='".$q->validate->toWin($q->url->f_home)."') ";
	}
	$s.="AND (STREET<>'') ";
	$s.="AND (STREET<>'-') ";
	$s.="AND (SREGION<>'') ";
	$s.="GROUP by ".$key." ";
	$s.="ORDER by ".$key." ASC ";
	
	return $s;
}

} ?>
