<?php
session_start();
require_once('php/link.php');
if (empty($_SESSION['eth_id'])) {
    header('Location:index');
}
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
/* ------------------------------ delete end ------------------------------ */
/* ------------------------- total cart price start ------------------------- */

$c = 0;
if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
    foreach ($_COOKIE['item'] as $name1 => $value) {
        $value12 = explode("__", $value);
        $c += $value12[9];
    }
}
setcookie("totalcart", $c, time() + (86400 * 30), "/");
$_SESSION['ccc'] = $c;
/* ------------------------- total cart price end ------------------------- */
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
            j.src ='https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WS3Q2PH');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WS3Q2PH" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- --------------------------- header start here --------------------------- -->
    <!-- Header Section Start From Here -->
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
                                <?php } ?>
                                <?php if (!empty($_SESSION['eth_id'])) { ?>                                    
                                    <div class="dropdown">
                                        <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" text-transform: capitalize;display:flex;align-items:center;"><?php 
                                        if (empty($_SESSION['eth_id'])) {
                                        echo "My Account ";
                                        } else { 
                                            // echo substr($_SESSION['eth_id'], 0, 8) . "... "; ?>
                                            <span style="border-radius:50%;overflow:hidden;padding:5px;border:1px solid #333;background:#FEF5E7;" class="mr-2"><img src="images/metamask.svg" alt="metamask" style="height:30px;width:30px;" class="animate__animated animate__pulse animate__infinite animate__slow"></span>
                                         <?php } ?>
                                            <i class="ion-ios-arrow-down"></i>
                                        </button>
                                        <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                            <li><a href="javascript:void(0)"><p class="font-weight-bold" style="display: inline-block;word-break:break-all;white-space: pre-line;overflow-wrap:break-word;"><?= $_SESSION['eth_id'] ?></p></a></li>
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
                            <a href="/"><img loading="lazy" class="img-responsive size" src="  <?php echo $img_link ?>images/logo/logo.png" alt="logo.png" /></a>
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
                                                            echo "0";
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
                        <a href="/"><img loading="lazy" class="img-responsive size" src="  <?php echo $img_link ?>images/logo/logo.png" alt="logo.png" style="padding:0.7rem 0;"/></a>
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
    <div class="mobile-search-area d-lg-none mb-15px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-element media-body">
                        <form class="d-flex" action="search.php" method="get">
                            <div class="search-category">
                                <select name="cat">
                                    <option value="all">All categories</option>
                                    <?php
                                    $q2 = "SELECT DISTINCT category from `product_category` WHERE 1";
                                    $res2 = mysqli_query($link, $q2);
                                    if (mysqli_num_rows($res2) > 0) {
                                        while ($row = mysqli_fetch_assoc($res2)) {
                                    ?>
                                            <option value="<?php echo $row['category'] ?>"><?php echo $row['category'] ?></option>
                                    <?php
                                        }
                                    } ?>

                                </select>
                            </div>
                            <input type="text" placeholder="Enter your search key ... " name="search" />
                            <button type="submit"><i class="lnr lnr-magnifier"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Category End -->
    <div class="mobile-category-nav d-lg-none mb-15px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!--=======  category menu  =======-->
                    <div class="hero-side-category">
                        <!-- Category Toggle Wrap -->
                        <div class="category-toggle-wrap">
                            <!-- Category Toggle -->
                            <button class="category-toggle"><i class="fa fa-bars"></i> All Categories</button>
                        </div>

                        <!-- Category Menu -->
                        <nav class="category-menu">
                            <ul>
                                <?php
                                $q = "SELECT DISTINCT category from `product_category` WHERE 1";
                                $res = mysqli_query($link, $q);
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                        <li class="menu-item-has-children menu-item-has-children-1"><a href="shop-left-sidebar.php?category=<?php echo $row['category'] ?>"><?php echo $row['category'] ?></a></li>
                                <?php }
                                } ?>
                                <!-- <li><a href="#">Televisions</a></li> -->
                            </ul>
                        </nav>
                    </div>

                    <!--=======  End of category menu =======-->
                </div>
            </div>
        </div>
    </div>
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
                                    <span class="quantity-price"><span id="itemquanity"><?php echo $value11[8] ?></span> x <span class="amount">&#8377;<span id="itemval_side"><?php echo $value11[5] ?></span></span></span>
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
                                                                                        echo $_SESSION['ccc']; ?></span></span>
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
                    <!-- <li>
                        <a href="https://www.facebook.com/quadbapparels/"><i class="ion-social-facebook"></i></a>
                    </li>
                    <li>
                        <a href="https://twitter.com/quadbcreations"><i class="ion-social-twitter"></i></a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/company/quadb"><i class="ion-social-linkedin"></i></a>
                    </li> -->
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
                            <li>Account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <!-- ------------------------ page start from here ------------------------- -->
    <div class="checkout-area mtb-50px">
        <div class="container">
            <div class="row">
                <div class="ml-auto mr-auto col-lg-9">
                    <div class="checkout-wrapper">
                        <div id="faq" class="panel-group">
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>1 .</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1" aria-expanded="false" class="collapsed">Edit your account information </a></h3>
                                </div>
                                <div id="my-account-1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php
                                        if (!empty($_SESSION['eth_id'])) {
                                            $check_mail = $_SESSION['eth_id'];
                                            $query = "SELECT * FROM `signup_details` WHERE `email`='$check_mail'";
                                            $result = mysqli_query($link, $query);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $row_first_name = "";
                                                    $row_last_name = "";
                                                    if ($row['name'] != "") {
                                                        $value_name = explode(" ", $row['name']);
                                                        $row_first_name = $value_name[0];
                                                        $row_last_name = $value_name[1];
                                                    }

                                        ?>
                                                    <div class="myaccount-info-wrapper">
                                                        <div class="account-info-wrapper">
                                                            <h4>My Account Information</h4>
                                                            <h5>Your Personal Details</h5>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="billing-info">
                                                                    <label>First Name</label>
                                                                    <input type="text" value="<?php echo $row_first_name ?>" id="update_first_name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="billing-info">
                                                                    <label>Last Name</label>
                                                                    <input type="text" value="<?php echo  $row_last_name ?>" id="update_last_name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="billing-info">
                                                                    <label>Email Address</label>
                                                                    <input type="email" readonly value="<?php echo $row['email']; ?>" id="update_email">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="billing-info">
                                                                    <label>Mobile</label>
                                                                    <input type="text" value="<?php echo $row['phone'] ?>" id="update_phone">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="billing-info">
                                                                    <label>Company Name</label>
                                                                    <input type="text" value="<?php echo $row['company'] ?>" id="update_company">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="billing-back-btn">
                                                            <div class="billing-back">
                                                                <a href="#"><i class="fa fa-arrow-up"></i> back</a>
                                                            </div>
                                                            <div class="billing-btn">
                                                                <button type="button" id="update_personal_details">Continue</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                        <?php  }
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>2 .</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2" class="collapsed" aria-expanded="false">Change your password </a></h3>
                                </div>
                                <div id="my-account-2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="myaccount-info-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>Change Password</h4>
                                                <h5>Your Password</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password</label>
                                                        <input type="password" id="update_password">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Confirm Password</label>
                                                        <input type="password" id="update_confirm_password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="fa fa-arrow-up"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <button type="button" id="set_new_password">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>3 .</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3" class="collapsed" aria-expanded="false">Modify your address book entries </a></h3>
                                </div>
                                <div id="my-account-3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="myaccount-info-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>Address Book Entries</h4>
                                            </div>
                                            <?php
                                            if (!empty($_SESSION['eth_id'])) {
                                                $check_mail = $_SESSION['eth_id'];
                                                $query = "SELECT * FROM `signup_details` WHERE `email`='$check_mail'";
                                                $result = mysqli_query($link, $query);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        if ($row['address'] != "") {
                                                            $value_address = explode("__", $row['address']);
                                                            $row_address = $value_address[0];
                                                            $row_city = $value_address[1];
                                                            $row_state = $value_address[2];
                                                            $row_postcode = $value_address[3];
                                                            $row_country = $value_address[4];
                                                        } else {
                                                            $row_address = "";
                                                            $row_address2 = "";
                                                            $row_city = "";
                                                            $row_state = "";
                                                            $row_postcode = "";
                                                            $row_country = "";
                                                        }

                                            ?>
                                                        <div class="entries-wrapper">
                                                            <div id="fixed_address">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                                        <div class="entries-info text-center">
                                                                            <p><?php echo $row_address ?></p>
                                                                            <p><?php echo $row_city ?></p>
                                                                            <p><?php echo $row_state ?></p>
                                                                            <p><?php echo $row_postcode ?></p>
                                                                            <p><?php echo $row_country ?></p>
                                                                            <p><?php echo $row['phone'] ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                                        <div class="entries-edit-delete text-center">
                                                                            <a class="edit" id="edit_address" style="cursor:pointer;">Edit</a>
                                                                            <a style="cursor:pointer;" id="delete_address">Delete</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div style="display:none" id="update_address">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                                        <div class="entries-info text-center">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12">
                                                                                    <div class="billing-info">
                                                                                        <input type="text" placeholder="House number and street name" value="<?php echo $row_address ?>" id="update_street_address">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12">
                                                                                    <div class="billing-info">
                                                                                        <input type="text" placeholder="City" value="<?php echo $row_city ?>" id="update_city">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12">
                                                                                    <div class="billing-info">
                                                                                        <input type="text" placeholder="State" value="<?php echo $row_state ?>" id="update_state">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12">
                                                                                    <div class="billing-info">
                                                                                        <input type="text" placeholder="Postcode" value="<?php echo $row_postcode ?>" id="update_postcode">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12">
                                                                                    <div class="billing-info">
                                                                                        <input type="text" placeholder="Country" value="<?php echo $row_country ?>" id="update_country">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                                        <div class="entries-edit-delete text-center">
                                                                            <a class="edit" id="update_new_address">Update</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                            <?php }
                                                }
                                            } ?>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="fa fa-arrow-up"></i> back</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>4 .</span> <a href="wishlist.php">Modify your wish
                                            list </a></h3>
                                </div>
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
            <div class="footer-top">
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
                                            <a href="https://www.google.com/search?q=Dank+Thrift&oq=Dank+Thrift&aqs=chrome..69i57j69i65j69i60l2.211j0j7&sourceid=chrome&ie=UTF-8" target="_blank"><i class="ion-android-globe" style="margin-right: 5px;"></i> Dank Thrift</a>
                                        </p>
                                        <p class=" text-center-mobile">
                                            <a href="https://wa.me/918171280077/?text=Hey+Fellas%2C%0D%0ACan+you+help+me+to+order+some+really+cool+merchandise+from+Dank+Thrift%3F" target="_blank"><i class="ion-social-whatsapp" style="margin-right: 5px;"></i> +91-81712 80077</a>
                                        </p>
                                        <p class=" text-center-mobile">
                                            <a href="tel:+918171280077" target="_blank"><i class="ion-android-call" style="margin-right: 5px;"></i> +91-81712 80077</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="footer-paymet-warp d-flex">
                                <div class="heading-info">Payment:</div>
                                <div class="payment-way"><img loading="lazy" class="payment-img img-responsive" src="  <?php echo $img_link ?>images/icons/payment/1.png" alt="" style="width: 6rem; height: 2.5rem; margin-right: 7px;" />
                                </div>
                                <div class="payment-way"><img loading="lazy" class="payment-img img-responsive" src="  <?php echo $img_link ?>images/icons/payment/2.png" alt="" style="width: 6rem; height: 2.5rem; margin-right: 7px;" />
                                </div>
                                <div class="payment-way"><img loading="lazy" class="payment-img img-responsive" src="  <?php echo $img_link ?>images/icons/payment/3.png" alt="" style="width: 6rem; height: 2.5rem; margin: 0 7px;" />
                                </div>
                                <div class="payment-way"><img loading="lazy" class="payment-img img-responsive" src="  <?php echo $img_link ?>images/icons/payment/4.png" alt="" style="width: 6rem; height: 2.5rem; margin-right: 7px;" />
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
                        <div class="col-md-8" >
                            <div class="tag-content">
                                <ul class="text-capitalize">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="shop-left-sidebar.php">shop</a></li>
                                    <li><a href="about">about</a></li>
                                    <li><a href="contact">contact</a></li>
                                    <li><a href="https://www.instagram.com/dank_thrift/" target="_blank">instagram</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <p class="copy-text">Copyright © <a href="/"> Dank Thrift</a>. All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Area End -->
    <!-- JS
