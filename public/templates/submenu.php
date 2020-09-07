<section class="section">
    <div class="container">

        <div id="heading">
            <h2>DVDs in my collection</h2>
        </div>

        <div class="submenu">
            <ul>
                <li class="col total">
                    <p class="">Displaying <b>
                    <?php
                    // display total number of DVDs showing
                    printf($statement->rowCount());
                    ?>
                    </b> results</p>
                </li>

                <li class="col query">
                    <form method="post">
                        <input type="search" id="search" name="query" placeholder="Search for a DVD">
                        <button type="submit" class="goBtn" name="search">
                            <i class="fas fa-search"></i>
                        </button>
                        <p>OR</p>
                        <input class="clearBtn" type="submit" name="submit" value="View all">
                    </form>
                </li>            
            </ul>
        </div>