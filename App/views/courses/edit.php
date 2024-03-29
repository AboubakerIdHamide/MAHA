<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Edit formation | <?= SITENAME ?></title>

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap" />

        <!-- Perfect Scrollbar -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/perfect-scrollbar.css" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/material-icons.css" />

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/icons/fontawesome.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

        <!-- Quill Theme -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/quill.css" />

        <!-- Nestable -->
        <link rel="stylesheet"  href="<?= CSSROOT ?>/plugins/nestable.css">

        <!-- Plyr CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/plyr.min.css" />
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }

            /* Firefox */
            input[type=number] {
              --moz-appearance: textfield;
            }
        </style>    
    </head>

    <body class="layout-fluid">

        <div class="preloader">
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>

            <!-- <div class="sk-bounce">
    <div class="sk-bounce-dot"></div>
    <div class="sk-bounce-dot"></div>
  </div> -->

            <!-- More spinner examples at https://github.com/tobiasahlin/SpinKit/blob/master/examples.html -->
        </div>

        <!-- Header Layout -->
        <div class="mdk-header-layout js-mdk-header-layout">
            <!-- require navbar header -->
            <?php require_once APPROOT . "/views/includes/formateur/navbar.php" ?>

            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content">
                <div data-push
                     data-responsive-width="992px"
                     class="mdk-drawer-layout js-mdk-drawer-layout">
                    <div class="mdk-drawer-layout__content page ">
                        <form id="edit-course-form" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/formateur">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/courses">Formations</a></li>
                                <li class="breadcrumb-item active">Modifier Formation</li>
                            </ol>
                            <div class="media align-items-center mb-headings">
                                <div class="media-body">
                                    <h1 class="h2">Modifier Formation</h1>
                                </div>
                                <div class="media-right">
                                    <a target="_blank" class="btn btn-secondary" href="<?= URLROOT ?>/courses/<?= $formation->slug ?>">
                                        <i class="material-icons mr-2">remove_red_eye</i> Live preview
                                    </a>
                                    <button id="edit-course" class="btn btn-success"><i class="material-icons mr-2">edit</i> MODIFIER</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="progressWrapper" class="my-3" style="display: none;">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" style="width: 0;background-color: rgba(57,68,77,.84)" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div id="message"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Basic Information</h4>
                                        </div>
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="title">Titre</label>
                                                <input type="text"
                                                       id="title"
                                                       name="nom"
                                                       value="<?= $formation->nomFormation ?>" 
                                                       class="form-control"
                                                       placeholder="Ecrire un titre"
                                                       >
                                            </div>

                                            <div class="form-group mb-0">
                                                <label class="form-label">Description</label>
                                                <div style="height: 150px;margin-bottom: 0"
                                                     data-toggle="quill"
                                                     data-quill-placeholder="..."
                                                     data-quill-modules-toolbar='[["bold", "italic"], [ "blockquote", "code"], [{"list": "ordered"}, {"list": "bullet"}]]' id="editor-container">
                                                     <?= $formation->description ?>
                                                </div>
                                                <textarea id="description" name="description" class="d-none"><?= $formation->description ?></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Preview video</h4>
                                        </div>
                                        <div class="preview-wrapper">
                                            <video width="200" src="<?= VIDEOROOT ?>/<?= $formation->url ?>" style="--plyr-color-main: #39444d;" id="player" playsinline controls>
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="card-body">
                                           <div class="custom-file">
                                                <input type="file"
                                                           id="preview-video"
                                                           name="preview" 
                                                           class="custom-file-input"
                                                           accept="video/*">
                                                <label for="preview-video"
                                                           class="custom-file-label">Choose file</label>
                                            </div>                                      
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Background Image</h4>
                                        </div>
                                        <div id="background-placeholder" style="background-color: #39444d" class="d-flex justify-content-center align-items-center w-100 mb-2">
                                            <?php if($formation->bgImg): ?>
                                                <img src="<?= IMAGEROOT ?>/<?= $formation->bgImg ?>" alt="background formation" class="img-fluid" />
                                            <?php else: ?>
                                                <i class="material-icons text-muted-light md-36" style="height: 250px;line-height: 250px">photo</i>
                                            <?php endif ?>
                                        </div>
                                        <div class="card-body">
                                            <div class="custom-file">
                                                <input type="file"
                                                       id="formation_background"
                                                       name="background" 
                                                       class="custom-file-input"
                                                       accept="image/*" 
                                                />
                                                <label for="formation_background"
                                                           class="custom-file-label">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="card">
                                        <div><img src="<?= IMAGEROOT ?>/<?= $formation->imgFormation ?>"
                                                 alt="formation image"
                                                 class="w-100"
                                                 id="image"
                                                 /></div>
                                        <div class="card-body">
                                            <div class="custom-file">
                                                <input type="file"
                                                       id="formation_image"
                                                       name="image" 
                                                       class="custom-file-input"
                                                       accept="image/*" />
                                                <label for="formation_image"
                                                           class="custom-file-label">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Meta</h4>
                                            <p class="card-subtitle">Extra Options </p>
                                        </div>

                                        <div class="card-body"
                                              action="#">
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="category">Category</label>
                                                <select name="id_categorie" id="category"
                                                        class="custom-select form-control">
                                                        <?php foreach($categories as $category) : ?>
                                                            <option <?= $formation->nomCategorie === $category->nom ? 'selected' : '' ?> value="<?= $category->id_categorie ?>"><?= $category->nom ?></option>
                                                        <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="price">Prix</label>
                                                <input type="number"
                                                       id="price"
                                                       name="prix"
                                                       value="<?= $formation->prix ?>" 
                                                       class="form-control"
                                                       placeholder="Prix (min: 10$)"
                                                       value="10">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="level">Niveau</label>
                                                <select name="id_niveau" id="level"
                                                        class="custom-select form-control">
                                                        <?php foreach($niveaux as $niveau) : ?>
                                                            <option <?= $formation->nomNiveau === $niveau->nom ? 'selected' : '' ?> value="<?= $niveau->id_niveau ?>"><?= $niveau->nom ?></option>
                                                        <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="attached-file">Attached File</label>
                                                <div>
                                                    <?php if($formation->fichier_attache): ?>
                                                    <div id="file-wrapper" class="mb-2 rounded d-flex align-items-center justify-content-between px-2" style="height: 50px;background-color: #eee">
                                                        <div class="d-flex align-items-center">
                                                            <i class="material-icons mr-1">file_present</i>
                                                            <span>attached_file.zip</span>
                                                        </div>
                                                        <div>
                                                            <a style="color:inherit;" href="<?= URLROOT ?>/public/files/<?= $formation->fichier_attache ?>" download><i style="cursor: pointer;" class="material-icons mr-1">file_download</i></a>
                                                            <i data-id="<?= $formation->id_formation ?>" id="remove-file" style="cursor: pointer;" class="material-icons">clear</i>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                           id="attached-file"
                                                           name="attached" 
                                                           class="custom-file-input"
                                                           accept="application/zip" />
                                                        <label for="attached-file"
                                                               class="custom-file-label">Choose file</label>
                                                    </div>
                                                </div>  
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="language">Langue</label>
                                                <select name="id_langue" id="language"
                                                        class="custom-select form-control">
                                                        <?php foreach($langues as $langue) : ?>
                                                            <option <?= $formation->nomLangue === $langue->nom ? 'selected' : '' ?>  value="<?= $langue->id_langue ?>"><?= $langue->nom ?></option>
                                                        <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="scope">Visibilité</label>
                                                <select name="etat" id="scope"
                                                        class="custom-select form-control">
                                                        <?php foreach(['Publique' => 'public', 'Privé' => 'private'] as $key => $value) : ?>
                                                        <option <?= $formation->etat === $value ? 'selected' : '' ?>  value="<?= $value ?>"><?= $key ?></option>
                                                        <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="flex">
                                            <label class="form-label" for="is_published">IS PUBLISHED</label><br>
                                            <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                                <input <?= !is_null($formation->is_published) ? 'checked' : '' ?> type="checkbox" id="is_published" class="custom-control-input" name="is_published">
                                                <label class="custom-control-label" for="is_published">NO</label>
                                            </div>
                                            <label class="form-label mb-0" for="is_published">YES</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="<?= $formation->id_formation ?>" id="id_formation" />
                        </form>
                    </div>

                    <!-- require sidebar -->
                    <?php require_once APPROOT . "/views/includes/formateur/sideNavbar.php" ?>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <!-- jQuery -->
        <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>

        <!-- Plyr -->
        <script src="<?= JSROOT ?>/plugins/plyr.min.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/popper.min.js"></script>

        <!-- Perfect Scrollbar -->
        <script src="<?= JSROOT ?>/plugins/perfect-scrollbar.min.js"></script>

        <!-- MDK -->
        <script src="<?= JSROOT ?>/plugins/dom-factory.js"></script>
        <script src="<?= JSROOT ?>/plugins/material-design-kit.js"></script>

        <!-- Highlight.js -->
        <script src="<?= JSROOT ?>/plugins/hljs.js"></script>

        <!-- Quill -->
        <script src="<?= JSROOT ?>/plugins/quill.min.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>

        <!-- App JS -->
        <script src="<?= JSROOT ?>/plugins/app.js"></script>

        <!-- Jquery Validation -->
        <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>

        <script>const URLROOT = `<?= URLROOT ?>`;</script>
        <script src="<?= JSROOT ?>/courses/edit.js"></script>
    </body>
</html>