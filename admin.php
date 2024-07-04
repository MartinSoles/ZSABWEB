<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: prihlaseni.php");
    exit;
}

?>
<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/admin_style.css" />
    <title>ZŠAB | admin</title>
</head>

<body>
    <header>
        <p id ="admin-title">ZŠAB - administrace webu</p>
    </header>
    <?php

    //podprogramy
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


    //pridani aktuality
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
        //odebrani aktuality
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
        //pridani akce
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
        //odebrani akce
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
        //pridani pedagoga
        if (isset($_POST['add3'])) {
            $new_data = array(
                'function' => getPostValue('function'),
                'name' => getPostValue('name'),
                'mail' => getPostValue('mail'),
                'phone' => getPostValue('phone'),
                'group' => getPostValue('group'),
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
        //odebrani pedagoga
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
        //pridani souboru
        if (isset($_POST['upload_document'])) {
            $document_name = getPostValue('document_name');
            if (isset($_FILES['document']) && $_FILES['document']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/dokumenty/soubory/';
                $uploadFile = $uploadDir . basename($_FILES['document']['name']);
                
                if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadFile)) {
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
        //odebrani souboru
        if (isset($_POST['remove_document'])) {
            $remove_file = getPostValue('remove_file');
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
        // Přidání aktuality pro rodiče
        if (isset($_POST['add_parents'])) {
            $new_data7 = array(
                'title' => getPostValue('title'),
                'date' => getPostValue('date'),
                'content' => getPostValue('content')
            );
        
            $dataParent = getFiles('data/rodice/rodice.json'); 
            $dataParent[] = $new_data7;
            saveFiles('data/rodice/rodice.json', $dataParent); 
        
            header("Location: admin.php");
            exit();
        }
    }
?>


<?php
    //pridani krouzku1
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['add4'])) {
            $new_data = array(
                'title4' => getPostValue('title4'),
                'content4' => getPostValue('content4'),
                'image4' => '',
            );

            if (isset($_FILES['image4']) && $_FILES['image4']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/krouzky/img/';
                $uploadFile = $uploadDir . basename($_FILES['image4']['name']);

                if (move_uploaded_file($_FILES['image4']['tmp_name'], $uploadFile)) {
                    $new_data['image4'] = $uploadFile;
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }

            $data4 = getFiles('./data/krouzky/krouzky.json');
            $data4[] = $new_data;
            saveFiles('./data/krouzky/krouzky.json', $data4);

            header("Location: admin.php");
            exit();
        }
    //pridani rozvrhu krouzku1
        if (isset($_POST['add_schedule'])) {
            $shedule_arr = array(
                'schedule' => getPostValue('schedule')
            );
            if (isset($_FILES['schedule']) && $_FILES['shcedule']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/krouzky/img/';
                $uploadFile = $uploadDir . basename($_FILES['schedule']['name']);

                if (move_uploaded_file($_FILES['schedule']['tmp_name'], $uploadFile)) {
                    $schedule_arr['schedule'] = $uploadFile;
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }
            $data_schedule = getFiles('./data/krouzky/rozvrh.json');
            $data_schedule[] = $schedule_arr;
            saveFiles('./data/krouzky/rozvrh.json', $data_schedule);

            header("Location: admin.php");
            exit();
        }
    }
    //odebrani krouzku1
    if (isset($_POST['remove4'])) {
        $remove_title4 = getPostValue('remove_title4');
        $data4 = getFiles('./data/krouzky/krouzky.json');

        foreach ($data4 as $key => $item) {
            if ($item['title4'] == $remove_title4) {
                if (isset($item['image4']) && file_exists($item['image4'])) {
                    unlink($item['image4']);
                }
                unset($data4[$key]);
            }
        }

        saveFiles('./data/krouzky/krouzky.json', array_values($data4));
    }


    //pridani krouzku2
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['add42'])) {
            $new_data = array(
                'title42' => getPostValue('title42'),
                'content42' => getPostValue('content42'),
                'image42' => '',
            );

            if (isset($_FILES['image42']) && $_FILES['image42']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/krouzky2/img/';
                $uploadFile = $uploadDir . basename($_FILES['image42']['name']);

                if (move_uploaded_file($_FILES['image42']['tmp_name'], $uploadFile)) {
                    $new_data['image42'] = $uploadFile;
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }

            $data4 = getFiles('./data/krouzky2/krouzky2.json');
            $data4[] = $new_data;
            saveFiles('./data/krouzky2/krouzky2.json', $data4);

            header("Location: admin.php");
            exit();
        }
    //pridani rozvrhu krouzku2
        if (isset($_POST['add_schedule2'])) {
            $shedule_arr = array(
                'schedule2' => getPostValue('schedule2')
            );
            if (isset($_FILES['schedule2']) && $_FILES['schedule2']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = './data/krouzky2/img/';
                $uploadFile = $uploadDir . basename($_FILES['schedule2']['name']);

                if (move_uploaded_file($_FILES['schedule2']['tmp_name'], $uploadFile)) {
                    $schedule_arr['schedule2'] = $uploadFile;
                } else {
                    echo 'Chyba při nahrávání souboru.';
                }
            }
            $data_schedule = getFiles('./data/krouzky2/rozvrh.json');
            $data_schedule[] = $schedule_arr;
            saveFiles('./data/krouzky2/rozvrh.json', $data_schedule);

            header("Location: admin.php");
            exit();
        }
    }
    //odebrani krouzku2
    if (isset($_POST['remove42'])) {
        $remove_title4 = getPostValue('remove_title4');
        $data4 = getFiles('./data/krouzky2/krouzky2.json');

        foreach ($data4 as $key => $item) {
            if ($item['title42'] == $remove_title4) {
                if (isset($item['image42']) && file_exists($item['image42'])) {
                    unlink($item['image42']);
                }
                unset($data42[$key]);
            }
        }

        saveFiles('./data/krouzky2/krouzky2.json', array_values($data42));
    }
    //pridani odstavce druzina
    if (isset($_POST['add_paragraph3'])) {
        $new_data9 = array(
            'druzina' => getPostValue('druzina')
        );
    
        $dataDruzina = getFiles('data/druzina/druzina.json');  
        $dataDruzina[] = $new_data9;
        saveFiles('data/druzina/druzina.json', $dataDruzina); 
    
        header("Location: admin.php");
        exit();
    } 
    //odebrani obsahu druzina
    if (isset($_POST['remove_paragraph3'])) {
        $remove_paragraph3 = getPostValue('remove_paragraph3');
        $new_data9 = getFiles('./data/druzina/druzina.json');

        foreach ($new_data9 as $key => $item) {

                unset($new_data9[$key]);
            
        }

        saveFiles('./data/druzina/druzina.json', array_values($new_data9));
    }   
    //pridani odstavce stravovani2
    if (isset($_POST['add_paragraph'])) {
        $new_data6 = array(
            'stravovani1' => getPostValue('stravovani1')
        );
    
        $dataFood1 = getFiles('data/stravovani1/stravovani1.json'); 
        $dataFood1[] = $new_data6;
        saveFiles('data/stravovani1/stravovani1.json', $dataFood1); 
    
        header("Location: admin.php");
        exit();
    } 
    //odebrani obsahu stravovani1
    if (isset($_POST['remove_paragraph'])) {
        $remove_paragraph = getPostValue('remove_paragraph');
        $new_data6 = getFiles('./data/stravovani1/stravovani1.json');

        foreach ($new_data6 as $key => $item) {

                unset($new_data6[$key]);
            
        }

        saveFiles('./data/stravovani1/stravovani1.json', array_values($new_data6));
    }
    //pridani odstavce stravovani2
    if (isset($_POST['add_paragraph2'])) {
        $new_data7 = array(
            'stravovani2' => getPostValue('stravovani2')
        );
    
        $dataFood2 = getFiles('data/stravovani2/stravovani2.json'); 
        $dataFood2[] = $new_data7;
        saveFiles('data/stravovani2/stravovani2.json', $dataFood2); 
    
        header("Location: admin.php");
        exit();
    } 
    //odebrani obsahu stravovani2
    if (isset($_POST['remove_paragraph2'])) {
        $remove_paragraph2 = getPostValue('remove_paragraph2');
        $new_data7 = getFiles('./data/stravovani2/stravovani2.json');

        foreach ($new_data7 as $key => $item) {

                unset($new_data7[$key]);
            
        }

        saveFiles('./data/stravovani2/stravovani2.json', array_values($new_data7));
    }
    //pridani VZ
    if (isset($_POST['upload_VZ'])) {
        $VZ_name = getPostValue('VZ_name');
        if (isset($_FILES['VZ']) && $_FILES['VZ']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = './data/VZ/soubory/';
            $uploadFile = $uploadDir . basename($_FILES['VZ']['name']);
            
            if (move_uploaded_file($_FILES['VZ']['tmp_name'], $uploadFile)) {
                $dataVZ = getFiles('./data/VZ/dokumenty.json'); 
                $dataVZ[] = array(
                    'name' => $VZ_name,
                    'path' => $uploadFile
                );
                saveFiles('./data/VZ/dokumenty.json', $dataVZ);
                echo 'Soubor byl úspěšně nahrán.';
            } else {
                echo 'Chyba při nahrávání souboru.';
            }
        }
    }
    //odebrani VZ
    if (isset($_POST['remove_VZ'])) {
        $remove_file = getPostValue('remove_VZ');
        $dataVZ = getFiles('./data/VZ/dokumenty.json'); 
        $file_path = '';

        foreach ($dataVZ as $key => $doc) {
            if ($doc['name'] == $remove_file) {
                $file_path = $doc['path'];
                unset($dataVZ[$key]);
                break;
            }
        }

        if (file_exists($file_path)) {
            unlink($file_path);
            saveFiles('./data/VZ/dokumenty.json', array_values($dataVZ));
            echo 'Soubor byl úspěšně odstraněn.';
        } else {
            echo 'Soubor nebyl nalezen.';
        }
    }
    //pridani IZ
    if (isset($_POST['upload_IZ'])) {
        $IZ_name = getPostValue('IZ_name');
        if (isset($_FILES['IZ']) && $_FILES['IZ']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = './data/IZ/soubory/';
            $uploadFile = $uploadDir . basename($_FILES['IZ']['name']);
            
            if (move_uploaded_file($_FILES['IZ']['tmp_name'], $uploadFile)) {
                $dataIZ = getFiles('./data/IZ/dokumenty.json'); 
                $dataIZ[] = array(
                    'name' => $IZ_name,
                    'path' => $uploadFile
                );
                saveFiles('./data/IZ/dokumenty.json', $dataIZ);
                echo 'Soubor byl úspěšně nahrán.';
            } else {
                echo 'Chyba při nahrávání souboru.';
            }
        }
    }
    //odebrani IZ
    if (isset($_POST['remove_IZ'])) {
        $remove_file = getPostValue('remove_IZ');
        $dataIZ = getFiles('./data/IZ/dokumenty.json'); 
        $file_path = '';

        foreach ($dataIZ as $key => $doc) {
            if ($doc['name'] == $remove_file) {
                $file_path = $doc['path'];
                unset($dataVZ[$key]);
                break;
            }
        }

        if (file_exists($file_path)) {
            unlink($file_path);
            saveFiles('./data/IZ/dokumenty.json', array_values($dataIZ));
            echo 'Soubor byl úspěšně odstraněn.';
        } else {
            echo 'Soubor nebyl nalezen.';
        }
    }
    //pridani skolniho radu
    if (isset($_POST['upload_SR'])) {
        $SR_name = getPostValue('SR_name');
        if (isset($_FILES['SR']) && $_FILES['SR']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = './data/SR/soubory/';
            $uploadFile = $uploadDir . basename($_FILES['SR']['name']);
            
            if (move_uploaded_file($_FILES['SR']['tmp_name'], $uploadFile)) {
                $dataSR = getFiles('./data/SR/dokumenty.json'); 
                $dataSR[] = array(
                    'name' => $SR_name,
                    'path' => $uploadFile
                );
                saveFiles('./data/SR/dokumenty.json', $dataSR);
                echo 'Soubor byl úspěšně nahrán.';
            } else {
                echo 'Chyba při nahrávání souboru.';
            }
        }
    }
    //odebrani skolniho radu
    if (isset($_POST['remove_SR'])) {
        $remove_file = getPostValue('remove_SR');
        $dataSR = getFiles('./data/SR/dokumenty.json'); 
        $file_path = '';

        foreach ($dataSR as $key => $doc) {
            if ($doc['name'] == $remove_file) {
                $file_path = $doc['path'];
                unset($dataSR[$key]);
                break;
            }
        }

        if (file_exists($file_path)) {
            unlink($file_path);
            saveFiles('./data/SR/dokumenty.json', array_values($dataSR));
            echo 'Soubor byl úspěšně odstraněn.';
        } else {
            echo 'Soubor nebyl nalezen.';
        }
    }
    //pridani ŠVP
    if (isset($_POST['upload_SVP'])) {
        $SVP_name = getPostValue('SVP_name');
        if (isset($_FILES['SVP']) && $_FILES['SVP']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = './data/SVP/soubory/';
            $uploadFile = $uploadDir . basename($_FILES['SVP']['name']);
            
            if (move_uploaded_file($_FILES['SVP']['tmp_name'], $uploadFile)) {
                $dataSVP = getFiles('./data/SVP/dokumenty.json'); 
                $dataSVP[] = array(
                    'name' => $SVP_name,
                    'path' => $uploadFile
                );
                saveFiles('./data/SVP/dokumenty.json', $dataSVP);
                echo 'Soubor byl úspěšně nahrán.';
            } else {
                echo 'Chyba při nahrávání souboru.';
            }
        }
    }
    //odebrani ŠVP
    if (isset($_POST['remove_SVP'])) {
        $remove_file = getPostValue('remove_SVP');
        $dataSVP = getFiles('./data/SVP/dokumenty.json'); 
        $file_path = '';

        foreach ($dataSVP as $key => $doc) {
            if ($doc['name'] == $remove_file) {
                $file_path = $doc['path'];
                unset($dataSVP[$key]);
                break;
            }
        }

        if (file_exists($file_path)) {
            unlink($file_path);
            saveFiles('./data/SVP/dokumenty.json', array_values($dataSVP));
            echo 'Soubor byl úspěšně odstraněn.';
        } else {
            echo 'Soubor nebyl nalezen.';
        }
    }
    //pridani projektu
    if (isset($_POST['add_project'])) {
        $project_arr = array(
            'project' => getPostValue('project'),
            'project_name' => getPostValue('project_name')
        );
        if (isset($_FILES['project']) && $_FILES['project']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = './data/projekty/img/';
            $uploadFile = $uploadDir . basename($_FILES['project']['name']);

            if (move_uploaded_file($_FILES['project']['tmp_name'], $uploadFile)) {
                $project_arr['project'] = $uploadFile;
            } else {
                echo 'Chyba při nahrávání souboru.';
            }
        }
        $data_project = getFiles('./data/projekty/projekty.json');
        $data_project[] = $project_arr;
        saveFiles('./data/projekty/projekty.json', $data_project);

        header("Location: admin.php");
        exit();
    }

    //odebrani projektu
    if (isset($_POST['remove_project'])) {
        $remove_project = getPostValue('remove_project');
        $data_project = getFiles('./data/projekty/projekty.json');

        foreach ($data_project as $key => $item) {
            if ($item['project_name'] == $remove_project) {
                if (isset($item['project']) && file_exists($item['project'])) {
                    unlink($item['project']);
                }
                unset($data_project[$key]);
            }
        }

        saveFiles('./data/projekty/projekty.json', array_values($data_project));
    }

    //pridani odstavce uchazeci
    if (isset($_POST['add_paragraph32'])) {
        $new_data9 = array(
            'uchazeci' => getPostValue('uchazeci')
        );
    
        $dataUchazec = getFiles('data/uchazeci/uchazeci.json');  
        $dataUchazec[] = $new_data9;
        saveFiles('data/uchazeci/uchazeci.json', $dataUchazec); 
    
        header("Location: admin.php");
        exit();
    } 
    //odebrani obsahu uchazeci
    if (isset($_POST['remove_paragraph3'])) {
        $remove_paragraph3 = getPostValue('remove_paragraph3');
        $new_data9 = getFiles('./data/druzina/druzina.json');

        foreach ($new_data9 as $key => $item) {

                unset($new_data9[$key]);
            
        }

        saveFiles('./data/druzina/druzina.json', array_values($new_data9));
    }

    //pridani Rozvrhu
    if (isset($_POST['upload_RZ'])) {
        $RZ_name = getPostValue('RZ_name');
        if (isset($_FILES['RZ']) && $_FILES['RZ']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = './data/RZ/soubory/';
            $uploadFile = $uploadDir . basename($_FILES['RZ']['name']);
            
            if (move_uploaded_file($_FILES['RZ']['tmp_name'], $uploadFile)) {
                $dataRZ = getFiles('./data/RZ/dokumenty.json'); 
                $dataRZ[] = array(
                    'name' => $RZ_name,
                    'path' => $uploadFile
                );
                saveFiles('./data/RZ/dokumenty.json', $dataRZ);
                echo 'Soubor byl úspěšně nahrán.';
            } else {
                echo 'Chyba při nahrávání souboru.';
            }
        }
    }
    //odebrani Rozvrhu
    if (isset($_POST['remove_RZ'])) {
        $remove_file = getPostValue('remove_RZ');
        $dataRZ = getFiles('./data/RZ/dokumenty.json'); 
        $file_path = '';

        foreach ($dataRZ as $key => $doc) {
            if ($doc['name'] == $remove_file) {
                $file_path = $doc['path'];
                unset($dataRZ[$key]);
                break;
            }
        }

        if (file_exists($file_path)) {
            unlink($file_path);
            saveFiles('./data/RZ/dokumenty.json', array_values($dataRZ));
            echo 'Soubor byl úspěšně odstraněn.';
        } else {
            echo 'Soubor nebyl nalezen.';
        }
    }
    //pridani uspechy
    if (isset($_POST['add_us'])) {
        $us_arr = array(
            'us' => getPostValue('us'),
            'us_name' => getPostValue('us_name')
        );
        if (isset($_FILES['us']) && $_FILES['us']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = './data/uspechy/img/';
            $uploadFile = $uploadDir . basename($_FILES['us']['name']);

            if (move_uploaded_file($_FILES['us']['tmp_name'], $uploadFile)) {
                $us_arr['us'] = $uploadFile;
            } else {
                echo 'Chyba při nahrávání souboru.';
            }
        }
        $data_us = getFiles('./data/uspechy/uspechy.json');
        $data_us[] = $us_arr;
        saveFiles('./data/uspechy/uspechy.json', $data_us);

        header("Location: admin.php");
        exit();
    }

    //odebrani uspechy
    if (isset($_POST['remove_us'])) {
        $remove_us = getPostValue('remove_us');
        $data_us = getFiles('./data/uspechy/uspechy.json');

        foreach ($data_us as $key => $item) {
            if ($item['us_name'] == $remove_us) {
                if (isset($item['us']) && file_exists($item['us'])) {
                    unlink($item['us']);
                }
                unset($data_us[$key]);
            }
        }

        saveFiles('./data/uspechy/uspechy.json', array_values($data_us));
    }
    ?>

    <main>
        <div class="main-section">
            <p>Přidat aktualitu</p>
            <!--formulář pro přidání ac-->
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
            <!--formulář pro odebrání ac-->
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
            <!--formulář pro přidání akce-->
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
            <!--formulář pro odebrání akce-->
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
            <!--formulář pro přidání pedagoga-->
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
                <select name="group" required>
                        <?php
                            echo '<option value="vedení">Vedení školy</option>';
                            echo '<option value="kancelář">Kancelář školy</option>';
                            echo '<option value="třídní učitel">Třídní učitel</option>';
                            echo '<option value="učitel">Učitel</option>';
                            echo '<option value="vychovatelka">Vychovatelka</option>';
                            echo '<option value="ostatní">Ostatní</option>';
                        
                        ?>
                 </select> 
                <div class="general-item">
                    <button type="submit" name="add3">Přidat pedagoga</button>
                </div>
      
         
            </form>
            <p>Odstranit pedagoga</p>
            <!--formulář pro odebrání pedagoga-->
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
        <p>Přidat školní řád</p>
        <!--formulář pro přidání školního řádu-->
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
    
        <p>Odstranit školní řád</p>
        <!--formulář pro odebrání školního řádu-->
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
        


        <div class="main-section">
            <p>Přidat aktualitu pro rodiče</p>
        <!--formulář pro přidání ac pro rodiče-->
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


        <!--formulář pro přidání krouzky1-->
        <div class="main-section">
            <p>Přidat kroužek první stupeň</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="title4">
                </div>
                <div class="general-item">
                    <label for="image">Obrázek:</label>
                    <input type="file" name="image4" accept="image/*">
                </div>
                <div class="general-item">
                    <label for="content">Obsah:</label>
                    <textarea name="content4"></textarea>
                </div>
                <div class="general-item">
                    <button type="submit" name="add4">Přidat kroužek</button>
                </div>
               
                <div class="general-item">
                    <label for="image">rozvrh:</label>
                    <input type="file" name="schedule" accept="image/*">
                </div> 
                <div class="general-item">
                    <button type="submit" name="add_schedule">Přidat rozvrh</button>
                </div>            
            </form>

        <!--formulář pro odebrani krouzky1-->    
            <p>Odstranit Kroužek</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_title4">Název k odstranění:</label>
                    <select name="remove_title4" required>
                        <?php
                        $data = getFiles('./data/krouzky/krouzky.json');
                        foreach ($data as $item) {
                            echo '<option value="' . htmlspecialchars($item['title4']) . '">' . htmlspecialchars($item['title4']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove4">Odstranit kroužek</button>
                </div>
            </form>
        </div>
        <!--formulář pro přidání krouzky2-->
        <div class="main-section">
            <p>Přidat kroužek druhý stupeň</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="title42">
                </div>
                <div class="general-item">
                    <label for="image">Obrázek:</label>
                    <input type="file" name="image42" accept="image/*">
                </div>
                <div class="general-item">
                    <label for="content">Obsah:</label>
                    <textarea name="content42"></textarea>
                </div>
                <div class="general-item">
                    <button type="submit" name="add42">Přidat kroužek</button>
                </div>
               
                <div class="general-item">
                    <label for="image">rozvrh:</label>
                    <input type="file" name="schedule2" accept="image/*">
                </div> 
                <div class="general-item">
                    <button type="submit" name="add_schedule2">Přidat rozvrh</button>
                </div>            
            </form>

        <!--formulář pro odebrani krouzky2-->    
            <p>Odstranit Kroužek</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_title4">Název k odstranění:</label>
                    <select name="remove_title4" required>
                        <?php
                        $data = getFiles('./data/krouzky/krouzky.json');
                        foreach ($data as $item) {
                            echo '<option value="' . htmlspecialchars($item['title4']) . '">' . htmlspecialchars($item['title4']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove4">Odstranit kroužek</button>
                </div>
            </form>
        </div>
        <!--formulář pro druzina-->

        <div class="main-section">
            <p>Družina</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="function">Přidat odstavec </label>
                    <input type="text" name="druzina">
                </div>
                <div class="general-item">
                    <button type="submit" name="add_paragraph3">pridat</button>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove_paragraph3">smazat obsah </button>
                </div>
            </form>
        </div>

        <!--formulář pro stravovani1-->

        <div class="main-section">
            <p>Stravování 1 stupeň</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="function">Přidat odstavec </label>
                    <input type="text" name="stravovani1">
                </div>
                <div class="general-item">
                    <button type="submit" name="add_paragraph">pridat</button>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove_paragraph">smazat obsah </button>
                </div>
            </form>
        </div>

        <!--formulář pro stravovani2-->

        <div class="main-section">
            <p>Stravování 2 stupeň</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="function">Přidat odstavec </label>
                    <input type="text" name="stravovani2">
                </div>
                <div class="general-item">
                    <button type="submit" name="add_paragraph2">pridat</button>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove_paragraph2">smazat obsah </button>
                </div>
            </form>
        </div>
        <div class="main-section">
            <p>Přidat VZ</p>
            <!--formulář pro přidání VZ-->
            <form method="post" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="VZ_name" required class="input-field">
                </div>
                <div class="general-item">
                    <input type="file" name="VZ" required class="file-input"><br>
                </div>
                <div class="general-item">
                    <button type="submit" name="upload_VZ" class="submit-button">Přidat dokument</button>
                </div>
            </form>
        
            <p>Odstranit VZ</p>
            <!--formulář pro odebrání VZ-->
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_VZ">Název k odstranění:</label>
                    <select name="remove_VZ" id="remove_VZ">
                        <?php
                        $documents = getFiles('./data/VZ/dokumenty.json');
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
    <div class="main-section">
            <p>Přidat IZ</p>
            <!--formulář pro přidání IZ-->
            <form method="post" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="IZ_name" required class="input-field">
                </div>
                <div class="general-item">
                    <input type="file" name="IZ" required class="file-input"><br>
                </div>
                <div class="general-item">
                    <button type="submit" name="upload_IZ" class="submit-button">Přidat dokument</button>
                </div>
            </form>
        
            <p>Odstranit IZ</p>
            <!--formulář pro odebrání IZ-->
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_IZ">Název k odstranění:</label>
                    <select name="remove_IZ" id="remove_IZ">
                        <?php
                        $documents = getFiles('./data/IZ/dokumenty.json');
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
    <div class="main-section">
            <p>Přidat Školní řád</p>
            <!--formulář pro přidání školní řád-->
            <form method="post" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="SR_name" required class="input-field">
                </div>
                <div class="general-item">
                    <input type="file" name="SR" required class="file-input"><br>
                </div>
                <div class="general-item">
                    <button type="submit" name="upload_SR" class="submit-button">Přidat dokument</button>
                </div>
            </form>
        
            <p>Odstranit školní řád</p>
            <!--formulář pro odebrání školní řád-->
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_SR">Název k odstranění:</label>
                    <select name="remove_SR" id="remove_SR">
                        <?php
                        $documents = getFiles('./data/SR/dokumenty.json');
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

    <div class="main-section">
            <p>Přidat ŠVP</p>
            <!--formulář pro přidání š.v.p.-->
            <form method="post" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="SVP_name" required class="input-field">
                </div>
                <div class="general-item">
                    <input type="file" name="SVP" required class="file-input"><br>
                </div>
                <div class="general-item">
                    <button type="submit" name="upload_SVP" class="submit-button">Přidat dokument</button>
                </div>
            </form>
        
            <p>Odstranit ŠVP</p>
            <!--formulář pro odebrání školní řád-->
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_SVP">Název k odstranění:</label>
                    <select name="remove_SVP" id="remove_SVP">
                        <?php
                        $documents = getFiles('./data/SVP/dokumenty.json');
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
    <div class="main-section">
        <!--formulář přidání projektu--> 
            <p>Přidat projekt</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="project_name" required class="input-field">
                </div>
                <div class="general-item">
                    <input type="file" name="project" accept="image/*">
                </div> 
                <div class="general-item">
                    <button type="submit" name="add_project">Přidat projekt</button>
                </div>            
            </form>

        <!--formulář pro odebrani projektu-->    
            <p>Odstranit projekt</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_project">Název k odstranění:</label>
                    <select name="remove_project" required> 
                        <?php
                        $data = getFiles('./data/projekty/projekty.json');
                        foreach ($data as $item) {
                            echo '<option value="' . htmlspecialchars($item['project_name']) . '">' . htmlspecialchars($item['project_name']) . '</option>';
                        } 
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove4">Odstranit projekt</button>
                </div>
            </form>
        </div>
        <!--formulář pro uchazeči-->

        <div class="main-section">
            <p>Uchazeči</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="function">Přidat odstavec </label>
                    <input type="text" name="uchazeci">
                </div>
                <div class="general-item">
                    <button type="submit" name="add_paragraph32">pridat</button>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove_paragraph32">smazat obsah </button>
                </div>
            </form>
        </div>


        <div class="main-section">
            <p>Přidat Rozvrh</p>
            <!--formulář pro přidání rozvrhu-->
            <form method="post" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="RZ_name" required class="input-field">
                </div>
                <div class="general-item">
                    <input type="file" name="RZ" required class="file-input"><br>
                </div>
                <div class="general-item">
                    <button type="submit" name="upload_RZ" class="submit-button">Přidat dokument</button>
                </div>
            </form>
        
            <p>Odstranit ŠVP</p>
            <!--formulář pro odebrání rozbrhu-->
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_RZ">Název k odstranění:</label>
                    <select name="remove_RZ" id="remove_RZ">
                        <?php
                        $documents = getFiles('./data/RZ/dokumenty.json');
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
    <div class="main-section">
        <!--formulář přidání uspechu--> 
            <p>Přidat úspěch</p>
            <form method="post" action="" enctype="multipart/form-data" class="general">
                <div class="general-item">
                    <label for="title">Název:</label>
                    <input type="text" name="us_name" required class="input-field">
                </div>
                <div class="general-item">

                    <input type="file" name="us" accept="image/*">
                </div> 
                <div class="general-item">
                    <button type="submit" name="add_us">Přidat úspěch</button>
                </div>            
            </form>

        <!--formulář pro odebrani uspechu-->    
            <p>Odstranit úspěch</p>
            <form method="post" action="" class="general">
                <div class="general-item">
                    <label for="remove_us">Název k odstranění:</label>
                    <select name="remove_us" required> 
                        <?php
                        $data = getFiles('./data/uspechy/uspechy.json');
                        foreach ($data as $item) {
                            echo '<option value="' . htmlspecialchars($item['us_name']) . '">' . htmlspecialchars($item['us_name']) . '</option>';
                        } 
                        ?>
                    </select>
                </div>
                <div class="general-item">
                    <button type="submit" name="remove_us">Odstranit úspěch</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>

<?php
ob_end_flush();
?>