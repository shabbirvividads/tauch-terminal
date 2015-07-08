<div class="dashboard-tauchterminal">
    <h1><?php esc_html_e('Tauch Terminal' , 'tauch-terminal');?> <?php echo __('Settings') ?></h1>
    <p><?php echo __('You can set the default behaviour of your plugin here.') ?></p>

    <div class="metabox-holder<?php echo $columns_css; ?>">
        <div class="postbox-container">
            <div class="postbox">
                <a href="admin.php?page=tauch-terminal-edit" class="handlediv"><br></a>
                <h3 class='hndle'>
                    <span><?php echo __('Sites') ?></span>
                </h3>
                <div class="inside">
                    <?php if($sites): ?>
                        <ul class="list-unstyled">
                        <?php foreach($sites as $site): ?>
                            <li><?php echo $site->tt_name ?></li>
                        <?php endforeach ?>
                        </ul>
                    <?php else: ?>
                        <p><?php echo __('There are no sites defined yet.') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
