<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use jeremykenedy\LaravelLogger\App\Http\Traits\IpAddressDetails;
use jeremykenedy\LaravelLogger\App\Http\Traits\UserAgentDetails;

class UserController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use IpAddressDetails;
    use UserAgentDetails;
    use ValidatesRequests;
    private $_rolesEnabled;
    private $_rolesMiddlware;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        ActivityLogger::activity(trans('users.loggerofshowall'));

        return view('dashbord.users.index');
    }

    public function create()
    {
        ActivityLogger::activity('تسجيل عرض صفحة إنشاء المستخدمين');

        $user_types = UserType::all()->where('id', '!=', 1);
        $Cities = City::all();

        return view('dashbord.users.create')->with('user_types', $user_types)->with('Cities', $Cities); // تعديل الرسالة إلى اللغة العربية
    }

    public function store(Request $request)
    {
        $messages = [
            'first_name.required' => trans('users.first_name_R'),
            'last_name.required' => trans('users.last_name_R'),
            'username.required' => trans('users.username_R'),
            'address.required' => trans('users.address_R'),
            'email.required' => trans('users.email_R'),
            'phonenumber.required' => trans('users.phonenumber_R'),
            'user_type_id.required' => trans('users.user_type_id_R'),
        ];
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'address' => ['required'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phonenumber' => 'required|digits_between:10,10|numeric|starts_with:091,092,094,021|unique:users',
            'user_type_id' => ['required'],
        ], $messages);
        try {
            DB::transaction(function () use ($request) {
                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->username = $request->username;

                $user->cities_id = decrypt($request->address);
                $user->phonenumber = $request->phonenumber;

                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->user_type_id = decrypt($request->user_type_id);
                $user->active = 1;
                $user->save();
            });

            Alert::success(trans('users.successusersadd'));
            ActivityLogger::activity($request->email . trans('users.logeeraddusersfaul'));

            return redirect()->route('users');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->email . trans('users.logeeraddusersfaul'));

            return redirect()->route('users');
        }
    }

    public function users()
    {
        $user = User::with(['userType', 'cities'])->select('*')->where('id', '!=', auth()->id())->orderBy('created_at', 'DESC');
        return datatables()->of($user)
            ->addColumn('changeStatus', function ($user) {
                $user_id = encrypt($user->id);

                return '<a href="' . route('users/changeStatus', $user_id) . '"><i  class="fa  fa-refresh"> </i></a>';
            })
        
            ->addColumn('edit', function ($user) {
                $user_id = encrypt($user->id);

                return '<a style="color: #f97424;" href="' . route('users/edit', $user_id) . '"><i  class="fa  fa-edit"> </i></a>';
            })
          
            ->rawColumns(['changeStatus',  'edit'])
            ->make(true);
    }

    public function edit($id)
    {
        $user_id = decrypt($id);
        $user = User::find($user_id);
        $user_types = UserType::all()->where('id', '!=', 1);
        ActivityLogger::activity($user->email . trans('users.loggerofedituserspage'));
        $Cities = City::all();

        return view('dashbord.users.edit')
            ->with('user_types', $user_types)
            ->with('user', $user)->with('Cities', $Cities);
    }

    public function update(Request $request, $id)
    {
        $user_id = decrypt($id);

        $messages = [
            'first_name.required' => trans('users.first_name_R'),
            'last_name.required' => trans('users.last_name_R'),
            'username.required' => trans('users.username_R'),
            'address.required' => trans('users.address_R'),
            'email.required' => trans('users.email_R'),
            'phonenumber.required' => trans('users.phonenumber_R'),
            'user_type_id.required' => trans('users.user_type_id_R'),
        ];
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50'],
            'address' => ['required'],
            'phonenumber' => 'required|digits_between:10,10|numeric|starts_with:091,092,094,021|unique:users',
            'user_type_id' => ['required'],
            'email' => 'required|email|max:50|string|unique:users,email,' . $user_id,
        ], $messages);
        try {
            DB::transaction(function () use ($request, $id) {
                $user_id = decrypt($id);
                $user = User::find($user_id);
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->username = $request->username;
                $user->cities_id = decrypt($request->address);
                $user->phonenumber = $request->phonenumber;
                $user->email = $request->email;
                $user->user_type_id = decrypt($request->user_type_id);
                $user->active = 1;

                $user->save();

                ActivityLogger::activity($user->email . trans('users.logeeredituserseccess'));
            });
            Alert::success(trans('users.successuseredit'));

            return redirect()->route('users');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->email . trans('users.logeeredituserfaulss'));

            return redirect()->route('users');
        }
    }

    public function show($id)
    {
        $user_id = decrypt($id);
        $user = User::find($user_id);
        ActivityLogger::activity(trans('users.profilelogger'));

        return view('dashbord.users.profile')->with('user', $user);
    }

    public function showChangePasswordForm()
    {
        ActivityLogger::activity(trans('users.changepasslogger'));

        return view('dashbord.users.change_form');
    }

    public function changePassword(Request $request)
    {
        $messages = [
            'current-password.required' => trans('users.current-password_r'),
            'new-password.required' => trans('users.new-password_r'),
            'new-password-confirm.required' => trans('users.new-password-confirm'),
        ];

        $this->validate($request, [
            'current-password' => ['required', 'string', 'min:6'],
            'new-password' => ['required', 'string', 'min:6'],
            'new-password-confirm' => ['required', 'same:new-password', 'string', 'min:6'],
        ], $messages);
        if (!(Hash::check($request->input('current-password'), Auth::user()->password))) {
            ActivityLogger::activity(trans('users.changefailloogger'));
            Alert::warning(trans('users.passwordnotmatcheing'));
            return redirect()->back();
        }
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->input('new-password'));
        $user->save();
        ActivityLogger::activity(trans('users.changesecclogger'));
        Alert::success(trans('users.changesecc'));
        return redirect()->back();
    }

    public function changeStatus(Request $request, $id)
    {
        $user_id = decrypt($id);
        $user = User::find($user_id);

        try {
            DB::transaction(function () use ($request, $id) {
                $user_id = decrypt($id);
                $user = User::find($user_id);
                if ($user->active == 1) {
                    $active = 0;
                } else {
                    $active = 1;
                }

                $user->active = $active;
                $user->save();
            });
            ActivityLogger::activity($user->email . trans('users.changestatueslogger'));
            Alert::success(trans('users.changestatuesalert'));

            return redirect('users');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($user->email . trans('users.changestatuesloggerfail'));

            return redirect('users');
        }
    }

    public function myactivity(Request $request)
    {
        ActivityLogger::activity("عرض سجلاتي");
        if (config('LaravelLogger.loggerPaginationEnabled')) {
            $activities = config('LaravelLogger.defaultActivityModel')::where('userId', auth::user()->id)->orderBy('created_at', 'desc');
            if (config('LaravelLogger.enableSearch')) {
                $activities = $this->searchActivityLog($activities, $request);
            }
            $activities = $activities->paginate(config('LaravelLogger.loggerPaginationPerPage'))->withQueryString();
            $totalActivities = $activities->total();
        } else {
            $activities = config('LaravelLogger.defaultActivityModel')::orderBy('created_at', 'desc');

            if (config('LaravelLogger.enableSearch')) {
                $activities = $this->searchActivityLog($activities, $request);
            }
            $activities = $activities->get();
            $totalActivities = $activities->count();
        }

        self::mapAdditionalDetails($activities);

        if (config('LaravelLogger.enableLiveSearch')) {
            // We are querying only the paginated userIds because in a big application querying all user data is performance heavy
            $user_ids = array_unique($activities->pluck('userId')->toArray());
            $users = config('LaravelLogger.defaultUserModel')::whereIn(config('LaravelLogger.defaultUserIDField'), $user_ids)->get();
        } else {
            $users = config('LaravelLogger.defaultUserModel')::all();
        }

        $data = [
            'activities' => $activities,
            'totalActivities' => $totalActivities,
            'users' => $users,
        ];
        return view('dashbord.users.myactivity', $data);
    }

    public function searchActivityLog($query, $request)
    {
        if (in_array('description', explode(',', config('LaravelLogger.searchFields'))) && $request->get('description')) {
            $query->where('description', 'like', '%' . $request->get('description') . '%');
        }

        if (in_array('user', explode(',', config('LaravelLogger.searchFields'))) && (int) $request->get('user')) {
            $query->where('userId', '=', (int) $request->get('user'));
        }

        if (in_array('method', explode(',', config('LaravelLogger.searchFields'))) && $request->get('method')) {
            $query->where('methodType', '=', $request->get('method'));
        }

        if (in_array('route', explode(',', config('LaravelLogger.searchFields'))) && $request->get('route')) {
            $query->where('route', 'like', '%' . $request->get('route') . '%');
        }

        if (in_array('ip', explode(',', config('LaravelLogger.searchFields'))) && $request->get('ip_address')) {
            $query->where('ipAddress', 'like', '%' . $request->get('ip_address') . '%');
        }

        return $query;
    }

    private function mapAdditionalDetails($collectionItems)
    {
        $collectionItems->map(function ($collectionItem) {
            $eventTime = Carbon::parse($collectionItem->updated_at);
            $collectionItem['timePassed'] = $eventTime->diffForHumans();
            $collectionItem['userAgentDetails'] = UserAgentDetails::details($collectionItem->userAgent);
            $collectionItem['langDetails'] = UserAgentDetails::localeLang($collectionItem->locale);
            $collectionItem['userDetails'] = config('LaravelLogger.defaultUserModel')::find($collectionItem->userId);

            return $collectionItem;
        });

        return $collectionItems;
    }
}
