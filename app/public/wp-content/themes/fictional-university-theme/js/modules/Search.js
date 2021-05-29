import $ from "jquery";

class Search {
  // 1. describe and initiate our object
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchInput = $("#search-term");
    this.resultsDiv = $("#search-overlay__results");

    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;

    this.typingTimer;

    this.previousValue = "";

    this.events();
  }

  // 2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    this.searchInput.on("input", this.typingLogic.bind(this));

    // ESC to close overlay
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
  }

  // 3. methods
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    this.isOverlayOpen = true;

    // Remove scroll bar
    $("body").addClass("body-no-scroll");
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    this.isOverlayOpen = false;

    // Remove scroll bar
    $("body").removeClass("body-no-scroll");
  }

  keyPressDispatcher(event) {
    var code = event.keyCode;

    // s key
    if (
      code == 83 &&
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
      this.openOverlay();
    }

    // esc key
    if (code == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }

  typingLogic() {
    /**
     * Nếu người dùng nhập các phím như: mũi tên, ... thì không cần chạy các event bên dưới
     */
    if (this.searchInput.val() == this.previousValue) {
      return;
    }

    clearTimeout(this.typingTimer);

    if (this.searchInput.val()) {
      if (!this.isSpinnerVisible) {
        this.resultsDiv.html(`<div class="spinner-loader"></div>`);
        this.isSpinnerVisible = true;
      }

      this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
      this.previousValue = this.searchInput.val();
    } else {
      this.resultsDiv.html(``);
      this.isSpinnerVisible = false;
    }
  }

  getResults() {
    const keyword = this.searchInput.val();

    const url = `http://fictional-university.local/wp-json/wp/v2/posts?search=${keyword}`;

    $.getJSON(url, (posts) => {
      if (posts.length == 0) return;

      this.resultsDiv.html(`
        <h2 class="search-overlay__section-title">General Information</h2>
        <ul class="link-list min-list">
          ${posts
            .map(
              (post) =>
                `<li><a href="${post.link}">${post.title.rendered}</a></li>`
            )
            .join("")}
        </ul>
      `);
    });

    this.isSpinnerVisible = false;
  }
}

export default Search;
