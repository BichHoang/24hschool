<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/20/2018
 * Time: 4:28 PM
 */

namespace App\DAO\DaoLecturer;

use App\Http\System\Convert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class BookDao
{

    /**
     * get the teacher's book list
     * @param $id_lecturer
     * @return \Exception
     */
    public function list_book_of_lecturer($book_name){
        try{
            if($book_name == ""){
                return DB::table('book')
                    ->where('id_lecturer', Auth::user()->id);
            }else{
                return DB::table('book')
                    ->where('id_lecturer', Auth::user()->id)
                    ->where('name', 'like', "%$book_name%");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * create book, return id_book if create success and return 0 if fail
     * @param $request
     * @param $image_name
     * @return \Exception
     */
    public function create_book($request, $image_name_previous, $image_name_rear, $ebook_name)
    {
        try {
            $name = $request['name'];
            $author = $request['author'];
            $introduce = $request['introduce'];
            $price = 0;
            $sale = 0;
            $price_of_ebook = 0;
            $type_book = $request['type_book'];
            if ($type_book == 1) {
                $price = $request['price'];
                $price_of_ebook = $request['price_of_ebook'];
                if ($request->has['sale']) {
                    $sale = $request['sale'];
                }
            }
            $pages = $request['pages'];
            $publication_date = $request['publication_date'];
            $topic = $request['topic'];
            $id = Uuid::uuid4();

            $rs = DB::table('book')->insert([
                'id' => $id,
                'type_book' => $type_book,
                'id_lecturer' => Auth::user()->id,
                'id_user_post' => Auth::user()->id,
                'name' => $name,
                'author' => $author,
                'introduce' => $introduce,
                'ebook' => $ebook_name,
                'publication_date' => $publication_date,
                'price' => $price,
                'sale' => $sale,
                'price_of_ebook' => $price_of_ebook,
                'pages' => $pages,
                'previous_image' => $image_name_previous,
                'rear_image' => $image_name_rear,
                'created_at' => date('Y:m:d H:i:s'),
                'updated_at' => date('Y:m:d H:i:s'),
                'id_topic' => $topic
            ]);
            if ($rs) {
                return $id;
            } else {
                return 0;
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * delete a book of lecturer
     * @param $id_book
     * @return \Exception
     */
    public function delete_book($id_book)
    {
        try {
            return DB::table('book')
                ->where('id', $id_book)
                ->delete();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * change status of book
     * @param $id_book
     * @param $status
     * @return \Exception
     */
    public function change_status_book($id_book, $status)
    {
        try {
            return DB::table('book')
                ->where('id', $id_book)
                ->update([
                    'status' => $status,
                    'updated_at' => date('Y-m-d: H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin mot cuon sach de xem
     * @param $id_book
     * @return \Exception
     */
    public function get_one_book($id_book){
        try{
            return DB::table('book')
                ->where('id', $id_book)
                ->where('id_lecturer', Auth::user()->id)
                ->first();
        }catch (\Exception $ex){
            return $ex;
        }
    }


    /**
     * update book info
     * @param $request
     * @param $id_book
     * @return \Exception
     */
    public function update_book_info($request, $id_book, $ebook){
        try{
            $name = $request['name'];
            $slug = Convert::to_slug($name);
            $author = $request['author'];
            $price = 0;
            $price_of_ebook = 0;
            $sale = 0;
            $type_book = $request['type_book'];
            if($type_book == 1){
                $price = $request['price'];
                $price_of_ebook = $request['price_of_ebook'];
                if($request->has['sale']){
                    $sale = $request['sale'];
                }
            }
            $pages = $request['pages'];
            $introduce = $request['introduction'];
            $publication_date = $request['publication_date'];
            $topic = $request['topic'];
            return DB::table('book')
                ->where('id', $id_book)
                ->update([
                    'type_book' => $type_book,
                    'ebook' => $ebook,
                    'name' => $name,
                    'author' => $author,
                    'price' => $price,
                    'sale' => $sale,
                    'price_of_ebook' => $price_of_ebook,
                    'pages' => $pages,
                    'introduce' => $introduce,
                    'publication_date' => date('Y-m-d', strtotime($publication_date)),
                    'slug' => $slug,
                    'id_topic' => $topic,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }
}