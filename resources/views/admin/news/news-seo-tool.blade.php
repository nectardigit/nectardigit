<div class="row">
    <div class="col-lg-12">
        <h3><strong>SEO Tools</strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
            {{ Form::label('meta_title', 'Meta Title :', ['class' => 'col-sm-12']) }}
            <div class="col-sm-12">
                {{ Form::textarea('meta_title', @$newsInfo->meta_title, ['class' => 'form-control  ', 'id' => 'meta_title', 'rows' => 3, 'placeholder' => 'Meta Title',  'style' => 'width:80%; resize:none']) }}
                @error('meta_title')
                    <span class="help-block error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div
            class="form-group row {{ $errors->has('meta_description') ? 'has-error' : '' }}">
            {{ Form::label('meta_description', 'Meta Description :', ['class' => 'col-sm-12']) }}
            <div class="col-sm-12">
                {{ Form::textarea('meta_description', @$newsInfo->meta_description, ['class' => 'form-control  ', 'id' => 'meta_description', 'rows' => 3, 'placeholder' => 'Meta Description', 'style' => 'width:80%; resize:none']) }}
                @error('meta_description')
                    <span class="help-block error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div
            class="form-group row {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
            {{ Form::label('meta_keyword', 'Meta Keyword :', ['class' => 'col-sm-12']) }}
            <div class="col-sm-12">
                {{ Form::textarea('meta_keyword', @$newsInfo->meta_keyword, ['class' => 'form-control  ', 'id' => 'meta_keyword', 'rows' => 3, 'placeholder' => 'Meta Keyword', 'style' => 'width:80%; resize:none']) }}
                @error('meta_keyword')
                    <span class="help-block error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div
            class="form-group row {{ $errors->has('meta_keyphrase') ? 'has-error' : '' }}">
            {{ Form::label('meta_keyphrase', 'Meta Keyphrase :', ['class' => 'col-sm-12']) }}
            <div class="col-sm-12">
                {{ Form::textarea('meta_keyphrase', @$newsInfo->meta_keyphrase, ['class' => 'form-control  ', 'id' => 'meta_keyphrase', 'rows' => 3, 'placeholder' => 'Meta Keyphrase', 'style' => 'width:80%; resize:none']) }}
                @error('meta_keyphrase')
                    <span class="help-block error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>