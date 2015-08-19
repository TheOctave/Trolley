<?php

/**
 * Holds all the spherical geometry algorithms
 */
class Algorithm {

    const DIST_EPSILON = 1.0E-5;
    const DEGREE_EPSILON = 1.0E-1;
    const EPSILON = 1.0E-5;
    const EARTH_RADIUS = 6378100; //in meters
    
    /**
     * Calculates the dot product of two vectors
     * @param float array $vecA
     * @param float array $vecB
     * @return float
     */
    private static function dotProduct($vecA, $vecB) {
        
        if (count($vecA) != count($vecB))
            return false;
        
        $sum = 0;
        $size = count($vecA);
        
        for ($i = 0; $i < $size; $i++) {
            
            $sum += $vecA[$i] * $vecB[$i];
        }
        
        return $sum;
    }
    
    /**
     * Calculate the magnitude of a vector
     * @param float array $vecA
     * @return float
     */
    private static function vecMagnitude($vecA) {
        
        $squareMagnitude = 0;
        
        $size = count($vecA);
        print 'Vec Size: ' . $size;
        for ($i = 0; $i < $size; $i++) {
            
            $squareMagnitude += $vecA[$i] * $vecA[$i];
        }
        
        print 'Square magnitude ' . $squareMagnitude;
        
        return sqrt($squareMagnitude);
    }
    
    /**
     * Calculates the unit vector, given a vector
     * @param float array $vecA
     * @return float array array
     */
    private static function unitVector($vecA) {
        
        $unitVec = [];
        $size = count($vecA);
        $mag = self::vecMagnitude($vecA);
        
        for ($i = 0; $i < $size; $i++) {
            
            array_push($unitVec, $vecA[$i] / $mag);
        }
        
        return $unitVec;
    }
    
    /**
     * Converts Geographical coordinates (LatLng) to Cartesian (x, y, z)
     * @param GeographicalicalPoint $point
     * @return \SphericalPoint
     */
    private static function geographicalToCartesian($point) {
        
        $x = cos(deg2rad($point->_latitude)) * cos(deg2rad($point->_longitude));
        $y = cos(deg2rad($point->_latitude)) * sin(deg2rad($point->_longitude));
        $z = sin(deg2rad($point->_latitude));
        
        return new SphericalPoint($x, $y, $z);
    }
    
    /**
     * Converts Cartesian coordinates(x, y, z) to Geographical (LatLng)
     * @param SphericalPoint $point
     * @return \GeographicalPoint
     */
    private static function cartesianToGeographical($point) {
        
        $lat = asin($point->_z);
        $long = atan($point->_y / $point->_x);
        
        return new GeographicalPoint(rad2deg($lat), rad2deg($long));
    }
    
    /**
     * Calculate the angle a great circle makes with the equator
     * @param GeographicalLine $line
     * @return float
     */
    private static function equatorialAngle($line) {
        
        /*
         * Convert line's points to cartesian coordinates
         */
        $pointA = self::geographicalToCartesian($line->_pointA);
        $pointB = self::geographicalToCartesian($line->_pointB);
        $arc = new SphericalLine($pointA, $pointB);
        /*
         * caculate the normal vector to the great circle plane
         */
        $vectorA = [$arc->_pointA->_y * $arc->_pointB->_z - $arc->_pointB->_y * $arc->_pointA->_z,
                    $arc->_pointB->_x * $arc->_pointA->_z - $arc->_pointA->_x * $arc->_pointB->_z,
                    $arc->_pointA->_x * $arc->_pointB->_y - $arc->_pointB->_x * $arc->_pointA->_y];
        
        /*
         * Set parameters for the equatorial line/arc
         */
        $pointC = self::geographicalToCartesian(new GeographicalPoint(0, 0));
        $pointD = self::geographicalToCartesian(new GeographicalPoint(0, 1.57));
        $arc = new SphericalLine($pointC, $pointB);
        /*
         * Calculate the vector normal to the equatorial circle
         */
        $vectorB = [$arc->_pointA->_y * $arc->_pointB->_z - $arc->_pointB->_y * $arc->_pointA->_z,
                    $arc->_pointB->_x * $arc->_pointA->_z - $arc->_pointA->_x * $arc->_pointB->_z,
                    $arc->_pointA->_x * $arc->_pointB->_y - $arc->_pointB->_x * $arc->_pointA->_y];
        
        /*
         * Solve for the angle between the great circle plane and the equatorial plane
         */
        $numerator = self::dotProduct($vectorA, $vectorB);
        $denominator = self::vecMagnitude($vectorA) * self::vecMagnitude($vectorB);
        
        $angle = acos($numerator / $denominator);
        
        return $angle;
    }
    
