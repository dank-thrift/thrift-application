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
if ((isset($_POST["id"]) && !empty($_POST["id"])) && !empty($_POST["sku_size"])) {
    $d = 0;
    if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
        foreach ($_COOKIE['item'] as $name => $value) {
            $d = $d + 1;
        }
        $d = $d + 1;
    } else {
        $d = $d + 1;
    }
    $sku_size = $_POST["sku_size"];
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
            $sku = $row['sku'] . "-" . $sku_size;
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
                    setcookie("item[$name1]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty1 . "__" . $price1 . "__" . $sku, time() + (86400 * 30), "/");
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
                setcookie("item[$c]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $sku, time() + (86400 * 30), "/");
            }
            // echo $d;
        } else {
            setcookie("item[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $sku, time() + (86400 * 30), "/");
        }
    }
    header("Location:/");
}
// if click on hot deal start
if (isset($_POST["hot_deal_id"]) && !empty($_POST["hot_deal_id"])) {
    $d = 0;
    if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
        foreach ($_COOKIE['item'] as $name => $value) {
            $d = $d + 1;
        }
        $d = $d + 1;
    } else {
        $d = $d + 1;
    }
    $q = "SELECT * FROM product_tbl INNER JOIN `hot_deals` ON product_tbl.id=hot_deals_product_id WHERE hot_deals_product_id=" . $_POST['hot_deal_id'] . "";
    $res = mysqli_query($link, $q);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $design = $row['design'];
            $name = $row['name'];
            $image = $row['image'];
            $image2 = $row['image2'];
            $cost_price = $row['hot_deal_cost_price'];
            $sale_price = $row['hot_deal_sale_price'];
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
// if click on hot deal end
/* ------------------------- total cart price start ------------------------- */

// $c=0;
// if(!empty($_COOKIE['item']) && is_array($_COOKIE['item'])){
//     foreach($_COOKIE['item'] as $name1=>$value){
//         $value12=explode("__",$value);
//         $c+=$value12[9];
//     }
// }
// setcookie("totalcart",$c,time()+(86400 * 30),"/");
/* ------------------------- total cart price end ------------------------- */
/* ----------------------------- wishlist start ----------------------------- */
if (isset($_POST["wishid"]) && !empty($_POST["wishid"]) && isset($_POST["sku_base_size"]) && isset($_POST["sku_base_id"])) {
    $sku_base_id = $_POST["sku_base_id"];
    $sku_base_size = $_POST["sku_base_size"];
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
    header("Location:/");
}
/* ------------------------------ wishlist end ------------------------------ */
if (isset($_POST["hot_deal_wishid"]) && !empty($_POST["hot_deal_wishid"])) {
    $d = 0;
    if (!empty($_COOKIE['wishitem']) && is_array($_COOKIE['wishitem'])) {
        foreach ($_COOKIE['wishitem'] as $name => $value) {
            $d = $d + 1;
        }
        $d = $d + 1;
    } else {
        $d = $d + 1;
    }
    $q = "SELECT * FROM product_tbl INNER JOIN `hot_deals` ON product_tbl.id=hot_deals_product_id WHERE hot_deals_product_id=" . $_POST['hot_deal_wishid'] . "";
    $res = mysqli_query($link, $q);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $design = $row['design'];
            $name = $row['name'];
            $image = $row['image'];
            $image2 = $row['image2'];
            $cost_price = $row['hot_deal_cost_price'];
            $sale_price = $row['hot_deal_sale_price'];
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
                    setcookie("wishitem[$name1]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty1 . "__" . $price1 . "__" . $name1, time() + (86400 * 30), "/");
                }
            }
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
            }
            if ($found == 0) {
                setcookie("wishitem[$c]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $d, time() + (86400 * 30), "/");
            }
        } else {
            setcookie("wishitem[$d]", $image . "__" . $design . "__" . $name . "__" . $image . "__" . $image2 . "__" . $sale_price . "__" . $cost_price . "__" . $id . "__" . $qty . "__" . $price1 . "__" . $d, time() + (86400 * 30), "/");
        }
    }
    header("Location:/");
}
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

