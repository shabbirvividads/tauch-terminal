<div>
    <h2><?php esc_html_e('Tauch Terminal Tulamben' , 'tauch-terminal');?></h2>
    <div class="row">
        <div class="col-sm-8">
            <?php var_dump($data) ?>
        </div>
        <div class="col-sm-4">
            <div class="jumbotron">
                <h3><?php echo __('average Rating') ?></h3>
                <h2><?php echo $data->globalStatistics->averageRating ?></h2>
                <p><?php printf('out of %s reviews and %s different protals', $data->globalStatistics->reviewCount, $data->globalStatistics->portalCount) ?></p>
            </div>
        </div>
    </div>
</div>
