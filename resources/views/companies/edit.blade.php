@extends('layouts.app')

@section('title', '| Edit Company')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Edit Company</h1>
            <hr>

            {!! Form::model($company, ['route' => ['companies.update',$company->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

                <fieldset class="form-group required">
                {{ Form::label('user_id', 'User:', array('class'=>'control-label'))  }}
                <select class="form-control" id="user_id" name="user_id" required="">
                    <option value="" >-- Choose --</option>
                    @forelse($users as $index => $user)
                        <option value="{{$user->id}}" {{($user->id==$company->user->id)? 'selected="selected"' : '' }}>{{$user->email}}</option>
                    @empty
                        <option value="">There are no users</option>
                    @endforelse
                </select>
                </fieldset>

                <hr>

                <fieldset class="form-group">
                {{ Form::label('company_name', 'Company Name:')  }}
                {{ Form::text('company_name',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('label', 'Label:')  }}
                {{ Form::text('label',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                </fieldset>

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
                            null,
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

                <hr>

                <div class="row form-group">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{-- {{ Form::submit('<i class="fa fa-btn fa-user"></i> Create User', array('class' => 'btn btn-success btn-lg btn-block'))}} --}}
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            <i class="glyphicon glyphicon-briefcase"></i> Update
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