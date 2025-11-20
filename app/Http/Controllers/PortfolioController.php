<?php
// app/Http/Controllers/PortfolioController.php
namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SkillEcosystem;
use App\Models\EcosystemSection;
use App\Models\Project;
use App\Models\Contact;
use App\Models\User;
use App\Models\Analytics;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function home()
    {
        $this->trackVisit('/');
        $homeSection = Section::where('name', 'home')->first();
        $projects = Project::where('is_active', true)->orderBy('order')->get();
        
        // Get ecosystem skills for home page
        $javascriptSkills = SkillEcosystem::byEcosystem('javascript')->active()->ordered()->limit(3)->get();
        $phpSkills = SkillEcosystem::byEcosystem('php')->active()->ordered()->limit(3)->get();

        return view('portfolio.home', compact('homeSection', 'projects', 'javascriptSkills', 'phpSkills'));
    }

    public function about()
    {
        $this->trackVisit('/about');
        $aboutSection = Section::where('name', 'about')->first();
        return view('portfolio.about', compact('aboutSection'));
    }

    public function skills()
    {
        // Get ecosystem sections and skills
        $javascriptSection = EcosystemSection::where('ecosystem', 'javascript')->visible()->first();
        $phpSection = EcosystemSection::where('ecosystem', 'php')->visible()->first();
        
        $javascriptSkills = $javascriptSection ? 
            SkillEcosystem::byEcosystem('javascript')->active()->ordered()->get() : collect();
        $phpSkills = $phpSection ? 
            SkillEcosystem::byEcosystem('php')->active()->ordered()->get() : collect();
        
        return view('portfolio.skills', compact('javascriptSection', 'phpSection', 'javascriptSkills', 'phpSkills'));
    }

    public function projects()
    {
        $projects = Project::where('is_active', true)->orderBy('order')->get();
        return view('portfolio.projects', compact('projects'));
    }

    public function contact()
    {
        $this->trackVisit('/contact');
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

    private function trackVisit($page)
    {
        $request = request();
        $userAgent = $request->userAgent();
        
        Analytics::create([
            'page' => $page,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'referrer' => $request->header('referer'),
            'device_type' => $this->getDeviceType($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'os' => $this->getOS($userAgent)
        ]);
    }

    private function getDeviceType($userAgent)
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            return 'Mobile';
        }
        return 'Desktop';
    }

    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        return 'Other';
    }

    private function getOS($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac') !== false) return 'macOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iOS') !== false) return 'iOS';
        return 'Other';
    }
}
