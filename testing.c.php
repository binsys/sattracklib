<?php
/* testing.c -- a part of the SGP - C Library
 *
 * Copyright (c) 2001-2002 Dominik Brodowski
 *           (c) 1992-2000 Dr TS Kelso
 *
 * This file is part of the SGP C Library.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public 
 * License as published by the Free Software Foundation; either 
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU 
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public 
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * This SGP C Library is based on the SGP4 Pascal Library by Dr TS Kelso.
 *
 * You can reach Dominik Brodowski by electronic mail at
 * mail@brodo.de
 * and by paper mail at 
 * Karlstrasse 11a; 72072 Tuebingen; Germany
 */



/* ------------------------------------------------------------------- *
 * ---------------------------- includes ----------------------------- *
 * ------------------------------------------------------------------- */

//#include "sgp.h"
//#include <stdio.h>
//#include <math.h>
//#include <string.h>

include "sgp.php";
include "sgp_int.php";
include "sgp_conv.php";
include "sgp_time.php";
include "sgp_math.php";
include "sgp4sdp4.php";
include "sgp_deep.php";
include "sgp8sdp8.php";
include "util.php";

/* ------------------------------------------------------------------- *
 * ------------------------------ clrscr ----------------------------- *
 * ------------------------------------------------------------------- */

function clrscr ()
{
	$i;
	for ($i=1;($i<25);$i++) printf("\n");
}



/* ------------------------------------------------------------------- *
 * ---------------------------- gettestdata -------------------------- *
 * ------------------------------------------------------------------- */
/*
void gettestdata (struct tle_ascii *sat_data1, struct tle_ascii *sat_data2)
{
	char inputchar[73];
	FILE *$testdatafile;
	$testdatafile=fopen("testdata","r");
	fgets($testdatafile);
	substr(sat_data1->l[1], inputchar, 70);
	fgets($testdatafile);
	substr(sat_data1->l[2], inputchar, 70);
	fgets($testdatafile);
	substr(sat_data2->l[1], inputchar, 70);
	fgets($testdatafile);
	substr(sat_data2->l[2], inputchar, 70);
	fclose($testdatafile);
}
*/


function gettestdata (&$sat_data1, &$sat_data2)
{
	//char inputchar[73];
	$inputchar = '';
	
	$testdatafile;
	$testdatafile=fopen("testdata","r");
	$inputchar = fgets($testdatafile,72);
	$sat_data1->l[1] = substr($inputchar,0,70);
	$inputchar = fgets($testdatafile,72);
	$sat_data1->l[2] = substr($inputchar,0,70);
	$inputchar = fgets($testdatafile,72);
	$sat_data2->l[1] = substr($inputchar,0,70);
	$inputchar = fgets($testdatafile,72);
	$sat_data2->l[2] = substr($inputchar,0,70);
	fclose($testdatafile);
}


/* ------------------------------------------------------------------- *
 * ------------------------------ sgp_test --------------------------- *
 * ------------------------------------------------------------------- */

function sgp_test ()
{
	//struct vector pos[5], vel[5];
	$pos = array(new vector(),new vector(),new vector(),new vector(),new vector());
	$vel = array(new vector(),new vector(),new vector(),new vector(),new vector());
	$satdata = new sgp_data();

	$satnumber=0;$interval = 0;$j = 0;
	$delta = 0.0;$tsince = 0.0;
	//struct tle_ascii sat_data[2];
	$sat_data = array(new tle_ascii(),new tle_ascii());
 	
	$c = '';
	gettestdata($sat_data[0],$sat_data[1]);
	$delta = 360.0;
	
	echo "<pre>";
	for ($j=0;($j<4);$j++)
	{
		$model=0;
		printf("\n\n\n");
		switch ($j)
		{
		case 0 :
			$model = _SGP4;
			printf("*** SGP4 ***\n\n");
			$satnumber = 0;
			break;
			
		case 1 :
			$model = _SDP4;
			printf("*** SDP4 ***\n\n");
			$satnumber = 1;
			break;
		case 2 :
			$model = _SGP8;
			printf("*** SGP8 ***\n\n");
			$satnumber = 0;
			break;
		case 3 :
			$model = _SDP8;
			printf("*** SDP8 ***\n\n");
			$satnumber = 1;
			break;
		}

		printf("%s",$sat_data[$satnumber]->l[1]);
		printf("%s",$sat_data[$satnumber]->l[2]);
		printf("\n");
		printf("\n");
		Convert_Satellite_Data($sat_data[$satnumber],$satdata);
		for ($interval=0;($interval<=4);$interval++)
		{
			$tsince = $interval * $delta;
			switch ($model) 
			{
			case _SGP4:
				sgp4($tsince,$pos[$interval],$vel[$interval],$satdata);
				break;
			case _SDP4:
				sdp4($tsince,$pos[$interval],$vel[$interval],$satdata);
				break;
			case _SGP8:
				sgp8($tsince,$pos[$interval],$vel[$interval],$satdata);
				break;
			case _SDP8:
				sdp8($tsince,$pos[$interval],$vel[$interval],$satdata);
				break;
			}
			Convert_Sat_State($pos[$interval],$vel[$interval]);
			$pos[$interval]->v[3]=$tsince;
		}
		printf("  TSINCE           X                  Y                  Z \n");
		for ($interval=0;($interval<=4);$interval++)
			printf(" % 7.1f    % 15.8f    % 15.8f    % 15.8f \n", $pos[$interval]->v[3], $pos[$interval]->v[0],$pos[$interval]->v[1],$pos[$interval]->v[2]);
		//$lat = asin(($pos[$interval]->v[2]) / xkmper);
		//$lon = atan2($pos[$interval]->v[1], $pos[$interval]->v[0]);
		//echo $lat;
		//echo $lon;
		/*
		printf("  TSINCE           Lat                 Lon                 Alt \n");
		for ($interval=0;($interval<=4);$interval++)
		{
			$SatPos = new SatPos();
			calculateLatLonAlt($pos[$interval]->v[3],$pos[$interval],$SatPos) ;
			printf(" % 7.1f    % 15.8f    % 15.8f    % 15.8f \n", $pos[$interval]->v[3],$SatPos->lat,$SatPos->lon,$SatPos->alt);
		}
		printf("\n");
		*/
		printf("\n\n\n                   XDOT               YDOT             ZDOT \n");
		for ($interval=0;($interval<=4);$interval++)
			printf("             % 13.8f      % 13.8f     % 13.8f \n",$vel[$interval]->v[0],$vel[$interval]->v[1],$vel[$interval]->v[2]);
		printf("\n");
		


		//fflush(stdin);
		//c=getchar();

	}
	echo "</pre>";
	



}


/* ------------------------------------------------------------------- *
 * -------------------------------- main ----------------------------- *
 * ------------------------------------------------------------------- */

function main ()
{
	sgp_test();
}
main();
?>