    /**
     * Calculate the great circle distance. This formula is a little unreliable for small distances
     * @param GeographicalLine $line
     * @return float
     */
    public static function greatCircleDistance($line) {
        
        /*
         * Convert the angles to radians
         */
        $latA = deg2rad($line->_pointA->_latitude);
        $latB = deg2rad($line->_pointB->_latitude);
        $longA = deg2rad($line->_pointA->_longitude);
        $longB = deg2rad($line->_pointB->_longitude);
                
        /*
         * formula : r * arccos(sin(latitude1)sin(latitude2) + cos(latitude1)cos(latitude2)cos(abs(longitude1 - longitude2)))
         */
        $arcAngle = acos(sin($latA) * sin($latB) + cos($latA) * cos($latB) * cos (abs($longA - $longB)));
        $distance = self::EARTH_RADIUS * $arcAngle;
        
        return $distance;
    }
    
    /**
     * Calculates the great circle distance, using the haversine formula. 
     * @param GeographicalLine $line
     * @return float
     */
    public static function greatCircleDistanceHaversine($line) {
        
        /*
         * Convert the angles to radians
         */
        $latA = deg2rad($line->_pointA->_latitude);
        $latB = deg2rad($line->_pointB->_latitude);
        $longA = deg2rad($line->_pointA->_longitude);
        $longB = deg2rad($line->_pointB->_longitude);
                
        //additional variables to simplify formula
        $halfDiffLong = ($longB - $longA) / 2;
        $halfDiffLat = ($latB - $latA) / 2;
        
        /*
         * formula : 2r * arcsin(sqrt(pow(sin(halfdifflat), 2) + cos(latA) * cos(latB) * pow(sin(halfdifflong), 2)))
         */
        $angle = asin(sqrt(pow(sin($halfDiffLat), 2) + cos($latA) * cos($latB) * pow(sin($halfDiffLong), 2)));
        $distance = 2 * self::EARTH_RADIUS * $angle;
        
        return $distance;
    }
    
    /**
     * Calculates the great circle distance. (This is the most precise method available, even for small distances)
     * @param Geographical $line
     * @return float
     */
    public static function greatCircleDistancePrecise($line) {
        
        /*
         * Convert the angles to radians
         */
        $latA = deg2rad($line->_pointA->_latitude);
        $latB = deg2rad($line->_pointB->_latitude);
        $longA = deg2rad($line->_pointA->_longitude);
        $longB = deg2rad($line->_pointB->_longitude);
        
        /*
         * Apply the formula for the precise distance
         */
        $diffLong = abs($longA - $longB);
        $tempA = cos($latB) * sin($diffLong);
        $tempB = cos($latA) * sin($latB) - sin($latA) * cos($latB) * cos($diffLong);
        
        $numerator = sqrt($tempA * $tempA + $tempB * $tempB);
        $denominator = sin($latA) * sin($latB) + cos($latA) * cos($latB) * cos($diffLong);
        $arcAngle = atan($numerator / $denominator);
        $distance = self::EARTH_RADIUS * $arcAngle;
        
        return $distance;
    }
    
    /**
     * Calculates the angle a great circle arc makes with the center of the earth
     * @param GeographicalLine $line
     * @param float $len
     * @return float
     */
    public static function centralAngle($line, $len) {
        
        if ($line)
            $len = self::greatCircleDistancePrecise($line);
        $angle = $len / self::EARTH_RADIUS;
        
        return $angle;
    }
    
