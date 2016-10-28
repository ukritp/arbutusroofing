<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      @forelse($workorder->images as $index => $image)
        <li data-target="#myCarousel" data-slide-to="{{$index}}" {{($index==0)?'class="active"':''}}></li>
      @empty
      @endforelse
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      @forelse($workorder->images as $index => $image)
          @set('path','/uploads/'.$workorder->property->company->id.'/'.$workorder->property->id.'/'.$workorder->id.'/images/'.$image->name)

          <div class="item {{($index==0)?'active':''}}">
            <a href="{{$path}}">
              <img src="{{$path}}" alt="{{$workorder->property->property_name}}" class="img-responsive">
            </a>
            <div class="carousel-caption">
              {{-- <h3>Chania</h3> --}}
              <p>{{$image->description}}</p>
            </div>
          </div>
      @empty
      @endforelse

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>