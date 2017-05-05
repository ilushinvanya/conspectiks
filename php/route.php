<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 01.05.2017
 * Time: 23:55
 */

if ( isset($_POST['faculty_id']) ){
    if( isset( $_POST['year'] ) ){
        header( 'Location: http://conspectiks.ru/?fac='.$_POST['faculty_id'].'&kurs='.$_POST['year'] );
    }else{
        header( 'Location: http://conspectiks.ru/?fac='.$_POST['faculty_id'] );
    }
}else if( isset( $_POST['university_id'] ) ){
    if( isset( $_POST['year'] ) ){
        header( 'Location: http://conspectiks.ru/?univer='.$_POST['university_id'].'&kurs='.$_POST['year'] );
    }else{
        header( 'Location: http://conspectiks.ru/?univer='.$_POST['university_id'] );
    }
}else if ( isset( $_POST['city_id'] ) ) {
//    header( 'Location: http://conspectiks.ru/start' );
}

