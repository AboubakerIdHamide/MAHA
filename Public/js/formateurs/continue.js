$(function () {
    // Loader
    document.body.style.overflow = "hidden";
    $(window).on('load', function () {
        document.body.style.overflow = "auto";
        $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(350);
        $(window).scroll();
    });

    // Jquery Validation
    const $wizardForm = $("#wizard-form");

	$.validator.addMethod("lettersonly", function(value, element) {
    	return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
	}, "Le champ ne peut contenir que des lettres et des espaces.");
  
    // Wizard form validation
      $wizardForm.validate({
       rules: {
		    categorie: {
		        required: true,
		    },
		    speciality: {
		        required: true,
		        minlength: 3,
		        maxlength: 15,
		        lettersonly: true
		    },
		    biography: {
		        required: true,	
		        minlength: 15,
		        maxlength: 700,	        
		    },
		},
		messages: {
		    categorie: {
		        required: "Veuillez sélectionner une catégorie.",
		    },
		    speciality: {
		        required: "votre specialité est requis.",
		        minlength: "votre specialité doit comporter au moins {0} caractères.",
		        maxlength: "votre specialité ne doit pas dépasser {0} caractères.",
		        lettersonly: "votre specialité ne peut contenir que des lettres."
		    },
		    biography: {
		        required: "votre biographie est requise.",
		        minlength: "votre biographie doit comporter au moins {0} caractères.",
		        maxlength: "votre biographie ne doit pas dépasser {0} caractères.",
		    },
		},
		highlight: function(element) {
		    $(element).addClass("input_error");
		},
		unhighlight: function(element) {
		    $(element).removeClass("input_error");
		},
    });

    //  Wizard
	$("#wizard_container").wizard({
		stepsWrapper: "#wizard-form",
		submit: ".submit",
		beforeSelect: function (event, state) {
			if (!state.isMovingForward) return true;
			const inputs = $(this).wizard('state').step.find(':input');
			return !inputs.length || !!inputs.valid();
		},
		afterSelect: function (event, state) {
			$("#progressbar").progressbar("value", state.percentComplete);
			$(".location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
		}
	});

	//  progress bar
	$("#progressbar").progressbar();

	const Delta = Quill.import('delta');
	const quill = new Quill('#editor-container', {
        theme: 'snow' 
    });

  	quill.on('text-change', function(delta, oldDelta, source) {
        $('#biography').val(quill.container.firstChild.innerHTML);
    });

    // Store accumulated changes
	let change = new Delta();
	quill.on('text-change', function(delta) {
		change = change.compose(delta);
		localStorage.setItem('quillChanges', JSON.stringify(quill.getContents()));
	});

	// Save periodically
	setInterval(function() {
		if (change.length() > 0) {
			console.log('Saving changes', change);
			change = new Delta();
		}
	}, 5*1000);

	// Load saved changes from local storage when the page loads
	const savedChanges = localStorage.getItem('quillChanges');
	if (savedChanges) {
		quill.setContents(JSON.parse(savedChanges), 'api');
	}

	// Check for unsaved data
	$(window).on('beforeunload', function(){
		if (change.length() > 0) {
			return 'Il y a des modifications non enregistrées. Êtes-vous sûr(e) de vouloir quitter?';
		}
	});
});