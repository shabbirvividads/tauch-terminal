<div class="dashboard-tauchterminal">
    <h2><?php esc_html_e('Tauch Terminal' , 'tauch-terminal');?></h2>

    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
       <table class="wp-list-table widefat fixed pages">
            <thead>
                <tr>
                   <th scope="col" class="manage-column column-title sortable desc">
                        <a href="">
                            <span><?php echo __('Default Url') ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                   <td><input type="text" name="url" value="<?php echo isset($site) ? $site->url : '' ?>" style="width: 100%;" /></td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="action" value="save" />
                        <button type="submit"><?php echo __('Save') ?></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
