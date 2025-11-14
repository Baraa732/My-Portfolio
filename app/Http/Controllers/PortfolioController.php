<?php
// app/Http/Controllers/PortfolioController.php
namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Contact;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function home()
    {
        $homeSection = Section::where('name', 'home')->first();
        $skills = Skill::where('is_active', true)->orderBy('order')->get();
        $projects = Project::where('is_active', true)->orderBy('order')->get();

        return view('portfolio.home', compact('homeSection', 'skills', 'projects'));
    }

    public function about()
    {
        $aboutSection = Section::where('name', 'about')->first();
        return view('portfolio.about', compact('aboutSection'));
    }

    public function skills()
    {
        $skills = Skill::where('is_active', true)->orderBy('order')->get();
        return view('portfolio.skills', compact('skills'));
    }

    public function projects()
    {
        $projects = Project::where('is_active', true)->orderBy('order')->get();
        return view('portfolio.projects', compact('projects'));
    }

    public function contact()
    {
        return view('portfolio.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function downloadCV()
    {
        $filePath = public_path('cv/cv.pdf');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'CV not found.');
        }

        return response()->download($filePath);
    }
}
