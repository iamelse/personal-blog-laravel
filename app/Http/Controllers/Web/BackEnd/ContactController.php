<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    protected array $allowedFilterFields = ['custom_id', 'name', 'email', 'ip'];

    private function _getFilteredContacts(Request $request)
    {
        return Contact::search(
                keyword: $request->keyword,
                columns: $this->allowedFilterFields,
            )
            ->sort(
                sort_by: $request->sort_by ?? 'created_at',
                sort_order: $request->sort_order ?? 'DESC'
            )
            ->paginate($request->query('limit') ?? 10);
    }

    public function index(Request $request): View
    {
        Gate::authorize(PermissionEnum::READ_POST->value);

        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $contacts = $this->_getFilteredContacts($request);

        return view('pages.contact.index', [
            'title' => 'Contact',
            'contacts' => $contacts,
            'allowedFilterFields' => $this->allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_CONTACT->value);

        try {
            $contact->delete();

            return redirect()
                ->route('be.contact.index')
                ->with('success', 'Contact deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting contact (custom_id: {$contact->custom_id}): " . $e->getMessage());

            return redirect()
                ->route('be.contact.index')
                ->with('error', 'An error occurred while deleting the contact.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_CONTACT->value);

        try {
            $contactArray = explode(',', $request->input('custom_ids', ''));

            if (!empty($contactArray)) {
                Contact::whereIn('custom_id', $contactArray)->delete();
            }

            return redirect()
                ->route('be.contact.index')
                ->with('success', 'Contacts deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting contacts: '. $e->getMessage());
            return redirect()
                ->route('be.post-categories.index')
                ->with('error', 'An error occurred while deleting the contacts.');
        }

    }
}
