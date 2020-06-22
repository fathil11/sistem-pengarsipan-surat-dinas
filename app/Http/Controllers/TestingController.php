<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function storeMailIn()
    {
        // TODO:
        /*
            === Validation ===
            - Check Role (TU)
            - Form field validation
                - Mail
                - Mail File
                    - Required
                    - Mimes : pdf, doc, jpg, jpeg, png
                    - Max Size : 5MB

            Fail -> return abort:401, "Anda tidak memiliki akses"

            === Query ===
            - Create Mail
            - fill attr
            - fill property attr w id table

            - Create Mail Version
            - mail_id -> id Created mail
            - version -> inc

            - Create Mail File
            - mail_version_id -> id Created mail version
            - original_name -> "getOriginalFileName()"
            - type -> File extension

            - Create Mail Transaction
            - mail_version_id -> id Created mail version
            - user_id -> Auth
            - target_user_id -> All user (Sekrestaris)
            - type -> create

         */
    }
}
