<?php 
$start_entry = ($current_page - 1)*$settings['movie']['backend_per_page'] + 1;
$end_entry = min(array($total, $current_page*$settings['movie']['backend_per_page']));
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array('en' => 'Movie', 'zh' => '电影')); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array('en' => 'Movie list', 'zh' => '电影列表')) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr role="row">
        <th>ID</th>
        <th><?php i18n_echo(array('en' => 'STitle', 'zh' => '搜索标题')) ?></th>
        <th><?php i18n_echo(array('en' => 'Released', 'zh' => '上映时间')) ?></th>
        <th><?php i18n_echo(array('en' => 'Updated', 'zh' => '更新时间')) ?></th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($movies as $movie): ?>
    <tr>
      <td><?php echo $movie->getId(); ?></td>
      <td><?php echo $movie->getSearchTitle() ?></td>
      <td><?php echo $movie->getReleased() ? $movie->getReleased('Y/m/d') : 'N/A'; ?></td>
      <td><?php echo $movie->getUpdatedAt('Y-m-d H:i:s'); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="row">
  <div class="col-sm-12" style="text-align: right;">
  <?php i18n_echo(array(
      'en' => 'Showing ' . $start_entry . ' to ' . $end_entry . ' of ' . $total . ' entries', 
      'zh' => '显示' . $start_entry . '到' . $end_entry . '条记录，共' . $total . '条记录',
  )); ?>
  </div>
  <div class="col-sm-12" style="text-align: right;">
  <?php echo $pager; ?>
  </div>
</div>
          
        </div>
      </div>
    </div>
  </div>
</div>