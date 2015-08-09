<div class="dashboard-tauchterminal">
    <h1><?php esc_html_e('Tauch Terminal' , 'tauch-terminal');?></h1>


    <div id="dashboard-widgets-wrap">
        <div id="dashboard-widgets" class="metabox-holder">
            <div class="postbox-container">
                <div class="meta-box-sortables">
                    <div class="postbox">
                        <a href="admin.php?page=tauch-terminal-settings" class="handlediv"></a>
                        <h3 class='hndle'>
                            <span><?php echo __('Current Site') ?></span>
                        </h3>
                        <div class="inside">
                            <?php if($currentsite): ?>
                                <ul class="list-unstyled">
                                    <li><?php echo $currentsite->tt_name ?></li>
                                </ul>
                            <?php else: ?>
                                <p><?php echo __('There are no site as current defined yet.') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="postbox-container">
                <div class="meta-box-sortables">
                    <div class="postbox">
                        <?php if(get_current_blog_id() == 1): ?><a href="admin.php?page=tauch-terminal-sites" class="handlediv"></a><?php endif; ?>
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
    </div>
</div>
