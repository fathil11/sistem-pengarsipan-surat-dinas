<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MailFolder;
use App\MailPriority;
use App\MailReference;
use App\MailType;

class MailSettingController extends Controller
{
    //=== CRUD FOR MAIL TYPE ===
    public function storeMailType()
    {
        MailType::create($this->validateMailComponent());
        return response(200);
    }

    public function updateMailType($id)
    {
        MailType::where('id', $id)->update($this->validateMailComponent());
        return response(200);
    }

    public function deleteMailType($id)
    {
        MailType::findOrFail($id)->delete();
        return response(200);
    }


    //=== CRUD FOR MAIL PRIORITY ===
    public function storeMailPriority()
    {
        MailPriority::create($this->validateMailComponent());
        return response(200);
    }

    public function updateMailPriority($id)
    {
        MailPriority::where('id', $id)->update($this->validateMailComponent());
        return response(200);
    }

    public function deleteMailPriority($id)
    {
        MailPriority::findOrFail($id)->delete();
        return response(200);
    }


    //=== CRUD FOR MAIL REFERENCE ===
    public function storeMailReference()
    {
        MailReference::create($this->validateMailComponent());
        return response(200);
    }

    public function updateMailReference($id)
    {
        MailReference::where('id', $id)->update($this->validateMailComponent());
        return response(200);
    }

    public function deleteMailReference($id)
    {
        MailReference::findOrFail($id)->delete();
        return response(200);
    }

    private function validateMailComponent()
    {
        return request()->validate([
            'type' => 'required|min:3|max:50',
            'code' => 'required|min:2|max:50',
            'color' => 'required|min:3|max:50',
            ]);
    }
}
