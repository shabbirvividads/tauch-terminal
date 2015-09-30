<div class="edit-tauchterminal wrap">
    <h2><?php esc_html_e('Tauch Terminal Certifications' , 'tauch-terminal');?> <a href="<?php echo esc_url( add_query_arg( array('action' => 'add'), $_SERVER['REQUEST_URI'] ) ) ?>" class="add-new-h2"><?php echo __('Add New') ?></a></h2>

        <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
        <div class="tablenav top">
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text"><?php echo __('Mehrfachauswahl') ?></label>
                <select name="action" id="bulk-action-selector-top">
                    <option value="-1" selected="selected"><?php echo __('Aktion wählen') ?></option>
                    <option value="add" class="hide-if-no-js"><?php echo __('Neu hinzufügen') ?></option>
                    <option value="edit" class="hide-if-no-js"><?php echo __('Bearbeiten') ?></option>
                    <option value="trash"><?php echo __('In Papierkorb legen') ?></option>
                </select>
                <input type="submit" name="" id="doaction" class="button action" value="Übernehmen">
            </div>
        </div>
        <table class="wp-list-table widefat fixed pages">
            <thead>
                <tr>
                    <th scope="col" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1"><?php echo __('Select all') ?></label>
                        <input id="cb-select-all-1" type="checkbox">
                    </th>
                    <th scope="col" class="manage-column column-icon">
                    </th>
                    <th scope="col" class="manage-column column-title sortable desc">
                        <label>
                            <span><?php echo __('Title') ?></span>
                            <span class="sorting-indicator"></span>
                        </label>
                    </th>
                    <th scope="col" class="manage-column column-desc">
                        <label>
                            <span><?php echo __('Url') ?></span>
                        </label>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if($certifications): ?>
                    <?php foreach($certifications as $certification): ?>
                        <tr>
                            <th scope="row" class="check-column">
                                <label class="screen-reader-text" for="cb-select-<?php echo $certification->id ?>"><?php echo __('Select %s certification', $certification->name) ?></label>
                                <input id="cb-select-<?php echo $certification->id ?>" type="checkbox" name="post[]" value="<?php echo $certification->id ?>">
                                <div class="locked-indicator"></div>
                                <input type="hidden" name="tt[<?php echo $certification->id ?>][id]" value="<?php echo $certification->id ?>" />
                            </th>
                            <td><img width="60" height="60" src="<?php echo $certification->url ?>" class="attachment-80x60" alt="unud"></td>
                            <td>
                                <strong>
                                    <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'edit', 'post' => array($certification->id) ), $_SERVER['REQUEST_URI'] ) ) ?>" title=""><?php echo $certification->name ?></a>
                                </strong>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo esc_url( add_query_arg( array( 'action' => 'edit', 'post' => array($certification->id) ), $_SERVER['REQUEST_URI'] ) ) ?>" title="Dieses Element bearbeiten"><?php echo __('Edit') ?></a> | </span>
                                    <span class="trash"><a class="submitdelete" title="Element in den Papierkorb verschieben" href="<?php echo esc_url( add_query_arg( array( 'action' => 'trash', 'post' => array($certification->id) ), $_SERVER['REQUEST_URI'] ) ) ?>"><?php echo __('Trash') ?></a></span>
                                </div>
                            </td>
                            <td><?php echo $certification->url ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif; ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </form>
</div>
