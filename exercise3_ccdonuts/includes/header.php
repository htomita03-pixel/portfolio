<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="common/reset.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet">

  <title>
    <?php
      $siteName = 'C.C.Donuts';
      echo $siteName;
      if (!empty($pageTitle)) {
        echo '｜' . htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
      }//$pageTitleにはTOP以外の各ページのタイトルが代入されて、ページごとの指定内容が読み込まれる。
    ?>
  </title>
</head>

<body>
<header>
  <div class="headerUpper">
    <button type="button" id="drawerOpenId" class="drawerOpenBtn" aria-label="メニューを開く">
      <img src="images/openIcon.svg" alt="">
    </button>

    <h1 class="pageRogo">
      <a href="index.php">
        <img src="images/mainRogo.svg" alt="C.C.Donutsショップメインロゴ">
      </a>
    </h1>

    <nav class="headerNav">
      <ul class="headerList">
        <li>
          <a href="login.php">
            <img src="images/loginIcon.svg" alt="ログインアイコン">
            <span class="headerBtn">ログイン</span>
          </a>
        </li>
        <li>
          <a href="cart.php">
            <img src="images/cartIcon.svg" alt="カートアイコン">
            <span class="headerBtn">カート</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <div class="headerLower">
    <form class="searchItem" action="#" method="get">
      <button type="submit"><img src="images/kensakuIcon.svg" alt="商品検索用アイコン"></button>
      <input class="textBox" type="text" name="keyword">
    </form>
  </div>
</header>


