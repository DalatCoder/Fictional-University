import $ from "jquery";

class MyNotes {
  constructor() {
    this.rootURL = universityData.root_url;
    this.nonceCode = universityData.nonce;

    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote.bind(this));
  }

  // Methods will go here
  deleteNote() {
    const noteID = 104;
    const deleteAPIURL = `${this.rootURL}/wp-json/wp/v2/note/${noteID}`;
    const nonceCode = this.nonceCode || "";

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", nonceCode);
      },
      url: deleteAPIURL,
      type: "DELETE",
      success: (response) => {
        console.log("success");
        console.log(response);
      },
      error: (response) => {
        console.log("sorry");
        console.log(response);
      },
    });
  }
}

export default MyNotes;
