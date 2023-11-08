
<div class="container">
<form action="<?= site_url('home'); ?>" method="get" class="search-container">
    <input type="text" id="search-bar" name="search" placeholder="搜索您最喜欢的电影">
    <a href="#"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a>
  </form>
<table class="table-responsive">
<thead>
    <tr>
    <th scope="col">视频名称</th>
    <th scope="col">视频类别</th>
    <th scope="col">更新时间</th>
    </tr>
</thead>
<tbody>
<?php foreach ($data['list'] as $item): ?>
    <tr>
    <td><a href="<?= site_url('movie/show/'.$item['vod_id']) ?>"><?php echo $item['vod_name']; ?></a> <span style="color: red;"><?php echo $item['vod_remarks']; ?>;</span></td>
    <td><?php echo $item['type_name']; ?></td>
    <td style="color:red;"><?php echo $item['vod_time']; ?></td>
    </tr>
<?php endforeach ?>
</tbody>
</table>
<?= $pager_links ?>
</div>