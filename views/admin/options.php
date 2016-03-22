<div id="wp-ps-options" class="wrap">

    <h1>WP Post Subscription Options</h1>

    <h2>Subscribers</h2>

    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th style="width: 20px;">ID</th>
                <th class="column-primary">E-Mail Address</th>
                <th>IP</th>
                <th>Created</th>
                <th style="width: 20px;"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="subscriber in subscribers">
                <td>{{ subscriber.id }}</td>
                <td>{{ subscriber.email }}</td>
                <td>{{ subscriber.ip }}</td>
                <td>{{ subscriber.created }}</td>
                <td><span v-on:click="deleteSubscriber(subscriber.id)" class="dashicons dashicons-trash"></span></td>
            </tr>
            <tr v-if="subscribers.length == 0">
                <td colspan="5"><i>none</i></td>
            </tr>
        </tbody>
    </table>

    <h3>Add subscriber manually</h3>

    <form v-on:submit.prevent="addNewSubscriber">
        <input type="hidden" name="action" value="ps_add_subscriber">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="add-email">Email</label></th>
                    <td><input id="add-email" v-model="newSubscriber.email" name="email" class="regular-text" type="email" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input name="submit" class="button button-primary" value="Add" type="submit">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <h2>Jobs</h2>

    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th style="width: 20px;">ID</th>
                <th class="column-primary">Post ID</th>
                <th>Offset</th>
                <th>Next round (GMT)</th>
                <th>Created (GMT)</th>
                <th style="width: 20px;"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="job in jobs">
                <td>{{ job.id }}</td>
                <td>{{ job.post_id }}</td>
                <td>{{ job.offset }}</td>
                <td>{{ job.next_round_gmt }}</td>
                <td>{{ job.created_gmt }}</td>
                <td><span v-on:click="deleteJob(job.id)" class="dashicons dashicons-trash"></span></td>
            </tr>
            <tr v-if="jobs.length == 0">
                <td colspan="5"><i>none</i></td>
            </tr>
        </tbody>
    </table>

</div>