<h2 class="col-xs-12"><?php echo $category->name ?></h2>
<?php // var_dump($category) ?>
<?php foreach($products as $product): ?>
    <?php var_dump($product); die; ?>
    <?php // wc_get_template_part('taxonomy', 'product_list-diving'); ?>
<?php endforeach; ?>
