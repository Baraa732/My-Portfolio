@extends('layouts.app')

<section class="skills-section">
   <div class="container">
      <div class="section-title">
         <h2>Technical Skills</h2>
         <p class="section-subtitle">A showcase of my technical expertise and proficiency levels across various
            technologies and tools</p>
      </div>

      <div class="skills-grid">
         @foreach($skills as $skill)
            <div class="skill-item animate-on-scroll" data-animation="fadeInUp"
               data-skill-type="{{ strtolower($skill->category ?? 'frontend') }}">
               <!-- Animated background effect -->
               <div class="skill-background-shimmer"></div>

               <div class="skill-header">
                  <div class="skill-info-main">
                     <div class="skill-icon">
                        <i class="{{ $skill->icon }}"></i>
                     </div>
                     <div class="skill-text">
                        <h3 class="skill-name">{{ $skill->name }}</h3>
                        {{-- <span class="skill-level">{{ $skill->getProficiencyLevel() }}</span> --}}
                     </div>
                  </div>
                  <div class="skill-percentage">{{ $skill->percentage }}%</div>
               </div>

               <div class="skill-progress-container">
                  <div class="skill-progress" data-width="{{ $skill->percentage }}">
                     <div class="skill-progress-shimmer"></div>
                  </div>
               </div>

               <div class="skill-meta">
                  <span class="skill-label">Proficiency</span>
                  {{-- <span class="skill-expertise">{{ $skill->getExpertiseLevel() }}</span> --}}
               </div>
            </div>
         @endforeach
      </div>

      <!-- Skills Categories -->
      <div class="skills-categories animate-on-scroll" data-animation="fadeInUp">
         <div class="categories-grid">
            <div class="category-card frontend">
               <div class="category-icon">
                  <i class="fas fa-code"></i>
               </div>
               <h3 class="category-title">Frontend</h3>
               <p class="category-description">React, Vue.js, JavaScript, TypeScript, CSS3, HTML5</p>
               <div class="category-progress">
                  <div class="category-progress-bar" style="width: 90%"></div>
               </div>
            </div>

            <div class="category-card backend">
               <div class="category-icon">
                  <i class="fas fa-server"></i>
               </div>
               <h3 class="category-title">Backend</h3>
               <p class="category-description">Node.js, Laravel, Python, Express.js, MongoDB, MySQL</p>
               <div class="category-progress">
                  <div class="category-progress-bar" style="width: 85%"></div>
               </div>
            </div>

            <div class="category-card tools">
               <div class="category-icon">
                  <i class="fas fa-tools"></i>
               </div>
               <h3 class="category-title">Tools</h3>
               <p class="category-description">Git, Docker, AWS, Figma, Webpack, Jest</p>
               <div class="category-progress">
                  <div class="category-progress-bar" style="width: 80%"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<style>
   /* Enhanced Skills Section */
   .skills-section {
      padding: 120px 0;
      background: var(--gradient-dark);
      position: relative;
      overflow: hidden;
   }

   .skills-section::before {
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

   /* Skills Grid */
   .skills-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 2rem;
      position: relative;
      z-index: 2;
   }

   /* Skill Item */
   .skill-item {
      background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
      padding: 2.5rem;
      border-radius: var(--border-radius);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
   }

   .skill-background-shimmer {
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
      transition: var(--transition);
   }

   .skill-item:hover .skill-background-shimmer {
      left: 100%;
   }

   .skill-item:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: var(--shadow-lg);
      border-color: rgba(76, 111, 255, 0.3);
   }

   /* Skill Header */
   .skill-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
   }

   .skill-info-main {
      display: flex;
      align-items: center;
      gap: 1rem;
   }

   .skill-icon {
      width: 60px;
      height: 60px;
      background: var(--gradient);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow);
      transition: var(--transition);
   }

   .skill-item:hover .skill-icon {
      transform: scale(1.1) rotate(5deg);
   }

   .skill-icon i {
      font-size: 1.8rem;
      color: var(--light);
   }

   .skill-text {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
   }

   .skill-name {
      color: var(--light);
      font-size: 1.3rem;
      font-weight: 700;
      margin: 0;
      transition: var(--transition);
   }

   .skill-item:hover .skill-name {
      color: var(--accent);
      transform: translateX(5px);
   }

   .skill-level {
      color: var(--gray);
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
   }

   .skill-percentage {
      font-size: 1.5rem;
      font-weight: 800;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      transition: var(--transition);
   }

   .skill-item:hover .skill-percentage {
      transform: scale(1.1);
   }

   /* Skill Progress */
   .skill-progress-container {
      background: rgba(255, 255, 255, 0.1);
      height: 12px;
      border-radius: 6px;
      overflow: hidden;
      position: relative;
      backdrop-filter: blur(10px);
   }

   .skill-progress {
      height: 100%;
      background: var(--gradient);
      border-radius: 6px;
      width: 0%;
      transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
   }

   .skill-progress-shimmer {
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      animation: shimmer 2s infinite;
      animation-play-state: paused;
   }

   .skill-item:hover .skill-progress-shimmer {
      animation-play-state: running;
   }

   .skill-item:hover .skill-progress {
      box-shadow: 0 0 25px rgba(76, 111, 255, 0.4);
   }

   /* Skill Meta */
   .skill-meta {
      display: flex;
      justify-content: space-between;
      margin-top: 0.8rem;
   }

   .skill-label {
      color: var(--gray);
      font-size: 0.9rem;
      font-weight: 500;
   }

   .skill-expertise {
      color: var(--accent);
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
   }

   /* Skills Categories */
   .skills-categories {
      margin-top: 5rem;
      position: relative;
      z-index: 2;
   }

   .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
   }

   .category-card {
      text-align: center;
      padding: 2.5rem 2rem;
      background: linear-gradient(145deg, rgba(26, 54, 93, 0.3), rgba(15, 20, 25, 0.5));
      border-radius: var(--border-radius);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
   }

   .category-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
      transition: var(--transition);
   }

   .category-card:hover::before {
      left: 100%;
   }

   .category-card:hover {
      transform: translateY(-5px);
      border-color: rgba(76, 111, 255, 0.3);
      box-shadow: var(--shadow);
   }

   .category-icon {
      width: 80px;
      height: 80px;
      background: var(--gradient);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      box-shadow: var(--shadow);
      transition: var(--transition);
   }

   .category-card:hover .category-icon {
      transform: scale(1.1) rotate(5deg);
   }

   .category-icon i {
      font-size: 2rem;
      color: var(--light);
   }

   .category-title {
      color: var(--light);
      margin-bottom: 1rem;
      font-size: 1.4rem;
      font-weight: 700;
   }

   .category-description {
      color: var(--gray);
      line-height: 1.6;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
   }

   .category-progress {
      background: rgba(255, 255, 255, 0.1);
      height: 6px;
      border-radius: 3px;
      overflow: hidden;
      backdrop-filter: blur(10px);
   }

   .category-progress-bar {
      height: 100%;
      background: var(--gradient);
      border-radius: 3px;
      transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
   }

   /* Color Variations for Categories */
   .category-card.frontend:hover {
      border-color: rgba(59, 130, 246, 0.4);
   }

   .category-card.backend:hover {
      border-color: rgba(16, 185, 129, 0.4);
   }

   .category-card.tools:hover {
      border-color: rgba(245, 158, 11, 0.4);
   }

   /* Animations */
   @keyframes shimmer {
      0% {
         transform: translateX(-100%) skewX(-15deg);
      }

      100% {
         transform: translateX(200%) skewX(-15deg);
      }
   }

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
      .skills-grid {
         grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      }
   }

   @media (max-width: 768px) {
      .skills-section {
         padding: 80px 0;
      }

      .skills-grid {
         grid-template-columns: 1fr;
         gap: 1.5rem;
      }

      .skill-item {
         padding: 2rem;
      }

      .skill-header {
         margin-bottom: 1.5rem;
      }

      .skill-icon {
         width: 50px;
         height: 50px;
      }

      .skill-icon i {
         font-size: 1.5rem;
      }

      .skill-name {
         font-size: 1.2rem;
      }

      .skill-percentage {
         font-size: 1.3rem;
      }

      .categories-grid {
         grid-template-columns: 1fr;
         gap: 1.5rem;
      }

      .category-card {
         padding: 2rem 1.5rem;
      }

      .category-icon {
         width: 70px;
         height: 70px;
      }

      .category-icon i {
         font-size: 1.8rem;
      }
   }

   @media (max-width: 480px) {
      .skill-item {
         padding: 1.5rem;
      }

      .skill-info-main {
         gap: 0.75rem;
      }

      .skill-icon {
         width: 45px;
         height: 45px;
      }

      .skill-icon i {
         font-size: 1.3rem;
      }

      .skill-name {
         font-size: 1.1rem;
      }

      .skill-percentage {
         font-size: 1.2rem;
      }

      .category-card {
         padding: 1.5rem;
      }

      .category-icon {
         width: 60px;
         height: 60px;
      }

      .category-icon i {
         font-size: 1.6rem;
      }
   }

   /* Accessibility & Performance */
   @media (prefers-reduced-motion: reduce) {

      .skill-item,
      .category-card,
      .skill-icon,
      .skill-progress {
         transition: none;
         animation: none;
      }

      .skill-item:hover,
      .category-card:hover {
         transform: none;
      }

      .skill-background-shimmer,
      .skill-progress-shimmer {
         display: none;
      }
   }

   @media (hover: none) {

      .skill-item:hover,
      .category-card:hover {
         transform: none;
      }

      .skill-item::before,
      .category-card::before {
         display: none;
      }
   }
</style>

<script>
   // JavaScript for animating skill progress bars on scroll
   document.addEventListener('DOMContentLoaded', function () {
      const skillItems = document.querySelectorAll('.skill-item');

      const observer = new IntersectionObserver((entries) => {
         entries.forEach(entry => {
            if (entry.isIntersecting) {
               const skillProgress = entry.target.querySelector('.skill-progress');
               const width = skillProgress.getAttribute('data-width'); 

               setTimeout(() => {
                  skillProgress.style.width = width + '%';
               }, 200);

               observer.unobserve(entry.target);
            }
         });
      }, { threshold: 0.3 });

      skillItems.forEach(item => {
         observer.observe(item);
      });
   });
</script>
