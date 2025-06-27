jQuery(document).ready(function($) {
    // Quand un filtre change
    $('#category-filter, #format-filter, #date-order').change(function() {
        // Récupérer les valeurs des filtres
        var category = $('#category-filter').val();
        var format = $('#format-filter').val();
        var order = $('#date-order').val();

        // Réinitialiser les photos et le numéro de page
        $('#photo-gallery').html('');
        var page = 1; // Commencer à partir de la première page

        // Envoi de la requête AJAX pour filtrer les photos
        var data = {
            action: 'load_more_photos',
            page: page,
            category: category,
            format: format,
            order: order
        };

        $.post(ajaxurl, data, function(response) {
            if (response) {
                $('#photo-gallery').html(response); // Charger les photos filtrées
                $('#load-more').show(); // Afficher le bouton "Charger plus"
            } else {
                $('#load-more').hide(); // Cacher le bouton "Charger plus" si aucune photo
            }
        });
    });
});
jQuery(document).ready(function($) {
    $('select').select2(); // ou cible un select spécifique
});



// afficher une fenetre modal, afficher tout les articles,  faire en  sorte que les  filtres marchent , reuissir a charger plus 