    /**
     * Calculates the coordinates a distance along a great circle line
     * @param GeogrpahicalLine $line
     * @param float $len
     * @param boolean $debug
     * @return float
     */
    public static function lineBreaker($line, $len, $debug) {
        
        $centralAngle = self::centralAngle($line, null);
        $angleA = self::centralAngle(null, $len);
        $angleB = self::centralAngle(null, self::greatCircleDistancePrecise($line) - $len);
        if ($debug)
            print "Angles: " . rad2deg($angleA) . ' + ' . rad2deg($angleB) . ' = ' . rad2deg($centralAngle) . '<br />';
        
        $sphericalPointA = self::geographicalToCartesian($line->_pointA);
        $sphericalPointB = self::geographicalToCartesian($line->_pointB);
        
        if ($debug) {
            
            print '*******************************<br />';
            print '..Coordinate conversion test ..<br />';
            print '*******************************<br />';
            print 'lat ' . $line->_pointA->_latitude . '<br />';
            print 'long ' . $line->_pointA->_longitude . '<br />';
            $lineB = self::cartesianToGeographical($sphericalPointA);
            print 'lat ' . $lineB->_latitude . '<br />';
            print 'long ' . $lineB->_longitude . '<br />';
            print '*******************************<br />';
            print '....    End of test       .....<br />';
            print '*******************************<br />';
        }
        
        $sphericalLine = new SphericalLine($sphericalPointA, $sphericalPointB);
        
        $s = $sphericalLine;
        print $s->_pointA->_x . ', ' . $s->_pointA->_y . ', ' . $s->_pointA->_z . '<br />';
        print $s->_pointB->_x . ', ' . $s->_pointB->_y . ', ' . $s->_pointB->_z . '<br />';
        
        print $sphericalLine->_pointA->_x * $sphericalLine->_pointB->_y . ' == ' . $sphericalLine->_pointB->_x * $sphericalLine->_pointA->_y;
        
        $a = $sphericalLine->_pointA->_y * $sphericalLine->_pointB->_z - $sphericalLine->_pointB->_y * $sphericalLine->_pointA->_z;
        $b = $sphericalLine->_pointB->_x * $sphericalLine->_pointA->_z - $sphericalLine->_pointA->_x * $sphericalLine->_pointB->_z;
        $c = $sphericalLine->_pointA->_x * $sphericalLine->_pointB->_y - $sphericalLine->_pointB->_x * $sphericalLine->_pointA->_y;
        
        if ($debug) {
            
            print '<br />*******************************<br />';
            print '..Cross product test ..<br />';
            print '*******************************<br />';
            print '<'  .$a . ', ' . $b . ', ' . $c . '><br />';
            print rad2deg(asin(sqrt($a * $a + $b * $b + $c * $c))) .  '<br />';
            print '*******************************<br />';
            print '....    End of test       .....<br />';
            print '*******************************<br />';
        }
        
        $a1 = $c * $sphericalLine->_pointA->_x - $a * $sphericalLine->_pointA->_z;
        $b1 = $c * $sphericalLine->_pointA->_y - $b * $sphericalLine->_pointA->_z;
        $c1 = $c * cos($angleA);
        $a2 = $c * $sphericalLine->_pointB->_x - $a * $sphericalLine->_pointB->_z;
        $b2 = $c * $sphericalLine->_pointB->_y - $b * $sphericalLine->_pointB->_z;
        $c2 = $c * cos($angleB);
        
        print '$a1: ' . $a1 . '<br />';
        print '$a2: ' . $a2 . '<br />';
        print '$b1: ' . $b1 . '<br />';
        print '$b2: ' . $b2 . '<br />';
        print $a2 * $b1 . '<br />';
        print $a1 * $b2 . '<br />';
        $y = ($a2 * $c1 - $a1 * $c2) / ($a2 * $b1 - $a1 * $b2);
        $x = ($c1 - $b1 * $y) / $a1;
        $z = (-$a * $x - $b * $y) / $c;
        
        if ($debug) {
            
            print 'Y = ' . $y . '<br />';
            print 'X = ' . $x . '<br />';
            print 'Z = ' . $z . '<br />';
        }
        
        $point = self::cartesianToGeographical(new SphericalPoint($x, $y, $z));
        
        if ($debug) {
            
            print 'lat ' . $point->_latitude . '<br />';
            print 'long ' . $point->_longitude . '<br />';
            print '<br />';
            print '<br />';
            print '***************************************************************************************************************';
        }
        
        return $point;
    }
    
