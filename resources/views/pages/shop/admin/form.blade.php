<div class="form-group">
    <label for="title">Title</label>
    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title','required']) !!}
</div>

<div class="form-group">
    <label for="logo">Logo</label>
    {!! Form::file('logo', ['class'=>'form-control', 'id'=>'logo']) !!}
</div>

<div class="form-group">
    <label for="emails_notification">Emails for notification</label>
    {!! Form::text('emails_notification', null, ['class'=>'', 'id'=>'emails_notification','required']) !!}
</div>

<div class="form-group">
    <label for="description">Description</label>
    {!! Form::textarea('description', null, ['class'=>'form-control','id'=>'description','rows' => 20]) !!}
</div>

<hr>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="fail_url">Fail URl</label>
            {!! Form::text('fail_url', null, ['class'=>'form-control', 'id'=>'fail_url']) !!}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="return_url">Return URl</label>
            {!! Form::text('return_url', null, ['class'=>'form-control', 'id'=>'return_url']) !!}
        </div>
    </div>

</div>
<hr>
<div><p>Sberbank Auth Data</p></div>

<div class="form-group">
    <label for="api_type">Test Mode*</label>
    <p><label><input name="test_mode" type="radio" value="0" @if(isset($shop) && $shop->mode == 0) checked
                     @endif required> &nbsp;&nbsp;Yes</label></p>
    <p><label><input name="test_mode" type="radio" value="1" @if(isset($shop) && $shop->mode == 1) checked @endif>
            &nbsp;&nbsp;No</label></p>
</div>
<hr>

<div class="row">
    <div class="col">
        <h3>Test</h3>
        <div class="form-group">
            <label for="api_login_test">Api Login</label>
            {!! Form::text('api_login_test', null, ['class'=>'form-control', 'id'=>'api_login_test']) !!}
        </div>

        <div class="form-group">
            <label for="api_password_test">Api Password</label>
            {!! Form::text('api_password_test', null, ['class'=>'form-control', 'id'=>'api_password_test']) !!}
        </div>
    </div>

    <div class="col">
        <h3>Production</h3>
        <div class="form-group">
            <label for="api_login">Api Login</label>
            {!! Form::text('api_login', null, ['class'=>'form-control', 'id'=>'api_login']) !!}
        </div>

        <div class="form-group">
            <label for="api_password">Api Password</label>
            {!! Form::text('api_password', null, ['class'=>'form-control', 'id'=>'api_password']) !!}
        </div>
    </div>
</div>


<hr>
<div><p>Or</p></div>

<div class="form-group">
    <label for="api_token">Api Token</label>
    {!! Form::text('api_token', null, ['class'=>'form-control', 'id'=>'api_token']) !!}
</div>

<div class="form-group">
    <button class="btn btn-sm btn-primary">
        Save
    </button>
</div>

@push('plugin-scripts')
    {!! Html::script('assets/plugins/tagify/jQuery.tagify.min.js') !!}

    <script data-name="basic">
        (function () {
// The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=emails_notification]');

// initialize Tagify on the above input node reference
            let tagify = new Tagify(input, {
                pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                delimiters: ",| ",
                whitelist: @if(isset($shop)) [{!!  $shop->emailForTagify  !!}]@else [''] @endif,
                editTags: {
                    clicks: 1,              // single click to edit a tag
                    keepInvalid: false      // if after editing, tag is invalid, auto-revert
                },
                enforceWhitelist: true,
                dropdown: {
                    enabled: 1,            // show suggestion after 1 typed character
                    fuzzySearch: false,    // match only suggestions that starts with the typed characters
                    position: 'text',      // position suggestions list next to typed text
                    caseSensitive: true,   // allow adding duplicate items if their case is different
                },
                callbacks: {
                    input: function (e) {
                        let val = e.detail.value;

                        console.log(tagify.settings.whitelist)

                        tagify.settings.whitelist.shift();

                        let hostList = [
                            '@tspu.edu.ru',
                            '@gmail.com',
                            '@mail.ru',
                            '@yandex.ru',
                            '@ya.ru',
                        ];

                        let is_email = val.indexOf('@') !== -1;

                        let newWhitelist = [];

                        if (is_email) {
                            newWhitelist.push(val);
                        } else {
                            hostList.forEach(function (item, i, arr) {
                                newWhitelist.push(val + item);
                            });
                        }

                        tagify.settings.whitelist.push(...newWhitelist, ...tagify.value);

                        // remove old values
                        tagify.settings.whitelist = [];
                        tagify.settings.whitelist.push(...newWhitelist, ...tagify.value);
                    }
                }
            });

            //
        })()
    </script>
@endpush

@push('plugin-styles')
    {!! Html::style('assets/plugins/tagify/tagify.css') !!}

    <style>
        #emails_notification {
            /*display: block;*/
            width: 100%;
            height: 2rem;
            padding: 0.875rem 1.375rem;
            font-size: 0.75rem;
            font-weight: 400;
            line-height: 1;
            color: #495057;
            background-color: #ffffff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 2px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endpush
