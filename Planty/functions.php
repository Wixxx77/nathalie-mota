<?php
function mon_theme_enqueue_select2() {
    // CSS Select2
    wp_enqueue_style(
        'select2-css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
    );

    // JS Select2
    wp_enqueue_script(
        'select2-js',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        ['jquery'],
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_select2');

function enqueue_custom_scripts() {
    // Enregistrer jQuery (c'est souvent déjà fait par défaut, mais on le rajoute pour être sûr)
    wp_enqueue_script('jquery');

    // Enregistrer le script des filtres (filters.js)
    wp_enqueue_script('filter-script', get_stylesheet_directory_uri() . '/filter.js', array('jquery'), null, true);
    
    // Enregistrer le script de "Charger plus" (load-more.js)
    wp_enqueue_script('load-more-script', get_stylesheet_directory_uri() . '/load-more.js', array('jquery'), null, true);
   
    wp_enqueue_script('modal-script', get_stylesheet_directory_uri() . '/modal.js', array('jquery'), null, true);
    
    // Passer l'URL admin-ajax.php à JavaScript pour l'appel AJAX
    wp_localize_script('load-more-script', 'ajaxurl', admin_url('admin-ajax.php'));
    wp_localize_script('filter-script', 'ajaxurl', admin_url('admin-ajax.php'));
    // Enregistrer Font Awesome via CDN
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts', 10);

function ajouter_polices_google_personnalisees() {
    wp_enqueue_style(
        'google-fonts-custom',
        'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'ajouter_polices_google_personnalisees');


function load_more_photos() {
    $paged = isset($_POST['page']) ? $_POST['page'] : 1; // Page actuelle
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $order = isset($_POST['order']) ? $_POST['order'] : 'DESC';

    // Arguments pour la requête WP
    $args = array(
        'post_type' => 'photographie',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => $order,
    );

    // Ajouter des conditions de filtrage si nécessaire
    $tax_query = array('relation' => 'AND');
    if ($category) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field' => 'id',
            'terms' => $category,
            'operator' => 'IN',
        );
    }
    if ($format) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field' => 'id',
            'terms' => $format,
            'operator' => 'IN',
        );
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    // Requête WP
    $query = new WP_Query($args);

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }
    
    // Requête WP
    $query = new WP_Query($args);
    
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
            <div class="photo-item">
                <img src="<?php echo esc_url($photo_url); ?>" class='item' alt="<?php the_title(); ?>">
                <div class="overlay">
                    <div class="overlay-center">
                        <a href="<?php the_permalink(); ?>">
                            <i class="fa-regular fa-eye" style="color: #ffffff;"></i>
                        </a>
                    </div>
                    <div class="overlay-top-right open-lightbox" 
                        data-image="<?php echo esc_url($photo_url); ?>" 
                        data-reference="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>" 
                        data-categorie="<?php echo get_post_meta(get_the_ID(), 'categorie', true); ?>">
                        <i class="fa-solid fa-expand" style="color: #ffffff;"></i>
                        </div>
                        <div class="overlay-bottom-left"><?php the_title(); ?></div>
                    <div class="overlay-bottom-right">
                        <?php 
                        // Récupère les catégories de cette photo
                        $categories = get_the_terms(get_the_ID(), 'categorie'); 
                        if (!empty($categories) && !is_wp_error($categories)) {
                            echo esc_html($categories[0]->name); // Affiche la catégorie
                        } else {
                            echo 'Non classé'; // Si aucune catégorie n'est trouvée
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
    endif;
    
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');?>


