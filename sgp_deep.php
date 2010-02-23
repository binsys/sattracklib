<?php

/* ------------------------------------------------------------------- *
 * -------------------- static shared variables ---------------------- *
 * ------------------------------------------------------------------- */
/* dpinit */
static $eqsq; static $siniq; static $cosiq; static $rteqsq; static $ao; static $cosq2; static $sinomo; static $cosomo;
static $bsq; static $xlldot; static $omgdt; static $xnodot; static $xnodp;
/*dpsec/dpper */
static $xll; static $omgasm; static $xnodes; static $em_d; static $xinc; static $xn; static $t;

/* ------------------------------------------------------------------- *
 * --------------------------- call_dpinit --------------------------- *
 * ------------------------------------------------------------------- */

function call_dpinit(&$values, &$satdata)
{
	/* dpinit */
	global $eqsq,$siniq,$cosiq,$rteqsq,$ao,$cosq2,$sinomo,$cosomo;
	global $bsq,$xlldot,$omgdt,$xnodot,$xnodp;
	/*dpsec/dpper */
	global $xll,$omgasm,$xnodes,$em_d,$xinc,$xn,$t;

	$eqsq   = $values->eosq;
	$siniq  = $values->sinio;
	$cosiq  = $values->cosio;
	$rteqsq = $values->betao;
	$ao	 = $values->aodp;
	$cosq2  = $values->theta2;
	$sinomo = $values->sing;	
	$cosomo = $values->cosg;
	$bsq	= $values->betao2;  
	$xlldot = $values->xmdot;   
	$omgdt  = $values->omgdot;  
	$xnodot = $values->xnodott;
	$xnodp  = $values->xnodpp;
	deep(1, $satdata);
	$values->eosq   = $eqsq;	
	$values->sinio  = $siniq;   
	$values->cosio  = $cosiq;   
	$values->betao  = $rteqsq;
	$values->aodp   = $ao;	  
	$values->theta2 = $cosq2;   
	$values->sing   = $sinomo;  
	$values->cosg   = $cosomo;
	$values->betao2 = $bsq;
	$values->xmdot  = $xlldot;  
	$values->omgdot = $omgdt;   
	$values->xnodott = $xnodot;
	$values->xnodpp  = $xnodp;
}



/* ------------------------------------------------------------------- *
 * ----------------------------- call_dpsec -------------------------- *
 * ------------------------------------------------------------------- */

function call_dpsec(&$values, &$satdata)
{
	/* dpinit */
	global $eqsq,$siniq,$cosiq,$rteqsq,$ao,$cosq2,$sinomo,$cosomo;
	global $bsq,$xlldot,$omgdt,$xnodot,$xnodp;
	/*dpsec/dpper */
	global $xll,$omgasm,$xnodes,$em_d,$xinc,$xn,$t;
	
	$xll	= $values->xmdf;	
	$omgasm = $values->omgadf;  
	$xnodes = $values->xnode;   
/*	$em_d   = $values->emm;
	$xinc   = $values->xincc; */
	$xn	 = $values->xnn;	 
	$t	  = $values->tsince;
	deep(2, $satdata);
	$values->xmdf   = $xll;	 
	$values->omgadf = $omgasm;  
	$values->xnode  = $xnodes;  
	$values->emm	= $em_d;
	$values->xincc  = $xinc;	
	$values->xnn	= $xn;	  
	$values->tsince = $t;
}



/* ------------------------------------------------------------------- *
 * ----------------------------- call_dpper -------------------------- *
 * ------------------------------------------------------------------- */

function call_dpper(&$values, &$satdata)
{
	/* dpinit */
	global $eqsq,$siniq,$cosiq,$rteqsq,$ao,$cosq2,$sinomo,$cosomo;
	global $bsq,$xlldot,$omgdt,$xnodot,$xnodp;
	/*dpsec/dpper */
	global $xll,$omgasm,$xnodes,$em_d,$xinc,$xn,$t;
	
	$em_d   = $values->e;	   
	$xinc   = $values->xincc;   
	$omgasm = $values->omgadf;  
	$xnodes = $values->xnode;
	$xll	= $values->xmam;
	deep(3, $satdata);
	$values->e	  = $em_d;	  
	$values->xincc  = $xinc;	
	$values->omgadf = $omgasm;  
	$values->xnode  = $xnodes;
	$values->xmam   = $xll;
}



/* ------------------------------------------------------------------- *
 * --------------------------------- deep ---------------------------- *
 * ------------------------------------------------------------------- */

