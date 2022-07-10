<?php
require "../src/functions.php";
require "../src/database.php";
require "../src/config.php";

$protocol = "https";
try {
     $type = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
} catch (Exception $e) {
     echo $e;
}

$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_POST["sharex"])) {
     if ($_POST["harex"] == "true") {
          $key = $_POST['key'];
     } else {
          $key = $_GET['key'];
     }
} else if (isset($_GET["sharex"])) {
     $key = $_GET['key'];
} else {
     $key = $_POST['key'];
}

$sql = "SELECT * FROM users WHERE `secret`='" . $key . "'";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();
$userid = $user['id'];
$username = $user['username'];
$emcolor = $user['embedcolor'];
$emdesc = $user['embeddesc'];
$emauthor = $user['embedauthor'];
$emtitle = $user['embedtitle'];
$role = $user['role'];
$use_embed = $user['use_embed'];
$use_customdomain = $user['use_customdomain'];
$use_subdomain = $user['use_subdomain'];
$invisible_url = $user['use_invisible_url'];
$emoji_url = $user['use_emoji_url'];
$uuid = $user['uuid'];
$uploadToDomain = $user['upload_domain'];
$subdomain = $user['subdomain'];
$uploads = intval($user['uploads']) + 1;
$filename_type = $user['filename_type'];
$url_type = $user['url_type'];
$last_uploaded = $user['last_uploaded'];
$banned = $user['banned'];
$upload_limit = $user['upload_limit'];
$upload_size_limit = $user['upload_size_limit'];
$self_destruct_upload = $user["self_destruct_upload"];

$toggles = "SELECT * FROM toggles";
$result = $mysqli->query($toggles);
$toggles = $result->fetch_assoc();
$maintenance = $user1['maintenance'];
$allow_uploads = $user1['allow_uploads'];
$announcement = $user1['announcement'];


