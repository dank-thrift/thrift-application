<?php
session_start();
require_once('php/link.php');
$product_id = "";
$total_image = 0;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
// $product_id = $params['id'];
$sku_base_size = $params['sku_size'];
$sku_base_id = $params['sku_base'];
if ($sku_base_id == "") {
    header("Location:/");
}
$rr = $_GET['sku_base'];
$uid = '';
/* -------------------------- find product category start------------------------- */
$product_category = '';
$q = "SELECT category FROM `product_category` INNER JOIN `product_tbl` ON product_tbl.product_category_id=product_category.product_category_id INNER JOIN `product_subcategory` ON product_tbl.product_subcategory_id=product_subcategory.product_subcategory_id WHERE sku='$rr'";
$res = mysqli_query($link, $q);
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $product_category = $row['category'];
    }
}
//  echo $product_category;

/* ------------------------ find product category end ----------------------- */

$q = "SELECT * FROM product_tbl WHERE `sku`='$sku_base_id'";
$res = mysqli_query($link, $q);
if (!mysqli_num_rows($res) > 0) {
    header("Location:/");
}
/* ------------------------ taking parameter form url end and show product----------------------- */

/* ---------------------------- add to cart start --------------------------- */
if (isset($_POST["id"]) && !empty($_POST["id"]) && (!empty($_POST["qtybutton"]) && isset($_POST["qtybutton"])) && ($sku_base_size) && ($sku_base_id)) {
    $complete_sku = $sku_base_id . "-" . $sku_base_size;
    if ($_POST['qtybutton'] > 0) {
        $qty = round($_POST['qtybutton']);
    } else {
        $qty = 1;
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
    // $product_qty=$_POST["qtybutton"];
    $sale_price = 0;
    $cost_price = 0;
    $q2 = "SELECT `hot_deal_sale_price`,`hot_deal_cost_price` FROM hot_deals WHERE `hot_deals_product_id`=" . $_POST["id"] . "";
    $res2 = mysqli_query($link, $q2);
    if (mysqli_num_rows($res2) > 0) {
        while ($row = mysqli_fetch_assoc($res2)) {
            $sale_price = $row['hot_deal_sale_price'];
            $cost_price = $row['hot_deal_cost_price'];
        }
    } else {
        $q3 = "SELECT `sale_price`,`cost_price` FROM product_tbl WHERE `id`=" . $_POST["id"] . "";
        $res3 = mysqli_query($link, $q3);
        if (mysqli_num_rows($res3) > 0) {
            while ($row = mysqli_fetch_assoc($res3)) {
                $sale_price = $row['sale_price'];
                $cost_price = $row['cost_price'];
            }
        }
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
            // $cost_price=$row['cost_price'];
            // $sale_price=$row['sale_price'];
            // $qty=$product_qty;
            $price1 = $qty * $sale_price;
        }
        if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
            $found = 0;
            foreach ($_COOKIE['item'] as $name1 => $value) {
                $value11 = explode("__", $value);
                if ($image == $value11[0]) {
                    $found = $found + 1;
                    $qty1 = $value11[8] + $qty;
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
    if ($_POST['urlpath'] == 'cart') {
        header("Location:cart");
    } else if ($_POST['urlpath'] == 'checkout') {
        header("Location:checkout");
    } else {
    }
}
/* ----------------------------- add to cart end ---------------------------- */
if (isset($_POST["id2"]) && !empty($_POST["id2"]) && ($sku_base_size) && ($sku_base_id)) {
    $complete_sku = $sku_base_id . "-" . $sku_base_size;
    $d = 0;
    if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
        foreach ($_COOKIE['item'] as $name => $value) {
            $d = $d + 1;
        }
        $d = $d + 1;
    } else {
        $d = $d + 1;
    }
    $sale_price = 0;
    $cost_price = 0;
    $q2 = "SELECT `hot_deal_sale_price`,`hot_deal_cost_price` FROM hot_deals WHERE `hot_deals_product_id`=" . $_POST["id2"] . "";
    $res2 = mysqli_query($link, $q2);
    if (mysqli_num_rows($res2) > 0) {
        while ($row = mysqli_fetch_assoc($res2)) {
            $sale_price = $row['hot_deal_sale_price'];
            $cost_price = $row['hot_deal_cost_price'];
        }
    } else {
        $q3 = "SELECT `sale_price`,`cost_price` FROM product_tbl WHERE `id`=" . $_POST["id2"] . "";
        $res3 = mysqli_query($link, $q3);
        if (mysqli_num_rows($res3) > 0) {
            while ($row = mysqli_fetch_assoc($res3)) {
                $sale_price = $row['sale_price'];
                $cost_price = $row['cost_price'];
            }
        }
    }
    $q = "SELECT * FROM product_tbl WHERE id=" . $_POST['id2'] . "";
    $res = mysqli_query($link, $q);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $design = $row['design'];
            $name = $row['name'];
            $image = $row['image'];
            $image2 = $row['image2'];
            // $cost_price=$row['cost_price'];
            // $sale_price=$row['sale_price'];
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
    if ($_POST['urlpath'] == 'cart') {
        header("Location:cart");
    } else if ($_POST['urlpath'] == 'checkout') {
        header("Location:checkout");
    } else {
    }
}
/* -------------------------- add to wishlist start ------------------------- */

if (isset($_POST["wishid"]) && !empty($_POST["wishid"]) && ($sku_base_size) && ($sku_base_id)) {
    $complete_sku = $sku_base_id . "-" . $sku_base_size;
    $d = 0;
    if (!empty($_COOKIE['wishitem']) && is_array($_COOKIE['wishitem'])) {
        foreach ($_COOKIE['wishitem'] as $name => $value) {
            $d = $d + 1;
        }
        $d = $d + 1;
    } else {
        $d = $d + 1;
    }
    $sale_price = 0;
    $cost_price = 0;
    $q2 = "SELECT `hot_deal_sale_price`,`hot_deal_cost_price` FROM hot_deals WHERE `hot_deals_product_id`=" . $_POST["wishid"] . "";
    $res2 = mysqli_query($link, $q2);
    if (mysqli_num_rows($res2) > 0) {
        while ($row = mysqli_fetch_assoc($res2)) {
            $sale_price = $row['hot_deal_sale_price'];
            $cost_price = $row['hot_deal_cost_price'];
        }
    } else {
        $q3 = "SELECT `sale_price`,`cost_price` FROM product_tbl WHERE `id`=" . $_POST["wishid"] . "";
        $res3 = mysqli_query($link, $q3);
        if (mysqli_num_rows($res3) > 0) {
            while ($row = mysqli_fetch_assoc($res3)) {
                $sale_price = $row['sale_price'];
                $cost_price = $row['cost_price'];
            }
        }
    }
    $q = "SELECT * FROM product_tbl WHERE id=" . $_POST['wishid'] . "";
    $res = mysqli_query($link, $q);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $design = $row['design'];
            $name = $row['name'];
            $image = $row['image'];
            $image2 = $row['image2'];
            // $cost_price=$row['cost_price'];
            // $sale_price=$row['sale_price'];
            $qty = $row['quantity'];
            $price1 = $qty * $sale_price;
        }
        if (!empty($_COOKIE['wishitem']) && is_array($_COOKIE['wishitem'])) {
            $found = 0;
            foreach ($_COOKIE['wishitem'] as $name1 => $value) {
                $value11 = explode("__", $value);

                if ($image == $value11[0]) {
                    $found = $found + 1;
                    $qty1 = $value11[8] + 1;
                    $price1 = $value11[5] * $qty1;
                    setcookie("wishitem[$name1]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty1 . "__" . $price1 . "__" . $name1 . "__" . $complete_sku, time() + (86400 * 30), "/");
                }
            }
            // $d=$name1+1
            $c = 0;
            $a = 0;
            $i = 1;
            while ($a == 0) {
                if (!empty($_COOKIE['wishitem'][$i])) {
                    // echo "not availabe";
                } else {
                    // echo "availabe";
                    $c = $i;

                    $a = 1;
                }
                $i = $i + 1;
            };
            if ($found == 0) {
                setcookie("wishitem[$c]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $d . "__" . $complete_sku, time() + (86400 * 30), "/");
            }
        } else {
            setcookie("wishitem[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $d . "__" . $complete_sku, time() + (86400 * 30), "/");
        }
    }
    header("Location:$actual_link");
}

/* --------------------------- add to wishlist end -------------------------- */

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
$qx = "SELECT * FROM product_tbl WHERE sku ='$sku_base_id'";
$resx = mysqli_query($link, $qx);
if (mysqli_num_rows($resx) > 0) {

    while ($row = mysqli_fetch_assoc($resx)) {

        $id = $row['id'];
        $uid = $id;
    }
}

//rating count start
$total_review_rate = 0;
$person = 0;
$avg_rating = 0;
$q_rate = "SELECT rating FROM `star_rating` WHERE `product_sku` = '$sku_base_id'";
$res_rate = mysqli_query($link, $q_rate);
if (mysqli_num_rows($res_rate) > 0) {
    while ($row_rate = mysqli_fetch_assoc($res_rate)) {
        $total_review_rate = $total_review_rate + intval($row_rate['rating']);
        $person++;
    }
    // echo $total_review_rate;
    // echo $person;
    $avg_rating = ceil(($total_review_rate / (5 * $person)) * 5);
}
//rating count end
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>Let’s make a Shift to Thrift</title>
    <meta name="description"
        content="If you haven’t discovered the joy of thrift shopping, now is the time. Dank Thrift is an affordable, sustainable and fashionable thrift store aimed to build a solid community of conscious shoppers.">
    <meta name="Keywords"
        content="Custom T-shirts,Custom Hoodies, Make your Own,Custom Polo,Custom Round neck,Custom T-shirts ">
    <meta name="author" content="Vinayak">
    <meta property="og:title" content="Let’s make a Shift to Thrift" />
    <meta property="og:url" content="<?php echo $actual_link ?>" />
    <meta property="og:description"
        content="If you haven’t discovered the joy of thrift shopping, now is the time. Dank Thrift is an affordable, sustainable and fashionable thrift store aimed to build a solid community of conscious shoppers.">
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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        type="text/css" media="all">
    <style>
    .fff li {
        height: 2rem !important;
        width: 2rem !important;
    }

    #setAdd {
        border: 1px solid #472D2D;
        background-color: #fff;
        color: #000;
    }

    #setAdd:hover {
        border: 1px solid #1d1d1d;
        background-color: #1d1d1d;
        transition: all .3s linear;
        outline: 0 none;
        color: #fff;
    }

    .question {
        border-radius: 50%;
        background-color: #fff;
        color: #878787;
        font-weight: 500;
        width: 16px;
        height: 16px;
        font-size: 11px !important;
        line-height: 16px;
        text-align: center;
        display: inline-block !important;
        border: 1px solid #e0e0e0;
        box-shadow: 0 0 1px 0 rgb(0 0 0 / 20%);
        vertical-align: middle;
        margin: 0 2px 0 8px;
        cursor: pointer;
    }

    .question:hover {
        color: #472D2D !important;
        border: 1px solid #472D2D !important;
    }

    .show_policy {
        visibility: visible !important;
    }

    #security_policy,
    #delivery_policy,
    #return_policy {
        visibility: hidden;
    }

    ._1LJS6T {
        background: #fff;
        font-size: 12px;
    }

    ._2XFXtH {
        font-size: 13px;
        width: 100%;
        margin: 12px 0;
        border-radius: 2px;
        border: 1px solid #c2c2c2;
        border-spacing: 0;
    }

    ._1LJS6T ._2XFXtH .-dElIf ._25vhVF {
        text-align: center;
        padding: 8px;
        font-weight: 500;
        background-color: #e0e0e0;
        border-bottom: 1px solid #c2c2c2;
        text-transform: capitalize;
        color: #333;
    }

    ._1LJS6T div,
    ._1LJS6T h1,
    ._1LJS6T h2,
    ._1LJS6T h3,
    ._1LJS6T h4,
    ._1LJS6T h5,
    ._1LJS6T h6,
    ._1LJS6T p {
        margin-bottom: 10px;
        padding: 0;
        line-height: 1.5;
        font-size: 12px;
        font-weight: 400;
    }

    ._1LJS6T li,
    ._1LJS6T ul {
        padding: 0 !important;
        margin: 0 !important;
        list-style: none !important;
        width: 100% !important;
        color: #333;
    }

    ._1LJS6T li {
        padding: 0 0 8px 20px !important;
        position: relative !important;
        line-height: 21px !important;
        width: 100% !important;
    }

    ._11u_lJ {
        color: #333;
        font-size: 12px;
    }

    #shipping-charges-for-Quadb-assured-items {
        font-weight: 700;
    }

    .orange {
        color: orange;
    }

    .yellow {
        color: #fdd835;
    }

    html {
        scroll-behavior: smooth;
    }

    .pro-details-policy li {
        width: 100% !important;
    }

    .pro-details-policy li span {
        max-width: 100% !important;
    }

    .product-details-img {
        position: sticky;
        top: 0;

    }

    @media screen and (max-width: 1024px) {
        .zoomContainer {
            display: none !important;
        }
    }

    .descHead {
        margin: 0;
        position: relative;
        text-transform: capitalize;
        font-weight: 700;
        line-height: 1;
        padding-right: 30px;
        background: #fff;
        z-index: 2;
        font-family: Muli, sans-serif;
        font-size: 24px;
        color: #272727;
        text-align: center;
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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WS3Q2PH" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- --------------------------- header start here --------------------------- -->
    <!-- Header Section Start From Here -->
    <header class="header-wrapper">
        <div class="header-nav">
            <div class="container">
                <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between"
                    style="align-items:center;">
                    <div class="header-static-nav">
                        <a href="mailto:contact@dankthrift.com">contact@dankthrift.com</a>
                    </div>
                    <div class="header-menu-nav">
                        <ul class="menu-nav">
                            <li>
                                <?php if (empty($_SESSION['eth_id'])) { ?>
                                <div style="position:relative;">
                                    <a class="sticky_button_side shadow-md enableEthereumButton" title="Add to cart"
                                        tabindex="0" id="enableEthereumButton" onclick="userLoginOut()">Login</a>
                                </div>
                                <?php } ?>
                                <?php if (!empty($_SESSION['eth_id'])) { ?>
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"
                                        style=" text-transform: capitalize;display:flex;align-items:center;"><?php
                                                                                                                                                                                                                                if (empty($_SESSION['eth_id'])) {
                                                                                                                                                                                                                                    echo "My Account ";
                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                    // echo substr($_SESSION['eth_id'], 0, 8) . "... "; 
                                                                                                                                                                                                                                ?>
                                        <span
                                            style="border-radius:50%;overflow:hidden;padding:5px;border:1px solid #333;background:#FEF5E7;"
                                            class="mr-2"><img src="images/metamask.svg" alt="metamask"
                                                style="height:30px;width:30px;"
                                                class="animate__animated animate__pulse animate__infinite animate__slow"></span>
                                        <?php } ?>
                                        <i class="ion-ios-arrow-down"></i>
                                    </button>
                                    <ul class="dropdown-menu animation slideDownIn"
                                        aria-labelledby="dropdownMenuButton">
                                        <li><a href="javascript:void(0)">
                                                <p class="font-weight-bold"
                                                    style="display: inline-block;word-break:break-all;white-space: pre-line;overflow-wrap:break-word;">
                                                    <?= $_SESSION['eth_id'] ?></p>
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
                                                                    } ?>" class="logout"
                                                onclick="signOutOfMetaMask()">Logout</a></li>
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
                            <a href="/"><img loading="lazy" class="img-responsive size"
                                    src="  <?php echo $img_link ?>images/logo/logo.png" alt="logo.png" /></a>
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
                                            <option value="<?php echo $row['category'] ?>">
                                                <?php echo $row['category'] ?></option>
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
                                    <a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i
                                            class="lnr lnr-heart"></i><span>Wishlist</span></a>
                                    <style>
                                    .header-tools .cart-info .heart:before {
                                        content: '<?php if (!empty($wishcart_item)) {
echo $wishcart_item;
                                    }

                                    else {
                                        echo "0";
                                    }

                                    ?>'

                                    }
                                    </style>
                                    <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i
                                            class="lnr lnr-cart"></i><span>My Cart</span></a>
                                    <style>
                                    .header-tools .cart-info .bag:before {
                                        content: '<?php if (!empty($cart_item)) {
echo $cart_item;
                                    }

                                    else {
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
        <input type="hidden" value="<?php echo $page ?>" id="page">
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
                                <li class="menu-item"><a
                                        href="shop-left-sidebar.php?category=<?php echo $row['category'] ?>"><?php echo $row['category'] ?></a>
                                </li>
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
                        <a href="/"><img loading="lazy" class="img-responsive size"
                                src="  <?php echo $img_link ?>images/logo/logo.png" alt="logo.png"
                                style="padding:0.7rem 0;" /></a>
                    </div>
                </div>
                <!-- Header Logo End -->

                <!-- Header Tools Start -->
                <div class="col-auto">
                    <div class="header-tools justify-content-end">
                        <div class="cart-info d-flex align-self-center">
                            <a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i
                                    class="lnr lnr-heart"></i><span>Wishlist</span></a>
                            <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i class="lnr lnr-cart"></i><span>My
                                    Cart</span></a>
                        </div>
                        <div class="mobile-menu-toggle">
                            <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                                <svg viewBox="0 0 800 600">
                                    <path
                                        d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                        id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path
                                        d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                        id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
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
                                    <option value="<?php echo $row['category'] ?>"><?php echo $row['category'] ?>
                                    </option>
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
                                <li class="menu-item-has-children menu-item-has-children-1"><a
                                        href="shop-left-sidebar.php?category=<?php echo $row['category'] ?>"><?php echo $row['category'] ?></a>
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
                        <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>" class="image"><img
                                loading="lazy"
                                src="  <?php echo $img_link ?>images/product-image/<?php echo $value11[3] ?>"
                                alt="Cart product Image" style="height: 78px;"></a>
                        <div class="content">
                            <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>"
                                class="title"><?php echo $value11[2] ?></a>
                            <span class="quantity-price"><span id="itemquanity"><?php echo $value11[8] ?></span> x <span
                                    class="amount">&#8377;<span
                                        id="itemval_side"><?php echo $value11[5] ?></span></span></span>
                            <form method="post">
                                <button type="submit" name="delete2<?php echo $name1; ?>"><a
                                        class="remove">×</a></button>
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
                        <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>" class="image"><img
                                loading="lazy"
                                src="  <?php echo $img_link ?>images/product-image/<?php echo $value11[3] ?>"
                                alt="Cart product Image" style="height: 78px;"></a>
                        <div class="content">
                            <a href="single-product.php?sku_size=<?= $only_size ?>&sku_base=<?php echo $sku ?>"
                                class="title"><?php echo $value11[2] ?></a>
                            <span class="quantity-price"><span id="itemquanity"><?php echo $value11[8] ?></span> x <span
                                    class="amount">&#8377;<span
                                        id="itemval_side"><?php echo $value11[5] ?></span></span></span>
                            <form method="post">
                                <button type="submit" name="delete3<?php echo $name1; ?>"><a
                                        class="remove">×</a></button>
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
                    <span class="amount">&#8377;<span
                            id="product_total_amt_side"><?php
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

    <!-- ----------------------- product page start here ----------------------- -->

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="/">Home</a></li>
                            <li><a href="/">Shop</a></li>
                            <li><?php $qq = "SELECT `name` FROM product_tbl WHERE `sku`='$sku_base_id'";
                                $res44 = mysqli_query($link, $qq);
                                if (mysqli_num_rows($res44) > 0) {
                                    while ($row = mysqli_fetch_assoc($res44)) {
                                        echo $row['name'];
                                    }
                                }
                                ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <!-- Shop details Area start -->
    <?php
    $sale_price = 0;
    $cost_price = 0;
    $q2 = "SELECT `hot_deal_sale_price`,`hot_deal_cost_price` FROM hot_deals WHERE `hot_deals_product_id`=" . $uid . "";
    $res2 = mysqli_query($link, $q2);
    if (mysqli_num_rows($res2) > 0) {
        $show_hide = 'd-inline-block';
        while ($row = mysqli_fetch_assoc($res2)) {
            $sale_price = $row['hot_deal_sale_price'];
            $cost_price = $row['hot_deal_cost_price'];
            if ($row['hot_deal_sale_price'] == $row['hot_deal_cost_price']) {
                $show_hide = 'd-none';
            } else {
                $show_hide = 'd-inline-block';
            }
        }
    } else {
        $q3 = "SELECT `sale_price`,`cost_price` FROM product_tbl WHERE `sku`='$sku_base_id'";
        $res3 = mysqli_query($link, $q3);
        if (mysqli_num_rows($res3) > 0) {
            $show_hide = 'd-inline-block';
            while ($row = mysqli_fetch_assoc($res3)) {
                $sale_price = $row['sale_price'];
                $cost_price = $row['cost_price'];
                if ($row['sale_price'] == $row['cost_price']) {
                    $show_hide = 'd-none';
                } else {
                    $show_hide = 'd-inline-block';
                }
            }
        }
    }
    $q = "SELECT * FROM product_tbl WHERE sku ='$sku_base_id'";
    $res = mysqli_query($link, $q);
    if (mysqli_num_rows($res) > 0) {

        while ($row = mysqli_fetch_assoc($res)) {

            $id = $row['id'];
            $uid = $id;
            $design = $row['design'];
            $name = $row['name'];
            $image = $row['image'];
            $image2 = $row['image2'];
            // $cost_price=$row['cost_price'];                    
            $qty = $row['quantity'];
            $product_desc = $row['product_desc'];
            $without_comma_desc = explode(",", $product_desc);
            // print_r($without_comma_desc);            
            $slider_img1 = $row['slider_img1'];
            $slider_img2 = $row['slider_img2'];
            $slider_img3 = $row['slider_img3'];
            $slider_img4 = $row['slider_img4'];
            $slider_img5 = $row['slider_img5'];
            $slider_img_zoom1 = $row['slider_img_zoom1'];
            $slider_img_zoom2 = $row['slider_img_zoom2'];
            $slider_img_zoom3 = $row['slider_img_zoom3'];
            $slider_img_zoom4 = $row['slider_img_zoom4'];
            $slider_img_zoom5 = $row['slider_img_zoom5'];
            $price1 = $qty * $sale_price;
            $extra_small_size = $row['extra_small_size'];
            $small_size = $row['small_size'];
            $medium_size = $row['medium_size'];
            $large_size = $row['large_size'];
            $extra_large_size = $row['extra_large_size'];
            $discount_price = (($cost_price - $sale_price) / $cost_price) * 100;
        }

        if ($slider_img1 != NULL) {
            $total_image += 1;
        }
        if ($slider_img2 != NULL) {
            $total_image += 1;
        }
        if ($slider_img3 != NULL) {
            $total_image += 1;
        }
        if ($slider_img4 != NULL) {
            $total_image += 1;
        }
        if ($slider_img5 != NULL) {
            $total_image += 1;
        }

        // echo $total_image;
    ?>
    <section class="product-details-area mtb-60px ">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-img product-details-tab">
                        <div class="zoompro-wrap zoompro-2">
                            <?php
                                if ($slider_img1 != NULL) {
                                ?>
                            <div class="zoompro-border zoompro-span">
                                <img loading="lazy" class="zoompro" id="img11"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom1 ?>"
                                    data-zoom-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom1 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img2 != NULL) {
                                ?>
                            <div class="zoompro-border zoompro-span">
                                <img loading="lazy" class="zoompro" id="img12"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom2 ?>"
                                    data-zoom-image="  <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom2 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img3 != NULL) {
                                ?>
                            <div class="zoompro-border zoompro-span">
                                <img loading="lazy" class="zoompro" id="img13 "
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom3 ?>"
                                    data-zoom-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom3 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img4 != NULL) {
                                ?>
                            <div class="zoompro-border zoompro-span">
                                <img loading="lazy" class="zoompro" id="img14"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom4 ?>"
                                    data-zoom-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom4 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img5 != NULL) {
                                ?>
                            <div class="zoompro-border zoompro-span">
                                <img loading="lazy" class="zoompro" id="img15"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom5 ?>"
                                    data-zoom-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom5 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                ?>
                        </div>
                        <div id="gallery" class="product-dec-slider-2">
                            <?php
                                if ($slider_img1 != NULL) {
                                ?>
                            <div class="single-slide-item">
                                <img loading="lazy" class="img-responsive size"
                                    data-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img1 ?>"
                                    data-zoom-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom1 ?>"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img1 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img2 != NULL) {
                                ?>
                            <div class="single-slide-item">
                                <img loading="lazy" class="img-responsive size"
                                    data-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img2 ?>"
                                    data-zoom-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom2 ?>"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img2 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img3 != NULL) {
                                ?>
                            <div class="single-slide-item">
                                <img loading="lazy" class="img-responsive size"
                                    data-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img3 ?>"
                                    data-zoom-image="<?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom3 ?>"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img3 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img4 != NULL) {
                                ?>
                            <div class="single-slide-item">
                                <img loading="lazy" class="img-responsive size"
                                    data-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img4 ?>"
                                    data-zoom-image="<?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom4 ?>"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img4 ?>"
                                    alt="" />
                            </div>
                            <?php }
                                if ($slider_img5 != NULL) {
                                ?>
                            <div class="single-slide-item">
                                <img loading="lazy" class="img-responsive size"
                                    data-image=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img5 ?>"
                                    data-zoom-image="<?php echo $img_link ?>images/product-image/<?php echo $slider_img_zoom5 ?>"
                                    src=" <?php echo $img_link ?>images/product-image/<?php echo $slider_img5 ?>"
                                    alt="" />
                            </div>
                            <?php }

                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <p class="reference">Collection: <span><?php echo $design ?></span></p>
                        <h2><?php echo $name ?></h2>
                        <div class="pro-details-rating-wrap">
                            <div class="rating-product">
                                <?php
                                    $k = 1;
                                    for ($l = 0; $l < 5; $l++) {
                                        if ($k <= $avg_rating) {
                                    ?>
                                <i class="ion-android-star" style="color:#fdd835;"></i>
                                <?php
                                        } else {
                                        ?>
                                <i class="ion-android-star"></i>
                                <?php
                                        }
                                        $k = $k + 1;
                                    }
                                    ?>
                            </div>
                            <span class="read-review"><a class="reviews" href="#reviewBox">Read reviews
                                    (<?php echo $person ?>)</a></span>
                        </div>
                        <div class="pricing-meta">
                            <ul>
                                <li class="old-price <?php echo $show_hide ?> ">&#8377;<?php echo $cost_price ?></li>
                                <li class="cuttent-price">&#8377;<?php echo $sale_price ?></li>
                                <li class="discount-flag <?php echo $show_hide ?>">save
                                    <?php echo number_format($discount_price, 2) ?>%</li>
                            </ul>
                        </div>
                        <div class="pro-details-list">
                            <p>
                            <ul style="list-style: disc;text-transform:capitalize;"><?php
                                                                                        for ($i = 0; $i < count($without_comma_desc); $i++) {
                                                                                            $new_desc =  explode(":", $without_comma_desc[$i]);
                                                                                        ?>
                                <li><span style="color:#333;font-weight:500;"><?php echo $new_desc[0]; ?></li>
                                <?php } ?>
                            </ul>
                            </p>
                        </div>
                        <form method="post" id="mm">
                            <div class="pro-details-policy"
                                style="border-bottom: 1px solid #ebebeb; margin-bottom:25px;">
                                <ul>
                                    <li><img loading="lazy" src=" <?php echo $img_link ?>images/icons/policy.png"
                                            alt="" /><span
                                            style="font-size: 14px;font-weight:700 !important;color:#333;">Secure
                                            Transaction Guarantee With MetaMask<span class="question"
                                                onclick="show_policy()">?</span></span>
                                        <div class="container" id="security_policy">
                                            <div class="row d-flex justify-content-center mt-2">
                                                <div class="col-11 shadow"
                                                    style="z-index:3;position:absolute;background:#fff;">
                                                    <div class="p-1">
                                                        <div class="_2JH8X1">
                                                            <div class="_3ELZs9">
                                                                <div class="_1LJS6T">
                                                                    <div class="_2NKhZn">
                                                                        <h2
                                                                            id="shipping-charges-for-Quadb-assured-items">
                                                                            Your transaction is secure</h2>
                                                                        <p>We work hard to protect your security and
                                                                            privacy.</p>
                                                                        <p> Our payment security system encrypts your
                                                                            information during transmission.</p>
                                                                        <p> We don’t share your credit card details with
                                                                            third-party sellers, and we don’t sell your
                                                                            information to others.</p>
                                                                        <p>* Your payment is 100% safe and secure with
                                                                            Razorpay.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><img loading="lazy" src=" <?php echo $img_link ?>images/icons/policy-2.png"
                                            alt="" /><span
                                            style="font-size: 14px;font-weight:700 !important;color:#333;">Free Fast and
                                            Secure Shipping Pan India<span class="question"
                                                onclick="delivery_policy()">?</span></span>
                                        <div class="container" id="delivery_policy">
                                            <div class="row d-flex justify-content-center mt-2">
                                                <div class="col-11 shadow"
                                                    style="z-index:3;position:absolute;background:#fff;">
                                                    <div class="p-2 mt-2">
                                                        <div class="_2JH8X1">
                                                            <div class="_3ELZs9">
                                                                <div class="_1LJS6T">
                                                                    <div class="_2NKhZn">
                                                                        <h2
                                                                            id="shipping-charges-for-Quadb-assured-items">
                                                                            Shipping Charges For Dank Thrift Assured
                                                                            Items</h2>
                                                                        <p> Shipping charges are calculated based on the
                                                                            number of units, distance and delivery date.
                                                                        </p>
                                                                        <p>* For faster delivery, shipping charges will
                                                                            be applicable</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><img loading="lazy" src=" <?php echo $img_link ?>images/icons/policy-3.png"
                                            alt="" /><span
                                            style="font-size: 14px;font-weight:700 !important;color:#333;">7 day Return
                                            Garuntee<span class="question" onclick="return_policy()">?</span></span>
                                        <div class="container" id="return_policy">
                                            <div class="row d-flex justify-content-end mt-2 pr-0">
                                                <div class="col-11 shadow"
                                                    style="z-index:3;position:absolute;background:#fff;right:15px;">
                                                    <div class="p-1">
                                                        <div class="_1LJS6T">
                                                            <table class="_2XFXtH">
                                                                <thead>
                                                                    <tr class="-dElIf">
                                                                        <th class="_25vhVF">Validity</th>
                                                                        <th class="_25vhVF">Covers</th>
                                                                        <th class="_25vhVF">Type Accepted</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="_240_vq">
                                                                        <td class="_11u_lJ">14 days from delivery</td>
                                                                        <td class="_11u_lJ">All Return Reasons</td>
                                                                        <td class="_11u_lJ">Refund / Replacement /
                                                                            Exchange</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="_2NKhZn">
                                                                <p>*If there is any issue with your product, you can
                                                                    raise a refund, replacement or exchange request
                                                                    within 14 days of receiving the product.</p>
                                                                <p>Successful pick-up of the product is subject to the
                                                                    following conditions being met:</p>
                                                                <ul>
                                                                    <li>Correct and complete product (with the original
                                                                        brand, article number, undetached MRP tag,
                                                                        product's original packaging, freebies and
                                                                        accessories)</li>
                                                                    <li>The product should be in unused, undamaged and
                                                                        original condition without any stains,
                                                                        scratches, tears or holes and with non-tampered
                                                                        quality check seals/return tags/ warranty seals
                                                                        (wherever applicable)</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>                           
                            <div class="pricing-meta">
                                <span style="font-size: 14px;font-weight: 700;color: #1d1d1d;">Size</span>
                                <ul class="size_chart" id="size_chart<?php echo $id; ?>">
                                <!-- size code start -->
                                <?php 
                                if($extra_small_size !== ''){
                                    $isActive = '';
                                    if($sku_base_size === 'XS'){
                                        $isActive = 'size_chart_active';
                                    }else{
                                        $isActive = '';
                                    }
                                ?>
                                    <li onclick="size('<?= $sku_base_id ?>','<?= $extra_small_size ?>')"
                                        style="line-height:1rem;text-align:center;" class="mr-2 <?= $isActive?>">
                                        <?= $extra_small_size ?></li>
                                <?php 
                                }
                                ?>
                                <?php 
                                if($small_size !== ''){
                                    $isActive = '';
                                    if($sku_base_size === 'S'){
                                        $isActive = 'size_chart_active';
                                    }else{
                                        $isActive = '';
                                    }
                                ?>
                                    <li onclick="size('<?= $sku_base_id ?>','<?= $small_size ?>')"
                                        style="line-height:1rem;text-align:center;" class="mr-2 <?= $isActive?>">
                                        <?= $small_size ?></li>
                                <?php 
                                }
                                ?>
                                <?php 
                                if($medium_size !== ''){
                                    $isActive = '';
                                    if($sku_base_size === 'M'){
                                        $isActive = 'size_chart_active';
                                    }else{
                                        $isActive = '';
                                    }
                                ?>
                                    <li onclick="size('<?= $sku_base_id ?>','<?= $medium_size ?>')"
                                        style="line-height:1rem;text-align:center;" class="mr-2 <?= $isActive?>">
                                        <?= $medium_size ?></li>
                                <?php 
                                }
                                ?>
                                <?php 
                                if($large_size !== ''){
                                    $isActive = '';
                                    if($sku_base_size === 'L'){
                                        $isActive = 'size_chart_active';
                                    }else{
                                        $isActive = '';
                                    }
                                ?>
                                    <li onclick="size('<?= $sku_base_id ?>','<?= $large_size ?>')"
                                        style="line-height:1rem;text-align:center;" class="mr-2 <?= $isActive?>">
                                        <?= $large_size ?></li>
                                <?php 
                                }
                                ?>
                                <?php 
                                if($extra_large_size !== ''){
                                    $isActive = '';
                                    if($sku_base_size === 'XL'){
                                        $isActive = 'size_chart_active';
                                    }else{
                                        $isActive = '';
                                    }
                                ?>
                                    <li onclick="size('<?= $sku_base_id ?>','<?= $extra_large_size ?>')"
                                        style="line-height:1rem;text-align:center;" class="mr-2 <?= $isActive?>">
                                        <?= $extra_large_size ?></li>
                                <?php 
                                }
                                ?>
                                <!-- size code end -->
                                    <div style="display: inline-block;cursor:pointer;" class="ml-2" onclick="setData()">
                                        <span style="font-size:12px;color:#472D2D;">Size Chart</span><img loading="lazy"
                                            src="<?php echo $img_link ?>images/size_chart.svg"
                                            style="margin-left: 6px; height: 10px;"></div>
                                </ul>
                            </div>
                            <div class="pro-details-quality mt-0px d-none d-lg-block">
                                <!-- <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                                    </div> -->
                                <input class="cart-plus-minus-box" type="hidden" name="qtybutton" value="1" />
                                <div class="pro-details-cart btn-hover" style="display: inline-block;">
                                    <input type="hidden" name="size" class="sizeId" id="sizeId<?php echo $id; ?>"
                                        value="<?php echo $sku_base_size ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>" id="id">
                                    <input type="hidden" name="urlpath" id="fixurl">
                                    <button value="addtocart" id="addtocart"><a class="add-to-curt" title="Add to cart"
                                            id="setAdd">Add to cart</a></button>
                                </div>
                                <div class="pro-details-cart btn-hover " style="display: inline-block;">
                                    <button value="buynow" id="buynow"><a class="add-to-curt" title="Add to cart">Buy
                                            Now</a></button>
                                </div>
                            </div>

                        </form>
                        <div class="pro-details-wish-com">
                            <div class="pro-details-wishlist">
                                <form method="post">
                                    <input type="hidden" name="wishid" value="<?php echo $id; ?>" id="wishid">
                                    <button><a><i class="ion-android-favorite-outline"></i>Add to wishlist</a></button>
                                </form>
                            </div>
                            <!-- <div class="pro-details-compare">
                                    <a href="#"><i class="ion-ios-shuffle-strong"></i>Add to compare</a>
                                </div> -->
                        </div>
                        <div class="pro-details-social-info" style="border-bottom:none;">
                            <span>Share</span>
                            <div class="social-info">
                                <ul>
                                    <li>
                                        <a title="Facebook"
                                            href="http://www.facebook.com/sharer.php?u=<?php echo $actual_link ?>&amp;src=sdkpreparse"
                                            target="_blank"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a title="Twitter"
                                            href="https://twitter.com/share?url=<?php echo $actual_link ?>&amp;text=quadb&amp;hashtags=quadb"
                                            target="_blank"><i class="ion-social-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a title="Gmail"
                                            href="mailto:?Subject=quadb&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 <?php echo $actual_link ?>"><i
                                                class="ion-social-google"></i></a>
                                    </li>
                                    <li>
                                        <a title="Linkedin"
                                            href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $actual_link ?>"
                                            target="_blank"><i class="ion-social-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop details Area End -->
    <!-- product details description area start -->
    <div class="description-review-area mb-50px" id="reviewBox">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav">
                    <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                    <a data-toggle="tab" href="#des-details2">Product Details</a>
                    <a data-toggle="tab" href="#des-details3">Reviews (<?php echo $person ?>)</a>
                </div>
                <div class="tab-content description-review-bottom mb-50px">
                    <div id="des-details2" class="tab-pane">
                        <div class="product-anotherinfo-wrapper">
                            <ul style="text-transform: capitalize;">
                                <li><span>Package Weight</span> 400 grms</li>
                                <li><span>Package Dimensions</span> 14 X 11 X 4 Inches</li>
                                <li><span>Materials</span> Cotton Blend</li>
                                <li><span>Pattern</span> Solid</li>
                                <li><span>Fabric Blend</span> 80% Cotton 20% Polyster</li>
                                <li><span>Fabric Detail 1</span> 100% Biowashed</li>
                                <li><span>Fabric Detail 2</span> Pre Shrunk </li>
                                <li><span>Fabric Detail 3</span> 320 GSM Material</li>
                                <li><span>Fabric Detail 4</span> Strechable </li>
                                <li><span>Fabric Detail 5</span> Breathable </li>
                                <li><span>Neck Style</span> Round Neck</li>
                                <li><span>Sleeve Style</span> Halfsleeve</li>
                                <li><span>Fit Type</span> Regular Fit</li>
                                <li><span>Wash Care Machine</span> Wash</li>
                                <li><span>Collection</span> The Minimalist Collection</li>
                                <li><span>Average Delivery Time</span> 3-7 Working Days</li>
                                <li><span>Occasion Type 1</span> Formal Wear</li>
                                <li><span>Occasion Type 2</span> Evening Wear</li>
                                <li><span>Occasion Type 3</span> Casual Wear</li>
                                <li><span>Occasion Type 4</span> Sports Wear</li>
                                <li><span>Manufacturer</span> Dank Thrift Apparel Private Limited</li>
                                <li><span>Manufacturer Address</span> 579/1, Mehmood Pura, Old Madhopuri Chowk,
                                    Ludhiana, Punjab 141008</li>
                                <li><span>Manufacturer Contact Number</span> 8146550542</li>
                                <li><span>Packager</span> Dank Thrift Apparel Private Limited</li>
                                <li><span>Packager Address</span> 579/1, Mehmood Pura, Old Madhopuri Chowk, Ludhiana,
                                    Punjab 141008</li>
                                <li><span>Packager Contact Number</span> 8146550542</li>
                                <li><span>Return Address</span> 579/1, Mehmood Pura, Old Madhopuri Chowk, Ludhiana,
                                    Punjab 141008</li>
                                <li><span>Helpline Number</span> 8146550542</li>
                            </ul>
                        </div>
                    </div>
                    <div id="des-details1" class="tab-pane active" style="padding: 0;font-size:15px;">
                        <div class="product-description-wrapper">
                            <div class="d-none d-lg-block">
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <img src="images/desktop-desc/Group7.png" style="width:100%">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <p style="text-align: center;width:100%;font-size:15px;" class="mt-3">Dank
                                            Thrift presents you it’s <b>Minimalist Collection.</b><br>
                                            This Collection of Minimalist T-shirts made from India’s Finest Cotton is
                                            perfect for every occassion.Be it a
                                            Party,a Business Meeting or evenaDate,these T-shirts will keep the focus on
                                            the most important thing in
                                            the room,You.Mix and Match this T-shirt with any article of clothing and
                                            gain a new outfit everytime.<br></p>
                                        <p style="text-align: center;width:100%;font-size:15px;">
                                            The Premium Cotton Fleece used to create these T-shirts are Not Just
                                            comforatble,but also sweat absorbent and antimicrobial allowing you to wear
                                            the T-shirt anywhere anytime
                                        </p>
                                        <p style="text-align: center;width:100%;" class="descHead">
                                            As Seen on
                                        </p>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center my-2">
                                    <div class="col-2">
                                        <img
                                            src="images/mobile-desc/5bee83f7a69edda26bc5b891_YourStory_Logo-New-01.png">
                                    </div>
                                    <div class="col-2">
                                        <img src="images/mobile-desc/PU-MIrror-Logo-Psd-2.png">
                                    </div>
                                    <div class="col-2">
                                        <img src="images/mobile-desc/timesnext-2x-1024x162.png">
                                    </div>
                                    <div class="col-2">
                                        <img src="images/mobile-desc/TechnoVans.png">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <img src="images/desktop-desc/Group6.png" style="width:100%">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <img src="images/desktop-desc/Group5.png" style="width:100%">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center p-0">
                                    <div class="col-3 p-0">
                                        <img src="images/desktop-desc/receiving-packages-E7UTAY8.png"
                                            style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Free Delivery</h3>
                                        <p style="width: 100%;text-align:center;" class="p-2">Avail Free Delivery offer
                                            Now
                                            powered by Delivery and get free,
                                            fast and secure delivery at all serviceable pincodes in India</p>
                                    </div>
                                    <div class="col-3 p-0">
                                        <img src="images/desktop-desc/Whatsapp.png" style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Free Returns</h3>
                                        <p style="width: 100%;text-align:center;" class="p-2">Got a Defective product?
                                            Don’tworry
                                            just contact us once and we will send
                                            are placement ASAP.</p>
                                    </div>
                                    <div class="col-3 p-0">
                                        <img src="images/desktop-desc/Webp.net-resizeimage.png" style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Secure Gateway</h3>
                                        <p style="width: 100%;text-align:center;" class="p-2">Pay Safely and securely
                                            with our ssl
                                            secured payment gateway powered
                                            by Razorpay.</p>
                                    </div>
                                    <div class="col-3 p-0">
                                        <img src="images/desktop-desc/delivery-man-spray-sanitizing-.png"
                                            style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Free Delivery</h3>
                                        <p style="width: 100%;text-align:center;" class="p-2">Our Facilities have been
                                            100% Sanitized according to WHO Covid-19
                                            Guidance. Get your package safely
                                            and Securely</p>
                                    </div>
                                </div>

                            </div>
                            <div class="d-lg-none position-relative">
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <img src="images/mobile-desc/Group7.png" style="width:100%">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <p style="text-align: center;width:100%;font-size:15px;" class="mt-3">Dank
                                            Thrift presents you it’s <b>Minimalist Collection.</b><br>
                                            This Collection of Minimalist T-shirts made from India’s Finest Cotton is
                                            perfect for every occassion.Be it a
                                            Party,a Business Meeting or evenaDate,these T-shirts will keep the focus on
                                            the most important thing in
                                            the room,You.Mix and Match this T-shirt with any article of clothing and
                                            gain a new outfit everytime.<br></p>
                                        <p style="text-align: center;width:100%;font-size:15px;">
                                            The Premium Cotton Fleece used to create these T-shirts are Not Just
                                            comforatble,but also sweat absorbent and antimicrobial allowing you to wear
                                            the T-shirt anywhere anytime
                                        </p>
                                        <p style="text-align: center;width:100%;" class="descHead">
                                            As Seen on
                                        </p>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6">
                                        <img
                                            src="images/mobile-desc/5bee83f7a69edda26bc5b891_YourStory_Logo-New-01.png">
                                    </div>
                                    <div class="col-6">
                                        <img src="images/mobile-desc/PU-MIrror-Logo-Psd-2.png">
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6">
                                        <img src="images/mobile-desc/timesnext-2x-1024x162.png">
                                    </div>
                                    <div class="col-6">
                                        <img src="images/mobile-desc/TechnoVans.png">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <img src="images/mobile-desc/Group6.png" style="width:100%">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <img src="images/mobile-desc/Group5.png" style="width:100%">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center p-0">
                                    <div class="col-6 p-0">
                                        <img src="images/mobile-desc/receiving-packages-E7UTAY8.png"
                                            style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Free Delivery</h3>
                                        <p style="width: 100%;text-align:justify;" class="p-2">Avail Free Delivery offer
                                            Now
                                            powered by Delivery and get free,
                                            fast and secure delivery at all serviceable pincodes in India</p>
                                    </div>
                                    <div class="col-6 p-0">
                                        <img src="images/mobile-desc/WhatsApp.png" style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Free Returns</h3>
                                        <p style="width: 100%;text-align:justify;" class="p-2">Got a Defective product?
                                            Don’tworry
                                            just contact us once and we will send
                                            are placement ASAP.</p>
                                    </div>
                                    <div class="col-6 p-0">
                                        <img src="images/mobile-desc/payment-with-smartphone-FY87QKJ.png"
                                            style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Secure Gateway</h3>
                                        <p style="width: 100%;text-align:justify;" class="p-2">Pay Safely and securely
                                            with our ssl
                                            secured payment gateway powered
                                            by Razorpay.</p>
                                    </div>
                                    <div class="col-6 p-0">
                                        <img src="images/mobile-desc/delivery-man-spray-sanitizing-on-a-box-3EDTQUR.png"
                                            style="width: 100%;">
                                        <h3 class="text-center mt-2 descHead">Free Delivery</h3>
                                        <p style="width: 100%;text-align:justify;" class="p-2">Our Facilities have been
                                            100% Sanitized according to WHO Covid-19
                                            Guidance. Get your package safely
                                            and Securely</p>
                                    </div>
                                </div>


                            </div>


                        </div>


                    </div>
                    <div id="des-details3" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="review-wrapper">
                                    <div id="set_rate"></div>

                                    <!--  Pagination Area Start -->
                                    <div class="pro-pagination-style text-center mtb-50px">
                                        <!-- pagination code start -->
                                        <?php
                                            $query1 = "SELECT * FROM `star_rating` WHERE `product_sku` ='$sku_base_id'";
                                            $result1 = mysqli_query($link, $query1);
                                            if (mysqli_num_rows($result1) > 0) {
                                                $link_value = '';
                                                $total_records = mysqli_num_rows($result1);
                                                $limit = 5;
                                                $total_page = ceil($total_records / $limit);
                                                if (isset($_GET['sku_base'])) {
                                                    $link_value = "sku_size=" . $sku_base_size . "&sku_base=" . $sku_base_id . "&";
                                                } else {
                                                    $link_value = '';
                                                }
                                            ?>
                                        <ul>
                                            <li>
                                                <a class="prev" onclick="call(<?php if ($page <= 1) {
                                                                                            echo ($page);
                                                                                        } else {
                                                                                            echo ($page - 1);
                                                                                        } ?>)"><i
                                                        class="ion-ios-arrow-left"></i></a>
                                            </li>
                                            <?php
                                                    for ($i = 1; $i <= $total_page; $i++) {
                                                    ?>
                                            <?php if ($i == $page) {
                                                            $active = "active";
                                                        } else {
                                                            $active = "";
                                                        } ?>
                                            <li><a id="ccc<?= $i ?>" class="ccc"
                                                    onclick="call(<?php echo $i ?>)"><?php echo $i ?></a></li>
                                            <?php
                                                    } ?>
                                            <li><a class="next" onclick="call(<?php if ($page >= $total_page) {
                                                                                            echo $page;
                                                                                        } else {
                                                                                            echo $page + 1;
                                                                                        } ?>)"><i
                                                        class="ion-ios-arrow-right"></i></a></li>
                                        </ul>
                                        <?php
                                            }
                                            ?>
                                        <!-- pagination code end -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="ratting-form-wrapper pl-50">
                                    <h3>Add a Review</h3>
                                    <div class="ratting-form">
                                        <form action="#">
                                            <div class="star-box">
                                                <span>Your rating:</span>
                                                <div class="rating-product">
                                                    <i class="ion-android-star star"></i>
                                                    <i class="ion-android-star star"></i>
                                                    <i class="ion-android-star star"></i>
                                                    <i class="ion-android-star star"></i>
                                                    <i class="ion-android-star star"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="rating-form-style mb-10">
                                                        <input placeholder="Name" type="text" id="rating_name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rating-form-style mb-10">
                                                        <input placeholder="Email" type="email" id="rating_email" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="rating-form-style form-submit">
                                                        <textarea name="Your Review" placeholder="Message"
                                                            id="rating_message"></textarea>
                                                        <input type="button" value="Submit" id="submit_rating" />
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } else {
        header("Location:/");
    } ?>
    <!-- product details description area end -->

    <!-- Arrivals Area Start -->
    <div class="arrival-area single-product-nav mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="section-heading">12 Other Products In The Same Category:</h2>
                    </div>
                </div>
            </div>
            <!-- Arrivel slider start -->
            <div class="arrival-slider-wrapper slider-nav-style-1">
                <?php
                $query = "SELECT * FROM `product_tbl` INNER JOIN `product_category` ON product_tbl.product_category_id=product_category.product_category_id INNER JOIN `product_subcategory` ON product_tbl.product_subcategory_id=product_subcategory.product_subcategory_id WHERE `category`='$product_category' ORDER BY id ASC LIMIT 6";
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
                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>"
                                    class="thumbnail">
                                    <img loading="lazy" class="first-img"
                                        src=" <?php echo $img_link ?>images/product-image/<?php echo $row['image'] ?>"
                                        alt="" />
                                    <img loading="lazy" class="second-img d-lg-block d-none"
                                        src=" <?php echo $img_link ?>images/product-image/<?php echo $row['image2'] ?>"
                                        alt="" />
                                </a>
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
    <!-- ------------------------------ page end ------------------------------- -->

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
                                    <a href="/"><img loading="lazy" class="img-responsive footer-img-size"
                                            src="  <?php echo $img_link ?>images/logo/logo.png" alt="logo.png" /></a>
                                </div>
                                <p class="text-infor" style="text-align: justify;">Dank thrift is an e-commerce store
                                    for thrift and second hand clothes. Our vision is to create a more sustainable
                                    fashion economy by making second-hand fashion inventory transparent and circular,
                                    one wardrobe at a time!</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6 mb-md-30px mb-lm-30px">
                            <div class="single-wedge">
                                <div class="footer-widget widget  text-center-mobile">
                                    <h4 class="text-uppercase"><i class="ion-home"></i> Office Address</h4>
                                    <p class="text-justify  text-center-mobile"> Next57 Coworking, 3rd Floor<br>Plot No.
                                        57, Industrial Area Phase I<br>Chandigarh, 160002</p>
                                    <div class="social-media" style="text-decoration: none;">
                                        <p class=" text-center-mobile">
                                            <a href="https://www.google.com/search?ei=z2UYXdXWGIq6rQGWzp_YCg&amp;q=quadb+creations&amp;oq=quad&amp;gs_l=psy-ab.3.2.35i39l2j0i67l2j0l6.2825.3302..5468...0.0..0.165.602.0j4......0....1..gws-wiz.-oR7-X_p75c"
                                                target="_blank"><i class="ion-android-globe"
                                                    style="margin-right: 5px;"></i> Dank Thrift</a>
                                        </p>
                                        <p class=" text-center-mobile">
                                            <a href="https://wa.me/917717303372/?text=Hey+Fellas%2C%0D%0ACan+you+help+me+to+order+some+really+cool+merchandise+from+QuadB%3F"
                                                target="_blank"><i class="ion-social-whatsapp"
                                                    style="margin-right: 5px;"></i> +91-81712 80077</a>
                                        </p>
                                        <p class=" text-center-mobile">
                                            <a href="tel:+918146550542" target="_blank"><i class="ion-android-call"
                                                    style="margin-right: 5px;"></i> +91-81712 80077</a>
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
                                <div class="payment-way"><img loading="lazy" class="payment-img img-responsive"
                                        src="  <?php echo $img_link ?>images/icons/payment.png" alt="" />
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
                                            <a href="https://www.instagram.com/dank_thrift/"><i
                                                    class="ion-social-instagram"></i></a>
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
                        <div class="col-md-8">
                            <div class="tag-content">
                                <ul class="text-capitalize">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="shop-left-sidebar.php">shop</a></li>
                                    <li><a href="about">about</a></li>
                                    <li><a href="contact">contact</a></li>
                                    <li><a href="https://www.instagram.com/dank_thrift/" target="_blank">instagram</a>
                                    </li>
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
    <!-- Footer Area End -->
    <!-- Modal -->

    <!-- Modal end -->
    <!-- fixed button start-->
    <div class="slider-menumob d-lg-none d-md-none" data-purpose="slider-menumob"
        style="align-items: center;background-color: #fff;box-shadow: 0 -2px 4px rgba(0,0,0,.08), 0 -4px 12px rgba(0,0,0,.08);display: flex;flex-direction: row;overflow-y: hidden;padding: 8px 16px;position: fixed;bottom: 0;left: 0;right: 0;width: 100%;z-index: 1000;">
        <div class="container-fluid justify-content-center" style="padding:0px;">
            <div class="row">
                <div class="col-6">
                    <button type="button" class="font-barlow-m add-to-cart buybtnchk btn"
                        style="color: #000;border:1px solid #472D2D;width: 100%;font-size:14px;padding:13px 20px;text-transform:uppercase;"
                        id="addtocart2">Add to cart</button>
                </div>
                <div class="col-6">
                    <button type="button" class="font-barlow-m add-to-cart buybtnchk btn"
                        style="color: #fff;background-color:#472D2D;width: 100%;font-size:14px;padding:13px 20px;text-transform:uppercase;"
                        id="buynow2">Buy Now</button>
                </div>
            </div>
        </div>
    </div>
    <!-- fixed button end-->
    <!-- Modal -->
    <modal id="myModal" class="modal animate__animated animate__flipInX" data-easein="flipYIn" tabindex="-1"
        role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Size Chart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row py-2">
                            <div class="col-lg-7 col-md-12 col-sm-12">
                                <div style="width:100%">
                                    <img loading="lazy" src="<?php echo $img_link ?>images/size_image.jpg" alt=""
                                        style="width:100%;">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12 col-sm-12">
                                <div class="_1Ci6qv">
                                    <div class="my-2" style="color:#333;font-weight:bold;"> Measuring T Shirt Size
                                    </div>
                                    <div class="my-2">
                                        <div>
                                            <p>Not sure about your t shirt size? Follow these simple steps to figure it
                                                out:</p>
                                            <p class="py-1"><strong
                                                    style="color:#333;font-weight:bold;"><em>Shoulder</em></strong> -
                                                Measure the shoulder at the back, from edge to edge with arms relaxed on
                                                both sides</p>
                                            <p class="py-1"><strong
                                                    style="color:#333;font-weight:bold;"><em>Chest</em></strong> -
                                                Measure around the body under the arms at the fullest part of the chest
                                                with your arms relaxed at both sides.</p>
                                            <p class="py-1"><strong
                                                    style="color:#333;font-weight:bold;"><em>Sleeve</em></strong> -
                                                Measure from the shoulder seam through the outer arm to the cuff/hem</p>
                                            <p class="py-1"><strong
                                                    style="color:#333;font-weight:bold;"><em>Neck</em></strong> -
                                                Measured horizontally across the neck
                                                Length - Measure from the highest point of the shoulder seam to the
                                                bottom hem of the garment's</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </modal>
    <!-- Modal -->
    <!-- JS
