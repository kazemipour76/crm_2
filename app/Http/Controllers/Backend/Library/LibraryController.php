<?php

namespace App\Http\Controllers\Backend\Library;

use App\Exceptions\FileUploadException;
use App\Http\Controllers\Controller;
use App\Models\Auth\Library;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use App\Utilities\UploadHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;


class LibraryController extends Controller
{

    protected $returnDefault = 'sadmin/library/library';
    protected $model = Library::class;
    protected $modelName = 'کاربر';
    protected $viewFolder = 'library.library';

    public function filter()
    {
        $model = $this->model::OrderBy('id');
        $filter = request()->all();

        if (!empty($filter['term'])) {
            $model->search($filter['term']);
        }

        $date_type = '';
        if (isset($filter['date_type'])) {
            $date_type= $filter['date_type'];

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

        if(isset($filter['ext'])){


            $model->where('ext',strtolower($filter['ext']));
        }

        if(isset($filter['folder']) && !empty($filter['folder'])){
            $model->where('folder',$filter['folder']);
        }
        return $model;
    }


    public function index()
    {

        $this->actions();
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

    public function gallery()
    {
        $models = $this->filter()->paginate(50);
        $old = \Request::flash($models);
        $old = \Request::old($old);
        $data = [
            'models' => $models,
            'n' => 'user list by variable',
            'old' => $old,
        ];

        return view("backend.{$this->viewFolder}.gallery", $data);
    }

    public function store(Request $request)
    {
        try {
            UploadHandler::validate($request->file('file'));

            $file = UploadHandler::save($request->file('file'));

        } catch (FileUploadException $ex) {

            $errors = json_decode($ex->getMessage(), true);
            $data = ['errors' => $errors];
            return response()->json($data);
        }


        if ($file) {
            $model = new Library();
            $model->file_name = $file['name'];
            $model->title = $file['name'];
            $model->path = $file['path'];
            $model->ext = $file['ext'];
            $model->folder = $file['folder'];
            $model->size = $file['size'];

            $model->user_id = Auth::id();
            $model->save();
            return response()->json($model->toArray());
        }
        $data = ['errors' => ['1' => ['فایل ذخیره نشد لطفا مجددا تلاش فرمایید ']]];
        return response()->json($data);
    }

    public function edit($id)
    {
        $model = $this->model::findOrFail($id);
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.edit", $data);
    }

    public function update(Request $request, $id)
    {
        $model = Library::findOrFail($id);

        try {
            UploadHandler::validate($request->file('file'));
            $file = UploadHandler::save($request->file('file'), $model->full_path);
            // for replace image just send $model->full_path as param 2
        } catch (FileUploadException $ex) {
            $errors = json_decode($ex->getMessage(), true);
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }
        $request->validate(Library::getValidationRules());

        if ($file) {
            $model->file_name = $file['name'];
            $model->path = $file['path'];
            $model->ext = $file['ext'];
            $model->folder = $file['folder'];
            $model->size = $file['size'];

        }
        $model->description = request('description');
        $model->caption = request('caption');
        $model->title = request('name');
        $model->user_id = Auth::id();
        $model->save();

        return redirect()->back();

    }


    /*
     * ------------------------------- actions ------------------------------
     */
    public function actions()
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
        $models = Library::findOrFail($ids);

         foreach ($models as $model) {
            $fullAddress = "storage/uploads/{$model->full_path}";
            File::delete($fullAddress);
            foreach (UploadHandler::THUMBNAIL_SIZE as $key => $size) {
                $path = str_replace($model->full_file_name, '', $model->full_path);
                $fullAddress = "storage/uploads/{$path}/{$key}/{$model->full_file_name}";
                File::delete($fullAddress);
            }

        }
        $this->model::whereIn('id', $ids)->delete();

    }
}
