<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Events\UserBlocked;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Scopes\UserScope;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use App\Utilities\UploadHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

//use IIlluminate\Support\Facades\St;

class UserController extends Controller
{

    protected $returnDefault = 'sadmin/auth/user';
    protected $model = \App\Models\Auth\User::class;
    protected $modelName = 'کاربر';
    protected $viewFolder = 'user';

    public function filter()
    {
//        dd(\request()->all());

        $model = User::withoutGlobalScope(UserScope::class)->OrderBy('id');
        $filter = request()->all();

        if (!empty($filter['term'])) {
            $model->search($filter['term']);
        }

        if (isset($filter['user_type']) && in_array('1', \request('user_type'))){
            $model->whereIn('user_type',\request('user_type'))

            ->orWhere('user_block',in_array('1', \request('user_type')));
        }elseif(isset($filter['user_type'])){
            $model->whereIn('user_type',\request('user_type'));
        }


        $date_type = '';
        if (isset($filter['date_type'])) {
            $date_type = $filter['date_type'];
        }

        if (isset($filter['date_from'])) {
            $date = explode('/', $filter['date_from']);
            $gdate = Jdf::jalali_to_gregorian($date[0], $date[1], $date[2], '-') . ' 00:00:00';
            $model->where($date_type, '>=', $gdate);
        }

        if (isset($filter['date_to'])) {
            $date = explode('/', $filter['date_to']);
            $gdate = Jdf::jalali_to_gregorian($date[0], $date[1], $date[2], '-') . ' 23:59:59';
            $model->where($date_type, '<=', $gdate);
        }

        return $model;
    }


    public function index(Request $request)
    {

        $models = $this->filter()->paginate(request('perPage', 5));
        $old = \Request::flash($models);
        $old = \Request::old($old);
        $data = [
            'models' => $models,
            'old' => $old,
        ];

        return view("backend.{$this->viewFolder}.list", $data);
    }


    public function destroy($id)
    {
        $this->deleteAction([$id]);
        return redirect($this->returnDefault);
    }

    public function create()
    {
        return view("backend.{$this->viewFolder}.create");
    }
    public function image()
    {
        return view("backend.{$this->viewFolder}.image");
    }
    public function saveImage(Request $request)
    {

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);
        $image = $request->file('image');
        $name_image = time().rand(0,20). ".". $image->extension();

//        $name_image = $request->file('image')->getClientOriginalName();
//        $path_image = $request->file('image')->store('public/images');


        $model= User::findOrFail(\Auth::id());
            if($model->name_image!==null){
                File::delete(public_path('imageUser/'.$model->name_image));
                $image->move(public_path('imageUser'), $name_image);
                $model->name_image =$name_image;

            }else{
                $image->move(public_path('imageUser'), $name_image);
                $model->name_image =$name_image;
            }


        $model->save();
        return redirect()->back();

    }
    public function deleteImage(Request $request)
    {
        $model= User::findOrFail(\Auth::id());
        File::delete(public_path('imageUser/'.$model->name_image));
        $model->name_image =null;
        $model->save();
        return redirect()->back();
    }

    public function store()
    {
        $model = new $this->model;
        $data = request()->validate(User::getValidationRules());
        $model->fill($data);
        $model->password = Hash::make(request('password'));

        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ایجاد شد', MessageBag::TYPE_SUCCESS);
            return redirect("{$this->returnDefault}/" . $model->id . '/edit');
        } else {
            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        $model = $this->model::findOrFail($id);
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.edit", $data);
    }
   public function editInformation()
    {
        $model = $this->model::findOrFail(Auth::id());
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.edit", $data);
    }

    public function update($id)
    {
        $model = $this->model::findOrFail($id);
        $data = request()->validate(User::getValidationRules(true, $id));
        $model->fill($data);

        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();
        } else {
            MessageBag::push('مجدد تلاش کنید ');
            return redirect()->back();
        }
    }

    public function updateInformation()
    {
//        dd('ddd');
        $model = $this->model::findOrFail(Auth::id());
        $data = request()->validate(User::getValidationRules(true, Auth::id()));
//        dd($data);
        if (request('password')!==null&&request('repassword')!==null){
            if (request('password')==request('repassword')){
                $model->password=  Hash::make(request('password'));

            }else{
                MessageBag::push('رمز عبور با تکرار آن مطابقت ندارد لطفا مجدد تلاش کنید');
                return redirect()->back();
            }
        }
        $model->fill($data);

        if ($model->save()) {
            MessageBag::push( ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();
        } else {
            MessageBag::push('مجدد تلاش کنید ');
            return redirect()->back();
        }
    }

    public function blockUser($id){
        if (Auth::id()==$id)
        {
            MessageBag::push('امکان این کار برای شما وجود ندارد');
            return redirect()->back();
        }
        $user= User::findOrFail($id);
        if ($user->user_block){
            $user->user_block=User::USER_UNBLOCK;
            $user->last_blocked_at=null;
            if ($user->save()) {
                MessageBag::push( ' با موفقیت رفع مسدودیت شد', MessageBag::TYPE_SUCCESS);
                return redirect()->back();
            } else {
                MessageBag::push('مجدد تلاش کنید ');
                return redirect()->back();
            }
        }else{
            $user->user_block=User::USER_BLOCK;

            if (  event(new UserBlocked($user))) {
                MessageBag::push( ' با موفقیت مسدود شد', MessageBag::TYPE_SUCCESS);
                return redirect()->back();
            } else {
                MessageBag::push('مجدد تلاش کنید ');
                return redirect()->back();
            }
        }
    }


    public function userPermissions($id){
        if (Auth::id()==$id)
        {
            MessageBag::push('امکان این کار برای شما وجود ندارد');
            return redirect()->back();
        }
        $model=User::findOrFail($id);
        $data['model']=$model;
        return view('backend/user/permissions',$data);
    }
    public function userPermissionsChange($id){
        if (Auth::id()==$id)
        {
            MessageBag::push('امکان این کار برای شما وجود ندارد');
            return redirect()->back();
        }
        $model =User::findOrFail($id);



        if (\request('user_type')==User::USER_ADMIN) {
            $model->user_type=User::USER_ADMIN;
        }
        if (\request('user_type') == User::USER_SPECIAL) {
            $model->user_type=User::USER_SPECIAL;
        }
        if (\request('user_type') == User::USER_NORMAL) {
            $model->user_type = User::USER_NORMAL;
        }
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت تغییر کرد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();

        } else {
            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
            return redirect()->back();
        }

    }
    /*
     * ------------------------------- actions ------------------------------
     */
    public function actions(Request $request)
    {
        $ids = array_keys(request('checks', []));
        $action = trim(strtolower(request('action', '')));

        switch ($action) {
            case 'delete':
                $this->deleteAction($ids);
                break;

        }

        return redirect()->back();
    }

    public function deleteAction($ids)
    {


        $count = count($ids);
        if ($this->model::whereIn('id', $ids)->delete()) {
            MessageBag::push("تعداد {$count} {$this->modelName} با موفقیت حذف شد" , MessageBag::TYPE_SUCCESS);
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");
        }
    }
}
