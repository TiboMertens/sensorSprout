// get the hamburger id
const hamburger = document.getElementById("hamburger");
//get the menu id
const menu = document.getElementById("menu");

//add event listener to the hamburger
hamburger.addEventListener("click", () => {
  //toggle the active class to the menu
  //rotate the hamburger 90 degrees
  hamburger.classList.toggle("rotate");
  menu.classList.toggle("hidden");
});
