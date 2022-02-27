<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Events\UserBlocked;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
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

        $model = $this->model::OrderBy('id');
        $filter = request()->all();

        if (!empty($filter['term'])) {
            $model->search($filter['term']);
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

        $user= User::findOrFail(6);
        if ($user->user_status){
            $user->user_status=User::USER_UNBLOCK;
            $user->last_blocked_at=null;
            $user->save();
        }else{
            $user->user_status=User::USER_BLOCK;
            event(new UserBlocked($user));
        }
    }


    public function userPermissions($id){

        $model=User::findOrFail($id);
        $data['model']=$model;
        return view('backend/user/permissions',$data);
    }
    public function userPermissionsChange($id){

        $model=User::findOrFail($id);
        $data['model']=$model;
        return view('backend/user/permissions',$data);
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
