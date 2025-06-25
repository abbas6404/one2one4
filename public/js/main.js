// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - initializing sidebar toggle');
    
    // Initialize tooltips if they exist
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers if they exist
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Sidebar Toggle Functionality
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');
    const body = document.body;
    const mainSidebar = document.getElementById('mainSidebar');
    const mainContent = document.getElementById('mainContent');
    
    console.log('Toggle elements:', {
        sidebarToggleBtn: !!sidebarToggleBtn,
        closeSidebarBtn: !!closeSidebarBtn,
        mainSidebar: !!mainSidebar,
        mainContent: !!mainContent
    });
    
    // Create backdrop element for mobile
    const backdrop = document.createElement('div');
    backdrop.classList.add('sidebar-backdrop');
    body.appendChild(backdrop);
    
    // Check if sidebar state is saved in localStorage
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    console.log('Initial sidebar state:', { sidebarCollapsed });
    
    // Apply saved state (only on desktop)
    if (sidebarCollapsed && window.innerWidth > 768) {
        body.classList.add('sidebar-collapsed');
        console.log('Applied collapsed state');
    }
    
    // Handle sidebar toggle click (primarily for desktop)
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', function() {
            console.log('Sidebar toggle clicked');
            if (window.innerWidth <= 768) {
                // Mobile behavior: show sidebar and backdrop
                mainSidebar.classList.add('active');
                body.classList.add('sidebar-open');
                console.log('Mobile sidebar toggled');
            } else {
                // Desktop behavior: toggle collapsed state
                body.classList.toggle('sidebar-collapsed');
                const isCollapsed = body.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
                console.log('Desktop sidebar toggled:', { isCollapsed });
            }
        });
    } else {
        console.error('Sidebar toggle button not found in DOM');
    }
    
    // Handle close sidebar button (mobile only)
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', function() {
            mainSidebar.classList.remove('active');
            body.classList.remove('sidebar-open');
        });
    }
    
    // Handle backdrop click to close sidebar
    backdrop.addEventListener('click', function() {
        mainSidebar.classList.remove('active');
        body.classList.remove('sidebar-open');
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            // Remove mobile specific classes
            mainSidebar.classList.remove('active');
            body.classList.remove('sidebar-open');
            
            // Apply saved collapse state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                body.classList.add('sidebar-collapsed');
            } else {
                body.classList.remove('sidebar-collapsed');
            }
        }
    });
    
    // Mobile menu handling
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            document.querySelector('.navbar-collapse').classList.toggle('show');
        });
    }
    
    // Back to top button functionality
    const backToTopButton = document.getElementById('back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    }
    
    // Initialize Hero Slider
    const heroSwiper = document.querySelector('.hero-swiper');
    if (heroSwiper) {
        new Swiper('.hero-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.hero-swiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.hero-swiper .swiper-button-next',
                prevEl: '.hero-swiper .swiper-button-prev',
            }
        });
    }
});
