import axios from "axios";
import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
  const initSlider = () => {
    const slides = document.querySelectorAll(".hero-slide");
    let currentIndex = 0; // Track the current slide
    const totalSlides = slides.length;

    function moveToSlide(n) {
      slides.forEach((slide, index) => {
        slide.style.transform = `translateX(${-100 * n}%)`;
        if (n === index) {
          slide.classList.add("active");
        } else {
          slide.classList.remove("active");
        }
      });
      currentIndex = n;
    }

    // Function to go to the next slide
    function nextSlide() {
      if (currentIndex === totalSlides - 1) {
        moveToSlide(0); // Go to the first slide if we're at the last
      } else {
        moveToSlide(currentIndex + 1);
      }
    }

    // Function to go to the previous slide
    function prevSlide() {
      if (currentIndex === 0) {
        moveToSlide(totalSlides - 1); // Go to the last slide if we're at the first
      } else {
        moveToSlide(currentIndex - 1);
      }
    }

    // Example usage with buttons
    // Assuming you have buttons with classes `.next` and `.prev` for navigation
    const carouselNextButton = document.querySelector(".hero-slide-next");
    if (carouselNextButton) {
      carouselNextButton.addEventListener("click", nextSlide);
    }
    const carouselPrevButton = document.querySelector(".hero-slide-prev");
    if (carouselPrevButton) {
      carouselPrevButton.addEventListener("click", prevSlide);
    }

    // Initialize the slider
    moveToSlide(0);
  };

  const initImagePicker = () => {
    const fileInput = document.querySelector("#carFormImageUpload");
    const imagePreview = document.querySelector("#imagePreviews");
    if (!fileInput) {
      return;
    }
    fileInput.onchange = (ev) => {
      imagePreview.innerHTML = "";
      const files = ev.target.files;
      for (let file of files) {
        readFile(file).then((url) => {
          const img = createImage(url);
          imagePreview.append(img);
        });
      }
    };

    function readFile(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (ev) => {
          resolve(ev.target.result);
        };
        reader.onerror = (ev) => {
          reject(ev);
        };
        reader.readAsDataURL(file);
      });
    }

    function createImage(url) {
      const a = document.createElement("a");
      a.classList.add("car-form-image-preview");
      a.innerHTML = `
        <img src="${url}" />
      `;
      return a;
    }
  };

  const initMobileNavbar = () => {
    const btnToggle = document.querySelector(".btn-navbar-toggle");

    btnToggle.onclick = () => {
      document.body.classList.toggle("navbar-opened");
    };
  };

  const imageCarousel = () => {
    const carousel = document.querySelector('.car-images-carousel');
    if (!carousel) {
      return;
    }
    const thumbnails = document.querySelectorAll('.car-image-thumbnails img');
    const activeImage = document.getElementById('activeImage');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');


    let currentIndex = 0;

    // Initialize active thumbnail class
    thumbnails.forEach((thumbnail, index) => {
      if (thumbnail.src === activeImage.src) {
        thumbnail.classList.add('active-thumbnail');
        currentIndex = index;
      }
    });

    // Function to update the active image and thumbnail
    const updateActiveImage = (index) => {
      activeImage.src = thumbnails[index].src;
      thumbnails.forEach(thumbnail => thumbnail.classList.remove('active-thumbnail'));
      thumbnails[index].classList.add('active-thumbnail');
    };

    // Add click event listeners to thumbnails
    thumbnails.forEach((thumbnail, index) => {
      thumbnail.addEventListener('click', () => {
        currentIndex = index;
        updateActiveImage(currentIndex);
      });
    });

    // Add click event listener to the previous button
    prevButton.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
      updateActiveImage(currentIndex);
    });

    // Add click event listener to the next button
    nextButton.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % thumbnails.length;
      updateActiveImage(currentIndex);
    });
  }

  const initMobileFilters = () => {
    const filterButton = document.querySelector('.show-filters-button');
    const sidebar = document.querySelector('.search-cars-sidebar');
    const closeButton = document.querySelector('.close-filters-button');

    if (!filterButton) return;

    console.log(filterButton.classList)
    filterButton.addEventListener('click', () => {
      if (sidebar.classList.contains('opened')) {
        sidebar.classList.remove('opened')
      } else {
        sidebar.classList.add('opened')
      }
    });

    if (closeButton) {
      closeButton.addEventListener('click', () => {
        sidebar.classList.remove('opened')
      })
    }
  }

  const initCascadingDropdown = (parentSelector, childSelector) => {
    const parentDropdown = document.querySelector(parentSelector);
    const childDropdown = document.querySelector(childSelector);

    if (!parentDropdown || !childDropdown) return;

    hideModelOptions(parentDropdown.value)

    parentDropdown.addEventListener('change', (ev) => {
      hideModelOptions(ev.target.value)
      childDropdown.value = ''
    });

    function hideModelOptions(parentValue) {
      const models = childDropdown.querySelectorAll('option');
      models.forEach(model => {
        if (model.dataset.parent === parentValue || model.value === '') {
          model.style.display = 'block';
        } else {
          model.style.display = 'none';
        }
      });
    }
  }

  /**
   * Initialise dropdown de tri sur la page search.blade
   */
  const initSortingDropdown = () => {
    const sortingDropdown = document.querySelector('.sort-dropdown');
    if (!sortingDropdown) return;

    // Init sorting dropdown with the current value
    // Récupère l'URL actuelle et vérifie si le param de tri "sort" est déja présent
    const url = new URL(window.location.href);
    const sortValue = url.searchParams.get('sort');
    // Si "sort" présent, la valeur est attribuée a la dropdown ce qui permet de voir l'option de tri sélectionnée
    if (sortValue) {
      sortingDropdown.value = sortValue;
    }
    // Gestion du changement de tri qd nouvelle valeur est sélectionnée
    sortingDropdown.addEventListener('change', (ev) => {
      const url = new URL(window.location.href);
      // Met à jour le param "sort" dans l'URL
      url.searchParams.set('sort', ev.target.value);
      // Redirige la page vers cette nouvelle URL ce qui peut recharger la page avec le bon param de tri
      window.location.href = url.toString();
    });
  }

  /**
   * Clic sur le button pour ajouter aux favoris sans que ça scroll vers le haut
   */
  const initAddToWatchlist = () => {
    // Select add to watchlist buttons
    const buttons = document.querySelectorAll('.btn-heart')
    // si le button n'existe pas on return
    if (!buttons) return

    // Iterate over these buttons and add click event listener
    buttons.forEach((button)  => {
      button.addEventListener('click', e => {
        // Get the button element on which click happened
        const button = e.currentTarget
        // We added data-url attribute to the button in blade file
        // get the url
        const url = button.dataset.url
        // Make request on the URL to add or remove the car from watchlist
        axios.post(url).then((response) => {
          // Select les 2 balises svg sur le button
          const toShow = button.querySelector('svg.hidden')
          const toHide = button.querySelector('svg:not(.hidden)')

          // Ce qui était caché doit être affiché
          toShow.classList.remove('hidden')
          // Ce qui était affiché doit être masqué
          toHide.classList.add('hidden')
          // Show alert to the user
          alert(response.data.message)
        })
          .catch(error => {
            console.error(error.response)
            // si error.response existe et si error.response.status = 401
            if (error?.response?.status === 401) {
              alert("Please authenticate first to add cars into watchlist.")
            } else {
              alert("Internal Server Error. Please Try again later!")
            }
          })
      })
    })
  }

  /**
   * Permet d'afficher le n° de tél en entier sur la page car détails
   */
  const initShowPhoneNumber = () => {
    // Select the element we need to listen to click
    const span = document.querySelector('.car-details-phone-view')

    span.addEventListener('click', ev => {
      ev.preventDefault()
      // Get the url on which we should make Ajax request
      const url = span.dataset.url
      // Make the request to the server and fetch phone number
      axios.post(url).then(response => {
        // Get response from backend and take actual phone number
        const phone = response.data.phone
        // Find the <a> element
        const a = span.parentElement
        // and update its href attribute with full phone number received from backend
        a.href = 'tel:' + phone
        // Recherchez l'élément qui contient du texte obscurci et le mettre à jour
        const phoneElt = a.querySelector('.text-phone')
        phoneElt.innerText = phone
      })
    })

  }

  initSlider();
  initImagePicker();
  initMobileNavbar();
  imageCarousel();
  initMobileFilters();
  initCascadingDropdown('#makerSelect', '#modelSelect');
  initCascadingDropdown('#stateSelect', '#citySelect');
  initSortingDropdown()
  initAddToWatchlist()
  initShowPhoneNumber()

  ScrollReveal().reveal(".hero-slide.active .hero-slider-title", {
    delay: 200,
    reset: true,
  });
  ScrollReveal().reveal(".hero-slide.active .hero-slider-content", {
    delay: 200,
    origin: "bottom",
    distance: "50%",
  });
});
