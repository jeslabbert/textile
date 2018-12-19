<spark-pending-invitations inline-template>
    <div>
        <div class="card card-default" v-if="invitations.length > 0">
            <div class="card-header">{{__('Pending Invitations')}}</div>

            <div class="table-responsive">
                <table class="table table-valign-middle mb-0">
                    <thead>
                        <th>{{ __('teams.team') }}</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        <tr v-for="invitation in invitations">
                            <!-- Team Name -->
                            <td>
                                <div class="btn-table-align">
                                    @{{ invitation.team.name }}
                                </div>
                            </td>

                            <!-- Accept Button -->
                            <td class="td-fit">
                                <button class="btn btn-success" @click="accept(invitation)">
                                    <i class="fas fa-thumbs-up"></i>
                                </button>

                                <button class="btn btn-danger" @click="reject(invitation)">
                                    <i class="fas fa-thumbs-down"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</spark-pending-invitations>
