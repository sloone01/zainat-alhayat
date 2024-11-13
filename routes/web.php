<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use \App\Models\Problem;
use \App\Http\Controllers\TicketController;
use \App\Models\Ticket;
use \App\Models\User;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\GeneralController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ChildController;
use App\Models\JobType;
use App\Models\Level;
use App\Models\planet;
use App\Models\Shift;
use App\Models\Criteria;
use App\Models\Performance;
use App\Models\Reading;
use App\Providers\RoleHelper;
use Dotenv\Store\File\Reader;
use \Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

const ADMIN = ['access:Admin'];
const OTHER = ['access:null'];


Route::get('/',[GeneralController::class,'getUserData'])->name('index')->middleware(OTHER);

Route::get('/login', function () {
    return view('user-login');
})->name('login');

Route::get('/logout', function () {
    Auth::logout();
    return view('user-login');
})->name('logout');

Route::post('/login-action', [UserController::class,'login'])->name('login-action');
Route::post('/reset-pass', [UserController::class,'reset_pass'])->name('reset-pass');

Route::get('/add-criteria',function () {
    return view('criterias.add-criteria',['criterias'=>Level::where('status','ACT')->get()]);})->name('new_planet')->middleware(ADMIN);

Route::post('/saveCriteria',[CriteriaController::class,'saveCriteria'])->name('saveCriteria')->middleware(ADMIN);
Route::post('/saveCriteria',[CriteriaController::class,'saveCriteria'])->name('saveCriteria')->middleware(ADMIN);
Route::post('/update-planet',[CriteriaController::class,'editPlanetDetails'])->name('update-planet')->middleware(ADMIN);

Route::get('/criteria-list', function () {
    return view('criterias.criterias-list',['criterias'=> Criteria::all()]);}
)->name('criterias')->middleware(ADMIN);


Route::get('/classes-list', function () {
    return view('classes.classes-list',['classes'=> Level::all()]);})
    ->name('classes')->middleware(ADMIN);

Route::get('/add-class',function () {
    return view('classes.add-class');})->name('add-class')->middleware(ADMIN);


Route::get('/edit-class-page/{id}',function ($id) {
    $pro = Level::find($id);
    return view('classes.edit-class',[
        'title' => $pro->title,
        'id'=>$pro->id,
        ]);})->name('edit-class-page')->middleware(ADMIN);

Route::get('/change-status-job/{id}',[LevelController::class,'changeStatus']
)->name('change-status-job')->middleware(ADMIN);

Route::get('/delete-jobType/{id}',[LevelController::class,'deleteJob']
)->name('delete-jobType')->middleware(ADMIN);


Route::post('/change-status',[CriteriaController::class,'changeStatus'])->name('change-status')->middleware(ADMIN);
Route::post('/add-performance',[CriteriaController::class,'savePerformance'])->name('add-performance')->middleware(ADMIN);
Route::post('/add-reading',[CriteriaController::class,'addReading'])->name('add-reading')->middleware(ADMIN);
Route::post('/save-class',[LevelController::class,'saveClass'])->name('save-class')->middleware(ADMIN);
Route::post('/save-edit-class',[LevelController::class,'saveEditClass'])->name('save-edit-class')->middleware(ADMIN);
Route::post('/saveEditCri',[CriteriaController::class,'saveEditCri'])->name('saveEditCri')->middleware(ADMIN);
Route::get('/export',[ChildController::class,'export'])->name('export')->middleware(OTHER);
Route::post('/search-reading',[ChildController::class,'adminSearch'])->name('search-reading')->middleware(OTHER);;

