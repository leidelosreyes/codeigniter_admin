<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div id="J_prismPlayer" style="width: 100%; height: 700px;"></div>
            <?php foreach ($data['list'] as $item) : ?>
                <h2 class="mt-2"><?php echo $item['vod_name']; ?></h2>
                <div class="row mt-4">
                    <div class="col"><span>类型: </span> <?php echo $item['type_name']; ?></div>
                    <div class="col"><span>地区: </span> <?php echo $item['vod_area']; ?></div>
                    <div class="col"><span>年: </span> <?php echo $item['vod_year']; ?></div>
                </div>
            <?php endforeach ?>
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
</div>
<script>
    var player = new Aliplayer({
        id: 'J_prismPlayer',
        width: '100%',
        source: '<?php echo $url?>', // The playback URL of an audio or video file stored in a third-party VOD service or in ApsaraVideo VOD. 
    }, function(player) {
        console.log('The player is created.')
    });

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