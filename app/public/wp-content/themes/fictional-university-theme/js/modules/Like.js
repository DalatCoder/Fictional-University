import $ from "jquery";

class Like {
  constructor() {
    this.apiURL = `${universityData.root_url}/wp-json/university/v1/manageLike`;
    this.events();

    this.isLike = $(".like-box").data("exists") === "yes";
    console.log(this.isLike);
  }

  events() {
    $(".like-box").on("click", this.ourClickDispatcher.bind(this));
  }

  // Methods
  ourClickDispatcher(event) {
    const currentLikeBox = $(event.target).closest(".like-box");

    if (this.isLike) this.deleteLike(currentLikeBox);
    else this.createLike(currentLikeBox);
  }

  createLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: this.apiURL,
      type: "POST",
      data: {
        professorID: currentLikeBox.data("professor"),
      },
      success: (response) => {
        this.isLike = true;
        console.log(response);
        console.log(this.isLike);

        currentLikeBox.attr("data-exists", "yes");
        currentLikeBox.attr("data-like", response);

        const likeCount = currentLikeBox.find(".like-count").html() * 1;
        currentLikeBox.find(".like-count").html((likeCount + 1).toString());
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: this.apiURL,
      type: "DELETE",
      data: {
        likeID: currentLikeBox.data("like"),
        professorID: currentLikeBox.data("professor"),
      },
      success: (response) => {
        this.isLike = false;
        console.log(this.isLike);
        console.log(response);

        currentLikeBox.attr("data-exists", "no");

        const likeCount = currentLikeBox.find(".like-count").html() * 1;
        currentLikeBox.find(".like-count").html((likeCount - 1).toString());
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default Like;
