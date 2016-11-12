<?
if (isset($univer_id)) {
    $query = "SELECT
universities.vk_id AS univerId,
universities.title AS univerName
FROM universities
WHERE universities.vk_id=" . $univer_id;
}

if (isset($fac_id)) {
    $query = "SELECT
faculties.vk_id AS facId,
faculties.title AS facName,
faculties.vk_id_universities AS univerId,
universities.title AS univerName
FROM faculties
JOIN universities ON faculties.vk_id_universities = universities.vk_id WHERE faculties.vk_id=" . $fac_id;
}

if (isset($chair_id)) {
    $query = "SELECT chairs.vk_id AS chairId,
chairs.title AS chairName,
chairs.vk_id_faculties AS facId,
faculties.title AS facName,
faculties.vk_id_universities AS univerId,
universities.title AS univerName
FROM chairs
JOIN faculties ON chairs.vk_id_faculties = faculties.vk_id
JOIN universities ON faculties.vk_id_universities = universities.vk_id WHERE chairs.vk_id=" . $chair_id;
}

if (isset($predmet_id)) {
    $query = "SELECT chairs.vk_id AS chairId,
chairs.title AS chairName,
chairs.vk_id_faculties AS facId,
faculties.title AS facName,
faculties.vk_id_universities AS univerId,
universities.title AS univerName,
predmet.id AS predmetId,
predmet.title AS predmetName,
kurs
FROM predmet
JOIN chairs ON predmet.vk_id_chairs = chairs.vk_id
JOIN faculties ON predmet.vk_id_faculties = faculties.vk_id
JOIN universities ON predmet.vk_id_universities = universities.vk_id WHERE predmet.id=" . $predmet_id;
}

if (isset($folder_id)) {
    $query = "SELECT chairs.vk_id AS chairId,
chairs.title AS chairName,
chairs.vk_id_faculties AS facId,
faculties.title AS facName,
faculties.vk_id_universities AS univerId,
universities.title AS univerName,
predmet.id AS predmetId,
predmet.title AS predmetName,
folder.id AS folderId,
folder.title AS folderName,
kurs
FROM folder
JOIN predmet ON folder.id_predmet = predmet.id
JOIN chairs ON predmet.vk_id_chairs = chairs.vk_id
JOIN faculties ON predmet.vk_id_faculties = faculties.vk_id
JOIN universities ON predmet.vk_id_universities = universities.vk_id WHERE folder.id=" . $folder_id;;
}

if (isset($work_id)) {
    $query = "SELECT chairs.vk_id AS chairId,
chairs.title AS chairName,
chairs.vk_id_faculties AS facId,
faculties.title AS facName,
faculties.vk_id_universities AS univerId,
universities.title AS univerName,
predmet.id AS predmetId,
predmet.title AS predmetName,
predmet.kurs AS kurs,
work.title AS workName,
work.id AS workId,
IFNULL(work.id_folder, 0) AS folderId,
IFNULL(folder.title, 0) AS folderName
FROM work
LEFT JOIN folder ON work.id_folder = folder.id
JOIN predmet ON work.id_predmet = predmet.id
JOIN chairs ON predmet.vk_id_chairs = chairs.vk_id
JOIN faculties ON predmet.vk_id_faculties = faculties.vk_id
JOIN universities ON predmet.vk_id_universities = universities.vk_id WHERE work.id=" . $work_id;
}

if (isset($teacher_id)) {
    $query = "SELECT teachers.vk_id_chairs AS chairId,
teachers.vk_id_universities AS univerId,
chairs.title AS chairName,
universities.title AS univerName
FROM teachers
JOIN chairs ON teachers.vk_id_chairs = chairs.vk_id
JOIN universities ON teachers.vk_id_universities = universities.vk_id WHERE teachers.id=" . $teacher_id;
}

if( isset($kurs_id) ) echo breadView($query, $kurs_id);
else echo breadView($query, null);

function breadView($query, $kurs_id) {
    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

    $bread = '';
    while ($r = mysql_fetch_assoc($result)) {
        if ($r['univerId'] != null AND $r['univerName'] != null) {
            $bread .= '<p>';
            $bread .= '<span>Универ: </span><a href="?univer=' . $r['univerId'] . '">' . $r['univerName'] . '</a>';
            $bread .= '</p>';
        }

        if ($r['facId'] != null AND $r['facName'] != null) {
            $bread .= '<p>';
            $bread .= '<span>Факультет: </span><a href="?fac=' . $r['facId'] . '">' . $r['facName'] . '</a>';
            $bread .= '</p>';
        }

        if (isset($r['chairId']) AND isset($r['chairName'])) {
            $bread .= '<p>';
            $bread .= '<span>Кафедра: </span><a href="?chair=' . $r['chairId'] . '">' . $r['chairName'] . '</a>';
            $bread .= '</p>';
        }
        if (isset($kurs_id) || isset($r['kurs'])) {
            $bread .= '<p>';
            if (isset($kurs_id)) $kurs = $kurs_id;
            else if (isset($r['kurs'])) $kurs = $r['kurs'];

            if (isset($r['chairId'])){
                $bread .= '<span>Курс: </span><a href="?chair='.$r['chairId'].'&kurs=' . $kurs . '">' . $kurs . '</a>';
            }else if ($r['facId'] != null) {
                $bread .= '<span>Курс: </span><a href="?fac='.$r['facId'].'&kurs=' . $kurs . '">' . $kurs . '</a>';
            }
            $bread .= '</p>';
        }

        if ($r['predmetId'] != null AND $r['predmetName'] != null) {
            $bread .= '<hr/>';
            $bread .= '<p>';
            $bread .= '<span>Предмет: </span><a href="?predmet=' . $r['predmetId'] . '">' . $r['predmetName'] . '</a>';
            $bread .= '</p>';
        }

        if ($r['folderId'] != null AND $r['folderName'] != null AND $r['folderId'] != 0) {
            $bread .= '<p>';
            $bread .= '<span>Папка: </span><a href="?folder=' . $r['folderId'] . '">' . $r['folderName'] . '</a>';
            $bread .= '</p>';
        }

        if ($r['workId'] != null AND $r['workName'] != null) {
            $bread .= '<p>';
            $bread .= '<span>Работа: </span><a href="?work=' . $r['workId'] . '">' . $r['workName'] . '</a>';
            $bread .= '</p>';
        }
    }

    return $bread;
}