Route::get('/reading-list/{l}', function ($l) {

    $sups = User::where([['roles','Supervisor']])->get();

    
    $query = User::leftJoin('readings', function($join) use ($l) {
        $join->on('users.id', '=', 'readings.child_id')
        ->where('readings.status', '=', 'N');
        
      })->where([['users.roles','Student']]);
      

      

    if ($l != 0) {
        $query->whereNotNull('readings.supervisor_id'); 
        $query->where('readings.supervisor_id','=',$l);
    }
    
    $students = $query->select('users.id as user_id','users.*', 'readings.*')
      ->get();

    return view('childs.childs-reading',['worklogs'=> $students,
                'sups'=> $sups,
                'sup_id'=>$l
            ]);
            })
    ->name('reading-list')->middleware(OTHER);

Route::get('/student-list/{id}', function ($id) {
    $level = Level::find($id);
    $level = $level == null ? new Level() : $level;
    

    
    $students = User::where([['roles','Student'],['level_id',$level->id]])->get();
    $criterias = Criteria::whereRaw('FIND_IN_SET(?, classes)', [$level->id])->get();
    
    $mapped = $students->map(function ($student) use ($criterias, $level) {
        $performanceData = [];
        foreach($criterias as $c)
        {
            $performanceData[$c->name] = Performance::where([['criteria_id',$c->id],['child_id',$student->id],['status','<>','Y']])->first();
        }
        return [
            'id' => $student->id,
            'name' => $student->name,
            'class' => $level->name,
            'class_id' => $level->id,
        ] + $performanceData;
    });
    

    return view('childs.childs-performance',['worklogs'=> $mapped,
                'classes'=> Level::all(),
                'class_id' => $id,
                'criterias'=> $criterias,
            ]);
            })
    ->name('student-list')->middleware(OTHER);



Route::post('/save-log',[ChildController::class,'saveLog']
)->name('save-log')->middleware(OTHER);

Route::post('/save-edit',[ChildController::class,'saveEdit']
)->name('save-edit')->middleware(OTHER);


Route::get('/select-planet1', function () {
    return view('tickets.select-planet',
    ['criterias'=>Level::where([['status','=','ACT']])->get()]);
})->name('select-planet1')->middleware(OTHER);

Route::get('/select-planet2/{id}', function ($id) {
    return view('tickets.select-planet2',
    ['criterias'=>planet::where([['status','=','ACT'],['planet_id',$id]])->get()]);
})->name('select-planet2')->middleware(OTHER);


Route::get('/create-log/{id}', function ($id) {
    return view('tickets.create-log',
    ['types'=> JobType::where('status','=','ACT')->get(),
    'criterias'=> planet::where([['status','=','ACT'],['id',$id]])->get(),
    'techs'=> User::where('roles','=','tech')->get(),
    'shifts'=> Shift::where('status','=','ACT')->get()]);
})->name('create-log')->middleware(OTHER);;

Route::get('/add-user-page', function () {
    return view('User.create-user',['criterias'=> Level::where([['status','=','ACT']])->get()]);
})->name('add-user-page')->middleware(ADMIN);

Route::get('/users-list', function () {
    return view('User.users-list',['users'=> User::all()]);
})->name('users-list')->middleware(ADMIN);

Route::post('/save-user',[UserController::class,'saveUser']
)->name('save-user')->middleware(ADMIN);

Route::post('/update-user',[UserController::class,'update_user']
)->name('update-user')->middleware(ADMIN);


Route::get('/disable-user/{id}',[UserController::class,'disableUser']
)->name('disable-user')->middleware(ADMIN);

Route::get('/edit-user/{id}',function ($id){
    $user = User::find($id);
    return view('User.edit-user',['user'=> $user,
        'roles'=> explode(",",$user->roles),
        'criterias'=> Level::where([['status','=','ACT']])->get()]);
}
)->name('edit-user')->middleware(ADMIN);


Route::get('/edit-criteria/{id}',
    function ($id){
    $dep = Criteria::find($id);
    return view('criterias.edit-criteria',['name'=>$dep->name,'id'=>$dep->id,'tpe'=>$dep->type,
                                      'Levels'=>Level::where('status','ACT')->get()]);
    }
)->name('edit-criteria')->middleware(ADMIN);

