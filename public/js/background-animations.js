// Create animated background immediately
(function() {
    const animatedBg = document.createElement('div');
    animatedBg.className = 'animated-bg';
    
    animatedBg.innerHTML = `
        <div class="bg-shapes">
            <div class="bg-shape bg-shape-1"></div>
            <div class="bg-shape bg-shape-2"></div>
            <div class="bg-shape bg-shape-3"></div>
        </div>
        <div class="bg-grid"></div>
        <div class="bg-orbs">
            <div class="bg-orb bg-orb-1"></div>
            <div class="bg-orb bg-orb-2"></div>
        </div>
        <div class="bg-wave"></div>
        <div class="bg-particles">
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
        </div>
        <div class="bg-lines">
            <div class="bg-line bg-line-1"></div>
            <div class="bg-line bg-line-2"></div>
            <div class="bg-line bg-line-3"></div>
        </div>
    `;
    
    if (document.body) {
        document.body.insertBefore(animatedBg, document.body.firstChild);
    } else {
        document.addEventListener('DOMContentLoaded', () => {
            document.body.insertBefore(animatedBg, document.body.firstChild);
        });
    }
})();