<?

?>


<body>
<div class="wrapper main_wrap teacher_wrap">
    <aside>
        <div class="block">
            <h2>Комментарии</h2>
            <hr/>
            <div class="comments_list">
                <? echo getComments(1); ?>
            </div>
        </div>
    </aside>
    <section>
        <div class="block">
            <div class="table_text">
                <h2><? echo getItem('teachers', $teacher_id, 1); ?></h2>
                <hr/>
                <? require_once 'php/bread.php'; ?></div>
        </div>
        <div class="wrap_table block">
            <div class="title">
                <h2>Список работ</h2>
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
                <tbody>
                <? include 'php/work_list.php'; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
    var $hiddenColumn = [3];
    var $orderColumn =  [6, 'desc']; //по дате
</script>
<? include 'php/scripts.php'; ?>
<script src="js/function.js"></script>
</body>
</html>