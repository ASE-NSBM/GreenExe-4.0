<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompetitionInformation;
use App\Models\Faq;
use App\Models\Registration;
use App\Models\SmartCityContent;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Admin login form (FR-56).
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Authenticate an administrator (FR-56).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        if (! Auth::user()->isAdmin()) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'This account is not authorised for the administration area.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Dashboard summary (FR-58).
     */
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalRegistrations' => Registration::count(),
            'totalMembers' => TeamMember::count(),
            'byStatus' => Registration::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'byCategory' => Registration::selectRaw('project_category, count(*) as total')
                ->groupBy('project_category')
                ->pluck('total', 'project_category'),
            'latest' => Registration::with('members')->latest()->take(8)->get(),
        ]);
    }

    /**
     * Manage FAQs (FR-55, FR-67).
     */
    public function faqs()
    {
        return view('admin.faqs.index', [
            'faqs' => Faq::orderBy('sort_order')->get(),
        ]);
    }

    public function storeFaq(Request $request)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Faq::create([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', 'FAQ created.');
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $faq->update([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', 'FAQ updated.');
    }

    public function destroyFaq(Faq $faq)
    {
        $faq->delete();

        return back()->with('status', 'FAQ deleted.');
    }

    /**
     * Manage competition and Smart Green City content (FR-68 to FR-70).
     */
    public function content()
    {
        return view('admin.content.index', [
            'competition' => CompetitionInformation::orderBy('section')->orderBy('sort_order')->get(),
            'smartCity' => SmartCityContent::orderBy('section')->orderBy('sort_order')->get(),
        ]);
    }

    public function updateContent(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:competition,smart_city'],
            'id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        if ($data['type'] === 'competition') {
            CompetitionInformation::findOrFail($data['id'])->update([
                'title' => $data['title'],
                'body' => $data['body'],
                'is_published' => $request->boolean('is_published'),
            ]);
        } else {
            SmartCityContent::findOrFail($data['id'])->update([
                'title' => $data['title'],
                'description' => $data['body'],
                'is_published' => $request->boolean('is_published'),
            ]);
        }

        return back()->with('status', 'Content updated.');
    }

    /**
     * Secure logout (FR-57).
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been logged out.');
    }
}
