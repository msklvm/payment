<div class="form-group">
    {!! Form::label('name','Name*') !!}
    {!! Form::text('name', null ,['class'=>'form-control','required']) !!}
</div>

<div class="form-group">
    {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
</div>
