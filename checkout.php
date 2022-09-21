<?php
session_start();
require_once('php/link.php');
$_SESSION['product_final_quantity'] = 0;
$_SESSION['product_per_price'] = 0;
$_SESSION['product_final_price'] = 0;
$_SESSION['product_final_tax'] = 0;

//  echo $_SESSION['shipping_charge'].'<br>';
//  echo $_SESSION['net_product_amount'];
//  echo $arc;
/* -------------------------------product count check start------------------------------ */
$cart_item = "";
if (!empty($_COOKIE['item'])) {
  $cart_item .= count($_COOKIE['item']);
}
/* -------------------------------product count check end------------------------------ */
/* -------------------------------wish count check start------------------------------ */
$wishcart_item = "";
if (!empty($_COOKIE['wishitem'])) {
  $wishcart_item .= count($_COOKIE['wishitem']);
}
/* -------------------------------wish count check end------------------------------ */
/* ------------------------------ delete start ------------------------------ */
$d_cookie = "";
if (!empty($_COOKIE['wishitem']) && is_array($_COOKIE['wishitem'])) {
  foreach ($_COOKIE['wishitem'] as $name1 => $value) {
    if (isset($_POST["delete2$name1"])) {
      $d_cookie .= setcookie("wishitem[$name1]", "", time() - (86400 * 30), "/");
      // header("Refresh:0");            
      $page = $_SERVER['PHP_SELF'];
      header("Location:$page");
    }
  }
}
/* ------------------------------ delete end ------------------------------ */
/* ------------------------------ delete start ------------------------------ */
$d_cookie = "";
if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
  foreach ($_COOKIE['item'] as $name1 => $value) {
    if (isset($_POST["delete3$name1"])) {
      $d_cookie .= setcookie("item[$name1]", "", time() - (86400 * 30), "/");

      // header("Refresh:0");            
      $page = $_SERVER['PHP_SELF'];
      header("Location:$page");
    }
  }
}
//  echo $_SESSION['shipping_charge'];
/* ------------------------------ delete end ------------------------------ */
/* ------------------------- total cart price start ------------------------- */

