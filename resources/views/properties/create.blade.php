@extends('layouts.app')

@section('title', '| Create Property')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Create New Property</h1>
            <hr>

            {!! Form::open(array('route' => 'properties.store', 'data-parsley-validate'=>'')) !!}

                <fieldset class="form-group required">
                {{ Form::label('company_id', 'Company:', array('class'=>'control-label'))  }}
                <select class="form-control" id="company_id" name="company_id" required="">
                    <option value="" {{(is_null($company_id))? 'selected="selected"':''}}>-- Choose --</option>
                    @forelse($companies as $index => $company)
                        <option value="{{$company->id}}" {{($company->id==$company_id)? 'selected="selected"' : '' }}>{{$company->company_name}}</option>
                    @empty
                        <option value="">There are no companies</option>
                    @endforelse
                </select>
                </fieldset>

                <hr>

                <fieldset class="form-group required">
                {{ Form::label('property_name', 'Property Name:', array('class'=>'control-label'))  }}
                {{ Form::text('property_name',null, array('class' => 'form-control','required'=>'', 'maxlength'=>'255'))}}
                </fieldset>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('first_name', 'First Name:')  }}
                        {{ Form::text('first_name',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('last_name', 'Last Name:')  }}
                        {{ Form::text('last_name',null, array('class' => 'form-control',  'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('address', 'Address:', array('class'=>'control-label'))  }}
                        {{ Form::text('address',null, array('class' => 'form-control','required'=>'',  'maxlength'=>'255'))}}
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

                <hr>

                <div class="row form-group">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            <i class="glyphicon glyphicon-map-marker"></i> Create Property
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