<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Baraa Al-Rifaee</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="#" class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <span class="logo-text">Baraa Al-Rifaee</span>
                </a>
                <button class="toggle-sidebar" id="toggleSidebar" aria-label="Toggle sidebar">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <!-- Main Navigation -->
                <div class="nav-section">
                    <div class="nav-label">Main</div>
                    <ul class="nav-items">
                        <li><a href="#" class="nav-link active" data-section="dashboard">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a></li>
                        <li><a href="#" class="nav-link" data-section="sections">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <span>Sections</span>
                            </a></li>
                        <li><a href="#" class="nav-link" data-section="skills">
                                <i class="nav-icon fas fa-code"></i>
                                <span>Skills</span>
                                <span class="nav-badge" id="skills-count">0</span>
                            </a></li>
                        <li><a href="#" class="nav-link" data-section="projects">
                                <i class="nav-icon fas fa-project-diagram"></i>
                                <span>Projects</span>
                                <span class="nav-badge" id="projects-count">0</span>
                            </a></li>
                    </ul>
                </div>

                <!-- Communication -->
                <div class="nav-section">
                    <div class="nav-label">Communication</div>
                    <ul class="nav-items">
                        <li><a href="#" class="nav-link" data-section="messages">
                                <i class="nav-icon fas fa-envelope"></i>
                                <span>Messages</span>
                                <span class="nav-badge" id="messages-count">0</span>
                            </a></li>
                        <li><a href="#" class="nav-link" data-section="analytics">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <span>Analytics</span>
                            </a></li>
                    </ul>
                </div>

                <!-- System -->
                <div class="nav-section">
                    <div class="nav-label">System</div>
                    <ul class="nav-items">
                        <li><a href="#" class="nav-link" data-section="profile">
                                <i class="nav-icon fas fa-user"></i>
                                <span>Profile</span>
                            </a></li>
                        <li><a href="#" class="nav-link" data-section="settings">
                                <i class="nav-icon fas fa-cog"></i>
                                <span>Settings</span>
                            </a></li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="admin-header" style="position: relative; width: 102%; right: 8px;">
                <div class="header-left">
                    
                    <h1 class="page-title" id="pageTitle">Dashboard</h1>
                </div>

                <div class="header-right">
                    <button class="header-action" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge"></span>
                    </button>
                    <div class="user-menu">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="user-role">Administrator</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Dashboard Section -->
                <section id="dashboard" class="section-content active">
                    <div class="dashboard-grid">
                        <div class="stat-card" data-stat="projects">
                            <div class="stat-header">
                                <div class="stat-icon projects">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-value">0</div>
                                    <div class="stat-label">Total Projects</div>
                                </div>
                                <div class="stat-trend trend-up">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card" data-stat="skills">
                            <div class="stat-header">
                                <div class="stat-icon skills">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-value">0</div>
                                    <div class="stat-label">Active Skills</div>
                                </div>
                                <div class="stat-trend trend-up">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card" data-stat="messages">
                            <div class="stat-header">
                                <div class="stat-icon messages">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-value">0</div>
                                    <div class="stat-label">New Messages</div>
                                </div>
                                <div class="stat-trend trend-down">
                                    <i class="fas fa-arrow-down"></i>
                                    <span>0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card" data-stat="views">
                            <div class="stat-header">
                                <div class="stat-icon views">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-value">0</div>
                                    <div class="stat-label">Page Views</div>
                                </div>
                                <div class="stat-trend trend-up">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>0%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="card-header">
                            <h2 class="card-title">Recent Activity</h2>
                            <div class="card-actions">
                                <button class="btn btn-primary btn-sm" data-action="refresh">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <table class="data-table" id="recent-activities">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Item</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">Loading activities...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Dynamic Sections -->
                <div id="dynamic-sections"></div>
            </div>
        </main>
    </div>

    <!-- Unified Modal Template -->
    <template id="modal-template">
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button class="modal-close" aria-label="Close modal">&times;</button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </template>

    <!-- Section Templates -->
    <template id="sections-template">
        <section class="section-content">
            <div class="section-card">
                <div class="card-header">
                    <h2 class="card-title">Manage Portfolio Sections</h2>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-sm" data-action="add-section">
                            <i class="fas fa-plus"></i> Add Section
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="sections-grid" id="sections-container"></div>
                </div>
            </div>
        </section>
    </template>

    <template id="skills-template">
        <section class="section-content">
            <div class="section-card">
                <div class="card-header">
                    <h2 class="card-title">Manage Skills</h2>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-sm" data-action="add-skill">
                            <i class="fas fa-plus"></i> Add Skill
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="skills-grid" id="skills-container"></div>
                </div>
            </div>
        </section>
    </template>

    <template id="projects-template">
        <section class="section-content">
            <div class="section-card">
                <div class="card-header">
                    <h2 class="card-title">Manage Projects</h2>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-sm" data-action="add-project">
                            <i class="fas fa-plus"></i> Add Project
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="projects-grid" id="projects-container"></div>
                </div>
            </div>
        </section>
    </template>

    <template id="messages-template">
        <section class="section-content">
            <div class="section-card">
                <div class="card-header">
                    <h2 class="card-title">Contact Messages</h2>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-sm" data-action="mark-all-read">
                            <i class="fas fa-check-double"></i> Mark All Read
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="messages-list" id="messages-container"></div>
                </div>
            </div>
        </section>
    </template>

    <template id="profile-template">
        <section class="section-content">
            <div class="form-grid">
                <div class="form-card">
                    <h2 class="card-title">Profile Information</h2>
                    <form id="profile-form" class="ajax-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="{{ Auth::user()->title ?? '' }}"
                                placeholder="Full Stack Developer">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" rows="4"
                                placeholder="Write about yourself...">{{ Auth::user()->bio ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>

                <div class="form-card">
                    <h2 class="card-title">Change Password</h2>
                    <form id="password-form" class="ajax-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" required minlength="8">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="new_password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </section>
    </template>

    <!-- REMOVE THESE DUPLICATE SIMPLE TEMPLATES -->
    <!--
    <template id="section-form">
        <form class="ajax-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="form-label">Section Name</label>
                <input type="text" name="name" required placeholder="e.g., Hero, About">
            </div>
            <div class="form-group">
                <label class="form-label">Section Title</label>
                <input type="text" name="title" required placeholder="e.g., About Me">
            </div>
            <div class="form-group">
                <label class="form-label">Content</label>
                <textarea name="content" rows="4" placeholder="Section content..."></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" data-action="cancel">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Section</button>
            </div>
        </form>
    </template>

    <template id="skill-form">
        <form class="ajax-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="form-label">Skill Name</label>
                <input type="text" name="name" required placeholder="e.g., Laravel, React">
            </div>
            <div class="form-group">
                <label class="form-label">Proficiency</label>
                <input type="range" name="percentage" min="0" max="100" value="80">
                <div class="range-value">80%</div>
            </div>
            <div class="form-group">
                <label class="form-label">Icon</label>
                <input type="text" name="icon" required placeholder="fab fa-laravel">
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" data-action="cancel">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Skill</button>
            </div>
        </form>
    </template>

    <template id="project-form">
        <form class="ajax-form" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="form-label">Project Title</label>
                <input type="text" name="title" required placeholder="Project title">
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" required placeholder="Project description..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Technologies</label>
                <input type="text" name="technologies" required placeholder="Laravel, Vue.js, MySQL">
            </div>
            <div class="form-group">
                <label class="form-label">Project Image</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" data-action="cancel">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Project</button>
            </div>
        </form>
    </template>
    -->

    <!-- KEEP THESE COMPLETE MODAL TEMPLATES -->

    <!-- Section Form Template -->
    <template id="section-form-template">
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Section</h3>
                    <button class="modal-close" aria-label="Close modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="section-form" class="ajax-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="form-label">Section Name</label>
                            <input type="text" name="name" required placeholder="e.g., Hero, About">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section Title</label>
                            <input type="text" name="title" required placeholder="e.g., About Me">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Content</label>
                            <textarea name="content" rows="4" placeholder="Section content..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" value="0" min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="default">Default</option>
                                <option value="hero">Hero</option>
                                <option value="about">About</option>
                                <option value="skills">Skills</option>
                                <option value="projects">Projects</option>
                                <option value="contact">Contact</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" checked>
                                <span class="checkmark"></span>
                                Active
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="show_in_nav">
                                <span class="checkmark"></span>
                                Show in Navigation
                            </label>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary"
                                onclick="adminDashboard.closeModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Section</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <!-- Skill Form Template -->
    <template id="skill-form-template">
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Skill</h3>
                    <button class="modal-close" aria-label="Close modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="skill-form" class="ajax-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="form-label">Skill Name</label>
                            <input type="text" name="name" required placeholder="e.g., Laravel, React">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Proficiency: <span class="percentage-display">80%</span></label>
                            <input type="range" name="percentage" min="0" max="100" value="80" class="slider">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Icon Class</label>
                            <input type="text" name="icon" required placeholder="fab fa-laravel">
                            <small class="form-hint">Use FontAwesome icon classes</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" value="0" min="0">
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <!-- Change this: add value="1" and remove checked by default -->
                                <input type="checkbox" name="is_active" value="1">
                                <span class="checkmark"></span>
                                Active
                            </label>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary"
                                onclick="adminDashboard.closeModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Skill</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <!-- Project Form Template -->
    <template id="project-form-template">
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Project</h3>
                    <button class="modal-close" aria-label="Close modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="project-form" class="ajax-form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="form-label">Project Title</label>
                            <input type="text" name="title" required placeholder="Project title">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" required
                                placeholder="Project description..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Technologies</label>
                            <input type="text" name="technologies" required placeholder="Laravel, Vue.js, MySQL">
                            <small class="form-hint">Separate technologies with commas</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Project URL</label>
                            <input type="url" name="project_url" placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">GitHub URL</label>
                            <input type="url" name="github_url" placeholder="https://github.com/username/project">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Project Image</label>
                            <input type="file" name="image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" value="0" min="0">
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" checked>
                                <span class="checkmark"></span>
                                Active
                            </label>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary"
                                onclick="adminDashboard.closeModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
