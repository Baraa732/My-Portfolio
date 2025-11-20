@extends('layouts.app')

@section('content')
   <section class="about-section">
      <div class="container">
         <div class="section-title">
            <h2>About Me</h2>
            <p class="section-subtitle">Get to know more about my journey and experience</p>
         </div>

         <div class="about-content">
            <div class="about-image animate-on-scroll" data-animation="fadeInLeft">
               <div class="profile-image-container">
                  <div class="profile-image">
                     <picture>
                        <source srcset="{{ asset('images/profile/about.jpg') }}" type="image/webp">
                        <source srcset="{{ asset('images/profile/about.jpg') }}" type="image/jpeg">
                        <img src="{{ asset('images/profile/about.jpg') }}"
                           alt="Baraa Al-Rifaee - Full Stack Web Developer">
                     </picture>
                  </div>
                  <!-- Floating elements -->
                  <div class="floating-element element-1">
                     <i class="fab fa-html5"></i>
                  </div>
                  <div class="floating-element element-2">
                     <i class="fab fa-css3-alt"></i>
                  </div>
                  <div class="floating-element element-3">
                     <i class="fab fa-js"></i>
                  </div>
               </div>
            </div>

            <div class="about-text animate-on-scroll" data-animation="fadeInRight">
               <div class="about-badge">
                  <i class="fas fa-star me-2"></i>Full Stack Developer
               </div>

               <h3>My Journey in Web Development</h3>

               <div class="about-description">
                  <p>I build efficient, scalable, and user-friendly web applications that solve real-world problems. With a
                     passion for both
                     elegant frontend experiences and robust backend architecture, I bridge the gap between idea and
                     execution.</p>

                  <p>With experience in both frontend and backend development, I bring ideas to life through clean code and
                     innovative solutions. My journey started 3 years ago, and I've been constantly learning and adapting
                     to new technologies ever since.</p>
               </div>

               <div class="about-actions">
                  <a href="{{ route('contact') }}" class="btn btn-primary">
                     <i class="fas fa-paper-plane me-2"></i>
                     Get In Touch
                  </a>
                  <a href="{{ route('download.cv') }}" class="btn btn-secondary">
                     <i class="fas fa-download me-2"></i>
                     Download CV
                  </a>
               </div>
            </div>
         </div>

         <!-- Experience Timeline -->
         <div class="experience-section">
            <h3 class="section-subtitle text-center mb-4">My Experience</h3>
            <div class="timeline">
               <div class="timeline-item">
                  <div class="timeline-date">2025 - Present</div>
                  <div class="timeline-content">
                     <h4>Junior Full Stack Web Developer</h4>
                     <p>Tech Solutions Inc.</p>
                     <p>Leading development teams and architecting scalable websites.</p>
                  </div>
               </div>
               <div class="timeline-item">
                  <div class="timeline-date">2023 - 2024</div>
                  <div class="timeline-content">
                     <h4>Frontend Developer</h4>
                     <p>IX Coders</p>
                     <p>Creating responsive web interfaces and interactive user experiences.</p>
                  </div>
               </div>
               <div class="timeline-item">
                  <div class="timeline-date">2022 - 2023</div>
                  <div class="timeline-content">
                     <h4>Fresh Developer</h4>
                     <p>internship</p>
                     <p>Learning and implementing web development best practices.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <style>
      .about-section {
         padding: 120px 0;
         /* background: var(--gradient-dark); */
         position: relative;
         overflow: hidden;
      }

      .about-section::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background:
            radial-gradient(circle at 10% 20%, rgba(76, 111, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 90% 80%, rgba(26, 54, 93, 0.1) 0%, transparent 50%);
         pointer-events: none;
         z-index: 0;
         animation: backgroundPulse 8s ease-in-out infinite;
      }

      .about-content {
         display: grid;
         grid-template-columns: 1fr 1fr;
         gap: 5rem;
         align-items: center;
         margin-bottom: 6rem;
         position: relative;
         z-index: 2;
      }

      .profile-image-container {
         position: relative;
         max-width: 450px;
         margin: 0 auto;
      }

      .profile-image {
         width: 100%;
         aspect-ratio: 1;
         background: var(--gradient);
         border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
         display: flex;
         align-items: center;
         justify-content: center;
         position: relative;
         overflow: hidden;
         box-shadow: var(--shadow-lg);
         animation: morph 8s ease-in-out infinite, photoGlow 3s ease-in-out infinite alternate;
         transition: var(--transition);
      }

      .profile-image::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: linear-gradient(45deg, transparent, rgba(76, 111, 255, 0.1), transparent);
         animation: photoShine 6s ease-in-out infinite;
         z-index: 2;
      }

      .profile-image img {
         width: 100%;
         height: 100%;
         object-fit: cover;
         border-radius: inherit;
         transition: var(--transition);
         filter: brightness(1.05) contrast(1.1);
         animation: photoFloat 6s ease-in-out infinite;
      }

      .profile-image:hover {
         transform: scale(1.02);
         animation-play-state: paused;
      }

      .profile-image:hover img {
         transform: scale(1.05);
         filter: brightness(1.1) contrast(1.2);
         animation-play-state: paused;
      }

      .floating-element {
         position: absolute;
         width: 70px;
         height: 70px;
         background: rgba(76, 111, 255, 0.15);
         border-radius: 16px;
         display: flex;
         align-items: center;
         justify-content: center;
         backdrop-filter: blur(20px);
         border: 1px solid rgba(76, 111, 255, 0.3);
         animation: float 6s ease-in-out infinite;
         box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
         transition: var(--transition);
         z-index: 3;
      }

      .floating-element:hover {
         transform: scale(1.1);
         background: rgba(76, 111, 255, 0.25);
         animation-play-state: paused;
      }

      .floating-element i {
         font-size: 1.75rem;
         color: var(--light);
      }

      .element-1 {
         top: 10%;
         right: 5%;
         animation-delay: 0s;
      }

      .element-2 {
         bottom: 20%;
         left: 5%;
         animation-delay: 2s;
      }

      .element-3 {
         top: 50%;
         right: 8%;
         animation-delay: 4s;
      }

      .about-badge {
         background: rgba(76, 111, 255, 0.15);
         color: var(--accent);
         padding: 0.75rem 1.5rem;
         border-radius: 50px;
         font-size: 0.9rem;
         font-weight: 700;
         border: 1px solid rgba(76, 111, 255, 0.3);
         display: inline-block;
         margin-bottom: 2rem;
         backdrop-filter: blur(20px);
         animation: fadeInUp 0.6s ease-out;
         position: relative;
         overflow: hidden;
      }

      .about-badge::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.3), transparent);
         transition: var(--transition);
      }

      .about-badge:hover::before {
         left: 100%;
      }

      .about-text h3 {
         font-size: clamp(2.5rem, 4vw, 3.5rem);
         color: var(--light);
         margin-bottom: 2rem;
         font-weight: 800;
         line-height: 1.1;
         letter-spacing: -0.5px;
         animation: fadeInUp 0.6s ease-out 0.1s both;
      }

      .about-description {
         margin-bottom: 3rem;
         animation: fadeInUp 0.6s ease-out 0.2s both;
      }

      .about-description p {
         color: var(--gray);
         font-size: clamp(1rem, 1.8vw, 1.2rem);
         line-height: 1.7;
         margin-bottom: 1.5rem;
      }

      .about-stats {
         display: grid;
         grid-template-columns: repeat(3, 1fr);
         gap: 2rem;
         margin-bottom: 3rem;
         animation: fadeInUp 0.6s ease-out 0.3s both;
      }

      .stat-item {
         text-align: center;
         padding: 1.5rem;
         background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
         border: 1px solid rgba(255, 255, 255, 0.1);
         border-radius: 16px;
         backdrop-filter: blur(20px);
         transition: var(--transition);
         position: relative;
         overflow: hidden;
      }

      .stat-item::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
         transition: var(--transition);
      }

      .stat-item:hover::before {
         left: 100%;
      }

      .stat-item:hover {
         transform: translateY(-5px);
         border-color: rgba(76, 111, 255, 0.3);
         box-shadow: var(--shadow);
      }

      .stat-number {
         font-size: clamp(2rem, 3vw, 2.5rem);
         font-weight: 900;
         background: var(--gradient);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         line-height: 1;
         margin-bottom: 0.5rem;
         letter-spacing: -1px;
      }

      .stat-label {
         color: var(--gray);
         font-size: 0.9rem;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: 0.5px;
      }

      .about-actions {
         display: flex;
         gap: 1.25rem;
         flex-wrap: wrap;
         animation: fadeInUp 0.6s ease-out 0.4s both;
      }

      /* Enhanced Experience Timeline */
      .experience-section {
         margin-top: 6rem;
         position: relative;
         z-index: 2;
      }

      .experience-section h3 {
         font-size: clamp(2rem, 3vw, 2.5rem);
         color: var(--light);
         text-align: center;
         margin-bottom: 3rem;
         font-weight: 800;
         letter-spacing: -0.5px;
      }

      .timeline {
         position: relative;
         max-width: 900px;
         margin: 0 auto;
      }

      .timeline::before {
         content: '';
         position: absolute;
         left: 50%;
         transform: translateX(-50%);
         width: 2px;
         height: 100%;
         background: linear-gradient(to bottom, transparent, var(--accent), transparent);
         opacity: 0.3;
      }

      .timeline-item {
         display: flex;
         justify-content: center;
         align-items: flex-start;
         margin-bottom: 4rem;
         position: relative;
         animation: fadeInUp 0.6s ease-out both;
      }

      .timeline-item:nth-child(1) {
         animation-delay: 0.1s;
      }

      .timeline-item:nth-child(2) {
         animation-delay: 0.2s;
      }

      .timeline-item:nth-child(3) {
         animation-delay: 0.3s;
      }

      .timeline-date {
         flex: 0 0 180px;
         text-align: right;
         padding-right: 2.5rem;
         color: var(--accent);
         font-weight: 700;
         font-size: 1.1rem;
      }

      .timeline-content {
         flex: 1;
         padding-left: 2.5rem;
         background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
         padding: 2rem;
         border-radius: 16px;
         border: 1px solid rgba(255, 255, 255, 0.1);
         backdrop-filter: blur(20px);
         transition: var(--transition);
         position: relative;
         overflow: hidden;
      }

      .timeline-content::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
         transition: var(--transition);
      }

      .timeline-content:hover::before {
         left: 100%;
      }

      .timeline-content:hover {
         transform: translateX(10px);
         border-color: rgba(76, 111, 255, 0.3);
         box-shadow: var(--shadow);
      }

      .timeline-content h4 {
         color: var(--light);
         margin-bottom: 0.75rem;
         font-size: 1.4rem;
         font-weight: 700;
      }

      .timeline-content p {
         color: var(--gray);
         margin-bottom: 0.75rem;
         line-height: 1.6;
      }

      .timeline-content .company {
         color: var(--accent);
         font-weight: 600;
         font-size: 1.1rem;
      }

      /* Enhanced Animations */
      @keyframes backgroundPulse {

         0%,
         100% {
            opacity: 0.8;
            transform: scale(1);
         }

         50% {
            opacity: 1;
            transform: scale(1.02);
         }
      }

      @keyframes morph {

         0%,
         100% {
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
         }

         25% {
            border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%;
         }

         50% {
            border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%;
         }

         75% {
            border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
         }
      }

      @keyframes photoFloat {

         0%,
         100% {
            transform: translateY(0) scale(1);
         }

         50% {
            transform: translateY(-10px) scale(1.02);
         }
      }

      @keyframes photoGlow {
         0% {
            box-shadow:
               var(--shadow-lg),
               inset 0 2px 0 rgba(255, 255, 255, 0.1),
               0 0 20px rgba(76, 111, 255, 0.3);
         }

         100% {
            box-shadow:
               var(--shadow-lg),
               inset 0 2px 0 rgba(255, 255, 255, 0.1),
               0 0 40px rgba(76, 111, 255, 0.6);
         }
      }

      @keyframes photoShine {

         0%,
         100% {
            transform: translateX(-100%) translateY(-100%) rotate(45deg);
         }

         50% {
            transform: translateX(100%) translateY(100%) rotate(45deg);
         }
      }

      @keyframes float {

         0%,
         100% {
            transform: translateY(0) rotate(0deg);
         }

         50% {
            transform: translateY(-20px) rotate(5deg);
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

      /* Enhanced Responsive Design */
      @media (max-width: 1200px) {
         .about-content {
            gap: 4rem;
         }

         .profile-image-container {
            max-width: 400px;
         }
      }

      @media (max-width: 992px) {
         .about-content {
            grid-template-columns: 1fr;
            gap: 4rem;
            text-align: center;
         }

         .profile-image-container {
            max-width: 350px;
         }

         .about-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
         }

         .timeline::before {
            left: 30px;
         }

         .timeline-item {
            flex-direction: column;
            align-items: flex-start;
            padding-left: 70px;
         }

         .timeline-date {
            text-align: left;
            padding-right: 0;
            margin-bottom: 1rem;
            flex: none;
         }

         .timeline-content {
            padding-left: 0;
            width: 100%;
         }
      }

      @media (max-width: 768px) {
         .about-section {
            padding: 80px 0;
         }

         .about-content {
            gap: 3rem;
         }

         .profile-image-container {
            max-width: 300px;
         }

         .about-stats {
            grid-template-columns: 1fr;
            gap: 1.5rem;
         }

         .stat-item {
            padding: 1.25rem;
         }

         .about-actions {
            justify-content: center;
         }

         .floating-element {
            width: 50px;
            height: 50px;
         }

         .floating-element i {
            font-size: 1.3rem;
         }

         .timeline-item {
            padding-left: 50px;
            margin-bottom: 3rem;
         }
      }

      @media (max-width: 576px) {
         .about-section {
            padding: 60px 0;
         }

         .about-content {
            gap: 2.5rem;
         }

         .profile-image-container {
            max-width: 250px;
         }

         .about-actions {
            flex-direction: column;
            align-items: center;
         }

         .about-actions .btn {
            width: 100%;
            max-width: 280px;
         }

         .timeline-item {
            padding-left: 40px;
         }

         .timeline-date {
            font-size: 1rem;
         }

         .timeline-content {
            padding: 1.5rem;
         }
      }

      @media (max-width: 480px) {
         .profile-image-container {
            max-width: 220px;
         }

         .floating-element {
            width: 40px;
            height: 40px;
         }

         .floating-element i {
            font-size: 1.1rem;
         }

         .stat-number {
            font-size: 1.8rem;
         }

         .timeline-content h4 {
            font-size: 1.2rem;
         }
      }

      /* Accessibility & Performance */
      @media (prefers-reduced-motion: reduce) {
         * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
         }

         .profile-image,
         .profile-image img,
         .floating-element {
            animation: none !important;
         }
      }

      @media (hover: none) {

         .stat-item:hover,
         .timeline-content:hover,
         .profile-image:hover,
         .floating-element:hover {
            transform: none;
         }

         .stat-item::before,
         .timeline-content::before,
         .about-badge::before {
            display: none;
         }
      }
   </style>
   </section>
@endsection
