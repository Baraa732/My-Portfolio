@extends('layouts.app')

@section('content')
   <section class="contact-section">
      <div class="container">
         <div class="section-title">
            <h2>Get In Touch</h2>
            <p class="section-subtitle">Let's discuss your project and bring your ideas to life</p>
         </div>

         <!-- Notification Container -->
         <div id="notification-container" style="position: fixed; top: 100px; right: 20px; z-index: 10000;"></div>

         <div class="contact-content">
            <div class="contact-info animate-on-scroll" data-animation="fadeInLeft">
               <!-- Your existing contact info content -->
               <h3>Let's talk about everything!</h3>
               <p class="contact-description">Feel free to reach out to me for any questions, collaborations, or just to
                  say hello. I'll get back to you as soon as possible.</p>

               <div class="contact-methods">
                  <div class="contact-item">
                     <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                     </div>
                     <div class="contact-details">
                        <h4>Email</h4>
                        <p>baraaalrifaee732@gmail.com</p>
                     </div>
                  </div>

                  <div class="contact-item">
                     <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                     </div>
                     <div class="contact-details">
                        <h4>Phone</h4>
                        <p>+963 994 134 966</p>
                     </div>
                  </div>

                  <div class="contact-item">
                     <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                     </div>
                     <div class="contact-details">
                        <h4>Location</h4>
                        <p>Damascus, Syria</p>
                     </div>
                  </div>

                  <div class="contact-item">
                     <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                     </div>
                     <div class="contact-details">
                        <h4>Availability</h4>
                        <p>sunday - saturday</p>
                     </div>
                  </div>
               </div>
            </div>

            <div class="contact-form-container animate-on-scroll" data-animation="fadeInRight">
               <div class="contact-form-card">
                  <h3>Send Message</h3>
                  <form id="contact-form" method="POST" class="contact-form">
                     @csrf
                     <div class="form-row">
                        <div class="form-group">
                           <label for="name" class="form-label">Full Name *</label>
                           <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                           <label for="email" class="form-label">Subject *</label>
                           <input type="email" id="email" name="subject" class="form-control" required>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="subject" class="form-label">Email Address *</label>
                        <input type="text" id="subject" name="email" class="form-control" required>
                     </div>

                     <div class="form-group">
                        <label for="message" class="form-label">Message *</label>
                        <textarea id="message" name="message" class="form-control" rows="6" required
                           placeholder="Tell me about your project..."></textarea>
                     </div>

                     <button type="submit" class="btn btn-primary btn-full" id="submit-btn">
                        <i class="fas fa-paper-plane me-2"></i>
                        <span id="submit-text">Send Message</span>
                        <div id="submit-loading" style="display: none;">
                           <i class="fas fa-spinner fa-spin"></i> Sending...
                        </div>
                     </button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>

   <style>
      /* Enhanced Notification Styles */
      .notification {
         padding: 1.25rem 1.5rem;
         border-radius: var(--border-radius);
         color: var(--light);
         margin-bottom: 1rem;
         backdrop-filter: blur(20px);
         border: 1px solid;
         transform: translateX(400px);
         transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
         max-width: 420px;
         box-shadow: var(--shadow-lg);
         position: relative;
         overflow: hidden;
      }

      .notification::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         width: 4px;
         height: 100%;
         background: currentColor;
         opacity: 0.6;
      }

      .notification.show {
         transform: translateX(0);
      }

      .notification.success {
         background: rgba(16, 185, 129, 0.15);
         border-color: var(--success);
      }

      .notification.error {
         background: rgba(239, 68, 68, 0.15);
         border-color: var(--danger);
      }

      .notification.warning {
         background: rgba(245, 158, 11, 0.15);
         border-color: var(--warning);
      }

      .notification.info {
         background: rgba(59, 130, 246, 0.15);
         border-color: var(--info);
      }

      .notification-content {
         display: flex;
         align-items: flex-start;
         gap: 1rem;
      }

      .notification-icon {
         font-size: 1.3rem;
         margin-top: 0.1rem;
         flex-shrink: 0;
         width: 24px;
         text-align: center;
      }

      .notification-message {
         flex: 1;
         line-height: 1.5;
         font-size: 0.95rem;
         padding-right: 0.5rem;
      }

      /* Enhanced Close Button */
      .notification-close {
         background: rgba(255, 255, 255, 0.1);
         border: 1px solid rgba(255, 255, 255, 0.2);
         border-radius: 50%;
         width: 28px;
         height: 28px;
         display: flex;
         align-items: center;
         justify-content: center;
         cursor: pointer;
         transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         color: var(--light);
         font-size: 0.8rem;
         flex-shrink: 0;
         margin-top: 0.1rem;
         backdrop-filter: blur(10px);
      }

      .notification-close:hover {
         background: rgba(255, 255, 255, 0.2);
         transform: scale(1.1) rotate(90deg);
         border-color: rgba(255, 255, 255, 0.4);
         box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }

      .notification-close:active {
         transform: scale(0.95) rotate(90deg);
      }

      /* Progress Bar for Auto-dismiss */
      .notification-progress {
         position: absolute;
         bottom: 0;
         left: 0;
         height: 3px;
         background: currentColor;
         opacity: 0.4;
         width: 100%;
         transform-origin: left;
         animation: progress 5s linear forwards;
      }

      @keyframes progress {
         from {
            transform: scaleX(1);
         }

         to {
            transform: scaleX(0);
         }
      }

      /* Notification Container */
      #notification-container {
         position: fixed;
         top: 100px;
         right: 20px;
         z-index: 10000;
         max-width: 420px;
      }

      /* Loading States */
      .btn.loading {
         position: relative;
         color: transparent;
      }

      .btn.loading::after {
         content: '';
         position: absolute;
         width: 20px;
         height: 20px;
         top: 50%;
         left: 50%;
         margin: -10px 0 0 -10px;
         border: 2px solid transparent;
         border-top-color: var(--light);
         border-radius: 50%;
         animation: spin 1s linear infinite;
      }

      @keyframes spin {
         0% {
            transform: rotate(0deg);
         }

         100% {
            transform: rotate(360deg);
         }
      }

      /* Enhanced Contact Section */
      .contact-section {
         padding: 120px 0;
         background: var(--gradient-dark);
         min-height: 100vh;
         position: relative;
         overflow: hidden;
      }

      .contact-section::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background:
            radial-gradient(circle at 20% 80%, rgba(76, 111, 255, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(26, 54, 93, 0.05) 0%, transparent 50%);
         pointer-events: none;
         z-index: 0;
      }

      .contact-content {
         display: grid;
         grid-template-columns: 1fr 1fr;
         gap: 5rem;
         align-items: start;
         position: relative;
         z-index: 2;
      }

      .contact-info h3 {
         font-size: clamp(2.5rem, 4vw, 3.5rem);
         color: var(--light);
         margin-bottom: 1.5rem;
         font-weight: 800;
         line-height: 1.1;
         letter-spacing: -0.5px;
         animation: fadeInLeft 0.8s ease-out;
      }

      .contact-description {
         color: var(--gray);
         font-size: clamp(1rem, 1.8vw, 1.2rem);
         line-height: 1.7;
         margin-bottom: 3rem;
         animation: fadeInLeft 0.8s ease-out 0.1s both;
      }

      .contact-methods {
         margin-bottom: 3rem;
         animation: fadeInLeft 0.8s ease-out 0.2s both;
      }

      .contact-item {
         display: flex;
         align-items: center;
         gap: 1.5rem;
         margin-bottom: 1.5rem;
         padding: 1.5rem;
         background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
         border-radius: var(--border-radius);
         border: 1px solid rgba(255, 255, 255, 0.1);
         transition: var(--transition);
         backdrop-filter: blur(20px);
         position: relative;
         overflow: hidden;
      }

      .contact-item::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
         transition: var(--transition);
      }

      .contact-item:hover::before {
         left: 100%;
      }

      .contact-item:hover {
         transform: translateX(10px);
         border-color: rgba(76, 111, 255, 0.3);
         box-shadow: var(--shadow);
      }

      .contact-icon {
         width: 60px;
         height: 60px;
         background: var(--gradient);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         flex-shrink: 0;
         transition: var(--transition);
      }

      .contact-item:hover .contact-icon {
         transform: scale(1.1) rotate(5deg);
      }

      .contact-icon i {
         font-size: 1.5rem;
         color: var(--light);
      }

      .contact-details h4 {
         color: var(--light);
         margin-bottom: 0.5rem;
         font-size: 1.2rem;
         font-weight: 700;
      }

      .contact-details p {
         color: var(--gray);
         margin: 0;
         font-weight: 500;
      }

      .social-links-contact h4 {
         color: var(--light);
         margin-bottom: 1.5rem;
         font-size: 1.3rem;
         font-weight: 700;
         animation: fadeInLeft 0.8s ease-out 0.3s both;
      }

      .social-icons {
         display: flex;
         gap: 1rem;
         animation: fadeInLeft 0.8s ease-out 0.4s both;
      }

      .social-link {
         width: 55px;
         height: 55px;
         background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
         border: 1px solid rgba(255, 255, 255, 0.1);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         color: var(--light);
         font-size: 1.3rem;
         transition: var(--transition);
         text-decoration: none;
         backdrop-filter: blur(20px);
         position: relative;
         overflow: hidden;
      }

      .social-link::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.3), transparent);
         transition: var(--transition);
      }

      .social-link:hover::before {
         left: 100%;
      }

      .social-link:hover {
         background: var(--gradient);
         color: var(--light);
         transform: translateY(-5px) scale(1.1);
         box-shadow: var(--shadow);
         border-color: transparent;
      }

      .contact-form-container {
         position: sticky;
         top: 120px;
         animation: fadeInRight 0.8s ease-out;
      }

      .contact-form-card {
         background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
         border: 1px solid rgba(255, 255, 255, 0.1);
         border-radius: var(--border-radius);
         padding: 2.5rem;
         backdrop-filter: blur(20px);
         box-shadow: var(--shadow);
         transition: var(--transition);
         position: relative;
         overflow: hidden;
      }

      .contact-form-card::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
         transition: var(--transition);
      }

      .contact-form-card:hover::before {
         left: 100%;
      }

      .contact-form-card:hover {
         transform: translateY(-5px);
         box-shadow: var(--shadow-lg);
      }

      .contact-form-card h3 {
         font-size: clamp(1.8rem, 3vw, 2.2rem);
         color: var(--light);
         margin-bottom: 2rem;
         text-align: center;
         font-weight: 800;
         letter-spacing: -0.5px;
      }

      .form-row {
         display: grid;
         grid-template-columns: 1fr 1fr;
         gap: 1.5rem;
      }

      .form-group {
         margin-bottom: 1.5rem;
         animation: fadeInUp 0.6s ease-out both;
      }

      .form-group:nth-child(1) {
         animation-delay: 0.1s;
      }

      .form-group:nth-child(2) {
         animation-delay: 0.2s;
      }

      .form-group:nth-child(3) {
         animation-delay: 0.3s;
      }

      .form-group:nth-child(4) {
         animation-delay: 0.4s;
      }

      .form-label {
         display: block;
         color: var(--light);
         margin-bottom: 0.75rem;
         font-weight: 600;
         font-size: 0.95rem;
         text-transform: uppercase;
         letter-spacing: 0.5px;
      }

      .form-control {
         width: 100%;
         padding: 1rem 1.5rem;
         background: rgba(255, 255, 255, 0.05);
         border: 1px solid rgba(255, 255, 255, 0.1);
         border-radius: var(--border-radius);
         color: var(--light);
         font-size: 1rem;
         transition: var(--transition);
         backdrop-filter: blur(10px);
         font-family: inherit;
      }

      .form-control:focus {
         outline: none;
         border-color: var(--accent);
         box-shadow: 0 0 0 3px rgba(76, 111, 255, 0.1);
         background: rgba(255, 255, 255, 0.08);
         transform: translateY(-2px);
      }

      .form-control::placeholder {
         color: var(--gray-dark);
         font-weight: 500;
      }

      textarea.form-control {
         resize: vertical;
         min-height: 140px;
         line-height: 1.6;
      }

      .btn-full {
         width: 100%;
         padding: 1.2rem 2rem;
         font-size: 1.1rem;
         font-weight: 700;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         animation: fadeInUp 0.6s ease-out 0.5s both;
      }

      /* Enhanced Animations */
      @keyframes fadeInLeft {
         from {
            opacity: 0;
            transform: translateX(-30px);
         }

         to {
            opacity: 1;
            transform: translateX(0);
         }
      }

      @keyframes fadeInRight {
         from {
            opacity: 0;
            transform: translateX(30px);
         }

         to {
            opacity: 1;
            transform: translateX(0);
         }
      }

      @keyframes fadeInUp {
         from {
            opacity: 0;
            transform: translateY(20px);
         }

         to {
            opacity: 1;
            transform: translateY(0);
         }
      }

      /* Enhanced Responsive Design */
      @media (max-width: 1200px) {
         .contact-content {
            gap: 4rem;
         }
      }

      @media (max-width: 992px) {
         .contact-content {
            grid-template-columns: 1fr;
            gap: 4rem;
         }

         .contact-form-container {
            position: static;
         }

         .contact-info {
            text-align: center;
         }

         .contact-item {
            justify-content: center;
            text-align: left;
         }

         .social-icons {
            justify-content: center;
         }
      }

      @media (max-width: 768px) {
         .contact-section {
            padding: 80px 0;
         }

         .contact-content {
            gap: 3rem;
         }

         .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
         }

         .contact-form-card {
            padding: 2rem;
         }

         .contact-item {
            padding: 1.25rem;
            gap: 1rem;
         }

         .contact-icon {
            width: 50px;
            height: 50px;
         }

         .contact-icon i {
            font-size: 1.3rem;
         }

         .social-link {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
         }

         .notification {
            right: 10px;
            left: 10px;
            max-width: none;
         }
      }

      @media (max-width: 576px) {
         .contact-section {
            padding: 60px 0;
         }

         .contact-content {
            gap: 2.5rem;
         }

         .contact-form-card {
            padding: 1.5rem;
         }

         .contact-item {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
            padding: 1.5rem;
         }

         .contact-details {
            text-align: center;
         }

         .social-icons {
            flex-wrap: wrap;
            justify-content: center;
         }

         .btn-full {
            padding: 1rem 1.5rem;
            font-size: 1rem;
         }
      }

      @media (max-width: 480px) {
         .contact-item {
            padding: 1.25rem;
         }

         .contact-icon {
            width: 45px;
            height: 45px;
         }

         .contact-icon i {
            font-size: 1.1rem;
         }

         .social-link {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
         }

         .form-control {
            padding: 0.875rem 1.25rem;
         }
      }

      /* Accessibility & Performance */
      @media (prefers-reduced-motion: reduce) {

         .notification,
         .contact-item,
         .social-link,
         .contact-form-card,
         .form-control,
         .btn {
            transition: none;
            animation: none;
         }

         .contact-item:hover,
         .social-link:hover,
         .contact-form-card:hover {
            transform: none;
         }
      }

      @media (hover: none) {

         .contact-item:hover,
         .social-link:hover,
         .contact-form-card:hover,
         .form-control:focus {
            transform: none;
         }

         .contact-item::before,
         .social-link::before,
         .contact-form-card::before {
            display: none;
         }
      }

      /* Touch device optimizations */
      @media (pointer: coarse) {

         .form-control,
         .btn {
            min-height: 50px;
         }

         .social-link,
         .contact-icon {
            min-width: 50px;
            min-height: 50px;
         }
      }
   </style>

   <script>
      class ContactForm {
         constructor() {
            this.form = document.getElementById('contact-form');
            this.submitBtn = document.getElementById('submit-btn');
            this.submitText = document.getElementById('submit-text');
            this.submitLoading = document.getElementById('submit-loading');
            this.activeNotifications = new Set();
            this.init();
         }

         init() {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));

            // Add input validation
            this.addInputValidation();
         }

         addInputValidation() {
            const inputs = this.form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
               input.addEventListener('blur', () => this.validateField(input));
               input.addEventListener('input', () => this.clearFieldError(input));
            });
         }

         validateField(field) {
            const value = field.value.trim();
            if (!value && field.hasAttribute('required')) {
               this.showFieldError(field, 'This field is required');
               return false;
            }

            if (field.type === 'email' && value) {
               const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
               if (!emailRegex.test(value)) {
                  this.showFieldError(field, 'Please enter a valid email address');
                  return false;
               }
            }

            this.clearFieldError(field);
            return true;
         }

         showFieldError(field, message) {
            field.style.borderColor = 'var(--danger)';
            field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';

            // Remove existing error message
            const existingError = field.parentNode.querySelector('.field-error');
            if (existingError) existingError.remove();

            // Add error message
            const errorElement = document.createElement('div');
            errorElement.className = 'field-error';
            errorElement.style.cssText = `
                  color: var(--danger);
                  font-size: 0.8rem;
                  margin-top: 0.25rem;
                  display: flex;
                  align-items: center;
                  gap: 0.25rem;
              `;
            errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
            field.parentNode.appendChild(errorElement);
         }

         clearFieldError(field) {
            field.style.borderColor = '';
            field.style.boxShadow = '';
            const errorElement = field.parentNode.querySelector('.field-error');
            if (errorElement) errorElement.remove();
         }

         async handleSubmit(e) {
            e.preventDefault();

            // Validate all fields
            const inputs = this.form.querySelectorAll('input[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
               if (!this.validateField(input)) {
                  isValid = false;
               }
            });

            if (!isValid) {
               this.showNotification('Please fill in all required fields correctly', 'error');
               return;
            }

            // Show loading state
            this.setLoadingState(true);

            try {
               const formData = new FormData(this.form);

               const response = await fetch('{{ route("contact.submit") }}', {
                  method: 'POST',
                  headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                     'X-Requested-With': 'XMLHttpRequest',
                     'Accept': 'application/json'
                  },
                  body: formData
               });

               const result = await response.json();

               if (response.ok && result.success) {
                  this.showNotification(result.message || 'Message sent successfully! I\'ll get back to you soon.', 'success');
                  this.form.reset();
               } else {
                  const errorMessage = result.message ||
                     result.errors ? Object.values(result.errors).flat().join(', ') :
                     'Failed to send message. Please try again.';
                  this.showNotification(errorMessage, 'error');
               }
            } catch (error) {
               console.error('Contact form error:', error);
               this.showNotification('Network error. Please check your connection and try again.', 'error');
            } finally {
               this.setLoadingState(false);
            }
         }

         setLoadingState(loading) {
            if (loading) {
               this.submitBtn.disabled = true;
               this.submitText.style.display = 'none';
               this.submitLoading.style.display = 'block';
               this.submitBtn.classList.add('loading');
            } else {
               this.submitBtn.disabled = false;
               this.submitText.style.display = 'block';
               this.submitLoading.style.display = 'none';
               this.submitBtn.classList.remove('loading');
            }
         }

         showNotification(message, type = 'info', duration = 5000) {
            const container = document.getElementById('notification-container');
            const notificationId = `${message}-${type}-${Date.now()}`;

            // Check for duplicate notifications
            if (this.activeNotifications.has(notificationId)) {
               return;
            }

            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                  <div class="notification-content">
                      <i class="notification-icon fas fa-${this.getNotificationIcon(type)}"></i>
                      <div class="notification-message">${message}</div>
                      <button class="notification-close" title="Dismiss notification">
                          <i class="fas fa-times"></i>
                      </button>
                  </div>
                  <div class="notification-progress"></div>
              `;

            const closeBtn = notification.querySelector('.notification-close');
            closeBtn.addEventListener('click', () => {
               this.removeNotification(notification, notificationId);
            });

            container.appendChild(notification);
            this.activeNotifications.add(notificationId);

            // Show notification with animation
            setTimeout(() => notification.classList.add('show'), 100);

            // Auto-remove after duration
            let autoRemoveTimeout;
            if (duration > 0) {
               autoRemoveTimeout = setTimeout(() => {
                  this.removeNotification(notification, notificationId);
               }, duration);
            }

            // Pause progress on hover
            notification.addEventListener('mouseenter', () => {
               const progress = notification.querySelector('.notification-progress');
               if (progress) {
                  progress.style.animationPlayState = 'paused';
               }
               if (autoRemoveTimeout) {
                  clearTimeout(autoRemoveTimeout);
               }
            });

            notification.addEventListener('mouseleave', () => {
               const progress = notification.querySelector('.notification-progress');
               if (progress && duration > 0) {
                  progress.style.animationPlayState = 'running';
                  autoRemoveTimeout = setTimeout(() => {
                     this.removeNotification(notification, notificationId);
                  }, duration * 0.2);
               }
            });
         }

         removeNotification(notification, notificationId) {
            notification.classList.remove('show');
            setTimeout(() => {
               if (notification.parentNode) {
                  notification.remove();
               }
               this.activeNotifications.delete(notificationId);
            }, 400);
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

      document.addEventListener('DOMContentLoaded', () => {
         new ContactForm();
      });
   </script>
@endsection
