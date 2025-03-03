<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'heading' => 'required',
        ]);

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonals/'), $filename);
        }

        Testimonial::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'heading' => $request->heading,
            'feedback' => $request->feedback,
            'image' => isset($filename) ? 'uploads/testimonals/'.$filename : NULL,
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function show(Testimonial $testimonial)
    {
        //
    }

    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'heading' => 'required',
        ]);

        $oldImage = NULL;
        if ($testimonial->image == NULL) {
            $oldImage = $testimonial->image;
        }

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonals/'), $filename);
            $testimonial->image = 'uploads/testimonals/'.$filename;
        }

        $testimonial->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'heading' => $request->heading,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.'
        ]);
    }
}
