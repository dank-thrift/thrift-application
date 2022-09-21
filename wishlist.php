<?php
session_start();
require_once('php/link.php');
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

/* ---------------------------- add to cart start --------------------------- */
if (isset($_POST["wishidnew"]) && !empty($_POST["wishidnew"])) {
    foreach ($_COOKIE['wishitem'] as $name1 => $value) {
        $value11 = explode("__", $value);
        $qty = $value11[8];
    }
    $d = 0;
    if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
        foreach ($_COOKIE['item'] as $name => $value) {
            $d = $d + 1;
        }
        $d = $d + 1;
    } else {
        $d = $d + 1;
    }

    $q33 = "SELECT * FROM product_tbl INNER JOIN `hot_deals` ON product_tbl.id=hot_deals_product_id WHERE hot_deals_product_id=" . $_POST['wishidnew'] . "";
    $res2 = mysqli_query($link, $q33);
    if (mysqli_num_rows($res2) > 0) {
        while ($row2 = mysqli_fetch_assoc($res2)) {
            $id = $row2['id'];
            $design = $row2['design'];
            $name = $row2['name'];
            $image = $row2['image'];
            $image2 = $row2['image2'];
            $cost_price = $row2['hot_deal_cost_price'];
            $sale_price = $row2['hot_deal_sale_price'];
            // $qty=$row['quantity'];
            $price1 = $qty * $sale_price;
        }
        if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
            $found = 0;
            foreach ($_COOKIE['item'] as $name1 => $value) {
                $value11 = explode("__", $value);
                if ($image == $value11[0]) {
                    $found = $found + 1;
                    $qty1 = $value11[8] + 1;
                    $price1 = $value11[5] * $qty1;
                    setcookie("item[$name1]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty1 . "__" . $price1 . "__" . $complete_sku, time() + (86400 * 30), "/");
                }
            }
            // $d=$name1+1;
            $c = 0;
            $a = 0;
            $i = 1;
            while ($a == 0) {
                if (!empty($_COOKIE['item'][$i])) {
                    // echo "not availabe";
                } else {
                    // echo "availabe";
                    $c = $i;

                    $a = 1;
                }
                $i = $i + 1;
            }
            if ($found == 0) {
                setcookie("item[$c]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $complete_sku, time() + (86400 * 30), "/");
            }
        } else {
            setcookie("item[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $complete_sku, time() + (86400 * 30), "/");
        }
    } else {
        $q = "SELECT * FROM product_tbl WHERE id=" . $_POST['wishidnew'] . "";
        $res = mysqli_query($link, $q);
        $complete_sku = $_POST['sku'];
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $design = $row['design'];
                $name = $row['name'];
                $image = $row['image'];
                $image2 = $row['image2'];
                $cost_price = $row['cost_price'];
                $sale_price = $row['sale_price'];
                // $qty=$row['quantity'];
                $price1 = $qty * $sale_price;
            }
            if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
                $found = 0;
                foreach ($_COOKIE['item'] as $name1 => $value) {
                    $value11 = explode("__", $value);
                    if ($image == $value11[0]) {
                        $found = $found + 1;
                        $qty1 = $value11[8] + 1;
                        $price1 = $value11[5] * $qty1;
                        setcookie("item[$name1]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty1 . "__" . $price1 . "__" . $complete_sku, time() + (86400 * 30), "/");
                    }
                }
                // $d=$name1+1;
                $c = 0;
                $a = 0;
                $i = 1;
                while ($a == 0) {
                    if (!empty($_COOKIE['item'][$i])) {
                        // echo "not availabe";
                    } else {
                        // echo "availabe";
                        $c = $i;

                        $a = 1;
                    }
                    $i = $i + 1;
                }
                if ($found == 0) {
                    setcookie("item[$c]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $complete_sku, time() + (86400 * 30), "/");
                }
            } else {
                setcookie("item[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $complete_sku, time() + (86400 * 30), "/");
            }
        }
        /* ------------------------------add to cart and delete start ------------------------------ */
    }
    $d_cookie = "";
    if (!empty($_COOKIE['wishitem']) && is_array($_COOKIE['wishitem'])) {
        foreach ($_COOKIE['wishitem'] as $name1 => $value) {
            if (isset($_POST["deletewish$name1"])) {
                $d_cookie .= setcookie("wishitem[$name1]", "", time() - (86400 * 30), "/");
                // header("Refresh:0");            
                // $page = $_SERVER['PHP_SELF'];           
                // header("Location:$page");
            }
        }
    }
    /* ------------------------------add to cart and delete end ------------------------------ */
    header("Location:wishlist");
}
// /* ----------------------------- add to cart end ---------------------------- */
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

    <style>
        .add-to-curt-style {
            background-color: #472D2D;
            border-radius: 5px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            line-height: 1;
            padding: 10px 12px;
            text-transform: uppercase;
        }

        .add-to-curt-style:hover {
            background-color: #1d1d1d;
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
                                                        } ?>'
                                        }
                                    </style>
                                    <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i class="lnr lnr-cart"></i><span>My Cart</span></a>
                                    <style>
                                        .header-tools .cart-info .bag:before {
                                            content: '<?php if (!empty($cart_item)) {
                                                            echo $cart_item;
                                                        } else {
                                                            echo "0";
                                                        } ?>'
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
                                <li><a href="contant">Contact</a></li>
                            </ul>
                        </div>
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
                            <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i class="lnr lnr-cart"></i><span>My Cart</span></a>
                        </div>
                        <div class="mobile-menu-toggle">
                            <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                                <svg viewBox="0 0 800 600">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
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
                            <li>Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <!-- ------------------------ page start from here ------------------------- -->
    <?php @$dddd = 0;
    if (!empty($_COOKIE['wishitem']) && is_array($_COOKIE['wishitem'])) {
        @$dddd = $dddd + 1;
    }
    if (@$dddd == 0) {
        echo "<div class='empty-cart-area mtb-50px'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='cart-heading'><h2>Your cart item</h2></div>
                    <div class='empty-text-contant text-center'>
                       <i class='lnr lnr-cart'></i>
                       <h1>There are no more items in your cart</h1>
                       <a class='empty-cart-btn' href='/'>
                            <i class='ion-ios-arrow-left'> </i> Continue shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    } else {
    ?>
        <div class="cart-main-area mtb-50px">
            <div class="container">
                <h3 class="cart-page-title">Your cart items</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <!-- <form action="#"> -->
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Until Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Add To Cart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($_COOKIE['wishitem'] as $name1 => $value) {
                                        $value11 = explode("__", $value);
                                        $_SESSION['p_id'] = $value11[7]
                                    ?>
                                        <!-- <form method="post"> -->
                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#"><img loading="lazy" class="img-responsive size" src=" <?php echo $img_link ?>images/product-image/<?php echo $value11[3] ?>" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="#"><?php echo $value11[2] ?></a></td>
                                            <?php
                                            $q33 = "SELECT `hot_deal_sale_price` FROM hot_deals WHERE `hot_deals_product_id`='$value11[7]'";
                                            $res2 = mysqli_query($link, $q33);
                                            if (mysqli_num_rows($res2) > 0) {
                                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                            ?>
                                                    <td class="product-price-cart" id="price2">&#8377;<?php echo $row2['hot_deal_sale_price'] ?></td>
                                                    <input type="hidden" id="pid2" value="<?php echo $value11[7]; ?>">
                                                    <input type="hidden" id="psku2" value="<?php echo $value11[11]; ?>">
                                                    <td class="product-quantity">
                                                        <div class="cart-plus-minus">
                                                            <div class="dec qtybutton qtybutton_minus2">-</div>
                                                            <input class="cart-plus-minus-box itemQty2" type="text" name="qtybutton" value="<?php echo $value11[8] ?>" id="textbox" min="1">
                                                            <div class="inc qtybutton qtybutton_plus2">+</div>
                                                        </div>
                                                    </td>
                                                    <input type="hidden" id="pprice<?php echo $value11[7]; ?>" value="<?php echo $row2['hot_deal_sale_price'] ?>">
                                                    <?php
                                                }
                                            } else {
                                                $q = "SELECT `sale_price` FROM product_tbl WHERE id=" . $value11[7] . "";
                                                $res = mysqli_query($link, $q);
                                                if (mysqli_num_rows($res) > 0) {
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                    ?>
                                                        <td class="product-price-cart" id="price2">&#8377;<?php echo $value11[5] ?></td>
                                                        <input type="hidden" id="pid2" value="<?php echo $value11[7]; ?>">
                                                        <input type="hidden" id="psku" value="<?php echo $value11[11]; ?>">
                                                        <td class="product-quantity">
                                                            <div class="cart-plus-minus">
                                                                <div class="dec qtybutton qtybutton_minus2">-</div>
                                                                <input class="cart-plus-minus-box itemQty2" type="text" name="qtybutton" value="<?php echo $value11[8] ?>" id="textbox" min="1">
                                                                <div class="inc qtybutton qtybutton_plus2">+</div>
                                                            </div>
                                                        </td>
                                                        <input type="hidden" id="pprice<?php echo $value11[7]; ?>" value="<?php echo $row['sale_price'] ?>">
                                            <?php
                                                    }
                                                }
                                            } ?>
                                            <td class="product-subtotal total2">&#8377;<span id="total"><?php echo number_format($value11[9], 2) ?></span></td>
                                            <td class="product-wishlist-cart">
                                                <form method="post">
                                                    <input type="hidden" name="wishidnew" value="<?php echo $value11[7]; ?>">
                                                    <input type="hidden" name="sku" value="<?php echo $value11[11]; ?>">
                                                    <button type="submit" name="deletewish<?php echo @$value11[10]; ?>" class="add-to-curt-style"><a class="add-to-curt" title="Add to cart">Add to cart</a></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- </form> -->
                                    <?php } ?>
                                    <!-- <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img loading="lazy" class="img-responsive size" src=" <?php echo $img_link ?>images/popular-image/2-2.jpg" alt=""></a>
                                    </td>
                                    <td class="product-name"><a href="#">Product Name</a></td>
                                    <td class="product-price-cart"><span class="amount">$50.00</span></td>
                                    <td class="product-quantity">
                                        <div class="cart-plus-minus"><div class="dec qtybutton">-</div>
                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                                        <div class="inc qtybutton">+</div></div>
                                    </td>
                                    <td class="product-subtotal">$80.00</td>
                                    <td class="product-wishlist-cart">
                                        <a href="#">add to cart</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img loading="lazy" class="img-responsive size" src=" <?php echo $img_link ?>images/popular-image/2-3.jpg" alt=""></a>
                                    </td>
                                    <td class="product-name"><a href="#">Product Name</a></td>
                                    <td class="product-price-cart"><span class="amount">$70.00</span></td>
                                    <td class="product-quantity">
                                        <div class="cart-plus-minus"><div class="dec qtybutton">-</div>
                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                                        <div class="inc qtybutton">+</div></div>
                                    </td>
                                    <td class="product-subtotal">$90.00</td>
                                    <td class="product-wishlist-cart">
                                        <a href="#">add to cart</a>
                                    </td>
                                </tr> -->
                                </tbody>
                            </table>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    <?php  } ?>
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
    <script src="js/main.js"></script>
    <!-- Main Activation JS -->
    <script src="https://unpkg.com/@metamask/legacy-web3@latest/dist/metamask.web3.min.js"></script>
    <script src="js/new.js"></script>
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
        $(".itemQty2").on("change", function() {
            var el = $(this).closest("tr");
            var pid = el.find("#pid2").val();
            var pprice = $("#pprice" + pid).val();
            // var pricenew = parseFloat(document.getElementById("price2").innerHTML);
            qty = Math.round((el.find(".itemQty2").val()));
            console.log(qty);
            if (qty < 1) {
                qty = 1;
            }
            var price2 = qty * pprice;
            //    include tax
            var total = price2 + 0;
            var pp = el.find(".price2").val(price2);
            var total = el.find(".total2").val(total);
            var psku = el.find("#psku").val();
            var total1 = 0;
            $(".total2").each(function() {
                total1 += parseFloat($(this).val());
            });
            $("#grandtotal").val(total1);
            var gtot = $("#grandtotal").val();
            // console.log(pid);
            // console.log(pricenew);
            console.log(total.val());
            $.ajax({
                url: "php/wishtotal.php",
                method: "POST",
                data: {
                    pid: pid,
                    price: pprice,
                    // pp: pp.val(),
                    sku: psku,
                    pqty: qty,
                    total: price2,
                    // gtot: gtot,
                },
                success: function(result) {
                    console.log(result);
                    window.location.reload();
                },
            });
        });
        $('.qtybutton_plus2').click(function() {
            var el = $(this).closest("tr");
            var pid = el.find("#pid2").val();
            var pprice = $("#pprice" + pid).val();
            var psku = el.find("#psku").val();
            // var pricenew = parseFloat(document.getElementById("price2").innerHTML);
            qty = Math.round((el.find(".itemQty2").val()));
            if (qty < 1) {
                qty = 1;
            }
            qty = qty + 1;
            var price2 = qty * pprice;
            //    include tax
            var total = price2 + 0;
            var pp = el.find(".price2").val(price2);
            var total = el.find(".total2").val(total);
            var total1 = 0;
            $(".total2").each(function() {
                total1 += parseFloat($(this).val());
            });
            $("#grandtotal").val(total1);
            var gtot = $("#grandtotal").val();
            // console.log(pid);
            // console.log(pricenew);
            console.log(total.val());
            $.ajax({
                url: "php/wishtotal.php",
                method: "POST",
                data: {
                    pid: pid,
                    price: pprice,
                    sku: psku,
                    // pp: pp.val(),
                    pqty: qty,
                    total: price2,
                    // gtot: gtot,
                },
                success: function(result) {
                    console.log(result);
                    window.location.reload();
                },
            });
        });
        $('.qtybutton_minus2').click(function() {
            var el = $(this).closest("tr");
            var pid = el.find("#pid2").val();
            var pprice = $("#pprice" + pid).val();
            var psku = el.find("#psku").val();
            // var pricenew = parseFloat(document.getElementById("price2").innerHTML);
            qty = Math.round((el.find(".itemQty2").val()));
            qty = qty - 1;
            if (qty < 1) {
                qty = 1;
            }
            var price2 = qty * pprice;
            //    include tax
            var total = price2 + 0;
            var pp = el.find(".price2").val(price2);
            var total = el.find(".total2").val(total);
            // console.log(total.val());
            var total1 = 0;
            $(".total2").each(function() {
                total1 += parseFloat($(this).val());
            });
            console.log(total1);
            $("#grandtotal").val(total1);
            var gtot = $("#grandtotal").val();
            console.log(gtot);
            // console.log(pricenew);
            // console.log(total.val());
            $.ajax({
                url: "php/wishtotal.php",
                method: "POST",
                data: {
                    pid: pid,
                    price: pprice,
                    sku: psku,
                    // pp: pp.val(),
                    pqty: qty,
                    total: price2,
                    // gtot: gtot,
                },
                success: function(result) {
                    console.log(result);
                    window.location.reload();
                },
            });
        });
    </script>
</body>

</html>