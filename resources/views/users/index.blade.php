@extends('layouts.app')

@section('title', '| Users')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/typeaheadjs.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-11 col-md-offset-1">
        <div class="panel panel-default panel-mobile">
            <div class="panel-heading">ALL USERS</div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 form-group-ajax">
                    {!! Form::open(array('route' => 'users.search','method'=>'get', 'data-parsley-validate'=>'')) !!}
                    <div class="input-group">
                        <input type="text" name="keyword" id="keyword" class="form-control keyword" placeholder="Search" maxlegnth="255" required>
                        <input type="hidden" id="data-route" value="{{url('users')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-md" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>

                @if(!is_null(Request::get('keyword')))
                <br>
                <p><strong>Found: {{count($users)}} Results for "{{Request::get('keyword')}}"</strong></p>
                @endif
            </div>

            <!-- Table -->
            <table class="table table-hover table-hover-blue mobile-table">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="td-mobile">Phone</th>
                    <th class="td-mobile">Status</th>
                    <th class="text-right" style="width:16%;">Action</th>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td data-label="Name">{{$user->first_name.' '.$user->last_name}}</td>
                            <td data-label="Email">{{$user->email}}</td>
                            <td data-label="Phone" class="td-mobile">{{$user->formatPhone()}}</td>
                            <td data-label="Status" class="td-mobile">
                            @if($user->status)
                                <i class="glyphicon glyphicon-ok"></i>
                            @else
                                <i class="glyphicon glyphicon-remove"></i>
                            @endif
                            </td>
                            <td data-label="Action" class="text-right">
                            {!! Html::linkRoute('users.show', 'View', array($user->id), array('class'=>'btn btn-default btn-sm'))!!}
                            {!! Html::linkRoute('users.edit', 'Edit', array($user->id), array('class'=>'btn btn-default btn-sm') ) !!}
                            {{-- <a href="{{route('users.show',$user->id)}}" class="" title="View" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a> |
                            <a href="{{route('users.edit',$user->id)}}" class="" title="edit" data-toggle="tooltip" data-placement="right">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center no-item">There are no users</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="text-center"> {!!$users->render();!!}</div>
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
