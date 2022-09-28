F1.deferred.push(function initMainMenu() {
  document.querySelectorAll('.menu a').forEach(function(el) {
    if (el.getAttribute('href') === F1.page || (!el.getAttribute('href') && F1.page === 'home'))
      el.parentElement.classList.add('active');
  });
});
