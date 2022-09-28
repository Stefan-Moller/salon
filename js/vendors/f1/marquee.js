var Marquee = function(selector, options) {
  var defaults = {
    autoStart: true,
    selector: '.marquee',
    scrollStripSelector: '.marquee-items',
    startedClass: 'started',
    repeatContent: true,
    paginated: false,
    scrollTime: 5000,
    pauseTime: 500,
  }
  this.options = $.extend(defaults, options);
  this.id = this.options.id || Marquee.nextID++;
  this.$el = $(selector);
  this.$elScrollStrip = this.$el.find(this.options.scrollStripSelector);
  if (this.options.autoStart) { this.start(); }
};

Marquee.nextID = 1;

Marquee.prototype = {
  addAnimationSettings: function(frameWidth, scrollWidth) {
    var animName = 'marquee-' + this.id, animTimingFn = 'linear',
    animTime = this.options.scrollTime, keyFrames = [];
    if (this.options.paginated) {
      var i, progress = 0, pageCount = Math.ceil(scrollWidth / frameWidth),
      pauseTime = this.options.pauseTime, scrollTime = this.options.scrollTime,
      pageTime = pauseTime + scrollTime, totalTime = pageTime * pageCount,
      pausePercent = pauseTime / totalTime * 100, scrollPercent = scrollTime / totalTime * 100,
      pagePercent = pausePercent + scrollPercent; animTimingFn = 'ease'; animTime = totalTime;
      for (i = 0; i < pageCount; i++) {
        var fromPercent = progress, toPercent = fromPercent + pausePercent, dx = i * frameWidth,
        keyFrame = fromPercent + '%,' + toPercent + '% { transform: translateX(-' + dx + 'px); }';
        keyFrames.push(keyFrame); progress = toPercent + scrollPercent;
      }
      // keyFrames.push('100% { transform: translateX(-' + (pageCount*frameWidth) + 'px); }');
      keyFrames.push('100% { transform: translateX(-' + scrollWidth + 'px); }');
    } else {
      keyFrames.push('from { transform: translateX(0); }');
      keyFrames.push('to { transform: translateX(-' + scrollWidth + 'px); }');
    }
    var animDef =  animName + ' { ' + keyFrames.join(' ') + ' }';
    this.$el.prepend('<style>@-webkit-keyframes ' + animDef + ' @keyframes ' + animDef + '</style>');
    this.$elScrollStrip.css('animation-name', animName);
    this.$elScrollStrip.css('animation-play-state', 'paused');
    this.$elScrollStrip.css('animation-timing-function', animTimingFn);
    this.$elScrollStrip.css('animation-iteration-count', 'infinite');
    this.$elScrollStrip.css('animation-duration', animTime + 'ms');
  },

  addFillerContent: function(frameWidth, scrollWidth) {
    var i, fillerHtml = '', contentHtml = this.$elScrollStrip.html();
    if (this.options.repeatContent) {
      var dupFactor = Math.floor(frameWidth / scrollWidth);
      for (i = 0; i < dupFactor; i++) { fillerHtml += contentHtml; }
    } else {
      fillerHtml = '<li><div style="width:' + (frameWidth - scrollWidth) + 'px"></div></li>';
    }
    var $filler = $('<div>').html(fillerHtml);
    $filler.children().each(function(index, child) { $(child).addClass('filler'); });
    this.$elScrollStrip.html(contentHtml + $filler.html());
    return this.$elScrollStrip.width();
  },

  addOffScreenFrame: function(scrollWidth) {
    var marquee = this;
    this.$elScrollStrip.children().each(function(index, el){
      var $el = $(el).clone().addClass('off-screen');
      marquee.$elScrollStrip.append($el);
    });
    return this.$elScrollStrip.width();
  },

  pause: function() { this.$elScrollStrip.css('animation-play-state', 'paused'); },

  resume: function() { this.$elScrollStrip.css('animation-play-state', 'running'); },

  start: function(startDelay) {
    var marquee = this;
    startDelay = startDelay || this.options.pauseTime || 0;
    setTimeout(function() {
      marquee.init();
      marquee.$el.addClass(marquee.options.startedClass);
      marquee.resume();
    }, marquee.options.paginated ? 0 : startDelay);
  },

  restart: function() {
    var marquee = this; clearTimeout(this.restartTimeout); marquee.pause();
    this.restartTimeout = setTimeout(function() {
      marquee.$elScrollStrip.fadeTo('fast', 0, function(){
        marquee.$el.find('.filler, .off-screen, style').remove();
        marquee.start();
        marquee.$elScrollStrip.fadeTo('slow', 1);
      }); }, 200);
  },

  bindEvents: function() {
    window.addEventListener('resize', this.restart.bind(this));
    this.$el.on('mouseenter', this.pause.bind(this));  
    this.$el.on('mouseleave', this.resume.bind(this));      
  },

  init: function() {
    var frameWidth = this.$el.width(), scrollWidth = this.$elScrollStrip.width();
    console.log('Marquee.init(),', { frameWidth, scrollWidth });
    if (scrollWidth < frameWidth) { scrollWidth = this.addFillerContent(frameWidth, scrollWidth); }
    this.addAnimationSettings(frameWidth, scrollWidth); this.addOffScreenFrame(); this.bindEvents();
  }
}