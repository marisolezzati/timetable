<?php

$conexion = array('HOST'=>'localhost','USERNAME'=>'root','PASSWORD'=>'','DBNAME'=>'timetable');
$db = new mysqli($conexion['HOST'], $conexion['USERNAME'], $conexion['PASSWORD'], $conexion['DBNAME']);
$sql = 'SELECT * FROM timetable WHERE from=1 ';
$resultado = $db->query($sql);
while($r = $resultado->fetch_array(MYSQLI_BOTH)){
	$timetable[] = $r;
}
$resultado->free();

$dias=array('Lun','Ma','Mi','Ju','Vie','Sa','Do','Fer');
echo '<table>';
foreach($timetable as $h){
	echo '<tr>';
	$nocircula = '';
	for($i=5;$i<13;$i++){
		$nocircula .= (!$h[$i])? $dias[$i-5].', ':'';
	}
	echo '<td>'.$h['departure'].'</td>';
	echo '<td>'.$h['arrival'].'</td>';
	echo '<td>'.$h['company'].'</td>';
	echo '<td>'.$h['type'].'</td>';
	echo '<td>'.$nocircula.'</td>';
	echo '</tr>';
}
echo '</table>';
?>