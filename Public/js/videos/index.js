$(function(){
     $('[data-toggle="tooltip"]').tooltip()
    // ================ Player ===========================
    const players = {};

    Array.from(document.querySelectorAll('video')).forEach(video => {
        players[video.id] = new Plyr(video, {captions: {active: true}});
    });

    // ================= Custom validations =================
    // Add a custom method for validating accepted file types
    $.validator.addMethod('allowedTypes', function(value, element, allowedTypes) {
        const file = element.files[0];
        if (!file) {
            return true;
        }

        return allowedTypes.indexOf(file.type) !== -1;
    }, function(allowedTypes){return 'Please select a valid image file (' + allowedTypes.join(', ') + ').'});

    // Add a custom method for maximum file size validation
    $.validator.addMethod('maxFileSize', function(value, element, maxSizeMB) {
        const file = element.files[0];

        if (!file) {
          return true;
        }

        const maxSizeBytes = maxSizeMB * 1024 * 1024;
        return file.size <= maxSizeBytes;
    }, function (maxSizeMB){ return 'File size exceeds ' + maxSizeMB + 'MB limit.'});

    // Add a custom method for validating time in HH:MM format
    $.validator.addMethod("maxTime", function(value, element, time) {
        if (element.files && element.files.length > 0) {
            const prefix = element.id.replace('-video', '');
            const duration = $(`#${prefix} video`)[0].duration.toFixed(2) ?? 0;
            return duration < 60 * time;
        }

        return true; 
    }, function(time){return `La durée maximale est de ${time} minutes.`});

    // ====================== END =======================================

    // ================== input type file ====================
    $('.video-input').change(function (event) {
        const prefix = '#' + $(this).attr('id').replace('-video', '');

        const file = event.target.files[0];
        const fileName = file.name;
        const blobURL = URL.createObjectURL(file);
        $(`${prefix} video`).prop('src', blobURL);

        setTimeout(() => {
            $(`${prefix} label[for="lesson-video"]`).html('<div class="loader loader-secondary"></div>');
            if($(this).valid()){
                $(`${prefix} .preview-video`).removeClass('d-none');
                $(`${prefix} label[for="lesson-video"]`).text(fileName);
                $(`${prefix} [id*=v-title]`).val(fileName.substring(0, fileName.length - 4)).valid();
            }else{
                $(`${prefix} video`).prop('src', '#');
                $(`${prefix} .preview-video`).addClass('d-none');
                $(`${prefix} label[for="lesson-video"]`).text('Choose video');
            }
        }, 300);
    });

    // ==================================== Handle create lesson ===================
    // Create lesson form validation
    const $createLessonForm = $("#create-lesson-form");

    // create lesson Button
    const $createLessonBtn = $('#create-lesson-btn');

    $createLessonForm.validate({
        // debug: true,
        errorElement: "div",
        // onfocusout: false,
        // focusInvalid: false,
        rules: {
            lesson_video: {
                required: true,
                maxFileSize: 1024, // Maximum file size in bytes (1GB)
                allowedTypes: ['video/mp4', 'video/mov', 'video/avi', 'video/x-matroska'],
                maxTime: 50
            },
            v_title: {
                required: true,
                minlength: 3,
                maxlength: 80,
            },
            v_description: {
                required: true,
                minlength: 3,
                maxlength: 800,
            },
        },
        messages: {
            lesson_video: {
                required: "Veuillez sélectionner un lesson vidéo.",
            },
            v_title: {
                required: "Le titre est requis.",
                minlength: "Le titre doit comporter au moins {0} caractères.",
                maxlength: "Le titre ne doit pas dépasser {0} caractères.",
            },
            v_description: {
                required: "La description est requise.",
                minlength: "La description doit comporter au moins {0} caractères.",
                maxlength: "La description ne doit pas dépasser {0} caractères.",
            },
        },
        errorPlacement: function(error, element){
            error.addClass('invalid-feedback').appendTo(element.parent());
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function(form){
            const formData = new FormData(form);
            $(form).serializeArray().forEach((field) => formData.append(field.name, field.value));
            $('#create-lesson-form :input').prop('disabled', true);
            $createLessonBtn
                .addClass('is-loading')
                .addClass('is-loading-sm')
                .prop('disabled', true);

            $.ajax({
              url: `${URLROOT}/api/videos`, 
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function({status, data: video, messages}) {
                if(status === 201){
                    AddVideoToUI(video);
                    refreshTooltips();
                    $('.set-preview-btn').click(function(){handleSetVideoToPreview($(this))});
                    // Hide Modal
                    $('.close').click();

                    showMessage('success', messages, 'Success');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');

                    $('.edit-lesson')
                        .off()
                        .click(function() { fillEditModal($(this).data('video')) });
                }
              },
              error: function(response) {
                console.log(response);
                alert('Failed to submit the form.');
              },
              complete: function(){
                $createLessonBtn
                .removeClass('is-loading')
                .removeClass('is-loading-sm')
                .prop('disabled', false);

                $('#create-lesson-form :input').prop('disabled', false);
              }
            });
        }
    });

    // ==================================== Handle Edit lesson =========================
    // edit lesson form validation
    const $editLessonForm = $('#edit-lesson-form');

    // edit lesson Button
    const $editLessonBtn = $('#edit-lesson-btn');

    $editLessonForm.validate({
        // debug: true,
        errorElement: "div",
        // onfocusout: false,
        // focusInvalid: false,
        rules: {
            lesson_video: {
                required : {
                    depends: function(element) {
                        return $(element).val().trim().length > 0;
                    }
                },
                maxFileSize: 1024, // Maximum file size in bytes (1GB)
                allowedTypes: ['video/mp4', 'video/mov', 'video/avi', 'video/x-matroska'],
                maxTime: 50
            },
            v_title: {
                required: true,
                minlength: 3,
                maxlength: 80,
            },
            v_description: {
                required: true,
                minlength: 3,
                maxlength: 800,
            },
        },
        messages: {
            v_title: {
                required: "Le titre est requis.",
                minlength: "Le titre doit comporter au moins {0} caractères.",
                maxlength: "Le titre ne doit pas dépasser {0} caractères.",
            },
            v_description: {
                required: "La description est requise.",
                minlength: "La description doit comporter au moins {0} caractères.",
                maxlength: "La description ne doit pas dépasser {0} caractères.",
            },
        },
        errorPlacement: function(error, element){
            error.addClass('invalid-feedback').appendTo(element.parent());
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function(form){
            const formData = new FormData(form);
            $(form).serializeArray().forEach((field) => formData.append(field.name, field.value));
            $('#edit-lesson-form :input').prop('disabled', true);
            $editLessonBtn
                .addClass('is-loading')
                .addClass('is-loading-sm')
                .prop('disabled', true);

            $.ajax({
              url: `${URLROOT}/api/videos/${$('[name="id_video"]').val()}`, 
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function({messages, data: video}) {
                updateVideoInUI(video);
                // Hide Modal
                $('.close').click();
                showMessage('success', messages, 'Success');
                $('html, body').animate({ scrollTop: 0 }, 'slow');
              },
              error: function(response) {
                console.log(response);
                alert('Failed to submit the form.');
              },
              complete: function(){
                $editLessonBtn
                .removeClass('is-loading')
                .removeClass('is-loading-sm')
                .prop('disabled', false);

                $('#edit-lesson-form :input').prop('disabled', false);
              }
            });
        }
    });

    function showMessage(bgColor, message, strongMessage){
        $('.mb-headings').after(`
            <div class="alert alert-dismissible bg-${bgColor} text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>${strongMessage}</strong> ${message}
            </div>
        `);
    }

    function AddVideoToUI(video){
        $('.nestable-list').append(`
            <li class="nestable-item nestable-item-handle"
                data-id="${video.id_video}">
                <div class="nestable-handle"><i class="material-icons">menu</i></div>
                <div class="nestable-content">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <img src="${URLROOT}/public/images/${video.thumbnail}"
                                 alt="thumbnail video"
                                 width="100"
                                 class="rounded">
                        </div>
                        <div class="media-body">
                            <h5 class="card-title h6 mb-0">
                                <a href="#" class="video-name">${video.nomVideo}</a>
                            </h5>
                            <small class="text-muted created-at">created ${video.created_at}</small>
                        </div>
                        <div class="media-right d-flex gap-3 align-items-center">
                            <button data-id-formation="${video.id_formation}" data-id-video="${video.id_video}" class="btn btn-white btn-sm set-preview-btn" data-toggle="tooltip" data-placement="top" title="Make it Preview"><i class="material-icons">play_circle_outline</i></button>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" data-video='${JSON.stringify(video)}' data-target="#edit-lesson" data-toggle="modal" class="dropdown-item edit-lesson"><i class="material-icons">edit</i> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="javascript:void(0)"><i class="material-icons">delete</i> Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        `);
    }

    function updateVideoInUI(video){
        const videoItem = $(`.nestable-list li[data-id="${video.id_video}"]`);

        videoItem.find('img').attr('src', `${URLROOT}/public/images/${video.thumbnail}`);
        videoItem.find('.video-name').text(video.nomVideo);
        videoItem.find('.created-at').text(`created ${video.created_at}`);
        videoItem.find('.edit-lesson').data('video', video);
    }

    // ======================== When Modal Closed Clear it =====================
    $("#add-lesson, #edit-lesson").on("hidden.bs.modal", function () {
        // Clear Modal
        $('[name="v_title"]').val('');
        $('[name="v_description"]').val('');
        $('[name="lesson_video"]').val('');
        $('[name="id_video"]').val('');
        $('.custom-file-label').text('Choose video');
        $('video').prop('src', '#');
        $('.preview-video').addClass('d-none');
    });

    function fillEditModal(video) {
        $('#edit-lesson-form [name="v_title"]').val(video.nomVideo);
        $('#edit-lesson-form [name="v_description"]').val(video.description);
        $('#edit-lesson-form [name="id_video"]').val(video.id_video);
        $("#edit-lesson video").prop('src', `${URLROOT}/videos/${video.url}`);
        $('#edit-lesson .preview-video').removeClass('d-none');
        $('#edit-lesson label[for="lesson-video"]').text(video.nomVideo);
    }

    $('.edit-lesson').click(function() { fillEditModal($(this).data('video')) });

    // Sort Videos
    let initialOrder = $('.nestable').nestable('serialize');
    $('.nestable').change(function(){
        const updatedOrder = $(this).nestable('serialize');
        if(JSON.stringify(initialOrder) !== JSON.stringify(updatedOrder)){
            initialOrder = updatedOrder;
            $.post(`${URLROOT}/courses/sortVideos/${$(this).data('id-formation')}`, { order: updatedOrder }, function(response) {
                console.log('Order successfully:', response);
            }).fail(function(xhr, status, error) {
                console.log('Error sending order:', xhr);
            });
        }
    });

    function refreshTooltips(){
        $('.tooltip.show').remove();
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Set Video to preview
    function handleSetVideoToPreview(currentButton){
        $.post(`${URLROOT}/courses/setVideoToPreview/${currentButton.data('id-formation')}`, { id_video: currentButton.data('id-video') }, function({data}) {
            const previousPreview = $('.preview-badge');
            previousPreview.replaceWith(`<button data-id-formation="${previousPreview.data('id-formation')}" data-id-video="${previousPreview.data('id-video')}" class="btn btn-white btn-sm set-preview-btn" data-toggle="tooltip" data-placement="top" title="Make it Preview"><i class="material-icons">play_circle_outline</i></button>`);     
            currentButton.replaceWith(`<span data-id-formation="${currentButton.data('id-formation')}" data-id-video="${currentButton.data('id-video')}" class="badge badge-pill badge-light preview-badge">Preview</span>`);
            refreshTooltips();
            $('.set-preview-btn').click(function(){ handleSetVideoToPreview($(this)) });
        }).fail(function(xhr, status, error) {
            console.log('Error sending order:', xhr);
        });
    }

    $('.set-preview-btn').click(function(){handleSetVideoToPreview($(this))});

    // Delete video
    $('.delete-video').click(function(){
        $.ajax({
            url: `${URLROOT}/api/videos/${$(this).data('id')}`, 
            type: 'DELETE',
            data: {method: 'DELETE'},
            processData: false,
            contentType: false,
            success: function({messages}) {
                // Remove from DOM
                $(`.nestable-list.li[data-id="${$(this).data('id')}"]`).remove();
                showMessage('success', messages, 'Success');
                $('html, body').animate({ scrollTop: 0 }, 'slow');
            },
            error: function(response) {
                console.log(response);
                alert('Failed to submit the form.');
            },
        });
    });

    // to top button
    const $toTopBtn = $('.to-top-btn');

    $(window).scroll(function(){
        if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
            $toTopBtn.fadeIn('slow');
        } else {
            $toTopBtn.fadeOut('slow');
        }
    });

    $toTopBtn.click(function() {
        $("html, body").animate({ scrollTop: 0 }, 'slow');
        return false;
    })

    // Open the overlay when the button is clicked
    $(".video-name").click(function(event) {
        $("#overlay").fadeIn();
        $(".overlay-content").css({ transform: "translate(-50%, -50%)" });
        $("body").css({
            overflow : 'hidden'
        });

        $('#player-show').prop('src', $(this).data('url'));
    });

    function hideOverlay() {
        $("#overlay").fadeOut();
        $(".overlay-content").css({ transform: "translate(-50%, 1000%)" });
        $("body").css({
            overflow : 'auto'
        });
        
        $('#player-show').prop('src', '#');
    }

    $("#closeBtn, #overlay").click(hideOverlay);
});
