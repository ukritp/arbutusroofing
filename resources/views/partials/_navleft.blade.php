
<div class="logo ">
    <a href="{{route('home')}}">
    {{ Html::image('images/logo.png','a picture', array('class' => 'img-responsive center-block'))}}
    </a>
</div>
<hr>

<nav class="navbar navbar-default navbar-left-stacked" role="navigation">

    <div class="navbar-header">
        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#left-navbar-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="left-navbar-collapse">
        <ul class="nav nav-pills nav-stacked">


        @if (Auth::guest())
            <li role="presentation" class="{{Request::is('login*') ? "active" : ""}}" ><a href="{{ url('/login') }}">Login</a></li>
            {{-- <li role="presentation" class="{{Request::is('register*') ? "active" : ""}}" ><a href="{{ url('/register') }}">Register</a></li> --}}
        @else
            @set('user', \Auth::user()->roles()->first()->name)

            <li role="presentation" class="nav-stacked-parent {{Request::is('home*') ? "active" : ""}}" >
                @if($user === 'Client')
                <a href="{{ route('companies.client',Auth::user()->id) }}">Home</a>
                @else
                <a href="{{ route('home') }}">Home</a>
                @endif
            </li>
            {{--
             /* EXAMPLE: http://www.bootply.com/render/hJ6U0WphRy
             /* ICON: http://www.bootstrapicons.com/
            --}}

            @if($user === 'Admin')
            {{-- User Nav --}}
            <li role="presentation" class="nav-header nav-stacked-parent {{Request::is('users*') ? "active" : ""}}">
                <a href="#" class="{{Request::is('users*') ? "collapsed" : ""}}"
                    data-toggle="collapse"
                    data-target="#userMenu"
                    aria-expanded="{{Request::is('users*') ? "true" : "false"}}" >
                    Users <i class="glyphicon glyphicon-chevron-{{Request::is('users*') ? "down" : "right"}}"></i>
                </a>
                <ul class="nav nav-stacked collapse {{Request::is('users*') ? "in" : ""}}" id="userMenu"
                    aria-expanded="{{Request::is('users*') ? "true" : "false"}}"
                    {{Request::is('users*') ? 'style="height: 0px;"' : ''}} >
                    <li><a href="{{ url('users') }}"><i class="glyphicon glyphicon-minus"></i>  All User</a></li>
                    <li><a href="{{ route('users.create') }}"><i class="glyphicon glyphicon-minus"></i>  Create User</a></li>
                </ul>
            </li>

            {{-- Company Nav --}}
            <li role="presentation" class="nav-header nav-stacked-parent {{Request::is('companies*') ? "active" : ""}}">
                <a href="#" class="{{Request::is('companies*') ? "collapsed" : ""}}"
                    data-toggle="collapse"
                    data-target="#companyMenu"
                    aria-expanded="{{Request::is('companies*') ? "true" : "false"}}" >
                    Companies <i class="glyphicon glyphicon-chevron-{{Request::is('companies*') ? "down" : "right"}}"></i>
                </a>
                <ul class="nav nav-stacked collapse {{Request::is('companies*') ? "in" : ""}}" id="companyMenu"
                    aria-expanded="{{Request::is('companies*') ? "true" : "false"}}"
                    {{Request::is('companies*') ? 'style="height: 0px;"' : ''}} >
                    <li><a href="{{ url('companies') }}"><i class="glyphicon glyphicon-minus"></i>  All Companies</a></li>
                    <li><a href="{{ route('companies.create') }}"><i class="glyphicon glyphicon-minus"></i>  Create Company</a></li>
                </ul>
            </li>
            @endif

            @if($user === 'Admin')
            {{-- Property Nav --}}
            <li role="presentation" class="nav-header nav-stacked-parent {{Request::is('properties*') ? "active" : ""}}">
                <a href="#" class="{{Request::is('properties*') ? "collapsed" : ""}}"
                    data-toggle="collapse"
                    data-target="#propertyMenu"
                    aria-expanded="{{Request::is('properties*') ? "true" : "false"}}" >
                    Properties <i class="glyphicon glyphicon-chevron-{{Request::is('properties*') ? "down" : "right"}}"></i>
                </a>
                <ul class="nav nav-stacked collapse {{Request::is('properties*') ? "in" : ""}}" id="propertyMenu"
                    aria-expanded="{{Request::is('properties*') ? "true" : "false"}}"
                    {{Request::is('properties*') ? 'style="height: 0px;"' : ''}} >
                    <li><a href="{{ url('properties') }}"><i class="glyphicon glyphicon-minus"></i>  All Properties</a></li>
                    <li><a href="{{ route('properties.create') }}"><i class="glyphicon glyphicon-minus"></i>  Create Property</a></li>
                </ul>
            </li>
            @endif

            @if($user === 'Admin' || $user === 'Worker')
            {{-- Workorder Nav --}}
            <li role="presentation" class="nav-header nav-stacked-parent {{Request::is('workorders*') ? "active" : ""}}">
                <a href="#" class="{{Request::is('workorders*') ? "collapsed" : ""}}"
                    data-toggle="collapse"
                    data-target="#workorderMenu"
                    aria-expanded="{{Request::is('workorders*') ? "true" : "false"}}" >
                    Work Orders <i class="glyphicon glyphicon-chevron-{{Request::is('workorders*') ? "down" : "right"}}"></i>
                </a>
                <ul class="nav nav-stacked collapse {{Request::is('workorders*') ? "in" : ""}}" id="workorderMenu"
                    aria-expanded="{{Request::is('workorders*') ? "true" : "false"}}"
                    {{Request::is('workorders*') ? 'style="height: 0px;"' : ''}} >
                    <li><a href="{{ url('workorders') }}"><i class="glyphicon glyphicon-minus"></i>  All Work Order</a></li>
                    <li><a href="{{ route('workorders.create') }}"><i class="glyphicon glyphicon-minus"></i>  Create Work Order</a></li>
                </ul>
            </li>
            @endif
        @endif
        </ul>
    </div>

</nav>