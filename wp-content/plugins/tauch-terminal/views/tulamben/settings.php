<div>
    <h2><?php esc_html_e('Tauch Terminal Tulamben' , 'tauch-terminal');?></h2>

    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
        <div class="wrap">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo __('SOAP Client Username') ?></th>
                        <td><input class="form-control" type="text" name="settings['soap_username']" value="<?php echo (TauchTerminal_DB::getTTOption('soap_username')) ? TauchTerminal_DB::getTTOption('soap_username') : '' ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('SOAP Client Password') ?></th>
                        <td><input class="form-control" type="text" name="settings['soap_password']" value="<?php echo (TauchTerminal_DB::getTTOption('soap_password')) ? TauchTerminal_DB::getTTOption('soap_password') : '' ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('SOAP Client Namespace') ?></th>
                        <td><input class="form-control" type="text" name="settings['soap_namespace']" value="<?php echo (TauchTerminal_DB::getTTOption('soap_namespace')) ? TauchTerminal_DB::getTTOption('soap_namespace') : '' ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('SOAP Client Header Name') ?></th>
                        <td><input class="form-control" type="text" name="settings['header_name']" value="<?php echo (TauchTerminal_DB::getTTOption('header_name')) ? TauchTerminal_DB::getTTOption('header_name') : '' ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('SOAP Client Hotelbuchungssystem') ?></th>
                        <td>
                            <input class="form-control" type="text" name="settings['soap_booking']" value="<?php echo (TauchTerminal_DB::getTTOption('soap_booking')) ? TauchTerminal_DB::getTTOption('soap_booking') : '' ?>" />
                            <p class="help-block">http://36.78.146.97:1024/wsdl/ITTTSOAPWebService</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('Customer Alliance API (Stand auf externen Portalen)') ?></th>
                        <td><input class="form-control" type="text" name="settings['ca_api_external']" value="<?php echo (TauchTerminal_DB::getTTOption('ca_api_external')) ? TauchTerminal_DB::getTTOption('ca_api_external') : '' ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('Customer Alliance API (Customer Alliance Bewertungen)') ?></th>
                        <td><input class="form-control" type="text" name="settings['ca_api_reviews']" value="<?php echo (TauchTerminal_DB::getTTOption('ca_api_reviews')) ? TauchTerminal_DB::getTTOption('ca_api_reviews') : '' ?>" /></td>
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

