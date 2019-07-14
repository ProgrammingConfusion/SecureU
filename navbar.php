</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">Secure<span class="text-primary">U</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="<?php if ($page_title == 'Homepage') {
                                    echo 'active';
                                } ?> nav-item">
                        <a class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li class="<?php if ($page_title == 'Courses') {
                                    echo 'active';
                                } ?> nav-item">
                        <a class="nav-link" href="courses.php">Courses</a>
                    </li>
                    <li class="<?php if ($page_title == 'Forum') {
                                    echo 'active';
                                } ?> nav-item">
                        <a class="nav-link" href="forum.php">Forum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div></div>
    <br>
    <br>
    <br>