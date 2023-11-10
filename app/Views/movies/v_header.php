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
    <link href="<?= base_url(); ?>/assets/css/global.css" rel="stylesheet">
    <!-- style.css -->
    <!-- datatables -->
    <link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.15.2/skins/default/aliplayer-min.css" />
    <script charset="utf-8" type="text/javascript" src="https://g.alicdn.com/de/prismplayer/2.15.2/aliplayer-min.js"></script>
    <script src="<?= base_url(); ?>/assets/jquery-3.6.1/jquery-3.6.1.min.js"></script>


</head>

<body>
    <div class="loader-container">
        <div class="loader"></div>
        <div class="loader-text">載入中...</div>
    </div>
    <div id="content">
        <header class="main-header">
            <h1 class="logo mt-4">
                电影中心
                <nav class="navigation">
                    <ul>
                        <li class="active"><a href="<?= site_url('home') ?>">主页</a></li>
                        <?php foreach ($category as $item) : ?>
                            <div class="dropdown">
                                <li><a href="#"><?php echo $item['type_name'] ?></a></li>
                                <div class="dropdown-content">
                                    <?php foreach ($item['child'] as $sub_category) : ?>
                                        <a href="<?= site_url('home?id=' . $sub_category['type_id']) ?>"><?php echo $sub_category['type_name'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <div>
                <form action="<?= site_url('home'); ?>" method="get" class="search-container">
                    <input type="text" id="search-bar" name="search" placeholder="搜索您最喜欢的电影">
                    <a href="#"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a>
                </form>
                </div>
        </header>
        <main>
            <div id="carousel">

                <div class="hideLeft">
                    <img src="https://i1.sndcdn.com/artworks-000165384395-rhrjdn-t500x500.jpg">
                </div>

                <div class="prevLeftSecond">
                    <img src="https://i1.sndcdn.com/artworks-000185743981-tuesoj-t500x500.jpg">
                </div>

                <div class="prev">
                    <img src="https://i1.sndcdn.com/artworks-000158708482-k160g1-t500x500.jpg">
                </div>

                <div class="selected">
                    <img src="https://i1.sndcdn.com/artworks-000062423439-lf7ll2-t500x500.jpg">
                </div>

                <div class="next">
                    <img src="https://i1.sndcdn.com/artworks-000028787381-1vad7y-t500x500.jpg">
                </div>

                <div class="nextRightSecond">
                    <img src="https://i1.sndcdn.com/artworks-000108468163-dp0b6y-t500x500.jpg">
                </div>

                <div class="hideRight">
                    <img src="https://i1.sndcdn.com/artworks-000064920701-xrez5z-t500x500.jpg">
                </div>

            </div>

            <!-- <div class="buttons">
        <a id="prev"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-1 h-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
            </svg>
        </a>
        <a id="next"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-1 h-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
            </svg>
        </a>

    </div> -->



        </main>
        <div class="container mt-4">
            <?php foreach ($ads as $item) : ?>
                <div class="mt-2">
                    <a href="<?php echo $item['link'] ?>" target="_blank"><img src="<?= base_url('uploads/' . $item['images']); ?>" height="100px" alt="u911" style="width:100%;border-radius: 10px;margin-top:2px;"></a>
                </div>
            <?php endforeach; ?>
        </div>


        <script>
            $(document).ready(function() {
                // Simulate a delay (you can replace this with your actual page load logic)
                setTimeout(function() {
                    // Hide the loader
                    $('.loader-container').fadeOut('slow', function() {
                        // Show the content
                        $('#content').fadeIn('slow');
                    });
                }, 2000); // Replace 2000 with the desired delay in milliseconds
            });


            function moveToSelected(element) {

                if (element == "next") {
                    var selected = $(".selected").next();
                } else if (element == "prev") {
                    var selected = $(".selected").prev();
                } else {
                    var selected = element;
                }

                var next = $(selected).next();
                var prev = $(selected).prev();
                var prevSecond = $(prev).prev();
                var nextSecond = $(next).next();

                $(selected).removeClass().addClass("selected");

                $(prev).removeClass().addClass("prev");
                $(next).removeClass().addClass("next");

                $(nextSecond).removeClass().addClass("nextRightSecond");
                $(prevSecond).removeClass().addClass("prevLeftSecond");

                $(nextSecond).nextAll().removeClass().addClass('hideRight');
                $(prevSecond).prevAll().removeClass().addClass('hideLeft');

            }

            // Eventos teclado
            $(document).keydown(function(e) {
                switch (e.which) {
                    case 37: // left
                        moveToSelected('prev');
                        break;

                    case 39: // right
                        moveToSelected('next');
                        break;

                    default:
                        return;
                }
                e.preventDefault();
            });

            $('#carousel div').click(function() {
                moveToSelected($(this));
            });

            $('#prev').click(function() {
                moveToSelected('prev');
            });

            $('#next').click(function() {
                moveToSelected('next');
            });
        </script>