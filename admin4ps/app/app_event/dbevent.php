<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../../config.php');
require_once('../../../framework/joomlike.class.php');
require_once('../../../framework/mysql.class.php');

$db = new DB();

$SAVE = $_REQUEST['save'] ?? '';
$update = $_REQUEST['update'] ?? '';

if (isset($_REQUEST['option']) && $_REQUEST['option'] == 'common') {
    $date = date('d-m-Y');

    $maxdateRow = $db->loadObject("SELECT MAX(start_date) AS maxdate FROM events_creations");
    $maxdate = $maxdateRow ? date('d-m-Y', strtotime((string) $maxdateRow->maxdate)) : $date;

    $emaxdateRow = $db->loadObject("SELECT MAX(end_date) AS emaxdate FROM events_creations");
    $emaxdate = $emaxdateRow ? date('d-m-Y', strtotime((string) $emaxdateRow->emaxdate)) : $date;

    $finalvalue[] = [$maxdate, $emaxdate, $date];
    echo json_encode($finalvalue);
}

if ($SAVE == 'Save') {
    $name = $db->escape($_REQUEST['txt_evt_name']);
    $desc = $db->escape($_REQUEST['txt_evt_desc']);
    $sdate = date('Y-m-d', strtotime((string) $_REQUEST['txt_evt_sdate']));
    $edate = date('Y-m-d', strtotime((string) $_REQUEST['txt_evt_edate']));
    $userid = (int)$_REQUEST['userid'];
    $random = random_int(1, 1000000);
    $imgidentity = $userid . '_' . $random;

    $userRow = $db->loadObject("SELECT username FROM user WHERE id = $userid");
    $username = $userRow->username ?? '';

    // File upload
    $target_dir = "../../../images/events/";
    $filename = $imgidentity . '_' . basename((string) $_FILES["txt_evt_logo"]["name"]);
    $target_file = $target_dir . $filename;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed)) {
        // Optional: error handling
    } else {
        $db->query("INSERT INTO events_creations(event_name,event_desc,start_date,end_date,uservalue,username,filename)
                    VALUES('$name','$desc','$sdate','$edate',$userid,'$username','$filename')");

        // Compress image
        function compress_image($source, $destination, $quality) {
            $info = getimagesize($source);
            if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source);
            elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source);
            elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source);
            imagejpeg($image, $destination, $quality);
            return $destination;
        }

        if ($_FILES["txt_evt_logo"]["error"] === 0) {
            compress_image($_FILES["txt_evt_logo"]["tmp_name"], $target_file, 30);
        }

        echo '<script>
            alert("Saved Successfully.");
            document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
        </script>';
    }
}

if ($_REQUEST['option'] == 'edit') {
    $id = (int)$_REQUEST['editid'];
    $row = $db->loadObject("SELECT id,event_name,event_desc,start_date,end_date,filename FROM events_creations WHERE id=$id");

    if ($row) {
        $finalvalue[] = [
            $row->id,
            stripslashes((string) $row->event_name),
            stripslashes((string) $row->event_desc),
            date('d-m-Y', strtotime((string) $row->start_date)),
            date('d-m-Y', strtotime((string) $row->end_date)),
            "../../../images/events/" . $row->filename,
            $row->filename
        ];
        echo json_encode($finalvalue);
    }
}

if ($update == 'Update') {
    $id = (int)$_REQUEST['rowid'];
    $name = $db->escape($_REQUEST['txt_evt_name']);
    $desc = $db->escape($_REQUEST['txt_evt_desc']);
    $sdate = date('Y-m-d', strtotime((string) $_REQUEST['txt_evt_sdate']));
    $edate = date('Y-m-d', strtotime((string) $_REQUEST['txt_evt_edate']));
    $userid = (int)$_REQUEST['userid'];
    $random = random_int(1, 1000000);
    $imgidentity = $userid . '_' . $random;

    $imagename = basename((string) $_FILES["txt_evt_logo"]["name"]);
    if ($imagename == '') {
        $filename = $_REQUEST['imageid'];
    } else {
        $filename = $imgidentity . '_' . $imagename;
        $target_file = "../../../images/events/" . $filename;
    }

    $db->query("UPDATE events_creations SET
                event_name='$name',
                event_desc='$desc',
                start_date='$sdate',
                end_date='$edate',
                filename='$filename'
                WHERE id=$id");

    if ($_FILES["txt_evt_logo"]["error"] === 0) {
        compress_image($_FILES["txt_evt_logo"]["tmp_name"], $target_file, 30);
    }

    echo '<script>
        alert("Updated Successfully");
        document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
    </script>';
}

if ($_REQUEST['option'] == 'delete') {
    $id = (int)$_REQUEST['delid'];
    $db->query("DELETE FROM events_creations WHERE id=$id");
    echo '1';
}
?>
