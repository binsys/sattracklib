<?php
/* ------------------------------------------------------------------- *
 * --------------------------- definitions --------------------------- *
 * ------------------------------------------------------------------- */
 
/* when you call the function int sgp(int mode,...), you can pass one of 
 * these as first parameter - "mode". This makes your code more readable.
 */
 
define("_SGP0",0);
define("_SGP4",1);
define("_SDP4",2);
define("_SGP8",3);
define("_SDP8",4);

/* ------------------------------------------------------------------- *
 * ----------------------------- structs ----------------------------- *
 * ------------------------------------------------------------------- */

class vector
{
	var $v = array(0.0,0.0,0.0,0.0);
}
/* 3-dimensional vector, the fourth element contains the magnitude 
 */
 
 
 
class geodetic_t
{
	var $lat = 0.0;
	var $lon = 0.0;
	var $alt = 0.0;
	var $theta = 0.0;
	
}


class tle_ascii
{
	var $l = array(array(""),array(""),array(""));
}
/* a standard three-line Two-Line-Element. Yes, that's right: the first
 * line usually is a header stating the name of the object and sometimes
 * additional information, and the second and the third line form the
 * classic "Two-Line-Element".
 */

class sgp_data
{
	var $epoch = 0.0;
	var $julian_epoch =0.0;
	var $xno =0.0;
	var $bstar =0.0;
	var $xincl =0.0;
	var $eo =0.0;
	var $xmo =0.0;
	var $omegao =0.0;
	var $xnodeo =0.0;
	var $xndt2o =0.0;
	var $xndd6o =0.0;
	var $catnr = array('','','','','');
	var $elset = array('','','','');
	var $ideep = 0;
}
/* Convert_Satellite_Data(...) transforms the ascii-Two-Line-Element 
 * into binary values and saves them in this struct.
 */



/* ------------------------------------------------------------------- *
 * --------------------------- prototypes ---------------------------- *
 * ------------------------------------------------------------------- */

/*
int sgp (int mode, double time, struct tle_ascii tle, struct vector *pos, struct vector *vel);*/
/* Whenever you want to access any of the SGP, SGP4/SDP4 or SGP8/SDP8
 * models, it is strongly recommended that you use this function as
 * only interface. 
 *
 * INPUT:
 * int                 mode :   this specifies the model you want to use 
 *                              for the calculation. Please use _SGP0 for 
 *                              SGP, _SGP4 or _SDP4 for SGP4/SDP4, and
 *	 	                _SGP8 or _SDP8 for SGP8/SDP8.
 * double              time :   julian time for which the position and
 *                              veloicity shall be determined.
 * struct tle_ascii    tle  :   input data - a standard TwoLine Element in
 *                              lines 2 and 3; line 1 (usually including
 *                              object name and additional information)
 *                              is not used by sgp-c-lib.
 *
 * OUTPUT:
 * struct vector       *pos :   postion of object at "time" - in km.
 * struct vector       *vel :   veloicity of object at "time" - in km/s
 */


//double Julian_Date_of_Epoch(double epoch);

//double Julian_Date_of_Epoch(double epoch);
/* Julian_Date_of_Epoch returns the julian date of the date specified by 
 * the "TLE-style epoch" value given as parameter. This is especially
 * useful for correctly determing the "time" parameter for sgp(...)
 */

//void Convert_Satellite_Data (struct tle_ascii tle, struct sgp_data *data);
/* Convert_Satellite_Data tranforms an ascii-TLE to the binary struct
 * sgp_data needed for all propagation models
 */

//void Convert_Sat_State (struct vector *p, struct vector *v);
/* Convert_Sat_State transfers the output to km, km/s and calculates the
 * magnitude of these two vectors.
 */


/* sgp0.c */
//void sgp0 (double tsince, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
//void sgp0call (double time, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
/* sgp0 and sgp0call offer direct access to calculations with the SGP model. 
 * Note that all parameters have to be in the appropriate units. Use of this 
 * direct access is strongly discouraged. */


/* sgp4sdp4.c */
//void sgp4 (double tsince, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
//void sdp4 (double tsince, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
//void sgp4call (double time, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
/* sgp4, sdp4 and sgp0call offer direct access to calculations with the 
 * SGP4/SDP4 model. Note that all parameters have to be in the appropriate
 * units. Use of this direct access is strongly discouraged. */


/* sgp8sdp8.c */
//void sgp8 (double tsince, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
//void sdp8 (double tsince, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
//void sgp8call (double time, struct vector *pos, struct vector *vel, struct sgp_data *satdata);
/* sgp8, sdp8 and sgp0call offer direct access to calculations with the 
 * SGP8/SDP8 model. Note that all parameters have to be in the appropriate
 * units. Use of this direct access is strongly discouraged. */

?>