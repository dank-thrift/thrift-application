<?php
session_start();
require_once('php/link.php');
if (empty($_SESSION['eth_id'])) {
    header('Location:/');
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
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
    $q = "SELECT * FROM product_tbl WHERE id=" . $_POST['wishidnew'] . "";
    $res = mysqli_query($link, $q);
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
            foreach ($_COOKIE['item'] as $name1 => $value) {
                $value11 = explode("__", $value);
                $found = 0;
                if ($image == $value11[0]) {
                    $found = $found + 1;
                    $qty1 = $value11[8] + 1;
                    $price1 = $value11[5] * $qty1;
                    setcookie("item[$name1]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty1 . "__" . $price1, time() + (86400 * 30), "/");
                }
            }
            if ($found == 0) {
                setcookie("item[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1, time() + (86400 * 30), "/");
            }
        } else {
            setcookie("item[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1, time() + (86400 * 30), "/");
        }
    }
    /* ------------------------------add to cart and delete start ------------------------------ */
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
/* ----------------------------- add cart start ----------------------------- */
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $d = 0;
    if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
        foreach ($_COOKIE['item'] as $name => $value) {
            $d = $d + 1;
        }
        $d = $d + 1;
    } else {
        $d = $d + 1;
    }
    $q = "SELECT * FROM product_tbl WHERE id=" . $_POST['id'] . "";
    $res = mysqli_query($link, $q);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $design = $row['design'];
            $name = $row['name'];
            $image = $row['image'];
            $image2 = $row['image2'];
            $cost_price = $row['cost_price'];
            $sale_price = $row['sale_price'];
            $qty = $row['quantity'];
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
                    echo "name = " . $name1 . '</br>';
                    echo "d = " . $d . '</br>';
                    setcookie("item[$name1]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty1 . "__" . $price1, time() + (86400 * 30), "/");
                }
            }
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
                setcookie("item[$c]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1, time() + (86400 * 30), "/");
            }
            // echo $d;
        } else {
            setcookie("item[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1, time() + (86400 * 30), "/");
        }
    }
    header("Location:/");
}
/* ------------------------------ add cart end ------------------------------ */
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

        .list-group {
            border-color: $cloud !important;

            .list-group-item {
                border-color: $cloud !important;
            }
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 500 !important;
        }

        a.account-card {
            text-decoration: none;
            color: unset;

            i.fa {
                font-size: 42px;
                width: 45px;
            }

            .card {
                background: $snow;
                border: 1px solid $cloud;

                &:hover {
                    background: $white;
                }

                &:active {
                    background: $fog;
                }
            }
        }

        .bg-yellow {
            background: $yellow;
            color: $carbon;
        }

        .list-group-item-action {
            background: $snow;

            .fa {
                width: 22px;
            }

            .fa.fa-angle-right {
                font-size: 20px;
                position: absolute;
                right: 5px;
                top: 14px;
            }
        }

        .coupon {
            background: $snow;
            border: 2px dashed $cloud !important;
        }

        .reward-status-box {
            position: relative;
            width: 100%;
            color: $white;
            background: darken(saturate($blue, 15%), 15%);
            border: 2px solid saturate($blue, 15%);
            border-radius: 5px;

            .reward-status {
                width: 60%;
                background: saturate($blue, 15%);
                padding: 15px;
            }

            .current-status {
                position: absolute;
                right: 15px;
                top: 15px;
                color: $white;
            }

            .current-status-2 {
                position: absolute;
                right: 15px;
                top: 41px;
                color: $white;
            }
        }



        // Utilities

        .text-orange {
            color: $orange !important;
        }

        .text-carbon {
            color: $carbon !important;
        }

        .text-pebble {
            color: $pebble !important;
        }

        .text-gray {
            color: $gray !important;
        }

        .text-cloud {
            color: $cloud !important;
        }

        .text-blue {
            color: $blue !important;
        }

        .text-gray {
            color: $gray !important;
        }

        .text-pale-sky {
            color: $gray !important;
        }

        .bg-black {
            background: $black !important;
        }

        .bg-snow {
            background: $snow !important;
        }

        .bg-fog {
            background: $fog !important;
        }

        .bb1-cloud {
            border-bottom: 1px solid $cloud;
        }

        .fs-14 {
            font-size: 14px !important;
        }

        .fs-22 {
            font-size: 22px !important;
        }

        .tanga-header {
            .navbar-brand {
                margin-bottom: 5px;
            }

            .nav-link {
                color: $gray;

                &:hover {
                    color: $white;
                }

                &:active {
                    color: $gray;
                }
            }
        }

        .tanga-navbar {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;

            &:-webkit-scrollbar {
                display: none;
            }

            .nav-link {
                white-space: nowrap;
                color: $pebble;

                &:hover {
                    color: $charcoal;
                }

                &:active {
                    color: $pebble;
                }
            }
        }

        .btn-primary {
            background: $red;
            border-color: $red;
            cursor: pointer;

            &:hover {
                background: lighten($red, 10%);
                border-color: lighten($red, 10%);
            }
        }

        .btn-secondary {
            background: $white !important;
            color: $charcoal !important;
            border-color: $cloud !important;
            cursor: pointer;

            &:hover {
                color: $charcoal !important;
                background: $snow !important;
            }

            &:active {
                color: $pebble !important;
                background: $fog !important;
            }

            &:focus {
                color: $pebble !important;
                background: $fog !important;
                outline: 0 !important;
            }
        }

        .mobile-nav {
            position: fixed;
            bottom: 0;
            z-index: 50;
            display: block;
            width: 100%;
            background: $black;

            a {
                text-decoration: none !important;
                cursor: pointer;
                color: $gray;
                font-size: 12px;
                float: left;
                width: 20%;
                display: inline-block;
                text-align: center;
                margin: 0 !important;
                padding: 8px 0px 5px 0px;

                &.active {
                    background: $carbon;
                    color: $white;
                }

                i {
                    font-size: 23px;
                    display: block;
                    margin: 0 auto;
                    margin-bottom: 2px;
                }
            }
        }

        .fs-18 {
            font-size: 18px !important;
        }

        .fs-22 {
            font-size: 22px !important;
        }

        .bg-snow {
            background: $snow !important;
        }

        .card {
            border-color: $cloud !important;
        }

        .text-pebble {
            color: $pebble !important;
        }

        .text-charcoal {
            color: $charcoal !important;
        }

        .bottom-drawer {
            position: fixed;
            bottom: 56px;
            width: 100%;
            border-top: 1px solid $cloud;
        }

        .bg-white {
            background: $white !important;
        }

        .list-group {
            border-color: $cloud !important;
        }

        .list-group-item {
            border-color: $cloud !important;
        }

        .text-red {
            color: $red !important;
        }

        .text-green {
            color: $green !important;
        }

        .text-link-blue {
            color: $link-blue !important;
        }

        .form-control {
            background: $snow;
            border-color: $cloud !important;
        }

        .bd-2-cloud {
            border: 2px dashed $cloud;
        }

        .b-1-green {
            border: 2px solid $green !important;
        }

        .br-8 {
            border-radius: 5px;
        }

        .address-radio {
            .address-label {
                padding: 1rem;
                margin-bottom: 0 !important;
            }

            [type="radio"]:checked,
            [type="radio"]:not(:checked) {
                position: absolute;
                opacity: 0;

                &+label {
                    position: relative;
                    padding-left: 50px;
                    width: 100%;
                    cursor: pointer;
                    line-height: 20px;
                    display: inline-block;
                    color: $charcoal;

                    &:before {
                        content: '';
                        position: absolute;
                        left: 1rem;
                        top: 1rem;
                        width: 20px;
                        height: 20px;
                        border: 2px solid $cloud;
                        border-radius: 50%;
                        background: #fff;
                    }

                    &:after {
                        content: '';
                        width: 12px;
                        height: 12px;
                        background: $green;
                        position: absolute;
                        top: 20px;
                        left: 20px;
                        border-radius: 50%;
                        transition: all 0.2s ease;
                    }
                }
            }

            [type="radio"]:not(:checked)+label:after {
                opacity: 0;
                transform: scale(0);
            }

            [type="radio"]:checked+label:after {
                opacity: 1;
                transform: scale(1);
            }

            [type="radio"]:not(:checked)~label p {
                display: none;
            }

            [type="radio"]:checked~label p {
                display: unset;
            }
        }

        .no-gutters {
            display: flex;
            justify-content: center !important;
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
                                                    <option value="<?php echo $row['category'] ?>"><?php echo $row['category'] ?>
                                                    </option>
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
                                        <li class="menu-item"><a href="shop-left-sidebar.php?category=<?php echo $row['category'] ?>"><?php echo $row['category'] ?></a>
                                        </li>
                                <?php }
                                } ?>
                                <!-- <li class="menu-item">
                                        <a href="#">Electronics <i class="ion-ios-arrow-right"></i></a>
                                        <ul class="sub-menu flex-wrap">
                                            <li>
                                                <a href="#">
                                                    <span> <strong> Accessories & Parts</strong></span>
                                                </a>
                                                <ul class="submenu-item">
                                                    <li><a href="#">Cables & Adapters</a></li>
                                                    <li><a href="#">Batteries</a></li>
                                                    <li><a href="#">Chargers</a></li>
                                                    <li><a href="#">Bags & Cases</a></li>
                                                    <li><a href="#">Electronic Cigarettes</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span><strong>Camera & Photo</strong></span>
                                                </a>
                                                <ul class="submenu-item">
                                                    <li><a href="#">Digital Cameras</a></li>
                                                    <li><a href="#">Camcorders</a></li>
                                                    <li><a href="#">Camera Drones</a></li>
                                                    <li><a href="#">Action Cameras</a></li>
                                                    <li><a href="#">Photo Studio Supplie</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span><strong>Smart Electronics</strong></span>
                                                </a>
                                                <ul class="submenu-item">
                                                    <li><a href="#">Wearable Devices</a></li>
                                                    <li><a href="#">Smart Home Appliances</a></li>
                                                    <li><a href="#">Smart Remote Controls</a></li>
                                                    <li><a href="#">Smart Watches</a></li>
                                                    <li><a href="#">Smart Wristbands</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span><strong>Audio & Video</strong></span>
                                                </a>
                                                <ul class="submenu-item">
                                                    <li><a href="#">Televisions</a></li>
                                                    <li><a href="#">TV Receivers</a></li>
                                                    <li><a href="#">Projectors</a></li>
                                                    <li><a href="#">Audio Amplifier Boards</a></li>
                                                    <li><a href="#">TV Sticks</a></li>
                                                </ul>
                                            </li>
                                        </ul> -->
                                <!-- sub menu -->
                                <!-- </li>
                                    <li class="menu-item">
                                        <a href="#">Video Games <i class="ion-ios-arrow-right"></i></a>
                                        <ul class="sub-menu sub-menu-2">
                                            <li>
                                                <ul class="submenu-item">
                                                    <li><a href="#">Handheld Game Players</a></li>
                                                    <li><a href="#">Game Controllers</a></li>
                                                    <li><a href="#">Joysticks</a></li>
                                                    <li><a href="#">Stickers</a></li>
                                                </ul>
                                            </li>
                                        </ul> -->
                                <!-- sub menu -->
                                <!-- </li>
                                    <li class="menu-item"><a href="#">Digital Cameras</a></li>
                                    <li class="menu-item"><a href="#">Headphones</a></li>
                                    <li class="menu-item"><a href="#"> Wearable Devices</a></li>
                                    <li class="menu-item"><a href="#"> Smart Watches</a></li>
                                    <li class="menu-item"><a href="#"> Game Controllers</a></li>
                                    <li class="menu-item"><a href="#"> Smart Home Appliances</a></li> -->
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
                                        <li class="menu-item-has-children menu-item-has-children-1"><a href="shop-left-sidebar.php?category=<?php echo $row['category'] ?>"><?php echo $row['category'] ?></a>
                                        </li>
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
                            <li>My Order</li>
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
    // 
    ?>
    <div class="cart-main-area mtb-50px">
        <div class="container">
            <h3 class="cart-page-title">Orders</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- <form action="#"> -->
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>All Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $check_mail = $_SESSION['eth_id'];
                                $limit = 2;
                                $offset = ($page - 1) * $limit;
                                $query = "SELECT * FROM `order_details_header` WHERE  `account_id`='$check_mail' ORDER BY `order_details_header`.`order_details_header_id` DESC LIMIT {$offset},{$limit}";
                                $result = mysqli_query($link, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $payment_status = "Processing";
                                        $color_text = "black";
                                        $show_d_time = "";
                                        if ($row['capture_status'] == "Payment successful") {
                                            $payment_status = "Successful";
                                            $color_text = "green";
                                        } else {
                                            $payment_status = "Failed";
                                            $color_text = "red";
                                            $show_d_time = "---";
                                        }
                                        $my_order_id = $row['order_id'];
                                ?>
                                        <tr>
                                            <td>
                                                <div class="container mt-3 mt-md-5">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="list-group mb-5">
                                                                <div class="list-group-item p-3 bg-snow" style="position: relative;">
                                                                    <div class="row w-100 no-gutters">
                                                                        <div class="col-6 col-md mt-2">
                                                                            <h6 class="text-charcoal mb-0 w-100">Order Number
                                                                            </h6>
                                                                            <a href="trackorder.php?order_id=<?php echo $row['order_id'] ?>" class="text-pebble mb-0 w-100 mb-2 mb-md-0">#<?php echo $row['order_id'] ?></a>
                                                                        </div>
                                                                        <div class="col-6 col-md mt-2">
                                                                            <h6 class="text-charcoal mb-0 w-100">Date</h6>
                                                                            <p class="text-pebble mb-0 w-100 mb-2 mb-md-0"><?php $old_date = strtotime($row['time']);
                                                                                                                            $order_time = date('D, d M Y h:i:sa', $old_date);
                                                                                                                            echo $order_time; ?></p>
                                                                        </div>
                                                                        <div class="col-6 col-md mt-2">
                                                                            <h6 class="text-charcoal mb-0 w-100">Coupon Discount</h6>
                                                                            <p class="text-pebble mb-0 w-100 mb-2 mb-md-0">
                                                                                <?php echo $row['coupon_code_discount'] ?>%</p>
                                                                        </div>
                                                                        <div class="col-6 col-md mt-2">
                                                                            <h6 class="text-charcoal mb-0 w-100">Total</h6>
                                                                            <p class="text-pebble mb-0 w-100 mb-2 mb-md-0">
                                                                                &#8377;<?php echo number_format($row['order_total_price'], 2) ?></p>
                                                                        </div>
                                                                        <div class="col-6 col-md mt-2">
                                                                            <h6 class="text-charcoal mb-0 w-100">Payment Status</h6>
                                                                            <p class="text-pebble mb-0 w-100 mb-2 mb-md-0"><?php echo $payment_status ?></p>
                                                                        </div>
                                                                        <div class="col-12 col-md-3 mt-2">
                                                                            <a href="trackorder.php?order_id=<?php echo $row['order_id'] ?>" class="btn my-btn w-100">Track Order</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="list-group-item p-3 bg-white">
                                                                    <div class="row no-gutters">
                                                                        <div class="col-12 col-md-9 pr-0 pr-md-3">
                                                                            <div class="alert p-2 alert-success w-100 mb-0">
                                                                                <h6 class="text-green mb-0 float-left"><b>Delivery Status</b></h6>
                                                                                <p class="text-green hidden-sm-down mb-0 text-capitalize"><?php echo $row['delivery_status'] ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    $query2 = "SELECT * FROM  `order_details_lines` INNER JOIN product_tbl ON order_details_lines.product_ids=product_tbl.id WHERE `order_id`='$my_order_id'";
                                                                    $result2 = mysqli_query($link, $query2);
                                                                    if (mysqli_num_rows($result2) > 0) {
                                                                        while ($row = mysqli_fetch_assoc($result2)) {
                                                                            $url_sku_size = '';
                                                                            if($row['extra_small_size'] !== ''){
                                                                                $url_sku_size = 'XS';
                                                                            }else if($row['small_size'] !== ''){
                                                                                $url_sku_size = 'S';
                                                                            }else if($row['medium_size'] !== ''){
                                                                                $url_sku_size = 'M';
                                                                            }else if($row['large_size'] !== ''){
                                                                                $url_sku_size = 'L';
                                                                            }
                                                                            else if($row['extra_large_size'] !== ''){
                                                                                $url_sku_size = 'XL';
                                                                            }
                                                                    ?>
                                                                            <div class="row no-gutters mt-4">
                                                                                <div class="col-3 col-md-1">
                                                                                    <img loading="lazy" class="img-fluid pr-3" src="<?php echo $img_link ?>images/product-image/<?php echo $row['image'] ?>" alt="">
                                                                                </div>
                                                                                <div class="col-9 col-md-8 pr-0 pr-md-3">
                                                                                    <h6 class="text-charcoal mb-2 mb-md-1">
                                                                                        <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>" class="text-charcoal"><?php echo $row['product_quantity'] ?> x <?php echo $row['name'] ?></a>
                                                                                    </h6>
                                                                                    <h6 class="text-charcoal mb-0 mb-md-2">
                                                                                        <b>&#8377;<?php echo ($row['product_total_price'] - $row['shipping_charge']) ?></b>
                                                                                    </h6>
                                                                                    <ul class="list-unstyled text-pebble mb-2 small">
                                                                                        <li class="">
                                                                                            <b>+</b>
                                                                                        </li>
                                                                                        <li class="">
                                                                                            <b>Shipping Charge:</b> &#8377;<?php echo $row['shipping_charge'] ?>
                                                                                        </li>
                                                                                    </ul>

                                                                                </div>
                                                                            </div>

                                                                    <?php }
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- </form> -->
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- </form> -->
                    <!--  Pagination Area Start -->
                    <div class="pro-pagination-style text-center mtb-50px">
                        <!-- pagination code start -->
                        <?php

                        $query1 = "SELECT * FROM `order_details_header` WHERE  `email`='$check_mail' ORDER BY `order_details_header`.`order_details_header_id` DESC";
                        $result1 = mysqli_query($link, $query1);
                        if (mysqli_num_rows($result1) > 0) {
                            $link_value = '';
                            $total_records = mysqli_num_rows($result1);
                            $limit = 2;
                            $total_page = ceil($total_records / $limit);
                            if (isset($_GET['category'])) {
                                $link_value = "category={$product_category}&";
                            } else {
                                $link_value = '';
                            }
                        ?>
                            <ul>
                                <li>
                                    <a class="prev" href="my_order.php?<?php echo $link_value ?>page=<?php if ($page <= 1) {
                                                                                                            echo ($page);
                                                                                                        } else {
                                                                                                            echo ($page - 1);
                                                                                                        } ?>"><i class="ion-ios-arrow-left"></i></a>
                                </li>
                                <?php
                                                    $beforePage = $page - 1;
                                                    $afterPage = $page + 1;
                                                    if ($page > 2) {
                                                        echo "<li><a href='my_order.php?{$link_value}page=1'>1</a></li>";
                                                        if ($page > 3) {
                                                            echo "<li><a>...</a></li>";
                                                        }
                                                    }
                                                    if ($page == $total_page) {
                                                        $beforePage = $beforePage - 2;
                                                    } elseif ($page == $total_page - 1) {
                                                        $beforePage = $beforePage - 1;
                                                    }

                                                    if ($page == 1) {
                                                        $afterPage = $afterPage + 2;
                                                    } elseif ($page == 2) {
                                                        $afterPage = $afterPage + 1;
                                                    }

                                                    for ($i = $beforePage; $i <= $afterPage; $i++) {
                                                        if ($i > 0 && $i <= $total_page) {
                                                            if ($i == $page) {
                                                                echo "<li ><a class='active'>{$i}</a></li>";
                                                            } else {
                                                                echo "<li><a href='my_order.php?{$link_value}page={$i}'>{$i}</a></li>";
                                                            }
                                                        }
                                                    }

                                                    if ($page < $total_page - 1) {
                                                        if ($page < $total_page - 2) {
                                                            echo "<li><a>...</a></li>";
                                                        }
                                                        echo "<li><a href='my_order.php?{$link_value}page={$total_page}'>{$total_page}</a></li>";
                                                    }

                                                    ?>
                                <li><a class="next" href="my_order.php?<?php echo $link_value ?>page=<?php if ($page >= $total_page) {
                                                                                                            echo $page;
                                                                                                        } else {
                                                                                                            echo $page + 1;
                                                                                                        } ?>"><i class="ion-ios-arrow-right"></i></a></li>
                            </ul>
                        <?php
                        }
                        ?>
                        <!-- pagination code end -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php  //} 
    ?>
    <!-- ------------------------ page end from here ------------------------- -->
    <!-- Arrivals Area Start -->
    <div class="arrival-area single-product-nav mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="section-heading">Our Other Products:</h2>
                    </div>
                </div>
            </div>
            <!-- Arrivel slider start -->
            <div class="arrival-slider-wrapper slider-nav-style-1">
                <?php
                $query = "SELECT * FROM product_tbl ORDER BY rand() ASC LIMIT 6";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    $show_hide = 'd-inline-block';
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['sale_price'] == $row['cost_price']) {
                            $show_hide = 'd-none';
                        } else {
                            $show_hide = 'd-inline-block';
                        }
                        $url_sku_size = '';
                        if($row['extra_small_size'] !== ''){
                            $url_sku_size = 'XS';
                        }else if($row['small_size'] !== ''){
                            $url_sku_size = 'S';
                        }else if($row['medium_size'] !== ''){
                            $url_sku_size = 'M';
                        }else if($row['large_size'] !== ''){
                            $url_sku_size = 'L';
                        }
                        else if($row['extra_large_size'] !== ''){
                            $url_sku_size = 'XL';
                        }
                ?>
                        <div class="slider-single-item">
                            <!-- Single Item -->
                            <article class="list-product text-center">
                                <div class="product-inner">
                                    <div class="img-block">
                                        <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>" class="thumbnail">
                                            <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $row['image'] ?>" alt="" />
                                            <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $row['image2'] ?>" alt="" />
                                        </a>
                                        <div class="add-to-link">
                                            <ul>
                                                <li>
                                                <a class="quick_view" href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j]['sku'] ?>" data-link-action="quickview" title="Quick view" >
                                                        <i class="lnr lnr-magnifier"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="post">
                                                        <input type="hidden" name="wishid" value="<?php echo $row['id']; ?>" id="wishid">
                                                        <button><a title="Add to Wishlist"><i class="lnr lnr-heart"></i></a></button>
                                                    </form>
                                                </li>
                                                <!-- <li>
                                            <a href="compare.php" title="Add to compare"><i
                                                    class="lnr lnr-sync"></i></a>
                                        </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new <?php echo $show_hide ?>">
                                            -<?php echo number_format((($row['cost_price'] - $row['sale_price']) / $row['cost_price']) * 100, 2); ?>%
                                        </li>
                                    </ul>
                                    <div class="product-decs">
                                <a class="inner-link" href="/"><span><?php echo $row['design'] ?></span></a>
                                <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>"
                                        class="product-link"><?php echo $row['name'] ?></a></h2>
                                <div class="pricing-meta">
                                    Available Size :
                                    <ul class="size_chart2" id="size_chart<?php echo $row['id']; ?>">
                                        <?php
                                                if ($row['extra_small_size'] == 'XS') {
                                                ?>
                                        <li style="color:#272727;" class="mr-1">XS</li>
                                        <?php
                                                } else {
                                                ?>
                                        <li style="color:#272727;" class="mr-1 d-none">XS</li>
                                        <?php
                                                }
                                                ?>
                                        <?php
                                                if ($row['small_size'] == 'S') {
                                                ?>
                                        <li style="color:#272727;" class="mr-1">S</li>
                                        <?php
                                                } else {
                                                ?>
                                        <li style="color:#272727;" class="mr-1 d-none">S</li>
                                        <?php
                                                }
                                                ?>
                                        <?php
                                                if ($row['medium_size'] == 'M') {
                                                ?>
                                        <li style="color:#272727;" class="mr-1">M</li>
                                        <?php
                                                } else {
                                                ?>
                                        <li style="color:#272727;" class="mr-1 d-none">M</li>
                                        <?php
                                                }
                                                ?>
                                        <?php
                                                if ($row['large_size'] == 'L') {
                                                ?>
                                        <li style="color:#272727;" class="mr-1">L</li>
                                        <?php
                                                } else {
                                                ?>
                                        <li style="color:#272727;" class="mr-1 d-none">L</li>
                                        <?php
                                                }
                                                ?>
                                        <?php
                                                if ($row['extra_large_size'] == 'XL') {
                                                ?>
                                        <li style="color:#272727;" class="mr-1">XL</li>
                                        <?php
                                                } else {
                                                ?>
                                        <li style="color:#272727;" class="mr-1 d-none">XL</li>
                                        <?php
                                                }
                                                ?>
                                    </ul>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="old-price <?php echo $show_hide ?>">
                                            &#8377;<?php echo $row['cost_price'] ?></li>
                                        <li class="current-price">&#8377;<?php echo $row['sale_price'] ?></li>
                                    </ul>
                                </div>
                            </div>
                                    <!-- <div class="cart-btn">
                                        <form method="post">
                                            <input type="hidden" name="id2" value="<?php echo $row['id']; ?>" id="id2">
                                            <button><a class="add-to-curt" title="Add to cart">Add to cart</a></button>
                                        </form>
                                    </div> -->
                                </div>
                            </article>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <!-- Arrivel slider end -->
        </div>
    </div>
    <!-- Arrivals Area End -->
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-lm-100px mb-sm-30px">
                            <div class="quickview-wrapper">
                                <!-- slider -->
                                <div class="gallery-top">
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img1" src=" <?php echo $img_link ?>images/product-image/8.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img2" src=" <?php echo $img_link ?>images/product-image/14.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img3" src=" <?php echo $img_link ?>images/product-image/15.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img4" src=" <?php echo $img_link ?>images/product-image/11.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img5" src=" <?php echo $img_link ?>images/product-image/19.jpg" alt="">
                                    </div>
                                </div>
                                <div class=" gallery-thumbs">
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img1" src=" <?php echo $img_link ?>images/product-image/8.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img2" src=" <?php echo $img_link ?>images/product-image/14.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img3" src=" <?php echo $img_link ?>images/product-image/15.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img4" src=" <?php echo $img_link ?>images/product-image/11.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img loading="lazy" class="img-responsive size m-auto img5" src=" <?php echo $img_link ?>images/product-image/19.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content">
                                <h2 id="model_name">Originals Kaval Windbr</h2>
                                <p class="reference" id="model_design">Collection:<span> demo_17</span></p>
                                <div class="pro-details-rating-wrap">
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <span class="read-review"><a class="reviews" href="#">Read reviews (1)</a></span>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="old-price not-cut" id="model_old_price">&#8377;<span id="model_cost_price">18.90</span></li>
                                        <li class="current-price not-cut">&#8377;<span id="model_sale_price">18.90</span></li>
                                    </ul>
                                </div>
                                <p class="quickview-para" id="model_desc">Lorem ipsum dolor sit amet, consectetur adipisic elit eiusm tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim venialo quis nostrud exercitation ullamco</p>
                                <div class="pro-details-size-color">
                                    <div class="pro-details-color-wrap">
                                        <span>Color</span>
                                        <div class="pro-details-color-content">
                                            <ul>
                                                <li class="blue"></li>
                                                <li class="maroon active"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-details-quality">
                                    <!-- <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                                        </div> -->
                                    <div class="pro-details-cart btn-hover">
                                        <form method="post">
                                            <input type="hidden" name="id" id="model_id">
                                            <button><a>Add To Cart</a></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="pro-details-wish-com">
                                    <div class="pro-details-wishlist">
                                        <a href="wishlist.php"><i class="ion-android-favorite-outline"></i>Add to wishlist</a>
                                    </div>
                                    <div class="pro-details-compare">
                                        <a href="compare.php"><i class="ion-ios-shuffle-strong"></i>Add to compare</a>
                                    </div>
                                </div>
                                <div class="pro-details-social-info">
                                    <span>Share</span>
                                    <div class="social-info">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="ion-social-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-social-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-social-google"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-social-instagram"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
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
        /* --------------------- news letter functionality start -------------------- */
        $('#desktop_newsletter').click(function() {

            var email = $("#footer-subscribe-email_desktop").val();
            var error = "";

            function validateEmail(email) {
                var re =
                    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
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
        function fetchProduct(product_id) {
            $.ajax({
                type: 'POST',
                url: 'php/fetch_product_data.php',
                dataType: "json",
                async: false,
                data: {
                    product_id: product_id
                },
                //success function
                success: function(data) {
                    if (data.status == 201) {
                        // console.log(data);               
                        $('#model_name').html(data.name);
                        $('#model_design').html((data.design));
                        $('#model_desc').html(data.product_desc);
                        $('#model_cost_price').html((data.cost_price));
                        $('#model_sale_price').html(data.sale_price);
                        if ((data.sale_price) == (data.cost_price)) {
                            $('#model_old_price').css('display', 'none');
                        } else {
                            $('#model_old_price').css('display', 'inline-block');
                        }
                        $('#model_id').val(data.id);
                        $('.img1').attr('src', '<?php echo $img_link ?>images/product-image/' + data.slider_img1);
                        $('.img2').attr('src', '<?php echo $img_link ?>images/product-image/' + data.slider_img2);
                        $('.img3').attr('src', '<?php echo $img_link ?>images/product-image/' + data.slider_img3);
                        $('.img4').attr('src', '<?php echo $img_link ?>images/product-image/' + data.slider_img4);
                        $('.img5').attr('src', '<?php echo $img_link ?>images/product-image/' + data.slider_img5);
                    } else {

                    }
                }
            });
        }
    </script>
</body>

</html>