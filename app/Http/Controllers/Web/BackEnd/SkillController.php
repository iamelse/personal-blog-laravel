<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Skill\StoreSkillRequest;
use App\Http\Requests\Web\Skill\UpdateSkillRequest;
use App\Models\Skill;
use Cviebrock\EloquentSluggable\Services\SlugService;
use FFI\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_SKILL->value);

        $allowedFilterFields = ['name'];
        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $skills = Skill::search(
                keyword: $request->keyword,
                columns: $allowedFilterFields,
            )->sort(
                sort_by: $request->sort_by ?? 'name',
                sort_order: $request->sort_order ?? 'ASC'
            )->paginate($request->query('limit') ?? 10);

        return view('pages.skill.index', [
            'title' => 'Skill',
            'skills' => $skills,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_SKILL);

        return view('pages.skill.create', [
            'title'=> 'New Skill',
        ]);
    }

    public function store(StoreSkillRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_SKILL);
            
            if (Skill::count() >= 7) {
                return redirect()->back()
                    ->with('error', 'Maximum number of skills reached.');
            }

            Skill::create([
                'name' => $request->name,
                'icon_class' => $request->icon_class
            ]);

            return redirect()->route('be.skill.create')
                ->with('success','Skill created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.skill.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(Skill $skill): View
    {
        Gate::authorize(PermissionEnum::UPDATE_SKILL);

        return view('pages.skill.edit', [
            'title' => 'Edit Skill',
            'skill' => $skill,
        ]);
    }

    public function update(UpdateSkillRequest $request, Skill $skill): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_SKILL);

            Skill::where('name', $skill->name)->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'icon_class' => $request->icon_class
            ]);
            
            return redirect()->route('be.skill.edit', $request->slug ?? $skill->slug)
                ->with('success','Skill updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.skill.edit', $skill->name)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_SKILL->value);

            $skill->delete();

            return redirect()
                ->route('be.skill.index')
                ->with('success', 'Skill deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());

                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error("Error deleting skill (Name: {$skill->name}): " . $e->getMessage());

            return redirect()
                ->route('be.skill.index')
                ->with('error', 'An error occurred while deleting the skill.');
        }
    }

    public function massDestroy(Request $request, Skill $skill): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_ROLE->value);

            $skillsArray = explode(',', $request->input('names', ''));

            if (!empty($skillsArray)) {
                Skill::whereIn('name', $skillsArray)->delete();
            }

            return redirect()
                ->route('be.skill.index')
                ->with('success', 'Skills deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());
                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error deleting skills: '. $e->getMessage());
            return redirect()
                ->route('be.skill.index')
                ->with('error', 'An error occurred while deleting the skills.');
        }
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(Skill::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
