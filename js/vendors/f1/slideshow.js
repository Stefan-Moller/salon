var F1 = window.F1 || {};
(function (window, $, F1) {
var Slideshow = function (selector, options) {
  var self = this, activeSlideIndex = 0, $el = $(selector);
  var defaults = { autoStart: false, showSlideDuration: 7000, transitionDuration: 900 };
  this.$el = $el; this.options = $.extend(defaults, options);
  if ( ! this.$el.length) { throw new Error('Slideshow error... Can\'t find element "' + selector + '"'); }
  this.$elSlides = $el.find('.slides'); this.$slides = this.$elSlides.find('> *');
  if ( ! this.$slides.length) { throw new Error('Slideshow error... No slides to show!'); }
  this.$activeSlide = this.$elSlides.find('.show').first();
  if (this.$activeSlide.length) { activeSlideIndex = this.$activeSlide.index(); }
  else { this.$activeSlide = this.$slides.first(); this.$activeSlide.addClass('show'); }
  this.$indicatorsZone = $el.find('.indicators');
  this.useIndicators = this.$indicatorsZone.length;
  if (this.useIndicators) {
    this.$slides.each(function (indicatorIndex) {
      var $indicator = $('<i><label>' + (indicatorIndex + 1) + '</label></i>');
      if (indicatorIndex === activeSlideIndex) {
        self.$activeIndicator = $indicator;
        $indicator.addClass('show');
      }
      self.$indicatorsZone.append($indicator);
      $indicator.on('click', function (event) {
        if (self.busy) {
         // Stop all animations in progress with $.finish()
          self.$activeSlide.finish();
          self.$nextSlide.finish();
        }
        self.stopTimer(event);
        self.gotoSlide(self.$slides.eq(indicatorIndex));
      });
    });
  }
  this.$indicators = this.$indicatorsZone.find('i');
  this.$prevBtn = $el.find('.prev-slide');
  this.$nextBtn = $el.find('.next-slide');
  if (this.$prevBtn.length && this.$nextBtn.length) {
    this.$prevBtn.on('click', function (event) { self.stopTimer(event); self.gotoNextSlide(-1 * self.options.direction); });
    this.$nextBtn.on('click', function (event) { self.stopTimer(event); self.gotoNextSlide(self.options.direction); });
  }
  if (this.options.autoStart) { this.start(); }
};

Slideshow.prototype.stopTimer = function (event) {
  event.preventDefault();
  if (this.timer) { clearInterval(this.timer); this.timer = undefined; }
};

Slideshow.prototype.start = function (showSlideDuration, transitionDuration, direction) {
  var self = this, opts = this.options, timerDuration = opts.showSlideDuration - opts.transitionDuration;
  if (showSlideDuration) { opts.showSlideDuration = showSlideDuration; }
  if (transitionDuration) { opts.transitionDuration = transitionDuration; }
  opts.direction = (typeof direction === 'undefined') ? 1 : direction;
  console.log('SlideShow start(),', opts); 
  this.timer = setTimeout(function () {
    self.gotoNextSlide(opts.direction);
    console.log('Initial Start Timeout, Says Hi!');
    self.timer = setInterval(function () { console.log('Interval Timeout, Says Hi!'); 
      self.gotoNextSlide(opts.direction); }, timerDuration);
  }, timerDuration);
};

Slideshow.prototype.gotoSlide = function ($nextSlide) {
  var $nextIndicator, self = this, opts = this.options;
  this.busy = true;
  this.$nextSlide = $nextSlide;
  this.$activeSlide.css({ 'opacity': 1 });
  this.$activeSlide.animate({ 'opacity': 0 }, opts.transitionDuration, undefined, function() {
    self.$activeSlide.removeClass('show').css({ 'visibility': 'hidden' });
  });
  $nextSlide.css({ 'opacity': 0, 'visibility': 'visible' });
  $nextSlide.animate({ 'opacity': 1 }, opts.transitionDuration, undefined, function() {
    self.$activeSlide.finish();
    self.$activeSlide = $nextSlide;
    $nextSlide.addClass('show');
    self.busy = false;
  });
  if (this.useIndicators) {
    if (this.$activeIndicator) { this.$activeIndicator.removeClass('show'); }
    $nextIndicator = this.$indicators.eq($nextSlide.index());
    $nextIndicator.addClass('show');
    this.$activeIndicator = $nextIndicator;
  }
};

Slideshow.prototype.gotoNextSlide = function (direction) {
  direction = direction || this.options.direction;
  console.log('gotoNextSlide, direction =', direction, ', activeSlide =', this.$activeSlide);
  var $nextSlide;
  if (this.busy) {
    // Stop all animations in progress with $.finish()
    this.$activeSlide.finish();
    this.$nextSlide.finish();
  }
  $nextSlide = (this.$activeSlide && this.$activeSlide.length)
    ? ((direction > 0) ? this.$activeSlide.next() : this.$activeSlide.prev())
    : this.$slides.eq(0);
  if ( ! $nextSlide.length ) {
    $nextSlide = (direction > 0) ? this.$slides.eq(0) : this.$slides.eq(this.$slides.length - 1);
  }
  this.gotoSlide($nextSlide);
};
// end: Slideshow
F1.Slideshow = Slideshow;
}(window, jQuery, F1));