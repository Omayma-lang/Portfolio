document.addEventListener('DOMContentLoaded', function () {
  // Mobile navigation toggle
  var navToggle = document.getElementById('navToggle');
  var siteNav = document.getElementById('siteNav');

  if (navToggle && siteNav) {
    navToggle.addEventListener('click', function () {
      var isOpen = siteNav.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  // Close mobile nav when a link is clicked
  var navLinks = document.querySelectorAll('.site-nav a');
  navLinks.forEach(function (link) {
    link.addEventListener('click', function () {
      if (siteNav && siteNav.classList.contains('open')) {
        siteNav.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });
  });

  // Lightbox for case study / gallery images
  var lightboxImages = document.querySelectorAll('.cs-gallery img');
  var lightbox = document.getElementById('lightbox');
  var lightboxImg = document.getElementById('lightboxImg');
  var lightboxCaption = document.getElementById('lightboxCaption');

  if (lightboxImages.length && lightbox) {
    lightboxImages.forEach(function (img) {
      img.addEventListener('click', function () {
        lightboxImg.src = img.src;
        if (lightboxCaption) {
          lightboxCaption.textContent = img.getAttribute('alt') || '';
        }
        lightbox.classList.add('open');
      });
    });
    lightbox.addEventListener('click', function () {
      lightbox.classList.remove('open');
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        lightbox.classList.remove('open');
      }
    });
  }

  // Admin: image previews before upload
  var imageInput = document.getElementById('images');
  var previewList = document.getElementById('imagePreview');
  if (imageInput && previewList) {
    imageInput.addEventListener('change', function () {
      previewList.innerHTML = '';
      var files = imageInput.files;
      for (var i = 0; i < files.length; i++) {
        var reader = new FileReader();
        reader.onload = (function (data) {
          return function (e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            previewList.appendChild(img);
          };
        })(files[i]);
        reader.readAsDataURL(files[i]);
      }
    });
  }
});
