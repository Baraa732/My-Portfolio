class LoginAnimations {
    constructor() {
        this.init();
    }

    init() {
        this.setupPasswordToggle();
        this.setupFormValidation();
        this.setupLoadingStates();
        this.setupParticleAnimation();
        this.setupInputAnimations();
        this.setupFormSubmission();
    }

    setupPasswordToggle() {
        const passwordToggle = document.querySelector('.password-toggle');
        const passwordInput = document.querySelector('input[name="password"]');

        if (passwordToggle && passwordInput) {
            passwordToggle.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                const icon = passwordToggle.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');

                // Add animation
                passwordToggle.style.transform = 'translateY(-50%) scale(1.2)';
                setTimeout(() => {
                    passwordToggle.style.transform = 'translateY(-50%) scale(1)';
                }, 150);
            });
        }
    }

    setupFormValidation() {
        const inputs = document.querySelectorAll('.form-input');

        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateInput(input);
            });

            input.addEventListener('input', () => {
                this.clearErrors(input);
            });
        });
    }

    validateInput(input) {
        const wrapper = input.closest('.input-wrapper');
        const formGroup = input.closest('.form-group');

        if (input.value.trim() === '') {
            this.showInputError(formGroup, 'This field is required');
            wrapper.classList.add('error');
        } else if (input.type === 'email' && !this.isValidEmail(input.value)) {
            this.showInputError(formGroup, 'Please enter a valid email address');
            wrapper.classList.add('error');
        } else {
            this.clearErrors(input);
            wrapper.classList.remove('error');
        }
    }

    showInputError(formGroup, message) {
        let errorDiv = formGroup.querySelector('.error-message');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            formGroup.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
        errorDiv.style.animation = 'errorSlide 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    }

    clearErrors(input) {
        const formGroup = input.closest('.form-group');
        const errorDiv = formGroup.querySelector('.error-message');
        const wrapper = input.closest('.input-wrapper');

        if (errorDiv) {
            errorDiv.remove();
        }
        wrapper.classList.remove('error');
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    setupLoadingStates() {
        // This method is now handled in setupFormSubmission
        // Keeping for compatibility
    }

    showLoading(button) {
        button.classList.add('loading');
        button.disabled = true;

        // Add pulse animation to the button
        button.style.animation = 'pulse 1.5s ease-in-out infinite';
    }

    resetLoading(button) {
        button.classList.remove('loading');
        button.disabled = false;
        button.style.animation = '';
    }

    setupParticleAnimation() {
        const particles = document.querySelectorAll('.particle');

        particles.forEach((particle, index) => {
            // Add random movement
            setInterval(() => {
                const randomX = Math.random() * 20 - 10;
                const randomY = Math.random() * 20 - 10;
                particle.style.transform = `translate(${randomX}px, ${randomY}px)`;
            }, 3000 + index * 500);
        });
    }

    setupInputAnimations() {
        const inputs = document.querySelectorAll('.form-input');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                const wrapper = input.closest('.input-wrapper');
                const icon = wrapper.querySelector('.input-icon');

                // Animate icon
                if (icon) {
                    icon.style.transform = 'translateY(-50%) scale(1.1)';
                    icon.style.color = 'var(--accent)';
                }

                // Add glow effect
                wrapper.style.boxShadow = '0 0 20px rgba(76, 111, 255, 0.2)';
            });

            input.addEventListener('blur', () => {
                const wrapper = input.closest('.input-wrapper');
                const icon = wrapper.querySelector('.input-icon');

                // Reset icon
                if (icon && !wrapper.classList.contains('error')) {
                    icon.style.transform = 'translateY(-50%) scale(1)';
                    icon.style.color = 'var(--gray-dark)';
                }

                // Remove glow effect
                wrapper.style.boxShadow = 'none';
            });
        });
    }

    setupFormSubmission() {
        const form = document.querySelector('.login-form');

        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const honeypot = form.querySelector('input[name="website"]');

                // Check honeypot
                if (honeypot && honeypot.value !== '') {
                    this.showError('Security check failed. Please try again.');
                    return false;
                }

                // Validate all inputs
                const inputs = form.querySelectorAll('.form-input');
                let isValid = true;

                inputs.forEach(input => {
                    this.validateInput(input);
                    if (input.closest('.input-wrapper').classList.contains('error')) {
                        isValid = false;
                    }
                });

                // Get submit button first
                const submitBtn = form.querySelector('.login-btn');
                
                if (!isValid) {
                    this.shakeForm();
                    // Ensure button is visible and enabled
                    this.resetLoading(submitBtn);
                    return false;
                }

                // Show loading state only if validation passes
                this.showLoading(submitBtn);

                try {
                    // Always refresh CSRF token before submission
                    await this.refreshCSRFToken();

                    // Submit form using fetch to handle errors properly
                    const formData = new FormData(form);

                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        if (data.success && data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.href = '/admin';
                        }
                    } else if (response.status === 419) {
                        // CSRF token expired, refresh and try again
                        await this.refreshCSRFToken();
                        this.showError('Session expired. Please try again.');
                        this.resetLoading(submitBtn);
                    } else {
                        // Other errors
                        const errorData = await response.json().catch(() => ({ message: 'Login failed. Please check your credentials.' }));
                        this.showError(errorData.message || 'Login failed. Please check your credentials.');
                        this.resetLoading(submitBtn);
                        this.shakeForm();
                    }
                } catch (error) {
                    console.error('Login error:', error);
                    this.showError('Connection error. Please try again.');
                    this.resetLoading(submitBtn);
                    this.shakeForm();
                }
            });
        }
    }

    async refreshCSRFToken() {
        try {
            const response = await fetch('/admin/csrf-token', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            // Update CSRF token in meta tag
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                metaTag.setAttribute('content', data.token);
            }

            // Update CSRF token in form
            const csrfInput = document.querySelector('input[name="_token"]');
            if (csrfInput) {
                csrfInput.value = data.token;
            }

            console.log('CSRF token refreshed successfully');
        } catch (error) {
            console.error('Failed to refresh CSRF token:', error);
            throw error;
        }
    }

    shakeForm() {
        const loginCard = document.querySelector('.login-card');
        loginCard.style.animation = 'shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97)';

        setTimeout(() => {
            loginCard.style.animation = '';
        }, 500);
    }

    showError(message) {
        const form = document.querySelector('.login-form');

        // Remove existing error
        const existingAlert = form.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-error';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle"></i>
            <span>${message}</span>
        `;

        // Insert before submit button
        const submitBtn = form.querySelector('.login-btn');
        form.insertBefore(alertDiv, submitBtn);

        alertDiv.style.animation = 'alertSlide 0.4s cubic-bezier(0.4, 0, 0.2, 1)';

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
}

// Advanced particle system
class ParticleSystem {
    constructor() {
        this.canvas = null;
        this.ctx = null;
        this.particles = [];
        this.init();
    }

    init() {
        this.createCanvas();
        this.createParticles();
        this.animate();
    }

    createCanvas() {
        this.canvas = document.createElement('canvas');
        this.canvas.style.position = 'fixed';
        this.canvas.style.top = '0';
        this.canvas.style.left = '0';
        this.canvas.style.width = '100%';
        this.canvas.style.height = '100%';
        this.canvas.style.pointerEvents = 'none';
        this.canvas.style.zIndex = '-1';
        this.canvas.style.opacity = '0.6';

        document.body.appendChild(this.canvas);

        this.ctx = this.canvas.getContext('2d');
        this.resize();

        window.addEventListener('resize', () => this.resize());
    }

    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    createParticles() {
        const particleCount = 50;

        for (let i = 0; i < particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * 0.5,
                vy: (Math.random() - 0.5) * 0.5,
                size: Math.random() * 2 + 1,
                opacity: Math.random() * 0.5 + 0.2,
                color: `rgba(76, 111, 255, ${Math.random() * 0.5 + 0.2})`
            });
        }
    }

    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.particles.forEach(particle => {
            // Update position
            particle.x += particle.vx;
            particle.y += particle.vy;

            // Wrap around edges
            if (particle.x < 0) particle.x = this.canvas.width;
            if (particle.x > this.canvas.width) particle.x = 0;
            if (particle.y < 0) particle.y = this.canvas.height;
            if (particle.y > this.canvas.height) particle.y = 0;

            // Draw particle
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            this.ctx.fillStyle = particle.color;
            this.ctx.fill();
        });

        requestAnimationFrame(() => this.animate());
    }
}

// Add shake animation to CSS
const shakeCSS = `
@keyframes shake {
    10%, 90% { transform: translate3d(-1px, 0, 0); }
    20%, 80% { transform: translate3d(2px, 0, 0); }
    30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
    40%, 60% { transform: translate3d(4px, 0, 0); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes alertSlide {
    0% { opacity: 0; transform: translateY(-10px); }
    100% { opacity: 1; transform: translateY(0); }
}

.input-wrapper.error .form-input {
    border-color: var(--danger) !important;
    box-shadow: 0 0 20px rgba(245, 101, 101, 0.3) !important;
}

.input-wrapper.error .input-icon {
    color: var(--danger) !important;
}

.alert {
    margin: 1rem 0;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.alert-error {
    background: rgba(245, 101, 101, 0.1);
    border: 1px solid rgba(245, 101, 101, 0.3);
    color: #f56565;
}
`;

// Inject CSS
const style = document.createElement('style');
style.textContent = shakeCSS;
document.head.appendChild(style);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const loginAnimations = new LoginAnimations();
    new ParticleSystem();

    // Force clear all form data
    const form = document.querySelector('.login-form');
    if (form) {
        form.reset();

        // Clear all inputs manually
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            if (input.name !== '_token') { // Don't clear CSRF token
                input.value = '';
                input.defaultValue = '';
            }
        });
    }

    // Refresh CSRF token immediately and then every 5 minutes
    loginAnimations.refreshCSRFToken().catch(console.error);
    setInterval(() => {
        loginAnimations.refreshCSRFToken().catch(console.error);
    }, 300000);

    // Add entrance animation delay
    setTimeout(() => {
        document.body.style.overflow = 'hidden';
    }, 100);
});

// Clear form on page load and unload
window.addEventListener('load', () => {
    const form = document.querySelector('.login-form');
    if (form) {
        form.reset();
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = '';
            input.defaultValue = '';
        });
    }
});

window.addEventListener('beforeunload', () => {
    const form = document.querySelector('.login-form');
    if (form) {
        form.reset();
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = '';
        });
    }
});
