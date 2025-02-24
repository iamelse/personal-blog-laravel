<?php

namespace App\Http\Controllers\Backend\Resume;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceStoreRequest;
use App\Http\Requests\ExperienceUpdateRequest;
use App\Models\Experience;
use App\Services\ImageManagementService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    protected $imageManagementService;

    public function __construct(ImageManagementService $imageManagementService)
    {
        $this->imageManagementService = $imageManagementService;
    }

    public function index(Request $request): View
    {
        $perPage = $request->input('limit', 10);
        $q = $request->input('q', '');
        $columns = ['position_name', 'company_name'];

        $experiences = Experience::when($q, function ($query) use ($q, $columns) {
            $query->where(function ($subquery) use ($q, $columns) {
                foreach ($columns as $column) {
                    $subquery->orWhere($column, 'LIKE', "%$q%");
                }
            });
        })
        ->orderByRaw('end_date IS NULL DESC, end_date DESC')
        ->paginate($perPage);

        activity('experience_management')
            ->causedBy(Auth::user())
            ->log('Accessed experience index.');

        return view('backend.resume.experience.index', [
            'title' => 'Experience',
            'experiences' => $experiences,
            'perPage' => $perPage,
            'q' => $q,
        ]);
    }

    public function create(): View
    {
        activity('experience_management')
            ->causedBy(Auth::user())
            ->log('Accessed create experience page.');

        return view('backend.resume.experience.create', [
            'title' => 'New Experience'
        ]);
    }

    public function store(ExperienceStoreRequest $request): RedirectResponse
    {
        $imagePath = null;

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');

            $imagePath = $this->imageManagementService->uploadImage($file, [
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/experiences/company_logos',
            ]);
        }

        Experience::create([
            'company_logo_size' => $request->company_logo_size ?? 2.5,
            'company_logo' => $imagePath,
            'position_name' => $request->position_name,
            'company_name' => $request->company_name,
            'desc' => $request->desc,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'),
            'end_date' => $request->is_still_work_here ? null : ($request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d H:i:s') : null),
        ]);

        activity('experience_management')
            ->causedBy(Auth::user())
            ->log("Created experience: {$request->position_name} at {$request->company_name}");

        return redirect()->route('experience.index')->with('success', 'Experience created successfully');
    }

    public function edit(Experience $experience): View
    {
        activity('experience_management')
            ->causedBy(Auth::user())
            ->log("Accessed edit page for experience: {$experience->position_name}");

        return view('backend.resume.experience.edit', [
            'title' => 'Edit Experience',
            'experience' => $experience
        ]);
    }

    public function update(ExperienceUpdateRequest $request, Experience $experience): RedirectResponse
    {
        $data = [
            'company_logo_size' => $request->company_logo_size ?? 2.5,
            'position_name' => $request->position_name,
            'company_name' => $request->company_name,
            'desc' => $request->desc,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'),
            'end_date' => $request->is_still_work_here ? null : ($request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d H:i:s') : null),
        ];

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');

            $imagePath = $this->imageManagementService->uploadImage($file, [
                'currentImagePath' => $experience->company_logo ?? null,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/experiences/company_logos',
            ]);

            $data['company_logo'] = $imagePath;
        }

        $experience->update($data);

        activity('experience_management')
            ->causedBy(Auth::user())
            ->log("Updated experience: {$experience->position_name}");

        return redirect()->route('experience.index')->with('success', 'Experience updated successfully');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $this->imageManagementService->destroyImage($experience->company_logo);

        $experienceTitle = $experience->position_name;
        $experience->delete();

        activity('experience_management')
            ->causedBy(Auth::user())
            ->log("Deleted experience: {$experienceTitle}");

        return redirect()->route('experience.index')->with('success', 'Experience deleted successfully');
    }
}