Route::get('/activate-planet/{id}',[CriteriaController::class,'activatePlanet']
)->name('activate-planet')->middleware(ADMIN);


Route::get('/delete-planet/{id}',[CriteriaController::class,'deletePlanet']
)->name('delete-planet')->middleware(ADMIN);


Route::get('/edit-prop/{id}',[LevelController::class,'editProp']
)->name('edit-prop')->middleware(ADMIN);

Route::get('/delete-prop/{id}',[LevelController::class,'deleteProblem']
)->name('delete-prop')->middleware(ADMIN);


Route::get('/reset-password/{id}',[UserController::class,'resetPassword']
)->name('reset-password')->middleware(ADMIN);


Route::get('/single-student/{id}', function ($id) {
    $user = User::find($id);

    return view('childs.single-student',['log'=>$user,
    'cri'=> Criteria::whereRaw('FIND_IN_SET(?, classes)', [$user->level_id])->get(),
    'performance'=>Performance::where([['child_id',$user->id]])->get()]);
})->name('single-student')->middleware(OTHER);

Route::get('/problem-details/{id}', function ($id) {
    $problem = Problem::find($id);
    $dept = $problem->department;
    return response()->json(['problem'=>$problem]);
})->name('problem-details');


Route::post('/add-comment', [TicketController::class,'addComment'])->name('add-comment')->middleware(OTHER);
Route::post('/answer-query', [TicketController::class,'answerQuery'])->name('answer-query');
Route::get('/edit-log/{id}', function ($id) {
    return view('hospital-doctor');
})->name('edit-log')->middleware(OTHER);