    /**
     * Breaks a LatLng array into a specified distance interval
     * @param array $points
     * @param int $maxLen
     * @param boolean $debug
     * @return array
     */
    public static function significantTravelPoints($points, $maxLen, $debug) {
        
        /*
         *  lineSize variable keeps track of the current size of our line as we traverse points
         *  this is not supposed to exceed maxLen
         */
        $lineSize = 0;
        /*
         * define a new array to hold the new points generated and old points likewise
         * and another array to tell if the points are endPoints of a significant travel
         */
        $arrayRepresentation = array();
        $newPoints = array();
        $endPoint = array();
        
        $pointsSize = count($points);
        for ($i = 0; $i < $pointsSize; $i++) {
            
            array_push($newPoints, new GeographicalPoint($points[$i][0], $points[$i][1]));
            array_push($arrayRepresentation, $points[$i]);
            if (count($newPoints) > count($endPoint)) {
                array_push($endPoint, false);
            }
            
            $nextIndex = ($i + 1) % $pointsSize;
            $pointA = new GeographicalPoint($points[$i][0], $points[$i][1]);
            $pointB = new GeographicalPoint($points[$nextIndex][0], $points[$nextIndex][1]); 
            $len = self::greatCircleDistancePrecise(new GeographicalLine($pointA, $pointB));
            
            if ($debug)
                echo "LENGTH: " . $len . "<br />";
            
            $newPoint = new GeographicalPoint($points[$i][0], $points[$i][1]);
            while (true) {
                
                if ($lineSize + $len > $maxLen + self::DIST_EPSILON) {
                    
                    $rem = $maxLen - $lineSize;
                    $pointA = $newPoint;
                    $pointB = new GeographicalPoint($points[$nextIndex][0], $points[$nextIndex][1]);
                    $line = new GeographicalLine($pointA, $pointB);
                    
                    if ($debug) {
                        print '<pre>';
                        print "len: " . $len . '<br />';
                        print "rem: " . $rem . '<br />';
                        print_r($line);
                        print '</pre>';
                    }
                    $newPoint = self::lineBreaker($line, $rem, $debug);
                    array_push($newPoints, $newPoint);
                    array_push($arrayRepresentation, [$newPoint->_latitude, $newPoint->_longitude]);
                    array_push($endPoint, true);
                    $len -= $rem;
                    $lineSize = 0;
                } else if ($lineSize + $len > $maxLen - self::DIST_EPSILON) {
                    
                    array_push($endPoint, true);
                    $lineSize = 0;
                    break;
                } else {
                    
                    $lineSize += $len;
                    break;
                }
            }
        }
        
        return [$newPoints, $arrayRepresentation, $endPoint];
    }
    
