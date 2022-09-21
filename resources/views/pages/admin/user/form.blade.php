<div class="form-group">
    {!! Form::label('name','Name*') !!}
    {!! Form::text('name', null ,['class'=>'form-control','required']) !!}
</div>

<div class="form-group">
    {!! Form::label('email','Email*') !!}
    {!! Form::email('email', null ,['class'=>'form-control','required']) !!}
</div>

<div class="form-group">
    {!! Form::label('roles','Roles*') !!}
    {!!  Form::select('roles[]', $roles->pluck('name','id'), null, ['multiple','class'=>'form-control']); !!}
</div>

<div class="form-group">
    {!! Form::label('permissions','Permissions*') !!}
    {!!  Form::select('permissions[]', $permissions->pluck('title','pid'), null, ['multiple','class'=>'form-control']); !!}
</div>

@if($pass)
    @includeIf('pages.admin.user.password')
@endif

<div class="form-group">
    {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
</div>
