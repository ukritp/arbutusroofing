@extends('layouts.app')

@section('title', '| Edit Users | Password')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Edit User - Password</h1>
            <hr>

            {!! Form::model($user, ['route' => ['users.update_password',$user->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

                <fieldset class="form-group required">
                {{ Form::label('current_password', 'Current Password:', array('class'=>'control-label'))  }}
                {{ Form::password('current_password', ['class' => 'form-control','required'=>'','minlength'=>'6'])}}
                </fieldset>

                <fieldset class="form-group required">
                {{ Form::label('new_password', 'New Password:', array('class'=>'control-label'))  }}
                {{ Form::password('new_password', ['class' => 'form-control','required'=>'','minlength'=>'6'])}}
                </fieldset>

                <fieldset class="form-group required">
                {{ Form::label('new_password_confirmation', 'Confirm Password:', array('class'=>'control-label'))  }}
                {{ Form::password('new_password_confirmation', ['class' => 'form-control','required'=>'','minlength'=>'6'])}}
                </fieldset>

                <hr>

                <div class="row form-group">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{-- {{ Form::submit('<i class="fa fa-btn fa-user"></i> Create User', array('class' => 'btn btn-success btn-lg btn-block'))}} --}}
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            <i class="fa fa-btn fa-user"></i> Update
                        </button>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                        </fieldset>
                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection