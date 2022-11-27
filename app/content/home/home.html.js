/* global F1 */

/* View Specific JS */


/* Import required F1 plugins */

import { SlideShow } from './js/vendors/f1js/slideshow/slideshow.js';


F1.deferred.push(function initPage() {

  console.log( '[Salon Home Page] Says Hi!' );

  const slideShow = new SlideShow( '.slideshow' );
  F1.components.elSlideShow = slideShow.$el[0];
  F1.controllers.slideShowCtrl = slideShow;

  slideShow.start();

});