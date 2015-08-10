<div>
    <h2><?php esc_html_e('Tauch Terminal Tulamben' , 'tauch-terminal');?></h2>

    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
        <div class="wrap">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo __('Customer Alliance API (Stand auf externen Portalen)') ?></th>
                        <td><input type="text" name="settings['ca_api_external']" value="<?php echo ($settings && isset($settings)) ? TauchTerminal_Tulamben::getTauchTerminalOptions('ca_api_external') : '' ?>" style="width: 100%;" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('Customer Alliance API (Customer Alliance Bewertungen)') ?></th>
                        <td><input type="text" name="settings['ca_api_reviews']" value="<?php echo ($settings && isset($settings)) ? TauchTerminal_Tulamben::getTauchTerminalOptions('ca_api_reviews') : '' ?>" style="width: 100%;" /></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="hidden" name="action" value="save" />
                            <button type="submit"><?php echo __('Save') ?></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>

