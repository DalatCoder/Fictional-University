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

    const professorID = currentLikeBox.data("professor");
    const likeExists = currentLikeBox.data("exists") == "yes";

    if (likeExists) this.deleteLike(professorID);
    else this.createLike(professorID);
  }

  createLike(professorID) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: this.apiURL,
      type: "POST",
      data: {
        professorID: professorID,
      },
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike(professorID) {
    $.ajax({
      url: this.apiURL,
      type: "DELETE",
      data: {
        professorID: professorID,
      },
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
