/* =============================================================================
   BUILDFUTURE - JAVASCRIPT INTERACTIVO Y MODERNO
   Funcionalidades dinámicas para una experiencia juvenil
   ============================================================================= */

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    initializeNavigation();
    initializeAnimations();
    initializeVideoPlayers();
    initializeFormHandlers();
    initializeScrollEffects();
    initializeCarousels();
    initializeLazyLoading();
    initializeParallax();
});

/* =============================================================================
   NAVEGACIÓN DINÁMICA
   ============================================================================= */
function initializeNavigation() {
    const navbar = document.getElementById('navbar');
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    // Efecto scroll en navbar
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Toggle menú móvil
    navToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        navToggle.classList.toggle('active');
    });

    // Cerrar menú al hacer click en enlaces
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            navToggle.classList.remove('active');
        });
    });

    // Smooth scroll para enlaces internos
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetSection = document.querySelector(targetId);

            if (targetSection) {
                const offsetTop = targetSection.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/* =============================================================================
   ANIMACIONES Y EFECTOS VISUALES
   ============================================================================= */
function initializeAnimations() {
    // Inicializar AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 100
        });
    }

    // Animaciones personalizadas
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observar elementos para animaciones
    const animatedElements = document.querySelectorAll('.highlight-card, .project-card, .story-card, .career-card');
    animatedElements.forEach(el => observer.observe(el));
}

/* =============================================================================
   REPRODUCTORES DE VIDEO INTERACTIVOS
   ============================================================================= */
function initializeVideoPlayers() {
    // Videos de historias inspiradoras
    const storyVideos = document.querySelectorAll('.story-video');

    storyVideos.forEach(container => {
        const video = container.querySelector('video');
        const playButton = container.querySelector('.play-button');

        if (video && playButton) {
            playButton.addEventListener('click', () => {
                if (video.paused) {
                    // Pausar otros videos
                    storyVideos.forEach(otherContainer => {
                        const otherVideo = otherContainer.querySelector('video');
                        if (otherVideo && otherVideo !== video) {
                            otherVideo.pause();
                            otherContainer.querySelector('.play-button').style.display = 'flex';
                        }
                    });

                    video.play();
                    playButton.style.display = 'none';
                } else {
                    video.pause();
                    playButton.style.display = 'flex';
                }
            });

            video.addEventListener('ended', () => {
                playButton.style.display = 'flex';
            });

            video.addEventListener('click', () => {
                if (!video.paused) {
                    video.pause();
                    playButton.style.display = 'flex';
                }
            });
        }
    });

    // YouTube Video Modal System
    initializeYouTubeModal();
}

function initializeYouTubeModal() {
    const videoThumbnails = document.querySelectorAll('.video-thumbnail[data-video-id]');
    const modal = document.getElementById('videoModal');
    const closeBtn = document.getElementById('closeModal');
    const iframe = document.getElementById('youtubePlayer');

    // Abrir modal al hacer click en thumbnail
    videoThumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            const videoId = thumbnail.getAttribute('data-video-id');
            openVideoModal(videoId);
        });
    });

    // Cerrar modal
    function closeVideoModal() {
        modal.classList.remove('active');
        iframe.src = '';
        document.body.style.overflow = 'auto';
    }

    // Abrir modal
    function openVideoModal(videoId) {
        const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
        iframe.src = embedUrl;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Event listeners para cerrar
    if (closeBtn) {
        closeBtn.addEventListener('click', closeVideoModal);
    }

    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeVideoModal();
            }
        });
    }

    // Cerrar con ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeVideoModal();
        }
    });
}

/* =============================================================================
   MANEJO DE FORMULARIOS
   ============================================================================= */
function initializeFormHandlers() {
    const careerForm = document.querySelector('.career-form');
    const fileUpload = document.getElementById('cv-upload');

    if (careerForm) {
        careerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleFormSubmission(careerForm);
        });
    }

    // Manejo de subida de archivos
    if (fileUpload) {
        fileUpload.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const label = document.querySelector('label[for="cv-upload"]');

            if (file) {
                label.innerHTML = `<i class="fas fa-check"></i> ${file.name}`;
                label.style.background = 'linear-gradient(135deg, #63AF2D, #5DADE2)';
            }
        });
    }

    // Validación en tiempo real
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => clearFieldError(input));
    });
}

