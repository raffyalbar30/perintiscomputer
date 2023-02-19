<?php

include 'src/components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'src/components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="src/css/style.css">

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

  

  <div class="home-bg">

    <section class="home">

      <div class="swiper home-slider">

        <div class="swiper-wrapper">

          <div class="swiper-slide slide">
            <div class="image">
              <img src="lib/images/home-img-1.png" alt="">
            </div>
            <div class="content">
              <span>Diskon hingga 30%</span>
              <h3>Smartphone Edisi Terbaru</h3>
              <a href="shop.php" class="btn">Belanja</a>
            </div>
          </div>

          <div class="swiper-slide slide">
            <div class="image">
              <img src="lib/images/elektronik.png" alt="">
            </div>
            <div class="content">
              <span>Tersedia berbagai elektronik</span>
              <h3>dan menerima service computer dan laptop</h3>
              <a href="shop.php" class="btn">Belanja</a>
            </div>
          </div>

          <div class="swiper-slide slide">
            <div class="image">
              <img src="lib/images/laptop1.png" alt="">
            </div>
            <div class="content">
              <span>Diskon Hingga 50%</span>
              <h3>Laptop Gaming Terbaru</h3>
              <a href="shop.php" class="btn">Belanja</a>
            </div>
          </div>

        </div>

        <div class="swiper-pagination"></div>

      </div>


    </section>

  </div>

  
  <section class="products">

    <h1 class="heading"><span>Produk Terbaru</span></h1>

    <div class="box-container">

      <?php
      if($ModelProducts->tableRow > 0){
        $ModelProducts->getTableFetch();
        for ($i = 0; $i < 8; $i++) {
          $fetch_product = $ModelProducts->tableArray[$i];
      ?>
      <form action="" method="post" class="box">
        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
        <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
        <input type="hidden" name="price-before" value="<?= $fetch_product['price_before']; ?>">
        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
        <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
        <input type="hidden" name="qty" value="1">
        <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
        <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
        <img src="lib/images/product/<?= $fetch_product['image_01']; ?>" alt="">
        <div class="name"><?= $fetch_product['name']; ?></div>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div class="flex">
          <div class="price-before"><span>Rp
            </span><?= number_format($fetch_product['price_before']) ; ?><span>,-</span></div>
          <div class="price"><span>Rp </span><?= number_format($fetch_product['price']) ; ?><span>,-</span></div>
          <!-- <input type="number" name="qty" class="qty" min="1" max="99"
            onkeypress="if(this.value.length == 2) return false;" value="1"> -->
        </div>
        <input type="submit" value="Tambah ke Keranjang" class="btn" name="add_to_cart">
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">Tidak ada barang!</p>';
      }
      ?>

    </div>

    <div class="load-more" style=" margin-top: 2rem;">
      <a href="shop.php" class="option-btn">Lihat Semua</a>
    </div>

  </section>

  <section class="deal" id="deal">
    <h1 class="heading"><span>Penawaran Terbaik</span></h1>

    <div class="icons-container">
      <div class="icons">
        <i class="fas fa-shipping-fast"></i>
        <h3>Pengiriman Cepat</h3>
        <p>Pengiriman dilakukan di hari yang sama setelah barang dicheckout</p>
      </div>

      <div class="icons">
        <i class="fas fa-user-clock"></i>
        <h3>Pelayanan 24 Jam</h3>
        <p>Melayani customer selama 24 jam non stop</p>
      </div>

      <div class="icons">
        <i class="fas fa-money-check-alt"></i>
        <h3>Pembayaran Mudah</h3>
        <p>Didukung pembayaran antar bank dan berbagai macam e-wallet</p>
      </div>

      <div class="icons">
        <i class="fas fa-box"></i>
        <h3>Garansi Pengembalian</h3>
        <p>Garansi 10 hari setelah barang tiba. Syarat dan ketentuan berlaku</p>
      </div>
    </div>
  </section>


  <section class="home-contact">
    <div class="content">
      <h3>Ada Pertanyaan?</h3>
      <p>
        Silahkan tulis pertanyaan maupun masukan anda pada halaman Contact agar website kami dapat berkembang menjadi
        lebih
        baik dalam melayani customer
      </p>
      <a href="contact.php" class="btn">Hubungi Kami</a>
    </div>
  </section>



  <?php include 'src/components/footer.php'; ?>

  <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

  <script src="src/js/script.js"></script>

  <script>
  var swiper = new Swiper(".home-slider", {
    loop: true,
    spaceBetween: 20,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });

  var swiper = new Swiper(".category-slider", {
    loop: false,
    spaceBetween: 20,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 2,
      },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 6,
      },
    },
  });

  // var swiper = new Swiper(".products-slider", {
  //   loop: true,
  //   spaceBetween: 20,
  //   pagination: {
  //     el: ".swiper-pagination",
  //     clickable: true,
  //   },
  //   breakpoints: {
  //     550: {
  //       slidesPerView: 2,
  //     },
  //     768: {
  //       slidesPerView: 2,
  //     },
  //     1024: {
  //       slidesPerView: 3,
  //     },
  //   },
  // });
  </script>



</body>

</html>