<?php

use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// =====================
// MAIN FRONTEND ROUTES
// =====================

// Portfolio Routes
Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/download-cv', [PortfolioController::class, 'downloadCV'])->name('download.cv');

// =====================
// AUTH ROUTES
// =====================

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// PROTECTED ADMIN ROUTES
// =====================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard-data', [AdminController::class, 'getDashboardData'])->name('dashboard.data');

    // Skills routes
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::get('/skills/{id}', [SkillController::class, 'show'])->name('skills.show');
    
    Route::put('/skills/{id}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{id}', [SkillController::class, 'destroy'])->name('skills.destroy');

    // Projects routes
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Sections routes - make sure these exist
    Route::get('/sections', [AdminController::class, 'getSections'])->name('sections.index');
    Route::post('/sections', [AdminController::class, 'storeSection'])->name('sections.store');
    Route::get('/sections/{id}', [AdminController::class, 'getSection'])->name('sections.show');
    Route::put('/sections/{id}', [AdminController::class, 'updateSection'])->name('sections.update');
    Route::delete('/sections/{id}', [AdminController::class, 'deleteSection'])->name('sections.destroy');

    // Messages routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::put('/messages/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::put('/messages/mark-all-read', [MessageController::class, 'markAllAsRead'])->name('messages.mark-all-read');
    Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/messages-stats', [MessageController::class, 'stats'])->name('messages.stats');

    // Profile routes - ADD THESE
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password');
});

Route::get('/blog', function () {
    return view('blog-coming-soon');
})->name('blog');

// Test email route
Route::get('/test-email', function () {
    try {
        Mail::send('emails.test', [], function ($message) {
            $message->to('baraaalrifaee732@gmail.com')
                ->subject('Test Email from Portfolio');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/test-auto-reply', [ContactController::class, 'testEmail']);
