<?php

$where = '';
if (isset($predmet_id)) {
    $where .= " WHERE work.id_predmet=" . $predmet_id;
//	показывать с иерархией папок, как в файловом менеджере
    $mode = 'predmet';
}
if (isset($folder_id)) {
    $where .= " WHERE work.id_folder=" . $folder_id;
//	показывать с иерархией папок, как в файловом менеджере
    $mode = 'folder';
}

if (isset($profile_id)) {
    $where .= " WHERE work.id_users=" . $profile_id;
//	показывать весь путь до работы в одной ячейке
    $mode = 'profile';
}
if (isset($teacher_id)) {
    $where .= " WHERE work.id_teachers=" . $teacher_id;
    //	показывать весь путь до работы в одной ячейке
    $mode = 'profile';
}


$query = "SELECT work.id AS idWork,
work.title AS titleWork, 
type.title AS titleType,
id_type,
info,
work.id_predmet AS idPredmet,
predmet.title AS titlePredmet,
teachers.title AS titleTeacher,
id_teachers,
users.name AS nameUser,
users.byname AS bynameUser,
work.id_users AS idUser,
IFNULL(id_folder,0) AS idFolder,
date
FROM work JOIN type ON work.id_type = type.id
JOIN predmet ON work.id_predmet = predmet.id
JOIN teachers ON work.id_teachers = teachers.id
JOIN users ON work.id_users = users.id" . $where;


$result = mysql_query($query);
if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

$rows = array();
while ($r = mysql_fetch_assoc($result)) {

    $query1 = "SELECT COUNT(*) AS media FROM media WHERE id_work=" . $r['idWork'];
    $result1 = mysql_query($query1);
    if (!$result1) die ('Сбой при доступе к базе данных: ' . mysql_error());
    $r1 = mysql_fetch_assoc($result1);
    $r['media'] = $r1['media'];


    $query2 = "SELECT COUNT(*) AS likes FROM likes WHERE id_work=" . $r['idWork'];
    $result2 = mysql_query($query2);
    if (!$result2) die ('Сбой при доступе к базе данных: ' . mysql_error());
    $r2 = mysql_fetch_assoc($result2);
    $r['likes'] = $r2['likes'];

    $r['nameUser'] = $r['nameUser'] . ' ' . $r['bynameUser'];
    $rows[] = $r;

}


$folderArray = array();
for ($i = 0; $i < count($rows); $i++) {
    if($mode == 'predmet') {
        echo renderPredmetList($rows[$i]);
    }
    if($mode == 'profile') {
        echo renderProfileList($rows[$i]);
    }
    if($mode == 'folder') {
        echo renderFolderList($rows[$i]);
    }
};


function renderPredmetList($row) {
    $view = '';

    if ($row['idFolder'] != 0 && !in_array($row['idFolder'], $GLOBALS['$folderArray'])) {
        $count = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS count FROM work WHERE id_folder='.$row["idFolder"]));

        $view .= "<tr>";
        $view .= "<td><a href='/?predmet=" . $row['idPredmet'] . "'>" . $row['titlePredmet'] . "</a></td>";
        $view .= "<td><i class='glyphicon glyphicon-folder-open'></i>&nbsp;&nbsp;<a href='/?folder=" . $row['idFolder'] . "'>" . getItem('folder', $row['idFolder'], 1) . "</a></td>";
        $view .= "<td></td>";

        $view .= "<td></td>";
        $view .= "<td><a href='/?teacher=" . $row['id_teachers'] . "'>" . $row['titleTeacher'] . "</a></td>";
        $view .= "<td class='js_files'>". $count['count'] ."</td>";
        $view .= "<td></td>";
        $view .= "<td class='js_date'>" . $row['date'] . "</td>";
        $view .= "</tr>";

        $GLOBALS['$folderArray'][] = $row['idFolder'];
        return $view;
    } else if (in_array($row['idFolder'], $GLOBALS['$folderArray'])) {

    } else {
        $view .= "<tr>";
        $view .= "<td><a href='/?predmet=" . $row['idPredmet'] . "'>" . $row['titlePredmet'] . "</a></td>";
        $view .= "<td><i class='glyphicon glyphicon-file'></i>&nbsp;&nbsp;<a href='/?work=" . $row['idWork'] . "'>" . $row['titleWork'] . "</a></td>";
        $view .= "<td>" . $row['titleType'] . "</td>";

        $view .= "<td><a href='/?profile=" . $row['idUser'] . "'>" . $row['nameUser'] . "</a></td>";
        $view .= "<td><a href='/?teacher=" . $row['id_teachers'] . "'>" . $row['titleTeacher'] . "</a></td>";
        $view .= "<td>" . $row['media'] . "</td>";
        $view .= "<td>" . $row['likes'] . "</td>";
        $view .= "<td class='js_date'>" . $row['date'] . "</td>";
        $view .= "</tr>";

        return $view;
    }

}
function renderProfileList($row) {
    $view = '';

    $view .= "<tr>";
    $view .= "<td>";
    $view .= "<a href='/?predmet=" . $row['idPredmet'] . "'>" . $row['titlePredmet'] . "</a> / ";
    if ( $row['idFolder'] != 0 ) {
        $view .= "<a href='/?folder=" . $row['idFolder'] . "'>" . getItem('folder', $row['idFolder'], 1) . "</a> / ";
    }
    $view .= "<a href='/?work=" . $row['idWork'] . "'>" . $row['titleWork'] . "</a>";
    $view .=  "</td>";

    $view .= "<td>" . $row['titleType'] . "</td>";
    $view .= "<td><a href='/?profile=" . $row['idUser'] . "'>" . $row['nameUser'] . "</a></td>";
    $view .= "<td><a href='/?teacher=" . $row['id_teachers'] . "'>" . $row['titleTeacher'] . "</a></td>";
    $view .= "<td>" . $row['media'] . "</td>";
    $view .= "<td>" . $row['likes'] . "</td>";
    $view .= "<td class='js_date'>" . $row['date'] . "</td>";
    $view .= "</tr>";

    return $view;
}
function renderFolderList($row) {
    $view = '';

    $view .= "<tr>";
    $view .= "<td>";
    $view .= "<a href='/?work=" . $row['idWork'] . "'>" . $row['titleWork'] . "</a>";
    $view .=  "</td>";

    $view .= "<td>" . $row['titleType'] . "</td>";
    $view .= "<td><a href='/?profile=" . $row['idUser'] . "'>" . $row['nameUser'] . "</a></td>";
    $view .= "<td><a href='/?teacher=" . $row['id_teachers'] . "'>" . $row['titleTeacher'] . "</a></td>";
    $view .= "<td>" . $row['media'] . "</td>";
    $view .= "<td>" . $row['likes'] . "</td>";
    $view .= "<td class='js_date'>" . $row['date'] . "</td>";
    $view .= "</tr>";

    return $view;
}
