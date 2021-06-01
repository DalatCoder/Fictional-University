import $ from "jquery";

class Like {
  constructor() {
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

  createLike() {}

  deleteLike() {}
}

export default Like;
