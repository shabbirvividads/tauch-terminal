<?php var_dump($site) ?>
<div class="edit-tauchterminal wrap">
    <h2><?php esc_html_e('Tauch Terminal Sites' , 'tauch-terminal');?></h2>

    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
       <table class="wp-list-table widefat fixed pages tt-sites-edit">
            <tbody>
                <tr>
                   <td scope="col" class="manage-column column-title sortable desc">
                        <label>
                            <span><?php echo __('Title') ?></span>
                            <span class="sorting-indicator"></span>
                        </label>
                    </td>
                    <td class="form-group"><input type="text" class="form-control" name="tt_name" value="<?php echo isset($site) ? $site->tt_name : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-desc">
                        <label>
                            <span><?php echo __('Description') ?></span>
                        </label>
                    </td>
                    <td class="form-group"><input type="text" class="form-control" name="tt_desc" value="<?php echo isset($site) ? $site->tt_desc : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-slug">
                        <label>
                            <span><?php echo __('Slug') ?></span>
                        </label>
                    </td>
                    <td class="form-group"><input type="text" class="form-control" name="tt_slug" value="<?php echo isset($site) ? $site->tt_slug : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-url">
                        <label>
                            <span><?php echo __('Url') ?></span>
                        </label>
                    </td>
                    <td class="form-group"><input type="text" class="form-control" name="tt_url" value="<?php echo isset($site) ? $site->tt_url : '' ?>" /></td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-logo">
                        <label>
                            <span><?php echo __('Logo') ?></span>
                        </label>
                    </td><td class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="tt_logo" class="form-control image_path" value="<?php echo isset($site) ? $site->tt_logo : ''; ?>" id="image_path" placeholder="Upload your Image from here.">
                            </div>
                        </div>
                        <input type="button" value="Upload Image" class="btn btn-primary upload_image"/>

                        <br/ >
                        <?php if(isset($site) && !empty($site->tt_logo)): ?>
                            <img style="width: 200px" src="<?php echo isset($site) ? $site->tt_logo : '' ; ?>">
                            <input type="submit" name="remove" value="Remove Image" class="btn btn-default" id="remove_image"/>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td scope="col" class="manage-column column-bg">
                        <label>
                            <span><?php echo __('Background') ?></span>
                        </label>
                    </td>
                    <td class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="tt_bg" class="form-control image_path" value="<?php echo isset($site) ? $site->tt_bg : ''; ?>" id="image_path" placeholder="Upload your Image from here.">
                            </div>
                        </div>
                        <input type="button" value="Upload Image" class="btn btn-primary upload_image"/>

                        <br/ >
                        <?php if(isset($site) && !empty($site->tt_bg)): ?>
                            <img style="width: 200px" src="<?php echo isset($site) ? $site->tt_bg : '' ; ?>">
                            <input type="submit" name="remove" value="Remove Image" class="btn btn-default" id="remove_image"/>
                        <?php endif; ?>
                    </td>
                </tr>
                <form class="form-inline">

                <tr>
                    <td scope="col"></td>
                    <td class="form-group">
                        <input type="hidden" name="id" value="<?php echo isset($site) ? $site->id : '' ?>" />
                        <input type="hidden" name="action" value="<?php echo $action ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo __('Save') ?></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
