<?php echo $before_widget; ?>

<?php if ($title) : ?>
    <?php echo $before_title; ?>
    <?php echo $title; ?>
    <?php echo $after_title; ?>
<?php endif; ?>

<?php if ($text) : ?>
    <p><?php echo $text; ?></p>
<?php endif; ?>

<form v-if="!success" v-on:submit.prevent="subscribe">
    <input name="email" type="email" placeholder="email address" v-model="subscriber.email">
    <input type="submit" value="Submit" :disabled="currentlySubscribing">
</form>

<p class="success" v-if="success">
    Thanks for subscribing!
</p>

<?php echo $after_widget; ?>
