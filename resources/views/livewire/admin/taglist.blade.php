<div wire:ignore.self class="modal fade" id="modal-tag" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Tag</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-12">
                        {{-- <div class="form-group row">
                            {!! Form::label('en_title', 'Tag title (in English)', ['class' => 'col-sm-4']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('en_title', '', ['wire:model.defer' => 'en_title', 'class' =>
                                'form-control', 'placeholder' => 'Enter tag name ', 'style' => 'width:80%']) !!}
                                @error('en_title')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div> --}}
                        {{-- <div class=" form-group row">
                            {!! Form::label('np_title', 'Tag title (in Nepali)', ['class' => 'col-sm-4']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('np_title', '', ['wire:model.defer' => 'np_title', 'class' =>
                                'form-control', 'placeholder' => 'Enter tag name ', 'style' => 'width:80%']) !!}

                                @error('np_title')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        
                    </div>
                
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-success" wire:click="storeTag">Save Tag</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
{{-- <button type="button" class="btn btn-primary"   id="addTagModal" wire:click="addTag">
    Add Tag
</button> --}}
{{-- {{$selected_tags}} --}}
<div class="form-group row {{ $errors->has('tags') ? 'has-error' : '' }}">
    {!!  Html::decode(Form::label('tags', '<i class="fas fa-tags"></i> News Hash Tags :*', ['class' => 'col-sm-12'])) !!}
    <div class="col-sm-12">
        {{ Form::select('tags[]', $tags, @$selected_tags, ['class' => 'form-control  ', "wire:model.defer" => "tags",  'id' => 'tags', 'multiple' => true,]) }}
        @error('tags')
            <span class="help-block error">{{ $message }}</span>
        @enderror
    </div>
    

</div>

<script>
    
</script>
