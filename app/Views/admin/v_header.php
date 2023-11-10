<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pagetitle; ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url(); ?>/assets/bootstrap-5.2.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>/assets/bootstrap-icons-1.10.2/bootstrap-icons.css" rel="stylesheet">
    <!-- JQuery Confirm -->
    <link href="<?= base_url(); ?>/assets/jquery-confirm-v3.3.4/css/jquery-confirm.css" rel="stylesheet">
    <!-- datatables -->
    <link href="<?= base_url(); ?>/assets/DataTables/datatables.min.css" rel="stylesheet">
    <!-- base css -->
    <link href="<?= base_url(); ?>/assets/css/base.css" rel="stylesheet">

    <link href="<?= base_url(); ?>/assets/css/color.css" rel="stylesheet">
    <!-- style.css -->
    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet">
    <!-- Custom Loaded CSS -->

    <?php foreach ($css as $row) : ?>
        <link href="<?= base_url(); ?><?= $row ?>" rel="stylesheet">
    <?php endforeach ?>
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><?php echo getenv('appName'); ?></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="w-100 text-light text-nowrap px-3 py-2" style="overflow-x:hidden; text-overflow:ellipsis;">User: <?php echo $_SESSION['username']; ?> </div>
        <div class="w-100 text-light text-nowrap px-3 py-2" style="overflow-x:hidden; text-overflow:ellipsis;">Date: <?php echo date('M d, Y', time()); ?> &emsp;|&emsp; Server: <?php echo $_SERVER['SERVER_SOFTWARE']; ?> &emsp;|&emsp; Php: <?php echo phpversion(); ?> &emsp;|&emsp; Mysqli Client: <?php echo mysqli_get_client_version(); ?></div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="mt-2 col-md-3 col-lg-2 d-md-block  sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="list-unstyled ps-0">

                        <li>
                            <button class="btn btn-toggle align-items-center collapsed mb-2" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                                <i class="icons bi bi-person-vcard"></i>
                                帐户 / Account
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="sidebar_r btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="/dashboard" data-toggle="tooltip" title="操控界面 / Dashboard" class="sbnav"><i class="subicons bi-house-fill"></i> 操控界面 / Dashboard</a></li>
                                    <li><a href="/myprofile" data-toggle="tooltip" title="My Profile" class="sbnav"><i class="subicons bi-tools"></i> 我的资料 / My Profile</a></li>
                                </ul>
                            </div>
                        </li>
                        <?php
                        $permission_set = session()->get('permission_set');
                        ?>

                        <?php if ( in_array("UrlController/index", $permission_set) || in_array("UserManagement/index", $permission_set) || in_array("PermissionManagement/index", $permission_set) || in_array("RoleManagement/index", $permission_set) || in_array("SysConfig/index", $permission_set)) : ?>
                            <li>
                                <button class="btn btn-toggle align-items-center collapsed mb-2" data-bs-toggle="collapse" data-bs-target="#admin-collapse" aria-expanded="false">
                                    <i class="icons bi bi-person-circle"></i>
                                    行政管理 / Administration
                                </button>
                                <div class="collapse" id="admin-collapse">
                                    <ul class="sidebar_r btn-toggle-nav list-unstyled fw-normal pb-1 small">

                                        <?php if (in_array("UserManagement/index", $permission_set)) : ?>
                                            <li><a href="/usermanagement" data-toggle="tooltip" title="用户管理 / User Management" class="sbnav"><i class="subicons bi-person-fill-gear"></i> 用户管理 / User Management</a></li>
                                        <?php endif; ?>

                                        <?php if (in_array("PermissionManagement/index", $permission_set)) : ?>
                                            <li><a href="/permissionmanagement" data-toggle="tooltip" title="权限管理 / Permission Management" class="sbnav"><i class="subicons bi-person-fill-lock"></i> 权限管理 / Permission Management</a></li>
                                        <?php endif; ?>

                                        <?php if (in_array("RoleManagement/index", $permission_set)) : ?>
                                            <li><a href="/rolemanagement" data-toggle="tooltip" title="角色管理 / Role Management" class="sbnav"><i class="subicons bi-person-lines-fill"></i> 角色管理 / Role Management</a></li>
                                        <?php endif; ?>

                                        <?php if (in_array("SysConfig/index", $permission_set)) : ?>
                                            <li><a href="/sysconfig" data-toggle="tooltip" title="系统配置 / System Configuration" class="sbnav"><i class="subicons bi-gear-fill"></i> 系统配置 / System Configuration</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array("UrlController/index", $permission_set)) : ?>
                            <li>
                                <button class="btn btn-toggle align-items-center collapsed mb-2" data-bs-toggle="collapse" data-bs-target="#message-collapse" aria-expanded="false">
                                 <i class="subicons bi bi-film"></i>
                                    電影 /Movies
                                </button>

                                <div class="collapse" id="message-collapse">
                                    <ul class="sidebar_r btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <?php if (in_array("UrlController/index", $permission_set)) : ?>
                                            <li><a href="/admin/home" data-toggle="tooltip" title="发送信息 /Send Messages" class="sbnav"><i class="subicons bi bi-link"></i>關聯 /Url</a></li>
                                        <?php endif; ?>
                                    </ul>
                                    <ul class="sidebar_r btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <?php if (in_array("UrlController/index", $permission_set)) : ?>
                                            <li><a href="/admin/ads" data-toggle="tooltip" title="ads" class="sbnav"><i class="subicons bi bi-image"></i>廣告 / Ads </a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("TeleAdmin/index", $permission_set) || in_array("TeleAgent/index", $permission_set)) : ?>
                            <li>
                                <button class="btn btn-toggle align-items-center mb-2 collapsed" data-bs-toggle="collapse" data-bs-target="#telemarketing-collapse" aria-expanded="false">
                                    <i class="icons bi bi-person-video3"></i>
                                    电话营销 / Telemarketing
                                </button>
                                <div class="collapse" id="telemarketing-collapse">
                                    <ul class="sidebar_r btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <?php if (in_array("TeleAdmin/index", $permission_set)) : ?>
                                            <li><a href="/teleadmin" data-toggle="tooltip" title="营销管理 / Marketing Admin" class="sbnav"><i class="subicons bi-gear-fill"></i> 营销管理 / Marketing Admin</a></li>
                                        <?php endif; ?>

                                        <?php if (in_array("TeleReports/index", $permission_set)) : ?>
                                            <li><a href="/telereports" data-toggle="tooltip" title="营销报告 / Marketing Reports" class="sbnav"><i class="subicons bi-filetype-csv"></i> 营销报告 / Marketing Reports</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>


                    </ul>
                    <!-- <ul class="btn-toggle-nav logout fw-normal pb-1 small">
                        <li><a href="/logout" data-toggle="tooltip" title="登出 / Sign Out" class=""><i class="icons bi-power"></i> 登出 / Sign Out</a></li>
                    </ul> -->
                    <div class="logout bg-danger mt-5"><a href="/logout" data-toggle="tooltip" title="登出 / Sign Out" class=""><i class="icons bi-power"></i> 登出 / Sign Out</a></div>
                </div>
            </nav>
            <!-- end header -->