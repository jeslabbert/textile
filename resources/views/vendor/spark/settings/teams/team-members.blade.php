<spark-team-members :user="user" :team="team" inline-template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                {{__('teams.team_members')}} (@{{ team.users.length }})
            </div>

            <div class="table-responsive">
                <table class="table table-valign-middle mb-0">
                    <thead>
                        <th class="th-fit"></th>
                        <th>{{__('Name')}}</th>

                        <th>{{__('Role')}}</th>
                        <th>{{__('Permissions')}}</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>


                    @forelse($team->users as $member)
                        <tr>
                            <!-- Photo -->
                            <td>
                                <img src="{{$member->photo_url}}" class="spark-profile-photo">
                            </td>


                            <!-- Name -->
                            <td>
                                @if($member->id === Auth::User()->id)
                                <span>
                                    {{__('You')}}
                                </span>
@else
                                <span>
                                    {{$member->name}}
                                </span>
                                    @endif
                            </td>
                        {{--TODO Per team member, store the below items and show table structure based off of this--}}
                        <!-- Role -->
                            <td >
                                {{\App\TeamUser::where('team_id', $team->id)->where('user_id', $member->id)->first()->role}}
                                {{$member->role}}
                            </td>

                            <td>
@if($member->id != Auth::User()->id)
@if($team->owner_id === Auth::User()->id)
<form class="form-horizontal" method="POST" action="/updatesiterole">
    {{ csrf_field() }}
    <input name="member_id" type="hidden" value="{{$member->id}}">
    <input name="team_id" type="hidden" value="{{$team->id}}">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="subsrole" class="custom-control-input" id="rolesubscription">
        <label class="custom-control-label" for="defaultUnchecked">Subscription</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="payrole" class="custom-control-input" id="rolepaymentmethod">
        <label class="custom-control-label" for="defaultUnchecked">Payment</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="invrole" class="custom-control-input" id="roleinvoices">
        <label class="custom-control-label" for="defaultUnchecked">Invoices</label>
    </div>
</form>
@endif
    @endif
</td>


<td class="td-fit">
@if(\App\Role::all()->count() > 1)
<button class="btn-sm btn-primary" @click="editTeamMember({{$member}})" v-if="canEditTeamMember({{$member}})">
<i class="fa fa-cog"></i>
</button>
@endif
<button class="btn-sm btn-danger" @click="approveTeamMemberDelete({{$member}})" v-if="canDeleteTeamMember({{$member}})">
<i class="fa fa-remove"></i>
</button>
</td>
</tr>
@empty

@endforelse

{{--<tr v-for="member in team.users">--}}
{{--<!-- Photo -->--}}
{{--<td>--}}
{{--<img :src="member.photo_url" class="spark-profile-photo">--}}
{{--</td>--}}


{{--<!-- Name -->--}}
{{--<td>--}}
{{--<span v-if="member.id === user.id">--}}
    {{--{{__('You')}}--}}
{{--</span>--}}

{{--<span v-else>--}}
    {{--@{{ member.name }}--}}
{{--</span>--}}
{{--</td>--}}
{{--TODO Per team member, store the below items and show table structure based off of this--}}
{{--<!-- Role -->--}}
{{--<td v-if="roles.length > 0">--}}
{{--@{{ teamMemberRole(member) }}--}}
{{--</td>--}}
{{--<td v-if="user.id === team.owner_id & member.id !== user.id">--}}
{{--<div class="custom-control custom-checkbox">--}}
    {{--<input type="checkbox" name="subsrole" @click="editTeamMember(member)" class="custom-control-input" id="rolesubscription">--}}
    {{--<label class="custom-control-label" for="defaultUnchecked">Subscription</label>--}}
{{--</div>--}}
{{--<div class="custom-control custom-checkbox">--}}
    {{--<input type="checkbox" name="payrole" class="custom-control-input" id="rolepaymentmethod">--}}
    {{--<label class="custom-control-label" for="defaultUnchecked">Payment</label>--}}
{{--</div>--}}
{{--<div class="custom-control custom-checkbox">--}}
    {{--<input type="checkbox" name="invrole" class="custom-control-input" id="roleinvoices">--}}
    {{--<label class="custom-control-label" for="defaultUnchecked">Invoices</label>--}}
{{--</div>--}}
{{--</form>--}}
{{--</td>--}}
{{--<td v-if="member.id === user.id"></td>--}}

{{--<td class="td-fit">--}}
{{--<button class="btn-sm btn-primary" @click="editTeamMember(member)" v-if="roles.length > 1 && canEditTeamMember(member)">--}}
    {{--<i class="fa fa-cog"></i>--}}
{{--</button>--}}

{{--<button class="btn-sm btn-danger" @click="approveTeamMemberDelete(member)" v-if="canDeleteTeamMember(member)">--}}
{{--<i class="fa fa-remove"></i>--}}
{{--</button>--}}
{{--</td>--}}
{{--</tr>--}}
</tbody>
</table>
</div>
</div>

<!-- Update Team Member Modal -->
<div class="modal" id="modal-update-team-member" tabindex="-1" role="dialog">
<div class="modal-dialog" v-if="updatingTeamMember">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
{{__('teams.edit_team_member')}} (@{{ updatingTeamMember.name }})
</h5>
</div>

<div class="modal-body">
<!-- Update Team Member Form -->
<form role="form">
<div class="form-group row">
<label class="col-md-4 col-form-label text-md-right">
    {{__('Role')}}
</label>

<div class="col-md-6">
    <select class="form-control" v-model="updateTeamMemberForm.role" :class="{'is-invalid': updateTeamMemberForm.errors.has('role')}">
        <option v-for="role in roles" :value="role.value">
            @{{ role.text }}
        </option>
    </select>

    <span class="invalid-feedback" v-if="updateTeamMemberForm.errors.has('role')">
        @{{ updateTeamMemberForm.errors.get('role') }}
    </span>
</div>
</div>
</form>
</div>

<!-- Modal Actions -->
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>

<button type="button" class="btn btn-primary" @click="update" :disabled="updateTeamMemberForm.busy">
{{__('Update')}}
</button>
</div>
</div>
</div>
</div>

<!-- Delete Team Member Modal -->
<div class="modal" id="modal-delete-member" tabindex="-1" role="dialog">
<div class="modal-dialog" v-if="deletingTeamMember">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
{{__('teams.remove_team_member')}} (@{{ deletingTeamMember.name }})
</h5>
</div>

<div class="modal-body">
{{__('teams.are_you_sure_you_want_to_delete_member')}}
</div>

<!-- Modal Actions -->
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

<button type="button" class="btn btn-danger" @click="deleteMember" :disabled="deleteTeamMemberForm.busy">
{{__('Yes, Remove')}}
</button>
</div>
</div>
</div>
</div>
</div>
</spark-team-members>