function handleFormSubmission(form) {
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');

    // Mostrar estado de carga
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    submitButton.disabled = true;

    // Simular envío (aquí conectarías con tu backend)
    setTimeout(() => {
        showNotification('¡Gracias! Hemos recibido tu información. Te contactaremos pronto.', 'success');
        form.reset();
        submitButton.innerHTML = 'Enviar y unirme';
        submitButton.disabled = false;

        // Resetear label del archivo
        const fileLabel = document.querySelector('label[for="cv-upload"]');
        if (fileLabel) {
            fileLabel.innerHTML = '<i class="fas fa-upload"></i> Subir CV (PDF)';
            fileLabel.style.background = '';
        }
    }, 2000);
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    // Validaciones específicas
    switch (field.type) {
        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                console.log('Validating email:', value);
                isValid = false;
                errorMessage = 'Por favor, introduce un email válido';
            }
            break;
        case 'tel':
            const phoneRegex = /^[0-9+\-\s()]{9,9}$/;
            if (value && !phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Por favor, introduce un teléfono válido';
            }
            break;
        default:
            if (field.required && !value) {
                isValid = false;
                errorMessage = 'Este campo es obligatorio';
            }
    }

    // Mostrar/ocultar error
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }

    return isValid;
}


// function validateContactField(field) {
//     const value = field.value.trim();
//     let isValid = true;
//     let errorMessage = '';

//     if (field.required && !value) {
//         isValid = false;
//         errorMessage = 'Este campo es obligatorio';
//     } else if (field.type === 'email' && value) {
//         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//         if (!emailRegex.test(value)) {
//             isValid = false;
//             errorMessage = 'Por favor, introduce un email válido';
//         }
//     } else if (field.type === 'tel' && value) {
//         const phoneRegex = /^[0-9+\-\s()]{9,}$/;
//         if (!phoneRegex.test(value)) {
//             isValid = false;
//             errorMessage = 'Por favor, introduce un teléfono válido';
//         }
//     }

//     if (!isValid) {
//         showContactFieldError(field, errorMessage);
//     } else {
//         clearContactFieldError(field);
//     }

//     return isValid;
// }

// function showContactFieldError(field, message) {
//     clearContactFieldError(field);

//     field.style.borderColor = '#dc3545';

//     const errorDiv = document.createElement('div');
//     errorDiv.className = 'contact-field-error';
//     errorDiv.textContent = message;
//     errorDiv.style.cssText = `
//         color: #dc3545;
//         font-size: 0.8rem;
//         margin-top: 5px;
//         display: block;
//     `;

//     field.parentNode.appendChild(errorDiv);
// }

// function clearContactFieldError(field) {
//     field.style.borderColor = '';
//     const existingError = field.parentNode.querySelector('.contact-field-error');
//     if (existingError) {
//         existingError.remove();
//     }
// }


function showFieldError(field, message) {
    clearFieldError(field);

    field.style.borderColor = '#dc3545';

    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '5px';

    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.style.borderColor = '';
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

/* =============================================================================
   EFECTOS DE SCROLL Y PARALLAX
   ============================================================================= */
function initializeScrollEffects() {
    let ticking = false;

    function updateScrollEffects() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;

        // Parallax en el hero
        const heroVideo = document.querySelector('.hero-video');
        if (heroVideo) {
            heroVideo.style.transform = `translateY(${rate}px)`;
        }

        // Efectos en elementos específicos
        const parallaxElements = document.querySelectorAll('.preview-image img');
        parallaxElements.forEach((element, index) => {
            const speed = 0.3 + (index * 0.1);
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });

        ticking = false;
    }

    function requestScrollUpdate() {
        if (!ticking) {
            requestAnimationFrame(updateScrollEffects);
            ticking = true;
        }
    }

    window.addEventListener('scroll', requestScrollUpdate);
}

function initializeParallax() {
    // Efecto parallax más avanzado para elementos específicos
    const parallaxElements = document.querySelectorAll('[data-parallax]');

    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', () => {
            parallaxElements.forEach(element => {
                const speed = element.dataset.parallax || 0.5;
                const yPos = -(window.pageYOffset * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
    }
}

/* =============================================================================
   CARRUSELES Y SLIDERS
   ============================================================================= */
function initializeCarousels() {
    // Carrusel de quotes inspiradoras
    const quotes = document.querySelectorAll('.quote');
    let currentQuote = 0;

    if (quotes.length > 1) {
        setInterval(() => {
            quotes[currentQuote].classList.remove('active');
            currentQuote = (currentQuote + 1) % quotes.length;
            quotes[currentQuote].classList.add('active');
        }, 5000);
    }

    // Slider de comparación antes/después
    initializeBeforeAfterSliders();
}

function initializeBeforeAfterSliders() {
    const sliders = document.querySelectorAll('.before-after-slider');

    sliders.forEach(slider => {
        let isHovering = false;
        let interval;

        slider.addEventListener('mouseenter', () => {
            isHovering = true;
            const afterImage = slider.querySelector('img:last-child');

            interval = setInterval(() => {
                if (isHovering) {
                    afterImage.style.opacity = afterImage.style.opacity === '1' ? '0' : '1';
                }
            }, 1000);
        });

        slider.addEventListener('mouseleave', () => {
            isHovering = false;
            clearInterval(interval);
            const afterImage = slider.querySelector('img:last-child');
            afterImage.style.opacity = '0';
        });
    });
}

/* =============================================================================
   LAZY LOADING PARA OPTIMIZACIÓN
   ============================================================================= */
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback para navegadores sin soporte
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    }
}

