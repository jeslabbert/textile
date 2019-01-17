<div class="card card-default">
    <div class="card-header">
        Site Ownership
    </div>

<br>
    <form class="form-horizontal" method="POST" action="/updatesiteowner">
        {{ csrf_field() }}
        <input name="team_id" type="hidden" value="{{$team->id}}">
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Owner</label>

                    <div class="col-md-6">
                        <select name="owner" class="browser-default custom-select" style="margin-bottom: 10px;">
                            @forelse($team->users()->get() as $teamuser)
                                <option  @if(App\Team::where('id', $team->id)->first()->owner_id == $teamuser->id) selected @endif value="{{$teamuser->id}}">{{$teamuser->name}} {{$teamuser->last_name}}</option>
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
    </form>
<br>
</div>