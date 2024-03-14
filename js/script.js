// HEADER

function showDropdownMenu(element) {
  var dropdownMenu = element.querySelector(".dropdown-menu");
  if (dropdownMenu) {
    dropdownMenu.classList.add("show");
  }
}

function hideDropdownMenu(element) {
  var dropdownMenu = element.querySelector(".dropdown-menu");
  if (dropdownMenu) {
    dropdownMenu.classList.remove("show");
  }
}

// SCORING

function searchScoringTable() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("scoringTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function addScore() {
  // Redirect to addretro.php
  window.location.href = "index.php?pagina=addscore";
}

// ADD SCORE

document.addEventListener("DOMContentLoaded", function () {
  var pointsInput = document.getElementById("points");

  pointsInput.addEventListener("input", function () {
    var pointsValue = this.value;
    // Regular expression to allow only whole or decimal numbers
    var regex = /^\d*\.?\d*$/;

    if (!regex.test(pointsValue)) {
      // Clear the input value if it doesn't match the regex
      this.value = pointsValue.slice(0, -1);
    }
  });
});

// RETROSPECTIVES

function searchRetroTable() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("retroTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function addRetrospective() {
  // Redirect to addretro.php
  window.location.href = "index.php?pagina=addretro";
}

// ADD RETROSPECTIVES

document.addEventListener('DOMContentLoaded', function () {
  // Get the "Sprint" input element
  var sprintInput = document.getElementById('sprint');

  // Add an input event listener to the "Sprint" input
  sprintInput.addEventListener('input', function () {
      // Remove non-numeric characters
      this.value = this.value.replace(/[^0-9]/g, '');

      // Convert the input value to an integer
      var intValue = parseInt(this.value);

      // If the input value is not NaN, update it with the rounded integer
      if (!isNaN(intValue)) {
          this.value = intValue;
      }
  });
});

// REFLECTION

function searchReflectionTable() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("reflectionTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function addReflection() {
  // Redirect to addreflection.php
  window.location.href = "index.php?pagina=addreflection";
}

//ADD REFLECTION

document.addEventListener('DOMContentLoaded', function () {
  // Get the "Sprint" input element
  var sprintInput = document.getElementById('sprint');

  // Add an input event listener to the "Sprint" input
  sprintInput.addEventListener('input', function () {
      // Remove non-numeric characters
      this.value = this.value.replace(/[^0-9]/g, '');
  });
});