Route::get('/advanced-ui-kits-image-crop', function () {
    return view('advanced-ui-kits-image-crop');
});
Route::get('/advanced-ui-kits-jquery-confirm', function () {
    return view('advanced-ui-kits-jquery-confirm');
});
Route::get('/advanced-ui-kits-nestable', function () {
    return view('advanced-ui-kits-nestable');
});
Route::get('/advanced-ui-kits-pnotify', function () {
    return view('advanced-ui-kits-pnotify');
});
Route::get('/advanced-ui-kits-range-slider', function () {
    return view('advanced-ui-kits-range-slider');
});
Route::get('/advanced-ui-kits-ratings', function () {
    return view('advanced-ui-kits-ratings');
});
Route::get('/advanced-ui-kits-session-timeout', function () {
    return view('advanced-ui-kits-session-timeout');
});
Route::get('/advanced-ui-kits-sweet-alerts', function () {
    return view('advanced-ui-kits-sweet-alerts');
});
Route::get('/advanced-ui-kits-switchery', function () {
    return view('advanced-ui-kits-switchery');
});
Route::get('/advanced-ui-kits-toolbar', function () {
    return view('advanced-ui-kits-toolbar');
});
Route::get('/advanced-ui-kits-tour', function () {
    return view('advanced-ui-kits-tour');
});
Route::get('/advanced-ui-kits-treeview', function () {
    return view('advanced-ui-kits-treeview');
});
Route::get('/apps-calender', function () {
    return view('apps-calender');
});
Route::get('/apps-chat', function () {
    return view('apps-chat');
});
Route::get('/apps-email-compose', function () {
    return view('apps-email-compose');
});
Route::get('/apps-email-inbox', function () {
    return view('apps-email-inbox');
});
Route::get('/apps-email-open', function () {
    return view('apps-email-open');
});
Route::get('/apps-kanban-board', function () {
    return view('apps-kanban-board');
});
Route::get('/apps-onboarding-screens', function () {
    return view('apps-onboarding-screens');
});
Route::get('/basic-ui-kits-alerts', function () {
    return view('basic-ui-kits-alerts');
});
Route::get('/basic-ui-kits-badges', function () {
    return view('basic-ui-kits-badges');
});
Route::get('/basic-ui-kits-buttons', function () {
    return view('basic-ui-kits-buttons');
});
Route::get('/basic-ui-kits-cards', function () {
    return view('basic-ui-kits-cards');
});
Route::get('/basic-ui-kits-carousel', function () {
    return view('basic-ui-kits-carousel');
});
Route::get('/basic-ui-kits-collapse', function () {
    return view('basic-ui-kits-collapse');
});
Route::get('/basic-ui-kits-dropdowns', function () {
    return view('basic-ui-kits-dropdowns');
});
Route::get('/basic-ui-kits-embeds', function () {
    return view('basic-ui-kits-embeds');
});
Route::get('/basic-ui-kits-grids', function () {
    return view('basic-ui-kits-grids');
});
Route::get('/basic-ui-kits-images', function () {
    return view('basic-ui-kits-images');
});
Route::get('/basic-ui-kits-media', function () {
    return view('basic-ui-kits-media');
});
Route::get('/basic-ui-kits-modals', function () {
    return view('basic-ui-kits-modals');
});
Route::get('/basic-ui-kits-paginations', function () {
    return view('basic-ui-kits-paginations');
});
Route::get('/basic-ui-kits-popovers', function () {
    return view('basic-ui-kits-popovers');
});
Route::get('/basic-ui-kits-progressbars', function () {
    return view('basic-ui-kits-progressbars');
});
Route::get('/basic-ui-kits-spinners', function () {
    return view('basic-ui-kits-spinners');
});
Route::get('/basic-ui-kits-tabs', function () {
    return view('basic-ui-kits-tabs');
});
Route::get('/basic-ui-kits-toasts', function () {
    return view('basic-ui-kits-toasts');
});
Route::get('/basic-ui-kits-tooltips', function () {
    return view('basic-ui-kits-tooltips');
});
Route::get('/basic-ui-kits-typography', function () {
    return view('basic-ui-kits-typography');
});
Route::get('/chart-apex', function () {
    return view('chart-apex');
});
Route::get('/chart-c3', function () {
    return view('chart-c3');
});
Route::get('/chart-chartistjs', function () {
    return view('chart-chartistjs');
});
Route::get('/chart-chartjs', function () {
    return view('chart-chartjs');
});
Route::get('/chart-flot', function () {
    return view('chart-flot');
});
Route::get('/chart-knob', function () {
    return view('chart-knob');
});
Route::get('/chart-morris', function () {
    return view('chart-morris');
});
Route::get('/chart-piety', function () {
    return view('chart-piety');
});
Route::get('/chart-sparkline', function () {
    return view('chart-sparkline');
});
Route::get('/crm-clients', function () {
    return view('crm-clients');
});
Route::get('/crm-lead-status', function () {
    return view('crm-lead-status');
});
Route::get('/crm-projects', function () {
    return view('crm-projects');
});
Route::get('/dashboard-ecommerce', function () {
    return view('dashboard-ecommerce');
});
Route::get('/dashboard-hospital', function () {
    return view('dashboard-hospital');
});
Route::get('/ecommerce-cart', function () {
    return view('ecommerce-cart');
});
Route::get('/ecommerce-checkout', function () {
    return view('ecommerce-checkout');
});
Route::get('/ecommerce-myaccount', function () {
    return view('ecommerce-myaccount');
});
Route::get('/ecommerce-order-detail', function () {
    return view('ecommerce-order-detail');
});
Route::get('/ecommerce-order-list', function () {
    return view('ecommerce-order-list');
});
Route::get('/ecommerce-product-detail', function () {
    return view('ecommerce-product-detail');
});
Route::get('/ecommerce-product-list', function () {
    return view('ecommerce-product-list');
});
Route::get('/ecommerce-shop', function () {
    return view('ecommerce-shop');
});
Route::get('/ecommerce-single-product', function () {
    return view('ecommerce-single-product');
});
Route::get('/ecommerce-thankyou', function () {
    return view('ecommerce-thankyou');
});
Route::get('/error-404', function () {
    return view('error-404');
});
Route::get('/error-500', function () {
    return view('error-500');
});
Route::get('/error-comingsoon', function () {
    return view('error-comingsoon');
});
Route::get('/error-maintenance', function () {
    return view('error-maintenance');
});
Route::get('/form-colorpickers', function () {
    return view('form-colorpickers');
});
Route::get('/form-datepickers', function () {
    return view('form-datepickers');
});
Route::get('/form-editors', function () {
    return view('form-editors');
});
Route::get('/form-file-uploads', function () {
    return view('form-file-uploads');
});
Route::get('/form-groups', function () {
    return view('form-groups');
});
Route::get('/form-input-mask', function () {
    return view('form-input-mask');
});
Route::get('/form-inputs', function () {
    return view('form-inputs');
});
Route::get('/form-layouts', function () {
    return view('form-layouts');
});
Route::get('/form-maxlength', function () {
    return view('form-maxlength');
});
Route::get('/form-selects', function () {
    return view('form-selects');
});
Route::get('/form-touchspin', function () {
    return view('form-touchspin');
});
Route::get('/form-validations', function () {
    return view('form-validations');
});
Route::get('/form-wizards', function () {
    return view('form-wizards');
});
Route::get('/form-xeditable', function () {
    return view('form-xeditable');
});
Route::get('/hospital-appointment', function () {
    return view('hospital-appointment');
});
Route::get('/hospital-doctor', function () {
    return view('hospital-doctor');
});
Route::get('/hospital-patient', function () {
    return view('hospital-patient');
});
Route::get('/icon-dripicons', function () {
    return view('icon-dripicons');
});
Route::get('/icon-feather', function () {
    return view('icon-feather');
});
Route::get('/icon-flag', function () {
    return view('icon-flag');
});
Route::get('/icon-font-awesome', function () {
    return view('icon-font-awesome');
});
Route::get('/icon-ionicons', function () {
    return view('icon-ionicons');
});
Route::get('/icon-line-awesome', function () {
    return view('icon-line-awesome');
});
Route::get('/icon-material-design', function () {
    return view('icon-material-design');
});
Route::get('/icon-simple-line', function () {
    return view('icon-simple-line');
});
Route::get('/icon-socicon', function () {
    return view('icon-socicon');
});
Route::get('/icon-themify', function () {
    return view('icon-themify');
});
Route::get('/icon-svg', function () {
    return view('icon-svg');
});
Route::get('/icon-typicons', function () {
    return view('icon-typicons');
});
Route::get('/map-google', function () {
    return view('map-google');
});
Route::get('/map-vector', function () {
    return view('map-vector');
});
Route::get('/page-blog', function () {
    return view('page-blog');
});
Route::get('/page-faq', function () {
    return view('page-faq');
});
Route::get('/page-gallery', function () {
    return view('page-gallery');
});
Route::get('/page-invoice', function () {
    return view('page-invoice');
});
Route::get('/page-pricing', function () {
    return view('page-pricing');
});
Route::get('/page-starter', function () {
    return view('page-starter');
});
Route::get('/page-timeline', function () {
    return view('page-timeline');
});
Route::get('/table-bootstrap', function () {
    return view('table-bootstrap');
});
Route::get('/table-datatable', function () {
    return view('table-datatable');
});
Route::get('/table-editable', function () {
    return view('table-editable');
});
Route::get('/table-footable', function () {
    return view('table-footable');
});
Route::get('/table-rwdtable', function () {
    return view('table-rwdtable');
});
Route::get('/user-forgotpsw', function () {
    return view('user-forgotpsw');
});
Route::get('/user-lock-screen', function () {
    return view('user-lock-screen');
});
Route::get('/user-login', function () {
    return view('user-login');
})->name('user-login');
Route::get('/user-reset-page', function () {
    return view('reset-password');
})->name('user-reset-page');


Route::get('/user-register', function () {
    return view('user-register');
});

Route::get('/widgets', function () {
    return view('widgets');
});

