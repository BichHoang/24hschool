<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'User\HomePageController@getIndex');

Route::get('login', 'Auth\LoginController@login_get')->name('login');
Route::post('login', 'Auth\LoginController@login_post');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout_user', 'Auth\LoginController@logout_user')->name('logout_user');

Route::get('register', 'Auth\RegisterController@get_register')->name('register');
Route::post('register', 'Auth\RegisterController@post_register');

//forgot password
Route::get('forgot_password', 'Auth\ForgotPasswordController@get_forgot_password');
Route::post('forgot_password', 'Auth\ForgotPasswordController@post_forgot_password');

//complete personal information
Route::get('user/complete_information', 'User\AccountController@get_complete_information');
Route::post('user/complete_information', 'User\AccountController@post_complete_information');

Route::get('maintenance', function () {
    return view('page.maintenance');
});

Route::group(['middleware' => 'auth'], function () {

    //get image of book
    Route::get('image_book/{image_name}', [
        'uses' => 'ManageFile\Image@get_image_book',
        'as' => 'book.image'
    ]);

    //get image of study document
    Route::get('image_document/{image_document}', [
        'uses' => 'ManageFile\Image@get_image_document',
        'as' => 'study_document.image'
    ]);

    //get image of exam
    Route::get('image_exam/{image_exam}', [
        'uses' => 'ManageFile\Image@get_image_exam',
        'as' => 'exam.image'
    ]);

    //UI Admin
    Route::group(['middleware' => 'checkAdmin'], function () {
        Route::group(['prefix' => 'admin'], function () {

            Route::get('/home', 'Admin\HomeController@home');

            //student
            Route::group(['prefix' => 'student'], function () {
                Route::get('/show={name}', 'Admin\UserController@get_list_student');
                Route::post('/show={name}', 'Admin\UserController@post_list_student');

            });

            //lecturer
            Route::group(['prefix' => 'lecturer'], function () {
                Route::get('/show={name}', 'Admin\LecturerController@get_list_lecturer');
                Route::post('/show={name}', 'Admin\LecturerController@post_list_lecturer');

                //create lecturer
                Route::get('/create', 'Admin\LecturerController@get_create_lecturer');
                Route::post('/create', 'Admin\LecturerController@post_create_lecturer');

            });

            //CTV
            Route::group(['prefix' => 'ctv'], function () {
                Route::get('/show={name}', 'Admin\UserController@get_list_ctv');
                Route::post('/show={name}', 'Admin\UserController@post_list_ctv');

            });

            //class room
            Route::group(['prefix' => 'class_room'], function () {
                Route::get('/show={name}', 'Admin\ClassController@get_list_class_room');
                Route::post('/show={name}', 'Admin\ClassController@post_list_class_room');

            });

            //subject
            Route::group(['prefix' => 'subject'], function () {
                Route::get('/show={name}', 'Admin\SubjectController@get_list_subject');
                Route::post('/show={name}', 'Admin\SubjectController@post_list_subject');

            });

            //topic
            Route::group(['prefix' => 'topic'], function () {
                Route::get('/show={name}', 'Admin\TopicController@get_list_topic');
                Route::post('/show={name}', 'Admin\TopicController@post_list_topic');

            });

            //transaction
            Route::group(['prefix' => 'transaction'], function () {

                //nhan giao dich
                Route::get('/notify_receive/{id_transaction}', 'Admin\TransactionController@confirm_received_transaction');

                //tu choi nhan giao dich
                Route::post('/notify_deny_receive/{id_transaction}',
                    'Admin\TransactionController@post_notify_deny_receive_transaction');

                //thong bao giao dich thanh cong
                Route::get('/notify_success/{id_transaction}',
                    'Admin\TransactionController@notify_transaction_success');

                //thong bao giao dich that bai
                Route::post('/notify_fail/{id_transaction}',
                    'Admin\TransactionController@post_notify_transaction_fail');

                //lay tat ca giao dich
                Route::get('/all-{search}', 'Admin\TransactionController@get_list_transaction');
                Route::post('/all-{search}', 'Admin\TransactionController@post_list_transaction');

                //transaction book
                Route::group(['prefix' => 'book'], function () {

                    //display list register buy book of user
                    Route::get('/list_register-{search}',
                        'Admin\TransactionController@get_list_user_register_buy_book');
                    Route::post('/list_register-{search}',
                        'Admin\TransactionController@post_list_user_register_buy_book');

                    //detail transaction
                    Route::get('/detail_transaction/{id_register_buy_book}',
                        'Admin\TransactionController@get_detail_transaction_book');

                });

                //transaction study document
                Route::group(['prefix' => 'document'], function () {

                    //display list register buy document of user
                    Route::get('/list_register-{search}',
                        'Admin\TransactionController@get_list_user_register_buy_document');
                    Route::post('/list_register-{search}',
                        'Admin\TransactionController@post_list_user_register_buy_document');

                    //detail transaction
                    Route::get('/detail_transaction/{id_register_buy_document}',
                        'Admin\TransactionController@get_detail_transaction_document');

                });

            });

        });
    });

    //UI Lecturer
    Route::group(['middleware' => 'checkLecturer'], function () {

        Route::group(['prefix' => 'lecturer'], function () {
            //get file explain in storage
            Route::get('/file_exam={file_name}', 'ManageFile\FileExam@get_file_exam_pdf');

            //get file explain in storage
            Route::get('/file_explain={file_name}', 'ManageFile\FileExam@get_file_explain_pdf');

            //get file ebook
            Route::get('/ebook/{ebook_name}', 'ManageFile\FileExam@get_file_ebook_for_lecturer');

            //get file document
            Route::get('/document/{document_name}', 'ManageFile\FileExam@get_file_document_for_lecturer');

            //view home
            Route::get('/home', 'Lecturer\HomeController@home');

            //manage this lecturer's ctv
            Route::group(['prefix' => 'ctv'], function () {
                //show list of this lecturer's ctv
                Route::get('/list={name}', 'Lecturer\CTVController@get_list_your_ctv');
                Route::post('/list={name}', 'Lecturer\CTVController@post_list_your_ctv');

                //display list exam of ctv
                Route::get('/list_exam={id_ctv}', 'Lecturer\CTVController@get_list_exam_of_ctv');

                //display detail a exam in list exam of ctv
                Route::get('/exam_detail={id_exam}', 'Lecturer\CTVController@watch_detail_exam');

                //create a new ctv
                Route::get('/create_ctv', 'Lecturer\CTVController@get_create_new_ctv');
                Route::post('/create_ctv', 'Lecturer\CTVController@post_create_new_ctv');

            });

            //manage exam
            Route::group(['prefix' => 'exam'], function () {
                //watch detail of exam approved
                Route::get('/watch_detail={id_exam}', 'Lecturer\ExamController@get_detail_a_exam_approved');

                //delete one exam of ctv was approved
                Route::get('/delete={id_exam}', 'Lecturer\ExamController@delete_exam_of_ctv');

                //exams have been approved into web
                Route::group(['prefix' => 'exam_approved_web'], function () {
                    //show list of exams have been approved
                    Route::get('/list={name}', 'Lecturer\ExamController@get_exam_on_web');
                    Route::post('/list={name}', 'Lecturer\ExamController@post_exam_on_web');

                });

                //exams have been approved into repository
                Route::group(['prefix' => 'exam_approved_repository'], function () {
                    //show list of exams have been approved
                    Route::get('/list={name}', 'Lecturer\ExamController@get_exam_in_repository');
                    Route::post('/list={name}', 'Lecturer\ExamController@post_exam_in_repository');


                });

                //exams are waiting approve
                Route::group(['prefix' => 'exam_waiting_approve'], function () {
                    //show list of exams are waiting approve into web
                    Route::get('/list={name}', 'Lecturer\ExamController@get_waiting_approve');
                    Route::post('/list={name}', 'Lecturer\ExamController@post_waiting_approve');

                    //display detail exam is waiting approve
                    Route::get('/detail={id_exam}', 'Lecturer\ExamController@detail_exam_waiting');

                    //approve exam to web
                    Route::get('/approve_web={id_exam}', 'Lecturer\ExamController@approve_exam_to_web');

                    //approve exam to repository
                    Route::get('/approve_repository={id_exam}', 'Lecturer\ExamController@approve_exam_to_repository');

                    //send request ctv modify exam
                    Route::get('/send_modify={id_exam}', 'Lecturer\ExamController@get_send_request_modify');
                    Route::post('/send_modify={id_exam}', 'Lecturer\ExamController@post_send_request_modify');


                });

                //exams need modify
                Route::group(['prefix' => 'exam_need_modify'], function () {
                    //show list of exams need modify
                    Route::get('/list={name}', 'Lecturer\ExamController@get_exam_need_modify');
                    Route::post('/list={name}', 'Lecturer\ExamController@post_exam_need_modify');

                    //display detail exam need modify
                    Route::get('/detail={id_exam}', 'Lecturer\ExamController@get_detail_exam_need_modify');

                    //display list comment of a exam
                    Route::get('/comment_exam={id_exam}', 'Lecturer\ExamController@get_list_comment_of_exam');

                    //display detail exam with detail comment of this exam
                    Route::get('/detail_comment={id_comment}', 'Lecturer\ExamController@get_detail_comment_of_exam');

                    //update comment of exam
                    Route::post('/update_comment={id_comment}', 'Lecturer\ExamController@update_comment');

                });

                //---------------------------------- My Exam -----------------------------------------------------------
                //------------------------------------------------------------------------------------------------------
                Route::group(['prefix' => 'my_exam'], function () {
                    //up exam
                    Route::get('/up_exam', 'Lecturer\ExamController@get_upload_exam');
                    Route::post('/up_exam', 'Lecturer\ExamController@post_upload_exam');

                    //watch detail my exam
                    Route::get('/detail_exam={id_exam}', 'Lecturer\ExamController@get_detail_my_exam_complete');

                    //delete my exam
                    Route::get('/delete={id_exam}', 'Lecturer\ExamController@delete_my_exam');

                    //display view for choose update
                    Route::get('/update={id_exam}', 'Lecturer\ExamController@get_update_view');

                    //update exam file
                    Route::get('/update_exam_file={id_exam}', 'Lecturer\ExamController@get_update_exam_file');
                    Route::post('/update_exam_file={id_exam}', 'Lecturer\ExamController@post_update_exam_file');

                    //update explain file
                    Route::get('/update_explain_file={id_exam}', 'Lecturer\ExamController@get_update_explain_file');
                    Route::post('/update_explain_file={id_exam}', 'Lecturer\ExamController@post_update_explain_file');

                    //update list answer
                    Route::get('/update_list_answer={id_exam}', 'Lecturer\ExamController@get_update_list_answer');
                    Route::post('/update_list_answer={id_exam}', 'Lecturer\ExamController@post_update_list_answer');

                    //update exam information
                    Route::get('/update_exam_info={id_exam}', 'Lecturer\ExamController@get_update_exam_info');
                    Route::post('/update_exam_info={id_exam}', 'Lecturer\ExamController@post_update_exam_info');

                    //my exam not answer
                    Route::group(['prefix' => 'not_answer'], function () {
                        //show my list exam are haven't been answer
                        Route::get('/list={name}', 'Lecturer\ExamController@get_my_exam_not_answer');
                        Route::post('/list={name}', 'Lecturer\ExamController@post_my_exam_not_answer');

                        //enter answer for exam
                        Route::get('/enter_answer={id_exam}', 'Lecturer\ExamController@get_enter_answer');
                        Route::post('/enter_answer={id_exam}', 'Lecturer\ExamController@post_enter_answer');

                    });

                    //my exam have answer
                    Route::group(['prefix' => 'have_answer'], function () {
                        //show my list exams are have been answer
                        Route::get('/list={name}', 'Lecturer\ExamController@get_my_exam_have_answer');
                        Route::post('/list={name}', 'Lecturer\ExamController@post_my_exam_have_answer');

                        //add explain file into exam
                        Route::get('/add_explain={id_exam}', 'Lecturer\ExamController@get_add_explain');
                        Route::post('/add_explain={id_exam}', 'Lecturer\ExamController@post_add_explain');

                        //update explain file into exam
                        Route::get('/update_explain={id_exam}', 'Lecturer\ExamController@get_update_explain');
                        Route::post('/update_explain={id_exam}', 'Lecturer\ExamController@post_update_explain');

                        //save my exam to web
                        Route::get('/save_exam_to_web={id_exam}', 'Lecturer\ExamController@save_my_exam_to_web');

                        //save my exam to repository
                        Route::get('/save_exam_to_repository={id_exam}', 'Lecturer\ExamController@save_my_exam_to_repository');

                    });

                    //my exam on web
                    Route::group(['prefix' => 'web'], function () {
                        //show my list exam on web
                        Route::get('/list={name}', 'Lecturer\ExamController@get_my_exam_on_web');
                        Route::post('/list={name}', 'Lecturer\ExamController@post_my_exam_on_web');

                    });

                    //my exam in repository
                    Route::group(['prefix' => 'repository'], function () {
                        //show my list exam in repository
                        Route::get('/list={name}', 'Lecturer\ExamController@get_my_exam_in_repository');
                        Route::post('/list={name}', 'Lecturer\ExamController@post_my_exam_in_repository');


                    });

                });

            });

            //book
            Route::group(['prefix' => 'book'], function () {
                //delete book
                Route::get('/delete/{id_book}', 'Lecturer\BookController@delete_book');

                //cập nhật sách là còn hàng
                Route::get('/change_status/{id_book}', 'Lecturer\BookController@change_status_book');

                //create book
                Route::get('/create', 'Lecturer\BookController@get_create_book');
                Route::post('/create', 'Lecturer\BookController@post_create_book');

                //danh muc sach
                Route::get('/list{book_name}', 'Lecturer\BookController@get_list_book');
                Route::post('/list{book_name}', 'Lecturer\BookController@post_list_book');

                //watch detail book
                Route::get('/detail/{id_book}', 'Lecturer\BookController@get_detail');

                //update book image
                Route::post('/update_image/{id_book}', 'Lecturer\BookController@post_update_book_image');
                //update book info
                Route::post('/update_info/{id_book}', 'Lecturer\BookController@post_update_book_info');

            });

            //study document
            Route::group(['prefix' => 'study_document'], function () {
                //delete study document
                Route::get('/delete/{id_document}', 'Lecturer\StudyDocumentController@delete_document');

                //create study document
                Route::get('/create', 'Lecturer\StudyDocumentController@get_create_document');
                Route::post('/create', 'Lecturer\StudyDocumentController@post_create_document');

                //list document
                Route::get('/list{study_document}', 'Lecturer\StudyDocumentController@get_list_document');
                Route::post('/list{study_document}', 'Lecturer\StudyDocumentController@post_list_document');

                //watch detail book
                Route::get('/detail/{id_document}', 'Lecturer\StudyDocumentController@get_detail');

                //update study document image
                Route::post('/update_image/{id_document}', 'Lecturer\StudyDocumentController@post_update_image');

                //update study document info
                Route::post('/update_info/{id_document}', 'Lecturer\StudyDocumentController@post_update_info');

            });
        });
    });

    //UI CTV
    Route::group(['middleware' => 'checkCTV'], function () {

        Route::group(['prefix' => 'ctv'], function () {
            //get file exam in storage
            Route::get('/file_exam={file_name}', 'ManageFile\FileExam@get_file_exam_pdf');

            //get file explain in storage
            Route::get('/file_explain={file_name}', 'ManageFile\FileExam@get_file_explain_pdf');

            //show home view
            Route::get('/home', 'CTV\HomeController@home');

            //exam
            Route::group(['prefix' => 'exam'], function () {
                //up exam
                Route::get('/up_exam', 'CTV\ExamController@get_upload_exam');
                Route::post('/up_exam', 'CTV\ExamController@post_upload_exam');

                //delete exam
                Route::get('/delete={id_exam}', 'CTV\ExamController@delete_exam');

                //display view for choose update
                Route::get('/update={id_exam}', 'CTV\ExamController@get_update_view');

                //update exam file
                Route::get('/update_exam_file={id_exam}', 'CTV\ExamController@get_update_exam_file');
                Route::post('/update_exam_file={id_exam}', 'CTV\ExamController@post_update_exam_file');

                //update explain file
                Route::get('/update_explain_file={id_exam}', 'CTV\ExamController@get_update_explain_file');
                Route::post('/update_explain_file={id_exam}', 'CTV\ExamController@post_update_explain_file');

                //update list answer
                Route::get('/update_list_answer={id_exam}', 'CTV\ExamController@get_update_list_answer');
                Route::post('/update_list_answer={id_exam}', 'CTV\ExamController@post_update_list_answer');

                //update exam information
                Route::get('/update_exam_info={id_exam}', 'CTV\ExamController@get_update_exam_info');
                Route::post('/update_exam_info={id_exam}', 'CTV\ExamController@post_update_exam_info');

                //exams haven't been answer
                Route::group(['prefix' => 'not_answer'], function () {
                    //show list exam haven't been answer
                    Route::get('/list={name}', 'CTV\ExamController@get_exam_not_answer');
                    Route::post('/list={name}', 'CTV\ExamController@post_exam_not_answer');

                    //enter answer for exam file
                    Route::get('/enter_answer={id_exam}', 'CTV\ExamController@get_enter_answer');
                    Route::post('/enter_answer={id_exam}', 'CTV\ExamController@post_enter_answer');
                });

                //exams have answer
                Route::group(['prefix' => 'have_answer'], function () {
                    //show list exam have answer
                    Route::get('/list={name}', 'CTV\ExamController@get_exam_have_answer');
                    Route::post('/list={name}', 'CTV\ExamController@post_exam_have_answer');

                    //watch detail exam have answer
                    Route::get('/detail={id_exam}', 'CTV\ExamController@detail_exam_have_answer');

                    //send admin to approve exam
                    Route::get('/request_approve={id_exam}', 'CTV\ExamController@send_approve_request');


                });
                //exam waiting to approve
                Route::group(['prefix' => 'waiting_approve'], function () {
                    //show list exam waiting approve
                    Route::get('/list={name}', 'CTV\ExamController@get_exam_waiting_approve');
                    Route::post('/list={name}', 'CTV\ExamController@post_exam_waiting_approve');

                    //watch detail exam waiting approve
                    Route::get('/detail={id_exam}', 'CTV\ExamController@detail_exam_waiting_approve');

                    //cancel send approve request to admin
                    Route::get('/cancel_request={id_exam}', 'CTV\ExamController@cancel_approve_request');
                });

                //exam has been approved to web
                Route::group(['prefix' => 'web'], function () {
                    //show list exam has been approved on web
                    Route::get('/list={name}', 'CTV\ExamController@get_exam_on_web');
                    Route::post('/list={name}', 'CTV\ExamController@post_exam_on_web');

                    //watch detail exam approved to web
                    Route::get('/detail={id_exam}', 'CTV\ExamController@detail_exam_approved');
                });

                Route::group(['prefix' => 'repository'], function () {
                    //show list exam has been approved to repository
                    Route::get('/list={name}', 'CTV\ExamController@get_exam_in_repository');
                    Route::post('/list={name}', 'CTV\ExamController@post_exam_in_repository');

                    //watch detail exam approved in repository
                    Route::get('/detail={id_exam}', 'CTV\ExamController@detail_exam_approved');
                });

                //exam need modify to send approve again
                Route::group(['prefix' => 'need_modify'], function () {
                    //show list exam need modify to approve again
                    Route::get('/list={name}', 'CTV\ExamController@get_list_exam_need_modify');
                    Route::post('/list={name}', 'CTV\ExamController@post_list_exam_need_modify');

                    //watch detail exam need modify
                    Route::get('/detail={id_exam}', 'CTV\ExamController@detail_exam_need_modify');

                    //send admin to approve exam again
                    Route::get('/request_approve_again={id_exam}', 'CTV\ExamController@send_approve_again');

                    //comment for exam
                    Route::group(['prefix' => 'comment'], function () {
                        //show list comment for a exam
                        Route::get('/list={id_exam}', 'CTV\ExamController@get_comment_for_exam');

                        //detail comment
                        Route::get('/detail={id_comment}', 'CTV\ExamController@get_detail_comment');
                    });

                });
            });
        });

    });

    //UI User
    Route::group(['middleware' => 'checkUser'], function () {

        Route::group(['prefix' => 'user'], function () {

            //get file exam in storage
            Route::get('/file_exam={file_name}', 'ManageFile\FileExam@get_file_exam_pdf_for_user');

            //get file explain in storage
            Route::get('/file_explain={file_name}', 'ManageFile\FileExam@get_file_explain_pdf_for_user');

            //watch book
            Route::get('/ebook-cua-toi/{id_ebook}', 'User\TransactionController@detail_my_book');

            //watch document
            Route::get('/tai-lieu-cua-toi/{id_document}', 'User\TransactionController@detail_my_document');

            //history of do exam
            Route::get('/history', 'User\ExamHistoryController@get_list_exam_history');
            Route::get('/detail_result/{id_exam_history}', 'User\ExamHistoryController@get_one_exam_history');

            //exam
            Route::group(['prefix' => 'exam'], function () {
                //show all exam free
                Route::get('/exam_free', 'User\ExamController@get_list_exam_free');
                Route::post('/exam_free', 'User\ExamController@post_list_exam_free');

                //show all exam bought by coin
                Route::get('/exam_coin', 'User\ExamController@get_list_exam_coin');
                Route::post('/exam_coin', 'User\ExamController@post_list_exam_coin');

                //do exam free
                Route::get('/do_exam_free/{id}', 'User\ExamController@get_do_exam_free');
                Route::post('/do_exam_free/{id}', 'User\ExamController@post_do_exam_free');

                //do exam buy coin
                Route::get('/do_exam_coin/{id}', 'User\ExamController@get_do_exam_coin');
                Route::post('/do_exam_coin/{id}', 'User\ExamController@post_do_exam_coin');

                //show exam by id subject
                Route::get('/subject/{slug}/{id_subject}', 'User\ExamController@get_exam_by_subject');
                Route::post('/subject/{slug}/{id_subject}', 'User\ExamController@post_exam_by_subject');

                //show exam by id class
                Route::get('/class/{slug}/{id_class}', 'User\ExamController@get_exam_by_class');
                Route::post('/class/{slug}/{id_class}', 'User\ExamController@post_exam_by_class');

                //search exam
                Route::get('/search-{search}', 'User\ExamController@get_search_exam');
                Route::post('/search-{search}', 'User\ExamController@post_search_exam');

            });

            //account
            Route::group(['prefix' => 'account'], function () {
                //update user information
                Route::get('/information', 'User\AccountController@get_user_information');
                Route::post('/information', 'User\AccountController@post_user_information');

                //update password of user was logged
                Route::post('/update_password', 'User\AccountController@post_user_password');

            });

            //book
            Route::group(['prefix' => 'book'], function () {
                //show all book
                Route::get('/all', 'User\BookController@get_all_book');

                //show detail book
                Route::get('/detail/{id_book}', 'User\BookController@get_detail_book');

                //your cart
                Route::get('/my_cart', 'User\CartBookController@get_cart_book');
                Route::post('/my_cart', 'User\RegisterBuyBookController@post_register_buy_book');

                //book bought
                Route::get('/my_book', 'User\TransactionController@get_my_book');
                Route::post('/my_book', 'User\TransactionController@post_my_book');

                //search book
                Route::get('/search-{keyword}', 'User\BookController@get_search_book');
                Route::post('/search-{keyword}', 'User\BookController@post_search_book');

                //add book to cart
                Route::post('/add_book-{id_book}', 'User\CartBookController@add_book_into_cart');

                //delete book from cart
                Route::get('/delete_book-{id_book}', 'User\CartBookController@delete_book_from_cart');

                //delete all book from cart
                Route::get('/delete_all_book', 'User\CartBookController@delete_all_book_of_user');

            });

            //study document
            Route::group(['prefix' => 'document'], function () {
                //show all document
                Route::get('/all', 'User\StudyDocumentController@get_all_document');

                //show detail document
                Route::get('/detail/{id_document}', 'User\StudyDocumentController@get_detail_document');

                //your cart
                Route::get('/my_cart', 'User\CartDocumentController@get_cart_document');
                Route::post('/my_cart', 'User\RegisterBuyDocumentController@post_register_buy_all_cart');

                //document bought
                Route::get('/my_document', 'User\TransactionController@get_my_document');
                Route::post('/my_document', 'User\TransactionController@post_my_document');

                //search document
                Route::get('/search-{keyword}', 'User\StudyDocumentController@get_search_document');
                Route::post('/search-{keyword}', 'User\StudyDocumentController@post_search_document');

                //add document to cart
                Route::post('/add_document-{id_document}', 'User\CartDocumentController@add_document_into_cart');

                //delete documnent from cart
                Route::get('/delete_document-{id_document}', 'User\CartDocumentController@delete_document_from_cart');

                //delete all document from cart
                Route::get('/delete_all_document', 'User\CartDocumentController@delete_all_document_of_user');

            });

            //quan ly don hang cua ban
            Route::group(['prefix' => 'transaction'], function () {
                //hien thi danh sach giao dich
                Route::get('/all', 'User\TransactionController@get_list_transaction');
                //hien thi chi tiet 1 giao dich
                Route::get('/detail/{id_transaction}', 'User\TransactionController@detail_transaction');

                //Huy bo giao dich chua duoc xu ly
                Route::get('/cancel_transaction/{id_transaction}', 'User\TransactionController@cancel_transaction');

                //An 1 lich su giao dich voi nguoi dung
                Route::get('/delete_transaction/{id_transaction}',
                    'User\TransactionController@hide_transaction_with_customer');

                //transaction book
                Route::group(['prefix' => 'book'], function () {
                    //hien thi chi tiet giao dich mua sach
                    Route::get('/detail/{id_transaction}', 'User\TransactionController@detail_transaction_book');

                    //display form for user enter user's info buy ebook
                    Route::get('/buy_ebook/{id_book}', 'User\RegisterBuyBookController@get_register_buy_ebook');
                    Route::post('/buy_ebook/{id_book}', 'User\RegisterBuyBookController@post_register_buy_ebook');

                    //display form for user enter's info to buy ebook and book
                    Route::get('/buy_whole/{id_book}', 'User\RegisterBuyBookController@get_register_buy_whole');
                    Route::post('/buy_whole/{id_book}', 'User\RegisterBuyBookController@post_register_buy_whole');


                });

                //transaction document
                Route::group(['prefix' => 'document'], function () {
                    //hien thi chi tiet giao dich mua tai lieu
                    Route::get('/detail/{id_transaction}', 'User\TransactionController@detail_transaction_document');

                    //display form for user enter user's info buy document
                    Route::get('/buy_document/{id_document}', 'User\RegisterBuyDocumentController@get_register_buy_document');
                    Route::post('/buy_document/{id_document}', 'User\RegisterBuyDocumentController@post_register_buy_document');

                    //display form for user enter's info to buy whole
                    Route::get('/buy_whole/{id_document}', 'User\RegisterBuyDocumentController@get_register_buy_whole');
                    Route::post('/buy_whole/{id_document}', 'User\RegisterBuyDocumentController@post_register_buy_whole');
                });
            });

        });

    });
});

Route::get('/test_date', function () {
    return date('H:i:s Y-m-d', 1529469358);
});

Route::post('/enter_answer={name}', 'CTV\ExamController@post_enter_answer');

//Route::get('/test/{id}', 'ManageFile\FileExam@get_file_ebook_for_user');

