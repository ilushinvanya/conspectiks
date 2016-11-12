<?php

$where = '';
$tolink = '';
if( isset($univer_id) ) {
	$where .= " WHERE predmet.vk_id_universities=".$univer_id;
	$tolink .= 'univer='.$univer_id;
	if( isset($kurs_id) ) {
		$where .= " AND kurs=".$kurs_id;
	}
}else if( isset($fac_id) ) {
	$where .= " WHERE predmet.vk_id_faculties=".$fac_id;
	$tolink .= 'fac='.$fac_id;
	if( isset($kurs_id) ) {
		$where .= " AND kurs=".$kurs_id;
	}
}else if( isset($chair_id) )  {
	$where .= " WHERE predmet.vk_id_chairs=".$chair_id;
	$tolink .= 'chair='.$chair_id;
	if( isset($kurs_id) ) {
		$where .= " AND kurs=".$kurs_id;
	}
}else if(isset($kurs_id)) {
	$where = " WHERE kurs = ".$kurs_id;
};



$query = "SELECT predmet.id AS idPredmet,
predmet.title AS titlePredmet,
last_time, 
kurs, 
chairs.title AS titleChairs,
faculties.title AS titleFaculties,
universities.title AS titleUniversities,
predmet.vk_id_chairs AS idChairs,
predmet.vk_id_faculties AS idFaculties,
predmet.vk_id_universities AS idUniversities
FROM predmet
JOIN chairs ON predmet.vk_id_chairs = chairs.vk_id
JOIN faculties ON predmet.vk_id_faculties = faculties.vk_id
JOIN universities ON predmet.vk_id_universities = universities.vk_id".$where;


$result = mysql_query($query);
if(!$result) die ('Сбой при доступе к базе данных: '. mysql_error());

$rows = array( 'data' => array() );
while($r = mysql_fetch_assoc($result)) {

	$query1 = "SELECT COUNT(*) AS works FROM work WHERE id_predmet = ".$r['idPredmet'];
	$result1 = mysql_query($query1);
	$r1 = mysql_fetch_assoc($result1);
	$r['works'] = $r1['works'];


	echo "<tr>";
	echo "<td><a href='/?predmet=".$r['idPredmet']."'>".$r['titlePredmet']."</a></td>";

	echo "<td><a href='/?univer=".$r['idUniversities']."'>".$r['titleUniversities']."</a></td>";
	echo "<td><a href='/?fac=".$r['idFaculties']."'>".$r['titleFaculties']."</a></td>";
	echo "<td><a href='/?chair=".$r['idChairs']."'>".$r['titleChairs']."</a></td>";
	echo "<td><a href='/?".$tolink."&kurs=".$r['kurs']."'>".$r['kurs']."</a></td>";

	echo "<td>".$r['works']."</td>";
	echo "<td class='js_date' data-order=''>".$r['last_time']."</td>";

	echo "</tr>";
}
