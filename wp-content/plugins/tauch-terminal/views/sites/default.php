<div class="dashboard-tauchterminal">
    <h2><?php esc_html_e('Tauch Terminal Settings' , 'tauch-terminal');?></h2>

    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
        <div class="wrap">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo __('Current Website') ?></th>
                        <td>
                            <?php if ($sites): ?>
                                <select name="settings['default_site']" class="form-control">
                                    <?php foreach ($sites as $option): ?>
                                        <option value="<?php echo $option->id ?>"<?php if ($current == $option->id): ?> selected="selected"<?php endif; ?>><?php echo $option->tt_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <b><?php echo __('No Websites defined yet.') ?></b>
                                <p><?php echo __('Login to your main site, and add all your websites.') ?></p>
                                <input type="hidden" name="settings['default_site']" value="">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('Default Url') ?></th>
                        <td><input class="form-control" type="text" name="settings['default_prefix']" value="<?php echo ($url) ? $url : '' ?>" style="width: 100%;" /></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="hidden" name="action" value="save" />
                            <button type="submit" class="btn btn-primary"><?php echo __('Save') ?></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>
