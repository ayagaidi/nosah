<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Clinic;
use App\Models\contactinfo;
use App\Models\Diet;
use App\Models\doctor;
use App\Models\Homecontent;
use App\Models\Inbodydevices;
use App\Models\Inbox;
use App\Models\whoweare;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loginhome()
    {
        if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
        return view('loginhome');
    }
    public function index()
    {

         if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
        $whoweare = whoweare::first();

        $articles = Articles::with('users')
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->limit(2)       // or ->take(2)
            ->get();
        $home = Homecontent::first();
        return view('index')->with('home', $home)
            ->with('articles', $articles)
            ->with('whoweare', $whoweare);
    }


    public function clinics(Request $request)
    {
         if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
        $search = $request->input('search');
        $query = Clinic::with('cities')->where('active', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('address', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhereHas('cities', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $clinics = $query->paginate(12)->appends(['search' => $search]);

        return view('clinics')->with('clinics', $clinics);
    }


    public function doctors()
    {

         if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
        $doctors = doctor::where('active', 1)->orderBy('created_at', 'DESC')->paginate(6);
        return view('doctors')->with('doctors', $doctors);
    }


    public function diets()
    {
         if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }

        $diets = Diet::where('published', 1)->orderBy('created_at', 'DESC')->paginate(6);
        return view('diet')->with('diets', $diets);
    }

    public function showDiet($id)
    {
        if (Auth::guard('patient')->check()) {
            return redirect()->route('patient.dashboard');
        } elseif (Auth::guard('doctor')->check()) {
            return redirect()->route('doctor.dashboard');
        } elseif (Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }
        $diets = Diet::where('published', 1)->orderBy('created_at', 'DESC')->paginate(6);

        $diet = Diet::where('published', 1)->findOrFail($id);
        return view('diet_show')->with('diet', $diet)
        ->with('diets', $diets);
    }

    public function articals()
    {

         if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
        $articals = Articles::with('users')->where('published', 1)->orderBy('created_at', 'DESC')->paginate(6);
        return view('articals')->with('articals', $articals);
    }

    public function showArticle($id)
    {
        if (Auth::guard('patient')->check()) {
            return redirect()->route('patient.dashboard');
        } elseif (Auth::guard('doctor')->check()) {
            return redirect()->route('doctor.dashboard');
        } elseif (Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        $article = Articles::with('users')->where('published', 1)->findOrFail($id);
        $articals = Articles::with('users')->where('published', 1)->orderBy('created_at', 'DESC')->paginate(6);

        return view('article_show')->with('article', $article)
        ->with('articals',$articals);
    }
    public function contact()
    {
         if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
        $contactinfo = contactinfo::first();
        return view('contact')->with('contactinfo', $contactinfo);
    }

    public function store(Request $request)
    {
        // validate incoming data
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // insert into inbox
            Inbox::create($request->only('name', 'email', 'message'));

            DB::commit();

            // success alert
            Alert::success('نجاح', 'تم إرسال رسالتك بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            // error alert
            Alert::error('خطأ', 'حدث خطأ ما. حاول مرة أخرى.');
        }

        return back();
    }


    public function inbody(Request $request)
    {
         if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.dashboard');
    } elseif (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    } elseif (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
        $search = $request->input('search');
        $query = Inbodydevices::where('active', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('place_name', 'like', "%{$search}%")
                    ->orWhere('device_model', 'like', "%{$search}%")
                    ->orWhereHas('cities', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $inbodydevices = $query->paginate(12)->appends(['search' => $search]);

        return view('inbody')->with('inbodydevices', $inbodydevices);
    }
}
