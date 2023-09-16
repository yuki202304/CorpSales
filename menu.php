<header class="page-header">
        <?php
        //ログイン状態
        if(isset($_SESSION['login'])) { ?>
                <nav>
                        <ul class="header-menu">
                                <li><h1><a href="index.php"><img class="logo opacity" src="img/icon.svg" alt="ロゴ"></a>CorpSales<span>/コープセールス</span></h1></li>
                                <li><a id="list" href="history.php">企業一覧</a></li>
                                <li><a id="list" href="company.php">企業登録</a></li>
                                <li><a id="list" href="customer.php">担当者登録</a></li>
                                <li><a id="list" href="opportunity.php">案件登録</a></li>
                                <li><a id="list" href="report.php">行動登録</a></li>
                                <li><a id="list" href="logout-input.php">ログアウト</a></li>
                        </ul>
                </nav>
                <?php
        //ログイン未状態                
        } else { ?>
                <nav>
                        <ul class="header-menu">
                                <li><h1><a href="index.php"><img class="logo opacity" src="img/icon3.svg" alt="ロゴ"></a>CorpSales<span>/コープセールス</span></h1></li>
                                　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　
                                <li><a id="list" href="login-input.php">ログイン</a></li>
                        </ul>
                </nav>
                <?php
        } ?>
        
</header>
        <main>