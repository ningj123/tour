<?php

namespace App\Http\Controllers\Manage;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

/**
 * 权限管理
 * @package App\Http\Controllers\Manage
 */
class PermissionController extends BaseController
{
    /**
     * 主页
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('manage.system.permission.index', ['model' => 'system', 'menu' => 'permission', 'permissions' => $permissions]);
    }

    public function getCreate()
    {
        $permission = new Permission();
        return view('manage.system.permission.create', ['model' => 'system', 'menu' => 'permission', 'permission' => $permission]);
    }

    public function postCreate(Request $request)
    {
        $permission = new Permission();

        $validator = Validator::make($request->all(), $permission->rules(), $permission->messages());
        if ($validator->fails()) {
            return redirect('/manage/system/permission/create')
                ->withInput()
                ->withErrors($validator);
        }

        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');

        if ($permission->save()) {
            return URL::to('index');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }

    public function getEdit($id)
    {
        $permission = Permission::find($id);
        return view('manage.system.permission.edit', ['model' => 'system', 'menu' => 'permission', 'permission' => $permission]);
    }

    public function postEdit(Request $request, $id)
    {
        $permission = new Permission();

        $validator = Validator::make($request->all(), $permission->rules(), $permission->messages());
        if ($validator->fails()) {
            return redirect('/manage/system/permission/create')
                ->withInput()
                ->withErrors($validator);
        }

        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');

        if ($permission->save()) {
            return Redirect::to(action($this->controller . '@index'));
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }

    public function getShow($id)
    {
        $permission = Permission::find($id);
        return view('manage.system.permission.edit', ['model' => 'system', 'menu' => 'permission', 'permission' => $permission]);
    }


    public function getDelete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permission');

    }


}