============================================ -->
    <script src="js/vendor.min.js"></script>
    <script src="js/slick.min.js"></script>

    <!-- Main Activation JS -->
    <script src="js/main.js"></script>
    <!-- <script src="https://unpkg.com/@metamask/legacy-web3@latest/dist/metamask.web3.min.js"></script> -->
    <!-- <script src="js/new.js"></script> -->

    <!-- new code start here 2022-->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/web3modal@1.9.7/dist/index.js"></script>
    <script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.7.8/dist/umd/index.min.js">
    </script>
    <script src="./frontend/web3-login.js?v=009">
    </script>
    <script src="./frontend/web3-modal.js?v=001"></script>
     <!-- new code end here 2022-->

    <script>
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
        $('#edit_address').click(function() {
            $('#update_address').css('display', 'block');
            $('#fixed_address').css('display', 'none');
        });
        $('#update_new_address').click(function() {
            var error = "";
            var street_address = $('#update_street_address').val();
            var city = $('#update_city').val();
            var state = $('#update_state').val();
            var postcode = $('#update_postcode').val();
            var country = $('#update_country').val();
            if (street_address == "") {
                $("#update_street_address").css('border-color', 'red');
                $("#update_street_address").css('border-width', '2px');
                error = error + 'state';
            } else {
                $("#update_street_address").css('border-color', '#C0BBBB');
                $("#update_street_address").css('border-width', '1px');
            }
            if (error == "") {
                $.ajax({
                    type: 'POST',
                    url: 'php/update_details.php',
                    dataType: "json",
                    data: {
                        'street_address': street_address,
                        'city': city,
                        'state': state,
                        'postcode': postcode,
                        'country': country
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == 201) {
                            $('#update_address').css('display', 'none');
                            $('#fixed_address').css('display', 'block');
                            window.location.replace("my-account");
                        } else if (data.status == 601) {
                            console.log(data.error);
                        } else {
                            //     alert("problem with query");
                        }
                    }
                });
            }
        });
        $('#delete_address').click(function() {
            $.ajax({
                type: 'POST',
                url: 'php/update_details.php',
                dataType: "json",
                data: {
                    'delete_address': "delete_address"
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == 201) {
                        window.location.replace("my-account");
                    } else if (data.status == 601) {
                        console.log(data.error);
                    } else {
                        //     alert("problem with query");
                    }
                }
            });
        });
        $('#set_new_password').click(function() {
            var update_password = $('#update_password').val();
            var update_confirm_password = $('#update_confirm_password').val();
            var error = "";
            if (update_password == "") {
                $("#update_password").css('border-color', 'red');
                $("#update_password").css('border-width', '2px');
                error = error + 'password';
            } else {
                $("#update_password").css('border-color', '#C0BBBB');
                $("#update_password").css('border-width', '1px');
            }
            if (update_password.length < 6) {
                $("#update_password").css('border-color', 'red');
                $("#update_password").css('border-width', '2px');
                error = error + 'password';
            } else {
                $("#update_password").css('border-color', '#C0BBBB');
                $("#update_password").css('border-width', '1px');
            }
            if (update_confirm_password == "") {
                $("#update_confirm_password").css('border-color', 'red');
                $("#update_confirm_password").css('border-width', '2px');
                error = error + 'confirm_password';
            } else {
                $("#update_confirm_password").css('border-color', '#C0BBBB');
                $("#update_confirm_password").css('border-width', '1px');
            }
            if (update_password != update_confirm_password) {
                $("#update_confirm_password").css('border-color', 'red');
                $("#update_confirm_password").css('border-width', '2px');
                // alert('Password not match !');
                error = error + 'password not matched';
            }
            if (error == "") {
                $.ajax({
                    type: 'POST',
                    url: 'php/update_details.php',
                    dataType: "json",
                    data: {
                        'password': update_password
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == 201) {
                            window.location.replace("my-account");
                        } else if (data.status == 601) {
                            console.log(data.error);
                        } else {
                            //     alert("problem with query");
                        }
                    }
                });
            }
        });
        $('#update_personal_details').click(function() {
            var email = $('#update_email').val();
            var first_name = $('#update_first_name').val();
            var last_name = $('#update_last_name').val();
            var phone = $('#update_phone').val();
            var company = $('#update_company').val();
            var error = "";
            if ((phone == "") || (phone.length != 10)) {
                $("#update_phone").css('border-color', 'red');
                $("#update_phone").css('border-width', '2px');
                error = error + 'phone';
            } else {
                $("#update_phone").css('border-color', '#C0BBBB');
                $("#update_phone").css('border-width', '1px');
            }

            if (email == "") {
                error = "email";
            }
            if (error == "") {
                $.ajax({
                    type: 'POST',
                    url: 'php/update_details.php',
                    dataType: "json",
                    data: {
                        'email': email,
                        'first_name': first_name,
                        'last_name': last_name,
                        'phone': phone,
                        'company': company
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == 201) {
                            window.location.replace("my-account");
                        } else if (data.status == 601) {
                            console.log(data.error);
                        } else {
                            //     alert("problem with query");
                        }
                    }
                });
            }
        });
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
    </script>
</body>

</html>