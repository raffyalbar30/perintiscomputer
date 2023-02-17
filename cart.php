<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Jumlah keranjang belanja anda telah diperbarui';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/style.css">

  <!-- clear confirm form resubmission -->
  <script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
  </script>

  <!-- google analytics -->
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-PXX7TGT9XK"></script>
  <script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-PXX7TGT9XK');
  </script>

  <!-- google tag -->
  <!-- Google Tag Manager -->
  <script>
  (function(w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({
      'gtm.start': new Date().getTime(),
      event: 'gtm.js'
    });
    var f = d.getElementsByTagName(s)[0],
      j = d.createElement(s),
      dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src =
      'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
  })(window, document, 'script', 'dataLayer', 'GTM-W8ZMTQK');
  </script>
  <!-- End Google Tag Manager -->

</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8ZMTQK" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <?php include 'components/user_header.php'; ?>

  <section class="products shopping-cart">

    <h1 class="heading"><span>Keranjang Belanja</span></h1>

    <div class="box-container">

      <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
      <form action="" method="post" class="box">
        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
        <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
        <div class="name"><?= $fetch_cart['name']; ?></div>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div class="flex">
          <div class="price-before" style="text-decoration: line-through;"> Rp
            <span><?= number_format($fetch_cart['price_before']) ; ?></span>,-
          </div>
          <div class="price">Rp <?= number_format($fetch_cart['price']) ; ?>,-
          </div>

        </div>
        <div class="flex">

          <div class="quality">
            <h3>QTY : </h3>
            <input type="number" name="qty" class="qty" min="1" max="99"
              onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">

          </div>
          <button type="submit" class="fas fa-edit" name="update_qty"></button>
        </div>
        <div class="sub-total"> sub total :
          <span>Rp
            <?= number_format($sub_total = ( $fetch_cart['price']  * $fetch_cart['quantity'] )) ; ?>,-</span>
        </div>
        <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn"
          name="delete">
      </form>
      <?php
   $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty">Keranjang anda kosong</p>';
   }
   ?>
    </div>

    <div class="cart-total">
      <p>Total Biaya : <span>Rp <?= number_format($grand_total) ; ?>,-</span></p>
      <a href="shop.php" class="option-btn">Lanjut Belanja</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>"
        onclick="return confirm('delete all from cart?');">Hapus Semua Barang</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Lanjut Pembayaran</a>
    </div>

  </section>













  <?php include 'components/footer.php'; ?>

  <script src="js/script.js"></script>

</body>

</html>