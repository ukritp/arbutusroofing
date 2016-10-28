<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UploadImageRequest;

use App\Workorder;
use App\UploadImage;

use Alert;
use Session;
use Carbon\Carbon;
use File;

class UploadImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function download($id)
    {
        $image = UploadImage::find($id);
        $path = $this->getUploadPath($image->workorder);
        $destination_path = public_path($path.$image->name);

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
        return view('uploadimages.create')->withWorkorder($workorder);
    }

    /**
     * http://itsolutionstuff.com/post/laravel-5-fileimage-upload-example-with-validationexample.html
     * http://tutsnare.com/upload-multiple-files-in-laravel/
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        $workorder = Workorder::find($request->workorder_id);
        $files = $request->file('images');

        // Making counting of uploaded images
        $file_count = count($files);
        // start count how many uploaded
        $upload_count = 0;

        foreach($files as $index => $image){
            $original_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();

            $path = $this->getUploadPath($workorder);

            $name = Carbon::now().'-'.$index;
            $destination_path = public_path($path);

            // echo $destination_path.$name.'.'.$extension.'<br>';

            $image->move($destination_path, $name.'.'.$extension);

            $upload = new UploadImage;
            $upload->name         = $name.'.'.$extension;
            $upload->description  = $request->description;
            $upload->workorder_id = $request->workorder_id;
            $upload->save();

            $upload_count ++;
        }

        if($upload_count == $file_count){
            Session::flash('success','The Images were successfully uploaded');
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
        //
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
            'description' => 'required',
        ));

        $image = UploadImage::find($id);
        $image->description = $request->description;
        $image->save();

        // $return_json['status'] = $image->id;
        // echo json_encode($return_json);

        $workorder_id = $image->workorder_id;
        $workorder = Workorder::find($workorder_id);
        return view('uploadimages._imagethumbnail')->withWorkorder($workorder);
    }

    /**
     * http://stackoverflow.com/questions/22135706/laravel-4-update-div-using-ajax
     * http://laravel.io/forum/03-04-2014-reloadingchanging-the-contents-of-a-div
     * http://laravel.io/forum/06-21-2016-how-to-refresh-a-page-without-refreshing-master-page
     * http://stackoverflow.com/questions/33842735/how-to-delete-file-from-public-folder-in-laravel-5-1
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = UploadImage::find($id);
        $workorder_id = $image->workorder_id;

        $image->delete();

        // $return_json['path'] = $destination_path;
        // $return_json['status'] = 'success';
        // echo json_encode($return_json);

        $workorder = Workorder::find($workorder_id);
        return view('uploadimages._imagethumbnail')->withWorkorder($workorder);
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
        $path = 'uploads/'.$workorder->property->company->id.'/'.$workorder->property->id.'/'.$workorder->id.'/'.'images/';
        return $path;
    }
}
