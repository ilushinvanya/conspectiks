<?

?>

<body>
<div class="wrapper main_wrap">
    <aside>
        <div class="block">
            <h2>Коллеги</h2>
            <hr>
            <div class="user_list">
                <?
                $chairId = getItem('users', $profile_id, 9);

                if ($chairId == null) {
                    $chairId = getItem('users', $profile_id, 8);
                    $field = 'vk_id_faculties';
                } else {
                    $field = 'vk_id_chairs';
                }
                $kursId = getItem('users', $profile_id, 10);
                echo user_list($field, $chairId, $kursId); ?>
            </div>
        </div>
    </aside>
    <section>
        <div class="profile_block">
            <? echo profile_card($profile_id); ?>
        </div>
        <div class="wrap_table block">
            <div class="title">
                <h2>Список моих работ</h2>
            </div>
            <hr>
            <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Автор</th>
                    <th>Препод</th>
                    <th>Файлы</th>
                    <th>Лайки</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody><? include 'php/work_list.php'; ?></tbody>
            </table>
        </div>
    </section>
</div>



<script>
    var $hiddenColumn = [2];
    var $orderColumn =  [ 6, 'desc' ]; //по дате
</script>
<? include 'php/scripts.php'; ?>
<script src="js/function.js"></script>
</body>
</html>