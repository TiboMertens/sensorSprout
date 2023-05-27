const addButton = document.getElementById("add");
const add = document.getElementById("addProduct");
const closeButton = document.getElementById("close");
const closeButton2 = document.getElementById("close2");
const form = document.getElementById("search-form");

let state = add.getAttribute("data-id");

addButton.addEventListener("click", () => {
  const hiddenSection = document.querySelector("#add-section");
  hiddenSection.classList.toggle("hidden");
});

closeButton.addEventListener("click", () => {
  const hiddenSection = document.querySelector("#add-section");
  hiddenSection.classList.toggle("hidden");
});

closeButton2.addEventListener("click", () => {
  const hiddenSection = document.querySelector("#add-section");
  hiddenSection.classList.toggle("hidden");
});

//get the form state
const formState = form.getAttribute("data-id");

if (formState == "search") {
  const hiddenSection = document.querySelector("#add-section");
  hiddenSection.classList.toggle("hidden");
}
