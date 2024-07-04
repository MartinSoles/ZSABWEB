    <?php
    $json_file = './data/rodice/rodice.json'; // Cesta k vašemu JSON souboru

    if (file_exists($json_file)) {
        $json_data = file_get_contents($json_file);
        $news = json_decode($json_data, true);

    } else {
        $news = [];
    }
    ?>

    <!DOCTYPE html>
    <html lang="cs">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ZŠAB | Spolek </title>
        <link rel="stylesheet" type="text/css" href="./styles/normalize.css" />
        <link rel="stylesheet" type="text/css" href="./styles/style.css" />
        <link rel="stylesheet" type="text/css" href="./styles/media.css" />
        <link rel="stylesheet" type="text/css" href="./styles/spolek.css" />
    </head>
    <script>
        function toggleMenu() {
            var menuNavbar = document.querySelector('.menu-navbar');
            menuNavbar.classList.toggle('active');
        }
        function toggleList(){
            var menuNavbar = document.querySelector('.menu-navbar-list-dropdown');
            menuNavbar.classList.toggle('active');
        }
    </script>
    <body>
        <header class="header">
            <img class="logo" src="./images/logo.png" alt="logo školy">
            <h1>Základní škola Antonína Bratršovského</h1>
            <a class="menu-navbar-icon" onclick="toggleMenu();">☰</a>
            <menu class="menu-navbar">
                <div class="menu-navbar-top">
                    <a class="menu-navbar-top-close" id="cross-nav" onclick="toggleMenu();">❌</a>
                    
                    <img id="menu-navbar-top-close-logo"class="logo" src="./images/logo.png" alt="logo školy">
                </div>  
                <ul class="menu-navbar-list">
                    <li><a class="menu-navbar-list-button" onclick="toggleList();"> O škole</a>
                        <ul class="menu-navbar-list-dropdown">
                            <li class="menu-navbar-list-dropdown-item">Charakteristika školy</li>
                            <li class="menu-navbar-list-dropdown-item">Vize a hodnoty školy</li>
                            <li class="menu-navbar-list-dropdown-item">Organizace školního roku</li>
                            <li class="menu-navbar-list-dropdown-item">Projekty</li>
                            <li class="menu-navbar-list-dropdown-item">Úspěchy našich žáků</li>
                            <li class="menu-navbar-list-dropdown-item">Historie školy</li>
                        </ul>
                    </li>
                    <li><a href="#">Dokumenty školy</a></li>
                    <li><a href="#">Zájmové vzdělávání</a></li>
                    <li><a href="#">Spolek pro podporu ZŠAB</a></li>
                    <li><a href="#">Pro uchazeče</a></li>
                    <li><a href="#">Stravování</a></li>
                    <li><a href="#">Kontakty</a></li>
                </ul>
            </menu>
        </header>
        <h2>Informace pro rodiče</h2>
        <main>
            <section class="parent-news">

                <?php if (!empty($news)) : ?>
                    
                    <?php foreach (array_reverse($news) as $actuality) : ?>
                        <div class="parent-news-item">

                            <h3 class="ac-item-title"><?php echo htmlspecialchars($actuality['title']); ?></h3>
                            <p class ="parent-date"><?php echo htmlspecialchars($actuality['date']); ?></p>
                            <p><?php echo htmlspecialchars($actuality['content']); ?></p>

                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Žádné aktuality pro rodiče nejsou k dispozici.</p>
                <?php endif; ?>
            </section>
        </main>
        
        <footer class="footer">
            <div class="contacts">
                <h2>Kontakty</h2>
                <ul class="contacts-list">
                    <li class="contacts-list-item">576 978 567</li>
                    <li class="contacts-list-item">sekretariat@zsab.cz</li>
                    <li class="contacts-list-item">Saskova 2080/34</li>
                    <li class="contacts-list-item">Jablonec n.N.</li>
                </ul>
            </div>
            <div class="footer-end">2024 Základní škola Antonína Bratršovského</div>
        </footer>
    </body>
    </html>