<?php
session_start();
require 'config.php'; // Assuming config.php contains the PDO setup

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$sql_total_orders = "SELECT COUNT(*) AS total_orders FROM `order`";
$stmt = $pdo->query($sql_total_orders);
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];
//payment validé
$sql_total_orders_valid = "SELECT COUNT(*) AS total_orders_valid FROM `order` WHERE `status` = 'valide'";
$stmt = $pdo->query($sql_total_orders_valid);
$total_orders_valid = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders_valid'];
//payment impayé
$sql_total_orders_Impaye = "SELECT COUNT(*) AS total_orders_Impaye FROM `order` WHERE `status` = 'Impayé'";
$stmt = $pdo->query($sql_total_orders_Impaye);
$total_orders_Impaye = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders_Impaye'];



$sql_total_persons = "SELECT COUNT(DISTINCT email) AS total_persons FROM `order`"; // Use backticks around 'order'
$stmt = $pdo->query($sql_total_persons);
$total_persons = $stmt->fetch(PDO::FETCH_ASSOC)['total_persons'];
// Fetch average order value
$sql_avg_order_value = "SELECT AVG(price) AS average_order_value FROM `order`";
$stmt = $pdo->query($sql_avg_order_value);
$avg_order_value = $stmt->fetch(PDO::FETCH_ASSOC)['average_order_value'];

// Fetch total revenue
$sql_total_revenue = "SELECT SUM(paidamount) AS total_revenue FROM `order`";
$stmt = $pdo->query($sql_total_revenue);
$total_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];

// Fetch orders by category
$sql_orders_by_category = "SELECT product_cat, COUNT(*) AS total_orders FROM `order` GROUP BY product_cat";
$stmt = $pdo->query($sql_orders_by_category);
$orders_by_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch orders by month
$sql_orders_by_month = "SELECT MONTH(request_date_time) AS month, COUNT(*) AS total_orders 
                        FROM `order` GROUP BY MONTH(request_date_time)";
$stmt = $pdo->query($sql_orders_by_month);
$orders_by_month = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = [];
$orders = [];

foreach ($orders_by_category as $category) {
    $categories[] = $category['product_cat'];
    $orders[] = $category['total_orders'];
}

?>


<!doctype html>
<html lang="en">


