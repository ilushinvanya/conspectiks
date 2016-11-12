<?

$query = "SELECT id_type AS typeId,
type.title AS typeName,
work.title AS workName,
info,
id_teachers AS teacherId,
teachers.title AS teacherName,
id_users AS userId,
users.name AS userName,
users.byname AS userByname,
date
FROM work
JOIN type ON work.id_type = type.id
JOIN teachers ON work.id_teachers = teachers.id
JOIN users ON work.id_users = users.id WHERE work.id=" . $work_id;

$result = mysql_query($query);
if (!$result) die ('Сбой при доступе к базе данных: ' . mysql_error());

$row = mysql_fetch_assoc($result);

$type = $row['typeName'];
$teacherId = $row['teacherId'];
$teacherName = $row['teacherName'];
$userId = $row['userId'];
$userName = $row['userName'];
$userByname = $row['userByname'];
$date = $row['date'];
$info = $row['info'];
?>


<body>
<div class="wrapper work_wrap">
	<aside>
		<div class="block">
			<h2>Комментарии</h2>
			<hr/>
			<div class="comments_list">
				<? echo getComments($work_id); ?>
			</div>

		</div>
	</aside>
	<section>
		<div class="block">
			<div class="table_text"><? require_once 'php/bread.php'; ?></div>
		</div>
		<div class="wrap_table block">
		<div class="title">
			<h2><? echo $row['workName']; ?></h2>

			<div class="pullright js_date"><? echo $date ?></div>
			<div class="pullright likes_wrap"><? getLikes($work_id); ?></div>
		</div>
		<hr/>
		<div class="table_text">
			<p>
				<span>Тип: </span><span><? echo $type; ?></span>
			</p>
			<p>
				<span>Препод: </span>
				<a href="/?teacher=<? echo $teacherId; ?>"><? echo $teacherName; ?></a>
			</p>
			<p><span>Автор: </span>
				<a href="/?profile=<? echo $userId; ?>"><? echo $userName . ' ' . $userByname; ?></a>
			</p>
			<p>
				<span>Описание: </span>
				<span class="descr_work"><? echo $info; ?></span>
			</p>
		</div>
		<hr/>
		<div class="media_list">
			<? echo getMedia($work_id); ?>
		</div>
	</div>
	</section>
</div>

<? include 'php/scripts.php'; ?>
<script src="js/function.js"></script>
<script src="js/work.js"></script>
</body>
</html>