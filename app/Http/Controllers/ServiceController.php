<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\VehicleModel;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();

        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/services/'), $filename);
        }

        if ($request->hasFile('icon'))
        {
            $iconFile = $request->file('icon');
            $iconFilename = time().'.'.$iconFile->getClientOriginalExtension();
            $iconFile->move(public_path('uploads/service-icons/'), $iconFilename);
        }

        Service::create([
            'name'              => $request->name,
            'price'             => $request->price,
            'manufacture_name'  => $request->manufacture_name,
            'model_name'        => $request->model,
            'start_date'        => Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d H:i:s'),
            'end_date'          => Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d H:i:s'),
            'description'       => $request->description,
            'short_description' => $request->short_description,
            'service_icon'      => isset($iconFilename) ? 'uploads/service-icons/'.$iconFilename : NULL,
            'image'             => isset($filename) ? 'uploads/services/'.$filename : NULL

        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function autocompleteModel(Request $request)
    {
        $searchTerm = $request->input('input');
        $products = VehicleModel::where('model_name', 'like', '%' . $searchTerm . '%')->get(['id', 'model_name']);

        return response()->json($products);
    }

    public function show(Service $service)
    {
        //
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service = Service::where('id', $service->id)->first();
        $oldService = NULL;
        $oldServiceIcon = NULL;
        if($service != '') {
            $oldService = $service->image;
            $oldServiceIcon = $service->service_icon;
        }

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/services/'), $filename);
        }
        if ($request->hasFile('icon'))
        {
            $iconFile = $request->file('icon');
            $iconFilename = time().'.'.$iconFile->getClientOriginalExtension();
            $iconFile->move(public_path('uploads/service-icons/'), $iconFilename);
        }

        $service->update([
            'name'              => $request->name,
            'price'             => $request->price,
            'manufacture_name'  => $request->manufacture_name,
            'model_name'        => $request->model,
            'start_date'        => Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d H:i:s'),
            'end_date'          => Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d H:i:s'),
            'description'       => $request->description,
            'short_description' => $request->short_description,
            'service_icon'      => isset($iconFilename) ? 'uploads/service-icons/'.$iconFilename : $oldServiceIcon,
            'image'             => isset($filename) ? 'uploads/services/'.$filename : $oldService
        ]);

        return redirect()->route('services.index')->with('success', 'Services updated successfully.');
    }

    public function destroy(string $id)
    {
        Service::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.'
        ]);
    }
}
