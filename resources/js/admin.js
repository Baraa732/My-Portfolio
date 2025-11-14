// resources/js/admin.js
class AdminDashboard {
    constructor() {
        this.currentSection = 'dashboard';
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadDashboardData();
    }

    bindEvents() {
        
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.switchSection(link.dataset.section);
            });
        });

        this.bindFormSubmissions();
    }

    async switchSection(section) {
        this.currentSection = section;
        
        // Update active nav link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        document.querySelector(`[data-section="${section}"]`).classList.add('active');

        // Update page title
        document.getElementById('pageTitle').textContent = 
            section.charAt(0).toUpperCase() + section.slice(1);

        // Load section content
        await this.loadSectionContent(section);
    }

    async loadSectionContent(section) {
        const contentArea = document.getElementById('section-content');
        
        contentArea.innerHTML = this.getLoadingTemplate();

        try {
            let html = '';
            
            switch(section) {
                case 'dashboard':
                    html = await this.getDashboardTemplate();
                    break;
                case 'sections':
                    html = await this.getSectionsTemplate();
                    break;
                case 'skills':
                    html = await this.getSkillsTemplate();
                    break;
                case 'projects':
                    html = await this.getProjectsTemplate();
                    break;
                case 'messages':
                    html = await this.getMessagesTemplate();
                    break;
                case 'profile':
                    html = await this.getProfileTemplate();
                    break;
                case 'analytics':
                    html = await this.getAnalyticsTemplate();
                    break;
                case 'settings':
                    html = await this.getSettingsTemplate();
                    break;
                default:
                    html = '<div class="section-card"><div class="card-body"><p>Section not found</p></div></div>';
            }

            contentArea.innerHTML = html;
            this.bindSectionEvents(section);
            
        } catch (error) {
            console.error('Error loading section:', error);
            contentArea.innerHTML = '<div class="section-card"><div class="card-body"><p>Error loading content</p></div></div>';
        }
    }

    async loadDashboardData() {
        try {
            const response = await fetch('/admin/dashboard-data');
            const data = await response.json();
            
            this.updateStats(data.stats);
            this.updateRecentActivities(data.recent_activities);
            this.updateLatestMessages(data.latest_messages);
            
        } catch (error) {
            console.error('Error loading dashboard data:', error);
        }
    }

    updateStats(stats) {
        document.querySelector('[data-stat="projects"] .stat-value').textContent = stats.total_projects;
        document.querySelector('[data-stat="skills"] .stat-value').textContent = stats.active_skills;
        document.querySelector('[data-stat="messages"] .stat-value').textContent = stats.unread_messages;
        document.querySelector('[data-stat="views"] .stat-value').textContent = stats.total_views;
    }

    updateRecentActivities(activities) {
        const tbody = document.querySelector('#recent-activities tbody');
        tbody.innerHTML = activities.map(activity => `
            <tr>
                <td>${activity.action}</td>
                <td>${activity.item}</td>
                <td>${activity.date}</td>
                <td><span class="status-badge status-active">${activity.status}</span></td>
            </tr>
        `).join('');
    }

    getLoadingTemplate() {
        return `
            <section class="section-content active">
                <div class="section-card">
                    <div class="card-body">
                        <div class="skeleton" style="height: 200px;"></div>
                    </div>
                </div>
            </section>
        `;
    }

    async getSectionsTemplate() {
        const response = await fetch('/admin/sections');
        const sections = await response.json();

        return `
            <section class="section-content active">
                <div class="section-card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Sections</h3>
                    </div>
                    <div class="card-body">
                        <div class="sections-grid">
                            ${sections.map(section => `
                                <div class="section-item" data-section-id="${section.id}">
                                    <form class="section-form" onsubmit="adminDashboard.updateSection(event, ${section.id})">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title" value="${section.title || ''}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Content</label>
                                            <textarea name="content" class="form-control" rows="4">${section.content || ''}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="image" class="form-control">
                                            ${section.image ? `<small>Current: ${section.image}</small>` : ''}
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="is_active" ${section.is_active ? 'checked' : ''}>
                                                Active
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Section</button>
                                    </form>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </section>
        `;
    }

    bindFormSubmissions() {
        document.addEventListener('submit', async (e) => {
            if (e.target.classList.contains('ajax-form')) {
                e.preventDefault();
                await this.handleFormSubmit(e.target);
            }
        });
    }

    async handleFormSubmit(form) {
        const formData = new FormData(form);
        const url = form.action;
        const method = form.method || 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showNotification(result.message, 'success');

                // Refresh current section
                this.loadSectionContent(this.currentSection);
            } else {
                this.showNotification(result.message, 'error');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.showNotification('An error occurred', 'error');
        }
    }

    showNotification(message, type = 'info') {
        // Create and show notification
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    bindSectionEvents(section) {
        // Bind events specific to each section
        switch(section) {
            case 'skills':
                this.bindSkillsEvents();
                break;
            case 'projects':
                this.bindProjectsEvents();
                break;
            case 'messages':
                this.bindMessagesEvents();
                break;
        }
    }

    bindSkillsEvents() {
        // Make skills sortable
        if (typeof Sortable !== 'undefined') {
            new Sortable(document.getElementById('skills-list'), {
                handle: '.sort-handle',
                onEnd: async (evt) => {
                    const skills = Array.from(evt.from.children).map((item, index) => ({
                        id: item.dataset.skillId,
                        order: index
                    }));
                    
                    await this.updateSkillsOrder(skills);
                }
            });
        }
    }

    async updateSkillsOrder(skills) {
        try {
            const response = await fetch('/admin/skills/order', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ skills })
            });

            const result = await response.json();
            
            if (result.success) {
                this.showNotification('Skills order updated!', 'success');
            }
        } catch (error) {
            console.error('Error updating skills order:', error);
            this.showNotification('Error updating order', 'error');
        }
    }

}

document.addEventListener('DOMContentLoaded', () => {
    window.adminDashboard = new AdminDashboard();
});
