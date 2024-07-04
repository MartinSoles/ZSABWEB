<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZŠAB | kroužky1</title>
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
    function showKr(itemIndex, event) {
        var acItems = document.querySelectorAll('.Kr-item-text-open');
        acItems.forEach(function(item, index) {
            if (index === itemIndex) {
                item.classList.add('active');
            } 
        });
        event.stopPropagation();
    }
    function showKr(itemIndex, event) {
        var krItems = document.querySelectorAll('.kr-item-text-open');
        krItems.forEach(function(item, index) {
            if (index === itemIndex) {
                item.classList.add('active');
            } 
        });
        event.stopPropagation();
    }
    function closeKr(itemIndex, event) {
        var krItems = document.querySelectorAll('.kr-item-text-open');
        krItems.forEach(function(item, index) {
            if (index === itemIndex) {
                item.classList.remove('active');
            } 
        });
        event.stopPropagation();
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
    <main class="kr-main">
        <h2>Kroužky prvního stupně</h2>
        <?php 
    $json_data = file_get_contents('./data/krouzky/krouzky.json');
    $json_data = json_decode($json_data, true);

    echo '<div class="kr">';
    
    foreach (array_reverse($json_data) as $index => $item) {
        echo '<div class="ac-item" class="kr-width" onclick="showKr('.$index.', event);">';
            echo '<div class="kr-item-visible">';
                $title = htmlspecialchars($item['title4']);
                $content = htmlspecialchars($item['content4']);
                $image = $item['image4'];
        
                if (!empty($image)) {
                    echo "<img class='ac-img'  class ='kr-img' src='{$image}' alt=''>";
                }
                echo "<h3 class='kr-item-title'>{$title}</h3>"; 
            echo '</div>'; 
            echo '<div class="ac-item-text">';
                   


                echo "<div class='kr-item-text-open'>";
                    echo '<div class="ac-item-text-open-header"><img class="logo" src="./images/logo.png" alt="logo školy"> <a class="menu-navbar-top-close" onclick="closeKr('.$index.', event);">❌</a></div>';
                    if (!empty($image)) {
                        echo "<img class='ac-img-open' src='{$image}' alt=''>";
                    }
                    echo "<h2 class='ac-item-text-open-title'>{$title}</h2>";   
                    echo "<p class='kr-item-content'>{$content}</p>";         
                echo "</div>"; 
                
            echo "</div>"; 
        echo "</div>"; 
    }
    echo '</div>'; 
?>
<p>Rozvrh kroužků</p>
<?php 
    $json_schedule = file_get_contents('./data/krouzky/rozvrh.json');
    $json_schedule = json_decode($json_schedule, true);
    foreach (array_reverse($json_schedule) as $index => $item) {
        $schedule = $item['schedule'];
        if (!empty($schedule)) {
            echo "<figure class ='schedule-cover'><img class='schedule' src='{$schedule}' alt=''></figure>";
        }
    }
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
        <div class="footer-end">2024 Základní škola Antonína Bratršovkského</div>
    </footer>

</body>
</html>