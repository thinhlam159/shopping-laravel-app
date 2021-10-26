<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRoleController extends Controller
{
    private $role;
    private $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list_role');
        $roles = $this->role->all();
        return view('admin.role.index')->with(compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add_role');
        $permissions = $this->permission->where('parent_id', 0)->get();
        return view('admin.role.create')->with(compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('add_role');
        try {
            DB::beginTransaction();
            $role = $this->role->create([
                'name'=> $request->name,
                'display_name'=> $request->display_name,
            ]);
            $role->permission()->attach($request->permission_id);
            DB::commit();
            return redirect()->route('role.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message error: ' . $exception->getMessage() . 'Line: '. $exception->getLine());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit_role');
        $permissions = $this->permission->where('parent_id', 0)->get();
        $role = $this->role->find($id);
        $permissionChecked = $role->permission;
//        dd($role->permission);
        return view('admin.role.edit')->with(compact('permissions', 'role', 'permissionChecked'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit_role');
        try {
            DB::beginTransaction();
            $this->role->find($id)->update([
                'name'=> $request->name,
                'display_name'=> $request->display_name,
            ]);
            $role = $this->role->find($id);
            $role->permission()->sync($request->permission_id);
            DB::commit();
            return redirect()->route('role.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message error: ' . $exception->getMessage() . 'Line: '. $exception->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete_role');
        $role = $this->role->find($id);
        $role->permission()->detach();
        $role->delete();
        return redirect()->route('role.index');
    }
}
