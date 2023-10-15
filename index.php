<?php

$conexion = array('HOST'=>'localhost','USERNAME'=>'root','PASSWORD'=>'','DBNAME'=>'timetable');
$db = new mysqli($conexion['HOST'], $conexion['USERNAME'], $conexion['PASSWORD'], $conexion['DBNAME']);
/**
*Create table if not exists
*/
$ins = 'CREATE TABLE IF NOT EXISTS `timetable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(11) NOT NULL,
  `to` varchar(11) NOT NULL,
  `departure` time NOT NULL,
  `arrival` time NOT NULL,
  `Monday` boolean DEFAULT true,
  `Tuesday` boolean DEFAULT true,
  `Wednesday` boolean DEFAULT true,
  `Thusday` boolean DEFAULT true,
  `Friday` boolean DEFAULT true,
  `Saturday` boolean DEFAULT true,
  `Sunday` boolean DEFAULT true,
  `Holidays` boolean DEFAULT true,
  `type` varchar(11) NOT NULL,
  `company` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;';

$resultado = $db->query($ins);
/**
*Clear old data
*/
$resultado = $db->query('DELETE FROM `timetable`;');
/**
*Gets the time table information from the bus web page for Route 1 (in this case is a file for demo proproses)
*/
$html = file_get_contents('file:///C:/wamp64/www/timetable/rosario.html');
$fromros = getdata($html);
$fromros = array_slice($fromros, 4);
/**
*Process the information and insert it
*/
foreach($fromros as $h){
	$dias = '';
	for($i=3;$i<11;$i++){
		$dias .= ($h[$i]=='O')? ',true':',false';
	}
		
	$ins = 'INSERT INTO `timetable` (`from`, `to`, `departure`, `arrival`, `Monday`, `Tuesday`, `Wednesday`, `Thusday`, `Friday`, `Saturday`, 
							`Sunday`, `Holidays`, `type`, `company`) 
							VALUES (2,1,"'.$h[0].'","'.$h[1].'"'.$dias.',"'.$h[11].'","'.$h[2].'")';
	$resultado = $db->query($ins);
}
/**
*Gets the time table information from the bus web page for Route 2 (in this case is a file for demo proproses)
*/
$html = file_get_contents('file:///C:/wamp64/www/timetable/carcarana.html');
$fromros = getdata($html);
$fromros = array_slice($fromros, 4);
/**
*Process the information and insert it
*/
foreach($fromros as $h){
	$dias = '';
	for($i=3;$i<11;$i++){
		$dias .= ($h[$i]=='O')? ',true':',false';
	}
		
	$ins = 'INSERT INTO `timetable` (`from`, `to`, `departure`, `arrival`, `Monday`, `Tuesday`, `Wednesday`, `Thusday`, `Friday`, `Saturday`, 
							`Sunday`, `Holidays`, `type`, `company`) 
							VALUES (1,2,"'.$h[0].'","'.$h[1].'"'.$dias.',"'.$h[11].'","'.$h[2].'")';
	$resultado = $db->query($ins);
}

function getdata($contents)
{
    $DOM = new DOMDocument;
    $DOM->loadHTML($contents);

    $items = $DOM->getElementsByTagName('tr');

    foreach ($items as $node)
    {
        $arr[] = tdrows($node->childNodes);
    }
	return $arr;
}

function tdrows($elements)
{
	$str = array();
	foreach ($elements as $element)
	{
		if(ltrim($element->nodeValue)!='')
			$str[]= $element->nodeValue;
	}
	return $str;
}
?>