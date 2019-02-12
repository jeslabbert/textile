<!-- Customer Support -->
<div class="modal fade" id="modal-support" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form style="margin:auto;" method="POST" action="/support/email">
                {{ csrf_field() }}
            <div class="modal-body p-b-none">

                    <!-- From -->
                    <div class="form-group">
                        <input id="support-from" type="text" class="form-control" name="from" placeholder="{{__('Your Email Address')}}" value="{{Auth::user()->email}}">

                        {{--<span class="invalid-feedback" v-show="supportForm.errors.has('from')">--}}
                            {{--@{{ supportForm.errors.get('from') }}--}}
                        {{--</span>--}}
                    </div>

                    <!-- Subject -->
                    <div class="form-group" :class="{'is-invalid': supportForm.errors.has('subject')}">
                        <input id="support-subject" type="text" class="form-control" name="subject" placeholder="{{__('Subject')}}">

                        {{--<span class="invalid-feedback" v-show="supportForm.errors.has('subject')">--}}
                            {{--@{{ supportForm.errors.get('subject') }}--}}
                        {{--</span>--}}
                    </div>
                    <input type="text"  name="authuser_id" value="{{Auth::user()->id}}" hidden>
                    <input type="text"  name="allow_control" value="0" hidden>

                    <!-- E-Mail Address -->
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{__('Allow Control?')}}</label>

                        <div class="col-md-6">

                            <input type="checkbox" name="allow_control" @if(Auth::user()->allow_control === 1) checked @endif value="1" class="form-control py-0" id="inlineFormInputGroupUsername2">


                        </div>
                    </div>

                    <!-- Message -->
                    <div class="form-group m-b-none" :class="{'is-invalid': supportForm.errors.has('message')}">
                        <textarea class="form-control" rows="7" name="message" placeholder="{{__('Message')}}"></textarea>

                        {{--<span class="invalid-feedback" v-show="supportForm.errors.has('message')">--}}
                            {{--@{{ supportForm.errors.get('message') }}--}}
                        {{--</span>--}}
                    </div>

            </div>

            <!-- Modal Actions -->
            <div class="modal-footer border-none">
                <button class="btn btn-primary">
                    <i class="fa fa-btn fa-paper-plane"></i> {{__('Send')}}
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
