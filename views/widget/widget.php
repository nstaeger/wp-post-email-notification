<?= $before_widget ?>

<?php if ($title) : ?>
    <?= $before_title ?>
    <?= $title ?>
    <?= $after_title ?>
<?php endif; ?>

<?php if ($text) : ?>
    <p><?= $text ?></p>
<?php endif; ?>

<form v-if="!success" v-on:submit.prevent="subscribe">
    <input name="" type="email" placeholder="email address" v-model="subscriber.email">
    <input type="submit" value="Submit">
</form>

<p class="success" v-if="success">
    Thanks for subscribing!
</p>

<?= $after_widget ?>
