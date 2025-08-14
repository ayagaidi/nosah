<?php

use App\Http\Controllers\Dashbord\ArticleController;
use App\Http\Controllers\Dashbord\InboxController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Patient\ChatController;
use App\Http\Controllers\Patient\HomeController;

// Existing routes...

Auth::routes(['register' => false]);
Route::get('refreshcaptcha', [App\Http\Controllers\Auth\LoginController::class, 'refreshcaptcha'])->name('refreshcaptcha');
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('/');
Route::get('inbody', [App\Http\Controllers\IndexController::class, 'inbody'])->name('inbody');
Route::get('clinic', [App\Http\Controllers\IndexController::class, 'clinics'])->name('clinic');
Route::get('doctorsall', [App\Http\Controllers\IndexController::class, 'doctors'])->name('doctorsall');

Route::get('diet', [App\Http\Controllers\IndexController::class, 'diets'])->name('diet');
Route::get('diet/{id}', [App\Http\Controllers\IndexController::class, 'showDiet'])->name('diet.show');

Route::get('contact', [App\Http\Controllers\IndexController::class, 'contact'])->name('contact');
Route::post('contact', [App\Http\Controllers\IndexController::class, 'store'])->name('inbox.store');
Route::get('articals', [App\Http\Controllers\IndexController::class, 'articals'])->name('articals');
Route::get('article/{id}', [App\Http\Controllers\IndexController::class, 'showArticle'])->name('article.show');
Route::get('login/home', [App\Http\Controllers\IndexController::class, 'loginhome'])->name('login/home');

