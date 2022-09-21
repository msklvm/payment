<div class="form-group">
    <div class="col-sm-10 ">
        {!! Form::label('password','Пароль*') !!}
        {!! Form::password('password', ['class'=>'form-control','required']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10 ">
        {!! Form::label('password_confirmation','Повторите пароль*') !!}
        {!! Form::password('password_confirmation', ['class'=>'form-control','required']) !!}
    </div>
</div>