$c = 0;
if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
  foreach ($_COOKIE['item'] as $name1 => $value) {
    $value12 = explode("__", $value);
    $c += $value12[9];
  }
} else {
  header("Location:/");
}
// setcookie("totalcart",$c,time()+(86400 * 30),"/");
$_SESSION['ccc'] = $c;
/* ------------------------- total cart price end ------------------------- */
$discount = 0;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$previous_state = 'none';
$current_state = 'none';
if (isset($_GET['previous_step'])) {
  $previous_state = $_GET['previous_step'];
}
if (isset($_GET['step'])) {
  $current_state = $_GET['step'];
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <title>Let’s make a Shift to Thrift </title>
  <meta name="description" content="If you haven’t discovered the joy of thrift shopping, now is the time. Dank Thrift is an affordable, sustainable and fashionable thrift store aimed to build a solid community of conscious shoppers.">
  <meta name="Keywords" content="Custom T-shirts,Custom Hoodies, Make your Own,Custom Polo,Custom Round neck,Custom T-shirts ">
  <meta name="author" content="Vinayak">
  <meta property="og:title" content="Let’s make a Shift to Thrift " />
  <meta property="og:url" content="<?php echo $actual_link ?>" />
  <meta property="og:description" content="If you haven’t discovered the joy of thrift shopping, now is the time. Dank Thrift is an affordable, sustainable and fashionable thrift store aimed to build a solid community of conscious shoppers.">
  <meta property="og:image" itemprop="image" content="<?= $current_site_link ?>/icons/hold.png" />
  <meta property="og:image:secure_url" itemprop="image" content="<?= $current_site_link ?>/icons/hold.png" />
  <meta property="og:image:width" content="640">
  <meta property="og:image:height" content="300">
  <meta property="og:type" content="website" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <!-- css to include style.css -->
  <link rel="stylesheet" href="css/vendor.min.css" />
  <link rel="stylesheet" href="css/slick.min.css" />
  <link rel="stylesheet" href="css/style.css">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="icons/campaign.png" />
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" type="text/css" media="all">
  <style>
    html,
    body {
      scroll-behavior: smooth;
    }

    #loading {
      background: url('<?php echo $img_link ?>images/spinner.gif') no-repeat rgba(255, 255, 255, 0.7);
      background-position: center;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 100%;
      z-index: 9999999;
      background-size: 12%;
    }

    @media screen and (max-width: 1280px) {
      #loading {

        background-size: 15%;
      }

    }

    @media screen and (max-width: 991px) {
      #loading {

        background-size: 20%;
      }

    }

    @media screen and (max-width: 767px) {
      #loading {

        background-size: 22%;
      }

    }

    @media screen and (max-width: 479px) {
      #loading {

        background-size: 26%;
      }

    }

    .mb-20px {
      margin-bottom: 10px !important;
    }

    .your-order-middle li {
      display: block !important;
    }

    .upar {
      position: absolute;
      display: inline-block;
      width: 20px;
      height: 20px;
      color: #fff;
      background: #472D2D;
      line-height: 19px;
      font-size: 11px;
      border-radius: 100%;
      text-align: center;
      font-weight: 700;
      margin-left: -10%;
      top: 0;
    }

    @media screen and (max-width: 1200px) and (min-width: 991px) {
      .upar {
        margin-left: 55%;
      }
    }

    .self-button {
      cursor: pointer;
      background: #472D2D;
      border-radius: 5px;
      color: #fff !important;
      display: inline-block;
      font-size: 14px;
      font-weight: 600;
      line-height: 1;
      padding: 20px 30px 20px;
      text-transform: uppercase;
    }

    .self-button:hover {
      color: #fff;
      background: #1d1d1d;
    }

    .table td {
      padding: .75rem;
      vertical-align: top;
      border: none;
    }

    .shipping-info-show,
    .payment-info-show {
      display: none;
    }

    @media screen and (max-width: 991px) and (min-width: 0px) {
      .footer-tags {
        padding-top: 0;
        padding-bottom: 50px;
      }
    }

    .slider-menumob2,
    .slider-menumob3 {
      display: none;
    }

    .pay-button:hover {
      background: rgb(29 29 29);
      ;
      color: #fff !important;
    }

    .modal-flex {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
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
      j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-WS3Q2PH');
  </script>
  <!-- End Google Tag Manager -->
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WS3Q2PH" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div id="loading" style="display:none"></div>
  <!-- --------------------------- header start here --------------------------- -->
  <!-- Header Section Start From Here -->
  <input type="hidden" name="chooseChain" id="chooseChain">
  <input type="hidden" name="account_id" id="account_id" value="<?= $_SESSION['eth_id'] ?>">
  <header class="header-wrapper">
    <div class="header-nav">
      <div class="container">
        <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between" style="align-items:center;">
          <div class="header-static-nav">
            <a href="mailto:contact@dankthrift.com">contact@dankthrift.com</a>
          </div>
          <div class="header-menu-nav">
            <ul class="menu-nav">
              <li>
                <?php if (empty($_SESSION['eth_id'])) { ?>
                  <div style="position:relative;">
                    <a class="sticky_button_side shadow-md enableEthereumButton" title="Add to cart" tabindex="0" id="enableEthereumButton" onclick="userLoginOut()">Login</a>
                  </div>
                  <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
                <?php } ?>
                <?php if (!empty($_SESSION['eth_id'])) { ?>
                  <div class="dropdown">
                    <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" text-transform: capitalize;display:flex;align-items:center;"><?php
                                                                                                                                                                                                          if (empty($_SESSION['eth_id'])) {
                                                                                                                                                                                                            echo "My Account ";
                                                                                                                                                                                                          } else {
                                                                                                                                                                                                            // echo substr($_SESSION['eth_id'], 0, 8) . "... "; 
                                                                                                                                                                                                          ?>
                        <span style="border-radius:50%;overflow:hidden;padding:5px;border:1px solid #333;background:#FEF5E7;" class="mr-2"><img src="images/metamask.svg" alt="metamask" style="height:30px;width:30px;" class="animate__animated animate__pulse animate__infinite animate__slow"></span>
                      <?php } ?>
                      <i class="ion-ios-arrow-down"></i>
                    </button>
                    <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                      <li><a href="javascript:void(0)">
                          <p class="font-weight-bold" style="display: inline-block;word-break:break-all;white-space: pre-line;overflow-wrap:break-word;"><?= $_SESSION['eth_id'] ?></p>
                        </a></li>
                      <li><a href="my-account">Profile</a></li>
                      <li><a href="my_order" style="display:<?php if (empty($_SESSION['eth_id'])) {
                                                              echo "none";
                                                            } else {
                                                              echo "block";
                                                            } ?>">My Order</a></li>
                      <li><a style="display:<?php if (empty($_SESSION['eth_id'])) {
                                              echo "none";
                                            } else {
                                              echo "block";
                                            } ?>" class="logout" onclick="signOutOfMetaMask()">Logout</a></li>
                    </ul>
                  </div>
                <?php } ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="header-top bg-white ptb-30px d-lg-block d-none">
      <div class="container">
        <div class="row">
          <div class="col-md-3 d-flex justify-content-center">
            <div class="logo align-self-center">
              <a href="/"><img loading="lazy" class="img-responsive size" src="<?php echo $img_link ?>images/logo/logo.png" alt="logo.png" /></a>
            </div>
          </div>
          <div class="col-md-9 align-self-center">
            <div class="header-right-element d-flex">
              <div class="search-element media-body mr-20px">
                <form class="d-flex" action="search.php" method="get">
                  <div class="search-category">
                    <select name="cat">
                      <option value="all">All categories</option>
                      <?php
                      $q = "SELECT DISTINCT category from `product_category` WHERE 1";
                      $res = mysqli_query($link, $q);
                      if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                      ?>
                          <option value="<?php echo $row['category'] ?>"><?php echo $row['category'] ?></option>
                      <?php }
                      } ?>

                    </select>
                  </div>
                  <input type="text" placeholder="Enter your search key ... " name="search" />
                  <button type="submit">Search</button>
                </form>
              </div>
              <!--Cart info Start -->
              <div class="header-tools d-flex">
                <div class="cart-info d-flex align-self-center">
                  <a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i class="lnr lnr-heart"></i><span>Wishlist</span></a>
                  <style>
                    .header-tools .cart-info .heart:before {
                      content: '<?php if (!empty($wishcart_item)) {
                                  echo $wishcart_item;
                                } else {
                                  echo "0";
                                }

                                ?>'
                    }
                  </style>
                  <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i class="lnr lnr-cart"></i><span>My Cart</span></a>
                  <style>
                    .header-tools .cart-info .bag:before {
                      content: '<?php if (!empty($cart_item)) {
                                  echo $cart_item;
                                } else {
                                  // echo "0";
                                }

                                ?>'
                    }
                  </style>

                </div>
              </div>
            </div>
            <!--Cart info End -->
          </div>
        </div>
      </div>
    </div>
    <!-- Header Nav End -->
    <div class="header-menu bg-white sticky-nav d-lg-block d-none padding-0px">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <div class="header-menu-vertical">
              <h4 class="menu-title">Browse Categories </h4>
              <ul class="menu-content display-none">
                <?php
                $q = "SELECT DISTINCT category from `product_category` WHERE 1";
                $res = mysqli_query($link, $q);
                if (mysqli_num_rows($res) > 0) {
                  while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <li class="menu-item"><a href="shop-left-sidebar.php?category=<?php echo $row['category'] ?>"><?php echo $row['category'] ?></a></li>
                <?php }
                } ?>

              </ul>
              <!-- menu content -->
            </div>
            <!-- header menu vertical -->
          </div>
          <div class="col-lg-9">
            <div class="header-horizontal-menu">
              <ul class="menu-content">
                <li class="active menu-dropdown">
                  <a href="/">Home</a>
                </li>
                <li class="menu-dropdown">
                  <a href="shop-left-sidebar.php">Shop</a>
                </li>
                <li class="menu-dropdown">
                  <a href="about">About</a>
                </li>
                <li><a href="contact">Contact</a></li>
              </ul>
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- header menu -->
  </header>
  <!-- Header Section End Here -->
  <!-- Mobile Header Section Start -->
  <div class="mobile-header d-lg-none sticky-nav bg-white ptb-20px">
    <div class="container">
      <div class="row align-items-center">

        <!-- Header Logo Start -->
        <div class="col">
          <div class="header-logo">
            <a href="/"><img loading="lazy" class="img-responsive size" src="  <?php echo $img_link ?>images/logo/logo.png" alt="logo.png" style="padding:0.7rem 0;" /></a>
          </div>
        </div>
        <!-- Header Logo End -->

        <!-- Header Tools Start -->
        <div class="col-auto">
          <div class="header-tools justify-content-end">
            <div class="cart-info d-flex align-self-center">
              <a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i class="lnr lnr-heart"></i><span>Wishlist</span></a>
              <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i class="lnr lnr-cart"></i><span>My
                  Cart</span></a>
            </div>
            <div class="mobile-menu-toggle">
              <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                <svg viewBox="0 0 800 600">
                  <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                  <path d="M300,320 L540,320" id="middle"></path>
                  <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
                  </path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <!-- Header Tools End -->

      </div>
    </div>
  </div>

  <!-- Search Category Start -->

  <!-- Search Category End -->

  <!-- Mobile Header Section End -->
  <!-- OffCanvas Wishlist Start -->
  <div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
    <div class="inner">
      <div class="head">
        <span class="title">Wishlist</span>
        <button class="offcanvas-close">×</button>
      </div>
      <?php @$ddd = 0;
      if (!empty($_COOKIE['wishitem']) && is_array($_COOKIE['wishitem'])) {
        @$ddd = $ddd + 1;
      }
      if (@$ddd == 0) {
        echo "<div class='empty-cart-area mtb-50px'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='cart-heading'><h2 style='font-size:20px;'>Your wishlist item</h2></div>
                    <div class='empty-text-contant text-center'>
                       <i class='lnr lnr-heart' style='font-size:44px;'></i>
                       <h1 style='font-size: 14px;'>There are no more items in your wishlist</h1>
                       <a class='empty-cart-btn' href='/' style='font-size: 14px;padding:10px 14px;'>
                            <i class='ion-ios-arrow-left' style='font-size: 14px;'> </i> Continue shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>";
      } else {
      ?>
        <div class="body customScroll">
          <ul class="minicart-product-list">
            <?php
            foreach ($_COOKIE['wishitem'] as $name1 => $value) {
              $value11 = explode("__", $value);
              $_SESSION['wishp_id'] = $value11[7];
              $without_size = explode("-", $value11[11]);
              $only_size = $without_size[2];
              $sku = $without_size[0] . '-' . $without_size[1];
            ?>
              <li id="side_item1">
                <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>" class="image"><img loading="lazy" src="  <?php echo $img_link ?>images/product-image/<?php echo $value11[3] ?>" alt="Cart product Image" style="height: 78px;"></a>
                <div class="content">
                  <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>" class="title"><?php echo $value11[2] ?></a>
                  <span class="quantity-price"><span id="itemquanity"><?php echo $value11[8] ?></span> x <span class="amount">&#8377;<span id="itemval_side"><?php echo $value11[5] ?></span></span></span>
                  <form method="post">
                    <button type="submit" name="delete2<?php echo $name1; ?>"><a class="remove">×</a></button>
                  </form>
                </div>
              </li>
            <?php
            }
            ?>

          </ul>
        </div>
        <div class="foot">
          <div class="buttons">
            <a href="wishlist.php" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
  <!-- OffCanvas Wishlist End -->

  <!-- OffCanvas Cart Start -->
  <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
    <div class="inner">
      <div class="head">
        <span class="title">Cart</span>
        <button class="offcanvas-close">×</button>
      </div>

      <?php @$d = 0;
      if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
        @$d = $d + 1;
      }
      if (@$d == 0) {
        echo "<div class='empty-cart-area mtb-50px'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='cart-heading'><h2 style='font-size:20px;'>Your cart item</h2></div>
                    <div class='empty-text-contant text-center'>
                       <i class='lnr lnr-cart'></i>
                       <h1 style='font-size: 14px;'>There are no more items in your cart</h1>
                       <a class='empty-cart-btn' href='/' style='font-size: 14px;padding:10px 14px;'>
                            <i class='ion-ios-arrow-left' style='font-size: 14px;'> </i> Continue shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>";
      } else {
      ?>
        <div class="body customScroll">
          <ul class="minicart-product-list">
            <?php
            foreach ($_COOKIE['item'] as $name1 => $value) {
              $value11 = explode("__", $value);
              $_SESSION['p_id'] = $value11[7];
              $without_size = explode("-", $value11[10]);
              $only_size = $without_size[2];
              $sku = $without_size[0] . '-' . $without_size[1];
            ?>
              <li id="side_item1">
                <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>" class="image"><img loading="lazy" src="  <?php echo $img_link ?>images/product-image/<?php echo $value11[3] ?>" alt="Cart product Image" style="height: 78px;"></a>
                <div class="content">
                  <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>" class="title"><?php echo $value11[2] ?></a>
                  <span class="quantity-price"><span id="itemquanity"><?php echo $value11[8] ?></span> x <span class="amount">&#8377;<span id="itemval_side">
                        <?php
                        // test start //
                        $q33 = "SELECT `hot_deal_sale_price` FROM hot_deals WHERE `hot_deals_product_id`='$value11[7]'";
                        $res2 = mysqli_query($link, $q33);
                        if (mysqli_num_rows($res2) > 0) {
                          while ($row2 = mysqli_fetch_assoc($res2)) {
                            $_SESSION['product_final_quantity'] = $value11[8];
                            echo $row2['hot_deal_sale_price'];
                            $_SESSION['product_final_price'] += $row2['hot_deal_sale_price'] * $_SESSION['product_final_quantity'];
                          }
                        } else {
                          // test end //
                          $q = "SELECT `sale_price`, `quantity` FROM product_tbl WHERE id=" . $value11[7] . "";
                          $res = mysqli_query($link, $q);
                          if (mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                              $_SESSION['product_final_quantity'] = $value11[8];
                              echo $row['sale_price'];
                              $_SESSION['product_final_price'] += $row['sale_price'] * $_SESSION['product_final_quantity'];
                            }
                          }
                        } ?>
                      </span>
                    </span>
                  </span>
                  <form method="post">
                    <button type="submit" name="delete3<?php echo $name1; ?>"><a class="remove">×</a></button>
                  </form>
                </div>
              </li>
            <?php
            }
            ?>

          </ul>
        </div>

        <div class="foot">
          <div class="sub-total">
            <strong>Subtotal :</strong>
            <span class="amount">&#8377;<span id="product_total_amt_side"><?php
                                                                          echo $_SESSION['product_final_price']; ?></span></span>
          </div>
          <div class="buttons">
            <a href="cart.php" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
            <a href="checkout.php" class="btn btn-outline-dark current-btn">checkout</a>
          </div>
          <p class="minicart-message">Free Shipping on All Orders Over ₹1000!</p>
        </div>
      <?php
      }

      ?>
    </div>
  </div>
  <!-- OffCanvas Cart End -->

  <!-- OffCanvas Search Start -->
  <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <div class="inner customScroll">
      <div class="head">
        <span class="title">&nbsp;</span>
        <button class="offcanvas-close">×</button>
      </div>
      <div class="offcanvas-menu">
        <ul>
          <li><a href="/"><span class="menu-text">Home</span></a>
          </li>
          <li><a href="shop-left-sidebar.php"><span class="menu-text">Shop</span></a>
          </li>
          <li><a href="about">About</a></li>
          <li><a href="contact">Contact</a></li>
        </ul>
      </div>
      <!-- OffCanvas Menu End -->
      <div class="offcanvas-social mt-30px">
        <ul>
          <li>
            <a href="https://www.facebook.com/quadbapparels/"><i class="ion-social-facebook"></i></a>
          </li>
          <li>
            <a href="https://twitter.com/quadbcreations"><i class="ion-social-twitter"></i></a>
          </li>
          <li>
            <a href="https://www.linkedin.com/company/quadb"><i class="ion-social-linkedin"></i></a>
          </li>
          <li>
            <a href="https://www.instagram.com/dank_thrift/"><i class="ion-social-instagram"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- OffCanvas Search End -->

  <div class="offcanvas-overlay"></div>

  <!-- --------------------------- header end here --------------------------- -->
  <!-- Breadcrumb Area Start -->
  <div class="breadcrumb-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="breadcrumb-content">
            <ul class="nav">
              <li><a href="/">Home</a></li>
              <li><a href="/">Shop</a></li>
              <li>Checkout</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb Area End-->
  <!-- ------------------------ page start from here ------------------------ -->
  <div class="checkout-area mt-50px mb-40px" style="margin-top:20px !important">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12  order-sm-0 order-md-0 order-lg-1">
          <!-- mobile view total order start -->
          <div class="d-lg-none position-relative mb-3" style="width:100%;">
            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="chevronShow">
              <div class="px-auto bg-primary text-white py-3" style="width:100%;"><span><i class="lnr lnr-cart mx-2"></i></span>Show order summary<span><i class="lnr lnr-chevron-down mx-2"></i></span></div>
            </a>
            <div class="collapse" id="collapseExample">
              <div class="card card-body p-0">
                <div class="your-order-area">
                  <div class="your-order-wrap gray-bg-4">
                    <div class="your-order-product-info">
                      <div class="your-order-top">
                        <ul>
                          <li>Product</li>
                          <li>Total</li>
                        </ul>
                      </div>
                      <div class="your-order-middle">
                        <ul>
                          <?php
                          $amount = 0;
                          $shipping_charge = 0;
                          foreach ($_COOKIE['item'] as $name1 => $value) {
                            $value11 = explode("__", $value);
                            $_SESSION['p_id'] = $value11[7];
                            $without_size = substr($value11[10], 0, -2);
                            $only_size = explode('-', $value11[10])[2];
                            // $_SESSION['id']=$value11[7]
                          ?><?php
                            $amount += $value11[9];
                            $net_amount = ($_SESSION['product_final_price']);

                            ?>
                          <input type="hidden" value="<?php echo $_SESSION['product_final_price']; ?>" class="original_price">

                          <li>
                            <div class="container p-0">
                              <div class="row">
                                <div class="col-3">
                                  <span>
                                    <input type="hidden" name="product_size" id="product_size" value="<?= $only_size ?>">
                                    <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $without_size ?>" class="image">
                                      <img loading="lazy" src="  <?php echo $img_link ?>images/product-image/<?php echo $value11[3] ?>" alt="Cart product Image" style="height: 78px;">
                                      <div class="upar">
                                        <?php echo $value11[8] ?>
                                      </div>
                                    </a>
                                  </span>
                                </div>
                                <div class="col-6">
                                  <span class="order-middle-left mx-1">
                                    <?php echo $value11[2] ?> X <?php echo $value11[8] ?>
                                    <input type="hidden" value="<?php echo $value11[2] ?>" class="order_name2">
                                    <input type="hidden" value="<?php echo $value11[8] ?>" class="order_quantity2">
                                    <input type="hidden" value="<?php echo $value11[0] ?>" class="order_image2">
                                    <input type="hidden" value="<?php echo $value11[5] ?>" class="order_per_price2">
                                    <input type="hidden" value="<?php echo $value11[7] ?>" class="order_id2">
                                    <input type="hidden" value="<?php echo $value11[10] ?>" class="product_sku2">
                                  </span>
                                </div>
                                <div class="col-3">
                                  <span class="order-price orderrow2">&#8377;<?php echo $value11[9] ?>
                                    <input type="hidden" value="<?php echo $value11[9] ?>" class="order_amount2">
                                  </span>
                                </div>
                              </div>
                            </div>

                          </li>
                          <!-- <li><span class="order-middle-left">Product Name X 1</span> <span class="order-price">$329 </span></li> -->
                        <?php } ?>
                        </ul>
                      </div>
                      <div class="discount-code-wrapper" style="background:none;border:none;padding:0;">
                        <div class="discount-code">
                          <p>Enter your coupon code if you have one.</p>
                          <form class="form-inline">
                            <div class="form-group" style="width:100%;display:inline;">
                              <input type="text" required="" name="name" id="in_mobile" style="width: 65%;">
                              <button class="cart-btn-2 ml-2" type="button" id="coupon_button_mobile" style="width: 30%;padding: 14px 0px;">Apply</button>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="your-order-bottom" style="display:none;" id="discount_show_mobile">
                        <ul>
                          <li class="your-order-shipping">Discount</li>
                          <li><span class="discount" id="discount_mobile">0</span><span>% off</span>
                          </li>
                        </ul>
                      </div>
                      <div class="your-order-bottom">
                        <ul>
                          <li class="your-order-shipping mt-2">Subtotal</li>
                          <li>&#8377;<span id="subtotal_mobile" class="subtotal"><?php echo $_SESSION['product_final_price']; ?></span>
                          </li>
                        </ul>
                      </div>
                      <div class="your-order-bottom mt-2">
                        <ul>
                          <li class="your-order-shipping">Shipping</li>
                          <li><span id="total_shipping_charge_mobile" class="total_shipping_charge">Calculated at next step</span>
                          </li>
                        </ul>
                      </div>
                      <div class="your-order-total">
                        <ul>
                          <li class="order-total">Total</li>
                          <li>&#8377;<span id="total_amount_price_mobile" class="total_amount_price"><?php echo $net_amount ?></span></li>
                        </ul>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- mobile view total order end -->
          <!-- Desktop view total order start -->
          <div class="your-order-area d-lg-block d-none">
            <h3>Your Order</h3>
            <div class="your-order-wrap gray-bg-4">
              <div class="your-order-product-info">
                <div class="your-order-top">
                  <ul>
                    <li>Product</li>
                    <li>Total</li>
                  </ul>
                </div>
                <div class="your-order-middle">
                  <ul>
                    <?php
                    $amount = 0;
                    $shipping_charge = 0;
                    foreach ($_COOKIE['item'] as $name1 => $value) {
                      $value11 = explode("__", $value);
                      $_SESSION['p_id'] = $value11[7];
                      $without_size = substr($value11[10], 0, -2);
                      $only_size = explode('-', $value11[10])[2];
                      // $_SESSION['id']=$value11[7]
                    ?><?php
                      $amount += $value11[9];
                      $net_amount = ($_SESSION['product_final_price']);

                      ?>
                    <input type="hidden" value="<?php echo $_SESSION['product_final_price']; ?>" class="original_price">

                    <li>
                      <div class="container p-0">
                        <div class="row">
                          <div class="col-3">
                            <span>
                              <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $without_size ?>" class="image">
                                <img loading="lazy" src="  <?php echo $img_link ?>images/product-image/<?php echo $value11[3] ?>" alt="Cart product Image" style="height: 78px;">
                                <div class="upar">
                                  <?php echo $value11[8] ?>
                                </div>
                              </a>
                            </span>
                          </div>
                          <div class="col-7">
                            <span class="order-middle-left mx-1">
                              <?php echo $value11[2] ?> X <?php echo $value11[8] ?>
                              <input type="hidden" value="<?php echo $value11[2] ?>" class="order_name">
                              <input type="hidden" value="<?php echo $value11[8] ?>" class="order_quantity">
                              <input type="hidden" value="<?php echo $value11[0] ?>" class="order_image">
                              <input type="hidden" value="<?php echo $value11[5] ?>" class="order_per_price">
                              <input type="hidden" value="<?php echo $value11[7] ?>" class="order_id">
                              <input type="hidden" value="<?php echo $value11[10] ?>" class="product_sku">
                            </span>
                          </div>
                          <div class="col-2">
                            <span class="order-price orderrow2">&#8377;<?php echo $value11[9] ?>
                              <input type="hidden" value="<?php echo $value11[9] ?>" class="order_amount">
                            </span>
                          </div>
                        </div>
                      </div>

                    </li>
                    <!-- <li><span class="order-middle-left">Product Name X 1</span> <span class="order-price">$329 </span></li> -->
                  <?php } ?>
                  </ul>
                </div>
                <div class="discount-code-wrapper" style="background:none;border:none;padding:0;">
                  <div class="discount-code">
                    <p>Enter your coupon code if you have one.</p>
                    <form class="form-inline">
                      <div class="form-group" style="width:100%;display:inline;">
                        <input type="text" required="" name="name" id="in" style="width: 65%;">
                        <button class="cart-btn-2 ml-2" type="button" id="coupon_button" style="width: 30%;padding: 18px 0px;">Apply</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="your-order-bottom" style="display:none;" id="discount_show">
                  <ul>
                    <li class="your-order-shipping">Discount</li>
                    <li><span class="discount" id="discount">0</span><span>% off</span>
                    </li>
                  </ul>
                </div>
                <div class="your-order-bottom">
                  <ul>
                    <li class="your-order-shipping mt-2">Subtotal</li>
                    <li>&#8377;<span id="subtotal" class="subtotal"><?php echo $_SESSION['product_final_price']; ?></span>
                    </li>
                  </ul>
                </div>
                <div class="your-order-bottom mt-2">
                  <ul>
                    <li class="your-order-shipping">Shipping</li>
                    <li><span id="total_shipping_charge" class="total_shipping_charge">Calculated at next step</span>
                    </li>
                  </ul>
                </div>
                <div class="your-order-total">
                  <ul>
                    <li class="order-total">Total</li>
                    <li>&#8377;<span id="total_amount_price" class="total_amount_price"><?php echo $net_amount ?></span></li>
                  </ul>
                </div>

              </div>
            </div>
          </div>
          <!-- Desktop view total order end -->
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12  order-sm-1 order-md-1 order-lg-0">
          <?php
          $row_first_name = "";
          $row_last_name = "";
          $row_company = "";
          $row_country = "";
          $row_address = "";
          $row_address2 = "";
          $row_city = "";
          $row_state = "";
          $row_postcode = "";
          $row_phone = "";
          $row_email = "";
          $row_additional_note = "";
          if (!empty($_SESSION['eth_id'])) {
            $check_mail = $_SESSION['eth_id'];
            $query = "SELECT * FROM `billing_details` WHERE `email`='$check_mail'";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $value_name = explode(" ", $row['name']);
                $row_first_name = $value_name[0];
                $row_last_name = $value_name[1];
                $row_company = $row['company'];
                $value_address = explode("__", $row['address']);
                $row_country = $value_address[5];
                $row_address = $value_address[0];
                $row_address2 = $value_address[1];
                $row_city = $value_address[2];
                $row_state = $value_address[3];
                $row_postcode = $value_address[4];
                $row_phone = $row['phone'];
                $row_email = $row['email'];
                $row_additional_note = $row['additional_notes'];
              }
            }
          }
          ?>
          <!-- step 1 start -->
          <div class="contact-info-show">
            <div class="billing-info-wrap">
              <h3>Contact Informtion</h3>
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="billing-info mb-20px">
                    <label for="">Email or mobile phone number</label>
                    <input type="text" id="email" value="">
                  </div>
                  <div class="checkout-account2">
                    <input class="checkout-toggle-update" type="checkbox">
                    <label class="pb-1 ">Keep me up to date on news and exclusive offers</label>
                  </div>
                </div>
              </div>
              <h3 class="mt-4">Shipping Details</h3>
              <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="billing-info mb-20px">
                    <label for="">First Name</label>
                    <input type="text" id="first_name" value="<?php echo $row_first_name ?>">
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="billing-info mb-20px">
                    <label for="">Last Name</label>
                    <input type="text" id="last_name" value="<?php echo $row_last_name ?>">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="billing-info mb-20px">
                    <label for="">Street Address</label>
                    <input type="text" placeholder="House number and street name" class="billing-address" id="street_address" value="<?php echo $row_address ?>">
                    <input type="text" placeholder="Apartment, suite, unit etc." id="street_address_extra" value="<?php echo $row_address2 ?>">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="billing-info mb-20px">
                    <label for="">Town / City</label>
                    <input type="text" id="city" value="<?php echo $row_city ?>">
                  </div>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="billing-select mb-20px">
                    <label>Country</label>
                    <select id="country">
                      <?php
                      $selected1 = "";
                      $selected2 = "";
                      $selected3 = "";
                      $selected4 = "";
                      $selected5 = "";
                      if ($row_country == "Azerbaijan") {
                        $selected1 = "selected";
                      } else if ($row_country == "Bahamas") {
                        $selected2 = "selected";
                      } else if ($row_country == "Bahrain") {
                        $selected3 = "selected";
                      } else if ($row_country == "Bangladesh") {
                        $selected4 = "selected";
                      } else if ($row_country == "Barbados") {
                        $selected5 = "selected";
                      }
                      ?>
                      <option value="">Select a country</option>
                      <option value="Afganistan">Afghanistan</option>
                      <option value="Albania">Albania</option>
                      <option value="Algeria">Algeria</option>
                      <option value="American Samoa">American Samoa</option>
                      <option value="Andorra">Andorra</option>
                      <option value="Angola">Angola</option>
                      <option value="Anguilla">Anguilla</option>
                      <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                      <option value="Argentina">Argentina</option>
                      <option value="Armenia">Armenia</option>
                      <option value="Aruba">Aruba</option>
                      <option value="Australia">Australia</option>
                      <option value="Austria">Austria</option>
                      <option value="Azerbaijan">Azerbaijan</option>
                      <option value="Bahamas">Bahamas</option>
                      <option value="Bahrain">Bahrain</option>
                      <option value="Bangladesh">Bangladesh</option>
                      <option value="Barbados">Barbados</option>
                      <option value="Belarus">Belarus</option>
                      <option value="Belgium">Belgium</option>
                      <option value="Belize">Belize</option>
                      <option value="Benin">Benin</option>
                      <option value="Bermuda">Bermuda</option>
                      <option value="Bhutan">Bhutan</option>
                      <option value="Bolivia">Bolivia</option>
                      <option value="Bonaire">Bonaire</option>
                      <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                      <option value="Botswana">Botswana</option>
                      <option value="Brazil">Brazil</option>
                      <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                      <option value="Brunei">Brunei</option>
                      <option value="Bulgaria">Bulgaria</option>
                      <option value="Burkina Faso">Burkina Faso</option>
                      <option value="Burundi">Burundi</option>
                      <option value="Cambodia">Cambodia</option>
                      <option value="Cameroon">Cameroon</option>
                      <option value="Canada">Canada</option>
                      <option value="Canary Islands">Canary Islands</option>
                      <option value="Cape Verde">Cape Verde</option>
                      <option value="Cayman Islands">Cayman Islands</option>
                      <option value="Central African Republic">Central African Republic</option>
                      <option value="Chad">Chad</option>
                      <option value="Channel Islands">Channel Islands</option>
                      <option value="Chile">Chile</option>
                      <option value="China">China</option>
                      <option value="Christmas Island">Christmas Island</option>
                      <option value="Cocos Island">Cocos Island</option>
                      <option value="Colombia">Colombia</option>
                      <option value="Comoros">Comoros</option>
                      <option value="Congo">Congo</option>
                      <option value="Cook Islands">Cook Islands</option>
                      <option value="Costa Rica">Costa Rica</option>
                      <option value="Cote DIvoire">Cote DIvoire</option>
                      <option value="Croatia">Croatia</option>
                      <option value="Cuba">Cuba</option>
                      <option value="Curaco">Curacao</option>
                      <option value="Cyprus">Cyprus</option>
                      <option value="Czech Republic">Czech Republic</option>
                      <option value="Denmark">Denmark</option>
                      <option value="Djibouti">Djibouti</option>
                      <option value="Dominica">Dominica</option>
                      <option value="Dominican Republic">Dominican Republic</option>
                      <option value="East Timor">East Timor</option>
                      <option value="Ecuador">Ecuador</option>
                      <option value="Egypt">Egypt</option>
                      <option value="El Salvador">El Salvador</option>
                      <option value="Equatorial Guinea">Equatorial Guinea</option>
                      <option value="Eritrea">Eritrea</option>
                      <option value="Estonia">Estonia</option>
                      <option value="Ethiopia">Ethiopia</option>
                      <option value="Falkland Islands">Falkland Islands</option>
                      <option value="Faroe Islands">Faroe Islands</option>
                      <option value="Fiji">Fiji</option>
                      <option value="Finland">Finland</option>
                      <option value="France">France</option>
                      <option value="French Guiana">French Guiana</option>
                      <option value="French Polynesia">French Polynesia</option>
                      <option value="French Southern Ter">French Southern Ter</option>
                      <option value="Gabon">Gabon</option>
                      <option value="Gambia">Gambia</option>
                      <option value="Georgia">Georgia</option>
                      <option value="Germany">Germany</option>
                      <option value="Ghana">Ghana</option>
                      <option value="Gibraltar">Gibraltar</option>
                      <option value="Great Britain">Great Britain</option>
                      <option value="Greece">Greece</option>
                      <option value="Greenland">Greenland</option>
                      <option value="Grenada">Grenada</option>
                      <option value="Guadeloupe">Guadeloupe</option>
                      <option value="Guam">Guam</option>
                      <option value="Guatemala">Guatemala</option>
                      <option value="Guinea">Guinea</option>
                      <option value="Guyana">Guyana</option>
                      <option value="Haiti">Haiti</option>
                      <option value="Hawaii">Hawaii</option>
                      <option value="Honduras">Honduras</option>
                      <option value="Hong Kong">Hong Kong</option>
                      <option value="Hungary">Hungary</option>
                      <option value="Iceland">Iceland</option>
                      <option value="Indonesia">Indonesia</option>
                      <option value="India" selected>India</option>
                      <option value="Iran">Iran</option>
                      <option value="Iraq">Iraq</option>
                      <option value="Ireland">Ireland</option>
                      <option value="Isle of Man">Isle of Man</option>
                      <option value="Israel">Israel</option>
                      <option value="Italy">Italy</option>
                      <option value="Jamaica">Jamaica</option>
                      <option value="Japan">Japan</option>
                      <option value="Jordan">Jordan</option>
                      <option value="Kazakhstan">Kazakhstan</option>
                      <option value="Kenya">Kenya</option>
                      <option value="Kiribati">Kiribati</option>
                      <option value="Korea North">Korea North</option>
                      <option value="Korea Sout">Korea South</option>
                      <option value="Kuwait">Kuwait</option>
                      <option value="Kyrgyzstan">Kyrgyzstan</option>
                      <option value="Laos">Laos</option>
                      <option value="Latvia">Latvia</option>
                      <option value="Lebanon">Lebanon</option>
                      <option value="Lesotho">Lesotho</option>
                      <option value="Liberia">Liberia</option>
                      <option value="Libya">Libya</option>
                      <option value="Liechtenstein">Liechtenstein</option>
                      <option value="Lithuania">Lithuania</option>
                      <option value="Luxembourg">Luxembourg</option>
                      <option value="Macau">Macau</option>
                      <option value="Macedonia">Macedonia</option>
                      <option value="Madagascar">Madagascar</option>
                      <option value="Malaysia">Malaysia</option>
                      <option value="Malawi">Malawi</option>
                      <option value="Maldives">Maldives</option>
                      <option value="Mali">Mali</option>
                      <option value="Malta">Malta</option>
                      <option value="Marshall Islands">Marshall Islands</option>
                      <option value="Martinique">Martinique</option>
                      <option value="Mauritania">Mauritania</option>
                      <option value="Mauritius">Mauritius</option>
                      <option value="Mayotte">Mayotte</option>
                      <option value="Mexico">Mexico</option>
                      <option value="Midway Islands">Midway Islands</option>
                      <option value="Moldova">Moldova</option>
                      <option value="Monaco">Monaco</option>
                      <option value="Mongolia">Mongolia</option>
                      <option value="Montserrat">Montserrat</option>
                      <option value="Morocco">Morocco</option>
                      <option value="Mozambique">Mozambique</option>
                      <option value="Myanmar">Myanmar</option>
                      <option value="Nambia">Nambia</option>
                      <option value="Nauru">Nauru</option>
                      <option value="Nepal">Nepal</option>
                      <option value="Netherland Antilles">Netherland Antilles</option>
                      <option value="Netherlands">Netherlands (Holland, Europe)</option>
                      <option value="Nevis">Nevis</option>
                      <option value="New Caledonia">New Caledonia</option>
                      <option value="New Zealand">New Zealand</option>
                      <option value="Nicaragua">Nicaragua</option>
                      <option value="Niger">Niger</option>
                      <option value="Nigeria">Nigeria</option>
                      <option value="Niue">Niue</option>
                      <option value="Norfolk Island">Norfolk Island</option>
                      <option value="Norway">Norway</option>
                      <option value="Oman">Oman</option>
                      <option value="Pakistan">Pakistan</option>
                      <option value="Palau Island">Palau Island</option>
                      <option value="Palestine">Palestine</option>
                      <option value="Panama">Panama</option>
                      <option value="Papua New Guinea">Papua New Guinea</option>
                      <option value="Paraguay">Paraguay</option>
                      <option value="Peru">Peru</option>
                      <option value="Phillipines">Philippines</option>
                      <option value="Pitcairn Island">Pitcairn Island</option>
                      <option value="Poland">Poland</option>
                      <option value="Portugal">Portugal</option>
                      <option value="Puerto Rico">Puerto Rico</option>
                      <option value="Qatar">Qatar</option>
                      <option value="Republic of Montenegro">Republic of Montenegro</option>
                      <option value="Republic of Serbia">Republic of Serbia</option>
                      <option value="Reunion">Reunion</option>
                      <option value="Romania">Romania</option>
                      <option value="Russia">Russia</option>
                      <option value="Rwanda">Rwanda</option>
                      <option value="St Barthelemy">St Barthelemy</option>
                      <option value="St Eustatius">St Eustatius</option>
                      <option value="St Helena">St Helena</option>
                      <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                      <option value="St Lucia">St Lucia</option>
                      <option value="St Maarten">St Maarten</option>
                      <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                      <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                      <option value="Saipan">Saipan</option>
                      <option value="Samoa">Samoa</option>
                      <option value="Samoa American">Samoa American</option>
                      <option value="San Marino">San Marino</option>
                      <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                      <option value="Saudi Arabia">Saudi Arabia</option>
                      <option value="Senegal">Senegal</option>
                      <option value="Seychelles">Seychelles</option>
                      <option value="Sierra Leone">Sierra Leone</option>
                      <option value="Singapore">Singapore</option>
                      <option value="Slovakia">Slovakia</option>
                      <option value="Slovenia">Slovenia</option>
                      <option value="Solomon Islands">Solomon Islands</option>
                      <option value="Somalia">Somalia</option>
                      <option value="South Africa">South Africa</option>
                      <option value="Spain">Spain</option>
                      <option value="Sri Lanka">Sri Lanka</option>
                      <option value="Sudan">Sudan</option>
                      <option value="Suriname">Suriname</option>
                      <option value="Swaziland">Swaziland</option>
                      <option value="Sweden">Sweden</option>
                      <option value="Switzerland">Switzerland</option>
                      <option value="Syria">Syria</option>
                      <option value="Tahiti">Tahiti</option>
                      <option value="Taiwan">Taiwan</option>
                      <option value="Tajikistan">Tajikistan</option>
                      <option value="Tanzania">Tanzania</option>
                      <option value="Thailand">Thailand</option>
                      <option value="Togo">Togo</option>
                      <option value="Tokelau">Tokelau</option>
                      <option value="Tonga">Tonga</option>
                      <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                      <option value="Tunisia">Tunisia</option>
                      <option value="Turkey">Turkey</option>
                      <option value="Turkmenistan">Turkmenistan</option>
                      <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                      <option value="Tuvalu">Tuvalu</option>
                      <option value="Uganda">Uganda</option>
                      <option value="United Kingdom">United Kingdom</option>
                      <option value="Ukraine">Ukraine</option>
                      <option value="United Arab Erimates">United Arab Emirates</option>
                      <option value="United States of America">United States of America</option>
                      <option value="Uraguay">Uruguay</option>
                      <option value="Uzbekistan">Uzbekistan</option>
                      <option value="Vanuatu">Vanuatu</option>
                      <option value="Vatican City State">Vatican City State</option>
                      <option value="Venezuela">Venezuela</option>
                      <option value="Vietnam">Vietnam</option>
                      <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                      <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                      <option value="Wake Island">Wake Island</option>
                      <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                      <option value="Yemen">Yemen</option>
                      <option value="Zaire">Zaire</option>
                      <option value="Zambia">Zambia</option>
                      <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="billing-info mb-20px">
                    <label for="">State / Country</label>
                    <input type="text" id="state" value="<?php echo $row_country ?>">
                  </div>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="billing-info mb-20px">
                    <label for="">Postcode / Zip</label>
                    <input type="text" id="postcode" value="<?php echo $row_postcode ?>">
                  </div>
                </div>
                <div class="col-lg-12 col-md-12">
                  <div class="billing-info mb-20px">
                    <label for="">Phone</label>
                    <input type="text" id="phone" value="<?php echo $row_phone ?>">

                  </div>
                </div>
                <div class="col-lg-12 col-md-12">
                  <div class="checkout-account3">
                    <input class="checkout-toggle-nexttime" type="checkbox">
                    <label class="pb-1 ">Save this information for next time</label>
                  </div>
                </div>
              </div>
              <div class="your-order-area d-none d-lg-block">
                <div class="Place-order mt-25">
                  <div style="cursor:pointer;" id="place_order_step1" onclick="firststep()"><a class="btn-hover">Continue to shipping</a></div>
                </div>
              </div>
            </div>
          </div>
          <!-- step 1 end -->
          <!-- step 2 start -->
          <div class="shipping-info-show">
            <div class="discount-code-wrapper mt-5" style="padding: 20px 10px 20px;">
              <div class="table-responsive">
                <table class="table" style="font-size:12px;">
                  <tbody>
                    <tr>
                      <td style="border-bottom: 1px solid #dee2e6;">
                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-12">
                            Contact
                          </div>
                          <div class="col-lg-10 col-md-10 col-sm-12">
                            <span class="contact-span text-lowercase">xxxxxxxxxxxxxx</span>
                          </div>
                        </div>
                      </td>
                      <td style="border-bottom: 1px solid #dee2e6;"><a onclick="changeinfo()" style="cursor:pointer;color:#472D2D;">Change</a></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-12">
                            Ship to
                          </div>
                          <div class="col-lg-10 col-md-10 col-sm-12">
                            <span class="address-span text-capitalize">xxxxxxxxxxxxxx</span>
                          </div>
                        </div>
                      </td>
                      <td><a onclick="changeinfo()" style="cursor:pointer;color:#472D2D;">Change</a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="mt-5">
              <h3 style="font-weight: 700;color: #1d1d1d;margin: 15px 0 10px;font-size: 20px;line-height: 16px;" class="my-3">Shipping method</h3>
              <div class="discount-code-wrapper p-0">
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="total-shipping">
                      <ul>
                        <li style="width:100%;padding: 20px 30px 20px;">
                          <input type="radio" value="free" class="checkbox-shipping mx-2" id="Shipping_method" name="checkbox-shipping" checked="checked">Standard<span class="float-right" style="color:#333;">Free</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-4 d-flex justify-content-center">
              <div class="col-lg-6 col-md-6 d-none d-lg-block">
                <div class="your-order-area">
                  <div class="Place-order mt-0">
                    <div style="cursor:pointer;" id="place_order_step2"><a class="btn-hover" onclick="secondstep()">Continue to payment</a></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 text-center" style="padding: 18px 20px;">
                <a onclick="changeinfo()" style="cursor:pointer;color:#472D2D;">return to information</a>
              </div>
            </div>
          </div>
          <!-- step 2 end -->
          <!-- step 3 start -->
          <div class="payment-info-show">
            <div class="discount-code-wrapper mt-5" style="padding: 20px 10px 20px;">
              <div class="table-responsive">
                <table class="table" style="font-size:12px;">
                  <tbody>
                    <tr>
                      <td style="border-bottom: 1px solid #dee2e6;">
                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-12">
                            Contact
                          </div>
                          <div class="col-lg-10 col-md-10 col-sm-12">
                            <span class="contact-span text-lowercase">xxxxxxxxxxxxx</span>
                          </div>
                        </div>
                      </td>
                      <td style="border-bottom: 1px solid #dee2e6;"><a onclick="changeinfo()" style="cursor:pointer;color:#472D2D;">Change</a></td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #dee2e6;">
                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-12">
                            Ship to
                          </div>
                          <div class="col-lg-10 col-md-10 col-sm-12">
                            <span class="address-span text-capitalize">xxxxxxxxxxxxxx</span>
                          </div>
                        </div>
                      </td>
                      <td style="border-bottom: 1px solid #dee2e6;"><a onclick="changeinfo()" style="cursor:pointer;color:#472D2D;">Change</a></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-12">
                            Method
                          </div>
                          <div class="col-lg-10 col-md-10 col-sm-12">
                            Standred. <span style="color: #333;font-weight:700;" class="mx-2">Free</span>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- step 3 end -->
            <h3 style="font-weight: 700;color: #1d1d1d;margin: 15px 0 10px;font-size: 20px;line-height: 16px;">Payment</h3>
            <p class="my-2">All transactions are secure and encrypted.</pc>
            <div class="discount-code-wrapper p-0">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="total-shipping">
                    <ul>
                      <li style="width:100%;padding: 20px 30px 20px;display: flex; align-items:baseline;">
                        <input type="radio" value="razorpay" class="checkbox-payment mx-2" id="payment_radio" name="checkbox-payment" checked="checked" value="razorpay">100% secure payment by Metamask. <span class="float-right"><img src="images/razorpay.png" width="150" height="auto"></span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-5">
              <h3 style="font-weight: 700;color: #1d1d1d;margin: 15px 0 10px;font-size: 20px;line-height: 16px;">Billing address</h3>
              <p class="my-2">Select the address that matches your card or payment method.</pc>
              <div class="discount-code-wrapper p-0">
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="total-shipping">
                      <div class="accordion" id="accordionExample">
                        <div class="card">
                          <div class="card-header p-0" id="headingOne">
                            <h2 class="mb-0">
                              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="box-shadow: none;text-decoration:none;width:100%;text-align:left;">
                                <input type="radio" value="0" class="checkbox-billing mx-2" id="billing_check1" name="checkbox-billing">Same as shipping address.
                              </button>
                            </h2>
                          </div>
                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header p-0" id="headingTwo">
                            <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="box-shadow: none;text-decoration:none;width:100%;text-align:left;">
                                <input type="radio" value="1" class="checkbox-billing mx-2" id="billing_check2" name="checkbox-billing">Use a different billing address.
                              </button>
                            </h2>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                              <div class="billing-info-wrap">
                                <div class="row">
                                  <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20px">
                                      <label for="">First Name</label>
                                      <input type="text" id="first_name2" value="<?php echo $row_first_name ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20px">
                                      <label for="">Last Name</label>
                                      <input type="text" id="last_name2" value="<?php echo $row_last_name ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-12">
                                    <div class="billing-info mb-20px">
                                      <label for="">Street Address</label>
                                      <input type="text" placeholder="House number and street name" class="billing-address" id="street_address2" value="<?php echo $row_address ?>">
                                      <input type="text" placeholder="Apartment, suite, unit etc." id="street_address_extra2" value="<?php echo $row_address2 ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-12">
                                    <div class="billing-info mb-20px">
                                      <label for="">Town / City</label>
                                      <input type="text" id="city2" value="<?php echo $row_city ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4">
                                    <div class="billing-select mb-20px">
                                      <label>Country</label>
                                      <select id="country2">
                                        <?php
                                        $selected1 = "";
                                        $selected2 = "";
                                        $selected3 = "";
                                        $selected4 = "";
                                        $selected5 = "";
                                        if ($row_country == "Azerbaijan") {
                                          $selected1 = "selected";
                                        } else if ($row_country == "Bahamas") {
                                          $selected2 = "selected";
                                        } else if ($row_country == "Bahrain") {
                                          $selected3 = "selected";
                                        } else if ($row_country == "Bangladesh") {
                                          $selected4 = "selected";
                                        } else if ($row_country == "Barbados") {
                                          $selected5 = "selected";
                                        }
                                        ?>
                                        <option value="">Select a country</option>
                                        <option value="Afganistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bonaire">Bonaire</option>
                                        <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canary Islands">Canary Islands</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Channel Islands">Channel Islands</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Island">Cocos Island</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote DIvoire">Cote DIvoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Curaco">Curacao</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Ter">French Southern Ter</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Great Britain">Great Britain</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="India" selected>India</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea North">Korea North</option>
                                        <option value="Korea Sout">Korea South</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Midway Islands">Midway Islands</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Nambia">Nambia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                        <option value="Nevis">Nevis</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau Island">Palau Island</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Phillipines">Philippines</option>
                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="St Barthelemy">St Barthelemy</option>
                                        <option value="St Eustatius">St Eustatius</option>
                                        <option value="St Helena">St Helena</option>
                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                        <option value="St Lucia">St Lucia</option>
                                        <option value="St Maarten">St Maarten</option>
                                        <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                        <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                        <option value="Saipan">Saipan</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Samoa American">Samoa American</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Tahiti">Tahiti</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                        <option value="United States of America">United States of America</option>
                                        <option value="Uraguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City State">Vatican City State</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                        <option value="Wake Island">Wake Island</option>
                                        <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zaire">Zaire</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4">
                                    <div class="billing-info mb-20px">
                                      <label for="">State / Country</label>
                                      <input type="text" id="state2" value="<?php echo $row_country ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4">
                                    <div class="billing-info mb-20px">
                                      <label for="">Postcode / Zip</label>
                                      <input type="text" id="postcode2" value="<?php echo $row_postcode ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20px">
                                      <label for="">Phone</label>
                                      <input type="text" id="phone2" value="<?php echo $row_phone ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20px">
                                      <label for="">Email</label>
                                      <input type="email" id="email2" value="">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-4 d-flex justify-content-center">
              <div class="col-lg-6 col-md-6 d-lg-block d-none">
                <div class="your-order-area">
                  <div class="Place-order mt-0">
                    <?php if (empty($_SESSION['eth_id'])) { ?>
                      <div toggle="modal" style="cursor:pointer; color: #472D2D;" id="place_order_step3"><a type="button" class="btn my-btn btn-hover" data-toggle="modal" onclick="userLoginOut()">
                          Pay Now</a></div>
                  </div>
                <?php } ?>
                <?php if (!empty($_SESSION['eth_id'])) { ?>
                  <div toggle="modal" data-target="#metamaskDonateModal" style="cursor:pointer; color: #472D2D;" id="place_order_step3"><a type="button" class="btn my-btn btn-hover" data-toggle="modal" data-target="#metamaskDonateModal">
                      Pay Now</a></div>
                </div>
              <?php } ?>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 text-center" style="padding: 18px 20px;">
              <a onclick="changeinfo()" style="cursor:pointer;color:#472D2D;">return to information</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- ------------------------ page end from here ------------------------- -->

  <!-- News letter area -->

  <!-- News letter area  End -->
  <!-- ------------------------ page end form here ------------------------- -->
  <!-- Footer Area Start -->
  <div class="footer-area">
    <div class="footer-container" style="background:#F8F8F8;">
      <div class="footer-top d-none d-lg-block">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-lg-6 mb-md-30px mb-lm-30px col-sm-6">
              <div class="single-wedge">
                <div class="footer-logo d-flex">
                  <a href="/"><img loading="lazy" class="img-responsive footer-img-size" src="  <?php echo $img_link ?>images/logo/logo.png" alt="logo.png" /></a>
                </div>
                <p class="text-infor" style="text-align: justify;">Dank thrift is an e-commerce store for thrift and second hand clothes. Our vision is to create a more sustainable fashion economy by making second-hand fashion inventory transparent and circular, one wardrobe at a time!</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6 mb-md-30px mb-lm-30px">
              <div class="single-wedge">
                <div class="footer-widget widget  text-center-mobile">
                  <h4 class="text-uppercase"><i class="ion-home"></i> Office Address</h4>
                  <p class="text-justify  text-center-mobile"> Next57 Coworking, 3rd Floor<br>Plot No. 57, Industrial Area Phase I<br>Chandigarh, 160002</p>
                  <div class="social-media" style="text-decoration: none;">
                    <p class=" text-center-mobile">
                      <a href="https://www.google.com/search?ei=z2UYXdXWGIq6rQGWzp_YCg&amp;q=quadb+creations&amp;oq=quad&amp;gs_l=psy-ab.3.2.35i39l2j0i67l2j0l6.2825.3302..5468...0.0..0.165.602.0j4......0....1..gws-wiz.-oR7-X_p75c" target="_blank"><i class="ion-android-globe" style="margin-right: 5px;"></i> Dank Thrift</a>
                    </p>
                    <p class=" text-center-mobile">
                      <a href="https://wa.me/917717303372/?text=Hey+Fellas%2C%0D%0ACan+you+help+me+to+order+some+really+cool+merchandise+from+QuadB%3F" target="_blank"><i class="ion-social-whatsapp" style="margin-right: 5px;"></i> +91-81712 80077</a>
                    </p>
                    <p class=" text-center-mobile">
                      <a href="tel:+918146550542" target="_blank"><i class="ion-android-call" style="margin-right: 5px;"></i> +91-81712 80077</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-center d-none d-lg-block">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="footer-paymet-warp d-flex">
                <div class="heading-info">Payment:</div>
                <div class="payment-way"><img loading="lazy" class="payment-img img-responsive" src="  <?php echo $img_link ?>images/icons/payment.png" alt="" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="footer-social-icon d-flex">
                <div class="heading-info">Follow Us:</div>
                <div class="social-icon">
                  <ul>
                    <!-- <li class="facebook">
                      <a href="https://www.facebook.com/quadbapparels/"><i class="ion-social-facebook"></i></a>
                    </li>
                    <li class="twitter">
                      <a href="https://twitter.com/quadbcreations"><i class="ion-social-twitter"></i></a>
                    </li>
                    <li class="google">
                      <a href="https://www.linkedin.com/company/quadb" class><i class="ion-social-linkedin"></i></a>
                    </li> -->
                    <li class="instagram">
                      <a href="https://www.instagram.com/dank_thrift/"><i class="ion-social-instagram"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-tags">
        <div class="container">
          <div class="row">
            <div class="col-md-12 d-none d-lg-block">
              <div class="tag-content">
                <ul class="text-capitalize">
                  <li><a href="/">Home</a></li>
                  <li><a href="shop-left-sidebar.php">shop</a></li>
                  <li><a href="about">about</a></li>
                  <li><a href="contact">contact</a></li>
                  <li><a href="https://www.instagram.com/dank_thrift/" target="_blank">facebook</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-12 text-center d-none d-lg-block">
              <p class="copy-text">Copyright © <a href="/"> Dank Thrift</a>. All Rights Reserved</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer Area End -->
  <!-- fixed button start-->
  <div class="slider-menumob d-lg-none d-md-none" data-purpose="slider-menumob" style="align-items: center;background-color: #fff;box-shadow: 0 -2px 4px rgba(0,0,0,.08), 0 -4px 12px rgba(0,0,0,.08);display: flex;flex-direction: row;overflow-y: hidden;padding: 8px 16px;position: fixed;bottom: 0;left: 0;right: 0;width: 100%;z-index: 1000;">
    <div class="container-fluid justify-content-center" style="padding:0px;">
      <div class="row">
        <div class="col-12">
          <button type="button" class="font-barlow-m add-to-cart buybtnchk btn" style="color: #fff;background-color:#472D2D;width: 100%;font-size:14px;padding:13px 20px;text-transform:uppercase;font-weight:700;" onclick="firststep()">Continue to shipping</button>
        </div>
      </div>
    </div>
  </div>
  <div class="slider-menumob2 d-lg-none d-md-none" data-purpose="slider-menumob" style="align-items: center;background-color: #fff;box-shadow: 0 -2px 4px rgba(0,0,0,.08), 0 -4px 12px rgba(0,0,0,.08);display: flex;flex-direction: row;overflow-y: hidden;padding: 8px 16px;position: fixed;bottom: 0;left: 0;right: 0;width: 100%;z-index: 1000;display:none;">
    <div class="container-fluid justify-content-center" style="padding:0px;">
      <div class="row">
        <div class="col-12">
          <button type="button" class="font-barlow-m add-to-cart buybtnchk btn" style="color: #fff;background-color:#472D2D;width: 100%;font-size:14px;padding:13px 20px;text-transform:uppercase;font-weight:700;" id="buynow2" onclick="secondstep()">Continue to Payment</button>
        </div>
      </div>
    </div>
  </div>
  <div class="slider-menumob3 d-lg-none d-md-none" data-purpose="slider-menumob" style="align-items: center;background-color: #fff;box-shadow: 0 -2px 4px rgba(0,0,0,.08), 0 -4px 12px rgba(0,0,0,.08);display: flex;flex-direction: row;overflow-y: hidden;padding: 8px 16px;position: fixed;bottom: 0;left: 0;right: 0;width: 100%;z-index: 1000;display:none;">
    <div class="container-fluid justify-content-center" style="padding:0px;">
      <div class="row">
        <div class="col-12">
          <button type="button" class="font-barlow-m add-to-cart buybtnchk btn pay-button" style="color: #fff;background-color:#472D2D;width: 100%;font-size:14px;padding:13px 20px;text-transform:uppercase;font-weight:700;" id="buynow2">Pay Now</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="metamaskDonateModal" tabindex="-1" role="dialog" aria-labelledby="metamaskDonateModalLabel" aria-hidden="true" style="background:rgba(0,0,0, .2);">
    <div class="modal-dialog modal-dialog-centered modal-flex" role="document">
      <div class="modal-content center modal-md mx-5 setModalStyle" style="background:rgb(246,246,246); width:500px">
        <div class="modal-header d-flex justify-content-between align-items-center" style="color:var(--text-color)">
          <h5 class="modal-title" id="metamaskDonateModalLabel">Payment</h5>
          <button type="button" class="close-modal btn p-0 m-0 px-2 btn btn-hover" data-bs-dismiss="modal" aria-label="Close"><i class="ri-2x ri-close-fill"></i></button>
        </div>
        <div class="modal-body" style="background:var(--primary-color);border-radius:0 0 15px 15px;">
          <?php
          $metafrom = $_SESSION['eth_id'];
          $metato = '0x49E8883B30c482ADE14488Fd00A6622c9377C366';
          ?>
          <div class="row g-3 mb-3">
            <div class="col-12">
              <div class="form-group">
                <label class="my-2" for=" amount" style="color:var(--text-color);">Select network chain
                  to
                  pay
                  in</label>
                <select class="form-control story-input p-2 currencyField" onchange="selectChain()" id="selectNetworkChain">
                  <option value="">Select chain</option>
                  <option value="ethereum">ETH</option>
                  <option value="matic-network">MATIC</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row g-3" id="donateArea" style="display:none;">
            <div class=" col-lg-6 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="amount" style="color:var(--text-color);">Amount (in rupee)</label>
                <!-- <input type="number" required min="0" oninput="validity.valid||(value='');" class="form-control story-input p-2 currencyField" class="currencyField"   required /> -->
                <input type="number" required min="0" oninput="validity.valid||(value='');" value="<?= $net_amount ?>" class="form-control story-input p-2 currencyField" class="currencyField" id="price" name="usd" id="dollar_amount" readonly />
                <!-- <input type="number" name="usd" id="dollar_amount" value="<?= $net_amount ?>" class="form-control"> -->
                <input type="hidden" class="metato" id="metato" value="<?php echo $metato; ?>">
                <input type="hidden" class="metafrom" id="metafrom" value="<?php echo $metafrom; ?>">
              </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="price" style="color:var(--text-color);">Amount (in
                  <span id="price_lable">celo</span>)</label>
                <input type="number" required min="0" oninput="validity.valid||(value='');" class="form-control story-input p-2 currencyField" class="currencyField" id="price" name="eth" required readonly />
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="d-flex justify-content-center align-items-center mt-3 mb-2">
                <button class="pay-button btn my-btn">Pay Now</button>
              </div>
              <div class="message text-muted"></div>
            </div>
          </div>
          <small style="font-size:12px;">
            <b>Note:</b>&nbsp;Your selected network must be add in your metamask,to add network chain in
            your
            metamask
            you
            can visit on <a href="https://chainlist.org/" target="_blank">chainlist</a>.
          </small>
        </div>
      </div>
    </div>
  </div>

  <!-- fixed button end-->
  <!-- JS
