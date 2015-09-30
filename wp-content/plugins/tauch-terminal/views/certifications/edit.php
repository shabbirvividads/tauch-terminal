<div class="edit-tauchterminal wrap">
    <h2><?php esc_html_e('Tauch Terminal Certification' , 'tauch-terminal');?></h2>

    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
       <table class="wp-list-table widefat fixed pages">
            <tbody>
                <tr>
                   <td scope="col" class="manage-column column-title sortable desc">
                        <label>
                            <span><?php echo __('Title') ?></span>
                            <span class="sorting-indicator"></span>
                        </label>
                    </td>
                    <td><input type="text" name="name" value="<?php echo isset($certification) ? $certification->name : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-bg">
                        <label>
                            <span><?php echo __('Logo') ?></span>
                        </label>
                    </td>
                    <td class="preview">
                        <p><img src="<?php echo isset($certification) ? $certification->url : '' ?>" class="preview bg" width="200" /></p>
                        <p><input type="text" name="url" value="<?php echo isset($certification) ? $certification->url : '' ?>" /></p>
                    </td>
                </tr>
                <tr>
                    <td scope="col"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo isset($certification) ? $certification->id : '' ?>" />
                        <input type="hidden" name="action" value="<?php echo $action ?>" />
                        <button type="submit" class="button-primary"><?php echo __('Save') ?></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
