@extends('layouts.app')

@section('content')
   <section class="projects-section">
      <div class="container">
         <div class="section-title">
            <h2>Featured Projects</h2>
            <p class="section-subtitle">A collection of my recent work showcasing innovative solutions and technical
               expertise</p>
         </div>

         <div class="projects-grid">
            @foreach($projects as $project)
               <div class="project-card animate-on-scroll" data-animation="fadeInUp">
                  <div class="project-image">
                     <div class="project-image-placeholder">
                        <i class="fas fa-project-diagram"></i>
                     </div>
                     <div class="project-overlay">
                        <div class="project-overlay-content">
                           <div class="project-links">
                              @if($project->project_url)
                                 <a href="{{ $project->project_url }}" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                 </a>
                              @endif
                              @if($project->github_url)
                                 <a href="{{ $project->github_url }}" class="btn btn-secondary">
                                    <i class="fab fa-github"></i>
                                 </a>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="project-content">
                     <h3 class="project-title">{{ $project->title }}</h3>
                     <p class="project-description">{{ $project->description }}</p>

                     <div class="project-technologies">
                        @foreach(explode(',', $project->technologies) as $tech)
                           <span class="tech-tag">{{ trim($tech) }}</span>
                        @endforeach
                     </div>

                     <div class="project-actions">
                        @if($project->project_url)
                           <a href="{{ $project->project_url }}" class="btn btn-primary">
                              <i class="fas fa-external-link-alt me-2"></i>
                              Live Demo
                           </a>
                        @endif
                        @if($project->github_url)
                           <a href="{{ $project->github_url }}" class="btn btn-secondary">
                              <i class="fab fa-github me-2"></i>
                              Code
                           </a>
                        @endif
                     </div>
                  </div>
               </div>
            @endforeach
         </div>

         <!-- CTA Section -->
         <div class="cta-section animate-on-scroll" data-animation="fadeInUp">
            <h3 class="cta-title">Ready to Start Your Project?</h3>
            <p class="cta-description">Let's work together to bring your ideas to life with cutting-edge solutions</p>
            <a href="{{ route('contact') }}" class="btn btn-light">
               <i class="fas fa-paper-plane me-2"></i>
               Get In Touch
            </a>
         </div>
      </div>
   </section>

   <style>
      /* Projects Section */
      .projects-section {
         padding: 120px 0;
         background: var(--gradient-dark);
         position: relative;
         overflow: hidden;
      }

      .projects-section::before {
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

      /* Projects Grid */
      .projects-grid {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
         gap: 2.5rem;
         position: relative;
         z-index: 2;
      }

      /* Project Card */
      .project-card {
         background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
         border-radius: var(--border-radius);
         overflow: hidden;
         border: 1px solid rgba(255, 255, 255, 0.1);
         backdrop-filter: blur(20px);
         transition: var(--transition);
         position: relative;
         animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
      }

      .project-card::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
         transition: var(--transition);
         z-index: 1;
      }

      .project-card:hover::before {
         left: 100%;
      }

      .project-card:hover {
         transform: translateY(-10px) scale(1.02);
         box-shadow: var(--shadow-lg);
         border-color: rgba(76, 111, 255, 0.3);
      }

      /* Project Image */
      .project-image {
         height: 250px;
         position: relative;
         overflow: hidden;
         transition: var(--transition);
      }

      .project-image-placeholder {
         width: 100%;
         height: 100%;
         background: var(--gradient);
         display: flex;
         align-items: center;
         justify-content: center;
         position: relative;
      }

      .project-image-placeholder i {
         font-size: 4rem;
         color: var(--light);
         transition: var(--transition);
      }

      .project-card:hover .project-image-placeholder i {
         transform: scale(1.1) rotate(5deg);
      }

      .project-overlay {
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(26, 54, 93, 0.95);
         display: flex;
         align-items: center;
         justify-content: center;
         opacity: 0;
         transition: var(--transition);
         backdrop-filter: blur(10px);
      }

      .project-card:hover .project-overlay {
         opacity: 1;
      }

      .project-overlay-content {
         text-align: center;
      }

      .project-links {
         display: flex;
         gap: 1rem;
         justify-content: center;
      }

      .project-links .btn {
         padding: 0.8rem 1.5rem;
         border-radius: 50%;
         width: 50px;
         height: 50px;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .project-card:hover .project-image {
         transform: scale(1.05);
      }

      /* Project Content */
      .project-content {
         padding: 2rem;
      }

      .project-title {
         color: var(--light);
         font-size: 1.4rem;
         margin-bottom: 1rem;
         font-weight: 700;
         transition: var(--transition);
      }

      .project-card:hover .project-title {
         color: var(--accent);
      }

      .project-description {
         color: var(--gray);
         margin-bottom: 1.5rem;
         line-height: 1.6;
         font-weight: 500;
      }

      /* Technologies */
      .project-technologies {
         margin-bottom: 1.5rem;
      }

      .tech-tag {
         background: rgba(76, 111, 255, 0.15);
         color: var(--accent);
         padding: 0.4rem 0.8rem;
         border-radius: 50px;
         font-size: 0.8rem;
         font-weight: 600;
         border: 1px solid rgba(76, 111, 255, 0.3);
         display: inline-block;
         margin: 0.25rem;
         transition: var(--transition);
         backdrop-filter: blur(10px);
      }

      .project-card:hover .tech-tag {
         background: rgba(76, 111, 255, 0.25);
         transform: translateY(-2px);
      }

      /* Project Actions */
      .project-actions {
         display: flex;
         gap: 1rem;
      }

      .project-actions .btn {
         flex: 1;
         justify-content: center;
         padding: 0.8rem;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         font-size: 0.9rem;
      }

      /* CTA Section */
      .cta-section {
         text-align: center;
         margin-top: 5rem;
         padding: 4rem;
         background: var(--gradient);
         border-radius: var(--border-radius);
         position: relative;
         overflow: hidden;
         animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
      }

      .cta-section::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.1)" points="0,1000 1000,0 1000,1000" /></svg>');
         pointer-events: none;
      }

      .cta-title {
         color: var(--light);
         font-size: clamp(2rem, 4vw, 2.5rem);
         margin-bottom: 1.5rem;
         font-weight: 800;
         position: relative;
         line-height: 1.1;
      }

      .cta-description {
         color: rgba(255, 255, 255, 0.9);
         margin-bottom: 2.5rem;
         font-size: clamp(1rem, 2vw, 1.2rem);
         position: relative;
         font-weight: 500;
         line-height: 1.6;
      }

      .btn-light {
         background: rgba(255, 255, 255, 0.2);
         border: 2px solid rgba(255, 255, 255, 0.3);
         color: var(--light);
         position: relative;
         backdrop-filter: blur(10px);
         transition: var(--transition);
      }

      .btn-light:hover {
         background: rgba(255, 255, 255, 0.3);
         border-color: rgba(255, 255, 255, 0.5);
         transform: translateY(-3px);
         box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
      }

      /* Animations */
      @keyframes fadeInUp {
         from {
            opacity: 0;
            transform: translateY(30px);
         }

         to {
            opacity: 1;
            transform: translateY(0);
         }
      }

      /* Responsive Design */
      @media (max-width: 1200px) {
         .projects-grid {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
         }
      }

      @media (max-width: 768px) {
         .projects-section {
            padding: 80px 0;
         }

         .projects-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
         }

         .project-actions {
            flex-direction: column;
         }

         .cta-section {
            padding: 3rem 2rem;
            margin-top: 4rem;
         }

         .project-content {
            padding: 1.5rem;
         }

         .project-title {
            font-size: 1.3rem;
         }
      }

      @media (max-width: 480px) {
         .projects-grid {
            gap: 1.5rem;
         }

         .project-image {
            height: 200px;
         }

         .project-image-placeholder i {
            font-size: 3rem;
         }

         .project-content {
            padding: 1.25rem;
         }

         .project-title {
            font-size: 1.2rem;
         }

         .cta-section {
            padding: 2rem 1.5rem;
            margin-top: 3rem;
         }

         .tech-tag {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
         }
      }

      /* Accessibility & Performance */
      @media (prefers-reduced-motion: reduce) {

         .project-card,
         .project-image,
         .project-overlay,
         .btn-light {
            transition: none;
            animation: none;
         }

         .project-card:hover {
            transform: none;
         }

         .project-card::before {
            display: none;
         }
      }

      @media (hover: none) {
         .project-card:hover {
            transform: none;
         }

         .project-card::before {
            display: none;
         }
      }

      /* Touch Device Optimizations */
      @media (pointer: coarse) {
         .project-actions .btn {
            min-height: 50px;
         }

         .project-links .btn {
            min-width: 50px;
            min-height: 50px;
         }
      }
   </style>
@endsection