?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>Let’s make a Shift to Thrift</title>
    <meta name="description" content="If you haven’t discovered the joy of thrift shopping, now is the time. Dank Thrift is an affordable, sustainable and fashionable thrift store aimed to build a solid community of conscious shoppers.">
    <meta name="Keywords" content="Custom T-shirts,Custom Hoodies, Make your Own,Custom Polo,Custom Round neck,Custom T-shirts ">
    <meta name="author" content="Vinayak">
    <meta property="og:title" content="Let’s make a Shift to Thrift" />
    <meta property="og:url" content="<?= $current_site_link ?>/" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
                                        <a class="sticky_button_side shadow-md enableEthereumButton" title="Add to cart" tabindex="0" onclick="userLoginOut()">Login</a>
                                    </div>
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
                                                    <p class="font-weight-bold" style="display: inline-block;word-break:break-all;white-space: pre-line;overflow-wrap:break-word;">
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
                            <a href="/"><img loading="lazy" class="img-responsive size" src=" <?php echo $img_link ?>images/logo/logo.png" alt="logo.png" /></a>
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
                                                    <option class="option" value="<?php echo $row['category'] ?>">
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
                                    <a href="shop-left-sidebar">Shop</a>
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

            <?php @$dd = 0;
            if (!empty($_COOKIE['item']) && is_array($_COOKIE['item'])) {
                @$dd = $dd + 1;
            }
            if (@$dd == 0) {
                echo "<div class='empty-cart-area mtb-50px'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='cart-heading'><h2 style='font-size:20px;'>Your cart item</h2></div>
                    <div class='empty-text-contant text-center'>
                       <i class='lnr lnr-cart' style='font-size:44px;'></i>
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
                        <?php } ?>


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

    <!-- --------------------------- page start here --------------------------- -->

    <!-- Slider Start desktop -->
    <div class="slider-area d-none d-lg-block">
        <div class="hero-slider-wrapper">
            <?php
            $q = "SELECT * FROM `banner_slider` WHERE 1";
            $res = mysqli_query($link, $q);
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
            ?>
                    <!-- Single Slider  -->
                    <div class="single-slide slider-height-1 bg-img d-flex" data-bg-image=" <?php echo $img_link ?>images/slider-image/<?php echo $row['banner_img1'];; ?>" style="background-position:right;">
                        <div class="container align-self-center">
                            <div class="slider-content-1 slider-animated-<?php echo $row['banner_slider_id']; ?> text-left pl-60px">
                                <h1 class="animated color-black">
                                    <?php echo $row['banner_text_line1']; ?>
                                </h1>
                                <p class="animated color-gray"><?php echo $row['banner_text_line3']; ?></p>
                                <a href="<?php echo $row['button_url']; ?>" class="shop-btn animated"><?php echo $row['banner_text_line4']; ?></a>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
    <!-- Slider End desktop -->

    <!-- Slider Start mobile-->
    <div class="slider-area d-lg-none position-relative">
        <div class="hero-slider-wrapper">
            <?php
            $q = "SELECT * FROM `banner_slider` WHERE 1";
            $res = mysqli_query($link, $q);
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
            ?>
                    <!-- Single Slider  -->
                    <div class="single-slide slider-height-1 bg-img d-flex" data-bg-image=" <?php echo $img_link ?>images/slider-image/<?php echo $row['banner_img_mobile']; ?>" style="background-position:right;">
                        <div class="container align-self-center">
                            <div class="slider-content-1 slider-animated-<?php echo $row['banner_slider_id']; ?> text-left pl-60px">
                                <h1 class="animated color-black">
                                    <?php echo $row['banner_text_line1']; ?>
                                </h1>
                                <p class="animated color-gray"><?php echo $row['banner_text_line3']; ?></p>
                                <a href="<?php echo $row['button_url']; ?>" class="shop-btn animated"><?php echo $row['banner_text_line4']; ?></a>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
    <!-- Slider End mobile-->

    <!-- Static Area Start -->
    <div class="static-area mtb-50px">
        <div class="container">
            <div class="static-area-wrap">
                <div class="row">
                    <!-- Static Single Item Start -->
                    <div class="col-lg-4 col-xs-12 col-md-6 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-static">
                            <img loading="lazy" src=" <?php echo $img_link ?>images/icons/static-icons-1.png" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Free Shipping</h4>
                                <p>On all orders above ₹1000</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <!-- <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-static">
                            <img loading="lazy" src=" <?php echo $img_link ?>images/icons/static-icons-2.png" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Free Returns</h4>
                                <p>Returns are free within 9 days</p>
                            </div>
                        </div>
                    </div> -->
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-4 col-xs-12 col-md-6 col-sm-6 mb-sm-30px">
                        <div class="single-static">
                            <img loading="lazy" src=" <?php echo $img_link ?>images/icons/static-icons-3.png" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>100% Secure Payments</h4>
                                <p>Your payments are safe with us</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-4 col-xs-12 col-md-6 col-sm-6 ">
                        <div class="single-static">
                            <img loading="lazy" src=" <?php echo $img_link ?>images/icons/static-icons-4.png" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Support 24/7</h4>
                                <p>Contact us 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Static Area End -->

    <!-- Feature Area Start -->
    <div class="feature-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2>Featured Products</h2>
                            </div>
                        </div>
                    </div>
                    <div class="feature-slider-wrapper slider-nav-style-1">
                        <?php
                        $query = "SELECT * FROM product_tbl ORDER BY rand() ASC LIMIT 10";
                        $result = mysqli_query($link, $query);
                        $data = array();
                        if (mysqli_num_rows($result) > 0) {
                            $show_hide = 'd-inline-block';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $data[] = $row;
                            }
                            $j = 0;
                            for ($i = 0; $i < ceil(count($data) / 2); $i++) {
                                if (($data[$i + $j]['sale_price']) == ($data[$i + $j]['cost_price'])) {
                                    $show_hide = 'd-none';
                                } else {
                                    $show_hide = 'd-inline-block';
                                }
                                $url_sku_size = '';
                                if ($data[$i + $j]['extra_small_size'] !== '') {
                                    $url_sku_size = 'XS';
                                } else if ($data[$i + $j]['small_size'] !== '') {
                                    $url_sku_size = 'S';
                                } else if ($data[$i + $j]['medium_size'] !== '') {
                                    $url_sku_size = 'M';
                                } else if ($data[$i + $j]['large_size'] !== '') {
                                    $url_sku_size = 'L';
                                } else if ($data[$i + $j]['extra_large_size'] !== '') {
                                    $url_sku_size = 'XL';
                                }
                        ?>
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center mb-30px">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j]['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j]['image2'] ?>" alt="" />
                                                </a>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a class="quick_view" href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j]['sku'] ?>" data-link-action="quickview" title="Quick view">
                                                                <i class="lnr lnr-magnifier"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form method="post">
                                                                <input type="hidden" name="sku_base_id" class="sizeId" id="sizeId<?php echo $data[$i + $j]['id'] ?>" value="<?php echo $data[$i + $j]['sku'] ?>">
                                                                <input type="hidden" name="wishid" value="<?php echo $data[$i + $j]['id'] ?>" id="wishid">
                                                                <input type="hidden" name="sku_base_size" id="sku_base_size1" value="<?php echo $url_sku_size ?>">
                                                                <button><a title="Add to Wishlist"><i class="lnr lnr-heart"></i></a></button>
                                                            </form>
                                                        </li>
                                                        <!--   -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="product-flag">
                                                <li class="new <?php echo $show_hide ?>">
                                                    -<?php echo number_format((($data[$i + $j]['cost_price'] - $data[$i + $j]['sale_price']) / $data[$i + $j]['cost_price']) * 100, 2); ?>%
                                                </li>
                                            </ul>
                                            <form method="post" class="target" id="target<?php echo $data[$i + $j]['id']; ?>">
                                                <div class="product-decs">
                                                    <a class="inner-link" href="/"><span><?php echo $data[$i + $j]["design"] ?></span></a>
                                                    <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i]['sku'] ?>" class="product-link"><?php echo $data[$i + $j]["name"] ?></a></h2>
                                                    <div class="pricing-meta">
                                                        Available Size :
                                                        <ul class="size_chart2" id="size_chart<?php echo $data[$i + $j]['id']; ?>">
                                                            <?php
                                                            if ($data[$i + $j]['extra_small_size'] == 'XS') {
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
                                                            if ($data[$i + $j]['small_size'] == 'S') {
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
                                                            if ($data[$i + $j]['medium_size'] == 'M') {
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
                                                            if ($data[$i + $j]['large_size'] == 'L') {
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
                                                            if ($data[$i + $j]['extra_large_size'] == 'XL') {
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
                                                                &#8377;<?php echo $data[$i + $j]["cost_price"] ?></li>
                                                            <li class="current-price">
                                                                &#8377;<?php echo $data[$i + $j]["sale_price"] ?></li>
                                                        </ul>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?php echo $data[$i + $j]['id']; ?>" id="id<?php echo $data[$i + $j]['id']; ?>">
                                                            <input type="hidden" name="sku_size" id="sku_size1" value="<?php echo $url_sku_size ?>">
                                                            <button><a class="add-to-curt" title="Add to cart">Add to
                                                                    cart</a></button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- <div class="cart-btn">
                                                    <input type="hidden" name="size" class="sizeId" id="sizeId<?php echo $data[$i + $j]['id']; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $data[$i + $j]['id']; ?>" id="id">
                                                    <button onclick="submitForm(<?php echo $data[$i + $j]['id']; ?>)"><a class="add-to-curt" title="Add to cart">Add to cart</a></button>
                                                </div> -->
                                            </form>
                                        </div>
                                    </article>

                                    <!-- Single Item -->
                                    <?php
                                    $show_hide = 'd-inline-block';
                                    if (($data[$i + $j + 1]['sale_price']) == ($data[$i + $j + 1]['cost_price'])) {
                                        $show_hide = 'd-none';
                                    } else {
                                        $show_hide = 'd-inline-block';
                                    }
                                    $url_sku_size = '';
                                    if ($data[$i + $j + 1]['extra_small_size'] !== '') {
                                        $url_sku_size = 'XS';
                                    } else if ($data[$i + $j + 1]['small_size'] !== '') {
                                        $url_sku_size = 'S';
                                    } else if ($data[$i + $j + 1]['medium_size'] !== '') {
                                        $url_sku_size = 'M';
                                    } else if ($data[$i + $j + 1]['large_size'] !== '') {
                                        $url_sku_size = 'L';
                                    } else if ($data[$i + $j + 1]['extra_large_size'] !== '') {
                                        $url_sku_size = 'XL';
                                    }
                                    ?>
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + 1]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + 1]["image"] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + 1]["image2"] ?>" alt="" />
                                                </a>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a class="quick_view" href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + 1]['sku'] ?>" data-link-action="quickview" title="Quick view">
                                                                <i class="lnr lnr-magnifier"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form method="post">
                                                                <input type="hidden" name="sku_base_id" class="sizeId" id="sizeId<?php echo $data[$i + $j + 1]['id'] ?>" value="<?php echo $data[$i + $j + 1]['sku'] ?>">
                                                                <input type="hidden" name="wishid" value="<?php echo $data[$i + $j + 1]['id'] ?>" id="wishid">
                                                                <input type="hidden" name="sku_base_size" id="sku_base_size2" value="<?php echo $url_sku_size ?>">
                                                                <button><a title="Add to Wishlist"><i class="lnr lnr-heart"></i></a></button>
                                                            </form>
                                                        </li>
                                                        <!--   -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="product-flag">
                                                <li class="new <?php echo $show_hide ?>">
                                                    -<?php echo number_format((($data[$i + $j + 1]['cost_price'] - $data[$i + $j + 1]['sale_price']) / $data[$i + $j + 1]['cost_price']) * 100, 2); ?>%
                                                </li>
                                            </ul>
                                            <form method="post" class="target" id="target<?php echo $data[$i + $j + 1]['id']; ?>">
                                                <div class="product-decs">
                                                    <a class="inner-link" href="/"><span><?php echo $data[$i + $j + 1]["design"] ?></span></a>
                                                    <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + 1]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + 1]["name"] ?></a>
                                                    </h2>
                                                    <div class="pricing-meta">
                                                        Available Size :
                                                        <ul class="size_chart2" id="size_chart<?php echo $data[$i + $j + 1]['id']; ?>">
                                                            <?php
                                                            if ($data[$i + $j]['extra_small_size'] == 'XS') {
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
                                                            if ($data[$i + $j]['small_size'] == 'S') {
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
                                                            if ($data[$i + $j]['medium_size'] == 'M') {
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
                                                            if ($data[$i + $j]['large_size'] == 'L') {
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
                                                            if ($data[$i + $j]['extra_large_size'] == 'XL') {
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
                                                                &#8377;<?php echo $data[$i + $j + 1]["cost_price"] ?></li>
                                                            <li class="current-price">
                                                                &#8377;<?php echo $data[$i + $j + 1]["sale_price"] ?></li>
                                                        </ul>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?php echo $data[$i + $j + 1]['id']; ?>" id="id<?php echo $data[$i + $j + 1]['id']; ?>">
                                                            <input type="hidden" name="sku_size" id="sku_size2" value="<?php echo $url_sku_size ?>">
                                                            <button><a class="add-to-curt" title="Add to cart">Add to
                                                                    cart</a></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </article>
                                </div>
                        <?php
                                $j = $j + 1;
                            }
                        }

                        ?>
                        <!-- --------------------------- test paste here start--------------------------- -->

                        <!-- --------------------------- test paste here end--------------------------- -->

                    </div>
                </div>
                <!-- Feature Area End -->
            </div>
        </div>
    </div>
    <!-- Banner Area End -->

    <!-- Banner Area Start -->
    <div class="banner-area mt-30px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-wrapper d-lg-block d-none">
                        <a href="search.php?cat=all&search=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/1.jpg" alt="" /></a>
                    </div>
                    <div class="banner-wrapper d-lg-none">
                        <a href="search.php?cat=all&search=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/1mobile.jpg" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="banner-area mt-30px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-wrapper d-lg-block d-none">
                        <a href="search.php?cat=all&search=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/BANNER  DANK THRIFT (1).jpg" alt="" /></a>
                    </div>
                    <div class="banner-wrapper d-lg-none">
                        <a href="search.php?cat=all&search=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/1mobile.jpg" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-area mt-30px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-wrapper d-lg-block d-none">
                        <a href="search.php?cat=all&search=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/BANNER  DANK THRIFT.jpg" alt="" /></a>
                    </div>
                    <div class="banner-wrapper d-lg-none">
                        <a href="search.php?cat=all&search=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/1mobile.jpg" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Banner Area End -->

    <!-- Best sell Area Start -->
    <div class="best-sell-area mt-20px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>Best Sellers</h2>
                    </div>
                </div>
            </div>
            <div class="best-sell-area-wrapper slider-nav-style-1 slider-nav-style-4">
                <?php
                $query = "SELECT * FROM product_tbl ORDER BY rand() ASC LIMIT 6";
                $result = mysqli_query($link, $query);
                $data = array();
                if (mysqli_num_rows($result) > 0) {
                    $show_hide = 'd-inline-block';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data[] = $row;
                    }
                    $j = 0;
                    for ($i = 0; $i < ceil(count($data) / 2); $i++) {
                        if (($data[$i + $j]['sale_price']) == ($data[$i + $j]['cost_price'])) {
                            $show_hide = 'd-none';
                        } else {
                            $show_hide = 'd-inline-block';
                        }
                        $url_sku_size = '';
                        if ($data[$i + $j]['extra_small_size'] !== '') {
                            $url_sku_size = 'XS';
                        } else if ($data[$i + $j]['small_size'] !== '') {
                            $url_sku_size = 'S';
                        } else if ($data[$i + $j]['medium_size'] !== '') {
                            $url_sku_size = 'M';
                        } else if ($data[$i + $j]['large_size'] !== '') {
                            $url_sku_size = 'L';
                        } else if ($data[$i + $j]['extra_large_size'] !== '') {
                            $url_sku_size = 'XL';
                        }
                ?>
                        <div class="single-slider-item">
                            <!-- Single Item -->
                            <article class="list-product text-center">
                                <div class="product-inner">
                                    <div class="img-block">
                                        <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j]['sku'] ?>" class="thumbnail">
                                            <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j]['image'] ?>" alt="" />
                                            <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j]['image2'] ?>" alt="" />
                                        </a>
                                        <div class="add-to-link">
                                            <ul>
                                                <li>
                                                    <a class="quick_view" href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j]['sku'] ?>" data-link-action="quickview" title="Quick view">
                                                        <i class="lnr lnr-magnifier"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="post">
                                                        <input type="hidden" name="sku_base_id" class="sizeId" id="sizeId<?php echo $data[$i + $j]['id'] ?>" value="<?php echo $data[$i + $j]['sku'] ?>">
                                                        <input type="hidden" name="wishid" value="<?php echo $data[$i + $j]['id'] ?>" id="wishid">
                                                        <input type="hidden" name="sku_base_size" id="sku_base_size3" value="<?php echo $url_sku_size ?>">
                                                        <button><a title="Add to Wishlist"><i class="lnr lnr-heart"></i></a></button>
                                                    </form>
                                                </li>
                                                <!--   -->
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new <?php echo $show_hide ?>">
                                            -<?php echo number_format((($data[$i + $j]['cost_price'] - $data[$i + $j]['sale_price']) / $data[$i + $j]['cost_price']) * 100, 2); ?>%
                                        </li>
                                    </ul>
                                    <div class="product-decs">
                                        <a class="inner-link" href="/"><span><?php echo $data[$i + $j]['design'] ?></span></a>
                                        <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j]['sku'] ?>" class="product-link"><?php echo $data[$i + $j]['name'] ?></a></h2>
                                        <!-- <div class="availability-list in-stock">Availability: <span>900 In Stock</span></div> -->
                                        <p><?php echo $data[$i + $j]['product_desc']; ?></p>
                                        <!-- <div class="pricing-meta">
                                                <ul class="size_chart">
                                                    
                                                    <li>S</li>
                                                    <li>M</li>
                                                    <li>L</li>
                                                    <li>XL</li>
                                                </ul>
                                            </div> -->
                                        <div class="pricing-meta">
                                            <ul>
                                                <li class="old-price <?php echo $show_hide ?>">
                                                    &#8377;<?php echo $data[$i + $j]['cost_price'] ?></li>
                                                <li class="current-price">&#8377;<?php echo $data[$i + $j]['sale_price'] ?></li>
                                            </ul>
                                        </div>
                                        <div class="cart-btn">
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $data[$i + $j]['id']; ?>" id="id<?php echo $data[$i + $j]['id']; ?>">
                                                <input type="hidden" name="sku_size" id="sku_size3" value="<?php echo $url_sku_size ?>">
                                                <button><a class="add-to-curt" title="Add to cart">Add to cart</a></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Single Item -->
                            <?php
                            $show_hide = 'd-inline-block';
                            if (($data[$i + $j + 1]['sale_price']) == ($data[$i + $j + 1]['cost_price'])) {
                                $show_hide = 'd-none';
                            } else {
                                $show_hide = 'd-inline-block';
                            }
                            $url_sku_size = '';
                            if ($data[$i + $j + 1]['extra_small_size'] !== '') {
                                $url_sku_size = 'XS';
                            } else if ($data[$i + $j + 1]['small_size'] !== '') {
                                $url_sku_size = 'S';
                            } else if ($data[$i + $j + 1]['medium_size'] !== '') {
                                $url_sku_size = 'M';
                            } else if ($data[$i + $j + 1]['large_size'] !== '') {
                                $url_sku_size = 'L';
                            } else if ($data[$i + $j + 1]['extra_large_size'] !== '') {
                                $url_sku_size = 'XL';
                            }
                            ?>
                            <article class="list-product text-center">
                                <div class="product-inner">
                                    <div class="img-block">
                                        <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + 1]['sku'] ?>" class="thumbnail">
                                            <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + 1]['image'] ?>" alt="" />
                                            <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + 1]['image2'] ?>" alt="" />
                                        </a>
                                        <div class="add-to-link">
                                            <ul>
                                                <li>
                                                    <a class="quick_view" href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + 1]['sku'] ?>" data-link-action="quickview" title="Quick view">
                                                        <i class="lnr lnr-magnifier"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="post">
                                                        <input type="hidden" name="sku_base_id" class="sizeId" id="sizeId<?php echo $data[$i + $j + 1]['id'] ?>" value="<?php echo $data[$i + $j + 1]['sku'] ?>">
                                                        <input type="hidden" name="wishid" value="<?php echo $data[$i + $j + 1]['id'] ?>" id="wishid">
                                                        <input type="hidden" name="sku_base_size" id="sku_base_size4" value="<?php echo $url_sku_size ?>">
                                                        <button><a title="Add to Wishlist"><i class="lnr lnr-heart"></i></a></button>
                                                    </form>
                                                </li>
                                                <!--   -->
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new <?php echo $show_hide ?>">
                                            -<?php echo number_format((($data[$i + $j + 1]['cost_price'] - $data[$i + $j + 1]['sale_price']) / $data[$i + $j + 1]['cost_price']) * 100, 2); ?>%
                                        </li>
                                    </ul>
                                    <div class="product-decs">
                                        <a class="inner-link" href="/"><span><?php echo $data[$i + $j + 1]['design'] ?></span></a>
                                        <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + 1]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + 1]['name'] ?></a></h2>
                                        <!-- <div class="availability-list in-stock">Availability: <span>300 In Stock</span></div> -->
                                        <p><?php echo $data[$i + $j + 1]['product_desc'] ?></p>
                                        <!-- <div class="pricing-meta">
                                                <ul class="size_chart">
                                                    
                                                    <li>S</li>
                                                    <li>M</li>
                                                    <li>L</li>
                                                    <li>XL</li>
                                                </ul>
                                            </div> -->
                                        <div class="pricing-meta">
                                            <ul>
                                                <li class="old-price <?php echo $show_hide ?>">
                                                    &#8377;<?php echo $data[$i + $j + 1]['cost_price'] ?></li>
                                                <li class="current-price">&#8377;<?php echo $data[$i + $j + 1]['sale_price'] ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="cart-btn">
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $data[$i + $j + 1]['id']; ?>" id="id<?php echo $data[$i + $j + 1]['id']; ?>">
                                                <input type="hidden" name="sku_size" id="sku_size4" value="<?php echo $url_sku_size ?>">
                                                <button><a class="add-to-curt" title="Add to cart">Add to cart</a></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                <?php
                        $j = $j + 1;
                    }
                }

                ?>
            </div>
        </div>
    </div>
    <!-- Best sell Area End -->
    <!-- Banner Area Start -->
    <div class="banner-area mt-30px mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 ">
                    <div class="banner-wrapper d-lg-block d-none">
                        <a href="shop-left-sidebar.php?&sub_category=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/2.jpg" alt="" /></a>
                    </div>
                    <div class="banner-wrapper d-lg-none">
                        <a href="shop-left-sidebar.php?&sub_category=bundle"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/2mobile.jpg" alt="" /></a>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="banner-wrapper d-lg-block d-none">
                        <a href="shop-left-sidebar.php?category=men"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/3.jpg" alt="" /></a>
                    </div>
                    <div class="banner-wrapper d-lg-none">
                        <a href="shop-left-sidebar.php?category=men"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/3mobile.jpg" alt="" /></a>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="banner-wrapper d-lg-block d-none">
                        <a href="shop-left-sidebar.php?category=men"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/4.jpg" alt="" /></a>
                    </div>
                    <div class="banner-wrapper d-lg-none">
                        <a href="shop-left-sidebar.php?category=men"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/4mobile.jpg" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Area End -->

    <!-- Arrivals Area Start -->
    <div class="arrival-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>New Arrivals</h2>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs sub-category">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-1">Men</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-2">Women</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-3">Smart Watch</a>
                            </li> -->
                        </ul>
                        <!-- Nav tabs -->
                    </div>
                </div>
            </div>
            <!-- tab content -->
            <div class="tab-content">
                <!-- First-Tab -->
                <div id="tab-1" class="tab-pane active fade">
                    <!-- Arrivel slider start -->
                    <div class="arrival-slider-wrapper slider-nav-style-1">
                        <?php
                        $query = "SELECT * FROM `product_tbl`  WHERE `product_category_id`='1' ORDER BY id ASC LIMIT 6";
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
                                if ($row['extra_small_size'] !== '') {
                                    $url_sku_size = 'XS';
                                } else if ($row['small_size'] !== '') {
                                    $url_sku_size = 'S';
                                } else if ($row['medium_size'] !== '') {
                                    $url_sku_size = 'M';
                                } else if ($row['large_size'] !== '') {
                                    $url_sku_size = 'L';
                                } else if ($row['extra_large_size'] !== '') {
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
                                                            <a class="quick_view" href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $row['sku'] ?>" data-link-action="quickview" title="Quick view">
                                                                <i class="lnr lnr-magnifier"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form method="post">
                                                                <input type="hidden" name="sku_base_id" class="sizeId" id="sizeId<?php echo $row['id'] ?>" value="<?php echo $row['sku'] ?>">
                                                                <input type="hidden" name="wishid" value="<?php echo $row['id']; ?>" id="wishid">
                                                                <input type="hidden" name="sku_base_size" id="sku_base_size5" value="<?php echo $url_sku_size ?>">
                                                                <button><a title="Add to Wishlist"><i class="lnr lnr-heart"></i></a></button>
                                                            </form>
                                                        </li>
                                                        <!--   -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="product-flag">
                                                <li class="new <?php echo ($show_hide) ?>">
                                                    -<?php echo number_format((($row['cost_price'] - $row['sale_price']) / $row['cost_price']) * 100, 2); ?>%
                                                </li>
                                            </ul>
                                            <div class="product-decs">
                                                <a class="inner-link" href="/"><span><?php echo $row['design'] ?></span></a>
                                                <h2><a href="single-product.php?id=<?php echo $row['id'] ?>" class="product-link"><?php echo $row['name'] ?></a></h2>
                                                <div class="pricing-meta">
                                                    Available Size :
                                                    <ul class="size_chart2" id="size_chart<?php echo $data[$i + $j]['id']; ?>">
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
                                                        <li class="old-price <?php echo ($show_hide) ?>">
                                                            &#8377;<?php echo $row['cost_price'] ?></li>
                                                        <li class="current-price">&#8377;<?php echo $row['sale_price'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="cart-btn">
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" id="id">
                                                    <input type="hidden" name="sku_size" id="sku_size5" value="<?php echo $url_sku_size ?>">
                                                    <button><a class="add-to-curt" title="Add to cart">Add to cart</a></button>
                                                </form>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                        <?php }
                        } ?>
                    </div>
                    <!-- Arrivel slider end -->
                </div>
                <!-- First-Tab -->
                <!-- Second-Tab -->
                <div id="tab-2" class="tab-pane fade">
                    <!-- Arrivel slider start -->
                    <div class="arrival-slider-wrapper slider-nav-style-1">
                        <?php
                        $query = "SELECT * FROM `product_tbl`  WHERE `product_category_id`='2' ORDER BY id ASC LIMIT 6";
                        $result = mysqli_query($link, $query);
                        if (mysqli_num_rows($result) > 0) {
                            $show_hide = 'd-inline-block';
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sale_price'] == $row['cost_price']) {
                                    $show_hide = 'd-none';
                                } else {
                                    $show_hide = 'd-inline-block';
                                }
                        ?>
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?id=<?php echo $row['id'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $row['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $row['image2'] ?>" alt="" />
                                                </a>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a class="quick_view" href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j]['sku'] ?>" data-link-action="quickview" title="Quick view">
                                                                <i class="lnr lnr-magnifier"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form method="post">
                                                                <input type="hidden" name="sku_base_id" class="sizeId" id="sizeId<?php echo $row['id'] ?>" value="<?php echo $row['sku'] ?>">
                                                                <input type="hidden" name="wishid" value="<?php echo $row['id']; ?>" id="wishid">
                                                                <input type="hidden" name="sku_base_size" id="sku_base_size6" value="<?php echo $url_sku_size ?>">
                                                                <button><a title="Add to Wishlist"><i class="lnr lnr-heart"></i></a></button>
                                                            </form>
                                                        </li>
                                                        <!--   -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="product-flag">
                                                <li class="new <?php echo ($show_hide . $row['id']) ?>">
                                                    -<?php echo number_format((($row['cost_price'] - $row['sale_price']) / $row['cost_price']) * 100, 2); ?>%
                                                </li>
                                            </ul>
                                            <div class="product-decs">
                                                <a class="inner-link" href="/"><span><?php echo $row['design'] ?></span></a>
                                                <h2><a href="single-product.php?id=<?php echo $row['id'] ?>" class="product-link"><?php echo $row['name'] ?></a></h2>
                                                <div class="pricing-meta">
                                                    Available Size :
                                                    <ul class="size_chart2" id="size_chart<?php echo $data[$i + $j]['id']; ?>">
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
                                            <div class="cart-btn">
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" id="id">
                                                    <input type="hidden" name="sku_size" id="sku_size6" value="<?php echo $url_sku_size ?>">
                                                    <button><a class="add-to-curt" title="Add to cart">Add to cart</a></button>
                                                </form>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                        <?php }
                        } ?>
                    </div>
                    <!-- Arrivel slider end -->
                </div>
                <!-- Second-Tab -->
                <!-- Third-Tab -->
                <!-- Third-Tab -->
            </div>
            <!-- tab content end-->
        </div>
    </div>
    <!-- Arrivals Area End -->

    <!-- Banner Area Start -->
    <!-- <div class="banner-area mt-20px mb-20px ">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="banner-wrapper">
                        <a href="/"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/5.jpg" alt="" /></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="banner-wrapper">
                        <a href="/"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/6.jpg" alt="" /></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="banner-wrapper">
                        <a href="/"><img loading="lazy" src=" <?php echo $img_link ?>images/banner-image/7.jpg" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Banner Area End -->
    <!-- Catogery slider area Start-->
    <div class="category-slider-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-md-30px mb-lm-30px">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2>Women</h2>
                            </div>
                        </div>
                    </div>
                    <div class="category-slider-wraper slider-nav-style-1">
                        <?php
                        $query = "SELECT * FROM `product_tbl`  WHERE `product_category_id`='2' ORDER BY id ASC LIMIT 6";
                        $result = mysqli_query($link, $query);
                        $data = array();
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $data[] = $row;
                            }
                            $j = 0;
                            $k = 0;
                            for ($i = 0; $i < ceil(count($data) / 3); $i++) {
                                $url_sku_size = '';
                                if ($data[$i + $j + $k]['extra_small_size'] !== '') {
                                    $url_sku_size = 'XS';
                                } else if ($data[$i + $j + $k]['small_size'] !== '') {
                                    $url_sku_size = 'S';
                                } else if ($data[$i + $j + $k]['medium_size'] !== '') {
                                    $url_sku_size = 'M';
                                } else if ($data[$i + $j + $k]['large_size'] !== '') {
                                    $url_sku_size = 'L';
                                } else if ($data[$i + $j + $k]['extra_large_size'] !== '') {
                                    $url_sku_size = 'XL';
                                }
                        ?>
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k]['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k]['image2'] ?>" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + $k]['name'] ?></a></h2>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">
                                                            &#8377;<?php echo $data[$i + $j + $k]['sale_price'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <!-- Single Item -->
                                    <?php
                                    $url_sku_size = '';
                                    if ($data[$i + $j + $k + 1]['extra_small_size'] !== '') {
                                        $url_sku_size = 'XS';
                                    } else if ($data[$i + $j + $k + 1]['small_size'] !== '') {
                                        $url_sku_size = 'S';
                                    } else if ($data[$i + $j + $k + 1]['medium_size'] !== '') {
                                        $url_sku_size = 'M';
                                    } else if ($data[$i + $j + $k + 1]['large_size'] !== '') {
                                        $url_sku_size = 'L';
                                    } else if ($data[$i + $j + $k + 1]['extra_large_size'] !== '') {
                                        $url_sku_size = 'XL';
                                    }
                                    ?>
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 1]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 1]['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 1]['image2'] ?>" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 1]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + $k + 1]['name'] ?></a>
                                                </h2>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">
                                                            &#8377;<?php echo $data[$i + $j + $k + 1]['sale_price'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <!-- Single Item -->
                                    <?php
                                    $url_sku_size = '';
                                    if ($data[$i + $j + $k + 2]['extra_small_size'] !== '') {
                                        $url_sku_size = 'XS';
                                    } else if ($data[$i + $j + $k + 2]['small_size'] !== '') {
                                        $url_sku_size = 'S';
                                    } else if ($data[$i + $j + $k + 2]['medium_size'] !== '') {
                                        $url_sku_size = 'M';
                                    } else if ($data[$i + $j + $k + 2]['large_size'] !== '') {
                                        $url_sku_size = 'L';
                                    } else if ($data[$i + $j + $k + 2]['extra_large_size'] !== '') {
                                        $url_sku_size = 'XL';
                                    }
                                    ?>
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 2]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 2]['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 2]['image2'] ?>" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 2]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + $k + 2]['name'] ?></a>
                                                </h2>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">
                                                            &#8377;<?php echo $data[$i + $j + $k + 2]['sale_price'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                        <?php
                                $j = $j + 1;
                                $k = $k + 1;
                            }
                        }

                        ?>
                    </div>

                </div>
                <div class="col-lg-6 mb-md-30px mb-lm-30px">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2>Men</h2>
                            </div>
                        </div>
                    </div>
                    <div class="category-slider-wraper slider-nav-style-1">
                        <?php
                        $query = "SELECT * FROM `product_tbl`  WHERE `product_category_id`='1' ORDER BY id ASC LIMIT 6";
                        $result = mysqli_query($link, $query);
                        $data = array();
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $data[] = $row;
                            }
                            $j = 0;
                            $k = 0;
                            for ($i = 0; $i < ceil(count($data) / 3); $i++) {
                                $url_sku_size = '';
                                if ($data[$i + $j + $k]['extra_small_size'] !== '') {
                                    $url_sku_size = 'XS';
                                } else if ($data[$i + $j + $k]['small_size'] !== '') {
                                    $url_sku_size = 'S';
                                } else if ($data[$i + $j + $k]['medium_size'] !== '') {
                                    $url_sku_size = 'M';
                                } else if ($data[$i + $j + $k]['large_size'] !== '') {
                                    $url_sku_size = 'L';
                                } else if ($data[$i + $j + $k]['extra_large_size'] !== '') {
                                    $url_sku_size = 'XL';
                                }

                        ?>
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k]['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k]['image2'] ?>" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + $k]['name'] ?></a></h2>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">
                                                            &#8377;<?php echo $data[$i + $j + $k]['sale_price'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <!-- Single Item -->
                                    <?php
                                    $url_sku_size = '';
                                    if ($data[$i + $j + $k + 1]['extra_small_size'] !== '') {
                                        $url_sku_size = 'XS';
                                    } else if ($data[$i + $j + $k + 1]['small_size'] !== '') {
                                        $url_sku_size = 'S';
                                    } else if ($data[$i + $j + $k + 1]['medium_size'] !== '') {
                                        $url_sku_size = 'M';
                                    } else if ($data[$i + $j + $k + 1]['large_size'] !== '') {
                                        $url_sku_size = 'L';
                                    } else if ($data[$i + $j + $k + 1]['extra_large_size'] !== '') {
                                        $url_sku_size = 'XL';
                                    }
                                    ?>
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 1]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 1]['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 1]['image2'] ?>" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 1]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + $k + 1]['name'] ?></a>
                                                </h2>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">
                                                            &#8377;<?php echo $data[$i + $j + $k + 1]['sale_price'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <!-- Single Item -->
                                    <?php
                                    $url_sku_size = '';
                                    if ($data[$i + $j + $k + 2]['extra_small_size'] !== '') {
                                        $url_sku_size = 'XS';
                                    } else if ($data[$i + $j + $k + 2]['small_size'] !== '') {
                                        $url_sku_size = 'S';
                                    } else if ($data[$i + $j + $k + 2]['medium_size'] !== '') {
                                        $url_sku_size = 'M';
                                    } else if ($data[$i + $j + $k + 2]['large_size'] !== '') {
                                        $url_sku_size = 'L';
                                    } else if ($data[$i + $j + $k + 2]['extra_large_size'] !== '') {
                                        $url_sku_size = 'XL';
                                    }
                                    ?>
                                    <article class="list-product text-center">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 2]['sku'] ?>" class="thumbnail">
                                                    <img loading="lazy" class="first-img" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 2]['image'] ?>" alt="" />
                                                    <img loading="lazy" class="second-img d-lg-block d-none" src=" <?php echo $img_link ?>images/product-image/<?php echo $data[$i + $j + $k + 2]['image2'] ?>" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.php?sku_size=<?= $url_sku_size ?>&sku_base=<?php echo $data[$i + $j + $k + 2]['sku'] ?>" class="product-link"><?php echo $data[$i + $j + $k + 2]['name'] ?></a>
                                                </h2>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">
                                                            &#8377;<?php echo $data[$i + $j + $k + 2]['sale_price'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                        <?php
                                $j = $j + 1;
                                $k = $k + 1;
                            }
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Catogery slider area End-->
    <!-- Brand area start -->

    <!-- Brand area end -->
    <!-- --------------------------- page  end here --------------------------- -->

    <!-- News letter area  End -->

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
    <!-- Modal -->

    <!-- Modal end -->
    <!-- Modal 1-->

    <!-- Modal2 end -->
    <!-- JS   ============================================ -->
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="js/vendor.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/main.js"></script>



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




    <!-- <script src="https://unpkg.com/@metamask/legacy-web3@latest/dist/metamask.web3.min.js"></script> -->
    <!-- <script src="js/new.js"></script> -->
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
                        // window.location.replace('/');
                        window.location.reload();
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
                        console.log(data);
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
                        $('#model_id2').val(data.id);
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
                        $('#model_name2').html(data.name);
                        $('#model_design2').html((data.design));
                        $('#model_desc2').html(data.product_desc);
                        $('#model_cost_price2').html((data.cost_price));
                        $('#model_sale_price2').html(data.sale_price);
                        if ((data.sale_price) == (data.cost_price)) {
                            $('#model_old_price2').css('display', 'none');
                        } else {
                            $('#model_old_price2').css('display', 'inline-block');
                        }

                    } else {

                    }
                }
            });
        }
        $(document).ready(function() {
            var selector = '.size_chart li';
            $(selector).on('click', function() {
                $(selector).removeClass('size_chart_active');
                $(this).addClass('size_chart_active');
            });
        });

        function size(value, w) {
            // alert(value);
            $(`#sizeId${w}`).val(value);
        }

        function submitForm(v) {
            if ($(`#sizeId${v}`).val() === '') {
                $(`#size_chart${v}>li`).css('border', '2px solid red');
                event.preventDefault();
            } else {
                $(this).attr('id').submit();
            }
        }
    </script>

</body>

</html>