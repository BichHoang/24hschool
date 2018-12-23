<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/20/2018
 * Time: 4:33 PM
 */

namespace App\DAO\DaoLecturer;


use App\Http\System\Convert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class StudyDocumentDao
{
    /**
     * get the teacher's study document list
     * @param $id_lecturer
     * @return \Exception
     */
    public function study_document_of_lecturer($document_name){
        try{
            if($document_name == ""){
                return DB::table('study_document')
                    ->where('status', 1)
                    ->where('id_lecturer', Auth::user()->id);
            }else{
                return DB::table('study_document')
                    ->where('status', 1)
                    ->where('id_lecturer', Auth::user()->id)
                    ->where('name', 'like', "%$document_name%");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * lay thong tin mot tai lieu hoc tap
     * @param $document_name
     * @return \Exception
     */
    public function get_one_document($id_document){
        try{
            return DB::table('study_document')
                ->where('id', $id_document)
                ->first();
        }catch (\Exception $ex){
            return $ex;
        }
    }


    /**
     * create study document, return id_document if create success and return 0 if fail
     * @param $request
     * @param $image_name
     * @return \Exception
     */
    public function create_document($request, $image_name, $document_name){
        try{
            $name = $request['name'];
            $class = $request['class'];
            $subject = $request['subject'];
            $slug = Convert::to_slug($name);
            $introduce = $request['introduce'];
            $price = 0;
            $sale = 0;
            $type_document = $request['type_document'];
            if($type_document == 1){
                $price = $request['price'];
                if($request->has['sale']){
                    $sale = $request['sale'];
                }
            }
            $pages = $request['pages'];
            $id = Uuid::uuid4();

            $rs = DB::table('study_document')->insert([
                'id' => $id,
                'id_lecturer' => Auth::user()->id,
                'id_user_post' => Auth::user()->id,
                'name' =>$name,
                'id_class' => $class,
                'id_subject' => $subject,
                'introduce' => $introduce,
                'price' => $price,
                'sale' => $sale,
                'pages' => $pages,
                'document' => $document_name,
                'image' => $image_name,
                'slug' => $slug,
                'created_at' => date('Y:m:d H:i:s'),
                'updated_at' => date('Y:m:d H:i:s'),
            ]);
            if($rs){
                return $id;
            }else{
                return 0;
            }

        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * cap nhat thong tin tai lieu hoc tap
     * @param $request
     * @param $id_document
     * @param $link_document
     * @return \Exception
     */
    public function update_document_info($request, $id_document, $link_document){
        try{
            $name = $request['name'];
            $slug = Convert::to_slug($name);
            $price = 0;
            $sale = 0;
            $type_document = $request['type_document'];
            if($type_document == 1){
                $price = $request['price'];
                if($request->has['sale']){
                    $sale = $request['sale'];
                }
            }
            $pages = $request['pages'];
            $introduce = $request['introduce'];
            return DB::table('study_document')
                ->where('id', $id_document)
                ->update([
                    'type_document' => $type_document,
                    'document' => $link_document,
                    'name' => $name,
                    'price' => $price,
                    'sale' => $sale,
                    'pages' => $pages,
                    'introduce' => $introduce,
                    'slug' => $slug,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }
}