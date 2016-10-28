@extends('layouts.app')

@section('title', '| Work Order')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/typeaheadjs.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-11 col-md-offset-1">
        <div class="panel panel-default panel-mobile">
            <div class="panel-heading">ALL WORK ORDERS</div>
            <div class="panel-body">
                <div class="row">
                {!! Form::open(array('route' => 'workorders.search','method'=>'get', 'data-parsley-validate'=>'')) !!}
                <div class="col-md-6 form-search form-group-ajax">
                    <div class="input-group">
                        <input type="text" name="keyword" id="keyword" class="form-control search-txtbx keyword" placeholder="Search" maxlegnth="255" required>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Company <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                @foreach($companies as $company)
                                <li><a class="company-dropdown" data-value="{{$company->company_name}}">{{$company->company_name}}</a></li>
                                @endforeach
                            </ul>
                            <button class="btn btn-group btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div><!-- /btn-group -->

                    </div>
                    <input type="hidden" id="data-route" value="{{url('workorders')}}">
                </div>
                {!! Form::close() !!}
                </div>


                @if(!is_null(Request::get('keyword')))
                <br>
                <p><strong>Found: {{count($workorders)}} Results for "{{Request::get('keyword')}}"</strong></p>
                @endif
            </div>

            <!-- Table -->
            <table class="table table-hover table-hover-blue mobile-table">
                <thead>
                    <th>Property</th>
                    <th>Number</th>
                    <th>Tenant</th>
                    <th class="text-right" style="width:18%;">Action</th>
                </thead>
                <tbody>
                    @forelse($workorders as $index => $workorder)
                        <tr>
                            <td data-label="Property">{{$workorder->property->property_name}}</td>
                            <td data-label="Number">{{(!empty($workorder->workorder_number))?$workorder->workorder_number:'-'}}</td>
                            <td data-label="Tenant">{{$workorder->tenant_first_name.' '.$workorder->tenant_last_name}}</td>
                            <td data-label="Action" class="text-right">
                            {!! Html::linkRoute('workorders.show', 'View', array($workorder->id), array('class'=>'btn btn-default btn-sm'))!!}
                            {!! Html::linkRoute('workorders.edit', 'Edit', array($workorder->id), array('class'=>'btn btn-default btn-sm') ) !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center no-item">There are no work orders</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/sweetalert.min.js') !!}
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js')!!}
    {!! Html::script('js/app.typeahead.js') !!}
    @include('sweet::alert')
@endsection