/* =============================================================================
   SISTEMA DE NOTIFICACIONES
   ============================================================================= */
function showNotification(message, type = 'info') {
    // Remover notificaciones existentes
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notif => notif.remove());

    // Crear nueva notificación
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${getNotificationIcon(type)}"></i>
            <span>${message}</span>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    // Estilos de la notificación
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: ${getNotificationColor(type)};
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 400px;
    `;

    // Estilos del contenido
    const content = notification.querySelector('.notification-content');
    content.style.cssText = `
        display: flex;
        align-items: center;
        gap: 10px;
    `;

    // Botón de cerrar
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.style.cssText = `
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 0;
        margin-left: auto;
    `;

    document.body.appendChild(notification);

    // Animar entrada
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Auto-cerrar después de 5 segundos
    const autoClose = setTimeout(() => {
        closeNotification(notification);
    }, 5000);

    // Cerrar manualmente
    closeBtn.addEventListener('click', () => {
        clearTimeout(autoClose);
        closeNotification(notification);
    });
}

function closeNotification(notification) {
    notification.style.transform = 'translateX(100%)';
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 300);
}

function getNotificationIcon(type) {
    const icons = {
        success: 'check',
        error: 'exclamation-triangle',
        warning: 'exclamation',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

function getNotificationColor(type) {
    const colors = {
        success: 'linear-gradient(135deg, #63af2d, #5DADE2)',
        error: 'linear-gradient(135deg, #dc3545, #c82333)',
        warning: 'linear-gradient(135deg, #ffc107, #e0a800)',
        info: 'linear-gradient(135deg, #17a2b8, #138496)'
    };
    return colors[type] || colors.info;
}

/* =============================================================================
   EFECTOS ESPECIALES PARA ENGAGEMENT
   ============================================================================= */
function addSpecialEffects() {
    // Efecto de partículas en el hero (opcional)
    if (window.innerWidth > 768) {
        createParticleEffect();
    }

    // Contador animado para estadísticas
    animateCounters();

    // Efecto de escritura para textos importantes
    animateTypewriter();
}

function createParticleEffect() {
    const hero = document.querySelector('.hero');
    if (!hero) return;

    // Crear contenedor de partículas
    const particlesContainer = document.createElement('div');
    particlesContainer.className = 'particles-container';
    particlesContainer.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    `;

    // Crear partículas
    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.cssText = `
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
            left: ${Math.random() * 100}%;
            top: ${Math.random() * 100}%;
            animation-delay: ${Math.random() * 2}s;
        `;

        particlesContainer.appendChild(particle);
    }

    hero.appendChild(particlesContainer);

    // CSS para la animación de partículas
    if (!document.querySelector('#particle-styles')) {
        const style = document.createElement('style');
        style.id = 'particle-styles';
        style.textContent = `
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.6; }
                50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
}

function animateCounters() {
    const counters = document.querySelectorAll('[data-count]');

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.dataset.count);
                let current = 0;
                const increment = target / 50;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                   
                        counter.textContent = "+ " + target;
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 50);

                counterObserver.unobserve(counter);
            }
        });
    });

    counters.forEach(counter => counterObserver.observe(counter));
}

function animateTypewriter() {
    const typewriterElements = document.querySelectorAll('[data-typewriter]');

    typewriterElements.forEach(element => {
        const text = element.dataset.typewriter;
        element.textContent = '';

        let i = 0;
        const timer = setInterval(() => {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
            } else {
                clearInterval(timer);
            }
        }, 100);
    });
}

/* =============================================================================
   UTILIDADES Y HELPERS
   ============================================================================= */

// Función para detectar dispositivo móvil
function isMobile() {
    return window.innerWidth <= 768;
}

// Función para obtener parámetros de URL
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    const results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Función para scroll suave a elemento
function scrollToElement(elementId, offset = 80) {
    const element = document.getElementById(elementId);
    if (element) {
        const top = element.offsetTop - offset;
        window.scrollTo({
            top: top,
            behavior: 'smooth'
        });
    }
}

// Event listeners para botones específicos
document.addEventListener('DOMContentLoaded', function () {
    // Botón de scroll del hero
    const heroScroll = document.querySelector('.hero-scroll');
    if (heroScroll) {
        heroScroll.addEventListener('click', () => {
            scrollToElement('explora');
        });
    }

    // Botones CTA
    const ctaButtons = document.querySelectorAll('[data-scroll-to]');
    ctaButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = button.dataset.scrollTo;
            scrollToElement(targetId);
        });
    });

    // Scroll to top button
    initializeScrollToTop();

    // Contact form
    initializeContactForm();

    // LinkedIn posts simulation
    simulateLinkedInFeed();
});

/* =============================================================================
   SCROLL TO TOP FUNCTIONALITY
   ============================================================================= */
function initializeScrollToTop() {
    const scrollButton = document.getElementById('scroll-to-top');
    if (!scrollButton) return;

    // Show/hide button based on scroll position
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollButton.classList.add('visible');
        } else {
            scrollButton.classList.remove('visible');
        }
    });

    // Scroll to top functionality
    scrollButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/* =============================================================================
   CONTACT FORM ENHANCED
   ============================================================================= */
function initializeContactForm() {
    const contactForm = document.querySelector('.contact-form');
    if (!contactForm) return;

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        handleContactFormSubmission(contactForm);
    });

    // Enhanced validation
    const requiredFields = contactForm.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', () => validateContactField(field));
        field.addEventListener('input', () => clearContactFieldError(field));
    });
}

function handleContactFormSubmission(form) {
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');

    // Validate all fields
    const isValid = validateContactForm(form);
    if (!isValid) {
        showNotification('Por favor, corrige los errores en el formulario', 'error');
        return;
    }

    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando mensaje...';
    submitButton.disabled = true;

    // Simulate form submission
    setTimeout(() => {
        showNotification('¡Mensaje enviado! Te contactaremos pronto.', 'success');
        form.reset();
        submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar mensaje';
        submitButton.disabled = false;
    }, 2000);
}

function validateContactForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!validateContactField(field)) {
            isValid = false;
        }
    });

    return isValid;
}



/* =============================================================================
   SIMULATE LINKEDIN FEED (PLACEHOLDER)
   ============================================================================= */
function simulateLinkedInFeed() {
    // Simulate real-time LinkedIn posts
    const posts = document.querySelectorAll('.post-card');

    posts.forEach((post, index) => {
        // Add subtle animation delay
        post.style.animationDelay = `${index * 0.2}s`;

        // Simulate like button interaction
        const likeButton = post.querySelector('.post-actions span:first-child');
        if (likeButton) {
            likeButton.addEventListener('click', () => {
                const currentLikes = parseInt(likeButton.textContent.match(/\d+/)[0]);
                likeButton.innerHTML = `<i class="fas fa-thumbs-up"></i> ${currentLikes + 1}`;
                likeButton.style.color = 'var(--primary-color)';

                // Small animation
                likeButton.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    likeButton.style.transform = 'scale(1)';
                }, 200);
            });
        }
    });
}

/* =============================================================================
   COURSES INTERACTION
   ============================================================================= */
function initializeCoursesSection() {
    const courseCards = document.querySelectorAll('.course-card');

    courseCards.forEach(card => {
        card.addEventListener('click', () => {
            // Add visual feedback
            card.style.transform = 'scale(0.98)';
            setTimeout(() => {
                card.style.transform = '';
            }, 150);

            // Simulate course enrollment
            showNotification('¡Interés registrado! Te enviaremos más información sobre este curso.', 'info');
        });
    });

    // Course list items interaction
    const courseItems = document.querySelectorAll('.course-item');
    courseItems.forEach(item => {
        const link = item.querySelector('.course-link');
        if (link) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                showNotification('Curso disponible próximamente. ¡Te notificaremos cuando esté listo!', 'info');
            });
        }
    });
}

/* =============================================================================
   COMPETITION REGISTRATION
   ============================================================================= */
function initializeCompetitions() {
    const competitionButtons = document.querySelectorAll('.competition-card .btn');

    competitionButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            if (button.textContent.includes('Inscríbete')) {
                showCompetitionModal();
            } else {
                // External links
                if (button.href) {
                    window.open(button.href, '_blank');
                }
            }
        });
    });
}

function showCompetitionModal() {
    // Create modal for competition registration
    const modal = document.createElement('div');
    modal.className = 'competition-modal';
    modal.innerHTML = `
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>¡Únete al Reto Joven!</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>Prepárate para diseñar el módulo prefabricado del futuro. Te enviaremos toda la información necesaria para participar.</p>
                <form class="competition-form">
                    <input type="text" placeholder="Tu nombre completo" required>
                    <input type="email" placeholder="Tu email" required>
                    <select required>
                        <option value="">Selecciona tu área de estudio</option>
                        <option value="arquitectura">Arquitectura</option>
                        <option value="ingenieria">Ingeniería</option>
                        <option value="fp">Formación Profesional</option>
                        <option value="otros">Otros</option>
                    </select>
                    <button type="submit" class="btn btn-accent">Registrarme al reto</button>
                </form>
            </div>
        </div>
    `;

    // Modal styles
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    `;

    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';

    // Modal functionality
    const closeModal = () => {
        document.body.removeChild(modal);
        document.body.style.overflow = '';
    };

    modal.querySelector('.modal-close').addEventListener('click', closeModal);
    modal.querySelector('.modal-overlay').addEventListener('click', closeModal);

    // Form submission
    modal.querySelector('.competition-form').addEventListener('submit', (e) => {
        e.preventDefault();
        closeModal();
        showNotification('¡Registro exitoso! Te enviaremos los detalles del concurso por email.', 'success');
    });
}

