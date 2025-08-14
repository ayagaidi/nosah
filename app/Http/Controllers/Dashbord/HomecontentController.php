<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Homecontent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HomecontentController extends Controller
{
    public function index()
    {
        $homecontent = Homecontent::first();
        return view('dashbord.homecontent.index', compact('homecontent'));
    }

    public function create()
    {
        $existing = Homecontent::first();
        if ($existing) {
            Alert::warning('لا يمكن إضافة أكثر من محتوى واحد.');
            return redirect()->route('homecontent.edit', $existing->id);
        }
        return view('dashbord.homecontent.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'clinics_title' => 'required|string|max:255',
            'clinics_text' => 'required|string',
            'inbody_title' => 'required|string|max:255',
            'inbody_text' => 'required|string',
            'banner_title' => 'required|string|max:255',
            'banner_text' => 'required|string',
            'video_url' => 'nullable|url|max:255',
        ]);
        try {
            DB::transaction(function () use ($request) {
                \App\Models\Homecontent::create($request->only([
                    'clinics_title', 'clinics_text',
                    'inbody_title', 'inbody_text',
                    'banner_title', 'banner_text',
                    'video_url'
                ]));
            });
            Alert::success('تمت إضافة المحتوى بنجاح.');
            return redirect()->route('homecontent.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('homecontent.index');
        }
    }

    public function edit($id)
    {
        $homecontent = Homecontent::findOrFail($id);
        return view('dashbord.homecontent.edit', compact('homecontent'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'clinics_title' => 'required|string|max:255',
            'clinics_text' => 'required|string',
            'inbody_title' => 'required|string|max:255',
            'inbody_text' => 'required|string',
            'banner_title' => 'required|string|max:255',
            'banner_text' => 'required|string',
            'video_url' => 'nullable|url|max:255',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $homecontent = \App\Models\Homecontent::findOrFail($id);
                $homecontent->update($request->only([
                    'clinics_title', 'clinics_text',
                    'inbody_title', 'inbody_text',
                    'banner_title', 'banner_text',
                    'video_url'
                ]));
            });
            Alert::success('تم تعديل المحتوى بنجاح.');
            return redirect()->route('homecontent.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('homecontent.index');
        }
    }

    public function destroy($id)
    {
        try {
            $homecontent = Homecontent::findOrFail($id);
            $homecontent->delete();
            Alert::success('تم حذف المحتوى بنجاح.');
            return redirect()->route('homecontent.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('homecontent.index');
        }
    }
}