if ($maintenance == "true") {
     die("Currently under maintenance!");
} else {
     if ($allow_uploads == "true") {
          if ($user['id']) {
               if (!empty($_FILES['file'])) {
                    if ($banned == "true") {
                         die("You are banned!");
                    } else if ($banned = "false") {
                         if (!file_exists("uploads/$uuid")) {
                              mkdir('uploads/' . $uuid, 0777);
                         }
                         if (!file_exists("uploads/$uuid/$username")) {
                              mkdir('uploads/' . $uuid . '/' . $username, 0777);
                         }

                         $invite = ranCode(8) . "-" . ranCode(8) . "-" . ranCode(8) . "-" . ranCode(8);
                         if ($uploads == 500) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         } else if ($uploads == 1000) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         } else if ($uploads == 1500) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         } else if ($uploads == 2000) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         } else if ($uploads == 2500) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         } else if ($uploads == 3000) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         } else if ($uploads == 3500) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         } else if ($uploads == 4000) {
                              $sql = "INSERT INTO `invites`(`id`, `inviteCode`, `inviteAuthor`) VALUES (NULL, '" . $invite . "', '" . $username . "');";
                              $mysqli->query($sql);
                         }
                         $rnd = rndFileName(8);
                         if ($filename_type == "short") {
                              $rnd = rndFileName(8);
                              $hash = $rnd . "." . $type;
                              $smallHash = $rnd;
                         } else if ($filename_type == "long") {
                              $rnd = rndFileName(16);
                              $hash = $rnd . "." . $type;
                              $smallHash = $rnd;
                         }

                         // FILECHECK 
                         $type = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                         $original_filename = $_FILES['file']['name'];
                         $fileurl = $protocol . DOMAIN . DIRECTORY . "uploads/$hash.$type";
                         $filelocation = __DIR__ . "uploads/$hash.$type";
                         if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $uuid . "/$username/" . $hash)) {
                              $sql = "SELECT * FROM users WHERE secret = '$key'";
                              $result = $mysqli->query($sql);
                              $user = $result->fetch_assoc();
                              $uuid = $user['uuid'];
                              $source = "direct/index.html";
                              $destination = 'uploads/' . $uuid . '/index.html';
                              copy($source, $destination);
                              $destination = 'uploads/' . $uuid . '/' . $username . '/index.html';
                              copy($source, $destination);
                              date_default_timezone_get('Europe/Berlin');
                              $date = date("F d, Y h:i:s A");
                              $sql = "UPDATE `users` SET `last_uploaded`='$date' WHERE `username`='$username'";
                              $mysqli->query($sql);
                              $sql = "UPDATE `users` SET uploads=" . $uploads . " WHERE secret=" . $key;
                              $mysqli->query($sql);
                              $source = "uploads/" . $hash;
                              $destination = 'uploads/' . $uuid . '/' . $username . "/" . $hash;

                              if ($use_embed == "true") {

                                   $hash_filename_emoji = generateRandomEmoji($hash_filename);
                                   $hash_filename = generateInvisible($hash_filename);
                                   $fileurl = $protocol . DOMAIN . DIRECTORY . "uploads/$hash";
                                   $files = scandir('uploads/');
                                   $filesize = human_filesize(filesize('uploads/' . $uuid . '/' . $username . "/" . $hash), 2);

                                   $filesize_placeholder = "%filesize";
                                   $filename_placeholder = "%filename";
                                   $username_placeholder = "%username";
                                   $userid_placeholder = "%id";
                                   $date_placeholder = "%date";
                                   $date_placeholder = "%date";
                                   $uploads_placeholder = "%uploads";

                                   if (strpos($emdesc, "'") !== false) {
                                        $newdesc = str_replace("'", " ", $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   $delete_secret = generateSecret(16);
                                   if (strpos($emdesc, $filename_placeholder) !== false) {
                                        $newdesc = str_replace("%filename", $hash, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $filesize_placeholder) !== false) {
                                        $newdesc = str_replace("%filesize", $filesize, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $username_placeholder) !== false) {
                                        $newdesc = str_replace("%username", $username, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $userid_placeholder) !== false) {
                                        $newdesc = str_replace("%id", $userid, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $date_placeholder) !== false) {
                                        $newdesc = str_replace("%date", $date, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $uploads_placeholder) !== false) {
                                        $newdesc = str_replace("%uploads", $uploads, $emdesc);
                                        $emdesc = $newdesc;
                                   }

                                   if (strpos($emauthor, "'") !== false) {
                                        $newauthor = str_replace("'", " ", $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $filename_placeholder) !== false) {
                                        $newauthor = str_replace("%filename", $hash, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $filesize_placeholder) !== false) {
                                        $newauthor = str_replace("%filesize", $filesize, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $username_placeholder) !== false) {
                                        $newauthor = str_replace("%username", $username, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $userid_placeholder) !== false) {
                                        $newauthor = str_replace("%id", $userid, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $date_placeholder) !== false) {
                                        $newauthor = str_replace("%date", $date, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $uploads_placeholder) !== false) {
                                        $newauthor = str_replace("%uploads", $uploads, $emauthor);
                                        $emauthor = $newauthor;
                                   }

                                   if (strpos($emtitle, $filename_placeholder) !== false) {
                                        $newtitle = str_replace("%filename", $hash, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $filesize_placeholder) !== false) {
                                        $newtitle = str_replace("%filesize", $filesize, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $username_placeholder) !== false) {
                                        $newtitle = str_replace("%username", $username, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $userid_placeholder) !== false) {
                                        $newtitle = str_replace("%id", $userid, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $date_placeholder) !== false) {
                                        $newtitle = str_replace("%date", $date, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $uploads_placeholder) !== false) {
                                        $newtitle = str_replace("%uploads", $uploads, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, "'") !== false) {
                                        $newtitle = str_replace("'", " ", $emtitle);
                                        $emtitle = $newtitle;
                                   }

                                   if (strpos($uploadToDomain, $filename_placeholder) !== false) {
                                        $newDomain = str_replace("%filename", $hash, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $filesize_placeholder) !== false) {
                                        $newDomain = str_replace("%filesize", $filesize, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $username_placeholder) !== false) {
                                        $newDomain = str_replace("%username", $username, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $userid_placeholder) !== false) {
                                        $newDomain = str_replace("%id", $userid, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $date_placeholder) !== false) {
                                        $newDomain = str_replace("%date", $date, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $uploads_placeholder) !== false) {
                                        $newDomain = str_replace("%uploads", $uploads, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if ($use_customdomain == "true") {
                                        if ($url_type == "short") {
                                             echo "https://" . $uploadToDomain . DIRECTORY . "/" . $hash;
                                        } else if ($url_type == "long") {
                                             echo "https://" . BASE_DOMAIN . "/uploads/$uuid/$username/$hash";
                                        }
                                   }
                                   if ($use_subdomain == "true") {
                                        if ($url_type == "short") {
                                             echo "https://" . $subdomain . $uploadToDomain . DIRECTORY . "/" . $hash;
                                        } else if ($url_type == "long") {
                                             echo "https://" . BASE_DOMAIN . "/uploads/$uuid/$username/$hash";
                                        }
                                   } else {

                                        if ($url_type == "short") {
                                             if ($emoji_url == "true") {
                                                  echo "https://" . DOMAIN . DIRECTORY . "/" . $hash_filename_emoji;
                                                  $hash_filename_db = urlencode($hash_filename_emoji);
                                             } else if ($invisible_url == "true") {
                                                  echo "https://" . DOMAIN . DIRECTORY . "/" . $hash_filename;
                                                  $hash_filename_db = urlencode($hash_filename);
                                             } else {
                                                  echo "https://" . DOMAIN . DIRECTORY . "/" . $hash;
                                             }
                                        } else if ($url_type == "long") {
                                             echo "https://" . BASE_DOMAIN . "/uploads/$uuid/$username/$hash";
                                        }
                                   }

                                   $sql = "INSERT INTO `uploads` (`id`, `userid`, `username`, `filename`, `hash_filename`, `original_filename`, `filesize`, `delete_secret`, `self_destruct_upload`, `embed_color`, `embed_author`, `embed_title`, `embed_desc`, `role`, `uploaded_at`, `ip`) VALUES (NULL,'" . $userid . "', '" . $username . "', '" . $hash . "', '$hash_filename_db', '" . $original_filename . "', '" . $filesize . "', '" . $delete_secret . "', '" . $self_destruct_upload . "', '" . $emcolor . "', '" . $emauthor . "', '" . $emtitle . "', '" . $emdesc . "', '" . $user['role'] . "', '" . $date . "', '" . $ip . "');";
                                   $result = mysqli_query($mysqli, $sql);
                                   $filesize = human_filesize(filesize('uploads/' . $uuid . '/' . $username . "/" . $hash), 2);
                              } else {

                                   $hash_filename_emoji = generateRandomEmoji($hash_filename);
                                   $hash_filename = generateInvisible($hash_filename);
                                   $fileurl = $protocol . DOMAIN . DIRECTORY . "uploads/$hash";
                                   $files = scandir('uploads/');
                                   $filesize = human_filesize(filesize('uploads/' . $uuid . '/' . $username . "/" . $hash), 2);

                                   $filesize_placeholder = "%filesize";
                                   $filename_placeholder = "%filename";
                                   $username_placeholder = "%username";
                                   $userid_placeholder = "%id";
                                   $date_placeholder = "%date";
                                   $date_placeholder = "%date";
                                   $uploads_placeholder = "%uploads";
                                   if (strpos($emdesc, "'") !== false) {
                                        $newdesc = str_replace("'", " ", $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   $delete_secret = generateSecret(16);
                                   // Description Placeholders
                                   if (strpos($emdesc, $filename_placeholder) !== false) {
                                        $newdesc = str_replace("%filename", $hash, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $filesize_placeholder) !== false) {
                                        $newdesc = str_replace("%filesize", $filesize, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $username_placeholder) !== false) {
                                        $newdesc = str_replace("%username", $username, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $userid_placeholder) !== false) {
                                        $newdesc = str_replace("%id", $userid, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $date_placeholder) !== false) {
                                        $newdesc = str_replace("%date", $date, $emdesc);
                                        $emdesc = $newdesc;
                                   }
                                   if (strpos($emdesc, $uploads_placeholder) !== false) {
                                        $newdesc = str_replace("%uploads", $uploads, $emdesc);
                                        $emdesc = $newdesc;
                                   }

                                   // Author Placeholders
                                   if (strpos($emauthor, "'") !== false) {
                                        $newauthor = str_replace("'", " ", $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $filename_placeholder) !== false) {
                                        $newauthor = str_replace("%filename", $hash, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $filesize_placeholder) !== false) {
                                        $newauthor = str_replace("%filesize", $filesize, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $username_placeholder) !== false) {
                                        $newauthor = str_replace("%username", $username, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $userid_placeholder) !== false) {
                                        $newauthor = str_replace("%id", $userid, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $date_placeholder) !== false) {
                                        $newauthor = str_replace("%date", $date, $emauthor);
                                        $emauthor = $newauthor;
                                   }
                                   if (strpos($emauthor, $uploads_placeholder) !== false) {
                                        $newauthor = str_replace("%uploads", $uploads, $emauthor);
                                        $emauthor = $newauthor;
                                   }

                                   // Title Placeholders
                                   if (strpos($emtitle, $filename_placeholder) !== false) {
                                        $newtitle = str_replace("%filename", $hash, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $filesize_placeholder) !== false) {
                                        $newtitle = str_replace("%filesize", $filesize, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $username_placeholder) !== false) {
                                        $newtitle = str_replace("%username", $username, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $userid_placeholder) !== false) {
                                        $newtitle = str_replace("%id", $userid, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $date_placeholder) !== false) {
                                        $newtitle = str_replace("%date", $date, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, $uploads_placeholder) !== false) {
                                        $newtitle = str_replace("%uploads", $uploads, $emtitle);
                                        $emtitle = $newtitle;
                                   }
                                   if (strpos($emtitle, "'") !== false) {
                                        $newtitle = str_replace("'", " ", $emtitle);
                                        $emtitle = $newtitle;
                                   }

                                   // Description Placeholders
                                   if (strpos($uploadToDomain, $filename_placeholder) !== false) {
                                        $newDomain = str_replace("%filename", $hash, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $filesize_placeholder) !== false) {
                                        $newDomain = str_replace("%filesize", $filesize, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $username_placeholder) !== false) {
                                        $newDomain = str_replace("%username", $username, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $userid_placeholder) !== false) {
                                        $newDomain = str_replace("%id", $userid, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $date_placeholder) !== false) {
                                        $newDomain = str_replace("%date", $date, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if (strpos($uploadToDomain, $uploads_placeholder) !== false) {
                                        $newDomain = str_replace("%uploads", $uploads, $uploadToDomain);
                                        $uploadToDomain = $newDomain;
                                   }
                                   if ($use_customdomain == "true") {
                                        if ($url_type == "short") {
                                             echo "https://" . $uploadToDomain . DIRECTORY . "/" . $hash;
                                        } else if ($url_type == "long") {
                                             echo "https://" . BASE_DOMAIN . "/uploads/$uuid/$username/$hash";
                                        }
                                   }
                                   if ($use_subdomain == "true") {
                                        if ($url_type == "short") {
                                             echo "https://" . $subdomain . $uploadToDomain . DIRECTORY . "/" . $hash;
                                        } else if ($url_type == "long") {
                                             echo "https://" . BASE_DOMAIN . "/uploads/$uuid/$username/$hash";
                                        }
                                   } else {
                                        if ($url_type == "short") {
                                             if ($emoji_url == "true") {
                                                  echo "https://" . DOMAIN . DIRECTORY . "/" . $hash_filename_emoji;
                                                  $hash_filename_db = urlencode($hash_filename_emoji);
                                             } else if ($invisible_url == "true") {
                                                  echo "https://" . DOMAIN . DIRECTORY . "/" . $hash_filename;
                                                  $hash_filename_db = urlencode($hash_filename);
                                             } else {
                                                  echo "https://" . DOMAIN . DIRECTORY . "/" . $hash;
                                             }
                                        } else if ($url_type == "long") {
                                             echo "https://" . BASE_DOMAIN . "/uploads/$uuid/$username/$hash";
                                        }
                                   }
                                   $query = "INSERT INTO `uploads` (`id`, `userid`, `username`, `filename`, `hash_filename`, `original_filename`, `filesize`, `delete_secret`, `self_destruct_upload`, `embed_color`, `embed_author`, `embed_title`, `embed_desc`, `role`, `uploaded_at`, `ip`) VALUES (NULL,'" . $userid . "', '" . $username . "', '" . $hash . "', '$hash_filename_db', '" . $original_filename . "', '" . $filesize . "', '" . $delete_secret . "', '" . $self_destruct_upload . "', '', '', '', '', '" . $user['role'] . "', '" . $date . "', '" . $ip . "');";
                                   $result = mysqli_query($mysqli, $query);
                                   $filesize = human_filesize(filesize('uploads/' . $uuid . '/' . $username . "/" . $hash), 2);
                              }
                         }
                    } else {
                         echo "Failed to upload your file.";
                    }
               }
          } else {
               echo "Unknown User";
          }
     } else {
          die("Uploading is currently disabled. Please try again later.");
     }
}
