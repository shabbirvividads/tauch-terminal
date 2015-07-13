<div class="edit-tauchterminal">
    <h1><?php esc_html_e('Tauch Terminal' , 'tauch-terminal');?> <?php echo __('Edit') ?></h1>

    <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <div class="tablenav top">
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text"><?php echo __('Mehrfachauswahl') ?></label>
                <select name="action" id="bulk-action-selector-top">
                    <option value="-1" selected="selected"><?php echo __('Aktion wählen') ?></option>
                    <option value="edit" class="hide-if-no-js"><?php echo __('Bearbeiten') ?></option>
                    <option value="trash"><?php echo __('In Papierkorb legen') ?></option>
                </select>
                <input type="submit" name="" id="doaction" class="button action" value="Übernehmen">
            </div>
            <div class="alignleft actions">
                <label for="filter-by-date" class="screen-reader-text"><?php echo __('Nach Datum filtern') ?></label>
                <select name="m" id="filter-by-date">
                    <option selected="selected" value="0"><?php echo __('Alle Daten') ?></option>
                    <option value="201503"><?php echo __('März 2015') ?></option>
                </select>
                <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Auswahl einschränken">
            </div>
            <div class="tablenav-pages one-page"><span class="displaying-num"><?php echo __('Ein Element') ?></span>
            <span class="pagination-links"><a class="first-page disabled" title="Zur ersten Seite gehen" href="http://localhost/~nessie/wordpress/wp-admin/edit.php?post_type=page">«</a>
            <a class="prev-page disabled" title="Zur vorherigen Seite gehen" href="http://localhost/~nessie/wordpress/wp-admin/edit.php?post_type=page&amp;paged=1">‹</a>
            <span class="paging-input"><label for="current-page-selector" class="screen-reader-text"><?php echo __('Seite auswählen') ?></label><input class="current-page" id="current-page-selector" title="Aktuelle Seite" type="text" name="paged" value="1" size="1"> von <span class="total-pages">1</span></span>
            <a class="next-page disabled" title="Zur nächsten Seite gehen" href="http://localhost/~nessie/wordpress/wp-admin/edit.php?post_type=page&amp;paged=1">›</a>
            <a class="last-page disabled" title="Zur letzten Seite gehen" href="http://localhost/~nessie/wordpress/wp-admin/edit.php?post_type=page&amp;paged=1">»</a></span></div>
            <br class="clear">
        </div>
        <table class="wp-list-table widefat fixed pages">
            <thead>
                <tr>
                    <th scope="col" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1"><?php echo __('Select all') ?></label>
                        <input id="cb-select-all-1" type="checkbox">
                    </th>
                    <th scope="col" class="manage-column column-title sortable desc">
                        <a href="">
                            <span><?php echo __('Title *') ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <th scope="col" class="manage-column column-desc">
                        <a href="">
                            <span><?php echo __('Description') ?></span>
                        </a>
                    </th>
                    <th scope="col" class="manage-column column-slug">
                        <a href="">
                            <span><?php echo __('Slug') ?></span>
                        </a>
                    </th>
                    <th scope="col" class="manage-column column-url">
                        <a href="">
                            <span><?php echo __('Url') ?></span>
                        </a>
                    </th>
                    <th scope="col" class="manage-column column-logo">
                        <a href="">
                            <span><?php echo __('Logo') ?></span>
                        </a>
                    </th>
                    <th scope="col" class="manage-column column-bg">
                        <a href="">
                            <span><?php echo __('Background') ?></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if($sites): ?>
                    <?php foreach($sites as $site): ?>
                        <tr>
                            <th scope="row" class="check-column">
                                <label class="screen-reader-text" for="cb-select-<?php echo $site->id ?>"><?php echo __('Select %s site', $site->tt_name) ?></label>
                                <input id="cb-select-<?php echo $site->id ?>" type="checkbox" name="post[]" value="<?php echo $site->id ?>">
                                <div class="locked-indicator"></div>
                                <input type="hidden" name="tt[<?php echo $site->id ?>][id]" value="<?php echo $site->id ?>" />
                            </th>
                            <td><input type="text" name="tt[<?php echo $site->id ?>][name]" value="<?php echo $site->tt_name ?>" /></td>
                            <td><input type="text" name="tt[<?php echo $site->id ?>][desc]" value="<?php echo $site->tt_desc ?>" /></td>
                            <td><input type="text" name="tt[<?php echo $site->id ?>][slug]" value="<?php echo $site->tt_slug ?>" /></td>
                            <td><input type="text" name="tt[<?php echo $site->id ?>][url]" value="<?php echo $site->tt_url ?>" /></td>
                            <td class="preview">
                                <p><img src="<?php echo $site->tt_logo ?>" class="preview logo" width="50"/></p>
                                <p><input type="text" name="tt[<?php echo $site->id ?>][logo]" value="<?php echo $site->tt_logo ?>" /></p>
                            </td>
                            <td class="preview">
                                <p><img src="<?php echo $site->tt_bg ?>" class="preview bg" width="200" /></p>
                                <p><input type="text" name="tt[<?php echo $site->id ?>][bg]" value="<?php echo $site->tt_bg ?>" /></p>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif; ?>
                <tr>
                    <th scope="row" class="check-column">
                        <input type="hidden" name="tt[<?php echo ++$site->id ?>][id]" value="" />
                    </th>
                    <td><input type="text" name="tt[<?php echo $site->id ?>][name]" value="" /></td>
                    <td><input type="text" name="tt[<?php echo $site->id ?>][desc]" value="" /></td>
                    <td><input type="text" name="tt[<?php echo $site->id ?>][slug]" value="" /></td>
                    <td><input type="text" name="tt[<?php echo $site->id ?>][url]" value="" /></td>
                    <td><input type="text" name="tt[<?php echo $site->id ?>][logo]" value="" /></td>
                    <td><input type="text" name="tt[<?php echo $site->id ?>][bg]" value="" /></td>
            </tbody>
            <tfoot>

            </tfoot>
    </form>
</div>
