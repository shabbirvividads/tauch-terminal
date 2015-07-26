<div class="edit-tauchterminal wrap">
    <h2><?php esc_html_e('Tauch Terminal' , 'tauch-terminal');?></h2>

    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
       <table class="wp-list-table widefat fixed pages">
            <tbody>
                <tr>
                   <td scope="col" class="manage-column column-title sortable desc">
                        <a href="">
                            <span><?php echo __('Title *') ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </td>
                    <td><input type="text" name="tt_name" value="<?php echo isset($site) ? $site->tt_name : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-desc">
                        <a href="">
                            <span><?php echo __('Description') ?></span>
                        </a>
                    </td>
                    <td><input type="text" name="tt_desc" value="<?php echo isset($site) ? $site->tt_desc : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-slug">
                        <a href="">
                            <span><?php echo __('Slug') ?></span>
                        </a>
                    </td>
                    <td><input type="text" name="tt_slug" value="<?php echo isset($site) ? $site->tt_slug : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-url">
                        <a href="">
                            <span><?php echo __('Url') ?></span>
                        </a>
                    </td>
                    <td><input type="text" name="tt_url" value="<?php echo isset($site) ? $site->tt_url : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-logo">
                        <a href="">
                            <span><?php echo __('Logo') ?></span>
                        </a>
                    </td>
                    <td class="preview">
                        <p><img src="<?php echo isset($site) ? $site->tt_logo : '' ?>" class="preview logo" width="50"/></p>
                        <p><input type="text" name="tt_logo" value="<?php echo isset($site) ? $site->tt_logo : '' ?>" /></p>
                    </td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-bg">
                        <a href="">
                            <span><?php echo __('Background') ?></span>
                        </a>
                    </td>
                    <td class="preview">
                        <p><img src="<?php echo isset($site) ? $site->tt_bg : '' ?>" class="preview bg" width="200" /></p>
                        <p><input type="text" name="tt_bg" value="<?php echo isset($site) ? $site->tt_bg : '' ?>" /></p>
                    </td>
                </tr>
                <tr>
                    <td scope="col"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo isset($site) ? $site->id : '' ?>" />
                        <input type="hidden" name="action" value="<?php echo $action ?>" />
                        <button type="submit"><?php echo __('Save') ?></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