    /**
     * Find the great circle arc bisecting the angle formed by two great circle arcs.
     * @param GeographicalLine $line1
     * @param GeographicalLine $line2
     * @param boolean $debug
     * @return GeographicalPoint
     */
    public static function findBisectorPoint($line1, $line2, $debug) {
        
        $lenC = self::greatCircleDistancePrecise($line1);
        $lenA = self::greatCircleDistancePrecise($line2);
        $lenB = self::greatCircleDistancePrecise(new GeographicalLine($line1->_pointA, $line2->_pointB));
        
        $anglec = self::centralAngle(null, $lenC);
        $anglea = self::centralAngle(null, $lenA);
        $angleb = self::centralAngle(null, $lenB);
        
        $angleA = acos((cos($anglea) - cos($angleb) * cos($anglec)) / (sin($angleb) * sin($anglec)));
        $angle2B = acos((cos($angleb) - cos($anglea) * cos($anglec)) / (sin($anglea) * sin($anglec)));
        $angleB = deg2rad(rad2deg($angle2B) / 2);
        $angleC = acos((cos($anglec) - cos($anglea) * cos($angleb)) / (sin($anglea) * sin($angleb)));
        print 'sines: ' . sin($angleb) * sin($anglec) . '<br />';
        print 'cosines' . (cos($anglea) - (cos($angleb) * cos($anglec))) . '<br />';
        
        /*
         * Hack Starts:
         * This hack ensures the code doesn't break in the case of when we have very small angles
         * and we're dealing with a line as a result instead of a triangle
         */
        if (is_nan($angleA)) {
            $angleA = 0;
        }
        /*
         * Hack ends
         */
        
        if ($debug) {
            print '3 lens ' . $lenC . ' ' . $lenA . ' ' . $lenB . '<br />';
            print 'angles ' . rad2deg($angleA) . ' ' . rad2deg($angle2B) . ' ' . rad2deg($angleC) . '<br />';
        }
        
        $angleC2 = acos(sin($angleA) * sin($angleB) * cos($anglec) - cos($angleA) * cos($angleB));
        
        if ($debug) {
            print 'angle c2 ' . rad2deg($angleC2) . '<br />';
            print 'angle b ' . rad2deg($angleB) . '<br />';
        }
        
        $angleb2 = asin((sin($angleB) * sin($anglec)) / sin($angleC2));
        $lenB2 = self::EARTH_RADIUS * fmod($angleb2 + 2 * pi(), 2 * pi());
        
        if ($debug) {
            print fmod($angleb2 + 2 * pi(), 1) . '<br />';

            print 'line lengths: ' . self::greatCircleDistancePrecise(new GeographicalLine($line1->_pointA, $line2->_pointB)) . ' - ' . $lenB2 . '<br />';
        }
        
        $point = self::linebreaker(new GeographicalLine($line1->_pointA, $line2->_pointB), $lenB2, false);
        
        $lenA2 = new GeographicalLine($line1->_pointB, $point);
        $anglea2 = self::centralAngle($lenA2, $lenA2);
        
        if ($debug) {
            //print 'angle test ' . (sin($angleb2) / sin($angleB)) . ' = ' . (sin($anglec) / sin($angleC2)) . ' = ' . (sin($anglea2) / sin($angleA)) . '<br />';
            print 'rem lengths: ' . self::greatCircleDistancePrecise(new GeographicalLine($line1->_pointA, $point));
            print ' ' . self::greatCircleDistancePrecise(new GeographicalLine($point, $line2->_pointB)) . '<br />';
        }
        
        $bisector = array(
            'point' => $point,
            'half-angle' => $angleB
        );
        
        if ($debug)
            var_dump($bisector);
        return $bisector;
    }
    
    /**
     * Finds the intersections between two great circle
     * @param GeographicalLine $line1
     * @param GeographicalLine $line2
     * @param float $debug
     * @return GeographicalPoint array
     */
    public static function greatCircleIntersection($line1, $line2, $debug) {
        
        $cLine1 = new SphericalLine(self::geographicalToCartesian($line1->_pointA), self::geographicalToCartesian($line1->_pointB));
        $cLine2 = new SphericalLine(self::geographicalToCartesian($line2->_pointA), self::geographicalToCartesian($line2->_pointB));        
        
        if ($debug) {
            var_dump($cLine1);
            var_dump($cLine2);
        }
        $x1 = $cLine1->_pointA->_y * $cLine1->_pointB->_z - $cLine1->_pointB->_y * $cLine1->_pointA->_z;
        $y1 = $cLine1->_pointB->_x * $cLine1->_pointA->_z - $cLine1->_pointA->_x * $cLine1->_pointB->_z;
        $z1 = $cLine1->_pointA->_x * $cLine1->_pointB->_y - $cLine1->_pointB->_x * $cLine1->_pointA->_y;
        $vecA = self::unitVector([$x1, $y1, $z1]);
        
        $x2 = $cLine2->_pointA->_y * $cLine2->_pointB->_z - $cLine2->_pointB->_y * $cLine2->_pointA->_z;
        $y2 = $cLine2->_pointB->_x * $cLine2->_pointA->_z - $cLine2->_pointA->_x * $cLine2->_pointB->_z;
        $z2 = $cLine2->_pointA->_x * $cLine2->_pointB->_y - $cLine2->_pointB->_x * $cLine2->_pointA->_y;
        $vecB = self::unitVector([$x2, $y2, $z2]);
        
        $dx = $vecA[1] * $vecB[2] - $vecB[1] * $vecA[2];
        $dy = $vecB[0] * $vecA[2] - $vecA[0] * $vecB[2];
        $dz = $vecA[0] * $vecB[1] - $vecB[0] * $vecA[1];
        
        if ($debug)
            print $dx . ' ' . $dy . ' ' . $dz . '<br />';
        $mag = self::vecMagnitude([$dx, $dy, $dz]);
        if ($debug)
            print "Magnitude: " . $mag . '<br />';
        $s = self::unitVector([$dx, $dy, $dz]);
        if ($debug) {
            print 'After magnitude: ' . ($s[0] * $s[0] + $s[1] * $s[1] + $s[2] * $s[2]) . '<br />';
            var_dump($s);
        }
        $s2 = [-$s[0], -$s[1], -$s[2]];
        
        $pointA = self::cartesianToGeographical(new SphericalPoint($s[0], $s[1], $s[2]));
        $pointB = self::cartesianToGeographical(new SphericalPoint($s2[0], $s2[1], $s2[2]));
        
        if ($debug) {
            var_dump($s);
            var_dump($pointA, $pointB);
        }
        print deg2rad($pointA->_latitude) . ' ' . deg2rad($pointB->_latitude);
        
        var_dump([$pointA, $pointB]);
        return [$pointA, $pointB];
    }
    
