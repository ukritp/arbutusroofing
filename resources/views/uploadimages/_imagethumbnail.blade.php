
<div class="row image-thumbnail-div">
    @forelse($workorder->images as $index => $image)

        @set('path','/uploads/'.$workorder->property->company->id.'/'.$workorder->property->id.'/'.$workorder->id.'/images/'.$image->name)
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 thumb">
            <a class="thumbnail thumbnail-popup"
                data-path="{{$path}}"
                data-description="{{$image->description}}"
                data-token="{{csrf_token()}}"
                data-route="{{route('uploadimages.update',$image->id)}}""
                data-id="{{$image->id}}">
                <img class="img-responsive" src="{{$path}}" alt="{{$image->workorder->property->property_name}}">
            </a>

            <a class="thumb-link" href="{{route('uploadimages.download',$image->id)}}"><i class="glyphicon glyphicon-save"></i> Download</a>
            |
            <a class="delete-thumbnail thumb-link"
                data-token="{{csrf_token()}}"
                data-route="{{route('uploadimages.destroy',$image->id)}}""
                data-id="{{$image->id}}" >
                <i class="glyphicon glyphicon-trash"></i> Delete
            </a>
        </div>
        <div class="clear-div"></div>
    @empty
    @endforelse
</div>
