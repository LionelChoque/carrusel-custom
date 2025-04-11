<?php
/**
 * Plantilla predeterminada para el carrusel de posts
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="apc-carousel-wrapper">
    <div id="<?php echo esc_attr($carousel_id); ?>" class="apc-carousel">
        <?php while ($carousel_query->have_posts()): $carousel_query->the_post(); ?>
            <div class="apc-slide">
                <div class="apc-post-card" style="background-color: <?php echo esc_attr($options['card_bg_color']); ?>; border-radius: <?php echo esc_attr($options['card_border_radius']); ?>;">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="apc-post-thumbnail">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="apc-post-content">
                        <?php if ($options['show_category'] === 'yes' && has_category()): ?>
                            <div class="apc-post-category">
                                <?php the_category(', '); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="apc-post-title" style="color: <?php echo esc_attr($options['title_color']); ?>; font-size: <?php echo esc_attr($options['title_font_size']); ?>;">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <!-- Metadatos y contenido del post -->
                        <!-- Contenido abreviado por espacio -->
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>