/* =============================================================================
   COMMUNITY FEATURES
   ============================================================================= */
function initializeCommunityFeatures() {
    const communityButtons = document.querySelectorAll('.community-card .btn');

    communityButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const buttonText = button.textContent.toLowerCase();

            if (buttonText.includes('whatsapp')) {
                showNotification('¡Te enviaremos el enlace del grupo por email!', 'success');
            } else if (buttonText.includes('discord')) {
                showNotification('¡Te enviaremos la invitación al servidor Discord!', 'success');
            }
        });
    });

    // Event items interaction
    const eventItems = document.querySelectorAll('.event-item');
    eventItems.forEach(item => {
        item.addEventListener('click', () => {
            item.style.transform = 'translateX(15px)';
            setTimeout(() => {
                item.style.transform = '';
            }, 200);

            showNotification('¡Interés registrado! Te recordaremos este evento.', 'info');
        });
    });
}

/* =============================================================================
   ADVANCED ANIMATIONS AND EFFECTS
   ============================================================================= */
function initializeAdvancedEffects() {
    // Intersection Observer for advanced animations
    const advancedObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;

                // Add staggered animation to children
                const children = element.children;
                Array.from(children).forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('animate-in');
                    }, index * 100);
                });
            }
        });
    }, {
        threshold: 0.2
    });

    // Observe grid containers
    const gridContainers = document.querySelectorAll('.courses-grid, .competitions-grid, .posts-grid');
    gridContainers.forEach(container => advancedObserver.observe(container));

    // Add floating animation to certain elements
    const floatingElements = document.querySelectorAll('.hero-content, .highlight-icon');
    floatingElements.forEach(element => {
        element.classList.add('floating');
    });
}