Route::post('forgot-password', [App\Http\Controllers\Auth\LoginController::class, 'handleForgotPassword'])->name('forgot-password.post');




Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\DoctorLoginController::class, 'showLoginForm'])->name('login');

    // Forgot password routes
    Route::get('forgot-password', [App\Http\Controllers\Auth\DoctorLoginController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [App\Http\Controllers\Auth\DoctorLoginController::class, 'handleForgotPassword'])->name('forgot-password.post');
    Route::post('login', [App\Http\Controllers\Auth\DoctorLoginController::class, 'login']);
    Route::get('dashboard', [App\Http\Controllers\Doctor\HomeController::class, 'index'])->name('dashboard');
    Route::post('dashboard', [App\Http\Controllers\Doctor\HomeController::class, 'searchPatient'])->name('searchPatient');


    Route::post('logout', [App\Http\Controllers\Auth\DoctorLoginController::class, 'logout'])->name('logout');
    Route::get('changepassword/{id}', [App\Http\Controllers\Doctor\HomeController::class, 'showChangePasswordForm'])->name('changepassword.form');
    Route::POST('changepassword/{id}', [App\Http\Controllers\Doctor\HomeController::class, 'changePassword'])->name('changepassword');
    Route::get('profile/{id}', [App\Http\Controllers\Doctor\HomeController::class, 'show'])->name('profile');

      //----------------------------inbox-----------------------------------------------------------------       

  
    // Patient routes for doctor
    Route::get('patients', [App\Http\Controllers\Doctor\PatientController::class, 'index'])->name('patients');
    Route::get('patients/patients', [App\Http\Controllers\Doctor\PatientController::class, 'patients'])->name('patients.patients');
    Route::get('patients/create', [App\Http\Controllers\Doctor\PatientController::class, 'create'])->name('patients.create');
    Route::post('patients/create', [App\Http\Controllers\Doctor\PatientController::class, 'store'])->name('patients.store');
    Route::get('patients/edit/{id}', [App\Http\Controllers\Doctor\PatientController::class, 'edit'])->name('patients.edit');
    Route::post('patients/edit/{id}', [App\Http\Controllers\Doctor\PatientController::class, 'update'])->name('patients.update');
    Route::get('patients/change-status/{id}', [App\Http\Controllers\Doctor\PatientController::class, 'changeStatus'])->name('patients.changeStatus');
    Route::get('patients/show/{id}', [App\Http\Controllers\Doctor\PatientController::class, 'show'])->name('patients.show');

    Route::post('patients/generate-password/{patient}', [App\Http\Controllers\Doctor\PatientController::class, 'generateNewPassword'])->name('patients.generatePassword');

    Route::get('patients/send-whatsapp/{patient}', [App\Http\Controllers\Doctor\PatientController::class, 'sendPatientDataWhatsApp'])->name('patients.sendWhatsApp');

    Route::prefix('patients/{patient}/diet-plans')->name('diet_plans.')->group(function () {
        Route::get('/', [App\Http\Controllers\Doctor\PatientDietPlanController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\Doctor\PatientDietPlanController::class, 'create'])->name('create');
        Route::post('store', [App\Http\Controllers\Doctor\PatientDietPlanController::class, 'store'])->name('store');
        Route::get('{plan}', [App\Http\Controllers\Doctor\PatientDietPlanController::class, 'show'])->name('show');
        Route::get('{plan}/edit', [App\Http\Controllers\Doctor\PatientDietPlanController::class, 'edit'])->name('edit');
        Route::put('{plan}/update', [App\Http\Controllers\Doctor\PatientDietPlanController::class, 'update'])->name('update');
        Route::delete('{plan}/delete', [App\Http\Controllers\Doctor\PatientDietPlanController::class, 'destroy'])->name('delete');
    });
});
Route::namespace('Dashbord')->group(function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('users', [App\Http\Controllers\Dashbord\UserController::class, 'index'])->name('users');
    Route::get('users/create', [App\Http\Controllers\Dashbord\UserController::class, 'create'])->name('users/create');
    Route::post('users/create', [App\Http\Controllers\Dashbord\UserController::class, 'store'])->name('users/store');;
    Route::get('users/users', [App\Http\Controllers\Dashbord\UserController::class, 'users'])->name('users/users');
    Route::get('users/changeStatus/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'changeStatus'])->name('users/changeStatus');
    Route::get('users/edit/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'edit'])->name('users/edit');
    Route::post('users/edit/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'update'])->name('users/update');
    Route::get('users/profile/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'show'])->name('users/profile');
    Route::get('users/changepassword/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'showChangePasswordForm'])->name('users/ChangePasswordForm');
    Route::POST('users/changepassword/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'changePassword'])->name('users/changepassword');
    Route::get('users/myactivity', [App\Http\Controllers\Dashbord\UserController::class, 'myactivity'])->name('users/myactivity');

    //----------------------------city-----------------------------------------------------------------       
    Route::get('cities', [App\Http\Controllers\Dashbord\CityController::class, 'index'])->name('cities');
    Route::get('cities/create', [App\Http\Controllers\Dashbord\CityController::class, 'create'])->name('cities/create');
    Route::post('cities/create', [App\Http\Controllers\Dashbord\CityController::class, 'store'])->name('cities/store');;
    Route::get('cities/cities', [App\Http\Controllers\Dashbord\CityController::class, 'cities'])->name('cities/cities');;
    Route::get('cities/edit/{id}', [App\Http\Controllers\Dashbord\CityController::class, 'edit'])->name('cities/edit');
    Route::post('cities/edit/{id}', [App\Http\Controllers\Dashbord\CityController::class, 'update'])->name('cities/update');
    Route::delete('cities/delete/{id}', [App\Http\Controllers\Dashbord\CityController::class, 'delete'])->name('cities/delete');

    //----------------------------specializations-----------------------------------------------------------------       
    Route::get('specializations', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'index'])->name('specializations');
    Route::get('specializations/create', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'create'])->name('specializations/create');
    Route::post('specializations/create', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'store'])->name('specializations/store');
    Route::get('specializations/specializations', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'specializations'])->name('specializations/specializations');
    Route::get('specializations/edit/{id}', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'edit'])->name('specializations/edit');
    Route::post('specializations/edit/{id}', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'update'])->name('specializations/update');
    Route::delete('specializations/delete/{id}', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'destroy'])->name('specializations/delete');
    Route::get('specializations/change-status/{id}', [App\Http\Controllers\Dashbord\SpecializationsController::class, 'changeStatus'])->name('specializations/changeStatus');

    // ----------------------------clinics-------------------------------
    Route::get('clinics', [App\Http\Controllers\Dashbord\ClinicController::class, 'index'])->name('clinics');
    Route::get('clinics/create', [App\Http\Controllers\Dashbord\ClinicController::class, 'create'])->name('clinics/create');
    Route::post('clinics/create', [App\Http\Controllers\Dashbord\ClinicController::class, 'store'])->name('clinics/store');
    Route::get('clinics/clinics', [App\Http\Controllers\Dashbord\ClinicController::class, 'clinics'])->name('clinics/clinics');
    Route::get('clinics/edit/{id}', [App\Http\Controllers\Dashbord\ClinicController::class, 'edit'])->name('clinics/edit');
    Route::post('clinics/edit/{id}', [App\Http\Controllers\Dashbord\ClinicController::class, 'update'])->name('clinics/update');
    Route::delete('clinics/delete/{id}', [App\Http\Controllers\Dashbord\ClinicController::class, 'destroy'])->name('clinics/delete');
    Route::get('clinics/change-status/{id}', [App\Http\Controllers\Dashbord\ClinicController::class, 'changeStatus'])->name('clinics/changeStatus');
    Route::get('clinics/doctors/{clinic}', [App\Http\Controllers\Dashbord\ClinicController::class, 'doctors'])->name('clinics/doctors');

    Route::get('inbox', [InboxController::class, 'index'])->name('inbox');
  Route::get('inbox/inbox', [InboxController::class, 'inbox'])->name('inbox/inbox');

    //----------------------------inbodydevices-----------------------------------------------------------------       
    Route::get('inbodydevices', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'index'])->name('inbodydevices');
    Route::get('inbodydevices/create', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'create'])->name('inbodydevices/create');
    Route::post('inbodydevices/create', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'store'])->name('inbodydevices/store');
    Route::get('inbodydevices/inbodydevices', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'inbodydevices'])->name('inbodydevices/inbodydevices');
    Route::get('inbodydevices/edit/{id}', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'edit'])->name('inbodydevices/edit');
    Route::post('inbodydevices/edit/{id}', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'update'])->name('inbodydevices/update');
    Route::delete('inbodydevices/delete/{id}', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'destroy'])->name('inbodydevices/delete');
    Route::get('inbodydevices/change-status/{id}', [App\Http\Controllers\Dashbord\InbodydevicesController::class, 'changeStatus'])->name('inbodydevices/changeStatus');


    //----------------------------whoweare-----------------------------------------------------------------
    Route::get('whoweare', [App\Http\Controllers\Dashbord\WhoweareController::class, 'index'])->name('whoweare');
    Route::get('whoweare/create', [App\Http\Controllers\Dashbord\WhoweareController::class, 'create'])->name('whoweare/create');
    Route::post('whoweare/store', [App\Http\Controllers\Dashbord\WhoweareController::class, 'store'])->name('whoweare/store');
    Route::get('whoweare/edit/{id}', [App\Http\Controllers\Dashbord\WhoweareController::class, 'edit'])->name('whoweare/edit');
    Route::put('whoweare/update/{id}', [App\Http\Controllers\Dashbord\WhoweareController::class, 'update'])->name('whoweare/update');
    Route::delete('whoweare/delete/{id}', [App\Http\Controllers\Dashbord\WhoweareController::class, 'destroy'])->name('whoweare/delete');

    //----------------------------doctors-----------------------------------------------------------------
    Route::get('doctorss', [App\Http\Controllers\Dashbord\DoctorController::class, 'index'])->name('doctorss');
    Route::get('doctors/doctors', [App\Http\Controllers\Dashbord\DoctorController::class, 'doctors'])->name('doctors/doctors');
    Route::get('doctors/create', [App\Http\Controllers\Dashbord\DoctorController::class, 'create'])->name('doctors/create');
    Route::post('doctors/create', [App\Http\Controllers\Dashbord\DoctorController::class, 'store'])->name('doctors/store');
    Route::get('doctors/edit/{id}', [App\Http\Controllers\Dashbord\DoctorController::class, 'edit'])->name('doctors/edit');
    Route::post('doctors/edit/{id}', [App\Http\Controllers\Dashbord\DoctorController::class, 'update'])->name('doctors/update');
    Route::delete('doctors/delete/{id}', [App\Http\Controllers\Dashbord\DoctorController::class, 'destroy'])->name('doctors/delete');
    Route::get('doctors/change-status/{id}', [App\Http\Controllers\Dashbord\DoctorController::class, 'changeStatus'])->name('doctors/changeStatus');
    Route::get('doctors/view/{id}', [App\Http\Controllers\Dashbord\DoctorController::class, 'show'])->name('doctors/view');
    Route::get('doctors/send-login/{id}', [App\Http\Controllers\Dashbord\DoctorController::class, 'sendLoginCredentials'])->name('doctors/sendLogin');
    Route::get('doctors/send-login-whatsapp/{id}', [App\Http\Controllers\Dashbord\DoctorController::class, 'sendLoginCredentialsWhatsApp'])->name('doctors/sendLoginWhatsApp');

    //----------------------------articles-----------------------------------------------------------------
    Route::get('articles', [App\Http\Controllers\Dashbord\ArticleController::class, 'index'])->name('articles');
    Route::get('articles/create', [App\Http\Controllers\Dashbord\ArticleController::class, 'create'])->name('articles/create');
    Route::post('articles/create', [App\Http\Controllers\Dashbord\ArticleController::class, 'store'])->name('articles/store');
    Route::get('articles/articles', [App\Http\Controllers\Dashbord\ArticleController::class, 'articles'])->name('articles/data');
    Route::get('articles/edit/{id}', [App\Http\Controllers\Dashbord\ArticleController::class, 'edit'])->name('articles/edit');
    Route::post('articles/edit/{id}', [App\Http\Controllers\Dashbord\ArticleController::class, 'update'])->name('articles/update');
    Route::delete('articles/delete/{id}', [App\Http\Controllers\Dashbord\ArticleController::class, 'delete'])->name('articles/delete');
    Route::post('articles/toggle-publish', [ArticleController::class, 'togglePublish'])->name('articles.togglePublish');

    //----------------------------contactinfos-----------------------------------------------------------------
    Route::get('contactinfos', [App\Http\Controllers\Dashbord\ContactinfoController::class, 'index'])
        ->name('contactinfos');
    Route::get('contactinfos/create', [App\Http\Controllers\Dashbord\ContactinfoController::class, 'create'])
        ->name('contactinfos/create');
    Route::post('contactinfos/create', [App\Http\Controllers\Dashbord\ContactinfoController::class, 'store'])
        ->name('contactinfos/store');
    Route::get('contactinfos/infos', [App\Http\Controllers\Dashbord\ContactinfoController::class, 'infos'])
        ->name('contactinfos/infos');
    Route::get('contactinfos/edit/{id}', [App\Http\Controllers\Dashbord\ContactinfoController::class, 'edit'])
        ->name('contactinfos/edit');
    Route::post('contactinfos/edit/{id}', [App\Http\Controllers\Dashbord\ContactinfoController::class, 'update'])
        ->name('contactinfos/update');
    Route::delete('contactinfos/delete/{id}', [App\Http\Controllers\Dashbord\ContactinfoController::class, 'delete'])
        ->name('contactinfos/delete');

    // ----------------------------homecontent-------------------------------
    Route::get('homecontent', [App\Http\Controllers\Dashbord\HomecontentController::class, 'index'])->name('homecontent.index');
    Route::get('homecontent/create', [App\Http\Controllers\Dashbord\HomecontentController::class, 'create'])->name('homecontent.create');
    Route::post('homecontent/store', [App\Http\Controllers\Dashbord\HomecontentController::class, 'store'])->name('homecontent.store');
    Route::get('homecontent/edit/{id}', [App\Http\Controllers\Dashbord\HomecontentController::class, 'edit'])->name('homecontent.edit');
    Route::put('homecontent/update/{id}', [App\Http\Controllers\Dashbord\HomecontentController::class, 'update'])->name('homecontent.update');
    Route::delete('homecontent/delete/{id}', [App\Http\Controllers\Dashbord\HomecontentController::class, 'destroy'])->name('homecontent.delete');

    // ----------------------------diet-------------------------------
    Route::get('diets', [App\Http\Controllers\Dashbord\DietController::class, 'index'])->name('diets.index');
    Route::get('diets/dataa', [App\Http\Controllers\Dashbord\DietController::class, 'data'])->name('diets/dataa');

    Route::get('diets/create', [App\Http\Controllers\Dashbord\DietController::class, 'create'])->name('diets.create');
    Route::post('diets/store', [App\Http\Controllers\Dashbord\DietController::class, 'store'])->name('diets.store');
    Route::get('diets/edit/{id}', [App\Http\Controllers\Dashbord\DietController::class, 'edit'])->name('diets.edit');
    Route::put('diets/update/{id}', [App\Http\Controllers\Dashbord\DietController::class, 'update'])->name('diets.update');
    Route::delete('diets/delete/{id}', [App\Http\Controllers\Dashbord\DietController::class, 'destroy'])->name('diets.delete');
    Route::post('diets/toggle-publish', [App\Http\Controllers\Dashbord\DietController::class, 'togglePublish'])->name('diets.togglePublish');
});

