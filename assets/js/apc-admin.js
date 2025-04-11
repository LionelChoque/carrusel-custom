/**
 * Advanced Post Carousel - Admin Scripts
 */
(function($) {
    'use strict';
    
    /**
     * Maneja la funcionalidad de pestañas en la página de administración
     */
    function initTabs() {
        $('.apc-tab-button').on('click', function(e) {
            e.preventDefault();
            
            // Eliminar la clase "active" de todos los botones y contenidos
            $('.apc-tab-button').removeClass('active');
            $('.apc-tab-content').removeClass('active');
            
            // Agregar la clase "active" al botón actual
            $(this).addClass('active');
            
            // Mostrar el contenido de la pestaña correspondiente
            var tabId = $(this).data('tab');
            $('#' + tabId + '-tab').addClass('active');
        });
    }
    
    /**
     * Inicializa los selectores de color
     */
    function initColorPickers() {
        if ($.fn.wpColorPicker) {
            $('.apc-color-picker').wpColorPicker();
        }
    }
    
    // Inicializar cuando el DOM esté listo
    $(document).ready(function() {
        initTabs();
        initColorPickers();
    });
    
})(jQuery);