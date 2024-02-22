<nav class="navbar navbar-expand-md" style="background: #F5F5F5; ">
    <a class="navbar-brand text-dark" href="index.php?pagina=dashboard">Dashboard</a>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item border-right pr-2 border-dark">
                <a class="nav-link text-dark" href="index.php?pagina=companies">Companies</a>
            </li>
            <li class="nav-item dropdown border-right pr-2 border-dark">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbardrop" data-toggle="dropdown">
                    Sprint Review
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-dark" href="index.php?pagina=scoring">Scoring</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=sprintretrospective">Retrospective</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=sprintselfreflection">Selfreflection</a>
                </div>
            </li>
            <li class="nav-item dropdown border-right pr-2 border-dark">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbardrop" data-toggle="dropdown">
                    Master Data
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-dark" href="index.php?pagina=mastercompanies">Companies</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=masterproducts">Products</a>
                    <a class="dropdown-item text-dark" href="index.php?pagina=mastermembers">Members</a>
                </div>
            </li>
            <li class="nav-item border-right pr-2 no-border">
                <a class="nav-link text-dark" href="index.php?pagina=test">Judges</a>
            </li>
        </ul>

        <!-- Right-aligned item -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item navrechts">
                <a class="nav-link text-dark" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>