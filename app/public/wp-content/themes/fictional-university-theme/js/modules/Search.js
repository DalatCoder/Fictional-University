import $ from 'jquery'

class Search {
  // 1. describe and initiate our object
  constructor() {
    this.openButton = $('.js-search-trigger')
    this.closeButton = $('.search-overlay__close')
    this.searchOverlay = $('.search-overlay')

    this.isOverlayOpen = false;

    this.events();
  }

  // 2. events
  events() {
    this.openButton.on('click', this.openOverlay.bind(this))
    this.closeButton.on('click', this.closeOverlay.bind(this))

    // ESC to close overlay
    $(document).on('keydown', this.keyPressDispatcher.bind(this))
  }

  // 3. methods
  openOverlay() {
    this.searchOverlay.addClass('search-overlay--active')
    this.isOverlayOpen = true;

    // Remove scroll bar
    $('body').addClass('body-no-scroll')
  }

  closeOverlay() {
    this.searchOverlay.removeClass('search-overlay--active')
    this.isOverlayOpen = false;

    // Remove scroll bar
    $('body').removeClass('body-no-scroll')
  }

  keyPressDispatcher(event) {
    var code = event.keyCode;

    // s key
    if (code == 83 && !this.isOverlayOpen) {
      this.openOverlay()
    }

    // esc key
    if (code == 27 && this.isOverlayOpen) {
      this.closeOverlay()
    }
  }
}

export default Search