<!-- Mirrored from themesbrand.com/borex-symfony/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2024 13:43:43 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Horizontal | Borex - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-layout="horizontal" data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar" class="isvertical-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-dark-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark-sm.png" alt="" height="22">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="" height="22">
                            </span>
                            <span class="logo-sm">
                                <img src="assets/images/logo-light-sm.png" alt="" height="22">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn topnav-hamburger">
                        <div class="hamburger-icon open">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <div class="d-none d-sm-block ms-3 align-self-center">
                        <h4 class="page-title">Horizontal</h4>
                    </div>

                </div>

                <div class="d-flex">
                    <div class="dropdown">
                        <button type="button" class="btn header-item"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-sm" data-eva="search-outline"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0">
                            <form class="p-2">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-0" placeholder="Search...">
                                        <i class="search-icon" data-eva="search-outline" data-eva-height="26" data-eva-width="26"></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block language-switch">
                        <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="header-lang-img" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="eng">
                                <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp">
                                <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr">
                                <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it">
                                <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru">
                                <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-sm" data-eva="grid-outline"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-15"> Web Apps </h5>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small fw-semibold text-decoration-underline"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="px-lg-2 pb-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="assets/images/brands/github.png" alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                            <span>Mail Chimp</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="assets/images/brands/slack.png" alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-sm" data-eva="bell-outline"></i>
                            <span class="noti-dot bg-danger rounded-pill">4</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-15"> Notifications </h5>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small fw-semibold text-decoration-underline"> Mark all as read</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 250px;">
                                <a href="#!" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">James Lemire</h6>
                                            <div class="font-size-13 text-muted">
                                                <p class="mb-1">It will seem like simplified English.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hour ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#!" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-sm me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="bx bx-cart"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Your order is placed</h6>
                                            <div class="font-size-13 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#!" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-sm me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="bx bx-badge-check"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Your item is shipped</h6>
                                            <div class="font-size-13 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#!" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Salena Layfield</h6>
                                            <div class="font-size-13 text-muted">
                                                <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hour ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top d-grid">
                                <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                    <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle" id="right-bar-toggle">
                            <i class="icon-sm" data-eva="settings-outline"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="p-3 border-bottom">
                                <h6 class="mb-0">Jennifer Bennett</h6>
                                <p class="mb-0 font-size-11 text-muted">jennifer.bennett@email.com</p>
                            </div>
                            <a class="dropdown-item" href="contacts-profile.html"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                            <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                            <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-wallet text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$6951.02</b></span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Settings</span><span class="badge badge-soft-success ms-auto">New</span></a>
                            <a class="dropdown-item" href="auth-lock-screen.html"><i class="mdi mdi-lock text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                            <a class="dropdown-item" href="auth-logout.html"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-dark-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="22">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="22">
                    </span>
                    <span class="logo-sm">
                        <img src="assets/images/logo-light-sm.png" alt="" height="22">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 header-item vertical-menu-btn topnav-hamburger">
                <div class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <div data-simplebar class="sidebar-menu-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" data-key="t-menu">Menu</li>

                        <li>
                            <a href="javascript: void(0);">
                                <i class="icon nav-icon" data-eva="grid-outline"></i>
                                <span class="menu-item" data-key="t-dashboards">Dashboards</span>
                                <span class="badge rounded-pill bg-primary">3</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="index.html" data-key="t-ecommerce">Ecommerce</a></li>
                                <li><a href="dashboard-saas.html" data-key="t-saas">Saas</a></li>
                                <li><a href="dashboard-crypto.html" data-key="t-crypto">Crypto</a></li>
                            </ul>
                        </li>

                        <li class="menu-title" data-key="t-applications">Applications</li>

                        <li>
                            <a href="apps-calendar.html">
                                <i class="icon nav-icon" data-eva="calendar-outline"></i>
                                <span class="menu-item" data-key="t-calendar">Calendar</span>
                            </a>
                        </li>

                        <li>
                            <a href="apps-chat.html">
                                <i class="icon nav-icon" data-eva="message-circle-outline"></i>
                                <span class="menu-item" data-key="t-chat">Chat</span>
                                <span class="badge rounded-pill badge-soft-danger" data-key="t-hot">Hot</span>
                            </a>
                        </li>

                        <li>
                            <a href="apps-file-manager.html">
                                <i class="icon nav-icon" data-eva="archive-outline"></i>
                                <span class="menu-item" data-key="t-filemanager">File Manager</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="shopping-bag-outline"></i>
                                <span class="menu-item" data-key="t-ecommerce">Ecommerce</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="ecommerce-products.html" data-key="t-products">Products</a></li>
                                <li><a href="ecommerce-product-detail.html" data-key="t-product-detail">Product Detail</a></li>
                                <li><a href="ecommerce-orders.html" data-key="t-orders">Orders</a></li>
                                <li><a href="ecommerce-customers.html" data-key="t-customers">Customers</a></li>
                                <li><a href="ecommerce-cart.html" data-key="t-cart">Cart</a></li>
                                <li><a href="ecommerce-checkout.html" data-key="t-checkout">Checkout</a></li>
                                <li><a href="ecommerce-shops.html" data-key="t-shops">Shops</a></li>
                                <li><a href="ecommerce-add-product.html" data-key="t-add-product">Add Product</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="email-outline"></i>
                                <span class="menu-item" data-key="t-email">Email</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="email-inbox.html" data-key="t-inbox">Inbox</a></li>
                                <li><a href="email-read.html" data-key="t-read-email">Read Email</a></li>
                                <li>
                                    <a href="javascript: void(0);">
                                        <span class="menu-item" data-key="t-email-templates">Templates</span>
                                        <span class="badge rounded-pill badge-soft-success" data-key="t-new">New</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="email-template-basic.html" data-key="t-basic-action">Basic Action</a></li>
                                        <li><a href="email-template-alert.html" data-key="t-alert-email">Alert Email</a></li>
                                        <li><a href="email-template-billing.html" data-key="t-bill-email">Billing Email</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="book-outline"></i>
                                <span class="menu-item" data-key="t-invoices">Invoices</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="invoices-list.html" data-key="t-invoice-list">Invoice List</a></li>
                                <li><a href="invoices-detail.html" data-key="t-invoice-detail">Invoice Detail</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="briefcase-outline"></i>
                                <span class="menu-item" data-key="t-projects">Projects</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="projects-grid.html" data-key="t-p-grid">Projects Grid</a></li>
                                <li><a href="projects-list.html" data-key="t-p-list">Projects List</a></li>
                                <li><a href="projects-create.html" data-key="t-create-new">Create New</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="wifi-outline"></i>
                                <span class="menu-item" data-key="t-contacts">Contacts</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="contacts-grid.html" data-key="t-user-grid">User Grid</a></li>
                                <li><a href="contacts-list.html" data-key="t-user-list">User List</a></li>
                                <li><a href="contacts-profile.html" data-key="t-user-profile">Profile</a></li>
                            </ul>
                        </li>

                        <li class="menu-title" data-key="t-layouts">Layouts</li>

                        <li>
                            <a href="layouts-horizontal.html">
                                <i class="icon nav-icon" data-eva="browser-outline"></i>
                                <span class="menu-item" data-key="t-horizontal">Horizontal</span>
                            </a>
                        </li>

                        <li class="menu-title" data-key="t-pages">Pages</li>

                        <li>
                            <a href="javascript: void(0);">
                                <i class="icon nav-icon" data-eva="person-done-outline"></i>
                                <span class="menu-item" data-key="t-authentication">Authentication</span>
                                <span class="badge rounded-pill bg-info">8</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                            <li><a href="logout.php" data-key="t-logout">Logout</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="cube-outline"></i>
                                <span class="menu-item" data-key="t-utility">Utility</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="pages-starter.html" data-key="t-starter-page">Starter Page</a></li>
                                <li><a href="pages-maintenance.html" data-key="t-maintenance">Maintenance</a></li>
                                <li><a href="pages-comingsoon.html" data-key="t-coming-soon">Coming Soon</a></li>
                                <li><a href="pages-timeline.html" data-key="t-timeline">Timeline</a></li>
                                <li><a href="pages-faqs.html" data-key="t-faqs">FAQs</a></li>
                                <li><a href="pages-pricing.html" data-key="t-pricing">Pricing</a></li>
                                <li><a href="pages-404.html" data-key="t-error-404">Error 404</a></li>
                                <li><a href="pages-500.html" data-key="t-error-500">Error 500</a></li>
                            </ul>
                        </li>

                        <li class="menu-title" data-key="t-components">Components</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="layers-outline"></i>
                                <span class="menu-item" data-key="t-ui-elements">UI Elements</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="ui-alerts.html" data-key="t-alerts">Alerts</a></li>
                                <li><a href="ui-buttons.html" data-key="t-buttons">Buttons</a></li>
                                <li><a href="ui-cards.html" data-key="t-cards">Cards</a></li>
                                <li><a href="ui-carousel.html" data-key="t-carousel">Carousel</a></li>
                                <li><a href="ui-dropdowns.html" data-key="t-dropdowns">Dropdowns</a></li>
                                <li><a href="ui-grid.html" data-key="t-grid">Grid</a></li>
                                <li><a href="ui-images.html" data-key="t-images">Images</a></li>
                                <li><a href="ui-lightbox.html" data-key="t-lightbox">Lightbox</a></li>
                                <li><a href="ui-modals.html" data-key="t-modals">Modals</a></li>
                                <li><a href="ui-offcanvas.html" data-key="t-offcanvas">Offcanvas</a></li>
                                <li><a href="ui-rangeslider.html" data-key="t-range-slider">Range Slider</a></li>
                                <li><a href="ui-progressbars.html" data-key="t-progress-bars">Progress Bars</a></li>
                                <li><a href="ui-sweet-alert.html" data-key="t-sweet-alert">Sweet-Alert</a></li>
                                <li><a href="ui-tabs-accordions.html" data-key="t-tabs-accordions">Tabs & Accordions</a></li>
                                <li><a href="ui-typography.html" data-key="t-typography">Typography</a></li>
                                <li><a href="ui-video.html" data-key="t-video">Video</a></li>
                                <li><a href="ui-general.html" data-key="t-general">General</a></li>
                                <li><a href="ui-colors.html" data-key="t-colors">Colors</a></li>
                                <li><a href="ui-rating.html" data-key="t-rating">Rating</a></li>
                                <li><a href="ui-notifications.html" data-key="t-notifications">Notifications</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="edit-2-outline"></i>
                                <span class="menu-item" data-key="t-forms">Forms</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="form-elements.html" data-key="t-form-elements">Form Elements</a></li>
                                <li><a href="form-layouts.html" data-key="t-form-layouts">Form Layouts</a></li>
                                <li><a href="form-validation.html" data-key="t-form-validation">Form Validation</a></li>
                                <li><a href="form-advanced.html" data-key="t-form-advanced">Form Advanced</a></li>
                                <li><a href="form-editors.html" data-key="t-form-editors">Form Editors</a></li>
                                <li><a href="form-uploads.html" data-key="t-form-upload">Form File Upload</a></li>
                                <li><a href="form-wizard.html" data-key="t-form-wizard">Form Wizard</a></li>
                                <li><a href="form-mask.html" data-key="t-form-mask">Form Mask</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="list"></i>
                                <span class="menu-item" data-key="t-tables">Tables</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="tables-basic.html" data-key="t-basic-tables">Basic Tables</a></li>
                                <li><a href="tables-advanced.html" data-key="t-advanced-tables">Advance Tables</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="pie-chart-outline"></i>
                                <span class="menu-item" data-key="t-charts">Charts</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="javascript: void(0);" class="has-arrow" data-key="t-apex-charts">Apex Charts</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="charts-line.html" data-key="t-line">Line</a></li>
                                        <li><a href="charts-area.html" data-key="t-area">Area</a></li>
                                        <li><a href="charts-column.html" data-key="t-column">Column</a></li>
                                        <li><a href="charts-bar.html" data-key="t-bar">Bar</a></li>
                                        <li><a href="charts-mixed.html" data-key="t-mixed">Mixed</a></li>
                                        <li><a href="charts-timeline.html" data-key="t-timeline">Timeline</a></li>
                                        <li><a href="charts-candlestick.html" data-key="t-candlestick">Candlestick</a></li>
                                        <li><a href="charts-boxplot.html" data-key="t-boxplot">Boxplot</a></li>
                                        <li><a href="charts-bubble.html" data-key="t-bubble">Bubble</a></li>
                                        <li><a href="charts-scatter.html" data-key="t-scatter">Scatter</a></li>
                                        <li><a href="charts-heatmap.html" data-key="t-heatmap">Heatmap</a></li>
                                        <li><a href="charts-treemap.html" data-key="t-treemap">Treemap</a></li>
                                        <li><a href="charts-pie.html" data-key="t-pie">Pie</a></li>
                                        <li><a href="charts-radialbar.html" data-key="t-radialbar">Radialbar</a></li>
                                        <li><a href="charts-radar.html" data-key="t-radar">Radar</a></li>
                                        <li><a href="charts-polararea.html" data-key="t-polararea">Polararea</a></li>
                                    </ul>
                                </li>
                                <li><a href="charts-echart.html" data-key="t-e-charts">E Charts</a></li>
                                <li><a href="charts-chartjs.html" data-key="t-chartjs-charts">Chartjs Charts</a></li>
                                <li><a href="charts-tui.html" data-key="t-ui-charts">Toast UI Charts</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="smiling-face-outline"></i>
                                <span class="menu-item" data-key="t-icons">Icons</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="icons-evaicons.html" data-key="t-evaicons">Eva Icons</a></li>
                                <li><a href="icons-boxicons.html" data-key="t-boxicons">Boxicons</a></li>
                                <li><a href="icons-materialdesign.html" data-key="t-material-design">Material Design</a></li>
                                <li><a href="icons-fontawesome.html" data-key="t-font-awesome">Font Awesome 5</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="pin-outline"></i>
                                <span class="menu-item" data-key="t-maps">Maps</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="maps-google.html" data-key="t-google">Google</a></li>
                                <li><a href="maps-vector.html" data-key="t-vector">Vector</a></li>
                                <li><a href="maps-leaflet.html" data-key="t-leaflet">Leaflet</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="icon nav-icon" data-eva="share-outline"></i>
                                <span class="menu-item" data-key="t-multi-level">Multi Level</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);" data-key="t-level-1.1">Level 1.1</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow" data-key="t-level-1.2">Level 1.2</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);" data-key="t-level-2.1">Level 2.1</a></li>
                                        <li><a href="javascript: void(0);" data-key="t-level-2.2">Level 2.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->

                <div class="p-3 px-4 sidebar-footer">
                    <p class="mb-1 main-title">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> &copy; Borex.
                    </p>
                    <p class="mb-0">Design & Develop by Themesbrand</p>
                </div>
            </div>
        </div>
        <!-- Left Sidebar End -->
        <header id="page-topbar" class="ishorizontal-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-dark-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="" height="22">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-light-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="" height="22">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-block ms-2 align-self-center">
                        <h4 class="page-title">Horizontal</h4>
                    </div>
                </div>

                <div class="d-flex">


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="p-3 border-bottom">
                                <h6 class="mb-0">Jennifer Bennett</h6>
                                <p class="mb-0 font-size-11 text-muted">jennifer.bennett@email.com</p>
                            </div>

                            <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="topnav">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="dashboard.php" id="topnav-dashboard" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon nav-icon" data-eva="grid-outline"></i>
                                        <span data-key="t-dashboards">Dashboards</span>
                                        <div class="arrow-down"></div>
                                    </a>

                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="table.php" id="topnav-dashboard" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon nav-icon" data-eva="grid-outline"></i>
                                        <span data-key="t-dashboards">Table</span>
                                        <div class="arrow-down"></div>
                                    </a>

                                </li>



                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                    <i data-eva="pie-chart-2" class="fill-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Total Orders</p>
                                            <h4 class="mb-0"><?php echo $total_orders; ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end ms-2">
                                            <div class="badge rounded-pill font-size-13 badge-soft-success"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                    <i data-eva="shopping-bag" class="fill-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Average Order Value</p>
                                            <h4 class="mb-0"><?php echo number_format($avg_order_value, 2); ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end ms-2">
                                            <div class="badge rounded-pill font-size-13 badge-soft-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                    <i data-eva="people" class="fill-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Total Revenue</p>
                                            <h4 class="mb-0"><?php echo number_format($total_revenue, 2); ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end ms-2">
                                            <div class="badge rounded-pill font-size-13 badge-soft-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                    <i data-eva="pie-chart-2" class="fill-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Total Orders Valid</p>
                                            <h4 class="mb-0"><?php echo $total_orders_valid; ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end ms-2">
                                            <div class="badge rounded-pill font-size-13 badge-soft-success"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                    <i data-eva="shopping-bag" class="fill-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Total Orders Impaye</p>
                                            <h4 class="mb-0"><?php echo $total_orders_Impaye; ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end ms-2">
                                            <div class="badge rounded-pill font-size-13 badge-soft-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                    <i data-eva="people" class="fill-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Total Customers</p>
                                            <h4 class="mb-0"><?php echo $total_persons; ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end ms-2">
                                            <div class="badge rounded-pill font-size-13 badge-soft-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-3">Orders by Month</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-eva="more-horizontal-outline" class="fill-muted" data-eva-height="18" data-eva-width="18"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Yearly</a>
                                                    <a class="dropdown-item" href="#">Monthly</a>
                                                    <a class="dropdown-item" href="#">Weekly</a>
                                                    <a class="dropdown-item" href="#">Today</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="align-middle">Order ID</th>
                                                    <th class="align-middle">Month</th>
                                                    <th class="align-middle">Total Orders</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders_by_month as $month): ?>
                                                    <tr>
                                                        <td><?php echo $month['month']; ?></td>
                                                        <td><?php echo date('F', mktime(0, 0, 0, $month['month'], 10)); ?></td>
                                                        <td><?php echo $month['total_orders']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-3">Orders by Category</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Monthly<i class="mdi mdi-chevron-down ms-1"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Yearly</a>
                                                    <a class="dropdown-item" href="#">Monthly</a>
                                                    <a class="dropdown-item" href="#">Weekly</a>
                                                    <a class="dropdown-item" href="#">Today</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mx-n4" data-simplebar style="max-height: 350px;">
                                    <canvas id="categoryDoughnutChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <script>document.write(new Date().getFullYear())</script> &copy; Borex. Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </footer>
