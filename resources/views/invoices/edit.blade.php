@extends('layouts.app')

@section('title', '| Edit Invoice')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/sweetalert.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Invoice</h1>
            <hr>

            <p ><strong>Property:</strong> {{$invoice->workorder->property->property_name}}</p>
            <p ><strong>Address:</strong> {{$invoice->workorder->property->fullAddress()}}</p>
            <p ><strong>Work Order Number:</strong> {{$invoice->workorder->workorder_number}}</p>
            <p ><strong>Work Order Description:</strong><br> {{$invoice->workorder->description}}</p>
            <hr>

            {!! Form::model($invoice, ['route' => ['invoices.update',$invoice->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

                <fieldset class="form-group required">
                {{ Form::label('invoiced_at', 'Date: (YYYY-MM-DD)', array('class'=>'control-label'))  }}
                {{ Form::text('invoiced_at',date('Y-m-d', strtotime($invoice->invoiced_at)), array('class' => 'form-control', 'required'=>'',  'maxlength'=>'255'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('description', 'Description:') }}
                {{ Form::textarea('description',null, array('class' => 'form-control'))}}
                </fieldset>

                <hr>

                <div class="row form-group">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            <i class="glyphicon glyphicon-cloud-upload"></i> Update invoice
                        </button>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                        </fieldset>
                    </div>
                </div>

                {{ Form::hidden('workorder_id', $invoice->workorder->id) }}

            {!! Form::close() !!}

        </div>
    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/sweetalert.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    <script language="javascript">
    $(document).ready(function() {
        $('#invoiced_at').datepicker({
            ignoreReadonly: true,
            todayHighlight:true,
            format: 'yyyy-mm-dd'
        });
    });
    </script>
@endsection