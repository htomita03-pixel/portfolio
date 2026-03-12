<?php
//TOPページ
session_start();

$pageTitle = ''; // TOPはサイト名のみなので空

require_once 'includes/db.php';

// ▼ ランキング表示用：商品を取得（例：上位6件） id の昇順にしている
$sql = $pdo->query('SELECT * FROM products LIMIT 6');/*ランキングにするなら ORDER BY score DESC LIMIT 6(今回はDB項目自体がないので機能しない）*/
$products = $sql->fetchAll();   // すべてのDBの行を読み込み対象のもの
$rank = 1;

require_once 'includes/header.php';
require_once 'includes/username.php';
require_once 'includes/drawer.php';
?>


<main>
  <section class="heroSec">
    <img class="spOnly" src="images/spHero.png" alt="メイン画像">
    <img class="pcOnly" src="images/pcHero.png" alt="メイン画像">
  </section>

  <div class="innerBody">
    <section class="infoSec">
      <ul>
        <li class="infoSecLi list01">
          <p class="pinkCircle">新商品</p>
          <span class="infoCaption01">サマーシトラス</span>
        </li>

        <li class="infoSecLi list02">
          <span class="infoCaption02">ドーナツのある生活</span>
        </li>

        <li class="infoSecLi list03">
          <a class="bunnerLink" href="products.php">
            <span class="infoCaption03">商品一覧</span>
          </a>
        </li>
      </ul>
    </section>
  </div>

  <section class="philosophySec">
    <div class="philosophyText01">
      <h3>Philosophy</h3>
      <p>私たちの信念</p>
    </div>
    <div class="philosophyText02">
      <p>"Creating Connections"</p>
      <p><span>「ドーナツでつながる」</span></p>
    </div>
  </section>

  <div class="innerBody">
    <section class="rankSec">
      <h2 class="sectionTitle"><span>人気ランキング</span></h2><!--今回はランキングではなくDBを上から読み込み６番目まで。-->

      <ol class="rankList">
        <?php foreach ($products as $row): ?>
          <li>
            <article class="rankArticle productDetail">
              <p class="rankNumber"><?= $rank ?></p>

              <p>
                <a href="product.php?id=<?= (int)$row['id'] ?>">
                  <img
                    src="images/productImage<?= (int)$row['id'] ?>.png"
                    alt="<?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>">
                </a>
              </p>

              <h3 class="productName">
                <?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>
              </h3>

              <p class="price productPrice">税込 ￥<?= number_format((int)$row['price']) ?></p>

              <form action="cartAdd.php" method="post">
                <input type="hidden" name="productId" value="<?= (int)$row['id'] ?>">
                <button type="submit">カートに入れる</button>
              </form>
            </article>
          </li>
        <?php $rank++; endforeach; ?>
      </ol>
    </section>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
