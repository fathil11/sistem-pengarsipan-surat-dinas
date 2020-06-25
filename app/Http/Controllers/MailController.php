<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MailOutRequest;
use App\Services\Mail\MailOutService;

class MailController extends Controller
{
    public function storeMailOut(MailOutRequest $request)
    {
        MailOutService::store($request);
    }

    public function updateMailOut(MailOutRequest $request, $id)
    {
        MailOutService::update($request, $id);
    }

    public function deleteMailOut($id)
    {
        MailOutService::delete($id);
    }
}
