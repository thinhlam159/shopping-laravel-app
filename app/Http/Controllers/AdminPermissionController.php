<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    private $permission;
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
    public function create()
    {
        return view('admin.permission.add');
    }

    public function store(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->module_parent,
            'display_name' => $request->display_name,
            'key_code' => '',
            'parent_id' => 0,
        ]);
//        dd(config('permissions.table_module.' . $request->module_parent));
        foreach (config('permissions.table_module.' . $request->module_parent) as $value) {
            Permission::create([
                'name' => $value,
                'display_name' => $value,
                'key_code' => $value,
                'parent_id' => $permission->id,
            ]);
        }
        return redirect()->back()->with('status', 'Tạo permission thành công');
    }
}
