import $ from "jquery";

class Search {
  // 1. describe and initiate our object
  constructor() {
    this.addSearchHTML();

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

    this.searchInput.val("");
    setTimeout(() => {
      this.searchInput.focus();
    }, 301);
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

      this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      this.previousValue = this.searchInput.val();
    } else {
      this.resultsDiv.html(``);
      this.isSpinnerVisible = false;
    }
  }

  getResults() {
    const keyword = this.searchInput.val();
    const namespace = "university";
    const version = "v1";
    const route = "search";

    const apiURL = `${universityData.root_url}/wp-json/${namespace}/${version}/${route}?term=${keyword}`;

    $.getJSON(apiURL, (results) => {
      this.resultsDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              results.generalInfo.length
                ? `
                  <ul class="link-list min-list">
                    ${results.generalInfo
                      .map((result) => {
                        const title = result.title;
                        const link = result.permalink;
                        const postType = result.postType;
                        const authorName = result.authorName;

                        const authorNameString =
                          postType === "post" ? `by ${authorName}` : "";

                        return `<li><a href="${link}">${title}</a> ${authorNameString}</li>`;
                      })
                      .join("")}
                  </ul>
              `
                : `
                  <p>No general information matches that search.</p>
                `
            }      
          </div>

          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${
              results.programs.length
                ? `
                  <ul class="link-list min-list">
                    ${results.programs
                      .map((result) => {
                        const title = result.title;
                        const link = result.permalink;

                        return `<li><a href="${link}">${title}</a></li>`;
                      })
                      .join("")}
                  </ul>
              `
                : `
                  <p>
                    No programs match that search.
                    <a href="${universityData.root_url}/programs">View all programs</a>
                  </p>
                `
            }      

            <h2 class="search-overlay__section-title">Professors</h2>

          </div>

          <div class="one-third">
            <h2 class="search-overlay__section-title">Campuses</h2>
            ${
              results.campuses.length
                ? `
                  <ul class="link-list min-list">
                    ${results.campuses
                      .map((result) => {
                        const title = result.title;
                        const link = result.permalink;

                        return `<li><a href="${link}">${title}</a></li>`;
                      })
                      .join("")}
                  </ul>
              `
                : `
                  <p>
                    No campuses match that search.
                    <a href="${universityData.root_url}/campuses">View all campuses</a>
                  </p>
                `
            }      

            <h2 class="search-overlay__section-title">Events</h2>

          </div>
        </div> 
      `);

      this.isSpinnerVisible = false;
    });
  }

  addSearchHTML() {
    $("body").append(`
      <div class="search-overlay">
        <div class="search-overlay__top">
            <div class="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                <input type="text" class="search-term" id="search-term" placeholder="What are you looking for?" autocomplete="off" autofocus>
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
        </div>

        <div class="container">
            <div id="search-overlay__results">
            </div>
        </div>
      </div>
    `);
  }
}

export default Search;
