<spark-current-teams :user="user" :teams="teams" inline-template>
    <div>
        <div class="card card-default">
            <div class="card-header">{{__('teams.current_teams')}}</div>

            <div class="table-responsive">
                <table class="table table-valign-middle mb-0">
                    <thead>
                        <th class="th-fit"></th>
                        <th class="th-lg">{{__('Name')}}</th>
                        {{--<th>{{__('Owner')}}</th>--}}
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        <tr  v-for="team in teams">
                            <!-- Photo -->
                            <td style="padding:5px;">
                                <img :src="team.photo_url" class="spark-profile-photo">
                            </td>

                            <!-- Team Name -->
                            <td>
                                <div class="btn-table-align">
                                    <a :href="'/settings/{{Spark::teamsPrefix()}}/'+team.id">
                                    @{{ team.name }}
                                    </a>
                                </div>
                            </td>

                            {{--<!-- Owner Name -->--}}
                            {{--<td>--}}
                                {{--<div class="btn-table-align">--}}
                                    {{--<span v-if="user.id == team.owner.id">--}}
                                        {{--{{__('You')}}--}}
                                    {{--</span>--}}

                                    {{--<span v-else>--}}
                                        {{--@{{ team.owner.name }}--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                            {{--</td>--}}

                            <!-- Edit Button -->
                            <td>
                                <button class="btn-sm btn-primary" @click="visitSite(team)"
                                        data-toggle="tooltip" title="{{__('teams.visit_site')}}">
                                    <i class="fa fa-link"></i>
                                </button>
                                <button class="btn-sm btn-warning" @click="approveLeavingTeam(team)"
                                        data-toggle="tooltip" title="{{__('teams.leave_site')}}"
                                        v-if="user.id !== team.owner_id">
                                    <i class="fa fa-sign-out"></i>
                                </button>
                                <button class="btn-sm btn-default" href="'/settings/{{ Spark::teamsPrefix() }}/'+ team.id +'/switch'">Switch</button>

                                @if (Spark::createsAdditionalTeams())
                                    <button class="btn-sm btn-danger" @click="approveTeamDelete(team)" v-if="user.id === team.owner_id">
                                        <i class="fa fa-times"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Leave Team Modal -->
        <div class="modal" id="modal-leave-team" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="leavingTeam">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('teams.leave_team')}} (@{{ leavingTeam.name }})
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{__('teams.are_you_sure_you_want_to_leave_team')}}
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-warning" @click="leaveTeam" :disabled="leaveTeamForm.busy">
                            {{__('Yes, Leave')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Team Modal -->
        <div class="modal" id="modal-delete-team" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingTeam">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('teams.delete_team')}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{__('teams.are_you_sure_you_want_to_delete_team')}}
                        {{__('teams.if_you_delete_team_all_data_will_be_deleted')}}
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-danger" @click="deleteTeam" :disabled="deleteTeamForm.busy">
                            <span v-if="deleteTeamForm.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Deleting')}}
                            </span>

                            <span v-else>
                                {{__('Yes, Delete')}}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-current-teams>
