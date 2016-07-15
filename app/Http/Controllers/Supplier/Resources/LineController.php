<?php

namespace App\Http\Controllers\Supplier\Resources;

use App\Http\Controllers\Supplier\BaseController;
use App\Http\Facades\Base;
use App\Models\Resources\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

class LineController extends BaseController
{

    /**
     * 主页
     */
    public function index()
    {
        $lines = Line::where('eid', Base::eid())->orderBy('created_at', 'desc')->paginate($this->pageSize);
        return view('supplier.resources.line.index', compact('lines'));
    }


    public function create(Request $request)
    {
        try {
            $line = new Line();
            if ($request->isMethod('post')) {
                $input = Input::all();

                $validator = Validator::make($input, $line->createRules(), $line->messages());
                if ($validator->fails()) {
                    return redirect('/supplier/resources/line/create')
                        ->withInput()
                        ->withErrors($validator);
                }
                $line->fill($input);
                $line->eid = Base::eid();
                $line->createid = Base::uid();
                $line->save();
                if ($line) {
                    return redirect('/supplier/resources/line/')->withSuccess('保存成功！');
                } else {
                    return Redirect::back()->withErrors('保存失败！');
                }
            }
            return view('supplier.resources.line.create', compact('line'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $line = Line::find($id);
            if (!$line) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            if ($request->isMethod('post')) {
                $input = Input::all();

                $validator = Validator::make($input, $line->editRules(), $line->messages());
                if ($validator->fails()) {
                    return redirect('/supplier/resources/line/edit/' . $id)
                        ->withInput()
                        ->withErrors($validator);
                }
                $line->fill($input);
                $line->editid = Base::uid();
                $line->save();
                if ($line) {
                    return redirect('/supplier/resources/line/')->withSuccess('更新成功！');
                } else {
                    return Redirect::back()->withErrors('更新失败！');
                }
            }
            return view('supplier.resources.line.edit', compact('line'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function copy($id)
    {
        try {
            $line = Line::find($id);
            if (!$line) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $line->name .= "（复制）";
            return view('supplier.resources.line.create', compact('line'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function delete($id)
    {
        $Line = Line::find($id);
        if ($Line->delete()) {
            return redirect('/supplier/resources/line/')->withSuccess('删除成功！');
        } else {
            return Redirect::back()->withErrors('数据加载失败！');
        }


    }

}