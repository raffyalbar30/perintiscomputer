<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

  <section class="flex">
    <div id="menu-btn" class="fas fa-bars"></div>

    <a href="home.php" class="logo"><i class="fa-solid fa-dragon"></i> PERINTIS COMPUTER<span>.</span></a>

    <nav class="navbar">
      <a href="home.php">home</a>
      <a href="shop.php">shop</a>
      <a href="orders.php">orders</a>
      <a href="contact.php">contact</a>
      <a href="about.php">about</a>
      <div class="wish">
        <a href="wishlist.php">wishlist</a>
      </div>
      <div class="wish">
        <a href="cart.php">cart</a>
      </div>
      <div class="wish">
        <a href="update_user.php">profile</a>
      </div>
    </nav>

    <div class="icons">
      <?php
            $total_wishlist_counts = sizeof($ModelWishlist->getTableArray("user_id = " . $user_id));
            $total_cart_counts = sizeof($ModelCart->getTableArray("user_id = " . $user_id));
         ?>

      <a href="search_page.php"><i class="fas fa-search"></i></a>
      <a id="w" href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
      <a id="w" href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
      <div id="user-btn" class="fas fa-user"></div>
    </div>

    <div class="profile">
      <?php          
            if(sizeof($ModelUsers->getTableColumn("id = " . $user_id)) > 0){
              $fetch_profile = $ModelUsers->getTableColumn("id = " . $user_id);
         ?>
      <img src="../src/images/profil.png" alt="">
      <p><?= $fetch_profile["name"]; ?></p>
      <a href="update_user.php" class="btn">update profil</a>
      <a href="src/components/user_logout.php" class="delete-btn"
        onclick="return confirm('logout from the website?');">Keluar</a>
      <?php
            }else{
         ?>
      <p>Silahkan masuk terlebih dahulu..!</p>
      <div class="flex-btn">
        <a href="user_register.php" class="option-btn">Daftar</a>
        <a href="user_login.php" class="option-btn">Masuk</a>
      </div>
      <?php
            }
         ?>


    </div>

  </section>

</header>