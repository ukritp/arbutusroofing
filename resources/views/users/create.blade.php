@extends('layouts.app')

@section('title', '| Create Users')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Create New User</h1>
            <hr>

            {!! Form::open(array('route' => 'users.store', 'data-parsley-validate'=>'')) !!}

                <fieldset class="form-group required">
                {{ Form::label('email', 'Email: (Username)', array('class'=>'control-label'))  }}
                {{ Form::text('email',null, array('class' => 'form-control','required'=>'', 'maxlength'=>'255', 'data-parsley-type'=>'email'))}}
                </fieldset>

                <fieldset class="form-group required">
                {{ Form::label('password', 'Password:', array('class'=>'control-label'))  }}
                {{ Form::password('password', ['class' => 'form-control','required'=>'','minlength'=>'6'])}}
                </fieldset>

                <fieldset class="form-group required">
                {{ Form::label('password_confirmation', 'Confirm Password:', array('class'=>'control-label'))  }}
                {{ Form::password('password_confirmation', ['class' => 'form-control','required'=>'','minlength'=>'6'])}}
                </fieldset>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('first_name', 'First Name:', array('class'=>'control-label'))  }}
                        {{ Form::text('first_name',null, array('class' => 'form-control', 'required'=>'', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('last_name', 'Last Name:', array('class'=>'control-label'))  }}
                        {{ Form::text('last_name',null, array('class' => 'form-control', 'required'=>'', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('address', 'Address:')  }}
                        {{ Form::text('address',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('city', 'City:')  }}
                        {{ Form::text('city',null, array('class' => 'form-control', 'maxlength'=>'50'))}}
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('province', 'Province:')  }}
                        {{ Form::select('province', array(
                            'BC' => 'British Columbia',
                            'AB' => 'Alberta',
                            'MB' => 'Manitoba',
                            'ON' => 'Ontario',
                            'QC' => 'Quebec',
                            'SK' => 'Saskatchewan',
                            'NS' => 'Nova Scotia',
                            'NB' => 'New Brunswick',
                            'PE' => 'Prince Edward Island',
                            'NL' => 'Newfoundland and Labrador'),
                            'BC',
                            array('class' => 'form-control')
                        )}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('postalcode', 'Postal Code:')  }}
                        {{ Form::text('postalcode',null, array('class' => 'form-control', 'maxlength'=>'6'))}}
                        </fieldset>
                    </div>
                </div>

                <fieldset class="form-group">
                {{ Form::label('phone_number', 'Phone Number:')  }}
                {{ Form::text('phone_number',null, array(
                    'class'             => 'form-control',
                    //'required'          =>'',
                    'minlength'         =>'10' ,
                    'maxlength'         =>'10',
                    'data-parsley-type' =>'digits'
                ))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('role', 'Role:')  }}
                <br>
                <label class="radio-inline">
                    <input type="radio" name="role" id="role1" value="1"> Administrator
                </label>
                <label class="radio-inline">
                    <input type="radio" name="role" id="role2" value="2" checked> Field Worker
                </label>
                <label class="radio-inline">
                    <input type="radio" name="role" id="role3" value="3"> Client
                </label>
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('status', 'Status:')  }}
                {{ Form::select('status', array(
                    '1' => 'Enabled',
                    '0' => 'Disabled'),
                    '1',
                    array('class' => 'form-control')
                )}}
                </fieldset>

                <hr>

                <div class="row form-group">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{-- {{ Form::submit('<i class="fa fa-btn fa-user"></i> Create User', array('class' => 'btn btn-success btn-lg btn-block'))}} --}}
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            <i class="fa fa-btn fa-user"></i> Create User
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