    /**
     * Checks if the great circle instersection is important
     * @param GeographicalPoint array $intersection
     * @param GeographicalLine $line
     * @param float $angle1
     * @param float $angle2
     * @param boolean $debug
     * @return boolean]
     */
    private static function isRealIntersection($intersection, $line, $angle1, $angle2, $debug) {
        
        $lineA = new GeographicalLine($line->_pointA, $intersection);
        $lineB = new GeographicalLine($line->_pointB, $intersection);

        if ($debug) {
            var_dump($line);
            var_dump($lineB);
            var_dump($lineA);
        }
        
        $lenC = self::greatCircleDistancePrecise($line);
        $lenB = self::greatCircleDistancePrecise($lineA);
        $lenA = self::greatCircleDistancePrecise($lineB);
        
        
        $anglec = self::centralAngle($line, -1);
        $angleb = self::centralAngle($lineA, -1);
        $anglea = self::centralAngle($lineB, -1);        
        
        $angleA = acos((cos($anglea) - cos($angleb) * cos($anglec)) / (sin($angleb) * sin($anglec)));
        
        if ($debug) {
            print '<br /><br />' . sin($angleb) / sin($angle2) . ' ' . sin($anglea) / sin($angle1) . '<br />';
            print '<br />' . rad2deg($angleA) . ' cmp ' . rad2deg($angle1) . '<br />';
        }
        if (abs(rad2deg($angleA) - rad2deg($angle1)) > self::DEGREE_EPSILON)
            return false;
        
        $angleB = acos((cos($angleb) - cos($anglea) * cos($anglec)) / (sin($anglea) * sin($anglec)));
        
        if ($debug)
            print rad2deg($angleB) . ' cmp ' . rad2deg($angle2) . '<br />';
        
        if (abs(rad2deg($angleB) - rad2deg($angle2)) > self::DEGREE_EPSILON)
            return false;
        
        return true;
    }
    
    /**
     * Calculates the distance of a point on the earth's surface from the endpoints of a great circle arc
     * @param GeographicalLine $arc
     * @param GeographicalPoint $point
     * @return float
     */
    private static function distanceFromArcEndpoints($arc, $point) {
        
        $lenA = self::greatCircleDistancePrecise(new GeographicalLine($point, $arc->_pointA));
        $lenB = self::greatCircleDistancePrecise(new GeographicalLine($point, $arc->_pointB));
        
        var_dump($point);
        print "Len " . $lenA + $lenB . '<br />';
        return $lenA + $lenB;
    }
    
