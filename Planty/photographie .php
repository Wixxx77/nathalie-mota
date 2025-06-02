<?php
/* Template Name: Photographies */
get_header(); 
?>
<div class="presentation">
    <img src="/wp-content/uploads/2024/08/Header.png" class="presentation-img" alt="Header Image">
</div>
<main>
<form id="photo-filters">
    <div class="selecteur">
    <select id="category-filter">
        <option value="">catégorie</option>
        <?php 
            $categories = get_terms(array('taxonomy' => 'categorie', 'hide_empty' => false));
            foreach ($categories as $category) {
                echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
            }
        ?>
    </select>

    <select id="format-filter">
        <option value="">format</option>
        <?php 
            $formats = get_terms(array('taxonomy' => 'format', 'hide_empty' => false));
            foreach ($formats as $format) {
                echo '<option value="' . $format->term_id . '">' . $format->name . '</option>';
            }
        ?>
    </select>
        </div>
        <div class="trie">
    <select id="date-order">
        <option value="desc">Du plus récent au plus ancien</option>
        <option value="asc">Du plus ancien au plus récent</option>
    </select>
        </div>
</form>

<div id="photo-gallery">
    <?php
    // Afficher les 8 premières photos
    $args = array(
        'post_type' => 'photographie',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => 1, // Première page
    );

    // Vérifier si des filtres sont appliqués
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'id',
                'terms' => $_GET['category'],
                'operator' => 'IN',
            ),
        );
    }

    if (isset($_GET['format']) && !empty($_GET['format'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'id',
            'terms' => $_GET['format'],
            'operator' => 'IN',
        );
    }

    // Exécution de la requête WP
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
            <div class="photo-item">
                    <img src="<?php echo esc_url($photo_url); ?>" class='item' alt="<?php the_title(); ?>">
                    <div class="overlay">
                    <div class="overlay-center"><a href="<?php the_permalink(); ?>"><i class="fa-regular fa-eye" style="color: #ffffff;"></i></a></div> 
                    <div class="overlay-top-right open-lightbox" 
                        data-image="<?php echo esc_url($photo_url); ?>" 
                        data-reference="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>" 
                        data-categorie="<?php echo get_post_meta(get_the_ID(), 'categorie', true); ?>">
                        <i class="fa-solid fa-expand" style="color: #ffffff;"></i>
                        </div>
                        <div class="overlay-bottom-left"><?php the_title(); ?></div>
                        <div class="overlay-bottom-right">
                        <?php $categories = get_the_terms(get_the_ID(), 'categorie'); // Récupère les catégories de CETTE photo
                            if (!empty($categories) && !is_wp_error($categories)) {
                                echo esc_html($categories[0]->name); // Affiche la catégorie de CETTE photo
                            } else {
                                echo 'Non classé'; // Si aucune catégorie n'est trouvée
                            }?>
                        </div>

                    </div>
               
            </div>
            <?php
        endwhile;
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    
    wp_reset_postdata();
?>    
</div>

<div id="photo-lightbox" class="lightbox-modal">
    <div class="lightbox-content">
        <span class="lightbox-close">&times;</span>
        <img id="lightbox-image" src="" alt="Photo en grand"></div>
        <div class="lightbox-navigation">
            <button id="lightbox-prev"><i class="fa-solid fa-arrow-left"> </i> precedent</button>
            <button id="lightbox-next">suivant <i class="fa-solid fa-arrow-right"></i></i></button>
        </div>
        
    
    <div class="lightbox-info">
            <div class="lightbox-meta-left" id="lightbox-reference"></div>
            <div class="lightbox-meta-right" id="lightbox-categorie"></div>
        </div>
</div>


<button id="load-more">Chargez plus</button>
</main>
<?php get_footer(); ?>



















