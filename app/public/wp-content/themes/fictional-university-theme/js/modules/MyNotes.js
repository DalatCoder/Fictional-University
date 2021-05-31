import $ from "jquery";

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote.bind(this));
  }

  // Methods will go here
  deleteNote() {
    alert("delete");
  }
}

export default MyNotes;
