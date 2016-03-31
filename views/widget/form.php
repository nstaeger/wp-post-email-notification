<p>
    <label for="<?php echo $title_field_id; ?>"><?php _e('Title:'); ?></label>
    <input id="<?php echo $title_field_id; ?>" name="<?php echo $title_field_name; ?>" value="<?php echo $title_value; ?>" type="text" class="widefat">
</p>
<p>
    <label for="<?php echo $text_field_id; ?>"><?php _e('text Text:'); ?></label>
    <textarea id="<?php echo $text_field_id; ?>" name="<?php echo $text_field_name; ?>" class="widefat" cols="20" rows="8"><?php echo $text_value; ?></textarea>
</p>
