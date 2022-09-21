<div class="form-group">
    <label for="shop_id">Shop*</label>
    {!! Form::select('shop_id', App\Models\Shop::allowed()->get()->pluck('title','id'), null, ['class'=>'form-control', 'id'=>'shop_id','required']) !!}
</div>

<div class="form-group">
    <label for="title">Title*</label>
    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title','required']) !!}
</div>

<div class="form-group">
    <label for="amount">Amount</label>
    {!! Form::number('amount', null, ['class'=>'form-control', 'id'=>'amount']) !!}
</div>

<div class="form-group">
    <label for="description">Description</label>
    {!! Form::textarea('description', null, ['class'=>'form-control','id'=>'description','rows' => 20]) !!}
</div>

{{--<div class="form-group">--}}
{!! Form::hidden('measure', 'штук') !!}
{{--    <label for="title">Ед. измер.</label>--}}
{{--    {!! Form::select('measure', ['штук','кг'], 0, ['class'=>'form-control', 'id'=>'title', 'selected']) !!}--}}
{{--</div>--}}
{{--{!! Form::hidden('user_id', auth()->user()->getAuthIdentifier()) !!}--}}

<div class="form-group">
    <button class="btn btn-sm btn-primary">
        Save
    </button>
</div>
