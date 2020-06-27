<?php

namespace App\Services\Mail;

use App\MailType;
use App\Http\Requests\MailComponentsRequest;

class MailComponentTypeService
{
    /** Show Mail Type List */
    public static function shows()
    {
        $mail_types = MailType::all();
        return view('app.mails.settings.type.type-list', compact('mail_types'));
    }

    /** Create Mail Type */
    public static function create()
    {
        return view('app.mails.settings.type.type-add');
    }

    /** Store Mail Type */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Type
        MailType::create([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return redirect('/surat/pengaturan/jenis-surat');
    }

    /** Edit Mail Type */
    public static function edit($id)
    {
        $mail_type = MailType::findOrFail($id);
        return view('app.mails.settings.type.type-edit', compact('mail_type'));
    }

    /** Update Mail Type */
    public static function update(MailComponentsRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail Type is Exists
        $mail_type = MailType::findOrFail($id);

        // Update Mail Type
        $mail_type->update([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return redirect('/surat/pengaturan/jenis-surat');
    }

    /** Delete Mail Type */
    public static function delete($id)
    {
        // Check Mail Type is Exists
        $mail_type = MailType::findOrFail($id);
        $mail_type->delete();
        return redirect('/surat/pengaturan/jenis-surat');
    }
}
