<?php
get_header(); 
// Récupérer l'ID de l'article actuel
$article_id = get_the_ID();

// Récupérer et afficher chaque sous-champ directement
?>
<div class="single-page">
<div class="informations-photo">
<div class="informations">
<?php // Format

echo '<h1>' . get_the_title() . '</h1>';


$format = get_post_meta($article_id, 'format', true);
if (!empty($format)) {
    echo '<p><strong>Format :</strong> ' . esc_html($format) . '</p>';
}

// Référence
$reference = get_post_meta($article_id, 'reference', true);
if (!empty($reference)) {
    echo '<p><strong>Référence :</strong> <span id="laRef"> ' . esc_html($reference) . ' </span> </p>';
}

// Catégorie
$categorie = get_post_meta($article_id, 'categorie', true);
if (!empty($categorie)) {
    echo '<p><strong>Catégorie :</strong> ' . esc_html($categorie) . '</p>';
}

// Type
$type = get_post_meta($article_id, 'type', true);
if (!empty($type)) {
    echo '<p><strong>Type :</strong> ' . esc_html($type) . '</p>';
}

// Date de la photo
$date_de_la_photo = get_post_meta($article_id, 'date_de_la_photo', true);
if (!empty($date_de_la_photo)) {
    echo '<p><strong>Date :</strong> ' . esc_html($date_de_la_photo) . '</p>';
}?>
</div>
<div class="main-photo">
<?php
// Photo (image)
$photo_id = get_post_meta($article_id, 'photo', true);
if (!empty($photo_id)) {
    $image_url = wp_get_attachment_image_url($photo_id, 'full');
    if ($image_url) {
        
        echo '<img class="photo-principale" src="' . esc_url($image_url) . '" alt="Image associée">';
    }
}
?>
</div>
</div>




<div class="contact">
            <p>Cette photo vous intéresse ?</p>
            <button class="contact-bouton" id="menu-item-623" >Contact</button>
        
        <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
        ?>
        <div class="navigation-post">
    <?php if (!empty($prev_post)) : ?>
        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-btn prev-btn">
            <i class="fa-solid fa-arrow-left arrow"> </i>
        </a>
    <?php endif; ?>

    <?php if (!empty($next_post)) : ?>
        <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-btn next-btn">
            <i class="fa-solid fa-arrow-right arrow"> </i>
        </a>
    <?php endif; ?>
        </div>
</div>





<?php
// Récupérer les catégories du CPT actuel
$terms = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));

if (!empty($terms)) {
    // Préparer la requête pour récupérer 2 autres CPT photographie avec la même catégorie
    $args = array(
        'post_type'      => 'photographie',
        'posts_per_page' => 2,
        'post__not_in'   => array(get_the_ID()), // Exclure le post actuel
        'orderby'        => 'rand', // Trier aléatoirement
        'tax_query'      => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'term_id',
                'terms'    => $terms,
            ),
        ),
    );

    $similar_query = new WP_Query($args);
?>  
<div class="last-part">
<?php
    if ($similar_query->have_posts()) :
        echo '<div class="similar-photographies"><h3>VOUS AIMEREZ AUSSI :</h3><div class="photo-list">';
        
         while ($similar_query->have_posts()) : $similar_query->the_post(); ?>
    <div class="photo-item">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <div class="photo-thumbnail">
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>">
                    
                </div>
            <?php endif; ?>
            <div class="overlay">
                    <div class="overlay-center"><a href="<?php the_permalink(); ?>"><i class="fa-regular fa-eye" style="color: #ffffff;"></i></a></div> 
                    <div class="overlay-top-right open-lightbox" 
                        data-image="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" 
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
        </a>
    </div>
<?php endwhile; 


        echo '</div></div>';
        wp_reset_postdata();
    endif;
}
?>

</div>
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
        <?php get_footer(); ?>