/* globals F1 */

/**
 * F1 Main Module - 26 Nov 2022
 *  
 * @author  C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - REL - 26 Nov 2022
 *   - Initial version
 *
 */

document.addEventListener( 'DOMContentLoaded', function() {

  if ( F1.DEBUG ) console.log( 'DOM content loaded. Run init code...' );

  F1.deferred.forEach( fn => fn() ); 

  if ( F1.DEBUG ) console.log( 'Page initialized. F1:', F1, '\n\n' );

} );
