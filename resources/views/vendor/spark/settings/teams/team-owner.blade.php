<div class="card card-default">
    <div class="card-header">
        Site Ownership
    </div>

<br>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Owner</label>

                    <div class="col-md-6">
                        <select name="first_user_id" class="browser-default custom-select" style="margin-bottom: 10px;">
                            @forelse($team->users()->get() as $teamuser)
                                <option @if(App\TeamCommission::where('team_id', $team->id)->count() > 0) @if(App\TeamCommission::where('team_id', $team->id)->first()->first_user_id == $teamuser->id) selected @endif @endif value="{{$teamuser->id}}">{{$teamuser->name}} {{$teamuser->last_name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
    <div class="form-group row mb-0">
        <div class="offset-md-4 col-md-6">
            <button type="submit" class="btn btn-primary">

                                {{__('Update')}}

            </button>
        </div>
    </div>
<br>
</div>