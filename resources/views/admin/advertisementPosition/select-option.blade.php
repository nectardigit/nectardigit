{{ Form::label('position', 'Position :*', ['class' => 'col-sm-3']) }}
<div class="col-sm-9">

    {{ Form::select('position', @$positions, @$position, ['class' => 'form-control  ', 'id' => 'position', 'required' => true, "placeholder" => "Advertisement Position", 'style' => 'width:80%']) }}

    @error('position')
        <span class="help-block error">{{ $message }}</span>
    @enderror
</div>
