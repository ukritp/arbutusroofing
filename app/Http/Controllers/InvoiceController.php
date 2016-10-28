<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\InvoiceRequest;

use App\Workorder;
use App\Invoice;

use Alert;
use Session;
use Carbon\Carbon;
use File;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function download($id)
    {
        $invoice = Invoice::find($id);
        $path = $this->getUploadPath($invoice->workorder);
        $destination_path = public_path($path.$invoice->name);

        return response()->download($destination_path);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $workorder = Workorder::find($id);
        return view('invoices.create')->withWorkorder($workorder);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        $workorder = Workorder::find($request->workorder_id);
        $files = $request->file('files');

        // Making counting of uploaded images
        $file_count = count($files);
        // start count how many uploaded
        $upload_count = 0;

        foreach($files as $index => $pdf){
            $original_name = $pdf->getClientOriginalName();
            $extension = $pdf->getClientOriginalExtension();

            $path = $this->getUploadPath($workorder);

            $name = Carbon::now().'-'.$index;
            $destination_path = public_path($path);

            $pdf->move($destination_path, $name.'.'.$extension);

            $invoice = new Invoice;
            $invoice->name         = $name.'.'.$extension;
            $invoice->description  = $request->description;
            $invoice->invoiced_at  = $request->invoiced_at;
            $invoice->workorder_id = $request->workorder_id;
            $invoice->save();

            $upload_count ++;
        }

        if($upload_count == $file_count){
            Session::flash('success','The PDF were successfully created');
        }else{
            Session::flash('error','Error: something went wrong');
        }

        return redirect()->route('workorders.show',$request->workorder_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.edit')->withInvoice($invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'invoiced_at' => 'required',
            'description' => '',
        ));

        $invoice = Invoice::find($id);
        $invoice->description  = $request->description;
        $invoice->invoiced_at  = $request->invoiced_at;
        $invoice->workorder_id = $request->workorder_id;
        $invoice->save();

        return redirect()->route('workorders.show',$request->workorder_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $workorder_id = $invoice->workorder_id;

        $invoice->delete();

        // $return_json['path'] = $destination_path;
        // $return_json['status'] = 'success';
        // echo json_encode($return_json);

        $workorder = Workorder::find($workorder_id);
        return view('invoices._pdf')->withWorkorder($workorder);
    }

    /**
     *
     * Get Upload Path so the code is DRY
     *
     * @param  int  $workorder (model object)
     * @return \Illuminate\Http\Response
     */
    public function getUploadPath($workorder)
    {
        // Path = "uploads/company_id/property_id/workorder_id/..."
        $path = 'uploads/'.$workorder->property->company->id.'/'.$workorder->property->id.'/'.$workorder->id.'/'.'pdfs/';
        return $path;
    }
}
