<?php

namespace App\Http\Controllers\ManageFile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileExam extends Controller
{
    /**
     * get file pdf exam from storage
     *
     * @param $file_name
     * @return \Exception|Response
     */
    public function get_file_exam_pdf($file_name){
        try{
            $contents = Storage::disk('exam')->get($file_name);
            return response($contents, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return view('errors.404');
        }
    }

    /**
     * get file pdf explain from storage
     *
     * @param $file_name
     * @return \Exception|Response
     */
    public function get_file_explain_pdf($file_name){
        try{
            $contents = Storage::disk('explain')->get($file_name);
            return response($contents, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return view('errors.404');
        }
    }

    /**
     * get file pdf exam from storage
     *
     * @param $file_name
     * @return \Exception|Response
     */
    public function get_file_exam_pdf_for_user($file_name){
        try{
            $contents = Storage::disk('exam')->get($file_name);
            return response($contents, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * get file pdf explain from storage for user
     *
     * @param $file_name
     * @return \Exception|Response
     */
    public function get_file_explain_pdf_for_user($file_name){
        try{
            $contents = Storage::disk('explain')->get($file_name);
            return response($contents, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return view('errors.404');
        }
    }

    /**
     * @param $ebook_name
     * @return \Exception
     */
    public function get_file_ebook_for_lecturer($ebook_name){
        try{
            $ebook = Storage::disk('ebook')->get($ebook_name);
            return response($ebook, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * get file document for lecturer
     * @param $document_name
     * @return \Exception
     */
    public function get_file_document_for_lecturer($document_name){
        try{
            $document = Storage::disk('study_document')->get($document_name);
            return response($document, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * @param $ebook_name
     * @return \Exception
     */
    public function get_file_ebook_for_user($ebook_name){
        try{
            $ebook = Storage::disk('ebook')->get($ebook_name);
            return response($ebook, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * get file document for user
     * @param $document_name
     * @return \Exception
     */
    public function get_file_document_for_user($document_name){
        try{
            $document = Storage::disk('study_document')->get($document_name);
            return response($document, 200)->header('Content-Type', "application/pdf");
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