/* =============================================================================
   PERFORMANCE AND OPTIMIZATION
   ============================================================================= */
function optimizePerformance() {
    // Lazy load images
    const images = document.querySelectorAll('img');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        if (img.dataset.src) {
            imageObserver.observe(img);
        }
    });

    // Optimize scroll listeners
    let ticking = false;
    const optimizedScrollHandler = () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                // Your scroll-based animations here
                ticking = false;
            });
            ticking = true;
        }
    };

    window.addEventListener('scroll', optimizedScrollHandler, { passive: true });
}

/* =============================================================================
   SOCIAL MEDIA INTEGRATION SIMULATION
   ============================================================================= */
function initializeSocialFeatures() {
    // Social sharing buttons
    const socialLinks = document.querySelectorAll('.social-links a');

    socialLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            const platform = link.querySelector('i').className;
            let message = '';

            if (platform.includes('linkedin')) {
                message = '¡Visitando el perfil de LinkedIn de ANDECE!';
            } else if (platform.includes('youtube')) {
                message = '¡Visitando el canal de YouTube de ANDECE!';
            } else if (platform.includes('instagram')) {
                message = '¡Visitando el Instagram de ANDECE!';
            } else if (platform.includes('twitter')) {
                message = '¡Visitando el Twitter de ANDECE!';
            }

            showNotification(message, 'info');

            // Simulate opening social media (in real implementation, use actual URLs)
            // window.open(link.href, '_blank');
        });
    });
}

/* =============================================================================
   MODAL STYLES (INJECTED DYNAMICALLY)
   ============================================================================= */
