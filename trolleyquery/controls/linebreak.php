<?php

/**
 * Test suite for the linebreak
 */
$arr = [[28.06279,-80.623032], //PDH Stop, Going North
		[28.06397,-80.622993], //Panther PL & University
                [28.063987,-80.62205],
                [28.06395,-80.6214],
                [28.063928,-80.619944],/*
		[28.063086,-80.619949],
		[28.06307,-80.620331],*/
                        
                /* start of commons */
                [28.063926,-80.619932],
                [28.063086,-80.619949],
                [28.06307,-80.620331],
                [28.062929,-80.620522],
                [28.06287,-80.621147],
                [28.06356,-80.62114],
                [28.06356,-80.62114],
                [28.063841,-80.621132],
                [28.063841,-80.619934],
                [28.06406,-80.619926],
                /* commons ends */
                
                /* University Blvd */
                [28.06408,-80.62103],
                [28.0640799,-80.62104],
                /*University Blvd ends */
                
                /* S Babcock St */
                [28.0640799,-80.621294],
                [28.07075,-80.621213],
                [28.07197,-80.621224],
                /* S Babcock St ends */
                
                /*Nathan Bisk */
                [28.07498,-80.62129],
                [28.07498,-80.62197],
                [28.07649,-80.62197],
                [28.07649,-80.62159],
                [28.07495,-80.6214],
                /* Nathan Bisk ends */
                
                /*S Babcock return */
                [28.07231,-80.62135],
                [28.07185,-80.621335],
                [28.0695,-80.62135],
                [28.06201,-80.62145],
                [28.061918,-80.62202],
                /*S Babcock ends */
                
                /*Panther Pl */
                [28.061884,-80.62215],
                [28.06192,-80.62233],
                [28.06198,-80.62284],
                [28.06204,-80.623036],
                [28.06279,-80.623032]

];
$maxDist = 100;
//echo '<pre>';
//$significantPoints = Algorithm::significantTravelPoints($arr, $maxDist, true);
//$arrSize = count($significantPoints[1]);
//
//for ($i = 0; $i < $arrSize; $i++) {
//    
//    print '[' . $significantPoints[1][$i][0] . ', ' . $significantPoints[1][$i][1] . ']' . ($i < $arrSize - 1 ? ',' : '') . '<br />';
//}
//var_dump($significantPoints);
//echo '</pre>';

$result = Algorithm::positionOnLine(1, new GeographicalPoint(28.0643, -80.6201),
                                [new GeographicalLine(new GeographicalPoint(28.065, -80.62114), new GeographicalPoint(28.065, -80.6205)),
                                 new GeographicalLine(new GeographicalPoint(28.065, -80.6205), new GeographicalPoint(28.065, -80.6198)),
                                 new GeographicalLine(new GeographicalPoint(28.065, -80.6198), new GeographicalPoint(28.065, -80.619))],
                                true);

var_dump($result);

//$lineA = Algorithm::testIntersection();