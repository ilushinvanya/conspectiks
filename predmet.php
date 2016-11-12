<?

?>


<body>
<div class="wrapper main_wrap">
    <aside>
        <div class="block">
            <h2>Авторы</h2>
            <hr>
            <div class="user_list">
                <? echo user_list('vk_id_universities', 65, null); ?>
            </div>
        </div>
    </aside>
    <section>
        <div class="block">
            <div class="table_text"><? require_once 'php/bread.php'; ?></div>
        </div>
        <div class="wrap_table block">
            <div class="title">
                <h2>Список работ</h2>
            </div>
            <hr>
            <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Предмет</th>
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
<? include 'php/scripts.php'; ?>
<script>
    var $hiddenColumn = [0];
    var $orderColumn =  [ 2, 'asc' ];
</script>
<script src="js/function.js"></script>

</body>

</html>