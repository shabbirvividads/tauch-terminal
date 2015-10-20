<?php foreach ($attributes as $att): ?>
<?php if (!$att['is_variation']): ?>
     <div class="form-group">
        <label for="<?php echo sanitize_title($att['name']); ?>" class="col-sm-3 control-label"><?php echo wc_attribute_label($att['name']); ?></label>
        <div class="col-sm-9">
            <select id="<?php echo esc_attr(sanitize_title($att['name'])); ?>" class="form-control" name="attribute_<?php echo sanitize_title($att['name']); ?>" data-attribute_name="attribute_<?php echo sanitize_title($att['name']); ?>">
                <?php foreach (explode("|", $att['value']) as $id => $name): ?>
                    <option value="<?php echo $id ?>"><?php echo $name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endif; ?>
<?php endforeach; ?>
