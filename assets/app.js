/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.css";
import "tw-elements";
import Like from "./scripts/like";

document.addEventListener("DOMContentLoaded", () => {
  const dropdownMenuButton2 = document.getElementById("dropdownMenuButton2");
  const dropdownMenu2 = document.querySelector(".dropdown-menu");
  dropdownMenuButton2.addEventListener("click", function (e) {
    e.preventDefault();
    dropdownMenu2.classList.toggle("hidden");
  });

  const likeElements = [].slice.call(
    document.querySelectorAll("a[data-action='like']")
  );

  if (likeElements) {
    new Like(likeElements);
  }
});
