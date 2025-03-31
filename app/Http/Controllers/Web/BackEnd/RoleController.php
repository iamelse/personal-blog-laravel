<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Role\StoreRoleRequest;
use App\Http\Requests\Web\Role\UpdateRoleRequest;
use App\Models\Role;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_ROLE->value);

        $allowedFilterFields = ['name'];
        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $roles = Role::with('permissions')->search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'name',
            sort_order: $request->sort_order ?? 'ASC'
        )
        ->paginate($request->limit ?? 10);

        return view('pages.role.index', [
            'title' => 'Role and Permission',
            'roles' => $roles,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_ROLE->value);

        return view('pages.role.create', [
            'title'=> 'New Role | Role and Permission'
        ]);
    }

    /**
     * Summary of store
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_ROLE->value);

            Role::create([
                'name'=> $request->name
            ]);

            return redirect()->route('be.role.and.permission.create')
                ->with('success', 'Role created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        }
        catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('be.role.and.permission.create')
                ->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, Role $role): View
    {
        Gate::authorize(PermissionEnum::UPDATE_ROLE->value);

        return view('pages.role.edit', [
            'title'=> 'Edit Role ' . $role->name,
            'role' => $role
        ]);
    }

    /**
     * Summary of update
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_ROLE->value);

            $role->update([
                'name' => $request->name
            ]);

            return redirect()->route('be.role.and.permission.edit', $role->slug)
                ->with('success', 'Role updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('be.role.and.permission.edit', $role->slug)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Summary of destroy
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Request $request, Role $role): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_ROLE->value);

            $role->delete();

            return redirect()
                ->route('be.role.and.permission.index')
                ->with('success', 'Role deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());

                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error("Error deleting role (Slug: {$role->slug}): " . $e->getMessage());

            return redirect()
                ->route('be.role.and.permission.index')
                ->with('error', 'An error occurred while deleting the role.');
        }
    }

    /**
     * Summary of massDestroy
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function massDestroy(Request $request, Role $role): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_ROLE->value);

            $roleSlugsArray = explode(',', $request->input('slugs', ''));

            if (!empty($roleSlugsArray)) {
                Role::whereIn('slug', $roleSlugsArray)->delete();
            }

            return redirect()
                ->route('be.role.and.permission.index')
                ->with('success', 'Roles deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());
                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error deleting roles: '. $e->getMessage());
            return redirect()
                ->route('be.role.and.permission.index')
                ->with('error', 'An error occurred while deleting the roles.');
        }
    }

    /**
     * Show the form for editing permission of specific user role
     */
    public function editPermission(Request $request, Role $role): View
    {
        $permissions = Permission::all();
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return ucfirst(explode('_', $permission->name)[0]);
        });

        return view('pages.role.permissions.edit', [
            'title' => 'Permissions | Role and Permission',
            'role' => $role,
            'permissions' => $permissions,
            'groupedPermissions' => $groupedPermissions
        ]);
    }

    public function updatePermission(Request $request, Role $role): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_ROLE_PERMISSION->value);

            $role->permissions()->sync($request->input('permissions', []));

            Artisan::call('permission:cache-reset');

            return redirect()
                ->route('be.role.and.permission.edit.permissions', $role->slug)
                ->with('success', 'Role permissions updated');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());

                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error updating role permissions: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'An error occurred while updating permissions.');
        }
    }
}
