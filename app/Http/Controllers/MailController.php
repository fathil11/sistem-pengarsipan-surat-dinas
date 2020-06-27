<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Mail Out Privileges
use App\Http\Requests\MailOutRequest;
use App\Services\Mail\MailOutService;

//Mail In Privileges
use App\Http\Requests\MailInRequest;
use App\Services\Mail\MailInService;
use App\Http\Requests\MailMemoRequest;

class MailController extends Controller
{
    //Mail Out Privileges
    public function storeMailOut(MailOutRequest $request)
    {
        return MailOutService::store($request);
    }

    public function updateMailOut(MailOutRequest $request, $id)
    {
        return MailOutService::update($request, $id);
    }

    public function deleteMailOut($id)
    {
        return MailOutService::delete($id);
    }

    public function forwardMailOut($id)
    {
        return MailOutService::forward($id);
    }


    //Mail In Privileges
    public function showMailIn($id)
    {
        return MailInService::show($id);
    }

    public function storeMailIn(MailInRequest $request)
    {
        return MailInService::store($request);
    }

    public function updateMailIn(MailInRequest $request, $id)
    {
        return MailInService::update($request, $id);
    }

    public function deleteMailIn($id)
    {
        return MailInService::delete($id);
    }

    public function downloadMailIn($id)
    {
        return MailInService::download($id);
    }

    public function forwardMailIn(MailMemoRequest $request, $id)
    {
        return MailInService::forward($request, $id);
    }

    public function dispositionMailIn(MailMemoRequest $request, $id)
    {
        return MailInService::disposition($request, $id);
    }

    public function downloadDispositionMailIn($id)
    {
        return MailInService::downloadDisposition($id);
    }
}
