jQuery(document).ready(function($) {
    var page = 2; // On commence à partir de la page 2

    $('#load-more').click(function() {
        var category = $('#category-filter').val();
        var format = $('#format-filter').val();
        var order = $('#date-order').val();

        var data = {
            action: 'load_more_photos',
            page: page,
            category: category,
            format: format,
            order: order,
        };

        $.post(ajaxurl, data, function(response) {
            if (response) {
                $('#photo-gallery').append(response); // Ajouter les nouvelles photos
                page++; // Incrémenter la page
            } else {
                $('#load-more').hide(); // Cacher le bouton si plus de photos
            }
        });
    });
});

