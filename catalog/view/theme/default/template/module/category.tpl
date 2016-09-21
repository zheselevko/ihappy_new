<div id="cmpro-1" class="box">
<div class="box-heading">Категории</div>
<div class="box-content">
<ul class="cmpro-collapsible ">
  <?php foreach ($categories as $category) { ?>

  <li class="cid-<?php echo $category_id;?>">
  <div> <a href="<?php echo $category['href']; ?>" class="list-group-item active"><span><?php echo $category['name']; ?></span></a>
</div></li>
  <?php if ($category['children']) { ?>
  <ul>
  <?php foreach ($category['children'] as $child) { ?>
  <?php if ($child['category_id'] == $child_id) { ?>
    <li class="cid-<?php echo $category['category_id'];?>"><a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a></li>
  <?php } else { ?>
  <li><a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a></li>
  <?php } ?>
  <?php } ?>
</ul>
  <?php } ?> 
   <?php if (($child['children2'])) { ?>
              <?php foreach ($child['children2'] as $child2) { ?>
              <?php if ($child2['category_id'] == $child_id2) { ?>
              <a href="<?php echo $child2['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child2['name']; ?></a>
              <?php } else { ?>
              <a href="<?php echo $child2['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child2['name']; ?></a>
              <?php } ?>
                <?php if (($child2['children3']) ) { ?>
                    <?php foreach ($child2['children3'] as $child3) { ?>
                    <?php if ($child3['category_id'] == $child_id3) { ?>
                    <a href="<?php echo $child3['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php echo $child3['name']; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $child3['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php echo $child3['name']; ?></a>
                    <?php } ?>
                    <?php } ?>
                 <?php } ?>
              <?php } ?>
           <?php } ?>
  <?php } ?>
  </ul>
</div>
</div>
