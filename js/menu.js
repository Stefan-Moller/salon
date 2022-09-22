F1.deferred.push(function initMainMenu() {
  document.querySelectorAll('.menu a').forEach(function(el) {
    if (el.getAttribute('href') === F1.page)
      el.parentElement.classList.add('active');
  });
});