function injectModalStyles() {
    if (document.getElementById('modal-styles')) return;

    const style = document.createElement('style');
    style.id = 'modal-styles';
    style.textContent = `
        .competition-modal .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }
        
        .competition-modal .modal-content {
            background: white;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .competition-modal .modal-header {
            padding: 30px 30px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .competition-modal .modal-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }
        
        .competition-modal .modal-close {
            background: none;
            border: none;
            font-size: 2rem;
            color: var(--gray-medium);
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: var(--transition-fast);
        }
        
        .competition-modal .modal-close:hover {
            background: var(--gray-light);
            color: var(--dark-color);
        }
        
        .competition-modal .modal-body {
            padding: 20px 30px 30px;
        }
        
        .competition-modal .modal-body p {
            color: var(--gray-medium);
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .competition-modal .competition-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .competition-modal .competition-form input,
        .competition-modal .competition-form select {
            padding: 12px 15px;
            border: 2px solid #E9ECEF;
            border-radius: 10px;
            font-size: 1rem;
            font-family: var(--font-primary);
            transition: var(--transition-fast);
        }
        
        .competition-modal .competition-form input:focus,
        .competition-modal .competition-form select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 175, 45, 0.1);
        }
    `;

    document.head.appendChild(style);
}

// Initialize all features when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Initialize all main features
    initializeNavigation();
    initializeAnimations();
    initializeVideoPlayers();
    initializeFormHandlers();
    initializeScrollEffects();
    initializeCarousels();
    initializeLazyLoading();
    initializeParallax();

    // Initialize new features
    initializeCoursesSection();
    initializeCompetitions();
    initializeCommunityFeatures();
    initializeAdvancedEffects();
    initializeSocialFeatures();
    injectModalStyles();

    // Initialize elegant particle system
    initializeElegantParticles();

    // Performance optimizations
    optimizePerformance();
});

// Inicializar efectos especiales después de que todo esté cargado
window.addEventListener('load', () => {
    addSpecialEffects();
});

/* =============================================================================
   SISTEMA DE PARTÍCULAS ELEGANTE Y PROFESIONAL
   ============================================================================= */
class ElegantParticles {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.particles = [];
        this.mouse = { x: 0, y: 0, isMoving: false };

        this.resize();
        this.createParticles();
        this.animate();
        this.addEventListeners();
    }

    resize() {
        this.canvas.width = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;
    }

    createParticles() {
        this.particles = [];
        const particleCount = Math.min(50, Math.floor((this.canvas.width * this.canvas.height) / 15000));

        for (let i = 0; i < particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * 0.5,
                vy: (Math.random() - 0.5) * 0.5,
                size: Math.random() * 2 + 1,
                opacity: Math.random() * 0.3 + 0.1,
                baseOpacity: Math.random() * 0.3 + 0.1
            });
        }
    }

    addEventListeners() {
        window.addEventListener('resize', () => this.resize());

        this.canvas.addEventListener('mousemove', (e) => {
            const rect = this.canvas.getBoundingClientRect();
            this.mouse.x = e.clientX - rect.left;
            this.mouse.y = e.clientY - rect.top;
            this.mouse.isMoving = true;

            // Efecto de repulsión - las partículas huyen del mouse
            this.particles.forEach(particle => {
                const dx = this.mouse.x - particle.x;
                const dy = this.mouse.y - particle.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < 150) {
                    const force = (150 - distance) / 150;
                    // Invertir la dirección para crear repulsión
                    particle.vx -= dx * 0.0002 * force;
                    particle.vy -= dy * 0.0002 * force;
                    particle.opacity = Math.min(particle.baseOpacity * 4, 1);
                } else {
                    particle.opacity = particle.baseOpacity;
                }
            });
        });

        this.canvas.addEventListener('mouseleave', () => {
            this.mouse.isMoving = false;
            this.particles.forEach(particle => {
                particle.opacity = particle.baseOpacity;
            });
        });
    }

    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Actualizar y dibujar partículas
        this.particles.forEach((particle, index) => {
            // Movimiento
            particle.x += particle.vx;
            particle.y += particle.vy;

            // Rebote suave en los bordes
            if (particle.x <= 0 || particle.x >= this.canvas.width) {
                particle.vx *= -0.8;
                particle.x = Math.max(0, Math.min(this.canvas.width, particle.x));
            }
            if (particle.y <= 0 || particle.y >= this.canvas.height) {
                particle.vy *= -0.8;
                particle.y = Math.max(0, Math.min(this.canvas.height, particle.y));
            }

            // Fricción sutil
            particle.vx *= 0.998;
            particle.vy *= 0.998;

            // Dibujar partícula con gradiente
            const gradient = this.ctx.createRadialGradient(
                particle.x, particle.y, 0,
                particle.x, particle.y, particle.size * 3
            );
            gradient.addColorStop(0, `rgba(99, 175, 45, ${particle.opacity})`);
            gradient.addColorStop(0.5, `rgba(42, 115, 185, ${particle.opacity * 0.6})`);
            gradient.addColorStop(1, `rgba(99, 175, 45, 0)`);

            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            this.ctx.fillStyle = gradient;
            this.ctx.fill();
        });

        // Dibujar conexiones sutiles entre partículas cercanas
        this.drawConnections();

        requestAnimationFrame(() => this.animate());
    }

    drawConnections() {
        for (let i = 0; i < this.particles.length; i++) {
            for (let j = i + 1; j < this.particles.length; j++) {
                const dx = this.particles[i].x - this.particles[j].x;
                const dy = this.particles[i].y - this.particles[j].y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < 120) {
                    const opacity = ((120 - distance) / 120) * 0.15;

                    this.ctx.beginPath();
                    this.ctx.moveTo(this.particles[i].x, this.particles[i].y);
                    this.ctx.lineTo(this.particles[j].x, this.particles[j].y);
                    this.ctx.strokeStyle = `rgba(42, 115, 185, ${opacity})`;
                    this.ctx.lineWidth = 0.5;
                    this.ctx.stroke();
                }
            }
        }
    }
}

