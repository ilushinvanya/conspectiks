<?

?>
<body>
<div class="wrapper main_wrap">
    <aside>
        <div class="block">
            <h2>Учащиеся</h2>
            <hr/>
            <div class="user_list">
                <?
                if (isset($univer_id)) {
                    if (isset($kurs_id)) {
                        echo user_list('vk_id_universities', $univer_id, $kurs_id);
                    } else {
                        echo user_list('vk_id_universities', $univer_id, null);
                    }
                } else if (isset($fac_id)) {
                    if (isset($kurs_id)) {
                        echo user_list('vk_id_faculties', $fac_id, $kurs_id);
                    } else {
                        echo user_list('vk_id_faculties', $fac_id, null);
                    }
                } else if (isset($chair_id)) {
                    if (isset($kurs_id)) {
                        echo user_list('vk_id_chairs', $chair_id, $kurs_id);
                    } else {
                        echo user_list('vk_id_chairs', $chair_id, null);
                    }
                }
                ?>
            </div>
        </div>
    </aside>
    <section>
        <div class="block">
            <div class="table_text"><? require_once 'php/bread.php'; ?></div>
        </div>
        <div class="wrap_table block">
            <div class="title">
                <h2>Список предметов</h2>
            </div>
            <hr>
            <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Универ</th>
                    <th>Факультет</th>
                    <th>Кафедра</th>
                    <th>Курс</th>
                    <th>Работ</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody><? include 'php/predmet_list.php'; ?></tbody>
            </table>
        </div>
    </section>
</div>
<? include 'php/scripts.php'; ?>
<script src="js/predmet_list.js"></script>
<script src="js/function.js"></script>
</body>
</html>