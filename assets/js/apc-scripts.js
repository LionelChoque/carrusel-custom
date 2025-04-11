/**
 * Advanced Post Carousel - Frontend Scripts
 */
(function($) {
    'use strict';
    
    /**
     * Inicializa todos los carruseles en la página
     */
    function initCarousels() {
        // Detecta todos los carruseles configurados en la página
        for (var key in window) {
            if (key.indexOf('apc_config_') === 0) {
                var config = window[key];
                initSingleCarousel(config);
            }
        }
    }
    
    /**
     * Inicializa un carrusel individual con su configuración específica
     */
    function initSingleCarousel(config) {
        var $carousel = $('#' + config.id);
        
        if ($carousel.length === 0) {
            return;
        }
        
        // Configuración predeterminada del carrusel
        var slickOptions = {
            slidesToShow: config.slidesToShow || 3,
            slidesToScroll: config.slidesToScroll || 1,
            autoplay: config.autoplay || false,
            autoplaySpeed: config.autoplaySpeed || 3000,
            dots: config.dots || false,
            arrows: config.arrows || true,
            infinite: true,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: Math.min(config.slidesToShow, 3),
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: Math.min(config.slidesToShow, 2),
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        };
        
        // Inicializar el carrusel con Slick
        $carousel.slick(slickOptions);
    }
    
    // Inicializar cuando el DOM esté listo
    $(document).ready(function() {
        initCarousels();
    });
    
})(jQuery);