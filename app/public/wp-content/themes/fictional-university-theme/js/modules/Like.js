import $ from "jquery";

class Like {
  constructor() {
    this.apiURL = `${universityData.root_url}/wp-json/university/v1/manageLike`;
    this.events();
  }

  events() {
    $(".like-box").on("click", this.ourClickDispatcher.bind(this));
  }

  // Methods
  ourClickDispatcher(event) {
    const currentLikeBox = $(event.target).closest(".like-box");

    const likeExists = currentLikeBox.data("exists") == "yes";

    if (likeExists) this.deleteLike();
    else this.createLike();
  }

  createLike() {
    $.ajax({
      url: this.apiURL,
      type: "POST",
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike() {
    $.ajax({
      url: this.apiURL,
      type: "DELETE",
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default Like;
