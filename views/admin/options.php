<div id="wp-ps-options" class="wrap">

    <h1>WP Post Email Notification Options</h1>

    <h2>Subscribers</h2>

    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th style="width: 20px;">ID</th>
                <th class="column-primary">E-Mail Address</th>
                <th>IP</th>
                <th>Created (GMT)</th>
                <th style="width: 20px;"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="subscriber in subscribers">
                <td class="check-column" style="padding: 8px 10px;">{{ subscriber.id }}</td>
                <td class="column-primary">{{ subscriber.email }}</td>
                <td>{{ subscriber.ip }}</td>
                <td>{{ subscriber.created_gmt }}</td>
                <td><span v-on:click="deleteSubscriber(subscriber.id)" class="dashicons dashicons-trash"></span></td>
            </tr>
            <tr v-if="subscribers.length == 0">
                <td colspan="5"><i>none</i></td>
            </tr>
        </tbody>
    </table>

    <h3>Add subscriber manually</h3>

    <form v-on:submit.prevent="addNewSubscriber">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="add-email">Email</label></th>
                    <td>
                        <input id="add-email" name="email" v-model="newSubscriber.email" class="regular-text" type="email" required>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button name="submit" class="button button-primary" type="submit">Add</button>
                        <div v-if="updatingSubscribers" class="spinner is-active" style="float: none;"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <hr/>

    <h2>Options</h2>

    <p>Possible Placeholders: <code>@@blog.name</code>, <code>@@post.title</code>, <code>@@post.author.name</code>,
        <code>@@post.link</code></p>

    <form v-on:submit.prevent="updateOptions">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>
                        <label for="emailSubject">Email Subject</label>
                    </th>
                    <td>
                        <input id="emailSubject" type="text" v-model="options.emailSubject" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="emailBody">Email Body</label>
                    </th>
                    <td>
                        <textarea id="emailBody" v-model="options.emailBody" class="large-text" cols="50" rows="10"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="numberOfMailsSendPerBatch">Number of emails to be send per batch</label>
                    </th>
                    <td>
                        <input id="numberOfMailsSendPerBatch" type="number" v-model="options.numberOfMailsSendPerBatch" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="jobInitialTimeWait">Initial job time wait</label>
                    </th>
                    <td>
                        <input id="jobInitialTimeout" type="number" v-model="options.jobInitialTimeWait" class="regular-text"/>
                        <p class="description">Delay in seconds until the first batch of email is being send by a job after it was scheduled.</p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="jobBatchTimeWait">Batch job time wait</label>
                    </th>
                    <td>
                        <input id="jobBatchTimeWait" type="number" v-model="options.jobBatchTimeWait" class="regular-text"/>
                        <p class="description">Delay in seconds between two batches of sending emails by a job.</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button name="submit" class="button button-primary" type="submit">Save</button>
                        <div v-if="updatingOptions" class="spinner is-active" style="float: none;"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <hr/>

    <h2>Jobs</h2>

    <p>This is a list of jobs, that are currently sending emails or wait for other jobs to complete.</p>

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
                <td colspan="6"><i>none</i></td>
            </tr>
        </tbody>
    </table>

</div>