============================================ -->
    <script src="js/vendor.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Main Activation JS -->
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
    /*--------------------------
            Product Zoom
    ---------------------------- */

    var zoomOptions = {
        zoomType: "inner",
        cursor: "crosshair",
        easing: true,
        responsive: true,

    };

    $(".zoompro-wrap").slick({
        asNavFor: ".product-dec-slider-2",
        slidesToShow: 1,
        arrows: false,
        dots: false,
        fade: true,
    });
    $(".product-dec-slider-2").slick({
        slidesToShow: <?php echo ($total_image - 1) ?>,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<span class="prev"><i class="ion-ios-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="ion-ios-arrow-right"></i></span>',
        dots: false,
        infinite: true,
        loop: true,
        asNavFor: ".zoompro-wrap",
        focusOnSelect: true
    });
    $(".zoompro-wrap .slick-current img").elevateZoom({
        easing: true,
        responsive: true
    });
    $(".zoompro-wrap").on("beforeChange", function(
        event,
        slick,
        currentSlide,
        nextSlide
    ) {
        $.removeData(currentSlide, "elevateZoom");
        $(".zoomContainer").remove();
    });
    $(".zoompro-wrap").on("afterChange", function() {
        $(".zoompro-wrap .slick-current img").elevateZoom({
            easing: true,
            responsive: true
        });
    });

    /*--------------------------
            Product Zoom
    ---------------------------- */
    // $("#img11").elevateZoom();
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
                    $('.img1').attr('src', '<?php echo $img_link ?>images/product-image/' + data
                        .slider_img1);
                    $('.img2').attr('src', '<?php echo $img_link ?>images/product-image/' + data
                        .slider_img2);
                    $('.img3').attr('src', '<?php echo $img_link ?>images/product-image/' + data
                        .slider_img3);
                    $('.img4').attr('src', '<?php echo $img_link ?>images/product-image/' + data
                        .slider_img4);
                    $('.img5').attr('src', '<?php echo $img_link ?>images/product-image/' + data
                        .slider_img5);
                } else {

                }
            }
        });
    }

    function size(value, w) {
        // alert(value);
        window.location.href = `single-product.php?sku_size=${w}&sku_base=${value}`;
    }
    //fixed button functionality start
    // $(document).scroll(function() {

    //     var y = $(this).scrollTop();
    //     if (y > 800) {
    //         if ($('#desktopship-mobile').prop("checked") == true) {
    //             $('.slider-menumob').css('display', 'none');
    //         } else {
    //             $('.slider-menumob').css('display', 'none');
    //         }
    //     } else {
    //         if ($('#desktopship-mobile').prop("checked") == true) {
    //             $('.slider-menumob').css('display', 'none');
    //         } else {
    //             $('.slider-menumob').css('display', 'block');
    //         }
    //     }
    // });
    //fixed button functionality end
    $("#addtocart").click(function() {
        $("#fixurl").val('cart');
        $("#mm").submit(); // Submit the form
    });
    $("#buynow").click(function() {
        $("#fixurl").val('checkout');
        $("#mm").submit(); // Submit the form
    });
    $("#addtocart2").click(function() {
        $("#fixurl").val('cart');
        $("#mm").submit(); // Submit the form
    });
    $("#buynow2").click(function() {
        $("#fixurl").val('checkout');
        $("#mm").submit(); // Submit the form
    });

    //get parameters from url start

    var getParams = function(url) {
        var params = {};
        var parser = document.createElement('a');
        parser.href = url;
        var query = parser.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }
        return params;
    };
    var params = getParams(window.location.href);
    // console.log(params);
    var sku_size = params.sku_size;
    var sku_base = params.sku_base;
    // console.log(sku_base);
    // console.log(sku_size);
    //get parameters from url end

    //Set data in Modal Desktop
    function setData() {
        $('#myModal').modal('show');
    }
    $('#closeModal').click(function() {
        $('#myModal').modal('hide');
    });

    function show_policy() {
        $('#security_policy').toggleClass("show_policy");
        $('#delivery_policy').removeClass("show_policy");
        $('#return_policy').removeClass("show_policy");
    }

    function delivery_policy() {
        $('#delivery_policy').toggleClass("show_policy");
        $('#security_policy').removeClass("show_policy");
        $('#return_policy').removeClass("show_policy");
    }

    function return_policy() {
        $('#return_policy').toggleClass("show_policy");
        $('#delivery_policy').removeClass("show_policy");
        $('#security_policy').removeClass("show_policy");
    }
    //star rating functionality start
    var star_rating = 0;
    const stars = document.querySelectorAll('.star');
    for (x = 0; x < stars.length; x++) {
        stars[x].starValue = (x + 1);
        ["click", "mouseover", "mouseout"].forEach(function(e) {
            stars[x].addEventListener(e, showRating);
        });
    }

    function showRating(e) {
        let type = e.type;
        let starValue = this.starValue;
        // console.log(type);
        if (type === 'click') {
            if (starValue > 0) {
                console.log(starValue);
                star_rating = starValue;
            }
        }
        stars.forEach(function(element, index) {
            if (type === 'click') {
                if (index < starValue) {
                    element.classList.add("orange");
                } else {
                    element.classList.remove("orange");
                }
            }
            if (type === 'mouseover') {
                if (index < starValue) {
                    element.classList.add("yellow");
                } else {
                    element.classList.remove("yellow");
                }
            }
            if (type === 'mouseout') {
                element.classList.remove("yellow");
            }
        });
    }
    //star rating functionality end
    var page = $('#page').val();
    $('#submit_rating').click(function() {
        var name = $("#rating_name").val();
        var email = $("#rating_email").val();
        var message = $("#rating_message").val();
        var error = "";

        function validateEmail(email) {
            var re =
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
        if (!validateEmail(email)) {
            $("#rating_email").css('border-color', 'red');
            $("#rating_email").css('border-width', '2px');
            error = error + 'email';
        } else {
            $("#rating_email").css('border-color', '#C0BBBB');
            $("#rating_email").css('border-width', '1px');
        }
        if ($("#rating_name").val() == "") {
            $("#rating_name").css('border-color', 'red');
            $("#rating_name").css('border-width', '2px');
            error = error + 'name';
        } else {
            $("#rating_name").css('border-color', '#C0BBBB');
            $("#rating_name").css('border-width', '1px');
        }
        if ($("#rating_message").val() == "") {
            $("#rating_message").css('border-color', 'red');
            $("#rating_message").css('border-width', '2px');
            error = error + 'address';
        } else {
            $("#rating_message").css('border-color', '#C0BBBB');
            $("#rating_message").css('border-width', '1px');
        }
        if (star_rating < 1) {
            error = error + 'star';
            alert('Select star first');
        }
        if (error == "") {
            $.ajax({
                type: 'POST',
                url: 'php/star_rating.php',
                dataType: "json",
                data: {
                    'email': email,
                    'name': name,
                    'message': message,
                    'star': star_rating,
                    'sku': sku_base
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == 201) {
                        $("#rating_name").val('');
                        $("#rating_email").val('');
                        $("#rating_message").val('');
                        call(page);
                    } else if (data.status == 301) {
                        $("#rating_name").val('');
                        $("#rating_email").val('');
                        $("#rating_message").val('');
                        call(page);
                    } else {

                    }
                }
            });
        } else {
            // return true;
        }
    });
    call(page);

    function call(page) {
        $('#page').val(page);
        $(".ccc").removeClass("active"); // remove active class from all
        $(`#ccc${page}`).addClass("active");
        $.ajax({
            type: 'POST',
            url: 'php/get_rate.php',
            // dataType: "json",
            data: {
                'page': page,
                'sku': sku_base
            },
            success: function(data) {
                //  console.log(data);
                $('#set_rate').html(data);

            }
        });
    }
    </script>
</body>

</html>