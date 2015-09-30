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
                    <td><input type="text" class="form-control" name="name" value="<?php echo isset($certification) ? $certification->name : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-bg">
                        <label>
                            <span><?php echo __('Logo') ?></span>
                        </label>
                    </td>
                    <td class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="url" class="form-control image_path" value="<?php echo isset($certification) ? $certification->url : ''; ?>" id="image_path" placeholder="Upload your Image from here.">
                            </div>
                        </div>
                        <input type="button" value="Upload Image" class="btn btn-primary upload_image"/>

                        <br/ >
                        <?php if(isset($certification) && !empty($certification->url)): ?>
                            <img style="width: 200px" src="<?php echo isset($certification) ? $certification->url : '' ; ?>">
                            <input type="submit" name="remove" value="Remove Image" class="btn btn-default" id="remove_image"/>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td scope="col"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo isset($certification) ? $certification->id : '' ?>" />
                        <input type="hidden" name="action" value="<?php echo $action ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo __('Save') ?></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
