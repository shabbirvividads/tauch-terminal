<?php foreach ($attributes as $att): ?>
<?php if (!$att['is_variation']): ?>
     <tr>
        <td><label for="<?php echo sanitize_title($att['name']); ?>"><?php echo wc_attribute_label($att['name']); ?></label></td>
        <td class="value">
            <select id="<?php echo esc_attr(sanitize_title($att['name'])); ?>" name="attribute_<?php echo sanitize_title($att['name']); ?>" data-attribute_name="attribute_<?php echo sanitize_title($att['name']); ?>">
                <?php foreach (explode("|", $att['value']) as $id => $name): ?>
                    <option value="<?php echo $id ?>"><?php echo $name ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
<?php endif; ?>
<?php endforeach; ?>
