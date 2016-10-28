
<div class="pdf-list-div">
    <table class="table table-hover table-hover-blue mobile-table">
        <thead>
            <th style="width:10%;">Invoice</th>
            <th style="width:18%;">Issued Date</th>
            <th>Description</th>
            <th class="text-right" style="width:15%;">Action</th>
        </thead>
        <tbody>
            @set('user', \Auth::user()->roles()->first()->name)
            @forelse($workorder->invoices as $index => $invoice)
                @set('path','/uploads/'.$workorder->property->company->id.'/'.$workorder->property->id.'/'.$workorder->id.'/pdfs/'.$invoice->name)
                <tr>
                    <td data-label="Invoice">{{$invoice->id}}</td>
                    <td data-label="Issued Date"><a href="{{$path}}" target="_blank">{{$invoice->invoiced_at}}</a></td>
                    <td data-label="Description">{{$invoice->description}}</td>
                    <td data-label="Action" class="text-right">
                    <a class="thumb-link" title="download" data-toggle="tooltip" data-placement="left" href="{{route('invoices.download',$invoice->id)}}"><i class="glyphicon glyphicon-save"></i></a>
                    @if($user === 'Admin' || $user === 'Worker')
                    |
                    <a href="{{route('invoices.edit',$invoice->id)}}" class="edit-pdf-link thumb-link" title="edit" data-toggle="tooltip" data-placement="top"
                        data-invoiced-at="{{$invoice->invoiced_at}}"
                        data-description="{{$invoice->description}}"
                        data-token="{{csrf_token()}}"
                        data-route="{{route('invoices.edit',$invoice->id)}}"
                        data-id="{{$invoice->id}}" >
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    |
                    <a class="delete-pdf-link thumb-link" title="delete" data-toggle="tooltip" data-placement="right"
                        data-token="{{csrf_token()}}"
                        data-route="{{route('invoices.destroy',$invoice->id)}}""
                        data-id="{{$invoice->id}}" >
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center no-item">There are no invoice</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>