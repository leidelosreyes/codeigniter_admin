<div class="container">
    <table class="table-responsive">
        <thead>
            <tr>
                <th scope="col">视频名称</th>
                <th scope="col">视频类别</th>
                <th scope="col">更新时间</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data['list']) > 0) : ?>
                <?php foreach ($data['list'] as $item) : ?>
                    <tr>
                        <td>
                            <a href="<?= site_url('movie/show/' . $item['vod_id']) ?>">
                                <?php echo $item['vod_name']; ?>
                            </a>
                            <span style="color: red;"><?php echo $item['vod_remarks']; ?></span>
                        </td>
                        <td><?php echo $item['type_name']; ?></td>
                        <td style="color: red;"><?php echo $item['vod_time']; ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <!-- Handle the case when the list is empty -->
                <tr>
                    <td colspan="3" style="text-align: center;">未找到任何項目</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
    <?= $pager_links ?>
</div>