function deep($ideep, &$satdata)
{

	/* dpinit */
	global $eqsq,$siniq,$cosiq,$rteqsq,$ao,$cosq2,$sinomo,$cosomo;
	global $bsq,$xlldot,$omgdt,$xnodot,$xnodp;
	/*dpsec/dpper */
	global $xll,$omgasm,$xnodes,$em_d,$xinc,$xn,$t;


	/* define all the constants */
	static $zns =  1.19459E-5;	 
	static $c1ss   =  2.9864797E-6;   
	static $zes	=  0.01675;
	static $znl	=  1.5835218E-4;   
	static $c1l	=  4.7968065E-7;   
	static $zel	=  0.05490;
	static $zcosis =  0.91744867;	 
	static $zsinis =  0.39785416;	 
	static $zsings = -0.98088458;
	static $zcosgs =  0.1945905;	  
	static $q22	=  1.7891679E-6;   
	static $q31	=  2.1460748E-6;   
	static $q33	=  2.2123015E-7;
	static $g22	=  5.7686396;	  
	static $g32	=  0.95240898;	 
	static $g44	=  1.8014998;
	static $g52	=  1.0508330;	  
	static $g54	=  4.4108898;	  
	static $root22 =  1.7891679E-6;
	static $root32 =  3.7393792E-7;   
	static $root44 =  7.3636953E-9;   
	static $root52 =  1.1428639E-7;
	static $root54 =  2.1765803E-9;   
	static $thdt   =  4.3752691E-3;
	static $iresfl	 = 0;  
	static $i2		 = 0;
	static $isynfl	 = 0;
	static $iret	   = 0;  
	static $iretn	  = 0;
	static $ls		 = 0;
	static $i		  = 0;
	static $a1	  = 0.0;	
	static $a2	  = 0.0;	
	static $a3	  = 0.0;
	static $a4	  = 0.0;   
	static $a5	  = 0.0;	
	static $a6	  = 0.0;
	static $a7	  = 0.0;	
	static $a8	  = 0.0;	
	static $a9	  = 0.0;
	static $a10	 = 0.0;	
	static $ainv2   = 0.0;	
	static $alfdp   = 0.0;
	static $aqnv	= 0.0;	
	static $atime   = 0.0;	
	static $betdp   = 0.0;
	static $bfact   = 0.0;	
	static $c	   = 0.0;	
	static $cc	  = 0.0;
	static $cosis   = 0.0;	
	static $cosok   = 0.0;	
	static $cosq	= 0.0;
	static $ctem	= 0.0;	
	static $d2201   = 0.0;   
	static $d2211   = 0.0;
	static $d3210   = 0.0;   
	static $d3222   = 0.0;   
	static $d4410   = 0.0;
	static $d4422   = 0.0;	
	static $d5220   = 0.0;	
	static $d5232   = 0.0;
	static $d5421   = 0.0;	
	static $d5433   = 0.0;	
	static $dalf	= 0.0;
	static $day	 = 0.0;	
	static $dbet	= 0.0;	
	static $del1	= 0.0;
	static $del2	= 0.0;   
	static $del3	= 0.0;	
	static $delt	= 0.0;
	static $dls	 = 0.0;  
	static $e3	  = 0.0;	
	static $ee2	 = 0.0;
	static $eoc	 = 0.0;  
	static $eq	  = 0.0;   
	static $f2	  = 0.0;
	static $f220	= 0.0; 
	static $f221	= 0.0; 
	static $f3	  = 0.0;
	static $f311	= 0.0;  
	static $f321	= 0.0;   
	static $f322	= 0.0;
	static $f330	= 0.0;  
	static $f441	= 0.0;   
	static $f442	= 0.0;
	static $f522	= 0.0;  
	static $f523	= 0.0;   
	static $f542	= 0.0;
	static $f543	= 0.0;  
	static $fasx2   = 0.0; 
	static $fasx4   = 0.0;
	static $fasx6   = 0.0;  
	static $ft	  = 0.0;  
	static $g200	= 0.0;
	static $g201	= 0.0;  
	static $g211	= 0.0;  
	static $g300	= 0.0;
	static $g310	= 0.0; 
	static $g322	= 0.0;  
	static $g410	= 0.0;
	static $g422	= 0.0; 
	static $g520	= 0.0;  
	static $g521	= 0.0;
	static $g532	= 0.0;  
	static $g533	= 0.0;   
	static $gam	 = 0.0;
	static $omegaq  = 0.0;   
	static $pe	  = 0.0;  
	static $pgh	 = 0.0;
	static $ph	  = 0.0;  
	static $pinc	= 0.0;  
	static $pl	  = 0.0;
	static $preep   = 0.0; 
	static $s1	  = 0.0;  
	static $s2	  = 0.0;
	static $s3	  = 0.0; 
	static $s4	  = 0.0;  
	static $s5	  = 0.0;
	static $s6	  = 0.0; 
	static $s7	  = 0.0;  
	static $savtsn  = 0.0;
	static $se	  = 0.0; 
	static $se2	 = 0.0;  
	static $se3	 = 0.0;
	static $sel	 = 0.0;   
	static $ses	 = 0.0;  
	static $sgh	 = 0.0;
	static $sgh2	= 0.0;  
	static $sgh3	= 0.0;	
	static $sgh4	= 0.0;
	static $sghl	= 0.0;  
	static $sghs	= 0.0;   
	static $sh	  = 0.0;
	static $sh2	 = 0.0;  
	static $sh3	 = 0.0;  
	static $sh1	 = 0.0;
	static $shs	 = 0.0;  
	static $si	  = 0.0;   
	static $si2	 = 0.0;
	static $si3	 = 0.0;  
	static $sil	 = 0.0;  
	static $sini2   = 0.0;
	static $sinis   = 0.0; 
	static $sinok   = 0.0;  
	static $sinq	= 0.0;
	static $sinzf   = 0.0;  
	static $sis	 = 0.0;  
	static $sl	  = 0.0;
	static $sl2	 = 0.0;  
	static $sl3	 = 0.0;  
	static $sl4	 = 0.0;
	static $sll	 = 0.0;   
	static $sls	 = 0.0;  
	static $sse	 = 0.0;
	static $ssg	 = 0.0; 
	static $ssh	 = 0.0; 
	static $ssi	 = 0.0;
	static $ssl	 = 0.0; 
	static $stem	= 0.0;  
	static $step2   = 0.0;
	static $stepn   = 0.0; 
	static $stepp   = 0.0;  
	static $temp	= 0.0;
	static $temp1   = 0.0;
	static $thgr	= 0.0;  
	static $x1	  = 0.0;
	static $x2	  = 0.0;
	static $x2li	= 0.0;  
	static $x2omi   = 0.0;
	static $x3	  = 0.0;
	static $x4	  = 0.0;  
	static $x5	  = 0.0;
	static $x6	  = 0.0;
	static $x7	  = 0.0;
	static $x8	  = 0.0;
	static $xfact   = 0.0; 
	static $xgh2	= 0.0; 
	static $xgh3	= 0.0;
	static $xgh4	= 0.0; 
	static $xh2	 = 0.0; 
	static $xh3	 = 0.0;
	static $xi2	 = 0.0; 
	static $xi3	 = 0.0;  
	static $xl	  = 0.0;
	static $xl2	 = 0.0; 
	static $xl3	 = 0.0;  
	static $xl4	 = 0.0;
	static $xlamo   = 0.0; 
	static $xldot   = 0.0;   
	static $xli	 = 0.0;
	static $xls	 = 0.0;
	static $xmao	= 0.0; 
	static $xnddt   = 0.0;
	static $xndot   = 0.0;  
	static $xni	 = 0.0;   
	static $xno2	= 0.0;
	static $xnodce  = 0.0; 
	static $xnoi	= 0.0;  
	static $xnq	 = 0.0;
	static $xomi	= 0.0; 
	static $xpidot  = 0.0;  
	static $xqncl   = 0.0;
	static $z1	  = 0.0; 
	static $z11	 = 0.0;  
	static $z12	 = 0.0;
	static $z13	 = 0.0; 
	static $z2	  = 0.0;  
	static $z21	 = 0.0;
	static $z22	 = 0.0; 
	static $z23	 = 0.0;  
	static $z3	  = 0.0;
	static $z31	 = 0.0; 
	static $z32	 = 0.0;  
	static $z33	 = 0.0;
	static $zcosg   = 0.0; 
	static $zcosgl  = 0.0;  
	static $zcosh   = 0.0;
	static $zcoshl  = 0.0;  
	static $zcosi   = 0.0;   
	static $zcosil  = 0.0;
	static $ze	  = 0.0; 
	static $zf	  = 0.0;   
	static $zm	  = 0.0;
	static $zmo	 = 0.0; 
	static $zmol	= 0.0;  
	static $zmos	= 0.0;
	static $zn	  = 0.0;  
	static $zsing   = 0.0;   
	static $zsingl  = 0.0;
	static $zsinh   = 0.0; 
	static $zsinhl  = 0.0;  
	static $zsini   = 0.0;
	static $zsinil  = 0.0; 
	static $zx	  = 0.0;  
	static $zy	  = 0.0;
	static $ds50	= 0.0;
	switch ($ideep)
	{
	case 1 :
		$thgr = ThetaG($satdata->epoch, $ds50);
		$eq = $satdata->eo;
		$xnq = $xnodp;
		$aqnv = 1.0 / $ao;
		$xqncl = $satdata->xincl;
		$xmao = $satdata->xmo;
		$xpidot = $omgdt + $xnodot;
		$sinq = sin($satdata->xnodeo);
		$cosq = cos($satdata->xnodeo);
		$omegaq = $satdata->omegao;
				/* Initialize lunar solar terms */
		$day = $ds50 + 18261.5;  /*Days since 1900 Jan 0.5 -- 5:*/
		if ($day != $preep) 
		{
			$preep = $day;
			$xnodce = 4.5236020 - 9.2422029E-4 * $day;
			$stem = sin($xnodce);
			$ctem = cos($xnodce);
			$zcosil = 0.91375164 - 0.03568096 * $ctem;
			$zsinil = sqrt(1.0 - $zcosil * $zcosil);
			$zsinhl = 0.089683511*$stem/$zsinil;
			$zcoshl = sqrt(1.0 - $zsinhl * $zsinhl);
			$c = 4.7199672 + 0.22997150 * $day;
			$gam = 5.8351514 + 0.0019443680 * $day;
			$zmol = fmod2p($c - $gam);
			$zx = 0.39785416 * $stem / $zsinil;
			$zy = $zcoshl * $ctem + 0.91744867 * $zsinhl * $stem;
			$zx = actan($zx, $zy);
			$zx = $gam + $zx - $xnodce;
			$zcosgl = cos($zx);
			$zsingl = sin($zx);
			$zmos = 6.2565837 + 0.017201977 * $day;
			$zmos = fmod2p($zmos);
		}
		/* Do solar terms -- 10:*/
		$savtsn = 1.0E20;
		$zcosg = $zcosgs;
		$zsing = $zsings;
		$zcosi = $zcosis;
		$zsini = $zsinis;
		$zcosh = $cosq;
		$zsinh = $sinq;
		$cc = $c1ss;
		$zn = $zns;
		$ze = $zes;
		$zmo = $zmos;
		$xnoi = 1/$xnq;
		$ls = 30; /*assign 30 to ls -- 20:*/
		for ($i=0;$i<2;$i++)
		{
			$a1 = $zcosg * $zcosh + $zsing * $zcosi * $zsinh;
			$a3 = -$zsing * $zcosh + $zcosg * $zcosi * $zsinh;
			$a7 = -$zcosg * $zsinh + $zsing * $zcosi * $zcosh;
			$a8 = $zsing * $zsini;
			$a9 = $zsing * $zsinh + $zcosg * $zcosi * $zcosh;
			$a10 = $zcosg * $zsini;
			$a2 = $cosiq * $a7 +  $siniq * $a8;
			$a4 = $cosiq * $a9 +  $siniq * $a10;
			$a5 = -$siniq * $a7 +  $cosiq * $a8;
			$a6 = -$siniq * $a9 +  $cosiq * $a10;
			$x1 = $a1 * $cosomo + $a2 * $sinomo;
			$x2 = $a3 * $cosomo + $a4 * $sinomo;
			$x3 = -$a1 * $sinomo + $a2 * $cosomo;
			$x4 = -$a3 * $sinomo + $a4 * $cosomo;
			$x5 = $a5 * $sinomo;
			$x6 = $a6 * $sinomo;
			$x7 = $a5 * $cosomo;
			$x8 = $a6 * $cosomo;
			$z31 = 12.0 * $x1 * $x1 - 3.0 * $x3 * $x3;
			$z32 = 24.0 * $x1 * $x2 - 6.0 * $x3 * $x4;
			$z33 = 12.0 * $x2 * $x2 - 3.0 * $x4 * $x4;
			$z1 = 3.0 * ( sqr($a1) + sqr($a2) ) + $z31 * $eqsq;
			$z2 = 6.0 * ($a1 * $a3 + $a2 * $a4) + $z32 * $eqsq;
			$z3 = 3 * ($a3 * $a3 + $a4 * $a4) + $z33 * $eqsq;
			$z11 = -6.0 * $a1 * $a5 + $eqsq * (-24.0 * $x1 * $x7 - 6 * $x3 * $x5);
			$z12 = -6.0 * ($a1 * $a6 + $a3 * $a5) + $eqsq * (-24.0 * ( $x2 * $x7 + $x1 * $x8) - 6.0 * ($x3 * $x6 + $x4 * $x5));
			$z13 = -6.0 * $a3 * $a6 + $eqsq * (-24.0 * $x2 * $x8 - 6 * $x4 * $x6);
			$z21 = 6.0 * $a2 * $a5 + $eqsq * (24.0 * $x1 * $x5 - 6 * $x3 * $x7);
			$z22 = 6.0 * ($a4 * $a5 + $a2 * $a6) + $eqsq * (24.0 * ($x2 * $x5 + $x1 * $x6) - 6.0 * ($x4 * $x7 + $x3 * $x8));
			$z23 = 6.0 * $a4 * $a6 + $eqsq * (24.0 * $x2 * $x6 - 6.0 * $x4 * $x8);
			$z1 = $z1 + $z1 + $bsq * $z31;
			$z2 = $z2 + $z2 + $bsq * $z32;
			$z3 = $z3 + $z3 + $bsq * $z33;
			$s3 = $cc * $xnoi;
			$s2 = -0.5 * $s3 / $rteqsq;
			$s4 = $s3 * $rteqsq;
			$s1 = -15.0 * $eq * $s4;
			$s5 = $x1 * $x3 + $x2 * $x4;
			$s6 = $x2 * $x3 + $x1 * $x4;
			$s7 = $x2 * $x4 - $x1 * $x3;
			$se = $s1 * $zn * $s5;
			$si = $s2 * $zn * ($z11 + $z13);
			$sl = -$zn * $s3 * ($z1 + $z3 - 14.0 - 6.0 * $eqsq);
			$sgh = $s4 * $zn * ($z31 + $z33 - 6.0);
			$sh = -$zn * $s2 * ($z21 + $z23);
			if ($xqncl < 5.2359877E-2) 
				$sh = 0;
			$ee2 = 2.0 * $s1 * $s6;
			$e3 = 2.0 * $s1 * $s7;
			$xi2 = 2 * $s2 * $z12;
			$xi3 = 2 * $s2 * ($z13 - $z11);
			$xl2 = -2.0 * $s3 * $z2;
			$xl3 = -2.0 * $s3 * ($z3 - $z1);
			$xl4 = -2.0 * $s3 * (-21 - 9 * $eqsq) * $ze;
			$xgh2 = 2.0 * $s4 * $z32;
			$xgh3 = 2.0 * $s4 * ($z33 - $z31);
			$xgh4 = -18.0 * $s4 * $ze;
			$xh2 = -2.0 * $s2 * $z22;
			$xh3 = -2.0 * $s2 * ($z23 - $z21);
			if ($ls==30) {
				$sse = $se;
				$ssi = $si;
				$ssl = $sl;
				$ssh = $sh / $siniq;
				$ssg = $sgh - $cosiq * $ssh;
				$se2 = $ee2;
				$si2 = $xi2;
				$sl2 = $xl2;
				$sgh2 = $xgh2;
				$sh2 = $xh2;
				$se3 = $e3;
				$si3 = $xi3;
				$sl3 = $xl3;
				$sgh3 = $xgh3;
				$sh3 = $xh3;
				$sl4 = $xl4;
				$sgh4 = $xgh4;
				$zcosg = $zcosgl;
				$zsing = $zsingl;
				$zcosi = $zcosil;
				$zsini = $zsinil;
				$zcosh = $zcoshl * $cosq + $zsinhl * $sinq;
				$zsinh = $sinq * $zcoshl - $cosq * $zsinhl;
				$zn = $znl;
				$cc = $c1l;
				$ze = $zel;
				$zmo = $zmol;
				$ls = 40; /*assign 40 to ls*/
			}
		}
		$sse = $sse + $se;
		$ssi = $ssi + $si;
		$ssl = $ssl + $sl;
		$ssg = $ssg + $sgh - $cosiq / $siniq * $sh;
		$ssh = $ssh + $sh / $siniq;
		/* Geopotential resonance initialization for 12 hour orbits */
		$iresfl = 0;
		$isynfl = 0;

		if (($xnq < 0.0052359877) && ($xnq > 0.0034906585)) 
		{
			/* Synchronous resonance terms initialization */
			$iresfl = 1;
			$isynfl = 1;
			$g200 = 1.0 + $eqsq * (-2.5 + 0.8125 * $eqsq);
			$g310 = 1.0 + 2.0 * $eqsq;
			$g300 = 1.0 + $eqsq * (-6 + 6.60937 * $eqsq);
			$f220 = 0.75 * (1.0 + $cosiq) * (1.0 + $cosiq);
			$f311 = 0.9375 * $siniq * $siniq * (1.0 + 3.0 * $cosiq) - 0.75 * (1.0 + $cosiq);
			$f330 = 1.0 + $cosiq;
			$f330 = 1.875 * $f330 * $f330 * $f330;
			$del1 = 3.0 * $xnq * $xnq * $aqnv * $aqnv;
			$del2 = 2.0 * $del1 * $f220 * $g200 * $q22;
			$del3 = 3.0 * $del1 * $f330 * $g300 * $q33 * $aqnv;
			$del1 = $del1 * $f311 * $g310 * $q31 * $aqnv;
			$fasx2 = 0.13130908;
			$fasx4 = 2.8843198;
			$fasx6 = 0.37448087;
			$xlamo = $xmao + ($satdata->xnodeo) + ($satdata->omegao) - $thgr;
			$bfact = $xlldot + $xpidot - thdt;
			$bfact = $bfact + $ssl + $ssg + $ssh;
		} else {
			if (($xnq < 8.26E-3) || ($xnq > 9.24E-3)) break;
			if ($eq<0.5) break;
			$iresfl = 1;
			$eoc = $eq * $eqsq;
			$g201 = -0.306 - ($eq - 0.64) * 0.440;
			if ($eq < 0.65) 
			{
				$g211 = 3.616 - 13.247 * $eq + 16.290 * $eqsq;
				$g310 = -19.302 + 117.390 * $eq - 228.419 * $eqsq + 156.591 * $eoc;
				$g322 = -18.9068 + 109.7927 * $eq - 214.6334 * $eqsq + 146.5816 * $eoc;
				$g410 = -41.122 + 242.694 * $eq - 471.094 * $eqsq + 313.953 * $eoc;
				$g422 = -146.407 + 841.880 * $eq - 1629.014 * $eqsq + 1083.435 * $eoc;
				$g520 = -532.114 + 3017.977 * $eq - 5740 * $eqsq + 3708.276 * $eoc;
			} else {
				$g211 = -72.099 + 331.819 * $eq - 508.738 * $eqsq + 266.724 * $eoc;
				$g310 = -346.844 + 1582.851 * $eq - 2415.925 * $eqsq + 1246.113 * $eoc;
				$g322 = -342.585 + 1554.908 * $eq - 2366.899 * $eqsq + 1215.972 * $eoc;
				$g410 = -1052.797 + 4758.686 * $eq - 7193.992 * $eqsq + 3651.957 * $eoc;
				$g422 = -3581.69 + 16178.11 * $eq - 24462.77 * $eqsq + 12422.52 * $eoc;
				if ($eq > 0.715) 
					$g520 = -5149.66 + 29936.92 * $eq - 54087.36 * $eqsq + 31324.56 * $eoc; 
				else
					$g520 = 1464.74 - 4664.75 * $eq + 3763.64* $eqsq;
			}
			
			if ($eq < (0.7)) 
			{
				$g533 = -919.2277 + 4988.61 * $eq - 9064.77 * $eqsq + 5542.21 * $eoc;
				$g521 = -822.71072 + 4568.6173 * $eq - 8491.4146 * $eqsq + 5337.524 * $eoc;
				$g532 = -853.666 + 4690.25 * $eq - 8624.77 * $eqsq + 5341.4 * $eoc;
			} else {
				$g533 = -37995.78 + 161616.52 * $eq - 229838.2 * $eqsq + 109377.94 * $eoc;
				$g521 = -51752.104 + 218913.95 * $eq - 309468.16 * $eqsq + 146349.42 * $eoc;
				$g532 = -40023.88 + 170470.89 * $eq - 242699.48 * $eqsq + 115605.82 * $eoc;
			}
			$sini2 = $siniq * $siniq;
			$f220 = 0.75 * (1.0 + 2.0 * $cosiq + $cosq2);
			$f221 = 1.5 * $sini2;
			$f321 = 1.875 * $siniq * (1.0 - 2.0 * $cosiq - 3.0 * $cosq2);
			$f322 = -1.875 * $siniq * (1.0 + 2.0 * $cosiq - 3.0 * $cosq2);
			$f441 = 35.0 * $sini2 * $f220;
			$f442 = 39.3750 * $sini2 * $sini2;
			$f522 = 9.84375 * $siniq * ($sini2 * (1.0 - 2.0 * $cosiq - 5.0 * $cosq2)
						  + 0.33333333*(-2 + 4*$cosiq + 6*$cosq2));
			$f523 = $siniq * (4.92187512 * $sini2 * (-2.0 - 4.0 * $cosiq + 10.0 * $cosq2) + 6.56250012 * (1.0 + 2.0 * $cosiq - 3.0 * $cosq2));
			$f542 = 29.53125 * $siniq *(2.0 - 8.0 * $cosiq + $cosq2*(-12.0 + 8.0 * $cosiq + 10.0 * $cosq2));
			$f543 = 29.53125 * $siniq * (-2.0 - 8.0 * $cosiq + $cosq2 * (12.0 + 8.0 * $cosiq - 10.0 * $cosq2));
			$xno2 = $xnq * $xnq;
			$ainv2 = $aqnv * $aqnv;
			$temp1 = 3 * $xno2 * $ainv2;
			$temp = $temp1 * $root22;
			$d2201 = $temp * $f220 * $g201;
			$d2211 = $temp * $f221 * $g211;
			$temp1 = $temp1 * $aqnv;
			$temp = $temp1 * $root32;
			$d3210 = $temp * $f321 * $g310;
			$d3222 = $temp * $f322 * $g322;
			$temp1 = $temp1 * $aqnv;
			$temp = 2.0 * $temp1 * $root44;
			$d4410 = $temp * $f441 * $g410;
			$d4422 = $temp * $f442 * $g422;
			$temp1 = $temp1 * $aqnv;
			$temp = $temp1 * $root52;
			$d5220 = $temp * $f522 * $g520;
			$d5232 = $temp * $f523 * $g532;
			$temp = 2.0 * $temp1 * $root54;
			$d5421 = $temp * $f542 * $g521;
			$d5433 = $temp * $f543 * $g533;
			$xlamo = $xmao + 2.0*($satdata->xnodeo) - $thgr - $thgr;
			$bfact = $xlldot + $xnodot + $xnodot - $thdt - $thdt;
			$bfact = $bfact + $ssl + $ssh + $ssh;
		}
		$xfact = $bfact - $xnq;
		/* Initialize integrator */
		$xli = $xlamo;
		$xni = $xnq;
		$atime = 0.0;
		$stepp = 720.0;
		$stepn = -720.0;
		$step2 = 259200;
		break;
	case 2:
		/* Entrance for deep space secular effects */
		$xll = $xll + $ssl * $t;
		$omgasm = $omgasm + $ssg * $t;
		$xnodes = $xnodes + $ssh * $t;
		$em_d = ($satdata->eo) + $sse  * $t;
		$xinc = $satdata->xincl + $ssi * $t;
		if ($xinc < 0) 
		{
			$xinc = -$xinc;
			$xnodes = $xnodes + _pi;
			$omgasm = $omgasm - _pi;
		}
		if ($iresfl != 0) 
		{
			$i = 0;
			$i2 = 0;
			do {
				if ($i2==0) /* block "100" */
				{
					if ($atime == 0) 
					{
						/* Epoch restart - Block "170"*/
						if ($t >= 0) 
							$delt = $stepp;
						else
							$delt = $stepn;
						$atime = 0.0;
						$xni = $xnq;
						$xli = $xlamo;
						$i2 = 1;
					} else {
						if (abs($t) < abs($atime))
						{
							$delt = $stepp;
							if ($t >= 0) 
								$delt = $stepn;
							$iret = 100;
							$i2 = 0;
						} else {
							$delt = $stepn;
							if ($t > 0)
								$delt = $stepp;
							$i2 = 1;
							}
						}
				}

				if ($i2==1) /* Block "125" */
				{
					if (abs($t - $atime) > $stepp)
					{
						$iret = 125;
						$i2 = 0;
					} else {
						$ft = $t - $atime;
						$iretn = 140;
						$i2 = 1;
					}
				}

				if ($i2==0) /* Block "160" */
				{
					$iretn = 165;
				}

				$i2 = 0;
				/* Block "150" */
				/* Dot terms calculated */
				if ($isynfl != 0) 
				{
					$xndot = $del1 * sin($xli - $fasx2) + $del2 * sin(2.0 * ($xli - $fasx4)) + $del3 * sin(3.0 * ($xli - $fasx6));
					$xnddt = $del1 * cos($xli - $fasx2) + 2.0 * $del2 * cos(2*($xli - $fasx4)) + 3.0 * $del3 * cos(3.0 * ($xli - $fasx6));
				} else {
					$xomi = $omegaq + $omgdt * $atime;
					$x2omi = $xomi + $xomi;
					$x2li = $xli + $xli;
					$xndot = $d2201 * sin($x2omi + $xli - $g22) + $d2211 * sin($xli - $g22) + $d3210 * sin($xomi + $xli - $g32) + $d3222 * sin(-$xomi + $xli - $g32) + $d4410 * sin($x2omi + $x2li - $g44) + $d4422 * sin($x2li - $g44) + $d5220 * sin($xomi + $xli - $g52) + $d5232 * sin(-$xomi + $xli - $g52) + $d5421 * sin($xomi + $x2li - $g54) + $d5433 * sin(-$xomi + $x2li - $g54);
					$xnddt = $d2201 * cos($x2omi + $xli - $g22) + $d2211 * cos($xli - $g22)	+ $d3210  * cos($xomi + $xli - $g32) + $d3222 * cos(-$xomi + $xli - $g32) + $d5220 * cos($xomi + $xli - $g52) + $d5232 * cos(-$xomi + $xli - $g52) + 2.0 * ($d4410 * cos($x2omi + $x2li - $g44) + $d4422 * cos($x2li - $g44) + $d5421 * cos($xomi + $x2li - $g54) + $d5433 * cos(-$xomi + $x2li - $g54));
				}
				$xldot = $xni + $xfact;
				$xnddt = $xnddt * $xldot;
				switch ($iretn)
				{
				case 140 : 
					/* Block 140 */
					$xn = $xni + $xndot * $ft + $xnddt * $ft * $ft * 0.5;
					$xl = $xli + $xldot * $ft + $xndot * $ft * $ft * 0.5;
					$temp = -$xnodes + $thgr + $t * $thdt;
					$xll = $xl - $omgasm + $temp;
					if ($isynfl == 0)
						$xll = $xl + $temp + $temp;
					$i2=1;
					$i=1;
					break;
				case 165 : 
					$i2=0;
					break;
				default :
					exit(1);
				}

				if ($i2==0) /* Block "165" */
				{
					$xli = $xli + $xldot * $delt + $xndot * $step2;
					$xni = $xni + $xndot * $delt + $xnddt * $step2;
					$atime = $atime + $delt;
					switch ($iret)
					{
					case 100:
						$i2=0;
						break;
					case 125:
						$i2=1;
						break;
					default:
						exit(1);
					}
				}
			} while ($i==0);
		}
		break; 
	case 3:
			 /* Entrance for lunar-solar periodics */
			 $sinis = sin($xinc);
			 $cosis = cos($xinc);
			 if (abs($savtsn - $t) > 30) 
		 {
			 $savtsn = $t;
			 $zm = $zmos + $zns * $t;
			 $zf = $zm + 2.0 * $zes * sin($zm);
			 $sinzf = sin($zf);
			 $f2 = 0.5 * $sinzf * $sinzf - 0.25;
			 $f3 = -0.5 * $sinzf * cos($zf);
			 $ses = $se2 * $f2 + $se3 * $f3;
			 $sis = $si2 * $f2 + $si3 * $f3;
			 $sls = $sl2 * $f2 + $sl3 * $f3 + $sl4 * $sinzf;
			 $sghs = $sgh2 * $f2 + $sgh3 * $f3 + $sgh4 * $sinzf;
			 $shs = $sh2 * $f2 + $sh3 * $f3;
			 $zm = $zmol + $znl * $t;
			 $zf = $zm + 2.0 * $zel * sin($zm);
			 $sinzf = sin($zf);
			 $f2 = 0.5 * $sinzf * $sinzf - 0.25;
			 $f3 = -0.5 * $sinzf * cos($zf);
			 $sel = $ee2 * $f2 + $e3 * $f3;
			 $sil = $xi2 * $f2 + $xi3 * $f3;
			 $sll = $xl2 * $f2 + $xl3 * $f3 + $xl4 * $sinzf;
			 $sghl = $xgh2 * $f2 + $xgh3 * $f3 + $xgh4 * $sinzf;
			 $sh1 = $xh2 * $f2 + $xh3 * $f3;
			 $pe = $ses + $sel;
			 $pinc = $sis + $sil;
			 $pl = $sls + $sll;
		 }
		 $pgh = $sghs + $sghl;
			 $ph = $shs + $sh1;
			 $xinc = $xinc + $pinc;
			 $em_d = $em_d + $pe;
			 if ($xqncl > 0.2) 
		 {
			 /* Apply periodics directly */
			 $ph = $ph / $siniq;
			 $pgh = $pgh - $cosiq * $ph;
			 $omgasm = $omgasm + $pgh;
			 $xnodes = $xnodes + $ph;
			 $xll = $xll + $pl;
			 } else {
			 /* Apply periodics with Lyddane modification */
			 $sinok = sin($xnodes);
			 $cosok = cos($xnodes);
			 $alfdp = $sinis * $sinok;
			 $betdp = $sinis * $cosok;
			 $dalf = $ph * $cosok + $pinc * $cosis * $sinok;
			 $dbet = -$ph * $sinok + $pinc * $cosis * $cosok;
			 $alfdp = $alfdp + $dalf;
			 $betdp = $betdp + $dbet;
			 $xls = $xll + $omgasm + $cosis * $xnodes;
			 $dls = $pl + $pgh - $pinc * $xnodes * $sinis;
			 $xls = $xls + $dls;
			 $xnodes = actan($alfdp, $betdp);
			 $xll = $xll + $pl;
			 $omgasm = $xls - $xll - cos($xinc) * $xnodes;
		 }
		 break;
	} 
}
?>






