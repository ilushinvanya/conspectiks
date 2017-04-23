<?php
require_once 'php/logindb.php';
require_once 'php/function.php';

$userId = 1;

$userFac = getItem('users', $userId,8);
$userChair = getItem('users', $userId,9);
$userKurs = getItem('users', $userId,10);

if($userChair != null){
	$urray = array('chair'=>$userChair,
	    		'kurs'=>$userKurs);
}else{
	$urray = array('fac'=>$userFac,
	    		'kurs'=>$userKurs);
};

$univer_id = $_GET['univer'];
$fac_id = $_GET['fac'];
$chair_id = $_GET['chair'];
$kurs_id = $_GET['kurs'];

$predmet_id = $_GET['predmet'];
$folder_id = $_GET['folder'];
$work_id = $_GET['work'];

$profile_id = $_GET['profile'];
$teacher_id = $_GET['teacher'];

include 'php/head.php';
include 'php/header.php';

if (isset($predmet_id)) {
	include 'predmet.php';
}
else if (isset($work_id)) {
	include 'work.php';
}
else if (isset($folder_id)) {
	include 'folder.php';
}
else if (isset($teacher_id)) {
	include 'teacher.php';
}
else if (isset($profile_id)) {
	include 'profile.php';
}else if ( isset( $univer_id ) || isset( $fac_id ) || isset( $chair_id ) || isset( $kurs_id ) ){
	include 'main.php';
}else{
//	header( 'Location: http://conspectiks.ru/?'.http_build_query($urray) );
	header( 'Location: http://conspectiks.ru/start' );
}