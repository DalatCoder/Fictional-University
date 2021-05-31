import $ from "jquery";

class MyNotes {
  constructor() {
    this.rootURL = universityData.root_url;
    this.nonceCode = universityData.nonce;
    this.editable = false;

    this.events();
  }

  events() {
    $("#my-notes").on("click", ".delete-note", this.deleteNote.bind(this));
    $("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
    $("#my-notes").on("click", ".update-note", this.updateNote.bind(this));
    $(".submit-note").on("click", this.createNote.bind(this));
  }

  // Methods will go here
  createNote() {
    const createAPIUrl = `${this.rootURL}/wp-json/wp/v2/note`;
    const nonceCode = this.nonceCode || "";

    const newNote = {
      title: $(".new-note-title").val(),
      content: $(".new-note-body").val(),
      status: "public",
    };

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", nonceCode);
      },
      url: createAPIUrl,
      data: newNote,
      type: "POST",
      success: (response) => {
        const newNoteID = response.id;
        const newNoteTitle = response.title.raw;
        const newNoteContent = response.content.raw;

        $(".new-note-title, .new-note-body").val("");
        $(`
            <li data-id="${newNoteID}">
                <input readonly class="note-title-field" type="text" value="${newNoteTitle}">
                <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                <textarea readonly class="note-body-field" name="" id="" cols="30" rows="10">${newNoteContent}</textarea>
                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
            </li>
        `)
          .prependTo("#my-notes")
          .hide()
          .slideDown();

        console.log(response);
      },
      error: (response) => {
        console.log("sorry");
        console.log(response);
      },
    });
  }

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

  updateNote(event) {
    const thisNote = $(event.target).parents("li");

    const noteID = thisNote.data("id");
    const updateAPIUrl = `${this.rootURL}/wp-json/wp/v2/note/${noteID}`;
    const nonceCode = this.nonceCode || "";

    const updatedPost = {
      title: thisNote.find(".note-title-field").val(),
      content: thisNote.find(".note-body-field").val(),
    };

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", nonceCode);
      },
      url: updateAPIUrl,
      data: updatedPost,
      type: "POST",
      success: (response) => {
        this.makeNoteReadonly(thisNote);
        console.log(response);
      },
      error: (response) => {
        console.log("sorry");
        console.log(response);
      },
    });
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
