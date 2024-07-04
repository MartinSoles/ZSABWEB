<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/style.css" />
    <link rel="stylesheet" type="text/css" href="./styles/media.css" />
    <link rel="stylesheet" type="text/css" href="./styles/normalize" />
    <title>ZŠAB</title>
</head>
<script>
    function toggleMenu() {
        var menuNavbar = document.querySelector('.menu-navbar');
        menuNavbar.classList.toggle('active');
    }

    function showAc(itemIndex, event) {
        var acItems = document.querySelectorAll('.ac-item-text-open');
        acItems.forEach(function(item, index) {
            if (index === itemIndex) {
                item.classList.add('active');
            } 
        });
        event.stopPropagation();
    }
    function showAkce(itemIndex, event) {
        var acItems = document.querySelectorAll('.akce-item-text-open');
        acItems.forEach(function(item, index) {
            if (index === itemIndex) {
                item.classList.add('active');
            } 
        });
        event.stopPropagation();
    }  
    function closeAc(itemIndex, event) {
        var acItems = document.querySelectorAll('.ac-item-text-open');
        acItems.forEach(function(item, index) {
            if (index === itemIndex) {
                item.classList.remove('active');
            } 
        });
        event.stopPropagation();
    }
    function closeAkce(itemIndex, event) {
        var acItems = document.querySelectorAll('.akce-item-text-open');
        acItems.forEach(function(item, index) {
            if (index === itemIndex) {
                item.classList.remove('active');
            } 
        });
        event.stopPropagation();
    }
    function disableAc() {
        var acItems = document.querySelectorAll('.ac-item');
        acItems.forEach(function(item, index) {
            if (index >= 4) {
                item.classList.add('disable');
            }
        });
    }
    function enableAc(){
        var acItems = document.querySelectorAll('.ac-item');
        acItems.forEach(function(item, index) {
            if (index >= 3) {
                item.classList.remove('disable');
            }
        });
        document.querySelector("#more").classList.add("disable")
    }
    
    function toggleList(){
        var menuNavbar = document.querySelector('.menu-navbar-list-dropdown');
        menuNavbar.classList.toggle('active');
    }
    
    window.onload = function() {
        disableAc();
    };
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
                <li><a href="soubory.php">Dokumenty školy</a></li>
                <li><a href="#">Zájmové vzdělávání</a></li>
                <li><a href="spolek.php">Spolek pro podporu ZŠAB</a></li>
                <li><a href="#">Pro uchazeče</a></li>
                <li><a href="stravovani.php">Stravování</a></li>
                <li><a href="Tym.php">Kontakty</a></li>
            </ul>
        </menu>
    </header>

        <figure class="foto"><img class="foto-item" src="./images/skola.jpg"></figure>

    <h2>AKTUALITY</h2>
    <?php

    $json_data = file_get_contents('./data/ac/actualities.json');
    $json_data = json_decode($json_data, true);
    $json_data2 = file_get_contents('./data/akce/akce.json');
    $json_data2 = json_decode($json_data2, true);
    echo '<div class="ac">';
    
    foreach (array_reverse($json_data) as $index => $item) {
        echo '<div class="ac-item" onclick="showAc('.$index.', event);">';
            echo '<div class="ac-item-visible">';
                $title = htmlspecialchars($item['title']);
                $content = htmlspecialchars($item['content']);
                $date = htmlspecialchars($item['date']);
                $fullContent = htmlspecialchars($item['fullContent']);
                $image = $item['image'];
        
                if (!empty($image)) {
                    echo "<img class='ac-img' src='{$image}' alt=''>";
                }
            echo '</div>'; // ac-item-visible
            echo '<div class="ac-item-text">';
                echo "<h3 class='ac-item-title'>{$title}</h3>";
                echo  "<p class='ac-item-date'>{$date}</p>";    
                echo "<p class='ac-item-content'>{$content}</p>";

                echo "<div class='ac-item-text-open'>";
                    echo '<div class="ac-item-text-open-header"><img class="logo" src="./images/logo.png" alt="logo školy"> <a class="menu-navbar-top-close" onclick="closeAc('.$index.', event);">❌</a></div>';
                    if (!empty($image)) {
                        echo "<img class='ac-img-open' src='{$image}' alt=''>";
                    }

                    echo "<h2 class='ac-item-text-open-title'>{$title}</h2>";
                    echo  "<p class='ac-item-text-open-date'>{$date}</p>";            
                    echo "<p class='ac-item-text-open-Fullcontent'>{$fullContent}</p>";
                echo "</div>"; // ac-item-text-open
                
            echo "</div>"; // ac-item-text
        echo "</div>"; // ac-item
    }
    echo '</div>'; // ac
    echo '<div class="ac-item-title" id="more" onclick="enableAc();">Další AKTUALITY</div>';
    echo "<h2>Akce</h2>";
    echo '<div class="akce">';
    
    foreach (array_reverse($json_data2) as $index => $item) {
        echo '<div class="akce-item" onclick="showAkce('.$index.', event);">';
            echo '<div class="akce-item-visible">';
                $title2 = htmlspecialchars($item['title2']);
                $content2 = htmlspecialchars($item['content2']);
                $date2 = htmlspecialchars($item['date2']);
                $fullContent2 = htmlspecialchars($item['fullContent2']);
                $image2 = $item['image2'];
        
                if (!empty($image2)) {
                    echo "<img class='akce-img' src='{$image2}' alt=''>";
                }
            echo '</div>'; // akce-item-visible
            echo '<div class="akce-item-text">';
                echo "<h3 class='ac-item-title'>{$title2}</h3>";
                echo  "<p class='ac-item-date'>{$date2}</p>";    
                echo "<p class='ac-item-content'>{$content2}</p>";
                echo "<div class='akce-item-text-open'>";
                    echo '<div class="akce-item-text-open-header"><img class="logo" src="./images/logo.png" alt="logo školy"> <a class="menu-navbar-top-close" onclick="closeAkce('.$index.', event);">❌</a></div>';
                    if (!empty($image2)) {
                        echo "<img class='akce-img-open' src='{$image2}' alt=''>";
                    }

                    echo "<h2 class='akce-item-text-open-title'>{$title2}</h2>";
                    echo  "<p class='akce-item-text-open-date'>{$date2}</p>";            
                    echo "<p class='akce-item-text-open-Fullcontent'>{$fullContent2}</p>";
                echo "</div>"; // akce-item-text-open
                
            echo "</div>"; // akce-item-text
        echo "</div>"; // akce-item
    }
    echo "</div>"; // akce
    ?>

    <h2>Odkazy</h2>
        <div class="links">
            <img class="links-img" src="./images/stitek-jablonec.png">
            <img class="links-img" src="./images/stitek-dieceze.png">
            <img class="links-img" src="./images/msmt-stitek.png">
            <img class="links-img" src="./images/lk-stitek.png">
        </div>

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
            <div class="footer-end">2024 Základní škola Antonína Bratršovkského</div>
        </footer>
    </body>
</html>