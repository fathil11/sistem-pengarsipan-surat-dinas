<?php

namespace App\Services\Mail;

use App\MailReference;
use App\Http\Requests\MailComponentsRequest;

class MailComponentReferenceService
{
    /** Show Mail Reference List */
    public static function shows()
    {
        $mail_references = MailReference::all();
        return view('app.mails.settings.reference.reference-list', compact('mail_references'));
    }

    /** Create Mail Reference */
    public static function create()
    {
        return view('app.mails.settings.reference.reference-add');
    }

    /** Store Mail Reference */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Reference
        MailReference::create([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return redirect('/surat/pengaturan/sifat-surat');
    }

    /** Edit Mail Reference */
    public static function edit($id)
    {
        $mail_reference = MailReference::findOrFail($id);
        return view('app.mails.settings.reference.reference-edit', compact('mail_reference'));
    }

    /** Update Mail Reference */
    public static function update(MailComponentsRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail Referenceis Exists
        $mail_reference = MailReference::findOrFail($id);

        // Update Mail Reference
        $mail_reference->update([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return redirect('/surat/pengaturan/sifat-surat');
    }

    /** Delete Mail Reference */
    public static function delete($id)
    {
        // Check Mail Reference is Exists
        $mail_reference = MailReference::findOrFail($id);
        $mail_reference->delete();
        return redirect('/surat/pengaturan/sifat-surat');
    }
}
