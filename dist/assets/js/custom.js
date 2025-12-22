// index js
// Modern Hamburger Menu Toggle
        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const navLinks = document.getElementById('navLinks');
        const menuOverlay = document.getElementById('menuOverlay');
        
        hamburgerMenu.addEventListener('click', () => {
            hamburgerMenu.classList.toggle('active');
            navLinks.classList.toggle('active');
            menuOverlay.classList.toggle('active');
            
            // Prevent scrolling when menu is open
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
        });
        
        // Close menu when clicking overlay or links
        menuOverlay.addEventListener('click', closeMobileMenu);
        
        document.querySelectorAll('.nav-link, .btn').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
        
        function closeMobileMenu() {
            hamburgerMenu.classList.remove('active');
            navLinks.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const navbarHeight = navbar.offsetHeight;
                    const targetPosition = targetElement.offsetTop - navbarHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Fade-in animation on scroll
        const fadeElements = document.querySelectorAll('.fade-in');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        fadeElements.forEach(el => observer.observe(el));
        
        // Update active nav link on scroll
        const sections = document.querySelectorAll('section');
        const navLinksAll = document.querySelectorAll('.nav-link');
        
        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (window.scrollY >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinksAll.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
        
        // Close mobile menu on window resize (if resized to desktop)
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeMobileMenu();
            }
        });
//index js tutup

// login js
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const navbarHeight = navbar.offsetHeight;
                    const targetPosition = targetElement.offsetTop - navbarHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Auto-fill demo credentials
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').value = 'admin@sipagu.ac.id';
            document.getElementById('password').value = 'password';
        });
        
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = togglePassword.querySelector('i');
        
        togglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                togglePassword.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                togglePassword.setAttribute('aria-label', 'Tampilkan password');
            }
        });
        
        // Form submission
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            // Remove any existing alerts
            const existingAlert = document.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Simple validation
            if (!email || !password) {
                showAlert('error', 'Harap isi semua field yang diperlukan');
                return;
            }
            
            // Demo validation
            const demoEmail = 'admin@sipagu.ac.id';
            const demoPassword = 'password';
            
            // Show loading state
            const originalButtonContent = loginButton.innerHTML;
            loginButton.innerHTML = '<div class="loading"></div> Memproses...';
            loginButton.disabled = true;
            
            // Simulate API call delay
            setTimeout(function() {
                if (email === demoEmail && password === demoPassword) {
                    // Successful login
                    showAlert('success', 'Login berhasil! Mengalihkan ke dashboard...');
                    
                    // Change button to success state
                    loginButton.innerHTML = '<i class="fas fa-check"></i> Login Berhasil!';
                    loginButton.style.background = 'linear-gradient(135deg, var(--success) 0%, #34d399 100%)';
                    
                    // Redirect to index after 1.5 seconds
                    setTimeout(function() {
                        window.location.href = 'index.html';
                    }, 1500);
                } else {
                    // Failed login
                    let errorMessage = 'Kredensial tidak valid';
                    
                    if (email !== demoEmail && password !== demoPassword) {
                        errorMessage = 'Email dan kata sandi tidak sesuai';
                    } else if (email !== demoEmail) {
                        errorMessage = 'Email tidak terdaftar dalam sistem';
                    } else {
                        errorMessage = 'Kata sandi salah';
                    }
                    
                    showAlert('error', errorMessage);
                    
                    // Reset button state
                    loginButton.innerHTML = originalButtonContent;
                    loginButton.disabled = false;
                    
                    // Add shake animation
                    loginForm.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        loginForm.style.animation = '';
                    }, 500);
                }
            }, 1500);
        });
        
        // Function to show alert
        function showAlert(type, message) {
            const form = document.getElementById('loginForm');
            const demoInfo = document.querySelector('.demo-info');
            
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            
            let icon = 'fa-info-circle';
            if (type === 'success') icon = 'fa-check-circle';
            if (type === 'error') icon = 'fa-exclamation-circle';
            
            alertDiv.innerHTML = `
                <i class="fas ${icon}"></i>
                <div>${message}</div>
            `;
            
            // Insert before form
            demoInfo.parentNode.insertBefore(alertDiv, demoInfo.nextSibling);
            
            // Auto remove after 5 seconds (except for success alerts)
            if (type !== 'success') {
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.style.opacity = '0';
                        alertDiv.style.transform = 'translateY(-10px)';
                        alertDiv.style.transition = 'all 0.3s ease';
                        
                        setTimeout(() => {
                            if (alertDiv.parentNode) {
                                alertDiv.parentNode.removeChild(alertDiv);
                            }
                        }, 300);
                    }
                }, 5000);
            }
        }
        
        // Add shake animation for error
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }
        `;
        document.head.appendChild(style);
        
        // Close mobile menu on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeMobileMenu();
            }
        });
        
        // Fade in animation on load
        document.addEventListener('DOMContentLoaded', () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach(el => {
                setTimeout(() => {
                    el.classList.add('visible');
                }, 100);
            });
        });

// login js tutup //
"use strict";
