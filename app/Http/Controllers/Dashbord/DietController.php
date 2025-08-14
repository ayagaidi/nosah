<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Diet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class DietController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $diets = Diet::orderBy('created_at', 'DESC')->get();
        return view('dashbord.diet.index', compact('diets'));
    }

    public function create()
    {
        return view('dashbord.diet.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        try {
            DB::transaction(function () use ($request) {
                $diet = new Diet();
                $diet->title = $request->title;
                $diet->text = $request->text;
                if ($request->file('image')) {
                    $fileObject = $request->file('image');
                    $image = "diets" . time() . ".jpg";
                    $fileObject->move('images/diets/', $image);
                    $diet->image = $image;
                } 
              
                
                $diet->save();
            });
            Alert::success('تمت إضافة الحمية بنجاح.');
            return redirect()->route('diets.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('diets.index');
        }
    }

    public function edit($id)
    {
        $diet = Diet::findOrFail($id);
        return view('dashbord.diet.edit', compact('diet'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $diet = Diet::findOrFail($id);
                $diet->title = $request->title;
                $diet->text = $request->text;
                if ($request->file('image')) {
                    $fileObject = $request->file('image');
                    $image = "diets" . time() . ".jpg";
                    $fileObject->move('images/diets/', $image);
                    $diet->image = $image;
                } 
                $diet->save();
            });
            Alert::success('تم تعديل الحمية بنجاح.');
            return redirect()->route('diets.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('diets.index');
        }
    }

    public function destroy($id)
    {
        try {
            $diet = Diet::findOrFail($id);
            $diet->delete();
            Alert::success('تم حذف الحمية بنجاح.');
            return redirect()->route('diets.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('diets.index');
        }
    }

    public function data()
    {
        $diets = \App\Models\Diet::orderBy('created_at', 'DESC');
        return datatables()->of($diets)
            ->addColumn('edit', function ($diet) {
                return '<a style="color: #f97424;" href="' . route('diets.edit', $diet->id) . '"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('publish', function ($diet) {
                $btnClass = $diet->published ? 'btn-success' : 'btn-secondary';
                $btnText = $diet->published ? 'إلغاء نشر' : 'نشر';
                $icon = $diet->published ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
                return '<button class="btn btn-sm '.$btnClass.' toggle-publish-diet"'
                    . ' data-id="'.$diet->id.'"'
                    . ' data-published="'.$diet->published.'"'
                    . ' data-toggle="tooltip" title="'.$btnText.'">'
                    . $icon.' '.$btnText
                    . '</button>';
            })
          
            ->addColumn('image', function ($diet) {
                return $diet->image
                    ? '<img src="' . asset('images/diets/'.$diet->image) . '" alt="صورة الحمية" style="max-width:80px;">'
                    : 'لا يوجد';
            })
            ->addColumn('status', function ($diet) {
                return $diet->published ? 'منشور' : 'غير منشور';
            })
            ->rawColumns(['edit',  'image', 'publish'])
            ->make(true);
    }
    public function togglePublish(Request $request)
    {
        $diet_id = $request->id;
        $diet = \App\Models\Diet::findOrFail($diet_id);
        $diet->published = !$diet->published;
        $diet->save();

        ActivityLogger::activity(($diet->published ? 'تم نشر' : 'تم إلغاء نشر') . ' الحمية: ' . $diet->title);

        return response()->json([
            'success' => true,
            'published' => $diet->published,
            'message' => $diet->published ? 'تم نشر الحمية' : 'تم إلغاء نشر الحمية'
        ]);
    }
}
