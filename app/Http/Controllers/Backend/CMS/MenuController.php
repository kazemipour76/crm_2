<?php

namespace App\Http\Controllers\Backend\CMS;

use App\Models\CMS\Menu;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class MenuController extends Controller
{
    protected $returnDefault = 'sadmin/cms/menu';
    protected $model = \App\Models\CMS\Menu::class;
    protected $modelName = 'منو';
    protected $viewFolder = 'CMS.menu';




    private function makeTreeView(Collection $collection)
    {
        $ret = [];
        foreach ($collection as $item) {
            if (isset($item['children']) && count($item['children'])) {
                $ret[] = [
                    'text' => $item['title'],
                    'children' => $this->makeTreeView(collect($item['children'])),
                    'state' => [
                        'selected' => true
                    ]
                ];
            } else {
                $ret[] = [
                    'text' => $item['title'],
                    'state' => [
                        'selected' => true
                    ]
                ];
            }
        }
        return $ret;
    }


    public function index($items = '')
    {
        $items = collect(Menu::getTree());
        $data['treeView'] = collect($this->makeTreeView($items));
        return view('backend.CMS.menu.list', $data);
    }


    public function create()
    {
        $models = $this->model::all();
        $data = [
            'models' => $models,
        ];
        return view("backend.{$this->viewFolder}.create",$data);
    }

    public function store()
    {
        $model = new $this->model;
       $order= $model->latest('order')->first();
//       dd($order['order']);
        $parentId=request('parent_id');
        $data = request()->validate(Menu::getValidationRules());
        $model->title = $data['title'];
        $model->order =  $order['order']+'1';
        $model->parent_id = $parentId;
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ایجاد شد', MessageBag::TYPE_SUCCESS);
               return redirect()->back();
        } else {
            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
            return redirect()->back();
        }

    }
}
