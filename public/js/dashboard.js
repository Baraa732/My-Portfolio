class NotificationSystem {
    constructor() {
        this.notificationContainer = null;
        this.activeNotifications = new Set();
        this.init();
    }

    init() {
        this.createNotificationContainer();
    }

    createNotificationContainer() {
        // Remove existing container if any
        const existingContainer = document.getElementById('admin-notification-container');
        if (existingContainer) {
            existingContainer.remove();
        }

        this.notificationContainer = document.createElement('div');
        this.notificationContainer.id = 'admin-notification-container';
        this.notificationContainer.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
        `;
        document.body.appendChild(this.notificationContainer);
    }

    showNotification(message, type = 'info', duration = 5000) {
        const notificationId = `${message}-${type}`;
        if (this.activeNotifications.has(notificationId)) {
            return;
        }

        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="notification-icon fas fa-${this.getNotificationIcon(type)}"></i>
                <div class="notification-message">${message}</div>
                <button class="notification-close" title="Dismiss">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            this.removeNotification(notification, notificationId);
        });

        this.notificationContainer.appendChild(notification);
        this.activeNotifications.add(notificationId);

        setTimeout(() => notification.classList.add('show'), 100);

        if (duration > 0) {
            setTimeout(() => {
                this.removeNotification(notification, notificationId);
            }, duration);
        }

        return notification;
    }

    removeNotification(notification, notificationId) {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
            this.activeNotifications.delete(notificationId);
        }, 300);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-triangle',
            warning: 'exclamation-circle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }
}

class AdminDashboard {
    constructor() {
        this.initializeCounts();
        this.notificationSystem = new NotificationSystem();
        this.currentSection = 'dashboard';

        // Fix base URL - use absolute path to avoid issues
        const baseMeta = document.querySelector('meta[name="base-url"]');
        this.baseUrl = baseMeta ? baseMeta.content : window.location.origin;

        // Ensure it ends with /admin
        if (!this.baseUrl.endsWith('/admin')) {
            this.baseUrl += '/admin';
        }

        console.log('Admin Dashboard initialized with base URL:', this.baseUrl);

        this.formSubmitHandler = null;
        this.buttonClickHandler = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadDashboardData();
        this.initLogout();
    }

    async initializeCounts() {
        try {
            // Initialize all counts when page loads
            await Promise.all([
                this.updateSkillsCount(),
                this.updateProjectsCount(),
                this.updateMessagesCount()
            ]);
        } catch (error) {
            console.error('Error initializing counts:', error);
        }
    }

    bindEvents() {
        // Navigation - bind once
        document.addEventListener('click', (e) => {
            if (e.target.closest('.nav-link')) {
                e.preventDefault();
                const link = e.target.closest('.nav-link');
                this.switchSection(link.dataset.section);
            }
        });

        // Mobile menu - bind once
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('mobile-open');
            });
        }

        // Sidebar toggle - bind once
        const toggleSidebar = document.getElementById('toggleSidebar');
        if (toggleSidebar) {
            toggleSidebar.addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('collapsed');
            });
        }
    }

    initLogout() {
        // Logout - bind once
        document.addEventListener('click', (e) => {
            if (e.target.closest('.logout-item')) {
                e.preventDefault();
                this.confirmLogout();
            }
        });
    }

    // =====================
    // SECTION MANAGEMENT
    // =====================

    async getSectionsContent() {
        try {
            const response = await fetch(`${this.baseUrl}/sections`);
            const sections = await response.json();

            let html = `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Portfolio Sections</h3>
                            <div class="card-actions">
                                <button class="btn btn-primary btn-sm" onclick="adminDashboard.showSectionForm()">
                                    <i class="fas fa-plus"></i> Add Section
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="sections-grid" id="sections-container">
            `;

            if (sections.length === 0) {
                html += `
                    <div class="text-center w-100" style="grid-column: 1 / -1; padding: 3rem;">
                        <i class="fas fa-layer-group" style="font-size: 3rem; color: var(--gray-dark); margin-bottom: 1rem;"></i>
                        <h4 style="color: var(--gray); margin-bottom: 1rem;">No Sections Yet</h4>
                        <p style="color: var(--gray-dark); margin-bottom: 2rem;">Start by adding sections to build your portfolio structure.</p>
                        <button class="btn btn-primary" onclick="adminDashboard.showSectionForm()">
                            <i class="fas fa-plus"></i> Add Your First Section
                        </button>
                    </div>
                `;
            } else {
                sections.forEach(section => {
                    const shortContent = section.content && section.content.length > 100
                        ? section.content.substring(0, 100) + '...'
                        : section.content || 'No content';

                    html += `
                        <div class="section-item" data-section-id="${section.id}">
                            <div class="d-flex align-center justify-between mb-2">
                                <div class="d-flex align-center gap-1">
                                    <div style="width: 40px; height: 40px; background: var(--gradient); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-layer-group" style="color: var(--light); font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <h4 style="color: var(--light); margin: 0;">${section.name}</h4>
                                        <small style="color: var(--gray-dark);">${section.title}</small>
                                    </div>
                                </div>
                                <div class="d-flex align-center gap-1">
                                    <span class="status-badge ${section.is_active ? 'status-active' : 'status-inactive'}">
                                        ${section.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                    ${section.show_in_nav ? '<span class="status-badge status-active">Nav</span>' : ''}
                                </div>
                            </div>
                            
                            <div style="margin-bottom: 1rem;">
                                <p style="color: var(--gray); font-size: 0.9rem; line-height: 1.4;">${shortContent}</p>
                            </div>
                            
                            <div class="d-flex justify-between align-center">
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <span style="background: rgba(115, 12, 14, 0.2); color: var(--primary); padding: 0.2rem 0.5rem; border-radius: 12px; font-size: 0.7rem; border: 1px solid rgba(115, 12, 14, 0.3);">
                                        ${section.type}
                                    </span>
                                    <span style="background: rgba(59, 130, 246, 0.2); color: var(--info); padding: 0.2rem 0.5rem; border-radius: 12px; font-size: 0.7rem; border: 1px solid rgba(59, 130, 246, 0.3);">
                                        Order: ${section.order}
                                    </span>
                                </div>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-primary btn-sm" onclick="adminDashboard.editSection(${section.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="adminDashboard.deleteSection(${section.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            html += `
                            </div>
                        </div>
                    </div>
                </section>
            `;

            return html;

        } catch (error) {
            console.error('Error loading sections:', error);
            return `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                <h4 style="color: var(--light); margin-bottom: 1rem;">Error Loading Sections</h4>
                                <p style="color: var(--gray);">Unable to load sections. Please check your backend connection.</p>
                                <button class="btn btn-primary" onclick="adminDashboard.loadSectionContent('sections')">
                                    <i class="fas fa-redo"></i> Try Again
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            `;
        }
    }

    showSectionForm(sectionId = null) {
        this.closeModal();

        const template = document.getElementById('section-form-template');
        if (!template) {
            this.showNotification('Section form template not found', 'error');
            return;
        }

        const modal = document.createElement('div');
        modal.innerHTML = template.innerHTML;
        document.body.appendChild(modal);

        const form = modal.querySelector('#section-form');
        const title = modal.querySelector('.modal-title');

        if (sectionId) {
            title.textContent = 'Edit Section';
            form.action = `${this.baseUrl}/sections/${sectionId}`;
            console.log('Edit section form action:', form.action);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);

            this.loadSectionData(sectionId);
        } else {
            title.textContent = 'Add New Section';
            form.action = `${this.baseUrl}/sections`;
            console.log('Add section form action:', form.action);
        }

        modal.querySelector('.modal-close').addEventListener('click', () => this.closeModal());
        modal.querySelector('.modal-overlay').addEventListener('click', (e) => {
            if (e.target === modal.querySelector('.modal-overlay')) {
                this.closeModal();
            }
        });
    }

    async loadSectionData(sectionId) {
        try {
            const response = await fetch(`${this.baseUrl}/sections/${sectionId}`);

            if (!response.ok) {
                if (response.status === 404) {
                    this.showNotification('Section not found. It may have been deleted.', 'info');
                    this.closeModal();
                    return;
                }
                throw new Error('Failed to fetch section data');
            }

            const section = await response.json();

            const form = document.getElementById('section-form');
            if (form) {
                form.querySelector('input[name="name"]').value = section.name || '';
                form.querySelector('input[name="title"]').value = section.title || '';
                form.querySelector('textarea[name="content"]').value = section.content || '';
                form.querySelector('input[name="order"]').value = section.order || 0;
                form.querySelector('select[name="type"]').value = section.type || 'default';
                form.querySelector('input[name="is_active"]').checked = section.is_active !== undefined ? section.is_active : true;
                form.querySelector('input[name="show_in_nav"]').checked = section.show_in_nav || false;
            }

        } catch (error) {
            console.error('Error loading section data:', error);
            this.showNotification('Error loading section data', 'error');
            this.closeModal();
        }
    }

    async deleteSection(sectionId) {
        if (!confirm('Are you sure you want to delete this section?')) return;

        try {
            const response = await fetch(`${this.baseUrl}/sections/${sectionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showNotification(result.message, 'success');

                const sectionElement = document.querySelector(`[data-section-id="${sectionId}"]`);
                if (sectionElement) {
                    sectionElement.style.opacity = '0';
                    setTimeout(() => sectionElement.remove(), 300);
                }

                this.loadDashboardData();

            } else {
                this.showNotification(result.message || 'Error deleting section', 'error');
            }
        } catch (error) {
            console.error('Error deleting section:', error);
            this.showNotification('Error deleting section', 'error');
        }
    }

    editSection(sectionId) {
        this.showSectionForm(sectionId);
    }

    // =====================
    // SKILLS MANAGEMENT
    // =====================

    async getSkillsContent() {
        try {
            const response = await fetch(`${this.baseUrl}/skills`);
            const skills = await response.json();

            let html = `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Skills</h3>
                            <div class="card-actions">
                                <button class="btn btn-primary btn-sm" onclick="adminDashboard.showSkillForm()">
                                    <i class="fas fa-plus"></i> Add Skill
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="skills-grid" id="skills-container">
            `;

            if (skills.length === 0) {
                html += `
                    <div class="text-center w-100" style="grid-column: 1 / -1; padding: 3rem;">
                        <i class="fas fa-code" style="font-size: 3rem; color: var(--gray-dark); margin-bottom: 1rem;"></i>
                        <h4 style="color: var(--gray); margin-bottom: 1rem;">No Skills Yet</h4>
                        <p style="color: var(--gray-dark); margin-bottom: 2rem;">Start by adding your first skill to showcase your expertise.</p>
                        <button class="btn btn-primary" onclick="adminDashboard.showSkillForm()">
                            <i class="fas fa-plus"></i> Add Your First Skill
                        </button>
                    </div>
                `;
            } else {
                skills.forEach(skill => {
                    html += `
                        <div class="skill-item" data-skill-id="${skill.id}">
                            <div class="d-flex align-center justify-between mb-2">
                                <div class="d-flex align-center gap-1">
                                    <div style="width: 40px; height: 40px; background: var(--gradient); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="${skill.icon}" style="color: var(--light); font-size: 1.2rem;"></i>
                                    </div>
                                    <h4 style="color: var(--light); margin: 0;">${skill.name}</h4>
                                </div>
                                <span class="status-badge ${skill.is_active ? 'status-active' : 'status-inactive'}">
                                    ${skill.is_active ? 'Active' : 'Inactive'}
                                </span>
                            </div>
                            <div class="skill-bar" style="background: var(--secondary); height: 8px; border-radius: 4px; margin-bottom: 0.5rem;">
                                <div class="skill-progress" style="height: 100%; background: var(--gradient); width: ${skill.percentage}%; border-radius: 4px;"></div>
                            </div>
                            <div class="d-flex justify-between align-center">
                                <span style="color: var(--gray); font-size: 0.9rem;">${skill.percentage}% Proficiency</span>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-primary btn-sm" onclick="adminDashboard.editSkill(${skill.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="adminDashboard.deleteSkill(${skill.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            html += `
                            </div>
                        </div>
                    </div>
                </section>
            `;

            document.getElementById('skills-count').textContent = skills.length;
            return html;

        } catch (error) {
            console.error('Error loading skills:', error);
            return `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                <h4 style="color: var(--light); margin-bottom: 1rem;">Error Loading Skills</h4>
                                <p style="color: var(--gray);">Unable to load skills. Please check your backend connection.</p>
                                <button class="btn btn-primary" onclick="adminDashboard.loadSectionContent('skills')">
                                    <i class="fas fa-redo"></i> Try Again
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            `;
        }
    }

    showSkillForm(skillId = null) {
        this.closeModal();

        const template = document.getElementById('skill-form-template');
        if (!template) {
            this.showNotification('Skill form template not found', 'error');
            return;
        }

        const modal = document.createElement('div');
        modal.innerHTML = template.innerHTML;
        document.body.appendChild(modal);

        setTimeout(() => {
            const form = document.getElementById('skill-form');
            const title = modal.querySelector('.modal-title');

            if (!form) {
                console.error('Skill form not found after adding to DOM');
                this.showNotification('Error: Form not found', 'error');
                return;
            }

            console.log('=== SKILL FORM DEBUG ===');
            console.log('Skill ID:', skillId);
            console.log('Base URL:', this.baseUrl);

            if (skillId) {
                title.textContent = 'Edit Skill';
                // Use absolute URL to avoid any base URL issues
                form.action = `/admin/skills/${skillId}`;
                console.log('Edit skill form action:', form.action);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);

                setTimeout(() => {
                    this.loadSkillData(skillId);
                }, 100);
            } else {
                title.textContent = 'Add New Skill';
                // Use absolute URL
                form.action = `/admin/skills`;
                console.log('Add skill form action:', form.action);
            }

            this.initializeSkillFormSlider(form);
            this.initializeModalEvents(modal);

        }, 50);
    }

    initializeSkillFormSlider(form) {
        const slider = form.querySelector('input[name="percentage"]');
        const display = form.querySelector('.percentage-display');

        if (slider && display) {
            slider.replaceWith(slider.cloneNode(true));
            const newSlider = form.querySelector('input[name="percentage"]');

            newSlider.addEventListener('input', (e) => {
                display.textContent = e.target.value + '%';
            });

            display.textContent = newSlider.value + '%';
        }
    }

    async loadSkillData(skillId) {
        try {
            console.log('Loading skill data for ID:', skillId);

            const response = await fetch(`/admin/skills/${skillId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const skill = await response.json();
            console.log('Skill data received:', skill);

            await new Promise(resolve => setTimeout(resolve, 150));

            const form = document.getElementById('skill-form');
            if (!form) {
                throw new Error('Form not found in DOM');
            }

            this.setFormValue(form, 'input[name="name"]', skill.name);
            this.setFormValue(form, 'input[name="percentage"]', skill.percentage || 80);
            this.setFormValue(form, 'input[name="icon"]', skill.icon);
            this.setFormValue(form, 'input[name="order"]', skill.order || 0);

            // Fix: Handle checkbox properly - set checked attribute based on boolean value
            const isActiveCheckbox = form.querySelector('input[name="is_active"]');
            if (isActiveCheckbox) {
                isActiveCheckbox.checked = skill.is_active == 1 || skill.is_active === true;
            }

            const display = form.querySelector('.percentage-display');
            const slider = form.querySelector('input[name="percentage"]');
            if (display && slider) {
                display.textContent = (skill.percentage || 80) + '%';
                slider.value = skill.percentage || 80;
            }

            console.log('Skill form populated successfully');

        } catch (error) {
            console.error('Error loading skill data:', error);
            this.showNotification('Error loading skill data: ' + error.message, 'error');
        }
    }

    async deleteSkill(skillId) {
        if (!confirm('Are you sure you want to delete this skill?')) return;

        try {
            const response = await fetch(`/admin/skills/${skillId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showNotification(result.message, 'success');

                const skillElement = document.querySelector(`[data-skill-id="${skillId}"]`);
                if (skillElement) {
                    skillElement.style.opacity = '0';
                    setTimeout(() => skillElement.remove(), 300);
                }

                await this.updateSkillsCount();
                this.loadDashboardData();

            } else {
                this.showNotification(result.message || 'Error deleting skill', 'error');
            }
        } catch (error) {
            console.error('Error deleting skill:', error);
            this.showNotification('Error deleting skill', 'error');
        }
    }

    editSkill(skillId) {
        this.showSkillForm(skillId);
    }

    // =====================
    // PROJECTS MANAGEMENT
    // =====================

    async getProjectsContent() {
        try {
            const response = await fetch(`${this.baseUrl}/projects`);
            const projects = await response.json();

            let html = `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Projects</h3>
                            <div class="card-actions">
                                <button class="btn btn-primary btn-sm" onclick="adminDashboard.showProjectForm()">
                                    <i class="fas fa-plus"></i> Add Project
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="projects-grid" id="projects-container">
            `;

            if (projects.length === 0) {
                html += `
                    <div class="text-center w-100" style="grid-column: 1 / -1; padding: 3rem;">
                        <i class="fas fa-project-diagram" style="font-size: 3rem; color: var(--gray-dark); margin-bottom: 1rem;"></i>
                        <h4 style="color: var(--gray); margin-bottom: 1rem;">No Projects Yet</h4>
                        <p style="color: var(--gray-dark); margin-bottom: 2rem;">Start by adding your first project to showcase your work.</p>
                        <button class="btn btn-primary" onclick="adminDashboard.showProjectForm()">
                            <i class="fas fa-plus"></i> Add Your First Project
                        </button>
                    </div>
                `;
            } else {
                projects.forEach(project => {
                    const shortDescription = project.description.length > 120
                        ? project.description.substring(0, 120) + '...'
                        : project.description;

                    html += `
                        <div class="project-item">
                            <div style="height: 200px; background: var(--gradient); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                                ${project.image ?
                            `<img src="/storage/${project.image}" alt="${project.title}" style="width: 100%; height: 100%; object-fit: cover;">` :
                            `<i class="fas fa-project-diagram" style="font-size: 3rem; color: var(--light);"></i>`
                        }
                                <div style="position: absolute; top: 10px; right: 10px;">
                                    <span class="status-badge ${project.is_active ? 'status-active' : 'status-inactive'}">
                                        ${project.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </div>
                            </div>
                            <div style="padding: 1.5rem;">
                                <h4 style="color: var(--light); margin-bottom: 0.5rem; font-size: 1.1rem;">${project.title}</h4>
                                <p style="color: var(--gray); margin-bottom: 1rem; font-size: 0.9rem; line-height: 1.4;">${shortDescription}</p>
                                <div style="margin-bottom: 1rem;">
                                    <div class="tech-tags">
                                        ${project.technologies.split(',').map(tech =>
                            `<span class="tech-tag">${tech.trim()}</span>`
                        ).join('')}
                                    </div>
                                </div>
                                <div class="d-flex justify-between align-center">
                                    <div class="d-flex gap-1">
                                        ${project.project_url ? `
                                            <a href="${project.project_url}" target="_blank" class="btn btn-primary btn-sm" style="padding: 0.3rem 0.6rem;">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        ` : ''}
                                        ${project.github_url ? `
                                            <a href="${project.github_url}" target="_blank" class="btn btn-secondary btn-sm" style="padding: 0.3rem 0.6rem;">
                                                <i class="fab fa-github"></i>
                                            </a>
                                        ` : ''}
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-primary btn-sm" onclick="adminDashboard.editProject(${project.id})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="adminDashboard.deleteProject(${project.id})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            html += `
                            </div>
                        </div>
                    </div>
                </section>
            `;

            document.getElementById('projects-count').textContent = projects.length;
            return html;

        } catch (error) {
            console.error('Error loading projects:', error);
            return `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                <h4 style="color: var(--light); margin-bottom: 1rem;">Error Loading Projects</h4>
                                <p style="color: var(--gray);">Unable to load projects. Please check your backend connection.</p>
                                <button class="btn btn-primary" onclick="adminDashboard.loadSectionContent('projects')">
                                    <i class="fas fa-redo"></i> Try Again
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            `;
        }
    }

    showProjectForm(projectId = null) {
        this.closeModal();

        const template = document.getElementById('project-form-template');
        if (!template) {
            this.showNotification('Project form template not found', 'error');
            return;
        }

        const modal = document.createElement('div');
        modal.innerHTML = template.innerHTML;
        document.body.appendChild(modal);

        const form = modal.querySelector('#project-form');
        const title = modal.querySelector('.modal-title');

        if (projectId) {
            title.textContent = 'Edit Project';
            form.action = `/admin/projects/${projectId}`;
            console.log('Edit project form action:', form.action);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);

            this.loadProjectData(projectId);
        } else {
            title.textContent = 'Add New Project';
            form.action = `/admin/projects`;
            console.log('Add project form action:', form.action);
        }

        modal.querySelector('.modal-close').addEventListener('click', () => this.closeModal());
        modal.querySelector('.modal-overlay').addEventListener('click', (e) => {
            if (e.target === modal.querySelector('.modal-overlay')) {
                this.closeModal();
            }
        });
    }

    async loadProjectData(projectId) {
        try {
            const response = await fetch(`/admin/projects/${projectId}`);

            if (!response.ok) {
                if (response.status === 404) {
                    this.showNotification('Project not found. It may have been deleted.', 'info');
                    this.closeModal();
                    return;
                }
                throw new Error('Failed to fetch project data');
            }

            const project = await response.json();

            const form = document.getElementById('project-form');
            if (form) {
                form.querySelector('input[name="title"]').value = project.title || '';
                form.querySelector('textarea[name="description"]').value = project.description || '';
                form.querySelector('input[name="technologies"]').value = project.technologies || '';
                form.querySelector('input[name="project_url"]').value = project.project_url || '';
                form.querySelector('input[name="github_url"]').value = project.github_url || '';
                form.querySelector('input[name="order"]').value = project.order || 0;
                form.querySelector('input[name="is_active"]').checked = project.is_active !== undefined ? project.is_active : true;
            }

        } catch (error) {
            console.error('Error loading project data:', error);
            this.showNotification('Error loading project data', 'error');
            this.closeModal();
        }
    }

    async deleteProject(projectId) {
        if (!confirm('Are you sure you want to delete this project? This action cannot be undone.')) return;

        try {
            const response = await fetch(`/admin/projects/${projectId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showNotification(result.message, 'success');

                const projectElement = document.querySelector(`.project-item`);
                if (projectElement) {
                    projectElement.style.opacity = '0';
                    projectElement.style.transform = 'translateX(100px)';
                    setTimeout(() => projectElement.remove(), 300);
                }

                await this.updateProjectsCount();
                this.loadDashboardData();

            } else {
                this.showNotification(result.message || 'Error deleting project', 'error');
            }
        } catch (error) {
            console.error('Error deleting project:', error);
            this.showNotification('Error deleting project', 'error');
        }
    }

    editProject(projectId) {
        this.showProjectForm(projectId);
    }

    // =====================
    // MESSAGES MANAGEMENT
    // =====================

    async getMessagesContent() {
        try {
            const response = await fetch(`${this.baseUrl}/messages`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const messages = await response.json();

            let html = `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-header">
                            <h3 class="card-title">Contact Messages</h3>
                            <div class="card-actions">
                                <button class="btn btn-primary btn-sm" onclick="adminDashboard.markAllAsRead()">
                                    <i class="fas fa-check-double"></i> Mark All Read
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="messages-list" id="messages-container">
            `;

            if (!messages || messages.length === 0) {
                html += `
                    <div class="text-center w-100" style="padding: 3rem;">
                        <i class="fas fa-envelope" style="font-size: 3rem; color: var(--gray-dark); margin-bottom: 1rem;"></i>
                        <h4 style="color: var(--gray); margin-bottom: 1rem;">No Messages Yet</h4>
                        <p style="color: var(--gray-dark);">No contact messages have been received yet.</p>
                    </div>
                `;
            } else {
                messages.forEach(message => {
                    const shortMessage = message.message.length > 150
                        ? message.message.substring(0, 150) + '...'
                        : message.message;
                    const date = new Date(message.created_at).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    html += `
                        <div class="message-item ${message.is_read ? '' : 'unread'}" data-message-id="${message.id}">
                            <div class="d-flex justify-between align-start mb-2">
                                <div style="flex: 1;">
                                    <h4 style="color: var(--light); margin: 0 0 0.25rem 0;">${message.subject}</h4>
                                    <div style="display: flex; gap: 1rem; color: var(--gray-dark); font-size: 0.9rem;">
                                        <span><i class="fas fa-user"></i> ${message.name}</span>
                                        <span><i class="fas fa-envelope"></i> ${message.email}</span>
                                        <span><i class="fas fa-clock"></i> ${date}</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    ${!message.is_read ? `
                                        <button class="btn btn-success btn-sm" onclick="adminDashboard.markAsRead(${message.id})" title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    ` : ''}
                                    <button class="btn btn-primary btn-sm" onclick="adminDashboard.viewMessage(${message.id})" title="View message">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="adminDashboard.deleteMessage(${message.id})" title="Delete message">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <p style="color: var(--gray); line-height: 1.4; margin: 0;">${shortMessage}</p>
                            ${!message.is_read ? `
                                <div style="margin-top: 0.5rem;">
                                    <span class="status-badge status-active">New</span>
                                </div>
                            ` : ''}
                        </div>
                    `;
                });
            }

            html += `
                            </div>
                        </div>
                    </div>
                </section>
            `;

            await this.updateMessagesCount();
            return html;

        } catch (error) {
            console.error('Error loading messages:', error);
            return `
                <section class="section-content">
                    <div class="section-card">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                <h4 style="color: var(--light); margin-bottom: 1rem;">Error Loading Messages</h4>
                                <p style="color: var(--gray);">${error.message}</p>
                                <button class="btn btn-primary" onclick="adminDashboard.loadSectionContent('messages')">
                                    <i class="fas fa-redo"></i> Try Again
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            `;
        }
    }

    async markAsRead(messageId) {
        try {
            const response = await fetch(`${this.baseUrl}/messages/${messageId}/read`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showNotification('Message marked as read', 'success');

                const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
                if (messageElement) {
                    messageElement.classList.remove('unread');
                    messageElement.querySelector('.status-badge')?.remove();
                    messageElement.querySelector('.btn-success')?.remove();
                }

                await this.updateMessagesCount();
                this.loadDashboardData();
            }
        } catch (error) {
            console.error('Error marking message as read:', error);
            this.showNotification('Error marking message as read', 'error');
        }
    }

    async markAllAsRead() {
        if (!confirm('Mark all messages as read?')) return;

        try {
            const response = await fetch(`${this.baseUrl}/messages/mark-all-read`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showNotification('All messages marked as read', 'success');

                document.querySelectorAll('.message-item').forEach(item => {
                    item.classList.remove('unread');
                    item.querySelector('.status-badge')?.remove();
                    item.querySelector('.btn-success')?.remove();
                });

                await this.updateMessagesCount();
                this.loadDashboardData();
            }
        } catch (error) {
            console.error('Error marking all messages as read:', error);
            this.showNotification('Error marking messages as read', 'error');
        }
    }

    async deleteMessage(messageId) {
        if (!confirm('Are you sure you want to delete this message?')) return;

        try {
            const response = await fetch(`${this.baseUrl}/messages/${messageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showNotification('Message deleted successfully', 'success');

                const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
                if (messageElement) {
                    messageElement.style.opacity = '0';
                    setTimeout(() => messageElement.remove(), 300);
                }

                await this.updateMessagesCount();
                this.loadDashboardData();
            }
        } catch (error) {
            console.error('Error deleting message:', error);
            this.showNotification('Error deleting message', 'error');
        }
    }

    viewMessage(messageId) {
        this.showMessageModal(messageId);
    }

    async showMessageModal(messageId) {
        try {
            const response = await fetch(`${this.baseUrl}/messages/${messageId}`);
            const message = await response.json();

            const modalHtml = `
                <div class="modal-overlay">
                    <div class="modal-content" style="max-width: 600px;">
                        <div class="modal-header">
                            <h3 class="modal-title">Message from ${message.name}</h3>
                            <button class="modal-close" onclick="adminDashboard.closeModal()">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div style="margin-bottom: 1.5rem;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <strong>From:</strong><br>
                                        ${message.name}<br>
                                        <a href="mailto:${message.email}">${message.email}</a>
                                    </div>
                                    <div>
                                        <strong>Date:</strong><br>
                                        ${new Date(message.created_at).toLocaleString()}
                                    </div>
                                </div>
                                <div>
                                    <strong>Subject:</strong><br>
                                    ${message.subject}
                                </div>
                            </div>
                            <div style="background: rgba(115, 12, 14, 0.1); padding: 1rem; border-radius: var(--border-radius-sm);">
                                <strong>Message:</strong>
                                <p style="margin-top: 0.5rem; white-space: pre-wrap; line-height: 1.5;">${message.message}</p>
                            </div>
                            ${message.ip_address ? `
                                <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--gray-dark);">
                                    <strong>Technical Info:</strong><br>
                                    IP: ${message.ip_address}<br>
                                    User Agent: ${message.user_agent || 'N/A'}
                                </div>
                            ` : ''}
                            <div class="modal-actions">
                                <button type="button" class="btn btn-secondary" onclick="adminDashboard.closeModal()">Close</button>
                                ${!message.is_read ? `
                                    <button type="button" class="btn btn-success" onclick="adminDashboard.markAsRead(${message.id}); adminDashboard.closeModal();">
                                        Mark as Read
                                    </button>
                                ` : ''}
                                <button type="button" class="btn btn-danger" onclick="adminDashboard.deleteMessage(${message.id}); adminDashboard.closeModal();">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const modal = document.createElement('div');
            modal.innerHTML = modalHtml;
            document.body.appendChild(modal);
        } catch (error) {
            console.error('Error loading message:', error);
            this.showNotification('Error loading message', 'error');
        }
    }

    // =====================
    // FORM HANDLING
    // =====================

    async handleFormSubmit(form) {
        console.log('=== FORM SUBMISSION START ===');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);

        // Prevent multiple submissions
        if (form.classList.contains('submitting')) {
            return;
        }

        const formData = new FormData(form);
        const method = form.querySelector('input[name="_method"]')?.value || 'POST';

        console.log('Final method with spoofing:', method);

        // Show all form data for debugging
        for (let [key, value] of formData.entries()) {
            console.log(`Form data - ${key}:`, value);
        }

        const button = form.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;

        // Show loading state and disable form
        form.classList.add('submitting');
        button.classList.add('loading');
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        // Clear previous errors
        this.clearFormErrors(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST', // Always use POST for FormData with Laravel spoofing
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            console.log('Response status:', response.status);

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const result = await response.json();
                console.log('Response data:', result);

                if (result.success) {
                    this.showNotification(result.message, 'success');
                    this.closeModal();
                    await this.loadSectionContent(this.currentSection);
                    this.loadDashboardData();
                } else {
                    // Show validation errors if they exist
                    if (result.errors) {
                        this.showFormErrors(form, result.errors);
                        this.showNotification('Please fix the validation errors below', 'error');
                    } else {
                        this.showNotification(result.message || 'Operation failed', 'error');
                    }
                }
            } else {
                // Handle non-JSON response (like HTML error pages)
                const text = await response.text();
                console.error('Non-JSON response:', text.substring(0, 500));
                this.showNotification('Server returned an error. Check console for details.', 'error');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.showNotification('Network error occurred: ' + error.message, 'error');
        } finally {
            // Re-enable form
            form.classList.remove('submitting');
            button.classList.remove('loading');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    }

    // Add these helper methods for form error handling
    clearFormErrors(form) {
        // Remove existing error messages
        form.querySelectorAll('.error-message').forEach(error => error.remove());

        // Remove error classes from inputs
        form.querySelectorAll('.error').forEach(input => input.classList.remove('error'));
    }

    showFormErrors(form, errors) {
        // Clear previous errors first
        this.clearFormErrors(form);

        // Add error messages for each field
        Object.keys(errors).forEach(fieldName => {
            const input = form.querySelector(`[name="${fieldName}"]`);
            if (input) {
                // Add error class to input
                input.classList.add('error');

                // Create error message element
                const errorElement = document.createElement('div');
                errorElement.className = 'error-message';
                errorElement.style.cssText = `
                color: var(--danger);
                font-size: 0.8rem;
                margin-top: 0.25rem;
                padding: 0.25rem 0.5rem;
                background: rgba(220, 53, 69, 0.1);
                border-radius: 4px;
                border-left: 3px solid var(--danger);
            `;
                errorElement.textContent = errors[fieldName][0];

                // Insert error message after the input
                input.parentNode.appendChild(errorElement);
            }
        });
    }

    // =====================
    // UTILITY METHODS
    // =====================

    async switchSection(section) {
        this.currentSection = section;

        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        document.querySelector(`[data-section="${section}"]`).classList.add('active');

        document.getElementById('pageTitle').textContent =
            section.charAt(0).toUpperCase() + section.slice(1);

        document.querySelectorAll('.section-content').forEach(section => {
            section.classList.remove('active');
        });

        await this.loadSectionContent(section);
    }

    async loadSectionContent(section) {
        const container = document.getElementById('dynamic-sections');
        container.innerHTML = '<div class="text-center">Loading...</div>';

        try {
            let html = '';

            switch (section) {
                case 'dashboard':
                    document.getElementById('dashboard').classList.add('active');
                    return;
                case 'skills':
                    html = await this.getSkillsContent();
                    break;
                case 'projects':
                    html = await this.getProjectsContent();
                    break;
                case 'messages':
                    html = await this.getMessagesContent();
                    break;
                case 'profile':
                    html = document.getElementById('profile-template').innerHTML;
                    break;
                case 'analytics':
                    html = await this.getAnalyticsContent();
                    break;
                case 'settings':
                    html = await this.getSettingsContent();
                    break;
                case 'sections':
                    html = await this.getSectionsContent();
                    break;
                default:
                    html = '<div class="text-center">Section not found</div>';
            }

            container.innerHTML = html;
            const sectionElement = container.querySelector('.section-content');
            if (sectionElement) {
                sectionElement.classList.add('active');
            }

            this.bindSectionEvents();

        } catch (error) {
            console.error('Error loading section:', error);
            this.showNotification('Error loading content', 'error');
            container.innerHTML = '<div class="text-center">Error loading content</div>';
        }
    }

    bindSectionEvents() {
        // Remove existing event listeners first to prevent duplicates
        this.removeEventListeners();

        // Bind form submissions - use event delegation
        this.formSubmitHandler = (e) => {
            const form = e.target;
            if (form.classList.contains('ajax-form')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                this.handleFormSubmit(form);
            }
        };
        document.addEventListener('submit', this.formSubmitHandler);

        // Bind button clicks using simpler event delegation
        this.buttonClickHandler = (e) => {
            const button = e.target.closest('button');
            if (!button) return;

            // Check for specific data attributes or onclick handlers
            if (button.hasAttribute('onclick')) {
                const onclick = button.getAttribute('onclick');

                if (onclick.includes('showSkillForm')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.showSkillForm();
                }
                else if (onclick.includes('showProjectForm')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.showProjectForm();
                }
                else if (onclick.includes('editSkill')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    const match = onclick.match(/editSkill\((\d+)\)/);
                    if (match) this.editSkill(parseInt(match[1]));
                }
                else if (onclick.includes('deleteSkill')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    const match = onclick.match(/deleteSkill\((\d+)\)/);
                    if (match) this.deleteSkill(parseInt(match[1]));
                }
                else if (onclick.includes('editProject')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    const match = onclick.match(/editProject\((\d+)\)/);
                    if (match) this.editProject(parseInt(match[1]));
                }
                else if (onclick.includes('deleteProject')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    const match = onclick.match(/deleteProject\((\d+)\)/);
                    if (match) this.deleteProject(parseInt(match[1]));
                }
                else if (onclick.includes('showSectionForm')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.showSectionForm();
                }
                else if (onclick.includes('editSection')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    const match = onclick.match(/editSection\((\d+)\)/);
                    if (match) this.editSection(parseInt(match[1]));
                }
                else if (onclick.includes('deleteSection')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    const match = onclick.match(/deleteSection\((\d+)\)/);
                    if (match) this.deleteSection(parseInt(match[1]));
                }
            }
        };

        document.addEventListener('click', this.buttonClickHandler, true);
    }

    removeEventListeners() {
        if (this.formSubmitHandler) {
            document.removeEventListener('submit', this.formSubmitHandler);
        }
        if (this.buttonClickHandler) {
            document.removeEventListener('click', this.buttonClickHandler);
        }
    }

    initializeModalEvents(modal) {
        const closeBtn = modal.querySelector('.modal-close');
        const overlay = modal.querySelector('.modal-overlay');

        if (closeBtn) {
            closeBtn.onclick = () => this.closeModal();
        }

        if (overlay) {
            overlay.onclick = (e) => {
                if (e.target === overlay) {
                    this.closeModal();
                }
            };
        }
    }

    setFormValue(form, selector, value) {
        const element = form.querySelector(selector);
        if (element) {
            element.value = value || '';
        } else {
            console.warn('Form element not found:', selector);
        }
    }

    async updateSkillsCount() {
        try {
            const response = await fetch(`${this.baseUrl}/skills`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const skills = await response.json();

            const skillsCountElement = document.getElementById('skills-count');
            if (skillsCountElement) {
                skillsCountElement.textContent = skills.length;
            }

            const statsElement = document.querySelector('[data-stat="skills"] .stat-value');
            if (statsElement) {
                statsElement.textContent = skills.length;
            }

            return skills.length;
        } catch (error) {
            console.error('Error updating skills count:', error);
            return 0;
        }
    }

    async updateProjectsCount() {
        try {
            const response = await fetch(`${this.baseUrl}/projects`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const projects = await response.json();

            const projectsCountElement = document.getElementById('projects-count');
            if (projectsCountElement) {
                projectsCountElement.textContent = projects.length;
            }

            const statsElement = document.querySelector('[data-stat="projects"] .stat-value');
            if (statsElement) {
                statsElement.textContent = projects.length;
            }

            return projects.length;
        } catch (error) {
            console.error('Error updating projects count:', error);
            return 0;
        }
    }

    async updateMessagesCount() {
        try {
            const response = await fetch(`${this.baseUrl}/messages-stats`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const stats = await response.json();

            if (stats && typeof stats.unread !== 'undefined') {
                const messagesCountElement = document.getElementById('messages-count');
                if (messagesCountElement) {
                    messagesCountElement.textContent = stats.unread;
                }

                const statsElement = document.querySelector('[data-stat="messages"] .stat-value');
                if (statsElement) {
                    statsElement.textContent = stats.unread;
                }

                return stats.unread;
            }
            return 0;
        } catch (error) {
            console.error('Error updating messages count:', error);
            return 0;
        }
    }

    async loadDashboardData() {
        try {
            const response = await fetch(`${this.baseUrl}/dashboard-data`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            this.updateStats(data.stats);

            await this.updateSkillsCount();
            await this.updateProjectsCount();
            await this.updateMessagesCount();
        } catch (error) {
            console.error('Error loading dashboard data:', error);
            this.updateStats({
                total_projects: 0,
                active_skills: 0,
                unread_messages: 0
            });
        }
    }

    updateStats(stats) {
        if (stats) {
            const projectElement = document.querySelector('[data-stat="projects"] .stat-value');
            const skillsElement = document.querySelector('[data-stat="skills"] .stat-value');
            const messagesElement = document.querySelector('[data-stat="messages"] .stat-value');

            if (projectElement) projectElement.textContent = stats.total_projects || 0;
            if (skillsElement) skillsElement.textContent = stats.active_skills || 0;
            if (messagesElement) messagesElement.textContent = stats.unread_messages || 0;
        }
    }

    refreshDashboard() {
        this.loadDashboardData();
        this.showNotification('Dashboard refreshed', 'success');
    }

    confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            this.performLogout();
        }
    }

    performLogout() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/logout';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;

        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }

    showNotification(message, type = 'info') {
        this.notificationSystem.showNotification(message, type);
    }

    closeModal() {
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => {
            modal.remove();
        });
    }

    // Other sections (simplified)
    async getAnalyticsContent() {
        return `
            <section class="section-content">
                <div class="section-card">
                    <div class="card-header">
                        <h3 class="card-title">Analytics</h3>
                    </div>
                    <div class="card-body">
                        <p>Analytics dashboard will be implemented soon.</p>
                    </div>
                </div>
            </section>
        `;
    }

    async getSettingsContent() {
        return `
            <section class="section-content">
                <div class="section-card">
                    <div class="card-header">
                        <h3 class="card-title">Settings</h3>
                    </div>
                    <div class="card-body">
                        <p>Settings management will be implemented soon.</p>
                    </div>
                </div>
            </section>
        `;
    }
}

// Initialize the dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.adminDashboard = new AdminDashboard();
    console.log('Admin Dashboard initialized successfully');
});
