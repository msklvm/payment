<div class="form-group">
    <label for="api_login">Template</label>
    {!! Form::textarea('html', $html, ['class'=>'form-control','rows'=>30, 'id'=>'template']) !!}
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
</div>