function initializeElegantParticles() {
    const canvas = document.getElementById('particles-canvas');
    if (canvas) {
        new ElegantParticles(canvas);
    }

    // Initialize mouse hover effects for hero section
    initializeHeroMouseEffects();
}

function initializeHeroMouseEffects() {
    const hero = document.querySelector('.hero');
    const heroOverlay = document.querySelector('.hero-overlay');

    if (hero && heroOverlay) {
        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            hero.style.setProperty('--mouse-x', x + '%');
            hero.style.setProperty('--mouse-y', y + '%');
        });

        hero.addEventListener('mouseleave', () => {
            hero.style.setProperty('--mouse-x', '50%');
            hero.style.setProperty('--mouse-y', '50%');
        });
    }
}
// mapa interactivo

document.addEventListener('DOMContentLoaded', () => {
if (document.querySelector('body').getAttribute('data-page') == 'index' ){
     const tooltip = document.createElement('div');
  tooltip.id = 'tooltip';
  document.body.appendChild(tooltip);

  const areas = document.querySelectorAll('area');

  areas.forEach(area => {
    area.addEventListener('mousemove', (e) => {
      const empresas = area.dataset.empresas || '0';
    
      const comunidad =  area.getAttribute("dgfh") || 'Comunidad';

      tooltip.innerHTML = `
        <div class="tooltip-content">
          <div class="titulo">${comunidad}</div>
          <div class="dato">${empresas} empresas</div>
        </div>
      `;

      tooltip.style.left = (e.x + 15 ) + 'px';
      tooltip.style.top = (e.y) + 'px';
      tooltip.style.opacity = '1';
    });

    area.addEventListener('mouseout', () => {
      tooltip.style.opacity = '0';
    });
  });

}
});

//  document.querySelectorAll('area').forEach(function(area) {
//     area.addEventListener('mouseover', function () {
//       this._title = this.title;
//       this.removeAttribute('title');
//     });
//     area.addEventListener('mouseout', function () {
//       this.setAttribute('title', this._title);
//     });
//   });

// carusel



document.addEventListener("DOMContentLoaded", function () {
  let slideIndex = 1;
  const slides = document.getElementsByClassName("mySlides");

  function showSlides() {
    for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

    slideIndex++;
    if (slideIndex > slides.length) {
      slideIndex = 1;
    }

    slides[slideIndex - 1].style.display = "block";
      autoSlideTimeout = setTimeout(showSlides, 4000); 
  }

  function plusSlides(n) {
    clearTimeout(autoSlideTimeout);

    slideIndex += n;

    if (slideIndex > slides.length) {
      slideIndex = 1;
    }
    if (slideIndex < 1) {
      slideIndex = slides.length;
    }

    for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";

    autoSlideTimeout = setTimeout(showSlides, 4000);
  }

  // Exponer para uso en HTML onclick
  window.plusSlides = plusSlides;


  // Iniciar slideshow automático
  showSlides();
});



// let slideIndex = 0;
// showSlides();

// function showSlides() {
//   let i;
//   let slides = document.getElementsByClassName("mySlides");
//   for (i = 0; i < slides.length; i++) {
//     slides[i].style.display = "none";
//   }
//   slideIndex++;
//   if (slideIndex > slides.length) {slideIndex = 1}
//   slides[slideIndex-1].style.display = "block";
//   setTimeout(showSlides, 2000); // Change image every 2 seconds
// }


/* =============================================================================
   PASA UN DÍA CON... - GALERÍA YOUTUBE
   ============================================================================= */


