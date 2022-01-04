<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\Group;
use App\Models\Auth\Library;
use App\Models\Auth\User;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GroupController extends Controller
{

    protected $returnDefault = 'sadmin/auth/group';
    protected $model = \App\Models\Auth\Group::class;
    protected $modelName = 'گروه کاربری';
    protected $viewFolder = 'group';

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


    public function index()
    {
//        $this->actions();
        $models = $this->filter()->paginate(request('perPage', 5));
        $old = \Request::flash($models);
        $old = \Request::old($old);
        $data = [
            'models' => $models,
            'count' => count($models),
            'n' => 'user list by variable',
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

    public function store()
    {
        $model = new $this->model;
        $data = request()->validate(Group::getValidationRules());
        $model->fill($data);
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

    public function update($id)
    {
        $model = $this->model::findOrFail($id);
        $data = request()->validate(Group::getValidationRules(true, $id));
        $model->fill($data);

        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();
        } else {
            MessageBag::push('مجدد تلاش کنید ');
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
            MessageBag::push("تعداد {$count} {$this->modelName} با موفقیت حذف شد", MessageBag::TYPE_SUCCESS);
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");
        }
    }

}
