<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist</title>

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

  <section class="products">

    <h1 class="heading"><span> Wishlist </span></h1>

    <div class="box-container">

      <?php
      $grand_total = 0;
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            $grand_total += $fetch_wishlist['price'];  
   ?>
      <form action="" method="post" class="box">
        <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
        <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
        <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
        <input type="hidden" name="price-before" value="<?= $fetch_product['price_before']; ?>">
        <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
        <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
        <input type="hidden" name="qty" value="1">
        <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
        <div class="name"><?= $fetch_wishlist['name']; ?></div>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div class="flex">
          <div class="price-before"><span>Rp
            </span><?= number_format($fetch_wishlist['price_before']) ; ?><span>,-</span></div>
          <div class="price">Rp <?= number_format($fetch_wishlist['price']) ; ?>/-</div>
          <!-- <input type="number" name="qty" class="qty" min="1" max="99"
            onkeypress="if(this.value.length == 2) return false;" value="1"> -->
        </div>
        <input type="submit" value="Tambah ke Keranjang" class="btn" name="add_to_cart">
        <input type="submit" value="Hapus Barang" onclick="return confirm('Hapus barang ini dari wishlist?');"
          class="delete-btn" name="delete">
      </form>
      <?php
      }
   }else{
      echo '<p class="empty">Tidak ada barang di wishlist</p>';
   }
   ?>
    </div>

    <div class="wishlist-total">
      <p>Total Biaya : <span>Rp <?= number_format($grand_total) ; ?>,-</span></p>
      <a href="shop.php" class="option-btn">Lanjut Belanja</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>"
        onclick="return confirm('Hapus semua barang dari wishlist?');">Hapus Semua</a>
    </div>

  </section>













  <?php include 'components/footer.php'; ?>

  <script src="js/script.js"></script>

</body>

</html>