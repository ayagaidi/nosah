<?php

namespace App\Http\Controllers\Dashbord;

use App\Models\contactinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class ContactinfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ContactInfo=contactinfo::first();
        ActivityLogger::activity('عرض معلومات الاتصال');
        return view('dashbord.contactinfo.index')->with('ContactInfo',$ContactInfo);
    }

    public function infos()
    {
        $infos = contactinfo::orderBy('created_at','DESC');
        return datatables()->of($infos)
            ->addColumn('email', function($info){
                return $info->email;
            })
            ->addColumn('edit', function($info){
                $id = encrypt($info->id);
                return '<a href="'.route('contactinfos/edit',$id).'" class="text-warning"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('delete', function($info){
                $id = encrypt($info->id);
                return '<form action="'.route('contactinfos/delete',$id).'" method="POST" style="display:inline">'
                    . method_field('DELETE') . csrf_field()
                    . '<button class="btn btn-link p-0 text-danger"><i class="fa fa-trash"></i></button></form>';
            })
            ->rawColumns(['email','edit','delete'])
            ->make(true);
    }

    public function create()
    {
        ActivityLogger::activity('صفحة إضافة معلومات الاتصال');
        return view('dashbord.contactinfo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phonenumber' => 'required|string|max:50|unique:contactinfos,phonenumber',
            'email'       => 'required|email|unique:contactinfos,email',
        ]);

        try {
            DB::transaction(fn() => contactinfo::create($request->only('phonenumber','email')));
            Alert::success('تم إضافة معلومات الاتصال بنجاح');
            ActivityLogger::activity('إضافة معلومات الاتصال');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
        }
        return redirect()->route('contactinfos');
    }

    public function edit($id)
    {
        $info = contactinfo::findOrFail(decrypt($id));
        ActivityLogger::activity('صفحة تعديل معلومات الاتصال');
        return view('dashbord.contactinfo.edit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'phonenumber' => 'required|string|max:50',
            'email'       => 'required|email',
        ]);

        try {
            DB::transaction(fn() => contactinfo::findOrFail($id)
                ->update($request->only('phonenumber','email'))
            );
            Alert::success('تم تعديل معلومات الاتصال بنجاح');
            ActivityLogger::activity('تعديل معلومات الاتصال');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
        }
        return redirect()->route('contactinfos');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        contactinfo::findOrFail($id)->delete();
        Alert::success('تم حذف معلومات الاتصال بنجاح');
        ActivityLogger::activity('حذف معلومات الاتصال');
        return redirect()->back();
    }
}
