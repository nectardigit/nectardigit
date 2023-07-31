@extends('layouts.admin')
@push('scripts')
    <script>
        $("#select_all").change(function(){
            $(".name").prop('checked', $(this).prop("checked"));
        });
        $('.name[]').change(function(){
            if(false == $(this).prop("checked")){
                $("#select_all").prop('checked', false);
            }
            if ($('.checkbox:checked').length == $('.checkbox').length ){
                $("#select_all").prop('checked', true);
            }
        });
    </script>
@endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Role</h3>
                    <div class="card-tools">
                        <a href="{{ route('roles.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($role_data))
                          {{Form::open(['url'=>route('roles.update',$role_data->id),'files'=>true,'class'=>'form'])}}
                          @method('put')
                          <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            {{Form::label('name','Roles Name: *',['class'=>'col-sm-3'])}}
                            <div class="col-sm-9">
                                {{Form::text('name',@$role_data->name,['class'=>'form-control form-control','id'=>'name','placeholder'=>'Admin or User or Writer','required'=>true,'style'=>'width:80%','readonly'])}}
                                @error('name')
                                <span class="help-block error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                      @else
                          {{Form::open(['url'=>route('roles.store'),'files'=>true,'class'=>'form'])}}
                          <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            {{Form::label('name','Roles Name: *',['class'=>'col-sm-3'])}}
                            <div class="col-sm-9">
                                {{Form::text('name',@$role_data->name,['class'=>'form-control form-control','id'=>'name','placeholder'=>'Admin or User or Writer','required'=>true,'style'=>'width:80%'])}}
                                @error('name')
                                <span class="help-block error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                      @endif

                      
                      <div class="form-group row {{ $errors->has('permission') ? 'has-error' :'' }}">
                          {{Form::label('permission','Permission:',['class'=>'col-sm-3'])}}
                          <div class="col-sm-9">
                              @if($permission->count()>0)
                              <div>
                                  {{Form::checkbox('select_all','',false,['id'=>'select_all'])}}
                                  <label for="">Select All</label>
                              </div>
                              <div class="row">
                                  @foreach($permission as $key=>$value)
                                      <div class="col-md-3">
                                          <div>
                                          @if($key%4 == 0)
                                              <strong class="d-inline-block m-b-5">Manage {{ucfirst(explode('-',$value->name)[0])}}:</strong>
                                          @else
                                              <strong class="d-inline-block m-b-5">&nbsp;</strong>
                                          @endif
                                          </div>
                                        <div>
                                          <label>{{Form::checkbox('permission[]', $value->id, @in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name']) }} {{ucfirst(str_replace('-',' ',$value->name))}}</label>
                                        </div>
                                    </div>
                                  @endforeach
                              </div>
                              @error('permission')
                              <span class="help-block error">{{$message}}</span>
                              @enderror
                              @else
                              <p class="">No Permission Found in Database</p>
                              @endif
                          </div>
                      </div>

                      <div class="form-group row">
                          {{Form::label('','',['class'=>'col-sm-3'])}}
                          <div class="col-sm-9">
                              {{Form::button("<i class='fa fa-paper-plane'></i> Submit",['class'=>'btn btn-success btn-flat','type'=>'submit'])}}
                              {{Form::button("<i class='fa fas fa-sync-alt'></i> Reset",['class'=>'btn btn-danger btn-flat','type'=>'reset'])}}
                          </div>
                      </div>
                      {{Form::close()}}
                </div>
            </div>
        </div>
    </section>
@endsection