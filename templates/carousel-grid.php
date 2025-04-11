<?php
/**
 * Plantilla de cuadrícula para el carrusel de posts
 * 
 * Esta plantilla muestra los posts en un formato de cuadrícula
 * dentro del carrusel.
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="apc-carousel-wrapper apc-grid-layout">
    <div id="<?php echo esc_attr($carousel_id); ?>" class="apc-carousel">
        <?php while ($carousel_query->have_posts()): $carousel_query->the_post(); ?>
            <div class="apc-slide">
                <div class="apc-grid-card" style="background-color: <?php echo esc_attr($options['card_bg_color']); ?>; border-radius: <?php echo esc_attr($options['card_border_radius']); ?>;">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="apc-grid-thumbnail">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                            
                            <?php if ($options['show_category'] === 'yes' && has_category()): ?>
                                <div class="apc-grid-category">
                                    <?php 
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="apc-grid-content">
                        <h3 class="apc-grid-title" style="color: <?php echo esc_attr($options['title_color']); ?>; font-size: <?php echo esc_attr($options['title_font_size']); ?>;">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <div class="apc-grid-meta">
                            <?php if ($options['show_date'] === 'yes'): ?>
                                <span class="apc-grid-date">
                                    <i class="dashicons dashicons-calendar-alt"></i>
                                    <?php the_time(get_option('date_format')); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($options['show_author'] === 'yes'): ?>
                                <span class="apc-grid-author">
                                    <i class="dashicons dashicons-admin-users"></i>
                                    <?php the_author(); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($options['excerpt_length'] > 0): ?>
                            <div class="apc-grid-excerpt">
                                <?php 
                                $excerpt = wp_trim_words(get_the_excerpt(), $options['excerpt_length'], '...');
                                echo $excerpt;
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($options['read_more_text'])): ?>
                            <a href="<?php the_permalink(); ?>" class="apc-grid-read-more">
                                <?php echo esc_html($options['read_more_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>