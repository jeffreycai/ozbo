<div class="container">

<ol class="breadcrumb">
  <?php $i = 0; ?>
  <?php foreach ($items as $name => $url): $i++ ?> 
    <?php if ($i != sizeof($items)): ?>
      <li><a href="<?php echo $url ?>"><?php echo $name ?></a>
    <?php else: ?>
      <li class="active"><?php echo $name ?></li>
    <?php endif; ?>
  <?php endforeach; ?>
</ol>
  
</div>