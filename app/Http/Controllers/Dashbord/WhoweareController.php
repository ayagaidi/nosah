<?php

namespace App\Http\Controllers\Dashbord;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutUs;
use App\Models\AboutUsContent;

use App\Models\whoweare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class WhoweareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $whoweare = whoweare::first();
        return view('dashbord.whoweare.index', compact('whoweare'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $existingEntry = whoweare::first();
        if ($existingEntry) {
            Alert::warning('لا يمكن إضافة أكثر من نص واحد.');
            return redirect()->route('whoweare.edit', $existingEntry->id);
        }

        return view('dashbord.whoweare.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => ['required', 'string'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                $whoweare = new whoweare();
                $whoweare->content = $request->content;

           
                $whoweare->save();
            });

            Alert::success('تمت إضافة النص بنجاح.');
            return redirect()->route('whoweare');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('whoweare');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(whoweare $whoweare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $whoweare = whoweare::findOrFail($id);
        return view('dashbord.whoweare.edit', compact('whoweare'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => ['required', 'string'],
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $whoweare = whoweare::findOrFail($id);
                $whoweare->content = $request->content;


                $whoweare->save();
            });

            Alert::success('تم تعديل النص بنجاح.');
            return redirect()->route('whoweare');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('whoweare');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $whoweare = whoweare::findOrFail($id);
            $whoweare->delete();

            Alert::success('تم حذف النص بنجاح.');
            return redirect()->route('whoweare');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('whoweare');
        }
    }
}
