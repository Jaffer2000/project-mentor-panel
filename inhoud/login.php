<body class="login">

    <div class="login-container">
        <div class="login-title">LOGIN</div>

        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>
        <form action="login_process.php" method="post" autocomplete="off">
            <input type="text" id="username" name="username" placeholder="Username" required autocomplete="off">
            <input type="password" id="password" name="password" placeholder="Password" required autocomplete="off">
            <button type="submit">LOGIN</button>
        </form>
    </div>

</body>

</html>