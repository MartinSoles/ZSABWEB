<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZŠAB | tým</title>
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
    <figure class="foto"><img class="foto-item" src="./images/tym.jpg"></figure>

    
    <div class="personal">
        <?php

            $json_data3 = file_get_contents('./data/tym/tym.json');
            $json_data3 = json_decode($json_data3, true);
            $counterV = 0;
            $counterK = 0;
            $counterT = 0;
            $counterU = 0;
            $counterO = 0;
            foreach ($json_data3 as $index => $item) {
                
                    $function = htmlspecialchars($item['function']);
                    $name = htmlspecialchars($item['name']);
                    $mail = htmlspecialchars($item['mail']);
                    $phone = htmlspecialchars($item['phone']);
                    $group = htmlspecialchars($item['group']);
                    $image3 = $item['image3'];
                    
                    if ($group == "vedení"){
                       
                        echo '<div class ="personal-item" id ="p-first">';
                        
                        if ($counterV == 0){
                            echo "<h2>Vedení školy</h2>";
                            $counterV +=1;
                        }
                            if (!empty($image3)) {
                                echo "<img class='tym-img' src='{$image3}' alt=''>";
                                
                            }
                            echo '<div class="personal-item-text">';
                                echo "<h3 class='personal-function'>{$function}</h3>";
                                echo  "<p class='personal-name'>{$name}</p>";    
                                echo "<p class='personal-mail'>{$mail}</p>";
                                echo "<p class='personal-phone'>{$phone}</p>";
                            echo "</div>"; 
                        echo "</div>";                  
                    }
                    
                    else if($group == "kancelář"){
                        echo '<div class ="personal-item" id ="p-second">';
                        if ($counterK == 0){
                            echo "<h2>Kancelář školy</h2>";
                            $counterK +=1;
                        }
                            if (!empty($image3)) {
                                echo "<img class='tym-img' src='{$image3}' alt=''>";
                                
                            }
                            echo '<div class="personal-item-text">';
                                echo "<h3 class='personal-function'>{$function}</h3>";
                                echo  "<p class='personal-name'>{$name}</p>";    
                                echo "<p class='personal-mail'>{$mail}</p>";
                                echo "<p class='personal-phone'>{$phone}</p>";
                            echo "</div>";    
                        echo "</div>";                    
                    }
                    else if($group == "třídní učitel"){
                        echo '<div class ="personal-item" id ="p-third">';
                        if ($counterT == 0){
                            echo "<h2>Třídní učitelé</h2>";
                            $counterT +=1; 
                        }
                            if (!empty($image3)) {
                                echo "<img class='tym-img' src='{$image3}' alt=''>";
                                
                            }
                            echo '<div class="personal-item-text">';
                                echo "<h3 class='personal-function'>{$function}</h3>";
                                echo  "<p class='personal-name'>{$name}</p>";    
                                echo "<p class='personal-mail'>{$mail}</p>";
                                echo "<p class='personal-phone'>{$phone}</p>";
                            echo "</div>";   
                        echo "</div>";                    
                    }
                    else if($group == "učitel"){
                        echo '<div class ="personal-item" id ="p-fourth">';
                        if ($counterU == 0){
                            echo "<h2>Učitelé</h2>";
                            $counterU +=1;
                        }
                            if (!empty($image3)) {
                                echo "<img class='tym-img' src='{$image3}' alt=''>";
                                
                            }
                            echo '<div class="personal-item-text">';
                                echo "<h3 class='personal-function'>{$function}</h3>";
                                echo  "<p class='personal-name'>{$name}</p>";    
                                echo "<p class='personal-mail'>{$mail}</p>";
                                echo "<p class='personal-phone'>{$phone}</p>";
                            echo "</div>";   
                        echo "</div>";                      
                    }
                    else if($group == "vychovatelka"){
                        echo '<div class ="personal-item id ="p-fiveth">';
                        if ($counterV == 0){
                            echo "<h2>vychovatelky</h2>";
                            $counterV +=1;
                        }
                            if (!empty($image3)) {
                                echo "<img class='tym-img' src='{$image3}' alt=''>";
                                
                            }
                            echo '<div class="personal-item-text">';
                                echo "<h3 class='personal-function'>{$function}</h3>";
                                echo  "<p class='personal-name'>{$name}</p>";    
                                echo "<p class='personal-mail'>{$mail}</p>";
                                echo "<p class='personal-phone'>{$phone}</p>";
                            echo "</div>";    
                        echo "</div>";                     
                    }
                    else{
                        echo '<div class ="personal-item id ="p-sixth">';
                        if ($counterO == 0){
                            echo "<h2>ostatní zaměstnanci</h2>";
                            $counterO +=1;
                        }
                            if (!empty($image3)) {
                                echo "<img class='tym-img' src='{$image3}' alt=''>";
                                
                            }
                            echo '<div class="personal-item-text">';
                                echo "<h3 class='personal-function'>{$function}</h3>";
                                echo  "<p class='personal-name'>{$name}</p>";    
                                echo "<p class='personal-mail'>{$mail}</p>";
                                echo "<p class='personal-phone'>{$phone}</p>";
                            echo "</div>";        
                        echo "</div>";                
                    }                            
            }
        ?>
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
        <div class="footer-end">2024 Základní škola Antonína Bratršovksého</div>
    </footer>
</body>
</html>