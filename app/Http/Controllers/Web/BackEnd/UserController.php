<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\User\StoreUserRequest;
use App\Http\Requests\Web\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show listing user data
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_USER->value);

        $roles = Role::all();
        $allowedFilterFields = ['name', 'username', 'email'];
        $allowedSortFields = ['name', 'username', 'email', 'email_verified_at', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $users = User::with('roles', 'permissions')->search(
                keyword: $request->keyword,
                columns: $allowedFilterFields,
            )->sort(
                sort_by: $request->sort_by ?? 'name',
                sort_order: $request->sort_order ?? 'ASC'
            )->when($request->role, fn($query, $role) =>
                $query->whereHas('roles', fn($q) => $q->where('slug', $role))
            )
            ->paginate($request->query('limit') ?? 10);

        return view('pages.user.index', [
            'title' => 'User',
            'roles' => $roles,
            'users' => $users,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    /**
     * Show form create new user
     */
    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_USER->value);

        $roles = Role::orderBy('name', 'ASC')->get();

        return view('pages.user.create', [
            'title' => 'New User',
            'roles' => $roles
        ]);
    }

    /**
     * Store new user
     * @param \App\Http\Requests\Web\User\StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize(PermissionEnum::CREATE_USER->value);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                $user->assignRole($request->role);
            });

            return redirect()->route('be.user.create')
                ->with('success','User created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.user.create')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Show form edit user
     */
    public function edit(User $user): View
    {
        Gate::authorize(PermissionEnum::UPDATE_USER->value);

        $roles = Role::orderBy('name', 'ASC')->get();

        return view('pages.user.edit', [
            'title' => 'Edit User | ' . $user->name,
            'roles' => $roles,
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize(PermissionEnum::UPDATE_USER->value);

        try {
            DB::transaction(function () use ($request, $user) {
                $updateData = [
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                ];

                if ($request->filled('password')) {
                    $updateData['password'] = Hash::make($request->password);
                }

                $user->update($updateData);

                $user->syncRoles($request->role);
            });

            return redirect()->route('be.user.edit', $user->username)
                ->with('success','User updated');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.user.edit', $user->username)
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Delete user data
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_USER->value);

            $user->delete();

            return redirect()
                ->route('be.user.index')
                ->with('success', 'User deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());

                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error("Error deleting user (Username: {$user->username}): " . $e->getMessage());

            return redirect()
                ->route('be.user.index')
                ->with('error', 'An error occurred while deleting the user.');
        }
    }

    /**
     * Mass delete user
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return RedirectResponse
     */
    public function massDestroy(Request $request, User $user): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_USER->value);

            $userUsernamesArray = explode(',', $request->input('usernames', ''));

            if (!empty($userUsernamesArray)) {
                User::whereIn('username', $userUsernamesArray)->delete();
            }

            return redirect()
                ->route('be.user.index')
                ->with('success', 'Users deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());
                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error deleting users: '. $e->getMessage());
            return redirect()
                ->route('be.user.index')
                ->with('error', 'An error occurred while deleting the users.');
        }
    }
}