============================================ -->
  <script src="js/vendor.min.js"></script>
  <script src="js/slick.min.js"></script>

  <!-- Main Activation JS -->
  <script src="js/main.js"></script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script src="https://unpkg.com/@metamask/legacy-web3@latest/dist/metamask.web3.min.js"></script>
  <script src="js/new.js"></script>

  <!-- new code start here 2022-->
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script> -->
  <script type="text/javascript" src="https://unpkg.com/web3modal@1.9.7/dist/index.js"></script>
  <script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.7.8/dist/umd/index.min.js">
  </script>
  <script src="./frontend/web3-login.js?v=009">
  </script>
  <script src="./frontend/web3-modal.js?v=001"></script>
  <!-- new code end here 2022 -->

  <script>
    /* ----------------------------- order-id generator start----------------------------- */
    // function guid() {
    //     function s4() {
    //         return Math.floor((1 + Math.random()) * 0x10000)
    //             .toString(16)
    //             .substring(1);
    //     }
    //     return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    //         s4() + '-' + s4() + s4() + s4();
    // }
    // var customer_order_id = guid();
    var customer_order_id = '';
    /* ----------------------------- order-id generator end----------------------------- */
    var shipping_address = 0;
    /* --------------------------- registration start --------------------------- */
    // var status = 0;
    // if ($('input.checkout-toggle2').prop('checked')) {
    //     // $("input.checkout-toggle2").is("click", function() {
    //     status = 1;
    // };
    var product_details = [];

    function windowCheck() {
      width = $(window).width();
      if ($(window).width() > 991) {
        var order_name = document.getElementsByClassName('order_name');
        var order_quantity = document.getElementsByClassName('order_quantity');
        var order_image = document.getElementsByClassName('order_image');
        var order_per_price = document.getElementsByClassName('order_per_price');
        var order_amount = document.getElementsByClassName('order_amount');
        var order_id = document.getElementsByClassName('order_id');
        var product_sku = document.getElementsByClassName('product_sku');
        product_details = "";
        for (i = 0; i < order_name.length; ++i) {
          product_details += order_name[i].value + "__" + order_quantity[i].value + "__" + order_image[i].value + "__" +
            order_amount[i].value + "__" + order_id[i].value + "__" + order_per_price[i].value + "__" + product_sku[i].value + ",";
        }
      } else if ($(window).width() <= 991) {
        var order_name = document.getElementsByClassName('order_name2');
        var order_quantity = document.getElementsByClassName('order_quantity2');
        var order_image = document.getElementsByClassName('order_image2');
        var order_per_price = document.getElementsByClassName('order_per_price2');
        var order_amount = document.getElementsByClassName('order_amount2');
        var order_id = document.getElementsByClassName('order_id2');
        var product_sku = document.getElementsByClassName('product_sku2');
        product_details = "";
        for (i = 0; i < order_name.length; ++i) {
          product_details += order_name[i].value + "__" + order_quantity[i].value + "__" + order_image[i].value + "__" +
            order_amount[i].value + "__" + order_id[i].value + "__" + order_per_price[i].value + "__" + product_sku[i].value + ",";
        }
      }

    }
    windowCheck();
    $(window).resize(function() {
      windowCheck();
    });
    // console.log(product_details);
    // var order_name = document.getElementsByClassName('order_name');
    // var order_quantity = document.getElementsByClassName('order_quantity');
    // var order_image = document.getElementsByClassName('order_image');
    // var order_per_price = document.getElementsByClassName('order_per_price');
    // var order_amount = document.getElementsByClassName('order_amount');
    // var order_id = document.getElementsByClassName('order_id');
    // var product_sku = document.getElementsByClassName('product_sku');
    // var product_details = "";
    // for (i = 0; i < order_name.length; ++i) {
    //     product_details += order_name[i].value + "__" + order_quantity[i].value + "__" + order_image[i].value + "__" +
    //         order_amount[i].value + "__" + order_id[i].value + "__" + order_per_price[i].value + "__" + product_sku[i].value + ",";
    // }
    //  console.log(product_details);
    // console.log(product_details); 
    var product_total_price = document.getElementById('total_amount_price').innerHTML;
    var total_shipping_charge = 0;
    var payment_price = parseFloat(product_total_price);
    var payment_shipping = 0;
    var error = "";
    var email = '';
    var first_name = '';
    var last_name = '';
    var company = "";
    var country = '';
    var street_address = '';
    var street_address_extra = '';
    var city = '';
    var state = '';
    var postcode = '';
    var phone = '';
    //  console.log(payment_price); 
    // self test start
    function firststep() {
      error = "";
      password = $("#password").val();
      confirm_password = $("#confirm_password").val();
      first_name = $("#first_name").val();
      last_name = $("#last_name").val();
      company = "null";
      country = $("#country").val();
      street_address = $("#street_address").val();
      street_address_extra = $("#street_address_extra").val();
      city = $("#city").val();
      state = $("#state").val();
      postcode = $("#postcode").val();
      phone = $("#phone").val();
      email = $("#email").val();

      function validateEmail(email) {
        var re =
          /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
      }
      if (phone == "") {
        $("#phone").css('border-color', 'red');
        $("#phone").css('border-width', '2px');
        error = error + 'phone' + ' ';
      } else {
        $("#phone").css('border-color', '#C0BBBB');
        $("#phone").css('border-width', '1px');
      }
      if (phone.length != 10) {
        $("#phone").css('border-color', 'red');
        $("#phone").css('border-width', '2px');
        error = error + 'phone' + ' ';
      } else {
        $("#phone").css('border-color', '#C0BBBB');
        $("#phone").css('border-width', '1px');
      }
      if (!validateEmail(email)) {
        $("#email").css('border-color', 'red');
        $("#email").css('border-width', '2px');
        error = error + 'email' + ' ';
      } else {
        $("#email").css('border-color', '#C0BBBB');
        $("#email").css('border-width', '1px');
      }
      if (first_name == "") {
        $("#first_name").css('border-color', 'red');
        $("#first_name").css('border-width', '2px');
        error = error + 'first_name' + ' ';
      } else {
        $("#first_name").css('border-color', '#C0BBBB');
        $("#first_name").css('border-width', '1px');
      }
      if (last_name == "") {
        $("#last_name").css('border-color', 'red');
        $("#last_name").css('border-width', '2px');
        error = error + 'last_name' + ' ';
      } else {
        $("#last_name").css('border-color', '#C0BBBB');
        $("#last_name").css('border-width', '1px');
      }
      if (country == "") {
        $("#country").css('border-color', 'red');
        $("#country").css('border-width', '2px');
        error = error + 'country' + ' ';
      } else {
        $("#country").css('border-color', '#C0BBBB');
        $("#country").css('border-width', '1px');
      }
      if (street_address == "") {
        $("#street_address").css('border-color', 'red');
        $("#street_address").css('border-width', '2px');
        error = error + 'street_address ' + ' ';
      } else {
        $("#street_address").css('border-color', '#C0BBBB');
        $("#street_addresss").css('border-width', '1px');
      }
      if (street_address_extra == "") {
        $("#street_address_extra").css('border-color', 'red');
        $("#street_address_extra").css('border-width', '2px');
        error = error + 'street_address_extra' + ' ';
      } else {
        $("#street_address_extra").css('border-color', '#C0BBBB');
        $("#street_address_extra").css('border-width', '1px');
      }
      if (city == "") {
        $("#city").css('border-color', 'red');
        $("#city").css('border-width', '2px');
        error = error + 'city' + ' ';
      } else {
        $("#city").css('border-color', '#C0BBBB');
        $("#city").css('border-width', '1px');
      }
      if (state == "") {
        $("#state").css('border-color', 'red');
        $("#state").css('border-width', '2px');
        error = error + 'state' + ' ';
      } else {
        $("#state").css('border-color', '#C0BBBB');
        $("#state").css('border-width', '1px');
      }
      if (postcode == "") {
        $("#postcode").css('border-color', 'red');
        $("#postcode").css('border-width', '2px');
        error = error + 'state' + ' ';
      } else {
        $("#postcode").css('border-color', '#C0BBBB');
        $("#postcode").css('border-width', '1px');
      }
      if (error == "") {
        $('.slider-menumob').css('display', 'none');
        $('.slider-menumob2').css('display', 'block');
        $('.slider-menumob3').css('display', 'none');
        $('.contact-span').html(email);
        $('.address-span').html(first_name + ' ' + last_name + ',' + street_address + ',' + street_address_extra + ',' + state + ',' + postcode + ',' + country);
        $('.contact-info-show').css('display', 'none');
        $('.payment-info-show').css('display', 'none');
        $('.shipping-info-show').css('display', 'block');
      } else {
        alert("Error in " + error);
      }
      $('.total_shipping_charge').html('Free');
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
    // $('#place_order_step1').click(function() {

    // });
    $('.slider-menumob').css('display', 'block');
    $('.slider-menumob2').css('display', 'none');
    $('.slider-menumob3').css('display', 'none');

    function secondstep() {
      var shipping_method = $('input[name=checkbox-shipping]:checked').val();
      if (shipping_method !== '') {
        $('.slider-menumob').css('display', 'none');
        $('.slider-menumob2').css('display', 'none');
        $('.slider-menumob3').css('display', 'block');
        $('.contact-info-show').css('display', 'none');
        $('.shipping-info-show').css('display', 'none');
        $('.payment-info-show').css('display', 'block');
      }
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
    // $('#place_order_step2').click(function() {

    // });
    // self test end  


    // Select Chain code Start Here
    function selectChain() {
      var chain = $('#selectNetworkChain').val();
      // $('#dollar_amount').val('');
      // $('#price').val('');
      if (chain || (chain !== '')) {
        $('#donateArea').css('display', 'flex');
      } else {
        $('#donateArea').css('display', 'none');
      }
      if (window.ethereum.networkVersion && chain) {
        console.log(window.ethereum.networkVersion, chain);
        $('#chooseChain').val(chain);
        abcnew(chain);
      }

      // var dollar_amount = $("#dollar_amount").val();
      var dollar_amount = parseFloat($("input[value=<?= $net_amount ?>]").val());
      var ethereum_amount = $("#price").val();
      let convFrom;
      if ($(this).prop("name") == "usd") {
        convFrom = "usd";
        convTo = "eth";
      } else {
        convFrom = "eth";
        convTo = "usd";
      }
      $.getJSON(`https://api.coingecko.com/api/v3/coins/markets?vs_currency=inr&ids=${chain}`,

        function(data) {
          console.log("Data = ", data)
          // var origAmount = parseFloat($("input[name='" + convFrom + "']").val());
          var origAmount = dollar_amount;
          var exchangeRate = parseFloat(data[0].current_price);
          let amount;
          if (convFrom == "usd")
            amount = parseFloat(origAmount * exchangeRate);
          else
            amount = parseFloat(origAmount / exchangeRate);
          $("input[name='" + "eth" + "']").val(amount.toFixed(5));
          console.log(amount)
          if (convFrom == "usd")
            price.innerHTML = amount
          else
            dollar_amount.innerHTML = amount
        });
    }
    // Select Chain code End Here

    /* ------------------------ switch network code start ----------------------- */
    async function abcnew(chainValue) {
      var chainId = "4" // Ethereum Testnet
      var HexchainId = "0x4"; // Hex Ethereum Testnet
      var coinSymble = 'ETH';

      if (chainValue === "ethereum") {
        chainId = "4"; // Ethereum Testnet
        HexchainId = "0x4"; // Hex Ethereum Testnet
        coinSymble = 'ETH';
      } else if (chainValue === "binancecoin") {
        chainId = "97"; // BNB Testnet
        HexchainId = "0x61"; // Hex BNB Testnet
        coinSymble = 'BNB';
      } else if (chainValue === "celo") {
        chainId = "44787"; // CELO Testnet
        HexchainId = "0xAEF3"; // Hex CELO Testnet
        coinSymble = 'CELO';
      } else if (chainValue === "fantom") {
        chainId = "4002"; // FANTOM Testnet
        HexchainId = "0xFA2"; // Hex FANTOM Testnet
        coinSymble = 'FTM';
      } else if (chainValue === "avalanche-2") {
        chainId = "43113"; // AVAX Testnet
        HexchainId = "0xA869"; // Hex AVAX Testnet
        coinSymble = 'AVAX';
      } else if (chainValue === "klay-token") {
        chainId = "1001"; // KLAY Testnet
        HexchainId = "0x3E9"; // Hex KLAY Testnet
        coinSymble = 'KLAY';
      }
      // else if (chainValue === "matic-network") {
      //   chainId = "137"; // MATIC Testnet
      //   HexchainId = "0x89"; // Hex MATIC Testnet
      //   coinSymble = 'MATIC';
      // }
      else if (chainValue === "matic-network") {
        chainId = "80001"; // MATIC Testnet
        HexchainId = "0x13881"; // Hex MATIC Testnet
        coinSymble = 'MATIC';
      } else {
        chainId = "4"; // Ethereum Testnet
        HexchainId = "0x4"; // Hex Ethereum Testnet
        coinSymble = 'ETH';
      }
      $('#price_lable').text(coinSymble);
      let chain = coinSymble;
      if (window.ethereum.networkVersion !== chainId) {
        try {
          await window.ethereum.request({
            method: 'wallet_switchEthereumChain',
            params: [{
              chainId: HexchainId,
            }],
          });
        } catch (err) {
          console.log(err);
        }
      }
    }
    /* ------------------------ switch network code end ----------------------- */

    window.addEventListener('load', async () => {
      if (window.ethereum) {
        window.web3 = new Web3(ethereum);
        try {
          await ethereum.enable();
          initPayButton()
        } catch (err) {
          $('#status').html('User denied account access', err)
        }
      } else if (window.web3) {
        window.web3 = new Web3(web3.currentProvider)
        initPayButton()
      } else {
        $('#status').html('No Metamask (or other Web3 Provider) installed')
      }
    });



    var eth_pay_id = '';
    var eth_amount = '';
    var eth_pay_status = '';
    const initPayButton = () => {
      $('.pay-button').click(() => {
        payment_price = parseFloat($('.original_price').val());
        coupon_code_discount = document.getElementById('discount').innerHTML;
        // alert(coupon_code_discount);
        var checkout_method = $('input[name=checkbox-payment]:checked').val();
        var checkout_billing = $('input[name=checkbox-billing]:checked').val();
        var error = "";
        var first_name2 = '';
        var last_name2 = '';
        var company2 = '';;
        var country2 = '';
        var street_address2 = '';
        var street_address_extra2 = '';
        var city2 = '';
        var state2 = '';
        var postcode2 = '';
        var phone2 = '';
        var email2 = '';
        if (checkout_method !== '') {
          $('.contact-info-show').css('display', 'none');
          $('.shipping-info-show').css('display', 'none');
          $('.payment-info-show').css('display', 'block');
        }
        if (checkout_billing === '0') {
          shipping_address = 0;
          if (first_name2 == "") {
            first_name2 = first_name;
          }
          if (last_name2 == "") {
            last_name2 = last_name;
          }
          if (company2 == "") {
            company2 = company;
          }
          if (country2 == "") {
            country2 = country;
          }
          if (street_address2 == "") {
            street_address2 = street_address;
          }
          if (street_address_extra2 == "") {
            street_address_extra2 = street_address_extra;
          }
          if (city2 == "") {
            city2 = city;
          }
          if (state2 == "") {
            state2 = state;
          }
          if (postcode2 == "") {
            postcode2 = postcode;
          }
          if (phone2 == "") {
            phone2 = phone;
          }
          if (email2 == "") {
            email2 = email;
          }
        } else if (checkout_billing === '1') {
          shipping_address = 1;
          first_name2 = $("#first_name2").val();
          last_name2 = $("#last_name2").val();
          company2 = "null";
          country2 = $("#country2").val();
          street_address2 = $("#street_address2").val();
          street_address_extra2 = $("#street_address_extra2").val();
          city2 = $("#city2").val();
          state2 = $("#state2").val();
          postcode2 = $("#postcode2").val();
          phone2 = $("#phone2").val();
          email2 = $("#email2").val();

          function validateEmail(email) {
            var re =
              /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
          }
          if (phone2 == "") {
            $("#phone2").css('border-color', 'red');
            $("#phone2").css('border-width', '2px');
            error = error + 'phone2' + ' ';
          } else {
            $("#phone2").css('border-color', '#C0BBBB');
            $("#phone2").css('border-width', '1px');
          }
          if (phone2.length != 10) {
            $("#phone2").css('border-color', 'red');
            $("#phone2").css('border-width', '2px');
            error = error + 'phone2' + ' ';
          } else {
            $("#phone2").css('border-color', '#C0BBBB');
            $("#phone2").css('border-width', '1px');
          }
          if (!validateEmail(email2)) {
            $("#email2").css('border-color', 'red');
            $("#email2").css('border-width', '2px');
            error = error + 'email2' + ' ';
          } else {
            $("#email2").css('border-color', '#C0BBBB');
            $("#email2").css('border-width', '1px');
          }
          if (first_name2 == "") {
            $("#first_name2").css('border-color', 'red');
            $("#first_name2").css('border-width', '2px');
            error = error + 'first_name2' + ' ';
          } else {
            $("#first_name2").css('border-color', '#C0BBBB');
            $("#first_name2").css('border-width', '1px');
          }
          if (last_name2 == "") {
            $("#last_name2").css('border-color', 'red');
            $("#last_name2").css('border-width', '2px');
            error = error + 'last_name2' + ' ';
          } else {
            $("#last_name2").css('border-color', '#C0BBBB');
            $("#last_name2").css('border-width', '1px');
          }
          if (country2 == "") {
            $("#country2").css('border-color', 'red');
            $("#country2").css('border-width', '2px');
            error = error + 'country2' + ' ';
          } else {
            $("#country2").css('border-color', '#C0BBBB');
            $("#country2").css('border-width', '1px');
          }
          if (street_address2 == "") {
            $("#street_address2").css('border-color', 'red');
            $("#street_address2").css('border-width', '2px');
            error = error + 'street_address2 ' + ' ';
          } else {
            $("#street_address2").css('border-color', '#C0BBBB');
            $("#street_address2").css('border-width', '1px');
          }
          if (street_address_extra2 == "") {
            $("#street_address_extra2").css('border-color', 'red');
            $("#street_address_extra2").css('border-width', '2px');
            error = error + 'street_address_extra2' + ' ';
          } else {
            $("#street_address_extra2").css('border-color', '#C0BBBB');
            $("#street_address_extra2").css('border-width', '1px');
          }
          if (city2 == "") {
            $("#city2").css('border-color', 'red');
            $("#city2").css('border-width', '2px');
            error = error + 'city2' + ' ';
          } else {
            $("#city2").css('border-color', '#C0BBBB');
            $("#city2").css('border-width', '1px');
          }
          if (state2 == "") {
            $("#state2").css('border-color', 'red');
            $("#state2").css('border-width', '2px');
            error = error + 'state2' + ' ';
          } else {
            $("#state2").css('border-color', '#C0BBBB');
            $("#state2").css('border-width', '1px');
          }
          if (postcode2 == "") {
            $("#postcode2").css('border-color', 'red');
            $("#postcode2").css('border-width', '2px');
            error = error + 'postcode2' + ' ';
          } else {
            $("#postcode2").css('border-color', '#C0BBBB');
            $("#postcode2").css('border-width', '1px');
          }
        } else {

        }

        // var shipping_charge = $("#product_quantity").val(); 
        var shipping_charge = total_shipping_charge;

        function validateEmail(email) {
          var re =
            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(String(email).toLowerCase());
        }
        if (phone == "") {
          $("#phone").css('border-color', 'red');
          $("#phone").css('border-width', '2px');
          error = error + 'phone' + ' ';
        } else {
          $("#phone").css('border-color', '#C0BBBB');
          $("#phone").css('border-width', '1px');
        }
        if (phone.length != 10) {
          $("#phone").css('border-color', 'red');
          $("#phone").css('border-width', '2px');
          error = error + 'phone' + ' ';
        } else {
          $("#phone").css('border-color', '#C0BBBB');
          $("#phone").css('border-width', '1px');
        }
        if (!validateEmail(email)) {
          $("#email").css('border-color', 'red');
          $("#email").css('border-width', '2px');
          error = error + 'email' + ' ';
        } else {
          $("#email").css('border-color', '#C0BBBB');
          $("#email").css('border-width', '1px');
        }
        if (first_name == "") {
          $("#first_name").css('border-color', 'red');
          $("#first_name").css('border-width', '2px');
          error = error + 'first_name' + ' ';
        } else {
          $("#first_name").css('border-color', '#C0BBBB');
          $("#first_name").css('border-width', '1px');
        }
        if (last_name == "") {
          $("#last_name").css('border-color', 'red');
          $("#last_name").css('border-width', '2px');
          error = error + 'last_name' + ' ';
        } else {
          $("#last_name").css('border-color', '#C0BBBB');
          $("#last_name").css('border-width', '1px');
        }
        if (country == "") {
          $("#country").css('border-color', 'red');
          $("#country").css('border-width', '2px');
          error = error + 'country' + ' ';
        } else {
          $("#country").css('border-color', '#C0BBBB');
          $("#country").css('border-width', '1px');
        }
        if (street_address == "") {
          $("#street_address").css('border-color', 'red');
          $("#street_address").css('border-width', '2px');
          error = error + 'street_address ' + ' ';
        } else {
          $("#street_address").css('border-color', '#C0BBBB');
          $("#street_addresss").css('border-width', '1px');
        }
        if (street_address_extra == "") {
          $("#street_address_extra").css('border-color', 'red');
          $("#street_address_extra").css('border-width', '2px');
          error = error + 'street_address_extra' + ' ';
        } else {
          $("#street_address_extra").css('border-color', '#C0BBBB');
          $("#street_address_extra").css('border-width', '1px');
        }
        if (city == "") {
          $("#city").css('border-color', 'red');
          $("#city").css('border-width', '2px');
          error = error + 'city' + ' ';
        } else {
          $("#city").css('border-color', '#C0BBBB');
          $("#city").css('border-width', '1px');
        }
        if (state == "") {
          $("#state").css('border-color', 'red');
          $("#state").css('border-width', '2px');
          error = error + 'state' + ' ';
        } else {
          $("#state").css('border-color', '#C0BBBB');
          $("#state").css('border-width', '1px');
        }
        if (postcode == "") {
          $("#postcode").css('border-color', 'red');
          $("#postcode").css('border-width', '2px');
          error = error + 'state' + ' ';
        } else {
          $("#postcode").css('border-color', '#C0BBBB');
          $("#postcode").css('border-width', '1px');
        }
        if (error == "") {
          $.ajax({
            type: 'POST',
            url: 'php/checkout_form',
            dataType: "json",
            data: {
              'email': email,
              'account_id': $('#account_id').val(),
              'phone': phone,
              'password': password,
              'first_name': first_name,
              'last_name': last_name,
              'company': company,
              'country': country,
              'street_address': street_address,
              'street_address_extra': street_address_extra,
              'city': city,
              'state': state,
              'postcode': postcode,
              'additional_information': '',
              'email2': email2,
              'phone2': phone2,
              'first_name2': first_name2,
              'last_name2': last_name2,
              'company2': company2,
              'country2': country2,
              'street_address2': street_address2,
              'street_address_extra2': street_address_extra2,
              'city2': city2,
              'state2': state2,
              'postcode2': postcode2,
              'product_details': product_details,
              'shipping_charge': 0,
              'product_total_price': payment_price,
              'eventname': "Payment",
              'shipping_address': shipping_address,
              // 'order_id': customer_order_id,
              'coupon_code_discount': coupon_code_discount
            },
            success: function(data) {
              var chain = $('#selectNetworkChain').val();
              console.log(chain)
              /* ----------------------------- eth payemnt code start ----------------------------- */
              // api url
              const api_url = `https://api.coingecko.com/api/v3/simple/price?ids=${chain}&vs_currencies=inr`;
              // const api_url = "https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=usd";
              // Defining async function
              async function getapi(url, chain) {
                // Storing response
                const response = await fetch(url);
                // Storing data in form of JSON
                var data = await response.json();
                // console.log(data['ethereum'].usd))
                // return data.ethereum.usd;
                if (chain == "ethereum") {
                  return data.ethereum.inr;
                } else {
                  return data['matic-network'].inr;
                }
              }
              async function asyncCall(api_url, chain) {
                console.log('calling');
                const result = await getapi(api_url, chain);
                const change_price = (1 / result) * payment_price;
                // const change_price = 0.00001;
                const paymentAddress = '0x0412c0D08aE2be93bf4Ef97f5E5256e69CaC4795';
                const amountEth = (change_price).toFixed(6);
                eth_amount = amountEth;
                console.log(result);
                console.log(change_price);
                // expected output: "resolved"
                web3.eth.sendTransaction({
                  to: paymentAddress,
                  value: web3.toWei(amountEth, 'ether')
                }, (err, transactionId) => {
                  if (err) {
                    console.log('Payment failed', err);
                    // $('#status').html('Payment failed');
                    eth_pay_id = err;
                    eth_pay_status = 'Payment failed';
                    alert(err.message);
                  } else {
                    console.log('Payment successful', transactionId);
                    eth_pay_id = transactionId;
                    eth_pay_status = 'Payment successful';
                    // $('#status').html('Payment successful');
                    setPayment(eth_pay_id, eth_amount, eth_pay_status);
                  }
                });
              }
              asyncCall(api_url, chain);
              /* -------------------------- eth payment code end -------------------------- */
              function setPayment(eth_pay_id, eth_amount, eth_pay_status, ) {
                $('#loading').css('display', 'block');
                /* ---------------------------------- checkout-update-form start--------------------------------- */
                var status_id = data.id;
                $.ajax({
                  type: 'POST',
                  url: 'php/checkout-update-form.php',
                  dataType: "json",
                  data: {
                    id: data.id,
                    razorpay_payment_id: eth_pay_id,
                    email: email,
                    capture_status: eth_pay_status,
                    'chain': chain,
                    'phone': phone,
                    'first_name': first_name,
                    'last_name': last_name,
                    'company': company,
                    'country': country,
                    'street_address': street_address,
                    'street_address_extra': street_address_extra,
                    'city': city,
                    'state': state,
                    'postcode': postcode,
                    'additional_information': '',
                    'email2': email2,
                    'phone2': phone2,
                    'first_name2': first_name2,
                    'last_name2': last_name2,
                    'company2': company2,
                    'country2': country2,
                    'street_address2': street_address2,
                    'street_address_extra2': street_address_extra2,
                    'city2': city2,
                    'state2': state2,
                    'postcode2': postcode2,
                    'product_details': product_details,
                    'shipping_charge': 0,
                    'product_total_price': eth_amount,
                    'eventname': "Payment",
                    'shipping_address': shipping_address,
                    'order_id': customer_order_id,
                    'coupon_code_discount': coupon_code_discount,
                    'product_size': $('#product_size').val()
                  },
                  success: function(data) {
                    if (data.status == 'ok') {
                      window.dataLayer = window.dataLayer || [];
                      window.dataLayer.push({
                        'event': 'payment success',
                        'name': first_name,
                        'phone': phone,
                        'email': email
                      });
                      $.ajax({
                        type: 'POST',
                        url: 'php/clear_cookies.php',
                        dataType: "json",
                        data: {
                          'clear_cookies': "clear_cookies",
                          'status_id': status_id
                        },
                        success: function(
                          data
                        ) {
                          // console.log(data);
                          if (data.status == 201) {
                            $('#loading').css('display', 'none');
                            window.location.replace("thankyou.php");
                          } else {
                            console.log(data.error);
                            //     alert("problem with query");
                          }
                        }
                      });
                    } else {
                      console.log("error");
                    }
                  }
                });
              }
              ///* --------------------------- capture code end --------------------------- */
            }
          });
        } else {
          alert("Error in " + error);
        }
      });
    };
    /* --------------------------- logout code start --------------------------- */
    $('.logout').click(function() {
      var logout_var = 'logout';
      $.ajax({
        type: 'POST',
        url: 'php/logout.php',
        dataType: "json",
        data: {
          'logout_var': logout_var
        },
        success: function(data) {
          // console.log(data);
          if (data.status == 201) {
            window.location.replace('/');
          } else {
            console.log(data.error);
            //     alert("problem with query");
          }
        }
      });
    });

    /* --------------------------- logout code end --------------------------- */

    /* --------------------- news letter functionality start -------------------- */
    $('#desktop_newsletter').click(function() {

      var email = $("#footer-subscribe-email_desktop").val();
      var error = "";

      function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
      }
      if (!validateEmail(email)) {
        $('#desktop_newsletter_success').css('display', 'block');
        $('#desktop_newsletter_success').html('Please Enter valid email id !');
        error = error + 'email';
      } else {
        $('#desktop_newsletter_success').css('display', 'none');
      }
      if (error == "") {
        $('.subscribe_preloader').css('display', 'block');
        $.ajax({
          type: 'POST',
          url: 'php/newsletter.php',
          dataType: "json",
          data: {
            'email': email
          },
          success: function(data) {
            console.log(data);
            if (data.status == 201) {

              $('#desktop_newsletter_success').css('display', 'block');
              $('#desktop_newsletter_success').html(data.error);
            } else if (data.status == 601) {
              console.log(data.error);
              // $('#desktop_newsletter_head').css('display','none');
              $('#desktop_newsletter_success').css('display', 'block');
              $('#desktop_newsletter_success').html(data.error);
            } else if (data.status == 301) {
              // $('#desktop_newsletter_head').css('display','none');
              $('#desktop_newsletter_success').css('display', 'block');
              $('#desktop_newsletter_success').html(data.error);
            } else {
              //console.log(data.error)
            }
            $('.subscribe_preloader').css('display', 'none');
          }
        });
      } else {

      }
    });
    /* --------------------- news letter functionality end -------------------- */
    /* ---------------------------- coupan code functionality start --------------------------- */
    $('#coupon_button').click(function() {
      // $("#err").attr("disabled","true");    
      if (document.getElementById('in').value != "") {
        var total_sale_price = <?php echo $_SESSION['product_final_price']; ?>;
        // alert(total_sale_price);
        $.ajax({
          type: "POST",
          url: "php/process.php",
          'async': false,
          dataType: "json",
          data: {
            coupon_code: document.getElementById('in').value,
            type: "coupon"
          },
          success: function(dataResult) {
            if (dataResult.statusCode == 200) {
              $('#discount_show').css('display', 'block');
              result = dataResult;
              $("#in").attr('placeholder', '' + result.coupon_code + ' Coupon Applied');
              $('.discount').html(result.discount);
              product_total_amt = Math.round(parseInt(total_sale_price - ((total_sale_price * result.discount) / 100)));
              $('.total_amount_price').html(product_total_amt + payment_shipping);
              $('.subtotal').html(product_total_amt);
              $('.original_price').val(product_total_amt);
              alert(result.coupon_code + " has been Successfully Applied");
              return true;
            } else if (dataResult.statusCode == 201) {
              $('#discount_show').css('display', 'none');
              alert("Invalid coupon");
            }
          }
        });
      } else {
        alert("Invalid coupon");
        $('#discount_show').css('display', 'none');
      }

    });
    $('#coupon_button_mobile').click(function() {
      // $("#err").attr("disabled","true");    
      if (document.getElementById('in_mobile').value != "") {
        var total_sale_price = <?php echo $_SESSION['product_final_price']; ?>;
        // alert(total_sale_price);
        $.ajax({
          type: "POST",
          url: "php/process.php",
          'async': false,
          dataType: "json",
          data: {
            coupon_code: document.getElementById('in_mobile').value,
            type: "coupon"
          },
          success: function(dataResult) {
            if (dataResult.statusCode == 200) {
              $('#discount_show_mobile').css('display', 'block');
              result = dataResult;
              $("#in_mobile").attr('placeholder', '' + result.coupon_code + ' Coupon Applied');
              $('.discount').html(result.discount);
              product_total_amt = Math.round(parseInt(total_sale_price - ((total_sale_price * result.discount) / 100)));
              $('.total_amount_price').html(product_total_amt + payment_shipping);
              $('.subtotal').html(product_total_amt);
              $('.original_price').val(product_total_amt);
              alert(result.coupon_code + " has been Successfully Applied");
              return true;
            } else if (dataResult.statusCode == 201) {
              $('#discount_show_mobile').css('display', 'none');
              alert("Invalid coupon");
            }
          }
        });
      } else {
        alert("Invalid coupon");
        $('#discount_show_mobile').css('display', 'none');
      }

    });
    // radio button functionality start
    $('#billing_check1').prop("checked", true);
    $('#headingOne').click(function() {
      $('#billing_check1').prop("checked", true);
    });
    $('#headingTwo').click(function() {
      $('#billing_check2').prop("checked", true);
    });
    // radio button functionality end
    function changeinfo() {
      $('.slider-menumob').css('display', 'block');
      $('.slider-menumob2').css('display', 'none');
      $('.slider-menumob3').css('display', 'none');
      $('.contact-info-show').css('display', 'block');
      $('.shipping-info-show').css('display', 'none');
      $('.payment-info-show').css('display', 'none');
    }
    /* ---------------------------- coupan code functionality end --------------------------- */
  </script>
</body>

</html>