<?php

/* ------------------------------------------------------------------- *
 * ---------------------------- double_value ------------------------- *
 * ------------------------------------------------------------------- */

function double_value(&$c1, $pos, $len)
{
	$d = 0.0;
	//register int i;
	$i = 0;
	$j=0;
	for ($i=0;($i<$len);$i++)
	{
		switch ($c1[$i+$pos]) {
		case ' ' :
			break;
		case '0' :
			$d *= 10;
			break;
		case '1' :
			$d *= 10;
			$d++;
			break;
		case '2' :
			$d *= 10;
			$d += 2;
			break;
		case '3' :
			$d *= 10;
			$d += 3;
			break;
		case '4' :
			$d *= 10;
			$d += 4;
			break;
		case '5' :
			$d *= 10;
			$d += 5;
			break;
		case '6' :
			$d *= 10;
			$d += 6;
			break;
		case '7' :
			$d *= 10;
			$d += 7;
			break;
		case '8' : 
			$d *= 10;
			$d += 8;
			break;
		case '9' :
			$d *= 10;
			$d += 9;
			break;
		case '.' :
			$j = $len-$i-1;
			break;
		default : 
			break;
		}
	}
	$d/=pow (10.0, $j);
	return $d;
}

/* ------------------------------------------------------------------- *
 * --------------------------- integer_value ------------------------- *
 * ------------------------------------------------------------------- */

function integer_value(&$c1, $pos, $len)
{
	$d = 0;
	$i;
	for ($i=0;($i<$len);$i++)
	{
		switch ($c1[$i+$pos]) {
		case ' ' :
			break;
		case '0' :
			$d *= 10;
			break;
		case '1' :
			$d *= 10;
			$d++;
			break;
		case '2' :
			$d *= 10;
			$d += 2;
			break;
		case '3' :
			$d *= 10;
			$d += 3;
			break;
		case '4' :
			$d *= 10;
			$d += 4;
			break;
		case '5' :
			$d *= 10;
			$d += 5;
			break;
		case '6' :
			$d *= 10;
			$d += 6;
			break;
		case '7' :
			$d *= 10;
			$d += 7;
			break;
		case '8' : 
			$d *= 10;
			$d += 8;
			break;
		case '9' :
			$d *= 10;
			$d += 9;
			break;
		default : 
			break;
		}
	}
	return $d;
}

/* ------------------------------------------------------------------- *
 * ----------------------- Convert_Satellite_Data -------------------- *
 * ------------------------------------------------------------------- */

function Convert_Satellite_Data ($tle,&$data)
{
	$iexp = 0;$ibexp = 0;
	
	$a1 = 0.0;
	$ao = 0.0;
	$del1 = 0.0;
	$delo = 0.0;
	$xnodp = 0.0;
	$temp = 0.0;
	$xke = 0.0;
	
	// first line 
	$data->epoch = double_value($tle->l[1], 18, 14);
	$data->julian_epoch = Julian_Date_of_Epoch($data->epoch);
	$data->xndt2o = double_value($tle->l[1], 33, 10);
	$data->xndd6o = double_value($tle->l[1], 44, 6) * 1.0E-5;
	$iexp = integer_value($tle->l[1], 50, 2);
	$data->bstar = double_value($tle->l[1], 53, 6) * 1.0E-5;
	$ibexp = integer_value($tle->l[1], 59, 2);

	// second line 
	$data->xincl = double_value($tle->l[2], 8, 8);
	$data->xnodeo = double_value($tle->l[2], 17, 8);
	$data->eo = double_value($tle->l[2], 26, 7) * 1E-7;
	$data->omegao = double_value($tle->l[2], 34, 8);
	$data->xmo = double_value($tle->l[2], 43, 8);
	$data->xno = double_value($tle->l[2], 52, 11);
	
	// Convert to proper units 
	$data->xndd6o = ($data->xndd6o) * pow (10.0, -$iexp);
	$data->bstar = ($data->bstar) * pow (10.0, -$ibexp) / _ae;
	$data->xnodeo = radians($data->xnodeo);
	$data->omegao = radians($data->omegao);
	$data->xmo = radians($data->xmo);
	$data->xincl = radians($data->xincl);
	$data->xno = ($data->xno) * 2.0 * _pi / _xmnpda;
	$data->xndt2o = ($data->xndt2o) * 2.0 * _pi / sqr (_xmnpda);
	$data->xndd6o = ($data->xndd6o) * 2.0 * _pi / cube (_xmnpda);

	// Determine whether Deep-Space Model is needed 
	$xke = sqrt((3600.0 * ge) / cube(xkmper));
	$a1 = pow (($xke/($data->xno)),(2.0/3.0));
	$temp = 1.5 * CK2 * ( 3 * sqr ( cos ($data->xincl)) - 1.0 ) / pow ( ( 1.0 - sqr ($data->eo) ), 1.5);
	$del1 = $temp / (sqr ($a1));
	$ao = $a1 * ( 1 - $del1 * (0.5 * (2.0/3.0) + $del1 * (1.0 + (134.0/81.0)* $del1 )));
	$delo = $temp / (sqr ($ao));
	$xnodp = ($data->xno) / (1 + $delo);
	if (((2 * _pi) / $xnodp) >= 225) 
		$data->ideep = 1;
	else
		$data->ideep = 0;
}


/* ------------------------------------------------------------------- *
 * ------------------------- Convert_Sat_State ----------------------- *
 * ------------------------------------------------------------------- */

function Convert_Sat_State (&$p,&$v)
{
	$i = 0;
	for ($i=0;($i<3);$i++)
	{
		$p->v[$i] = $p->v[$i] * xkmper;
		$v->v[$i] = $v->v[$i] * xkmper / 60;
	}

	Magnitude ($p);
	Magnitude ($v);
}


/* ------------------------------------------------------------------- *
 * --------------------------------- sgp ----------------------------- *
 * ------------------------------------------------------------------- */

function sgp ($mode, $time, $tle, &$pos, &$vel)
{
	$satdata = new sgp_data();
	Convert_Satellite_Data ($tle, $satdata);
	switch ($mode)
	{
		case _SGP0 :
			sgp0call($time, $pos, $vel, $satdata);
		break;
		case _SGP4 :
		case _SDP4 :
			sgp4call($time, $pos, $vel, $satdata);
		break;
		case _SGP8 :
		case _SDP8 :
			sgp8call($time, $pos, $vel, $satdata);
		break;
		default :
		return -1;
	}
	Convert_Sat_State ($pos, $vel);
	return 0;
}
?>