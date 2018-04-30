<?php

// Prefix for all related session variables.
define("S_PREFIX", "100sc_");

define("CALC_PATH", "includes/class.calculator.php");

// Email Information
define("SALES_EMAIL", "sales@schletter.us");
define("FEEDBACK_EMAIL", "marketing@schletter.us");

define("IMG_WIDTH", "800");
define("IMG_PADDING", "15");

define("IMG_RAFTER_SIZE", "2"); // Minimum px for a rafter in any image

define("MM_PER_INCH", 25.4);
define("INCH_PER_FOOT", 12);
define('METERS_PER_FOOT', 0.3048);
define('INCHES_PER_METER', 39.3701);

// Building Information Constants
define("GABLE", 1);
define("MONO",  2);

// Building Information Constants
define("ASPHALT",             1);
define("ASPHALT_W_CLEARANCE", 2);
define("TRAPEZOIDAL",         3);
define("STANDING_SEAM",       4);

// Building Information Constants
define("HORIZ_SEAMS_OVER",       1);
define("HORIZ_SEAMS_UNDER",      2);
define("T_SHAPED_SEAM",          3);
define("SINGLE_FOLD_SEAM",       4);
define("ANGLE_SEAM",             5);
define("ROUND_BULB_SEAM",        6);
define("VERTICAL_STANDING_SEAM", 7);

// Building Information Constants
define("R2_X_4", 1);
define("R2_X_6", 2);

// Environment Constants
define("CATEGORY_B", 1);
define("CATEGORY_C", 2);
define("CATEGORY_D", 3);

// Environment Constants
define("IMPORTANCE_CATEGORY_II", "II");
define("IMPORTANCE_CATEGORY_III", "III");
define("IMPORTANCE_CATEGORY_IV", "IV");

// Module Constants
define("PORTRAIT", 1);
define("LANDSCAPE", 2);

define("MAX_ROWS", 10); // No longer used.
define("MAX_COLS", 15); // No longer used.

// Zone Constants
define("INTERIOR_ZONE", 1);
define("EXTERIOR_ZONE", 2);
define("CORNER_ZONE",   3);

// Clamp Constants
define("END_CLAMP", 1);
define("MIDDLE_CLAMP", 2);

define("LANDSCAPE_INTER_MODULE_GAP_FT", 0.01667);    // ~5mm  space between cols in landscape 
define("CLAMP_GAP_FT", 0.07583); // ~23mm space between cols in portrait due to clamp dims
define("RAIL_EXTRA_FT", 0.26250); // ~40mm extra at rail ends

define("ZONE_THRESHOLD", .05); // if 5% of a module is in a specific zone...

// Splice Constants
define("MIN_SPLICE_PLACEMENT", 15); // E.g., Splices should be placed between 15% and
define("MAX_SPLICE_PLACEMENT", 30); // 30% of the roof attachment span.

define("SPLICE_PLACEMENT_THRESHOLD", 48); // If roof attachment spacing is less than 48 inches, we don't need to worry about where it goes.
define("SPLICE_MOUNT_THRESHOLD", 4); // A splice can only be within (195/2)mm of a roof attachment (a little less than 4").
define("SPLICE_CLAMP_THRESHOLD", 1); // A regular splice can only be within 1" a module clamp.

// Environment Constants
define("MIN_WIND_SPEED", 85);
define("MIN_WIND_SPEED_ASCE_7_10", 110);
//define("MAX_WIND_SPEED", 130);
define("MAX_WIND_SPEED", 215);
define("MIN_SNOW_LOAD", 0);
define("MAX_SNOW_LOAD", 90);
define("DEFAULT_SDS", 1.6);

// Building Size Constants
define("MIN_ROOF_HEIGHT", 11); // In feet.
define("MAX_ROOF_HEIGHT", 60); // In feet.
define("MAX_ROOF_WIDTH", 200); // In feet.
define("MAX_ROOF_LENGTH", 200); // In feet.
define("MAX_MONO_ROOF_SLOPE", 30); // In degrees.
define("MAX_GABLE_ROOF_SLOPE", 45); // In degrees.
define("MAX_RAFTER_SPACING", 48); // In inches.

// Rail length constants
define("MAX_RAIL_LENGTH", 6.2); // Max rail length in m
define("THERMAL_EXPANSION_THRESHOLD", 10.668); // Place a thermal expansion at ___m or less.
define("THERMAL_EXPANSION_SPACING", 1); // Space needed between modules for a thermal expansion (in inches)

// Splice constants
define("NORMAL_SPLICE", 1);
define("THERMAL_EXPANSION_SPLICE", 2);

// Image constants
define("MAX_ZOOM_HEIGHT", 300); // Used to minimize the height of 'zoomed in' images.

// Code constants
define("ASCE_7_5", 1);
define("ASCE_7_10", 2);

?>
