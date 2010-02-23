<?php

function Calculate_LatLonAlt($tsince,&$pos,&$geodetic)
{


    Public Const _pi As Double = 3.1415926535897931
    Public Const _pio2 As Double = _pi / 2
    Public Const _2pi As Double = 2 * _pi
    
    Public Const F As Double = 1.0 / 298.25999999999999
    
    
	/* Procedure Calculate_LatLonAlt will calculate the geodetic  */
	/* position of an object given its ECI position pos and time. */
	/* It is intended to be used to determine the ground track of */
	/* a satellite.  The calculations  assume the earth to be an  */
	/* oblate spheroid as defined in WGS '72.                     */
	
	/* Reference:  The 1992 Astronomical Almanac, page K12. */
	
	$r = 0.0; $e2 = 0.0; $phi = 0.0; $c = 0.0;
	
	$geodetic->theta = actan($pos->v[1], $pos->v[0]);  /* radians */
	$geodetic->lon = fmod2p($geodetic->theta - ThetaG_JD($tsince));  /* radians */
	
	
	$r = Sqrt(sqr($pos->v[0]) + sqr($pos->v[1]));
	$e2 = F * (2 - F);
	$geodetic->lat = actan($pos->v[2], $r); /* radians */
	
	do
	{
		$phi = $geodetic->lat;
		$c = 1 / Sqrt(1 - $e2 * sqr(Sin($phi)));
		$geodetic->lat = actan($pos->v[2] + xkmper * $c * $e2 * Sin($phi), $r);
	}
	while(Abs($geodetic->lat - $phi) >= 0.0000000001);
	
	$geodetic->alt = $r / Cos($geodetic->lat) - xkmper * $c  /* kilometers */
	
	If($geodetic->lat > _pio2){$geodetic->lat -= _2pi};
}
?>