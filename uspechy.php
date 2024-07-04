<!DOCTYPE html>
<html lang="cs">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZŠAB | Úspěchy</title>
    <link rel="stylesheet" type="text/css" href="./styles/normalize.css" />
    <link rel="stylesheet" type="text/css" href="./styles/style.css" />
    <link rel="stylesheet" type="text/css" href="./styles/media.css" />

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
                <li ><a class="menu-navbar-list-button" onclick="toggleList();"> O škole</a>
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
    <main>
    <?php 
    $json_data = file_get_contents('./data/uspechy/uspechy.json');
    $json_data = json_decode($json_data, true);

    echo '<div class="us">';
    
    foreach (array_reverse($json_data) as $index => $item) {;
        $us_name = htmlspecialchars($item['us_name']);
        $image = $item['us'];
        echo "<div class ='us-item'>";
            if (!empty($image)) {
                echo"<div  class= 'us-img'>";
                    echo "<img class='ac-img' src='{$image}' alt=''>";
                echo"</div>";
            }
            echo "<p class='us-text'>{$us_name}</p>"; 
        echo"</div>";
    }
    echo '</div>'; 
?>
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
        <div class="footer-end">2024 Základní škola Antonína Bratršovksého</div>
    </footer>
</body>
</html>