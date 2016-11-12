<?
function getVkItem($db, $id, $item)
{
    $query = "SELECT * FROM " . $db . " WHERE vk_id=" . $id;

    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

    $row = mysql_fetch_row($result);

    return $row[$item];
};
function getItem($db, $id, $item)
{
    $query = "SELECT * FROM " . $db . " WHERE id=" . $id;

    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

    $row = mysql_fetch_row($result);

    return $row[$item];
};


function profile_card($uid) {
    $query = "SELECT * FROM users WHERE id=" . $uid;

    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

    $row = mysql_fetch_assoc($result);


    $response = '';

    if ($row['boss'] == 1) {
        $bossHtml = '<span class="boss">Староста</span>';
    } else {
        $bossHtml = '';
    }

    $response .= '<div class="block ava_wrap"><img src="' . $row['ava'] . '"/></div>';

    $response .= '<div class="block">
					<div class="profile_text">
						<h2><a href="/?profile=' . $row['id'] . '">' . $row['name'] . ' ' . $row['byname'] . '</a></h2>' .
        $bossHtml;
    $response .= '<hr/><div class="table_text">';
    $response .= '<p><span>Универ:</span> <a href="/?univer=' . $row['vk_id_universities'] . '">' . getVkItem('universities', $row['vk_id_universities'], 1) . "</a></p>";
    $response .= '<p><span>Факультет:</span> <a href="/?fac=' . $row['vk_id_faculties'] . '">' . getVkItem('faculties', $row['vk_id_faculties'], 1) . "</a></p>";
    if ($row['vk_id_chairs'] != null) {
        $response .= '<p><span>Кафедра:</span> <a href="/?chair=' . $row['vk_id_chairs'] . '">' . getVkItem('chairs', $row['vk_id_chairs'], 1) . "</a></p>";
        $response .= '<p><span>Курс:</span> <a href="/?chair=' . $row['vk_id_chairs'] . '&kurs=' . $row['kurs'] . '">' . $row['kurs'] . "</a></p></div></div>";
    } else {
        $response .= '<p><span>Курс:</span> <a href="/?fac=' . $row['vk_id_faculties'] . '&kurs=' . $row['kurs'] . '">' . $row['kurs'] . "</a></p></div></div>";
    }
    $response .= '</div>';


    return $response;
}


function user_list($value, $key, $kurs)
{
    if ($kurs == null) {
        $query = "SELECT * FROM users WHERE " . $value . "=" . $key;
    } else {
        $query = "SELECT * FROM users WHERE " . $value . "=" . $key . " AND kurs=" . $kurs;
    }
    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());


    $response = '';

    while ($r = mysql_fetch_assoc($result)) {
        $name = $r['byname'];
        $ava = $r['ava'];
        $id = $r['id'];
        $response .= '<div class="user"><a href="/?profile=' . $id . '" class="ava"><img src="' . $ava . '"></a><p><a href="/?profile=' . $id . '">' . $name . '</a></div>';
    }

    return $response;
}

function getMedia($id)
{
    $query = "SELECT * FROM media WHERE id_work=" . $id . " ORDER BY indx";


    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());


    $response = '';
    while ($r = mysql_fetch_assoc($result)) {
        $url = $r['url'];
        $indx = $r['indx'];
        $descr = $r['descr'];
        $response .= '<a href="' . $url . '" data-sub-html="' . $descr . '"><img src="' . $url . '" data-index="' . $indx . '"></a>';
    }
    return $response;
}



function getComments($id) {
    $query = "SELECT * FROM comments WHERE id_work=" . $id;

    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

    $response = '';
    $num = mysql_num_rows($result);

    if( $num == 0 ){
        $response .= '<div class="nocomments">Комментариев еще пока ни одного</div>';
    }
    while ($r = mysql_fetch_assoc($result)) {
        $authorClass = '';
        $text = $r['text'];
        $userId = $r['id_users'];
        $userName = getItem('users', $userId, 2);
        $userAva = getItem('users', $userId, 11);
        $author = getItem('work', $id, 6);

        if ($userId == $author) {
            $authorClass = ' autor';
        }
        $response .= '<div class="comment_item' . $authorClass . '">';
        $response .= '<div class="user">';
        $response .= '<a href="/?profile=' . $userId . '" class="ava">';
        $response .= '<img src="' . $userAva . '">';
        $response .= '</a>';
        $response .= '<p><a href="/?profile='.$userId.'">' . $userName . '</a></p>';
        $response .= '</div>';
        $response .= '<div class="content">';
        $response .= '<p>' . $text . '</p>';
        $response .= '</div>';
        $response .= '</div>';
    }




    return $response;
}

function getLikes($id){

    $query = "SELECT likes.id_users AS userId,
  users.byname AS userByname,
  users.ava AS userAva
  FROM likes JOIN users ON likes.id_users = users.id WHERE id_work=" . $id;

    $result = mysql_query($query);
    if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

    $response = '';
    $num = mysql_num_rows($result);

    if( $num == 0 ){
        $response .= '<div class="nocomments">Комментариев еще пока ни одного</div>';
    }
    $view = '<div class="total">'.$num.'</div>';
    $view .= '<div class="people">';
    while ($r = mysql_fetch_assoc($result)) {
        $view .= '<div class="user">';
        $view .= '<a href="/?profile=' . $r['userId'] . '" class="ava">';
        $view .= '<img src="'.$r['userAva'].'"/>';
        $view .= '</a>';
        $view .= '<p><a href="/?profile='.$r['userId'].'">'.$r['userByname'].'</a></p>';
        $view .= '</div>';
    }
    $view .= '</div>';




    echo $view;
}