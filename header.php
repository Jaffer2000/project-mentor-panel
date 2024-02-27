<nav class="navbar navbar-expand-md" style="background: #F5F5F5;">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item pr-2">
                <a class="nav-link text-dark" href="index.php?pagina=dashboard">Dashboard</a>
            </li>
            <li class="nav-item pr-2">
                <a class="nav-link text-dark" href="index.php?pagina=companies">Companies</a>
            </li>
            <li class="nav-item dropdown pr-2" onmouseover="showDropdownMenu(this)" onmouseout="hideDropdownMenu(this)">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbardrop1">
                    Sprint Review
                </a>
                <div class="dropdown-menu" aria-labelledby="navbardrop1">
                    <a class="dropdown-item text-dark" href="index.php?pagina=scoring">Scoring</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=retrospectives">Retrospective</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=sprintselfreflection">Reflection</a>
                </div>
            </li>
            <li class="nav-item dropdown pr-2" onmouseover="showDropdownMenu(this)" onmouseout="hideDropdownMenu(this)">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbardrop2">
                    Master Data
                </a>
                <div class="dropdown-menu" aria-labelledby="navbardrop2">
                    <a class="dropdown-item text-dark" href="index.php?pagina=mastercompanies">Companies</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=masterproducts">Products</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=mastermembers">Members</a>
                </div>
            </li>
            <li class="nav-item pr-2">
                <a class="nav-link text-dark" href="index.php?pagina=test">Judges</a>
            </li>
        </ul>

        <!-- Right-aligned item -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item navrechts pr-5">
                <a class="nav-link text-dark" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>

<script>
function showDropdownMenu(element) {
    var dropdownMenu = element.querySelector('.dropdown-menu');
    if (dropdownMenu) {
        dropdownMenu.classList.add('show');
    }
}

function hideDropdownMenu(element) {
    var dropdownMenu = element.querySelector('.dropdown-menu');
    if (dropdownMenu) {
        dropdownMenu.classList.remove('show');
    }
}
</script>