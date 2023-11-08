<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <?php foreach ($data['list'] as $item) : ?>
                    <div class="col-md-2">
                             <?php
                            if (!empty($item['vod_pic'])) {
                                echo '<img src="' . $item['vod_pic'] . '" class="img-fluid" alt="Product Image">';
                            } else {
                                echo '<img src="' . base_url() . '/assets/images/no_image.jpg" class="img-fluid" alt="Default Image">';
                            }
                                ?>
                    </div>
                    <div class="col-md-9">
                        <h1><?php echo $item['vod_name']; ?></h1>
                        <span>主演:</span>
                        <p><?php echo $item['vod_actor']; ?></p>
                        <div class="row">
                            <div class="col">
                                <div class="d-flex">
                                    <span>地位:</span>
                                    <p style="color:red;"><?php echo $item['vod_remarks']; ?></p>
                                </div>

                            </div>
                            <div class="col">
                                <div class="d-flex">
                                    <span>时间:</span>
                                    <p style="color:red;"><?php echo $item['vod_time']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <span>导演:</span>
                            <p> <?php echo $item['vod_director']; ?></p>
                        </div>
                        <div class="row">
                            <div class="col"><span>类型: </span> <?php echo $item['type_name']; ?></div>
                            <div class="col"><span>地区: </span> <?php echo $item['vod_area']; ?></div>
                            <div class="col"><span>年: </span> <?php echo $item['vod_year']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><span>语言: </span> <?php echo $item['vod_lang']; ?></div>
                            <div class="col"><span>集数: </span> </div>
                            <div class="col"><span>期间: </span></div>
                        </div>

                    </div>

            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
        概要
        </div>
        <div class="card-body">
            <?php echo $item['vod_content'] ?>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
        视频链接
        </div>
        <div class="card-body">
            <div class="card">
                <ul class="list-group list-group-flush">
                <?php $counter = 0; ?>
                    <?php foreach ($video_urls as $play) : ?>
                        <?php if ($counter < 10): ?>
                        <?php list($code, $url) = explode('$', $play); ?>
                        <li class="list-group-item">
                            <a class="play" data="<?php echo $url ?>" vod_id="<?php echo $item['vod_id'] ?>">  <?php echo $play ?> </a>
                        </li>
                        <?php endif; ?>
                        <?php $counter++; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>


<script>
    $(".play").click(function() {
        $.ajax({

            url: '<?php echo base_url('movie/play2') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                data: $(this).attr('data'),
                id:$(this).attr('vod_id')
            },
            success: function(response) {
                // This code will run if the request succeeds.
               window.location.href = "<?= site_url('movie/play/') ?>"+response.id;
                // Perform actions with the response data.
            },
            error: function(xhr, status, error) {
                // This code will run if the request fails.
                console.log('Error:', xhr.status, error);
                // Handle errors here (display error messages, etc.).
            }

        });

    });
</script>