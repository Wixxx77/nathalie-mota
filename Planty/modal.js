document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("nous-contacter");
    const link = document.querySelector(".menu-item-623");
    const boutonContact = document.querySelector(".contact-bouton");

    // ✅ Ajout d'un event listener sur TOUS les éléments .close (au cas où y'en aurait plusieurs)
    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("close")) {
            modal.style.display = "none";
        }
    });

    if (link && modal) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            modal.style.display = "block";
        });
    }

    if (boutonContact && modal) {
        boutonContact.addEventListener("click", function () {
            const laRef = document.querySelector("#laRef")?.innerHTML;
            const input = document.querySelector("#ff_3_input_text");
            if (laRef && input) {
                input.value = laRef;
            }
            modal.style.display = "block";
        });
    }

    // Fermer si clic à l'extérieur de la modale
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});



//modale 2


document.addEventListener("DOMContentLoaded", function () {
    const lightbox = document.getElementById("photo-lightbox");
    const lightboxImage = document.getElementById("lightbox-image");
    const closeLightbox = document.querySelector(".lightbox-close");
    const nextLightbox = document.getElementById("lightbox-next");
    const prevLightbox = document.getElementById("lightbox-prev");
    let currentIndex = 0;
    let photoItems = [];

    // Ouvrir la modale photo
    document.body.addEventListener("click", function (e) {
        const target = e.target.closest(".open-lightbox");
        if (target) {
            e.preventDefault();      // Empêche le clic d'ouvrir un lien (si dans un <a>)
            e.stopPropagation();     // Évite que l’événement "remonte" à d’autres éléments
    
            // Recrée la liste complète des éléments .open-lightbox (y compris ceux ajoutés dynamiquement)
            photoItems = Array.from(document.querySelectorAll(".open-lightbox"));
    
            // Trouve l'index de celui sur lequel on a cliqué
            currentIndex = photoItems.indexOf(target);
    
            // Met à jour l'image de la modale
            updateLightbox();
    
            // Affiche la modale
            lightbox.style.display = "flex";
        }
    });
    


    // Fermer la modale
    closeLightbox.addEventListener("click", function () {
        lightbox.style.display = "none";
    });

    // Changer d'image
    function updateLightbox() {
        if (photoItems.length > 0) {
            const item = photoItems[currentIndex];
    
            // Met l'image dans la lightbox
            lightboxImage.src = item.dataset.image;
    
            // Met à jour les infos texte
            const ref = item.dataset.reference || "Référence manquante";
            const cat = item.dataset.categorie || "Catégorie manquante";
    
            document.getElementById("lightbox-reference").textContent = ref;
            document.getElementById("lightbox-categorie").textContent = cat;
        }
    }
    

    nextLightbox.addEventListener("click", function () {
        currentIndex = (currentIndex + 1) % photoItems.length;
        updateLightbox();
    });

    prevLightbox.addEventListener("click", function () {
        currentIndex = (currentIndex - 1 + photoItems.length) % photoItems.length;
        updateLightbox();
    });

    // Fermer la modale en cliquant en dehors de l'image
    lightbox.addEventListener("click", function (e) {
        if (e.target === lightbox) {
            lightbox.style.display = "none";
        }
    });
});