</div>

        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center bg-dark p-3">

                <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

                <a href="javascript:void(0);" class="right-bar-toggle-close ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="m-0" />

            <div class="p-4">
                <h6 class="mb-3">Layout</h6>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout"
                        id="layout-vertical" value="vertical">
                    <label class="form-check-label" for="layout-vertical">Vertical</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout"
                        id="layout-horizontal" value="horizontal">
                    <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                </div>

                <h6 class="mt-4 mb-3">Layout Mode</h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-mode"
                        id="layout-mode-light" value="light">
                    <label class="form-check-label" for="layout-mode-light">Light</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-mode"
                        id="layout-mode-dark" value="dark">
                    <label class="form-check-label" for="layout-mode-dark">Dark</label>
                </div>

                <h6 class="mt-4 mb-3">Layout Width</h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-width"
                        id="layout-width-fluid" value="fluid" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                    <label class="form-check-label" for="layout-width-fluid">Fluid</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-width"
                        id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                    <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                </div>

                <h6 class="mt-4 mb-3">Layout Position</h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-position"
                        id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                    <label class="form-check-label" for="layout-position-fixed">Fixed</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-position"
                        id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                    <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
                </div>

                <h6 class="mt-4 mb-3">Topbar Color</h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="topbar-color"
                        id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                    <label class="form-check-label" for="topbar-color-light">Light</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="topbar-color"
                        id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                    <label class="form-check-label" for="topbar-color-dark">Dark</label>
                </div>

                <div id="sidebar-setting">
                    <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Size</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                        <label class="form-check-label" for="sidebar-size-default">Default</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                        <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                        <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                    </div>

                    <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Color</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                        <label class="form-check-label" for="sidebar-color-light">Light</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                        <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>
                </div>

                <h6 class="mt-4 mb-3">Direction</h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-direction"
                        id="layout-direction-ltr" value="ltr">
                    <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="layout-direction"
                        id="layout-direction-rtl" value="rtl">
                    <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                </div>

            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- chat offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasActivity" aria-labelledby="offcanvasActivityLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasActivityLabel">Offcanvas right</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            ...
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenujs/metismenujs.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/eva-icons/eva.min.js"></script>

    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    var categoryNames = <?php echo json_encode($categories); ?>;
    var orderCounts = <?php echo json_encode($orders); ?>;

    var ctx = document.getElementById('categoryDoughnutChart').getContext('2d');
    var categoryDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: categoryNames,
            datasets: [{
                data: orderCounts,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>


</body>


<!-- Mirrored from themesbrand.com/borex-symfony/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2024 13:44:27 GMT -->

</html>