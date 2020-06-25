<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MailComponentsRequest;
use App\Services\Mail\MailComponentPriorityService;
use App\Services\Mail\MailComponentReferenceService;
use App\Services\Mail\MailComponentTypeService;

class MailSettingController extends Controller
{
    //=== CRUD FOR MAIL TYPE ===
    public function storeMailType(MailComponentsRequest $request)
    {
        return MailComponentTypeService::store($request);
    }

    public function updateMailType(MailComponentsRequest $request, $id)
    {
        return MailComponentTypeService::update($request, $id);
    }

    public function deleteMailType($id)
    {
        return MailComponentTypeService::delete($id);
    }


    //=== CRUD FOR MAIL PRIORITY ===
    public function storeMailPriority(MailComponentsRequest $request)
    {
        return MailComponentPriorityService::store($request);
    }

    public function updateMailPriority(MailComponentsRequest $request, $id)
    {
        return MailComponentPriorityService::update($request, $id);
    }

    public function deleteMailPriority($id)
    {
        return MailComponentPriorityService::delete($id);
    }


    //=== CRUD FOR MAIL REFERENCE ===
    public function storeMailReference(MailComponentsRequest $request)
    {
        return MailComponentReferenceService::store($request);
    }

    public function updateMailReference(MailComponentsRequest $request, $id)
    {
        return MailComponentReferenceService::update($request, $id);
    }

    public function deleteMailReference($id)
    {
        return MailComponentReferenceService::delete($id);
    }
}
