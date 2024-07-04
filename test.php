<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: prihlaseni.php");
    exit;
}

?>
<di?php
ob_start();
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/admin_style.css" />
    <title>ZSAB | admin</title>
</head>

<body>
    <header>
        <p id ="admin-title">ZŠAB - administrace webu</p>
    </header>
    <?php
    function getPostValue($key, $default = '')
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $default;
    }

    function getFiles($path, $type = 'json')
    {
        $json_data = file_get_contents($path);
        return json_decode($json_data, true);
    }

    function saveFiles($path, $data)
    {
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($path, $json_data);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['add'])) {
            $new_data = array(
                'title' => getPostValue('title'),
                'content' => getPostValue('content'),
                'date' => getPostValue('date'),
                'fullContent' => getPostValue('fullContent'),
                'image' => '',
            );

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/ac/img/';
                $uploadFile = $uploadDir . basename($_FILES['image']['name']);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $new_data['image'] = $uploadFile;
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }

            $data = getFiles('./data/ac/actualities.json');
            $data[] = $new_data;
            saveFiles('./data/ac/actualities.json', $data);

            header("Location: admin.php");
            exit();
        }

        if (isset($_POST['remove'])) {
            $remove_title = getPostValue('remove_title');
            $data = getFiles('./data/ac/actualities.json');

            foreach ($data as $key => $item) {
                if ($item['title'] == $remove_title) {
                    if (isset($item['image']) && file_exists($item['image'])) {
                        unlink($item['image']);
                    }
                    unset($data[$key]);
                }
            }

            saveFiles('./data/ac/actualities.json', array_values($data));
        }

        if (isset($_POST['add2'])) {
            $new_data = array(
                'title2' => getPostValue('title2'),
                'content2' => getPostValue('content2'),
                'date2' => getPostValue('date2'),
                'fullContent2' => getPostValue('fullContent2'),
                'image2' => '',
            );

            if (isset($_FILES['image2']) && $_FILES['image2']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/akce/img/';
                $uploadFile = $uploadDir . basename($_FILES['image2']['name']);

                if (move_uploaded_file($_FILES['image2']['tmp_name'], $uploadFile)) {
                    $new_data['image2'] = $uploadFile;
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }

            $data2 = getFiles('./data/akce/akce.json');
            $data2[] = $new_data;
            saveFiles('./data/akce/akce.json', $data2);

            header("Location: admin.php");
            exit();
        }

        if (isset($_POST['remove2'])) {
            $remove_title2 = getPostValue('remove_title2');
            $data2 = getFiles('./data/akce/akce.json');

            foreach ($data2 as $key => $item) {
                if ($item['title2'] == $remove_title2) {
                    if (isset($item['image2']) && file_exists($item['image2'])) {
                        unlink($item['image2']);
                    }
                    unset($data2[$key]);
                }
            }

            saveFiles('./data/akce/akce.json', array_values($data2));
        }

        if (isset($_POST['add3'])) {
            $new_data = array(
                'function' => getPostValue('function'),
                'name' => getPostValue('name'),
                'mail' => getPostValue('mail'),
                'phone' => getPostValue('phone'),
                'image3' => '',
            );

            if (isset($_FILES['image3']) && $_FILES['image3']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/tym/img/';
                $uploadFile = $uploadDir . basename($_FILES['image3']['name']);

                if (move_uploaded_file($_FILES['image3']['tmp_name'], $uploadFile)) {
                    $new_data['image3'] = $uploadFile;
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }

            $data3 = getFiles('./data/tym/tym.json');
            $data3[] = $new_data;
            saveFiles('./data/tym/tym.json', $data3);

            header("Location: admin.php");
            exit();
        }

        if (isset($_POST['remove3'])) {
            $remove_title3 = getPostValue('remove_title3');
            $data3 = getFiles('./data/tym/tym.json');

            foreach ($data3 as $key => $item) {
                if ($item['name'] == $remove_title3) {
                    if (isset($item['image3']) && file_exists($item['image3'])) {
                        unlink($item['image3']);
                    }
                    unset($data3[$key]);
                }
            }

            saveFiles('./data/tym/tym.json', array_values($data3));
        }

        if (isset($_POST['upload_document'])) {
            $document_name = getPostValue('document_name');
            if (isset($_FILES['document']) && $_FILES['document']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/dokumenty/soubory/';
                $uploadFile = $uploadDir . basename($_FILES['document']['name']);
                
                if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadFile)) {
                    // ZDE ZADEJTE CESTU K JSON SOUBORU
                    $dataDocs = getFiles('./data/dokumenty/dokumenty.json'); 
                    $dataDocs[] = array(
                        'name' => $document_name,
                        'path' => $uploadFile
                    );
                    saveFiles('./data/dokumenty/dokumenty.json', $dataDocs);
                    echo 'Soubor byl úspěšně nahrán.';
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }
        }

        if (isset($_POST['remove_document'])) {
            $remove_file = getPostValue('remove_file');
            // ZDE ZADEJTE CESTU K JSON SOUBORU
            $dataDocs = getFiles('./data/dokumenty/dokumenty.json'); 
            $file_path = '';

            foreach ($dataDocs as $key => $doc) {
                if ($doc['name'] == $remove_file) {
                    $file_path = $doc['path'];
                    unset($dataDocs[$key]);
                    break;
                }
            }

            if (file_exists($file_path)) {
                unlink($file_path);
                saveFiles('./data/dokumenty/dokumenty.json', array_values($dataDocs));
                echo 'Soubor byl úspěšně odstraněn.';
            } else {
                echo 'Soubor nebyl nalezen.';
            }
        }
        if (isset($_POST['add_parents'])) {
            $new_data = array(
                'title' => getPostValue('title'),
                'content' => getPostValue('content'),
                'date' => getPostValue('date'),
                'attachments' => [],
            );

            if (!empty($_FILES['attachments']['name'][0])) {
                $uploadDir = 'data/rodice/soubory/'; // Nastavte cestu k přílohám
                foreach ($_FILES['attachments']['name'] as $key => $name) {
                    $uploadFile = $uploadDir . basename($name);
                    if (move_uploaded_file($_FILES['attachments']['tmp_name'][$key], $uploadFile)) {
                        $new_data['attachments'][] = $uploadFile;
                    } else {
                        echo 'Chyba při nahrávání souboru: ' . htmlspecialchars($name);
                    }
                }
            }

            $dataParents = getFiles('data/rodice/rodice.json'); 
            $dataParents[] = $new_data;
            saveFiles('data/rodice/rodice.json', $dataParents); 

            header("Location: admin.php");
            exit();
        }
        // Přidání aktuality pro rodiče
        if (isset($_POST['add_parents'])) {
            $new_data = array(
                'title' => getPostValue('title'),
                'content' => getPostValue('content'),
                'date' => getPostValue('date'),
                'attachments' => [],
            );
        
            if (!empty($_FILES['attachments']['name'][0])) {
                $uploadDir = 'data/rodice/soubory/'; // Nastavte cestu k přílohám
                foreach ($_FILES['attachments']['name'] as $key => $name) {
                    $uploadFile = $uploadDir . basename($name);
                    if (move_uploaded_file($_FILES['attachments']['tmp_name'][$key], $uploadFile)) {
                        $new_data['attachments'][] = $uploadFile;
                    } else {
                        echo 'Chyba při nahrávání souboru: ' . htmlspecialchars($name);
                    }
                }
            }
        
            $dataParents = getFiles('data/rodice/rodice.json'); 
            $dataParents[] = $new_data;
            saveFiles('data/rodice/rodice.json', $dataParents); 
        
            header("Location: admin.php");
            exit();
        }
        if (isset($_POST['remove_parents'])) {
            $remove_title_parents = getPostValue('remove_title_parents');
            $dataParents = getFiles('data/rodice/rodice.json');
        
            foreach ($dataParents as $key => $item) {
                if ($item['title'] == $remove_title_parents) {
                    // Odstranění příloh, pokud existují
                    foreach ($item['attachments'] as $attachment) {
                        if (file_exists($attachment)) {
                            unlink($attachment);
                        }
                    }
                    unset($dataParents[$key]);
                    break;
                }
            }
        
            saveFiles('data/rodice/rodice.json', array_values($dataParents));
            header("Location: admin.php");
            exit();
        }
    }
    ?>
    <main>
        <div class="main-section">
            <p>Přidat aktualitu</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="general-item">
                    <label for="title">Datum:</label>
                    <input type="text" name="date" required>
                </div>
                <div class="general-item">
                    <label for="image">Obrázek:</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="general-item">
                    <label for="content">Obsah na hlavní stránce:</label>
                    <textarea name="content" required></textarea>
                </div>
                <div class="general-item">
                    <label for="fullContent">Obsah po otevření:</label>
                    <textarea name="fullContent" required></textarea>
                </div>
                <div class="general-item">
                    <button type="submit" name="add">Přidat aktualitu</button>
                </div>
            </form>
            <p>Odstranit aktualitu</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_title">Název k odstranění:</label>
                    <select name="remove_title" required>
                        <?php
                        $data = getFiles('./data/ac/actualities.json');
                        foreach ($data as $item) {
                            echo '<option value="' . htmlspecialchars($item['title']) . '">' . htmlspecialchars($item['title']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove">Odstranit aktualitu</button>
                </div>
            </form>
        </div>


        <div class="main-section">
            <p>Přidat akci</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title2">Název:</label>
                    <input type="text" name="title2" required>
                </div>
                <div class="general-item">
                    <label for="title2">Datum:</label>
                    <input type="text" name="date2" required>
                </div>
                <div class="general-item">
                    <label for="image2">Obrázek:</label>
                    <input type="file" name="image2" accept="image/*" required>
                </div>
                <div class="general-item">
                    <label for="content2">Obsah na hlavní stránce:</label>
                    <textarea name="content2" required></textarea>
                </div>
                <div class="general-item">
                    <label for="fullContent2">Obsah po otevření:</label>
                    <textarea name="fullContent2" required></textarea>
                </div>
                <div class="general-item">
                    <button type="submit" name="add2">Přidat akci</button>
                </div>
            </form>
            <p>Odstranit akci</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_title2">Název k odstranění:</label>
                    <select name="remove_title2" required>
                        <?php
                        $data2 = getFiles('./data/akce/akce.json');
                        foreach ($data2 as $item) {
                            echo '<option value="' . htmlspecialchars($item['title2']) . '">' . htmlspecialchars($item['title2']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove2">Odstranit akci</button>
                </div>
            </form>
        </div>

        <div class="main-section">
            <p>Přidat pedagoga</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="function">Funkce:</label>
                    <input type="text" name="function" required>
                </div>
                <div class="general-item">
                    <label for="name">Jméno:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="general-item">
                    <label for="mail">Email:</label>
                    <input type="text" name="mail" required>
                </div>
                <div class="general-item">
                    <label for="phone">Telefon:</label>
                    <input type="text" name="phone" required>
                </div>
                <div class="general-item">
                    <label for="image3">Fotka:</label>
                    <input type="file" name="image3" accept="image/*" required>
                </div>
                <div class="general-item">
                    <button type="submit" name="add3">Přidat pedagoga</button>
                </div>
            </form>
            <p>Odstranit pedagoga</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_title3">Jméno k odstranění:</label>
                    <select name="remove_title3" required>
                        <?php
                        $data3 = getFiles('./data/tym/tym.json');
                        foreach ($data3 as $item) {
                            echo '<option value="' . htmlspecialchars($item['name']) . '">' . htmlspecialchars($item['name']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove3">Odstranit pedagoga</button>
                </div>
            </form>
        </div>

        <div class="main-section">
    <p>Přidat dokument</p>
    <form method="post" enctype="multipart/form-data" class="general">
        <div class="general-item">
            <label for="title">Název:</label>
            <input type="text" name="document_name" required class="input-field">
        </div>
        <div class="general-item">
            <input type="file" name="document" required class="file-input"><br>
        </div>
        <div class="general-item">
            <button type="submit" name="upload_document" class="submit-button">Přidat dokument</button>
        </div>
    </form>

    <p>Odstranit dokument</p>

    <form method="post" action="" class="general">
        <div class="general-item">
            <label for="remove_file">Název k odstranění:</label>
            <select name="remove_file" id="remove_file">
                <?php
                $documents = getFiles('./data/dokumenty/dokumenty.json');
                foreach ($documents as $doc) {
                    echo '<option value="' . htmlspecialchars($doc['name']) . '">' . htmlspecialchars($doc['name']) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="general-item">
            <input type="submit" name="remove_document" value="Odstranit dokument">
        </div>
    </form>
</div>
        </div>


        <div class="main-section">
            <p>Přidat aktualitu pro rodiče</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="general-item">
                    <label for="date">Datum:</label>
                    <input type="text" name="date" required>
                </div>
                <div class="general-item">
                    <label for="content">Obsah:</label>
                    <textarea name="content" required></textarea>
                </div>
                <div class="general-item">
                    <input type="file" name="attachments[]" multiple>
                </div>
                <div class="general-item">
                    <button type="submit" name="add_parents">Přidat aktualitu pro rodiče</button>
                </div>
            </form>
            <p>Odstranit aktualitu pro rodiče</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_title_parents">Název k odstranění:</label>
                    <select name="remove_title_parents" required>
            
                        <?php
                        $dataParents = getFiles('data/rodice/rodice.json');
                        foreach ($dataParents as $item) {
                            echo '<option value="' . htmlspecialchars($item['title']) . '">' . htmlspecialchars($item['title']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove_parents">Odstranit aktualitu pro rodiče</button>
                </div>
            </form>
        </div>

    </main>
</body>

</html>

<?php
ob_end_flush();
?>