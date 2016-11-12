<? ?>
<header>
    <div class="wrapper">
        <div id="navbar" class="navbar-collapse collapse">
            <div class="navbar-header">
                <a href="/" class="navbar-brand">Дай списать</a>
            </div>
            <ul class="nav navbar-nav ng-hide">
                <li>
                    <a href="/?profile=<? echo $userId; ?>"><? echo getItem('users', $userId, 1) . ' ' .getItem('users', $userId, 2); ?></a>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li><a href="/teachers.php">Преподы (скоро)</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="">
                        <i class="fa fa-sign-out"></i> Выход
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>