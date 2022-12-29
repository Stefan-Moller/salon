/* globals F1 */

/**
 * F1 Main Module - 26 Nov 2022
 *  
 * @author  C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.1.0 - FT - 10 Dec 2022
 *   - Add `--scroll-bar-width` calculation code.
 *
 */

document.addEventListener( 'DOMContentLoaded', function() {

  if ( F1.DEBUG ) console.log( 'DOM content loaded. Run init code...' );

  F1.deferred.forEach( fn => fn() ); 

  const elMain = document.querySelector( 'body > main' );
  const scrollbarWidth = elMain.parentElement.clientWidth - elMain.clientWidth;

  document.documentElement.style.setProperty( '--scrollbar-width', 
    scrollbarWidth + 'px' );

  document.querySelectorAll('.menu a').forEach(function(el) {
    if (el.getAttribute('href') === F1.page || (!el.getAttribute('href') && F1.page === 'home'))
      el.parentElement.classList.add('active');
  });

  if ( F1.DEBUG ) console.log( 'Page initialized.', 
    { F1, scrollbarWidth, elMain }, '\n\n' );

} );
