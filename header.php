<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>হোম | কাউনিয়া বালিকা ফাজিল (ডিগ্রি) মডেল মাদ্রাসা</title>
<?php wp_head(); ?>

</head>
<body>

  <!-- header -->

  <header>
<!-- TOPBAR -->
<div class="topbar">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">

        <div class="d-flex flex-wrap gap-3">

            <strong>
                Madrasah Code:
                <?php echo esc_html(get_theme_mod('rs_madrasah_code')); ?>
            </strong>

            <span>
                EIIN:
                <?php echo esc_html(get_theme_mod('rs_eiin')); ?>
            </span>

        </div>

        <div class="d-flex align-items-center gap-3">

            <?php if(get_theme_mod('rs_show_clock', true)) : ?>

                <span>
                    <i class="bi bi-clock"></i>
                    <span id="liveClock"></span>
                </span>

            <?php endif; ?>

            <div class="dropdown">

                <button class="dropdown-toggle" data-bs-toggle="dropdown">
                    <?php echo esc_html(get_theme_mod('rs_apply_button_text')); ?>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="<?php echo esc_url(get_theme_mod('rs_apply1_url')); ?>">
                            <?php echo esc_html(get_theme_mod('rs_apply1_text')); ?>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="<?php echo esc_url(get_theme_mod('rs_apply2_url')); ?>">
                            <?php echo esc_html(get_theme_mod('rs_apply2_text')); ?>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="<?php echo esc_url(get_theme_mod('rs_apply3_url')); ?>">
                            <?php echo esc_html(get_theme_mod('rs_apply3_text')); ?>
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </div>
</div>

<!-- HEADER -->
<?php
$logo   = wp_get_attachment_image_url(get_theme_mod('rs_header_logo'),'full');
$banner = wp_get_attachment_image_url(get_theme_mod('rs_header_banner'),'full');
?>

<div class="site-header">
    <div class="container d-flex align-items-center justify-content-between gap-3 flex-wrap">

        <div class="d-flex align-items-center gap-3">

            <?php if($logo): ?>
                 <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url($logo); ?>" class="logo-img" alt="<?php bloginfo('name'); ?>">
                 </a>
            <?php endif; ?>

            <div>
                <div class="title-ar-top">
                    <?php echo esc_html(get_theme_mod('rs_header_arabic')); ?>
                </div>

                <div class="title-bn">
                    <?php echo esc_html(get_theme_mod('rs_header_bangla')); ?>
                </div>

                <div class="title-en">
                    <?php echo esc_html(get_theme_mod('rs_header_english')); ?>
                </div>
            </div>

        </div>

        <?php if($banner): ?>

            <img
                src="<?php echo esc_url($banner); ?>"
                class="header-side-banner d-none d-md-block"
                alt="Header Banner">

        <?php endif; ?>

    </div>
</div>


<nav class="navbar navbar-expand-lg navbar-main">

    <div class="container">

        <button class="navbar-toggler bg-light my-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#nav1">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="nav1">

            <?php

            wp_nav_menu(array(

                'theme_location' => 'Primary',

                'container'      => false,

                'depth'          => 2,

         

            ));

            ?>

        </div>

    </div>

</nav>

</header>