class Draggables {


  dragging = false

  initialX = undefined
  initialY = undefined
  currentX = undefined
  currentY = undefined

  elDraggableParent = undefined


  constructor(options) {

    const self = this;
    this.opts = options || {};
    var draggables = document.querySelectorAll(this.opts.selector);
    draggables.forEach(function(elDraggable) {
      elDraggable.setAttribute('draggable', '');
      elDraggable.addEventListener('touchstart', self.dragStart, false);
      elDraggable.addEventListener('touchend'  , self.dragEnd  , false);
      elDraggable.addEventListener('mousedown' , self.dragStart, false);
      elDraggable.addEventListener('mouseup'   , self.dragEnd  , false);
    });
    document.addEventListener('touchmove', this.drag, false);
    document.addEventListener('mousemove', this.drag, false);

  }


  dragStart(event) {

    const xOffset, yOffset;

    if (event.target.hasAttribute('draggable'))
    {
      this.elDraggableParent = event.target.parentElement;
      
      if (this.elDraggableParent.getAttribute('data-xOffset'))
      { xOffset = this.elDraggableParent.getAttribute('data-xOffset'); }
      else { this.elDraggableParent.setAttribute('data-xOffset', 0); xOffset = 0; }

      if (this.elDraggableParent.getAttribute('data-yOffset'))
      { yOffset = this.elDraggableParent.getAttribute('data-yOffset'); }
      else { this.elDraggableParent.setAttribute('data-yOffset', 0); yOffset = 0;  }
      
      if (event.type === 'touchstart') {
        this.initialX = event.touches[0].clientX - xOffset;
        this.initialY = event.touches[0].clientY - yOffset;
      } else {
        this.initialX = event.clientX - xOffset;
        this.initialY = event.clientY - yOffset;
      }
      
      elDraggableParent.setAttribute('data-initialX', this.initialX);
      elDraggableParent.setAttribute('data-initialY', this.initialY);

      this.dragging = true;
    }

  }


  dragEnd(event) {

    if (event.target.hasAttribute('draggable'))
    {
      this.currentX = this.elDraggableParent.getAttribute('data-currentX');
      this.currentY = this.elDraggableParent.getAttribute('data-currentY');
  
      this.initialX = this.currentX;
      this.initialY = this.currentY;
  
      this.elDraggableParent.setAttribute('data-initialX', this.initialX);
      this.elDraggableParent.setAttribute('data-initialY', this.initialY);

      this.dragging = false;
    }

  }


  drag(event) {

    if (this.dragging)
    {
      event.preventDefault();
      const initialX = this.elDraggableParent.getAttribute('data-initialX');
      const initialY = this.elDraggableParent.getAttribute('data-initialY');
      if (event.type === 'touchmove') {
        this.currentX = e.touches[0].clientX - initialX;
        this.currentY = e.touches[0].clientY - initialY
      } else {
        this.currentX = e.clientX - initialX;
        this.currentY = e.clientY - initialY;
        this.elDraggableParent.style.transform = 'translate3d(' + this.currentX + 'px, ' + this.currentY + 'px, 0)';
        this.elDraggableParent.setAttribute('data-currentX', this.currentX);
        this.elDraggableParent.setAttribute('data-currentY', this.currentY);
        const xOffset = this.currentX;
        const yOffset = this.currentY;
        this.elDraggableParent.setAttribute('data-xOffset', xOffset);
        this.elDraggableParent.setAttribute('data-yOffset', yOffset);
    }

  }


  isTouchSupport() {

    return 'ontouchstart' in window || navigator.MaxTouchPoints > 0 || navigator.msMaxTouchPoints > 0

  }

}