Route::prefix('doctor/diet-plans')->name('doctor.diet_plans.')->middleware('auth:doctor')->group(function () {
    Route::get('/search', [\App\Http\Controllers\Doctor\PatientDietPlanController::class, 'searchPatientForm'])->name('search.form');
    Route::post('/search', [\App\Http\Controllers\Doctor\PatientDietPlanController::class, 'searchPatient'])->name('search');
    Route::get('/{patient}/ajax', [\App\Http\Controllers\Doctor\PatientDietPlanController::class, 'ajax'])->name('ajax');
});
Route::prefix('doctor/appointments')->name('doctor.appointments.')->middleware('auth:doctor')->group(function () {
    Route::get('/search', [\App\Http\Controllers\Doctor\AppointmentController::class, 'searchForm'])->name('searchForm');
    Route::post('/search', [\App\Http\Controllers\Doctor\AppointmentController::class, 'search'])->name('search');
    Route::get('/{patient}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('index');
    Route::get('/{patient}/create', [\App\Http\Controllers\Doctor\AppointmentController::class, 'create'])->name('create');
    Route::post('/{patient}/store', [\App\Http\Controllers\Doctor\AppointmentController::class, 'store'])->name('store');
    Route::get('/{patient}/{appointment}/edit', [\App\Http\Controllers\Doctor\AppointmentController::class, 'edit'])->name('edit');
    Route::put('/{patient}/{appointment}/update', [\App\Http\Controllers\Doctor\AppointmentController::class, 'update'])->name('update');
    Route::get('/{patient}/ajax', [\App\Http\Controllers\Doctor\AppointmentController::class, 'ajax'])->name('ajax');
    Route::post('/toggle-attendance', [\App\Http\Controllers\Doctor\AppointmentController::class, 'toggleAttendance'])->name('toggleAttendance');
});
Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\PatientLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\PatientLoginController::class, 'login']);
    Route::get('logout', [App\Http\Controllers\Auth\PatientLoginController::class, 'logout'])->name('logout');

    // Forgot password routes
    Route::get('forgot-password', [App\Http\Controllers\Auth\PatientLoginController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [App\Http\Controllers\Auth\PatientLoginController::class, 'handleForgotPassword'])->name('forgot-password.post');

    Route::get('dashboard', [App\Http\Controllers\Patient\HomeController::class, 'index'])->name('dashboard');
    Route::get('diet-plan', [App\Http\Controllers\Patient\HomeController::class, 'dietplan'])->name('diet_plan');
    Route::get('diet-plan/all', [App\Http\Controllers\Patient\HomeController::class, 'dietplanajax'])->name('diet_plan.all');
    Route::get('diet-plan/showdietplan/{id}', [App\Http\Controllers\Patient\HomeController::class, 'showdietplan'])->name('diet_plan.showdietplan');
    Route::get('appointments', [App\Http\Controllers\Patient\HomeController::class, 'appointments'])->name('appointments');

    Route::get('changepassword/{id}', [App\Http\Controllers\Patient\HomeController::class, 'showChangePasswordForm'])->name('changepassword.form');
    Route::POST('changepassword/{id}', [App\Http\Controllers\Patient\HomeController::class, 'changePassword'])->name('changepassword');
    Route::get('profile', [App\Http\Controllers\Patient\HomeController::class, 'show'])->name('profile');

    // Route::get('/chat/doctor/{doctorId}', [ChatController::class, 'chatWithDoctor'])->name('chat.withDoctor');
    // Route::post('/chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    // Route::get('/chat/fetch-messages', [ChatController::class, 'fetchMessages'])->name('chat.fetchMessages');

    Route::post('/chat/upload-image', [App\Http\Controllers\Patient\ChatController::class, 'uploadImage'])->name('chat.uploadImage');
Route::get('/chat/{doctorId}', [ChatController::class, 'chatWithDoctor'])->name('chat.withDoctor');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('/chat/upload-image', [ChatController::class, 'uploadImage'])->name('chat.uploadImage');
    Route::get('/chat/fetch', [ChatController::class, 'fetchMessages'])->name('chat.fetchMessages');


});

// Doctor chat routes
Route::prefix('doctor')->name('doctor.')->middleware('auth:doctor')->group(function () {
   
   
    Route::get('/patients/lists', [\App\Http\Controllers\Doctor\ChatController::class, 'patientsList'])->name('patients.lists');
    Route::get('/patients/patients/lists', [\App\Http\Controllers\Doctor\ChatController::class, 'patients'])->name('patients.patients.lists');


    Route::get('/chat/patient/{patientId}', [\App\Http\Controllers\Doctor\ChatController::class, 'chatWithPatient'])->name('chat.withPatient');
    Route::post('/chat/send-message', [\App\Http\Controllers\Doctor\ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::get('/chat/fetch-messages', [\App\Http\Controllers\Doctor\ChatController::class, 'fetchMessages'])->name('chat.fetchMessages');
    Route::post('/chat/upload-image', [\App\Http\Controllers\Doctor\ChatController::class, 'uploadImage'])->name('doctor.chat.uploadImage');
});
