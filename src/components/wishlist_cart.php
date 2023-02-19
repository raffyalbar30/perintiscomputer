<?php

if(isset($_POST['add_to_wishlist'])){

   if($user_id == ''){
      header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price_before = $_POST['price-before'];
      $price_before = filter_var($price_before, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);

      $check_wishlist_numbers = $ModelWishlist->getTableArray("name = " . $name . " AND user_id = " . $user_id);
      $check_cart_numbers = $ModelCart->getTableArray("name = " . $name . " AND user_id = " . $user_id);

      if(sizeof($check_wishlist_numbers) > 0){
         $message[] = 'already added to wishlist!';
      }elseif(sizeof($check_cart_numbers) > 0){
         $message[] = 'already added to cart!';
      }else{
         $ModelWishlist->addTableColumn("(user_id, pid, name, price_before, price, image) VALUES(" . $user_id . ", " . $pid . ", " . $name . ", " . $price_before . ", " . $price . ", " . $image . ")");

         $message[] = 'added to wishlist!';
      }

   }

}

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price_before = $_POST['price-before'];
      $price_before = filter_var($price_before, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $ModelCart->getTableArray("name = " . $name . " AND user_id = " . $user_id);

      if(sizeof($check_cart_numbers) > 0){
         $message[] = 'already added to cart!';
      }else{

         $check_wishlist_numbers = $ModelWishlist->getTableArray("name = " . $name . " AND user_id = " . $user_id);

         if(sizeof($check_wishlist_numbers) > 0){
            $ModelWishlist->deleteTableColumn("name = " . $name . " AND user_id = " . $user_id);
         }

         $ModelCart->addTableColumn("(user_id, pid, name, price_before, price, quantity, image) VALUES(" . $user_id . ", " . $pid . ", " . $name . ", " . $price_before . ", " . $price . ", " . $qty . ", " . $image . ")");
         $message[] = 'added to cart!';
         
      }

   }

}

?>