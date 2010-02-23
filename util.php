<?php
define("FLATTENING_FACTOR",3.35281066474748E-3);
define("EARTH_RADIUS_KM",6.378137E3);
define("PI_OVER_TWO",(_pi/2.0));
define("TWO_PI",(_pi*2.0));

function calculateLatLonAlt($time,$pos,&$satPos) 
{
	
	$r = 0.0;
	$e2 = 0.0;
	$phi = 0.0;
	$c = 0.0;
	
	//Theta = atan2($pos.getY(), $pos.getX());
	$satPos->theta = (atan2($pos->v[1], $pos->v[0]));
	$satPos->lon = (mod2PI($satPos->theta - thetaGJD($time)));
	$r = sqrt(sqr($pos->v[0]) + sqr($pos->v[1]));
	$e2 = FLATTENING_FACTOR * (2 - FLATTENING_FACTOR);
	$satPos->lat = (atan2($pos->v[2], $r));
	
	do 
	{
		$phi = $satPos->lat;
		$c = 1.0 / sqrt(1 - $e2 * sqr(sin($phi)));
		$satPos->lat = (atan2($pos->v[2] + EARTH_RADIUS_KM * $c * $e2 * sin($phi), $r));
	}
	while (abs($satPos->lat - $phi) >= 1E-10);
	
	$satPos->alt = ($r / cos($satPos->lat) - EARTH_RADIUS_KM * $c);
	
	$temp = $satPos->lat;
	
	if ($temp > PI_OVER_TWO) 
	{
		$temp -= TWO_PI;
		$satPos->lat($temp);
	}
}

function mod2PI($testValue) 
{
	/* Returns mod 2PI of argument */
	
	$i = 0;
	$retVal = 0.0;
	
	$retVal = $testValue;
	$i = (int) ($retVal / TWO_PI);
	$retVal -= $i * TWO_PI;
	
	if ($retVal < 0.0) 
	{
		$retVal += TWO_PI;
	}
	
	return $retVal;
}


function frac($arg) 
{
	/* Returns fractional part of double argument */
	return ($arg - floor($arg));
}


define("SECS_PER_DAY",8.6400E4);
define("EARTH_ROTATIONS_PER_SIDERIAL_DAY",1.00273790934);

function thetaGJD($theJD) 
{
	/* Reference: The 1992 Astronomical Almanac, page B6. */
	
	$ut = 0.0;
	$tu = 0.0;
	$gmst = 0.0;
	
	$ut = frac($theJD + 0.5);
	$aJD = $theJD - $ut;
	$tu = ($aJD - 2451545.0) / 36525.0;
	$gmst = 24110.54841 + $tu
			* (8640184.812866 + $tu * (0.093104 - $tu * 6.2E-6));
	$gmst = modulus($gmst + SECS_PER_DAY * EARTH_ROTATIONS_PER_SIDERIAL_DAY * $ut, SECS_PER_DAY);
	
	return TWO_PI * $gmst / SECS_PER_DAY;
}


class SatPos
{

var $azimuth = 0.0;
var $elevation = 0.0;

var $lat = 0.0;
var $lon = 0.0;
var $alt = 0.0;

var $theta = 0.0;

var $time = 0.0;
var $range = 0.0;
var $rangeRate = 0.0;
var $phase = 0.0;
}


?>