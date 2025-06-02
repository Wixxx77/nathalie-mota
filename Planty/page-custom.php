<?php 
/*
Template Name: Nath la Mota
*/
get_header(); 
?>
<div class="presentation">
    <img src="/wp-content/uploads/2024/08/Header.png" class="presentation-img" alt="Header Image">
</div>

<div class="main-filter">
    <div class="main-filter-catfor">
        <select name="categorie" id="categorie" class="postform">
            <option value="0">CATÉGORIES</option>
            <option value="concert">CONCERT</option>
            <option value="mariage">MARIAGE</option>
            <option value="reception">RÉCEPTION</option>
            <option value="television">TÉLÉVISION</option>
        </select>

        <select name="format" id="format" class="postform">
            <option value="0">FORMAT</option>
            <option value="paysage">PAYSAGE</option>
            <option value="portrait">PORTRAIT</option>
        </select>
    </div>

    <div class="main-filter-trier">
        <select name="trier" id="trier" class="postform">
            <option value="0">TRIER PAR</option>
            <option value="nouveautes">NOUVEAUTÉS</option>
            <option value="anciennetes">ANCIENNETÉS</option>
        </select>
    </div>
</div>

<div class="photographie-gallery" id="photographie-gallery">
    <?php
    // Query pour récupérer les photographies
    $args = array(
        'post_type' => 'photographie',
        'posts_per_page' => 8,
        'paged' => 1,
    );
    $the_query = new WP_Query( $args );
    
    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();

            // Récupérer l'ID de la photographie et la méta-donnée
            $photographie_id = get_the_ID();
            $format = get_post_meta($photographie_id, 'format', true); // Récupérer la méta-donnée 'format'
            $categorie = get_post_meta($photographie_id, 'categorie', true);
            $date_de_la_photo = get_post_meta($photographie_id, 'date_de_la_photo', true); // Récupérer la méta-donnée 'format'

            // Ajouter une classe par défaut si 'format' est vide
            $format_class = !empty($format) ? esc_attr($format) : 'default-format';
            $categorie_class = !empty($categorie) ? esc_attr($categorie) : 'default-categorie';
            $date_de_la_photo_class = !empty($date_de_la_photo) ? esc_attr($date_de_la_photo) : 'default-date_de_la_photo';
            ?>
            <div class="gallery-item <?php echo $format_class; ?> <?php echo $categorie_class ;?> <?php echo $date_de_la_photo_class;?>">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="gallery-thumbnail">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                </a> 
                <!-- Ajouter la classe récupérée à l'élément avec le bouton -->
                <div class="gallery-button ">
                    <a href="<?php the_permalink(); ?>" class="btn">Voir plus</a>
                </div>
            </div>
        <?php endwhile;         
        wp_reset_postdata();
    else :
        echo '<p>Aucun photographie trouvé.</p>';
    endif;
    ?>
</div>

<script> 
// Filtre des catégories
const selectedConcert = document.querySelectorAll('.MARIAGE, .RÉCEPTION, .TÉLÉVISION');
const selectedMariage = document.querySelectorAll('.CONCERT, .RÉCEPTION, .TÉLÉVISION');
const selectedReception = document.querySelectorAll('.MARIAGE, .CONCERT, .TÉLÉVISION');
const selectedTelevision = document.querySelectorAll('.MARIAGE, .RÉCEPTION, .CONCERT');

document.getElementById('categorie').addEventListener('change', function () {
    const selectedValue = this.value;

    // Réinitialise les classes liées aux catégories
    document.querySelectorAll('.CONCERT, .MARIAGE, .RÉCEPTION, .TÉLÉVISION').forEach(el => {
        el.classList.remove('displaynone-categorie');
    });

    // Applique displaynone-categorie en fonction de la sélection
    if (selectedValue === 'concert') {
        selectedConcert.forEach(el => el.classList.add('displaynone-categorie'));
    } else if (selectedValue === 'mariage') {
        selectedMariage.forEach(el => el.classList.add('displaynone-categorie'));
    } else if (selectedValue === 'reception') {
        selectedReception.forEach(el => el.classList.add('displaynone-categorie'));
    } else if (selectedValue === 'television') {
        selectedTelevision.forEach(el => el.classList.add('displaynone-categorie'));
    }
});

// Filtre des formats
const selectedPORTRAIT = document.querySelectorAll('.PAYSAGE');
const selectedPAYSAGE = document.querySelectorAll('.PORTRAIT');

document.getElementById('format').addEventListener('change', function () {
    const selectedValue = this.value;

    // Réinitialise les classes liées aux formats
    document.querySelectorAll('.PORTRAIT, .PAYSAGE').forEach(el => {
        el.classList.remove('displaynone-format');
    });

    // Applique displaynone-format en fonction de la sélection
    if (selectedValue === 'portrait') {
        selectedPORTRAIT.forEach(el => el.classList.add('displaynone-format'));
    } else if (selectedValue === 'paysage') {
        selectedPAYSAGE.forEach(el => el.classList.add('displaynone-format'));
    }                                                             
});


//  Filtre des date 
document.getElementById('trier').addEventListener('change', function () {
    const selectedValue = this.value;

    // Sélectionne tous les éléments à trier
    const items = Array.from(document.querySelectorAll('.gallery-item'));

    // Trie selon la valeur sélectionnée
    if (selectedValue === 'nouveautes') {
        // Trier en ordre décroissant (années récentes en premier)
        items.sort((a, b) => parseInt(b.className.match(/\b\d{4}\b/)) - parseInt(a.className.match(/\b\d{4}\b/)));
    } else if (selectedValue === 'anciennetes') {
        // Trier en ordre croissant (années anciennes en premier)
        items.sort((a, b) => parseInt(a.className.match(/\b\d{4}\b/)) - parseInt(b.className.match(/\b\d{4}\b/)));
    }

    // Réorganise les éléments triés dans le DOM
    const parent = document.getElementById('photographie-gallery');
    items.forEach(item => parent.appendChild(item));z
});
categoryFilter.addEventListener('change', applyFiltersAndSort);
formatFilter.addEventListener('change', applyFiltersAndSort);
sortFilter.addEventListener('change', applyFiltersAndSort);

//script du bouton  

</script>

<button class="button" id="load-more" data-page="1">Charger plus</button>



                                                                                                                            

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        