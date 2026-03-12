
<?php
//商品一覧
session_start();
  $pageTitle = '商品一覧';
  require_once 'includes/db.php';
  require_once 'includes/header.php'; ?>
  <?php require 'includes/pankuzu.php'; ?>
<li>商品一覧</li>
</ul>
</nav>
  <?php require 'includes/username.php'; 
  require_once 'includes/drawer.php';
  ?>

<main>
<div class="innerBody">
    <section class="productsSec"><!--列整列はgridで操作-->
        <h1 class="sectionTitle">
           <span> 商品一覧</span>
        </h1>
        <h2 class="menuTitle">
            メインメニュー
        </h2>

        <!--index.htmlから移植して改造
        ?= ? は「HTML中」で使う。省略echoは HTMLに値を埋め込むための記法
        echoの文字列の中では使わない-->
        <ol class="productsList"><!--PHP化するかもしれない想定  article 単位で foreachにしたい-->
                    <!---ここからPHPをはじめる。<?  ?>-->
<?php foreach ($pdo->query('SELECT * FROM products LIMIT 6') as $row): ?>
            <li>
                <article class="productDetail">

                    <p class="productDetailImg">
                    <a href="product.php?id=<?= (int)$row['id'] ?>">
                        <img class="productImg"
                        src="images/productImage<?= $row['id'] ?>.png"
                        alt="<?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>">
                    </a>
                    </p>

                    <div class="productDetailBody">
                        <h3 class="productName">
                            <?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p class="productPrice">
                            税込 ￥<?= number_format($row['price']) ?>
                        </p>

                        <!-- カート追加：処理ページにPOST -->
                       <form action="cartAdd.php" method="post">
                        <input type="hidden" name="productId" value="<?= $row['id'] ?>">
                        
                        <button type="submit">カートに入れる</button>
                        </form>
                    </div>

                </article>
            </li>
<?php endforeach; ?>
                    <!---ここまでPHP-->
        </ol>
        
        <h2 class="menuTitle">
            バラエティセット
        </h2>

        <ol class="productsList"><!--PHP化するかもしれない想定  article 単位で foreachにしたい-->
                    <!---ここからPHPをはじめる。-->
<?php foreach ($pdo->query('SELECT * FROM products LIMIT 6 OFFSET 6') as $row): ?>
            <li>
                <article class="productDetail">

                    <p class="productDetailImg">
                       <a href="product.php?id=<?= (int)$row['id'] ?>"><img class="productImg"
                            src="images/productImage<?= $row['id'] ?>.png"
                            alt="<?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>">
                        </a>
                    </p>

                    <div class="productDetailBody">
                        <h3 class="productName">
                            <?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p class="productPrice">
                            税込 ￥<?= number_format($row['price']) ?>
                        </p>

                        <!-- カート追加：処理ページにPOST -->
                        <form action="cartUpdate.php" method="post">
                            <input type="hidden" name="productId" value="<?= $row['id'] ?>">
                            <button type="submit">カートに入れる</button>
                        </form>
                    </div>

                </article>
            </li>
<?php endforeach; ?> <!---ここまでPHP-->
        </ol>
    </section>
</div>
</main>
<?php require_once 'includes/footer.php'; ?>
    