//    const dia1 = document.getElementById('time1');
//    const dia2 = document.getElementById('time2');
//    const dia3 = document.getElementById('time3');

//    let dias = new Array(dia1, dia2, dia3);

// async function showDia() {

//   while (true) {

//     for (let index = 0; index < dias.length; index++) {

//      if (dias[index].style.display === "grid") {
//         dias[index].style.display = "none";
//         if (index === dias.length - 1) {
//             dias[0].style.display = "grid";
//         } else {
//             dias[index + 1].style.display = "grid";
//         }

//     } else {
//         dias[index].style.display = "none";
//     }


//   }
//     // Esperar 5 segundos antes de cambiar
//     await new Promise(resolve => setTimeout(resolve, 5000));

// }
// }
// showDia();



// const dia1 = document.getElementById('time1');
// const dia2 = document.getElementById('time2');
// const dia3 = document.getElementById('time3');

// let dias = [dia1, dia2, dia3];

// async function showDia() {
//     let index = 0;

//     // Inicializar todos ocultos
//     dias.forEach(d => {
//         d.style.display = "none";
//         d.classList.add("opacity-0");
//     });

//     while (true) {
//         const current = dias[index];

//         // Mostrar el elemento y quitar opacity-0 para transición
//         current.style.display = "grid";
//         requestAnimationFrame(() => {  // asegura que se aplique el display antes de quitar la clase
//             current.classList.remove("opacity-0");
//         });

//         // Esperar 5 segundos
//         await new Promise(resolve => setTimeout(resolve, 9000));

      
//         current.classList.add("opacity-0");
//         await new Promise(resolve => setTimeout(resolve, 4000)); // duración de la transición
//         current.style.display = "none";

//         index = (index + 1) % dias.length;
//     }
// }

// showDia();

// menu



 
document.addEventListener('DOMContentLoaded', function() {
  const boton = document.getElementById('nav-toggle');// clickar aqui 
  const menu = document.getElementById('nav-menu');  // menu
  const clickLinks = document.querySelectorAll('.nav-link');
    


    

  boton.addEventListener('click', function() {
    if (menu.style.left === '0px') {
      menu.style.left = '-100%';    
     } else {
          console.log('Toggle menu called');
          menu.style.left = 0;
 
    }
    
    

  });

    clickLinks.forEach(link => {
        link.addEventListener('click', () => {
            menu.style.left = '-100%';
            console.log('Menu closed on link click');
        });


});


});


const formbtn = document.getElementById("formbtn"); 
const checkbox = document.getElementById("privacidad"); 
const checkMark = document.getElementById("checkRequired"); 
const mnsj = document.getElementById("alertCheck"); 

formbtn.addEventListener("click", function() {
    if (!checkbox.checked) {
      
        checkMark.style.borderColor = "rgb(220, 53, 69)"; 
        mnsj.style.display = "block"; 
    } else {
        checkMark.style.borderColor = "#e1e5e9"; 
        mnsj.style.display = "none"; 
    }
});

checkbox.addEventListener("change", function() {
    if (checkbox.checked) {
        checkMark.style.borderColor = "#e1e5e9"; 
        mnsj.style.display = "none";
    } else {
        checkMark.style.borderColor = "red";
        mnsj.style.display = "block";
    }
});


const irDerecha = document.getElementById('videos-slide-right');
const irIzquierda = document.getElementById('videos-slide-left');
const slides = document.querySelector('.slides');
const slidesArray = document.querySelectorAll('.slide');

const flechaDerecha = document.getElementById('v-right');
const flechaIzquierda = document.getElementById('v-left');

let index = 0;

function mostrarSlide(nuevoIndex) {
    if (nuevoIndex < 0 || nuevoIndex >= slidesArray.length) return;

    slides.style.transform = `translateX(${-nuevoIndex * 100}%)`;
    index = nuevoIndex;

    actualizarFlechas();
}

function actualizarFlechas() {
    if (index === 0) {
        flechaIzquierda.style.color = "rgba(0,0,0,0.3)";
        flechaDerecha.style.color = "rgba(255,255,255,1)";
    } else if (index === slidesArray.length - 1) {
        flechaDerecha.style.color = "rgba(0,0,0,0.3)";
        flechaIzquierda.style.color = "rgba(255,255,255,1)";
    } else {
        flechaIzquierda.style.color = "rgba(255,255,255,1)";
        flechaDerecha.style.color = "rgba(255,255,255,1)";
    }
}

irDerecha.addEventListener("click", () => mostrarSlide(index + 1));
irIzquierda.addEventListener("click", () => mostrarSlide(index - 1));

// inicializamos colores
actualizarFlechas();
