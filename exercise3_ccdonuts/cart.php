<?php
//カートページ
session_start();
$pageTitle = 'カート';
require_once 'includes/db.php';
require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>
<li>カート</li>
</ul>
</nav>
<?php
require 'includes/username.php';
require_once 'includes/drawer.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cartItemCount = 0;
foreach ($cart as $numberOfPieces) { $cartItemCount += (int)$numberOfPieces; }//intで整数にしておく

$productRows = [];
$total = 0;

if (!empty($cart)) {
  $cartItemIds = array_keys($cart);
  $productPlaceholders = implode(',', array_fill(0, count($cartItemIds), '?'));

  $sql = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($productPlaceholders)");
  $sql->execute($cartItemIds);
  $dbRows = $sql->fetchAll();

  // id=>row にして cart順に並べる
  $productsByDbId = [];
  foreach ($dbRows as $product) $productsByDbId[(int)$product['id']] = $product;

  foreach ($cartItemIds as $id) {
    if (!isset($productsByDbId[$id])) continue;
    $matchedProduct = $productsByDbId[$id];
    $numberOfPieces = (int)$cart[$id];
    $subTotal = (int)$matchedProduct['price'] * $numberOfPieces;
    $total += $subTotal;

    $productRows[] = [
      'id' => (int)$matchedProduct['id'],
      'name' => $matchedProduct['name'],
      'price' => (int)$matchedProduct['price'],
      'numberOfPieces' => $numberOfPieces,
      'sub' => $subTotal,
    ];
  }
}

// 購入確認先（未実装はtest.phpへ）
$checkoutUrl = 'test.php'; 
?>


<main>
  <div class="innerBody">
    <section class="cartSec">
  
      <!-- 注文小計1 -->
      <div class="cartSummary">
        <p>現在　商品<?= $cartItemCount ?>点<br>
        ご注文小計：税込<span class="price"> ￥<?= number_format($total) ?></span>
        </p>
        <p>
          <a class="toCheckoutBtn" href="<?= htmlspecialchars($checkoutUrl, ENT_QUOTES, 'UTF-8') ?>">
            購入確認へ進む
          </a>
        </p>
      </div>

      <?php if (empty($productRows)): ?>
        <p>カートは空です。</p>
      <?php else: ?>

        <!-- カート内の商品 -->
        

        <?php foreach ($productRows as $matchedProduct): ?>
        
        <article class="cartDetail"><!--productDetail的役割-->
          <p class="cartDetailImg">
                <img class="productImg"
                  src="images/productImage<?= $matchedProduct['id'] ?>.png">
          </p>
          
          <div class="cartItemBody">
            <h3 class="cartItemName">
              <?= htmlspecialchars($matchedProduct['name'], ENT_QUOTES, 'UTF-8') ?>
            </h3>

            <div class="cartCountWrapper">
            <p class="cartPrice">
              税込　￥<?= number_format($matchedProduct['price']) ?>
            </p>

              <!-- 再計算（数量更新） -->
              <form class="cartCountForm" action="cartUpdate.php" method="post">
                <input type="hidden" name="productId" value="<?= $matchedProduct['id'] ?>">
                <!-- セレクトボックス（1〜10想定） -->
                <p>
                <span>数量</span>
                <select class="cartCount" name="count">
                  <?php for ($i = 1; $i <= 10; $i++): ?>
                    <option value="<?= $i ?>" <?= ($i === $matchedProduct['numberOfPieces']) ? 'selected' : '' ?>>
                      <?= $i ?>
                    </option>
                  <?php endfor; ?>
                </select>
                <span>個</span>
                  </p>
                  <!--再計算のボタン-->
                <button type="submit" class="cartUpdateBtn">再計算</button>
              </form>
            </div>
              <!-- 削除（文字リンク処理ページにフォーム送信） -->
              <form class="cartRemoveForm" action="cartRemove.php" method="post" >
                <input type="hidden" name="productId" value="<?= $matchedProduct['id'] ?>">
                <button class="cartRemoveLink" type="submit" >削除する</button>
              </form>
            

          </div>
        </article>

        <?php endforeach; ?>

      <?php endif; ?>

      <!-- 注文小計2 -->
      <div class="cartSummary">
        <p>現在　商品<?= $cartItemCount ?>点<br>
          ご注文小計：税込<span class="price"> ￥<?= number_format($total) ?></span>
        </p>

        <p>
          <a class="toCheckoutBtn" href="<?= htmlspecialchars($checkoutUrl, ENT_QUOTES, 'UTF-8') ?>">
            購入確認へ進む
          </a>
        </p>
      </div>

        <p>
          <a class="backToProducts" href="products.php">買い物を続ける</a>
        </p>
    </section>
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>




