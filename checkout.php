<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address =  $_POST['street'] .',  '.$_POST['flat'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Pesanan anda berhasil diproses!';
   }else{
      $message[] = 'keranjang belanja anda kosong';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>

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

  <section class="checkout-orders">

    <form action="" method="POST">

      <h3>Pesanan Anda</h3>

      <div class="display-orders">
        <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
        <p> <?= $fetch_cart['name']; ?>
          <span>(<?= 'Rp '. number_format($fetch_cart['price']) .',- x '. $fetch_cart['quantity']; ?>)</span>
        </p>
        <?php
            }
         }else{
            echo '<p class="empty">Keranjang anda kosong!</p>';
         }
      ?>
        <input type="hidden" name="total_products" value="<?= $total_products; ?>">
        <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
        <div class="grand-total">total biaya : <span>Rp <?= number_format($grand_total) ; ?>,-</span></div>
      </div>

      <h3>Informasi Pengiriman</h3>

      <div class="flex">
        <div class="inputBox">
          <span>nama :</span>
          <input type="text" name="name" placeholder="" class="box" maxlength="20" required>
        </div>
        <div class="inputBox">
          <span>nomor hp :</span>
          <input type="number" name="number" placeholder="" class="box" min="0" max="9999999999"
            onkeypress="if(this.value.length == 10) return false;" required>
        </div>
        <div class="inputBox">
          <span>email :</span>
          <input type="email" name="email" placeholder="" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>metode pembayaran :</span>
          <select name="method" class="box" required>
            <option value="cash on delivery">cash on delivery</option>
            <option value="credit card">credit card</option>
            <option value="paytm">paytm</option>
            <option value="paypal">paypal</option>
          </select>
        </div>
        <div class="inputBox">
          <span>Alamat :</span>
          <input type="text" name="street" placeholder="" class="box" maxlength="500" required>
        </div>
        <div class="inputBox">
          <span>Kecamatan :</span>
          <input type="text" name="flat" placeholder="" class="box" maxlength="50" required>
        </div>

        <div class="inputBox">
          <span>kota / kabupaten :</span>
          <input type="text" name="city" placeholder="" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>provinsi :</span>
          <input type="text" name="state" placeholder="" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>negara :</span>
          <input type="text" name="country" placeholder="" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>kode pos :</span>
          <input type="number" min="0" name="pin_code" placeholder="" min="0" max="999999"
            onkeypress="if(this.value.length == 6) return false;" class="box" required>
        </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Checkout Pesanan">

    </form>

  </section>













  <?php include 'components/footer.php'; ?>

  <script src="js/script.js"></script>

</body>

</html>