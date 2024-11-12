const menuButton = document.querySelector(".menu-button");
const drawer = document.getElementById("drawer");
const closeButton = document.querySelector(".close-button");

// I open the drawer when the user clicks the menu button
menuButton.addEventListener("click", () => {
  drawer.classList.add("open");
  menuButton.style.display = "none";
});

// I close the drawer when the user clicks the close button
closeButton.addEventListener("click", () => {
  drawer.classList.remove("open");
  menuButton.style.display = "flex";
});

// I close the drawer when the user clicks outside the drawer
document.addEventListener("click", (e) => {
  if (!drawer.contains(e.target) && !menuButton.contains(e.target)) {
    drawer.classList.remove("open");
    menuButton.style.display = "flex";
  }
});

// I submit the prayer request form using fetch API
const form = document.getElementById("prayerRequestForm");
form.addEventListener("submit", function (event) {
  event.preventDefault();

  const formData = new FormData(form);
  fetch("index.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      showToast(
        `Thank you, ${form.name.value}. Your prayer request has been submitted. STWC will be genuinely praying over your request.`
      );
      form.reset();
      document.body.style.overflow = "auto";
      modal.style.display = "none";
    })
    .catch((error) => {
      showToast("Failed to submit prayer request. Please try again.");
    });
});

// I show a toast message at the bottom of the screen
function showToast(message, type = "success") {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.className = "toast show";

  if (type === "error") {
    toast.style.backgroundColor = "#ff0000";
  } else {
    toast.style.backgroundColor = "#4CAF50";
  }
  setTimeout(() => {
    toast.className = toast.className.replace("show", "");
  }, 3000);
}

// I fade in the elements when they are in the viewport
// to give an entrance effect
document.addEventListener("DOMContentLoaded", function () {
  const elements = document.querySelectorAll(".fade-in-up");

  function checkVisibility() {
    elements.forEach((element) => {
      const rect = element.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom >= 0) {
        element.classList.add("visible");
      }
    });
  }

  window.addEventListener("scroll", checkVisibility);
  window.addEventListener("resize", checkVisibility);

  checkVisibility();
});

// I flip the cards in the TSCA section so that the back of the card is shown
// with the description of the title
const cards = document.querySelectorAll(".card");
cards.forEach((card) => {
  card.addEventListener("click", function () {
    card.classList.toggle("flip");
  });
});

// I handle the modal for the prayer request form
const modal = document.getElementById("modal");
const openModalBtn = document.getElementById("open-modal-button");
const closeModalBtn = document.querySelector(".close-button-modal");

modal.addEventListener("click", function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
    document.body.style.overflow = "auto";
  }
});

openModalBtn.addEventListener("click", function () {
  modal.style.display = "block";
  document.body.style.overflow = "hidden";
});

closeModalBtn.addEventListener("click", function () {
  modal.style.display = "none";
  document.body.style.overflow = "auto";
});

window.addEventListener("click", function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
    document.body.style.overflow = "auto";
  }
});
