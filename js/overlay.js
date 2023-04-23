const addButton = document.getElementById("add");
const closeButton = document.getElementById("close");
const closeButton2 = document.getElementById("close2");

addButton.addEventListener("click", () => {
  const hiddenSection = document.querySelector("#add-section");
  hiddenSection.classList.toggle("hidden");
});

closeButton.addEventListener("click", () => {
  console.log("clicked");
  const hiddenSection = document.querySelector("#add-section");
  hiddenSection.classList.toggle("hidden");
});

closeButton2.addEventListener("click", () => {
    console.log("clicked");
    const hiddenSection = document.querySelector("#add-section");
    hiddenSection.classList.toggle("hidden");
  });
