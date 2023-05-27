//get element w id addProduct
const addButton = document.getElementById("addProduct");
const closeButton = document.getElementById("close");
const closeButton2 = document.getElementById("close2");

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