    /**
     * This finds the real corresponding position of the trolley's coordinates on the great circle arc
     * @param GeographicalPoint array $projections
     * @param GeographicalLine  $line
     * @return boolean
     */
    private static function findRealProjectionOnArc($projections, $line) {
        
        $arcLen = self::greatCircleDistancePrecise($line);
        print "Arc Length: " . $arcLen;
        if (abs($arcLen - self::distanceFromArcEndpoints($line, $projections[0])) < self::DIST_EPSILON)
                return $projections[0];
        if (abs($arcLen - self::distanceFromArcEndpoints($line, $projections[1])) < self::DIST_EPSILON)
                return $projections[1];
        
        return false;
    }
    
    /**
     * Finds which Great circle intersection is needed
     * @param GeographicalPoint array $intersections
     * @param GeographicalLine $line
     * @param float $angle1
     * @param float $angle2
     * @param boolean $debug
     * @return GeographicalPoint
     */
    private static function realIntersection($intersections, $line, $angle1, $angle2, $debug) {
        
        if ($debug) {
            var_dump($intersections[0]);
            var_dump($intersections[1]);
            var_dump($line);
        }
        if (self::isRealIntersection($intersections[0], $line, $angle1, $angle2, $debug))
            return $intersections[0];
        
        if (self::isRealIntersection($intersections[1], $line, $angle1, $angle2, $debug))
            return $intersections[1];
        
        return null;
    }
    
    /**
     * Finds the projections of a trolley point on a great circle
     * @param GeographicalLine $line1
     * @param GeographicalLine $line2
     * @param GeographicalLine $line3
     * @param boolean $debug
     * @return GeographicalPoint Array
     */
    public static function projection($line1, $line2, $line3, $debug) {
        
        $bisectorAInfo = self::findBisectorPoint($line1, $line2, $debug);
        $bisectorBInfo = self::findBisectorPoint($line2, $line3, $debug);
        $bisectorA = new GeographicalLine($line1->_pointB, $bisectorAInfo['point']);
        $bisectorB = new GeographicalLine($line2->_pointB, $bisectorBInfo['point']);
        
        $intersections = self::greatCircleIntersection($bisectorA, $bisectorB, $debug);
        
        print '<br /><br />Angles: ' . rad2deg($bisectorAInfo['half-angle']) . ' ' . rad2deg($bisectorBInfo['half-angle']) . '<br />';
        return self::realIntersection($intersections, $line2, $bisectorAInfo['half-angle'], $bisectorBInfo['half-angle'], $debug);
    }
    
    /**
     * Finds the projection of a trolley position on a great circle arc
     * @param int $index - index of line in array
     * @param GeographicalPoint $point
     * @param GeographicalLine array $lineArray
     * @param float $debug
     * @return GeographicalPoint
     */
    public static function positionOnLine($index, $point, $lineArray, $debug) {
        
        $line1 = $lineArray[($index - 1) % count($lineArray)];
        $line2 = $lineArray[$index];
        $line3 = $lineArray[($index + 1) % count($lineArray)];
        
        $projectionPoint =  self::projection($line1, $line2, $line3, $debug);
        $projectionsOnLine = self::greatCircleIntersection($line2, new GeographicalLine($projectionPoint, $point), $debug);
        $projectionOnLine = self::findRealProjectionOnArc($projectionsOnLine, $line2);
        
        return $projectionOnLine;
    }
    
    /**
     * Test suite for great circle intersection
     */
    public static function testIntersection() {
        $vA = self::unitVector([-2, 3, 2]);
        $vB = self::unitVector([3, -2, 2]);
        $vC = self::unitVector([-2, 3, 2]);
        $vD = self::unitVector([-2, 2, 3]);
        $lineA = new GeographicalLine(self::cartesianToGeographical(new SphericalPoint($vA[0], $vA[1], $vA[2])),
                                      self::cartesianToGeographical(new SphericalPoint($vB[0], $vB[1], $vB[2])));
        $lineB = new GeographicalLine(self::cartesianToGeographical(new SphericalPoint($vC[0], $vC[1], $vC[2])),
                                      self::cartesianToGeographical(new SphericalPoint($vD[0], $vD[1], $vD[2])));
        
        var_dump($lineA);
        var_dump($lineB);
        self::greatCircleIntersection($lineA, $lineB);
    }
}