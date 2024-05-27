<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = EmailTemplate::latest()->get();

        return view('emails.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emails.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        EmailTemplate::create([
            'email_template' => $request->template,
            'content'        => $request->content,
            'status'         => $request->status
        ]);

        return redirect()->route('emails.index')->with('success', 'Email created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailTemplate $email)
    {
        $email = EmailTemplate::where('id', $email->id)->first();

        return view('emails.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailTemplate $email)
    {
        EmailTemplate::where('id', $email->id)->update([
            'email_template' => $request->template,
            'content'        => $request->content,
            'status'         => $request->status
        ]);

        return redirect()->route('emails.index')->with('success', 'Email updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        EmailTemplate::where('id', $emailTemplate->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Email Template deleted successfully.'
        ]);
    }
}
