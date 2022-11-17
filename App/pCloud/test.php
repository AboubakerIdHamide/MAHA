<?php
use pCloud\Sdk\App;
use pCloud\Sdk\Folder;
use pCloud\Sdk\File;


// Include autoload.php and set the credential file path
$access_token = "RMiu7ZMHkx8X1cEMzZM8uWc7ZJVsOoA1ivS8mjThYfGA97ytfhmh7";
$locationid = 1;

$pCloudApp = new App();
$pCloudApp->setAccessToken($access_token);
$pCloudApp->setLocationId($locationid);

// Create Folder instance
$pcloudFolder = new Folder($pCloudApp);

// Create new folder in root
$globalFolderID= 15171390512;
$userFolderId = $pcloudFolder->create("Nom_Prenom_type_12", $globalFolderID);
$imagesFolderId = $pcloudFolder->create("Images", $userFolderId);
$ressourcesFolderId = $pcloudFolder->create("Ressources", $userFolderId);
$videosFolderId = $pcloudFolder->create("Videos", $userFolderId);

// Create File instance
// $pcloudFile = new File($pCloudApp);

// Upload new file in created folder
// $fileMetadata = $pcloudFile->upload("./sample.png", $folderId);

// Get folder content
// $folderContent = $pcloudFolder->getContent($folderId);

?>