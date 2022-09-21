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
/* ------------------------ taking parameter form url start and show product----------------------- */

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// Inintialize URL to the variable 
$url = $actual_link;

// Use parse_url() function to parse the URL 
// and return an associative array which 
// contains its various components 
$url_components = parse_url($url);

// Use parse_str() function to parse the 
// string passed via URL 
parse_str($url_components['query'], $params);

// Display result 
// echo ' Hi '.$params['id'];
$product_id = $params['order_id'];
if ($product_id == "") {
    header("Location:/");
}
// echo $params['order_id'];
$q = "SELECT * FROM order_details_lines WHERE order_id='$product_id'";
$res = mysqli_query($link, $q);
if (!mysqli_num_rows($res) > 0) {
    header("Location:/");
}
/* ------------------------ taking parameter form url end and show product----------------------- */
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
        /* @import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700'); */

        /* * {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
} */



        .iphone {
            margin-top: 10px;
            background-color: #F4F4FB;
            height: 812px;
            /* width: 375px; */
            width: 100%;
            box-shadow: 0 1px 5px -1px rgba(0, 0, 0, 0.3), inset 0 0 0 1px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            z-index: 2;
            /* transform: scale(0.8); */
            transform-origin: top center;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 20%;
        }

        .order-summary {
            margin-left: 1.5rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        .order-summary>div {
            margin: 6px;
        }

        .order-status {
            color: #338A9A;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .order-date {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .order-day {
            color: #338A9A;
            font-size: 0.9rem;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .back-btn {
            margin-right: 50px;
            font-size: 1rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            box-shadow: 5px 5px 25px 0px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .back-btn:hover {
            transform: scale(1.2);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        .hero-img-container {
            width: 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding-bottom: 20px;
        }

        .hero-img-container::before {
            height: 20px;
            width: 20px;
            background-color: #0268EE;
            position: absolute;
            top: 25px;
            right: 150px;
            content: '';
            border-radius: 50%;
        }

        .arc {
            border: 1px solid #000;
            display: inline-block;
            min-width: 200px;
            min-height: 200px;
            padding: 0.5em;
            border-radius: 50%;
            border-top-color: transparent;
            border-left-color: transparent;
            border-bottom-color: transparent;
            opacity: 0.4;
            position: absolute;
            transform: rotate(-40deg);
            left: -10px;
        }

        .pattern {
            width: 50px;
            height: 50px;
            background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPScxMCcgaGVpZ2h0PScxMCc+CiAgPHJlY3Qgd2lkdGg9JzEwJyBoZWlnaHQ9JzEwJyBmaWxsPSd3aGl0ZScgLz4KICA8Y2lyY2xlIGN4PSc0JyBjeT0nNCcgcj0nNCcgZmlsbD0nYmxhY2snLz4KPC9zdmc+");
            opacity: 0.1;
            position: absolute;
            right: 30px;
            top: 30px;
            transform: scale(1.2);
        }

        .triangle1 {
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 10px 20px 10px;
            border-color: transparent transparent rgba(38, 108, 251, 0.85) transparent;
            position: absolute;
            top: 50px;
            left: 130px;
            transform: rotate(-45deg);
        }

        .hero-img {
            width: 80%;
        }

        .order-status-container {
            z-index: 3;
            display: flex;
            width: 100%;
            height: 230px;
            justify-content: space-evenly;
            align-items: center;
            background-color: white;
            /* border-top-right-radius: 50px;
    border-top-left-radius: 50px; */
            position: relative;
            /* box-shadow: 0 14px 28px rgba(0, 0, 0, 0.02), 0 10px 10px rgba(0, 0, 0, 0.2); */
        }

        @media only screen and (max-width:991px) {
            .order-status-container {
                z-index: 3;
                display: flex;
                width: 100%;
                height: 230px;
                justify-content: space-evenly;
                align-items: center;
                background-color: white;
                /* border-top-right-radius: 50px;
    border-top-left-radius: 50px; */
                position: relative;
                /* box-shadow: 0 14px 28px rgba(0, 0, 0, 0.02), 0 10px 10px rgba(0, 0, 0, 0.2); */
            }
        }

        @media only screen and (max-width:991px) {
            .iphone {
                margin-top: 10px;
                background-color: #F4F4FB;
                height: 100%;
                /* width: 375px; */
                width: 100%;
                box-shadow: 0 1px 5px -1px rgba(0, 0, 0, 0.3), inset 0 0 0 1px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                position: relative;
                z-index: 2;
                /* transform: scale(0.8); */
                transform-origin: top center;
            }
        }

        .order-status-container::before {
            content: '';
            position: absolute;
            width: 70px;
            height: 3px;
            background-color: #EAEBFF;
            opacity: 0.8;
            border-radius: 2px;
            top: 20px;
        }

        .status-item {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            height: 150px;
            padding-top: 24px;
        }

        @media only screen and (max-width:991px) {
            .status-item {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                height: 150px;
                padding-top: 22px;
            }
        }

        .status-item>div {
            margin: 10px;
        }

        .status-circle {
            height: 20px;
            width: 20px;
            background-color: rgba(38, 108, 251, 0.85);
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            z-index: 5;
            transition: all 0.2s;
            cursor: pointer;
        }

        .status-circle:hover {
            transform: scale(1.2);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        .status-text {
            font-size: 0.9rem;
            text-transform: capitalize;
            font-weight: 700;
        }

        .status-text span {
            display: block;
            text-align: center;
            padding: 2px;
        }

        .green {
            color: #338A9A;
        }

        /* order tracking functionality start */
        <?php
        $set_track_value = 0;
        $set_extra = 0;
        $order_track = '';
        $query = "SELECT * FROM `order_details_header` WHERE `order_id`='$product_id'";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $order_track = $row['delivery_status'];
            }
            if ($order_track == "delivered") {
                $set_track_value = 65.2;
                $set_extra = 17.8;
            } else if ($order_track == "ordered") {
                $set_track_value = 12.5;
                $set_extra = 4;
            } else if ($order_track == "shipped") {
                $set_track_value = 21;
                $set_extra = 11;
            } else if ($order_track == "out for delivery") {
                $set_track_value = 44;
                $set_extra = 13;
            } else {
                $set_track_value = 0;
            }
        }

        ?>.first::before {
            content: '';
            height: 4px;
            width: <?php echo $set_track_value ?>%;
            background-color: rgba(38, 108, 251, 0.85);
            position: absolute;
            z-index: 4;
            top: 82px;
            left: 186px;
        }

        .second::before {
            content: '';
            height: 4px;
            width: 65.2%;
            background-color: rgba(38, 108, 251, 0.85);
            position: absolute;
            z-index: 4;
            top: 82px;
            left: 190px;
            opacity: 0.2;
        }

        @media only screen and (max-width: 1200px) {

            .first::before {
                width: <?php echo $set_track_value ?>%;
                left: 16.5%;
            }

            .second::before {
                width: 67%;
                left: 16%;
            }
        }

        @media only screen and (max-width: 991px) {
            .first::before {
                content: '';
                height: 4px;
                width: <?php echo (($set_track_value - 12) + $set_extra - 2) ?>%;
                background-color: rgba(38, 108, 251, 0.85);
                position: absolute;
                z-index: 4;
                top: 81px;
                left: 16%;
            }

            .second::before {
                width: 67%;
                left: 16%;
                top: 81px;
            }
        }

        @media only screen and (max-width: 600px) {
            .first::before {
                content: '';
                height: 4px;
                width: <?php echo (($set_track_value - 12) + $set_extra) ?>%;
                background-color: rgba(38, 108, 251, 0.85);
                position: absolute;
                z-index: 4;
                top: 81px;
                left: 15%;
            }

            .second::before {
                left: 80px;
                width: 70%;
                top: 81px;
            }

            .status-text {
                font-size: 0.8rem;
                text-transform: capitalize;
                font-weight: 700;
            }
        }

        @media only screen and (max-width: 500px) {

            .second::before {
                left: 50px;
                width: 73%;
            }

        }

        /* order tracking functionality end */
        .order-details-container {
            position: relative;
            z-index: 6;
            height: 100%;
            background-color: rgba(38, 108, 251, 0.85);
            /* border-top-right-radius: 50px;
    border-top-left-radius: 50px; */
            padding-top: 20px;
            /* transform: translateY(-45px); */
            /* box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23); */
            cursor: default;
        }

        @media only screen and (max-width:991px) {
            .order-details-container {
                position: relative;
                z-index: 6;
                height: 900px;
                background-color: rgb(68, 128, 249);
                /* border-top-right-radius: 50px;
        border-top-left-radius: 50px; */
                padding-top: 20px;
                /* transform: translateY(-250px); */
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
                cursor: default;
            }
        }

        .odc-header {
            display: none;
            justify-content: center;
            align-items: flex-start;
        }

        .cta-text {
            margin-top: 40px;
            margin-right: 25px;
            color: white;
            font-size: 0.9rem;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.18);
        }

        .cta-button {
            margin-top: 20px;
            padding: 20px 40px;
            background-color: #472D2D;
            border: 0;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.10), 0 6px 6px rgba(0, 0, 0, 0.05);
            animation: shadow-pulse 1s infinite;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #1d1d1d;
        }

        @keyframes shadow-pulse {
            0% {
                box-shadow: 0 0 0 0px rgba(255, 255, 255, 0.2);
            }

            100% {
                box-shadow: 0 0 0 35px rgba(255, 255, 255, 0);
            }
        }

        .cta-button:focus {
            outline: none;
        }

        .order-details-container::before {
            content: '';
            position: absolute;
            width: 70px;
            height: 3px;
            background-color: #EAEBFF;
            opacity: 0.8;
            border-radius: 2px;
            top: 20px;
            left: 42%;
        }

        @media only screen and (max-width:991px) {
            .order-details-container::before {
                content: '';
                position: absolute;
                width: 70px;
                height: 3px;
                background-color: #EAEBFF;
                opacity: 0.8;
                border-radius: 2px;
                top: 20px;
                left: 42%;
            }
        }

        .odc-wrapper {
            margin: 30px;
        }

        .odc-header-line {
            margin-top: 30px;
            color: white;
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 40px
        }

        .odc-header-details {
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-container {
            background-color: #669fff;
            border-radius: 20px;
            padding: 25px;
        }

        .product {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .product span {
            display: block;
            color: white;
            margin-left: 25px;
            margin-bottom: 8px;
            flex-grow: 1;
        }

        .product span:first-child {
            font-weight: 300;
            font-size: 0.8rem;
        }

        .product span:last-child {
            font-weight: 500;
            font-size: 1.3rem;
        }

        .img-photo {
            width: 90px;
            /* transform: rotate(-35deg) */
        }

        @media only screen and (max-width:991px) {
            .img-photo {
                width: 60px !important;
                /* transform: rotate(-35deg) */
            }
        }

        .cancellation {
            margin-top: 20px;
            background-color: #669fff;
            border-radius: 20px;
            padding: 30px 20px;
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .shipping-desc {
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .shipping-address {
            margin-top: 20px;
            background-color: #669fff;
            border-radius: 20px;
            padding: 20px 20px;
            color: white;
            font-weight: bold;
            margin-bottom: 20px;

        }

        .footer {
            position: absolute;
            bottom: 15px;
            right: 15px;
            font-size: 0.9rem;
        }

        .footer small {
            font-size: 0.7rem;
        }

        .footer a {
            color: #3273dc;
            cursor: pointer;
            text-decoration: none;
            border-bottom: 2px solid rgba(50, 115, 220, .1);
            padding-bottom: 2px;
        }

        .footer a:hover {
            color: #1e57b4;
            border-bottom-color: #1e57b4;
        }

        .slide_up_active {
            /* transform: translateY(-250px); */
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

    <!-- ------------------------ page start form here ------------------------- -->

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="/">Home</a></li>
                            <li><a href="/">Shop</a></li>
                            <li>Track Order</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <!-- Track Order Start -->
    <?php
    $q = "SELECT * FROM `order_details_header` INNER JOIN `order_details_lines` ON order_details_header.order_id=order_details_lines.order_id INNER JOIN product_tbl ON order_details_lines.product_ids=product_tbl.id WHERE order_details_header.order_id='$product_id'";
    $res = mysqli_query($link, $q);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $order_id = $row['order_id'];
            $delivery_time = $row['delivery_time'];
            $order_name = $row['name'];
            $order_time = $row['time'];
            $shipping_charge = $row['shipping_charge'];
            $payment_status = $row['payment_status'];
            $order_total_price = $row['order_total_price'];
            $order_coupon_discount = $row['coupon_code_discount'];
            $payment_status = "Processing";
            $color_text = "black";
            $show_d_time = "";
            $payment_id = "";
            $show = "none";
            if ($row['capture_status'] == "Payment successful") {
                $payment_status = "Successful";
                $color_text = "green";
                $show_d_time = $row['delivery_time'];
                $payment_id = $row['payment_id'];
                $show = "block";
            } else {
                $payment_status = "Failed";
                $color_text = "red";
                $show_d_time = "---";
                $payment_id = "---";
                $show = "none";
            }
        }

    ?>

        <!-- ---------------------------- Desktop view start --------------------------- -->
        <div class="d-none d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-12 pt-5">
                        <div class="header">
                            <div class="order-summary pb-5">
                                <div class="order-status">Arriving date</div>
                                <div class="order-date">
                                    <?php $date = explode(",", $delivery_time);
                                    if ($show_d_time != "---") {
                                        echo $date[1];
                                    } else {
                                        echo $show_d_time;
                                    }
                                    ?>
                                </div>
                                <div class="order-day">
                                    <?php
                                    if ($show_d_time != "---") {
                                        if ($date[0] == "Mon") {
                                            echo "Monday";
                                        } else if ($date[0] == "Tue") {
                                            echo "Tuesday";
                                        } else if ($date[0] == "Wed") {
                                            echo "Wednesday";
                                        } else if ($date[0] == "Thu") {
                                            echo "Thursday";
                                        } else if ($date[0] == "Fri") {
                                            echo "Friday";
                                        } else if ($date[0] == "Sat") {
                                            echo "Saturday";
                                        } else {
                                            echo "Sunday";
                                        }
                                    } else {
                                        echo $show_d_time;
                                    }

                                    ?>
                                </div>
                            </div>
                            <!-- <div class="action-btn">
                            <div class="back-btn"><i class="far fa-long-arrow-left"></i></div>
                        </div> -->
                        </div>
                        <!-- <div class="hero-img-container">
                        <div class="triangle1"></div>
                        <div class="arc"></div>
                        <div class="pattern"></div>
                        <img loading="lazy" src="<?php echo $img_link ?>images/TrackOrder/relax.svg" class="hero-img">
                    </div> -->
                        <div class="mt-3 order-status-container shadow">
                            <div class="status-item first">
                                <div class="status-circle"></div>
                                <div class="status-text">
                                    today
                                </div>
                            </div>
                            <div class="status-item second">
                                <div class="status-circle"></div>
                                <div class="status-text">
                                    Shipped
                                </div>
                            </div>
                            <div class="status-item">
                                <div class="status-circle"></div>
                                <div class="status-text green">
                                    <span>Out</span><span>for delivery</span>
                                </div>
                            </div>
                            <div class="status-item">
                                <div class="status-circle"></div>
                                <div class="status-text green">
                                    <span>Ariving</span>
                                    <span>03&nbsp;-&nbsp;05</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-5 pb-5">
                        <div class="order-details-container" style="transition:all 0.8s;border-radius:20px;">
                            <div class="odc-header">
                                <div class="cta-text"> Ordered : <?php echo $order_time; ?></div>
                            </div>
                            <div class="odc-wrapper">
                                <div class="odc-header-line">
                                    Your order details
                                </div>
                                <div class="odc-header-details">
                                    Your product details (order-id : <?php echo $order_id; ?>)
                                </div>
                                <div class="product-container">
                                    <?php $q = "SELECT * FROM `order_details_header` INNER JOIN `order_details_lines` ON order_details_header.order_id=order_details_lines.order_id INNER JOIN product_tbl ON order_details_lines.product_ids=product_tbl.id WHERE order_details_header.order_id='$product_id'";
                                    $res = mysqli_query($link, $q);
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $product_quantity = $row['product_quantity'];
                                            $show_quantity = "";
                                            if ($product_quantity == 1) {
                                                $show_quantity = "none";
                                            } else {
                                                $show_quantity = "block";
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
                                            <div class="product mt-2 border">
                                                <div class="product-photo">
                                                    <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>"><img loading="lazy" src="<?php echo $img_link ?>images/product-image/<?php echo $row['image'] ?>" class="img-photo"></a>
                                                </div>
                                                <div class="product-desc">
                                                    <span><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>" style="color:#fff"><?php echo $row['name']; ?></a></span>
                                                    <div class="d-flex text-white" style="margin-left: 25px;">
                                                        <div style="font-size: 23px;">&#8377;<?php echo (($row['product_total_price'] - $row['shipping_charge']) / $row['product_quantity']) ?></div>
                                                        <div style="font-size:13px;margin-top:7px;margin-left:2px;display:<?php echo $show_quantity ?>"> x <?php echo $product_quantity ?>(Quantity)</div><?php ?>
                                                    </div>
                                                    <div style="margin-left: 25px;color: #fff;font-size: 12px;">+
                                                        &#8377;<?php echo $shipping_charge ?> shipping charge</div>
                                                </div>
                                            </div> <?php }
                                            } ?>

                                </div>
                                <div style="margin-top: 20px;
                                    background-color: #669fff;
                                    border-radius: 20px;
                                    padding: 30px 20px;
                                    color: white;
                                    font-weight: bold;
                                    margin-bottom: 20px;
                                    text-align: left;">
                                    <div class="mb-2">Coupon Discount : <?php echo $order_coupon_discount ?>%</div>
                                    <div class="mb-2" style="font-size:20px;">Total Amount : &#8377;<?php echo $order_total_price ?></div>

                                    <a href="#" class="text-white">Payment ID : <?php echo $payment_id ?></a>
                                    <div class="mt-2"><a href="#" class="text-white">Payment Status : <span style="background:<?php echo $color_text ?>;padding: 2px 6px;"><?php echo $payment_status ?></span></a>
                                    </div>
                                </div>
                                <!-- <div class="cancellation" style="display:<?php echo $show; ?>">
                                <a href="#" class="text-white">Request Cancellation</a>
                            </div> -->

                                <div class="shipping-desc">Your Shipping Address</div>
                                <?php $q = "SELECT * FROM `shipping_details` WHERE order_id='$product_id'";
                                $res = mysqli_query($link, $q);
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $add = explode("__", $row['address']);

                                ?>
                                        <div class="shipping-address">
                                            <?php echo $add[0]; ?><br>
                                            <?php echo $add[1]; ?><br>
                                            <?php echo $add[2]; ?><br>
                                            <?php echo $add[3]; ?><br>
                                            <?php echo $add[4] . "  " . $add[5]; ?>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ---------------------------- Desktop view end --------------------------- -->
        <!-- ---------------------------- mobile view start --------------------------- -->

        <div class="d-lg-none position-relative">
            <div class="container-fluid">
                <div class="row">
                    <div class="col pt-5 pl-0 pr-0">
                        <div class="iphone">
                            <div class="header">
                                <div class="order-summary">
                                    <div class="order-status">Arriving date</div>
                                    <div class="order-date">
                                        <!-- 03 Mar, 2019 -->
                                        <?php $date = explode(",", $delivery_time);
                                        if ($show_d_time != "---") {
                                            echo $date[1];
                                        } else {
                                            echo $show_d_time;
                                        }
                                        ?>
                                    </div>
                                    <div class="order-day">
                                        <?php
                                        if ($show_d_time != "---") {
                                            if ($date[0] == "Mon") {
                                                echo "Monday";
                                            } else if ($date[0] == "Tue") {
                                                echo "Tuesday";
                                            } else if ($date[0] == "Wed") {
                                                echo "Wednesday";
                                            } else if ($date[0] == "Thu") {
                                                echo "Thursday";
                                            } else if ($date[0] == "Fri") {
                                                echo "Friday";
                                            } else if ($date[0] == "Sat") {
                                                echo "Saturday";
                                            } else {
                                                echo "Sunday";
                                            }
                                        } else {
                                            echo $show_d_time;
                                        }

                                        ?>

                                    </div>
                                </div>
                                <div class="action-btn" style="display:none">
                                    <div class="back-btn"><i class="fas fa-arrow-left"></i></div>
                                </div>
                            </div>
                            <!-- <div class="hero-img-container">
                            <div class="triangle1"></div>
                            <div class="arc"></div>
                            <div class="pattern"></div>
                            <img loading="lazy" src="<?php echo $img_link ?>images/TrackOrder/relax.svg" class="hero-img">
                        </div> -->
                            <div class="order-status-container shadow">
                                <div class="status-item first">
                                    <div class="status-circle"></div>
                                    <div class="status-text">
                                        today
                                    </div>
                                </div>
                                <div class="status-item second">
                                    <div class="status-circle"></div>
                                    <div class="status-text">
                                        Shipped
                                    </div>
                                </div>
                                <div class="status-item">
                                    <div class="status-circle"></div>
                                    <div class="status-text green">
                                        <span>Out</span><span>for delivery</span>
                                    </div>
                                </div>
                                <div class="status-item">
                                    <div class="status-circle"></div>
                                    <div class="status-text green">
                                        <span>Ariving</span>
                                        <span>03&nbsp;-&nbsp;05</span>
                                    </div>
                                </div>
                            </div>
                            <div class="order-details-container slideup" style="transition:all 0.8s;">
                                <div class="odc-header">
                                    <div class="cta-text">See your product details</div>
                                    <div class="cta-button-container">
                                        <button class="cta-button">View</button>
                                    </div>
                                </div>
                                <div class="odc-wrapper">
                                    <div class="odc-header-line">
                                        Your order details
                                    </div>
                                    <div class="odc-header-details">
                                        Your product details (order-id : <?php echo $order_id; ?>)
                                    </div>
                                    <div class="product-container">
                                        <?php $q = "SELECT * FROM `order_details_header` INNER JOIN `order_details_lines` ON order_details_header.order_id=order_details_lines.order_id INNER JOIN product_tbl ON order_details_lines.product_ids=product_tbl.id WHERE order_details_header.order_id='$product_id'";
                                        $res = mysqli_query($link, $q);
                                        if (mysqli_num_rows($res) > 0) {
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $product_quantity = $row['product_quantity'];
                                                $show_quantity = "";
                                                if ($product_quantity == 1) {
                                                    $show_quantity = "none";
                                                } else {
                                                    $show_quantity = "block";
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
                                                <div class="product mt-2">
                                                    <div class="product-photo">
                                                        <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>"><img loading="lazy" src="<?php echo $img_link ?>images/product-image/<?php echo $row['image'] ?>" class="img-photo"></a>
                                                    </div>
                                                    <div class="product-desc">
                                                        <span><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>" style="color:#fff"><?php echo $row['name']; ?></a></span>
                                                        <div class="d-flex text-white" style="margin-left: 25px;">
                                                            <div style="font-size: 16px;">&#8377;<?php echo (($row['product_total_price'] - $row['shipping_charge']) / $row['product_quantity']) ?></div>
                                                            <div style="font-size:12px;margin-top:5px;margin-left:2px;display:<?php echo $show_quantity ?>"> x <?php echo $product_quantity ?>(Quantity)</div><?php ?>
                                                        </div>
                                                        <div style="margin-left: 25px;color: #fff;font-size: 12px;margin-top:2px">+
                                                            &#8377;<?php echo $shipping_charge ?> shipping charge</div>
                                                    </div>
                                                </div> <?php }
                                                } ?>

                                    </div>
                                    <div style="margin-top: 20px;
                                    background-color: #669fff;
                                    border-radius: 20px;
                                    padding: 30px 20px;
                                    color: white;
                                    font-weight: bold;
                                    margin-bottom: 20px;
                                    text-align: left;">
                                        <div class="mb-2">Coupon Discount : <?php echo $order_coupon_discount ?>%</div>
                                        <div class="mb-2" style="font-size:18px;">Total Amount : &#8377;<?php echo $order_total_price ?></div>

                                        <a href="#" class="text-white">Payment ID : <?php echo $payment_id ?></a>
                                        <div class="mt-2"><a href="#" class="text-white">Payment Status : <span style="background:<?php echo $color_text ?>;padding: 2px 6px;"><?php echo $payment_status ?></span></a>
                                        </div>
                                    </div>
                                    <!-- <div class="cancellation" style="display:<?php echo $show; ?>">
                                    <a href="#" class="text-white">Request Cancellation</a>
                                </div> -->

                                    <div class="shipping-desc">Your Shipping Address</div>

                                    <?php $q = "SELECT * FROM `shipping_details` WHERE order_id='$product_id'";
                                    $res = mysqli_query($link, $q);
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $add = explode("__", $row['address']);

                                    ?>
                                            <div class="shipping-address">
                                                <?php echo $add[0]; ?><br>
                                                <?php echo $add[1]; ?><br>
                                                <?php echo $add[2]; ?><br>
                                                <?php echo $add[3]; ?><br>
                                                <?php echo $add[4] . "  " . $add[5]; ?>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ----------------------------- mobile view end ---------------------------- -->
    <?php } ?>
    <!-- Track Order End -->
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
    </script>
</body>

</html>