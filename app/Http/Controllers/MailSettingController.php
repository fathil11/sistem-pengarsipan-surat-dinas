<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MailComponentsRequest;
use App\Services\Mail\MailComponentPriorityService;
use App\Services\Mail\MailComponentReferenceService;
use App\Services\Mail\MailComponentTypeService;

use App\Http\Requests\MailCompFolderRequest;
use App\Services\Mail\MailCompFolderService;

use App\Http\Requests\MailCorrectionTypeRequest;
use App\Services\Mail\MailCorrectionTypeService;

class MailSettingController extends Controller
{
    //=== CRUD FOR MAIL TYPE ===
    public function showMailsType()
    {
        return MailComponentTypeService::shows();
    }

    public function createMailType()
    {
        return MailComponentTypeService::create();
    }

    public function storeMailType(MailComponentsRequest $request)
    {
        if (MailComponentTypeService::store($request)) {
            return redirect('/surat/pengaturan/jenis-surat')->with('success', 'Berhasil menambahkan jenis surat');
        }
        return abort(500);
    }

    public function editMailType($id)
    {
        $mail_type = MailComponentTypeService::edit($id);
        if ($mail_type) {
            return view('app.mails.settings.type.type-edit', compact('mail_type'));
        }
        return abort(500);
    }

    public function updateMailType(MailComponentsRequest $request, $id)
    {
        if (MailComponentTypeService::update($request, $id)) {
            return redirect('/surat/pengaturan/jenis-surat')->with('success', 'Berhasil mengupdate jenis surat');
        }
        return abort(500);
    }

    public function deleteMailType($id)
    {
        if (MailComponentTypeService::delete($id)) {
            return redirect('/surat/pengaturan/jenis-surat')->with('success', 'Berhasil menghapus jenis surat');
        }
    }


    //=== CRUD FOR MAIL PRIORITY ===
    public function showMailsPriority()
    {
        return MailComponentPriorityService::shows();
    }

    public function createMailPriority()
    {
        return MailComponentPriorityService::create();
    }

    public function storeMailPriority(MailComponentsRequest $request)
    {
        if (MailComponentPriorityService::store($request)) {
            return redirect('/surat/pengaturan/prioritas-surat')->with('success', 'Berhasil menambahkan prioritas surat');
        }
    }

    public function editMailPriority($id)
    {
        return MailComponentPriorityService::edit($id);
    }

    public function updateMailPriority(MailComponentsRequest $request, $id)
    {
        if (MailComponentPriorityService::update($request, $id)) {
            return redirect('/surat/pengaturan/prioritas-surat')->with('success', 'Berhasil mengupdate prioritas surat');
        }
    }

    public function deleteMailPriority($id)
    {
        if (MailComponentPriorityService::delete($id)) {
            return redirect('/surat/pengaturan/prioritas-surat')->with('success', 'Berhasil menghapus prioritas surat');
        }
    }


    //=== CRUD FOR MAIL REFERENCE ===
    public function showMailsReference()
    {
        return MailComponentReferenceService::shows();
    }

    public function createMailReference()
    {
        return MailComponentReferenceService::create();
    }

    public function storeMailReference(MailComponentsRequest $request)
    {
        if (MailComponentReferenceService::store($request)) {
            return redirect('surat/pengaturan/sifat-surat')->with('success', 'Berhasil menambahkan sifat surat');
        }
    }

    public function updateMailReference(MailComponentsRequest $request, $id)
    {
        if (MailComponentReferenceService::update($request, $id)) {
            return redirect('surat/pengaturan/sifat-surat')->with('success', 'Berhasil mengupdate sifat surat');
        }
    }

    public function editMailReference($id)
    {
        return MailComponentReferenceService::edit($id);
    }

    public function deleteMailReference($id)
    {
        if (MailComponentReferenceService::delete($id)) {
            return redirect('surat/pengaturan/sifat-surat')->with('success', 'Berhasil menghapus sifat surat');
        }
    }

    //=== CRUD FOR MAIL FOLDER ===
    public function showMailsFolder()
    {
        return MailCompFolderService::shows();
    }

    public function createMailFolder()
    {
        return MailCompFolderService::create();
    }

    public function storeMailFolder(MailCompFolderRequest $request)
    {
        if (MailCompFolderService::store($request)) {
            return redirect('/surat/pengaturan/folder-surat')->with('Berhasil menambahkan folder surat');
        }
    }

    public function editMailFolder($id)
    {
        return MailCompFolderService::edit($id);
    }

    public function updateMailFolder(MailCompFolderRequest $request, $id)
    {
        if (MailCompFolderService::update($request, $id)) {
            return redirect('/surat/pengaturan/folder-surat')->with('Berhasil mengupdate folder surat');
        }
    }

    public function deleteMailFolder($id)
    {
        if (MailCompFolderService::delete($id)) {
            return redirect('/surat/pengaturan/folder-surat')->with('Berhasil menghapus folder surat');
        }
    }

    //=== CRUD FOR MAIL CORRECTION TYPE ===
    public function showMailsCorrectionType()
    {
        return MailCorrectionTypeService::shows();
    }

    public function createMailCorrectionType()
    {
        return MailCorrectionTypeService::create();
    }

    public function storeMailCorrectionType(MailCorrectionTypeRequest $request)
    {
        if (MailCorrectionTypeService::store($request)) {
            return redirect('surat/pengaturan/tipe-koreksi')->with('success', 'Berhasil menambahkan tipe koreksi surat');
        }
    }

    public function editMailCorrectionType($id)
    {
        return MailCorrectionTypeService::edit($id);
    }

    public function updateMailCorrectionType(MailCorrectionTypeRequest $request, $id)
    {
        if (MailCorrectionTypeService::update($request, $id)) {
            return redirect('surat/pengaturan/tipe-koreksi')->with('success', 'Berhasil mengupdate tipe koreksi surat');
        }
    }

    public function deleteMailCorrectionType($id)
    {
        if (MailCorrectionTypeService::delete($id)) {
            return redirect('surat/pengaturan/tipe-koreksi')->with('success', 'Berhasil menghapus tipe koreksi surat');
        }
    }
}
