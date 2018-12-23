<?php

namespace App\Http\Controllers\ManageFile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class Image extends Controller
{
    public function get_image_book($book_name){
        try{
            $image = Storage::disk('book_image')->get($book_name);
            if(is_null($image)){
                return new Response(Storage::disk('book_image')->get('book-default.png'), 200);
            }else{
                return new Response($image, 200);
            }
        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function get_image_document($document_name){
        try{
            $image = Storage::disk('study_document_image')->get($document_name);
            if(is_null($image)){
                return new Response(Storage::disk('study_document_image')->get('book-default.png'), 200);
            }else{
                return new Response($image, 200);
            }
        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function get_image_exam($exam_name){
        try{
            $image = Storage::disk('exam_image')->get($exam_name);
            return new Response($image, 200);
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
