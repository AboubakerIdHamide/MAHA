<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
        <title>Add formation | <?= SITENAME ?></title>

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,500,700%7CRoboto:400,500%7CRoboto:400,500&display=swap" />

        <!-- Perfect Scrollbar -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/perfect-scrollbar.css" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/material-icons.css" />

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/fontawesome.css" />

        <!-- Preloader -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/spinkit.css" />

        <!-- App CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/app.css" />

        <!-- Quill Theme -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plugins/quill.css" />

        <!-- Nestable -->
        <link rel="stylesheet"  href="<?= CSSROOT ?>/plugins/nestable.css">

        <!-- Plyr CSS -->
        <link rel="stylesheet" href="<?= CSSROOT ?>/plyr.min.css" />
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }

            /* Firefox */
            input[type=number] {
              -moz-appearance: textfield;
            }
        </style>    
    </head>

    <body class=" layout-fluid">

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
                        <form id="add-course-form" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/formateur">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= URLROOT ?>/courses">Formations</a></li>
                                <li class="breadcrumb-item active">Ajouter Formation</li>
                            </ol>
                            <div class="media align-items-center mb-headings">
                                <div class="media-body">
                                    <h1 class="h2">Ajouter Formation</h1>
                                </div>
                                <div class="media-right">
                                    <button id="add-course" class="btn btn-success">AJOUTER</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="progressWrapper" class="my-3" style="display: none;">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" style="width: 0;background-color: rgba(57,68,77,.84)" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
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
                                                </div>
                                                <textarea id="description" name="description" class="d-none"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Preview video</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="preview-wrapper d-none">
                                                <video style="--plyr-color-main: #662d91;" id="player" playsinline controls>
                                                    Your browser does not support the video tag.
                                                </video>
                                                <div class="form-group my-3">
                                                <label class="form-label"
                                                       for="preview-name">Apercu nom</label>
                                                <input type="text" class="form-control" id="preview-name" placeholder="nom Apercu" name="preview_name" />
                                            </div>
                                            </div>
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
                                </div> 
                                <div class="col-md-4">
                                    <div class="card">
                                        <div><img src="<?= IMAGEROOT ?>/formations/formation_image_placeholder.jpg"
                                                         alt="formation image"
                                                         class="w-100"
                                                         id="image-placeholder"
                                                         ></div>
                                        <div class="card-body">
                                            <div class="custom-file">
                                                <input type="file"
                                                           id="formation_image"
                                                           name="image" 
                                                           class="custom-file-input"
                                                           accept="image/*">
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
                                                            <option value="<?= $category->id_categorie ?>"><?= $category->nom ?></option>
                                                        <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="price">Prix</label>
                                                <input type="number"
                                                       id="price"
                                                       name="prix" 
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
                                                            <option value="<?= $niveau->id_niveau ?>"><?= $niveau->nom ?></option>
                                                        <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="language">Langue</label>
                                                <select name="id_langue" id="language"
                                                        class="custom-select form-control">
                                                        <?php foreach($langues as $langue) : ?>
                                                            <option value="<?= $langue->id_langue ?>"><?= $langue->nom ?></option>
                                                        <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="scope">Visibilité</label>
                                                <select name="etat" id="scope"
                                                        class="custom-select form-control">
                                                        <option value="public">Publique</option>
                                                        <option value="private">Privé</option>
                                                </select>
                                            </div>
                                            <div class="flex">
                                            <label class="form-label" for="is_published">IS PUBLISHED</label><br>
                                            <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                                <input type="checkbox" id="is_published" class="custom-control-input" name="is_published">
                                                <label class="custom-control-label" for="is_published">NO</label>
                                            </div>
                                            <label class="form-label mb-0" for="is_published">YES</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        <!-- Jquery UI -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- App JS -->
        <script src="<?= JSROOT ?>/plugins/app.js"></script>

        <!-- Highlight.js -->
        <script src="<?= JSROOT ?>/plugins/hljs.js"></script>

        <!-- Quill -->
        <script src="<?= JSROOT ?>/plugins/quill.min.js"></script>

        <!-- Bootstrap -->
        <script src="<?= JSROOT ?>/plugins/bootstrap-4.min.js"></script>

        <!-- Jquery Validation -->
        <script src="<?= JSROOT ?>/plugins/jquery.validate.min.js"></script>

        <script src="<?= JSROOT ?>/courses/add.js"></script>
    </body>
</html>