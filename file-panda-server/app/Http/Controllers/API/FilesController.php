<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JWTAuthController;
use App\Files;
use App\FileType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;

class FilesController extends Controller
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

    /*
        search by title, file_type, user description
    */
    public function search(Request $request)
    {
        // get logged in user
        $JWTAuthController = new JWTAuthController();
        $current_user = $JWTAuthController->getCurrentUser();

        // get query params to search
        $text = $request->text;
        $file_type = $request->file_type;

        return Files::where(function($query) use ($text, $file_type) {
            return $query->where('title', 'LIKE', "%$text%")
            ->orWhere('description', 'LIKE', "%$text%");
        })->where(function($query) use ($text, $file_type) {
            if($file_type) {
                return $query->where('file_type_id', $file_type);
            }
        })->where('user_id', $current_user->id)->get();
    }

    public function uploadMp4(Request $request, Response $response)
    {
        $JWTAuthController = new JWTAuthController();
        $files = new Files();
        $current_user = $JWTAuthController->getCurrentUser();

        // Upload Files handler
        $thumbnailName = $current_user->id . '' . time();
        $thumbnailSmallName = $thumbnailName . '-small.' . $request->thumbnail->extension();
        $thumbnailName = $thumbnailName.'.'.$request->thumbnail->extension();
        $videoName = $current_user->id . '' . time() . '.' . $request->video->extension(); 
   
        // Move uploaded files to specific path
        $request->video->move(public_path('storage/uploads/videos'), $videoName);
        $request->thumbnail->move(public_path('storage/uploads/thumbnails'), $thumbnailName);

        
        $img = Image::make('storage/uploads/thumbnails/'.$thumbnailName);

        // Create small thumbnail for mobile search
        $img->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/uploads/thumbnails/').$thumbnailSmallName);
        
        // Add Record to files table
        $fileTypeId = FileType::firstWhere('extension', 'MP4')->id;

        $files->title = $request->title;
        $files->description = $request->description;
        $files->file_name = public_path('storage/uploads/videos/').$videoName;
        $files->thumbnail =  public_path('storage/uploads/thumbnails/').$thumbnailName;
        $files->thumbnail_small  = public_path('storage/uploads/thumbnails/').$thumbnailSmallName;
        $files->user_id = $current_user->id;
        $files->file_type_id = $fileTypeId;

        $files->save();

        return ['Message' => 'Successfully Uploaded'];
    }

    public function uploadJpg(Request $request, Response $response)
    {
        $JWTAuthController = new JWTAuthController();
        $files = new Files();
        $current_user = $JWTAuthController->getCurrentUser();

        // Upload Files handler
        $fileName = $current_user->id . '' . time();
        $thumbnailSmallName = $fileName . '-small.' . $request->image->extension(); 
        $fileName = $fileName . '.' . $request->image->extension();

        
        // Move uploaded files to specific path
        $request->image->move(public_path('storage/uploads/jpgs/'), $fileName);

        // Create small thumbnail for mobile search
        $img = Image::make(public_path('storage/uploads/jpgs/').$fileName);
        
        $img->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/uploads/thumbnails/').$thumbnailSmallName);
        
        // Add Record to files table
        $fileTypeId = FileType::firstWhere('extension', 'JPG')->id;

        $files->title = $request->title;
        $files->description = $request->description;
        $files->file_name = public_path('storage/uploads/jpgs/') . $fileName;
        $files->thumbnail_small  = public_path('storage/uploads/thumbnails/') . $thumbnailSmallName;
        $files->user_id = $current_user->id;
        $files->file_type_id = $fileTypeId;

        $files->save();

        return ['Message' => 'Successfully Uploaded'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
