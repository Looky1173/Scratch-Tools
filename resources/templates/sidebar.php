<div class="sidebar">
    <!-- Content -->
    <div class="content">
        <?php
        /*
    $_SESSION['username'] = "TEST";
    echo $_SESSION['username'];
    */

        $user = new HandleUsers($db);
        if ($user->isLoggedIn() == false) {
            echo '
        <div class="text-center">
            <img src="/img/scratch-cat-transparent-background.gif" width="100px" height="100px" alt="Scratch Cat pixel art">
        </div>
        <h2 class="content-title">
            You are signed out
        </h2>
        <p class="text-justify">
            You are signed out of your Scratch Tools account. In order to access this panel and get the most out of this
            website, please sign in or register. Click on the button below to continue.
        </p>
        <a href="login" class="btn btn-primary btn-block" role="button">Let\'s go!</a>';
        } else {
            $username = $_SESSION['username'];
            //Get the profile picture of the logged in user
            $response = file_get_contents("https://api.scratch.mit.edu/users/" . $username);
            $response = json_decode($response, true);
            $profilePicture = $response["profile"]["images"]["90x90"];
            echo '
        <div class="text-center">
            <img src="' . $profilePicture . '" width="100px" height="100px" alt="Your profile picture">
        </div>
        <h2 class="content-title">
            Welcome back, ' . $username . '!
        </h2>
        <p class="text-justify">
            Hello there! Now that you are logged in, you may access all the features of the website.
        </p>
        <a href="/dashboard" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fas fa-sliders-h" aria-hidden="true"></i>
            </span>
            Dashboard
        </a>
        <a href="/search" class="sidebar-link sidebar-link-with-icon">
            <span class="sidebar-icon">
                <i class="fas fa-search" aria-hidden="true"></i>
            </span>
            Search
        </a>';
        }
        ?>
    </div>
</div>