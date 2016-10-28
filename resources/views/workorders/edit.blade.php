@extends('layouts.app')

@section('title', '| Edit Work Order')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Edit Work Order</h1>
            <hr>

            {!! Form::model($workorder, ['route' => ['workorders.update',$workorder->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

                <fieldset class="form-group required">
                {{ Form::label('property_id', 'Property:', array('class'=>'control-label'))  }}
                <select class="form-control" id="property_id" name="property_id" required="">
                    <option value="">-- Choose --</option>
                    @forelse($properties as $index => $property)
                        <option value="{{$property->id}}" {{($property->id==$workorder->property->id)? 'selected="selected"' : '' }}>{{$property->property_name}}</option>
                    @empty
                        <option value="">There are no properties</option>
                    @endforelse
                </select>
                </fieldset>

                <hr>

                <fieldset class="form-group">
                {{ Form::label('workorder_number', 'Work Order Number:')  }}
                {{ Form::text('workorder_number',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                </fieldset>

                <fieldset class="form-group required">
                {{ Form::label('description', 'Description:', array('class'=>'control-label'))  }}
                {{ Form::textarea('description',null, array('class' => 'form-control','required'=>''))}}
                </fieldset>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('tenant_first_name', 'Tenant First Name:')  }}
                        {{ Form::text('tenant_first_name',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('tenant_last_name', 'Tenant Last Name:')  }}
                        {{ Form::text('tenant_last_name',null, array('class' => 'form-control',  'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                </div>

                <fieldset class="form-group">
                {{ Form::label('tenant_phone_number', 'Tenant Phone Number:')  }}
                {{ Form::text('tenant_phone_number',null, array(
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
                            <i class="glyphicon glyphicon-wrench"></i> Update
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