<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();

        return view('faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer'   => 'required',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer'   => $request->answer
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ created successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $faq = Faq::where('id', $id)->first();

        return view('faq.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer'   => 'required',
        ]);

        $faq = Faq::where('id', $id)->first();
        $faq->update([
            'question' => $request->question,
            'answer'   => $request->answer
        ]);

        return redirect()->route('faqs.index')->with('success', 'Faq Updated successfully.');
    }

    public function destroy(string $id)
    {
        $faq = Faq::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Faq deleted successfully.'
        ]);
    }
}
