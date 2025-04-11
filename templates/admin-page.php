<?php
// Evitar el acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Obtener opciones guardadas
$options = get_option('apc_settings');

// Manejar mensajes de éxito
if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
    echo '<div class="notice notice-success is-dismissible"><p>' . __('Configuración guardada correctamente.', 'advanced-post-carousel') . '</p></div>';
}
?>

<div class="wrap apc-admin-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <form method="post" action="options.php">
        <?php
        settings_fields('apc_settings_group');
        ?>
        
        <div class="apc-admin-tabs">
            <div class="apc-tab-nav">
                <button type="button" class="apc-tab-button active" data-tab="general"><?php _e('General', 'advanced-post-carousel'); ?></button>
                <button type="button" class="apc-tab-button" data-tab="carousel"><?php _e('Carrusel', 'advanced-post-carousel'); ?></button>
                <button type="button" class="apc-tab-button" data-tab="style"><?php _e('Estilo', 'advanced-post-carousel'); ?></button>
                <button type="button" class="apc-tab-button" data-tab="content"><?php _e('Contenido', 'advanced-post-carousel'); ?></button>
            </div>
            
            <!-- Pestaña General -->
            <div class="apc-tab-content active" id="general-tab">
                <h2><?php _e('Configuración General', 'advanced-post-carousel'); ?></h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="apc_post_type"><?php _e('Tipo de Post', 'advanced-post-carousel'); ?></label>
                        </th>
                        <td>
                            <select name="apc_settings[post_type]" id="apc_post_type">
                                <?php 
                                $post_types = get_post_types(['public' => true], 'objects');
                                foreach ($post_types as $post_type) {
                                    $selected = ($options['post_type'] === $post_type->name) ? 'selected="selected"' : '';
                                    echo '<option value="' . esc_attr($post_type->name) . '" ' . $selected . '>' . esc_html($post_type->label) . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <!-- Más opciones de configuración general -->
                </table>
            </div>
            
            <!-- Otras pestañas: Carrusel, Estilo, Contenido -->
            <!-- Contenido abreviado por espacio -->
        </div>
        
        <?php submit_button(); ?>
    </form>
    
    <div class="apc-shortcode-info">
        <h2><?php _e('Uso del Shortcode', 'advanced-post-carousel'); ?></h2>
        <p><?php _e('Para usar el carrusel en cualquier página o post, usa el siguiente shortcode:', 'advanced-post-carousel'); ?></p>
        <code>[post_carousel]</code>
        
        <h3><?php _e('Atributos personalizables', 'advanced-post-carousel'); ?></h3>
        <ul>
            <li><code>slides_to_show="3"</code> - <?php _e('Número de slides a mostrar a la vez', 'advanced-post-carousel'); ?></li>
            <li><code>category="noticias"</code> - <?php _e('Filtrar por slug de categoría', 'advanced-post-carousel'); ?></li>
            <li><code>tag="destacados"</code> - <?php _e('Filtrar por slug de etiqueta', 'advanced-post-carousel'); ?></li>
            <li><code>layout="default"</code> - <?php _e('Diseño a utilizar (default, grid, list)', 'advanced-post-carousel'); ?></li>
        </ul>
        
        <h4><?php _e('Ejemplo completo:', 'advanced-post-carousel'); ?></h4>
        <code>[post_carousel slides_to_show="4" category="noticias" layout="grid" posts_per_page="12"]</code>
    </div>
</div>