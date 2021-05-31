import $ from "jquery";

class MyNotes {
  constructor() {
    this.rootURL = universityData.root_url;
    this.nonceCode = universityData.nonce;
    this.editable = false;

    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote.bind(this));
    $(".edit-note").on("click", this.editNote.bind(this));
  }

  // Methods will go here
  editNote(event) {
    const thisNote = $(event.target).parents("li");

    this.editable = !this.editable;

    if (this.editable) this.makeNoteEditable(thisNote);
    else this.makeNoteReadonly(thisNote);
  }

  makeNoteEditable(thisNote) {
    thisNote.find(".edit-note").html(`
      <i class="fa fa-times" aria-hidden="true"></i> Cancel
    `);

    thisNote
      .find(".note-title-field, .note-body-field")
      .removeAttr("readonly")
      .addClass("note-active-field");

    thisNote.find(".update-note").addClass("update-note--visible");
  }

  makeNoteReadonly(thisNote) {
    thisNote.find(".edit-note").html(`
      <i class="fa fa-pencil" aria-hidden="true"></i> Edit
    `);

    thisNote
      .find(".note-title-field, .note-body-field")
      .attr("readonly", "readonly")
      .removeClass("note-active-field");

    thisNote.find(".update-note").removeClass("update-note--visible");
  }

  deleteNote(event) {
    const thisNote = $(event.target).parents("li");

    const noteID = thisNote.data("id");
    const deleteAPIURL = `${this.rootURL}/wp-json/wp/v2/note/${noteID}`;
    const nonceCode = this.nonceCode || "";

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", nonceCode);
      },
      url: deleteAPIURL,
      type: "DELETE",
      success: (response) => {
        thisNote.slideUp();
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
