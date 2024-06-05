<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(setting $setting)
    {
        //
    }

    public function generalSetting(Request $request)
    {
        $datas = $request->all();
        $skippedArray = array_slice($datas, 1, null, true);
        $banner = Setting::where('key','banner')->first();
        $oldBanner = NULL;
        if($banner != '') {
            $oldBanner = $banner->value;
        }
        if ($request->hasFile('banner'))
        {

            $file = $request->file('banner');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/banners/'), $filename);
        }
        $skippedArray['banner'] = isset($filename) ? 'uploads/banners/'. $filename : $oldBanner;

        $logo = Setting::where('key','logo')->first();
        $oldLogo = NULL;
        if($logo != '') {
            $oldLogo = $logo->value;
        } 
        if ($request->hasFile('logo'))
        {
            $fileLogo = $request->file('logo');
            $filenameLogo = time().'.'.$fileLogo->getClientOriginalExtension();
            $fileLogo->move(public_path('uploads/logo/'), $filenameLogo);
        }
        $skippedArray['logo'] = isset($filenameLogo) ? 'uploads/logo/'.$filenameLogo : $oldLogo;

        if($request->timings)
        {
            $skippedArray['timings'] = json_encode($request->timings);
        }

        foreach ($skippedArray as $key => $value)
        {
            Setting::updateOrCreate([
                'key' => $key,
            ],[
                'value' => $value
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Setting updated successfully');
    }
}
