$(document).ready(function(){
	let courses = [];
	let coursesSelected = [];
	const render = (q = '') => {
		courses = $.parseJSON($.ajax({
	        url:  'http://localhost/maha/ajax/getMyFormations/' + q,
	        dataType: "json", 
	        async: false
    	}).responseText);

		const $tbody = $('tbody');
		$tbody.html('');

		let cptLikes = 0, cptApprenants = 0;
		for(let course of courses){
			let tr = `
			<tr>
				<td class="text-center"><input value=${course.id} type="checkbox" class="form-check-input fs-5 select"></td>
				<td><p class="titre">${course.titre}</p></td>
				<td class="text-center" style="font-weight: 600;">${course.likes}</td>
				<td><p class="desc">${course.description}</p></td>
				<td class="text-center" style="font-weight: 600;">${course.apprenants}</td>
				<td class="text-center"><a href='#' class="btn btn-success btn-sm" download>Telecharger</a></td>
				<td class="text-center">${course.dateUploaded}</td>
				<td class="text-center"><a href="http://localhost/maha/formations/videos/${course.id}" class="btn btn-warning btn-sm">Leçons</a></td>
				<td class="text-center"><strong>${course.prix} $</strong></td>
			</tr>
			`;
			cptLikes += Number(course.likes);
			cptApprenants += Number(course.apprenants);
			$tbody.html($tbody.html() + tr);
		}

		$('#nbr-formations').text(courses.length);
		// set count likes and Apprenants
		$('#nbr-likes').text(cptLikes);
		$('#nbr-apprenants').text(cptApprenants);

		$('.form-check-input').change(function (event) {
			const value = $(this).val();
			if(event.target.checked){
				coursesSelected.push(value);
				event.target.parentElement.parentElement.style.backgroundColor = '#dee2e6';
			}
			else
				if(coursesSelected.includes(value)){
					coursesSelected.splice(coursesSelected.indexOf(value), 1);
					event.target.parentElement.parentElement.style.backgroundColor = '#fff';
				}

			if(coursesSelected.length !== 0){
				$('button#delete').removeAttr('disabled');
				if(coursesSelected.length === 1)
					$('button#edit').removeAttr('disabled');
				else
					$('button#edit').attr('disabled', 'disabled');
				$('small#count-label').show();

				$('small#count-selected').text(coursesSelected.length);
			}
			else{
				$('button#delete').attr('disabled', 'disabled');
				$('button#edit').attr('disabled', 'disabled');
				$('small#count-label').hide();
				$('small#count-selected').text('');
			}
		});
	};

	// render received the data into the DOM
	render();
    	
	const $deleteBtn = $('button#deleteCours');
	$deleteBtn.click(function (event) {
		courses = courses.filter(course => {
			if(!coursesSelected.includes(course.id))
				return course;
		});

		$.ajax({
			url : 'http://localhost/maha/ajax/deleteFormation',
			method : 'POST',
			data : {
				id : coursesSelected
			},
			success : function (response) {
				console.log(response);
			}
		})

		// clear selected courses
		coursesSelected = [];

		// apres la suppression
		render();

		$('button.fermer').click();
		$('small#count-selected').text('');
		$('small#count-label').hide();
		$('button#delete').attr('disabled', 'disabled');
		$('button#edit').attr('disabled', 'disabled');
	});

	// ================================ Modal ==========================

	// Remplir le Modal
	const $editBtn = $('button#edit');
	$editBtn.click(function (event) {
		const $modalTitle = $('input#title'); 
		const $modalDescription = $('#description'); 
		const $modalMiniature = $('#miniature');
		const $modalPrix = $('#prix');
		const $modalSpec = $('#categorie');
		const $modalNiveau = $('#niveau');
		const $modalLangue = $('#langue');
		const $modalIdFormation = $('#id');

		const currentCours = courses.filter(cours => cours.id === coursesSelected[0])[0];
		$modalTitle.val(currentCours.titre);
		$modalDescription.val(currentCours.description);
		$modalMiniature.attr('src', 'http://localhost/maha/' + currentCours.miniature);
		$modalPrix.val(currentCours.prix);
		$modalSpec.val(currentCours.categorie);
		$modalNiveau.val(currentCours.niveauFormation);
		$modalLangue.val(currentCours.langue);
		$modalIdFormation.val(currentCours.id);
	});

	function removeTags(str) {
	    if ((str===null) || (str===''))
	        return '';
	    else
	        str = str.toString();
	          
	    // Regular expression to identify HTML tags in 
	    // the input string. Replacing the identified 
	    // HTML tag with a null string.
	    return str.replace(/(<([^>]+)>)/ig, '');
	}

	// Validation inputs
	function ValidationInputs({ title, description, prix }) {
		const cours = courses.filter(cours => cours.id === coursesSelected[0])[0];;
		const titre = removeTags(title.val());
		const desc = removeTags(description.val());
		const price = prix.val();

		// title
		if( titre.length > 0 ){
			if( titre.length < 25 && titre.length >= 5){
				cours.titre = titre;
				$('.error-title').text();
			}else{
				if(titre.length < 5)
					$('.error-title').text('Mininum caracteres 5 !!!');
				else
					$('.error-title').text('Maxmimun caracteres 25 !!!');
				return false;
			}
		}else{
			$('.error-title').text('Matkhlich hadchi vide !!!');
			return false;
		}

		// description
		if( desc.length > 0){
			if( desc.length < 500 && desc.length >= 10){
				cours.description = desc;
				$('.error-desc').text('');
			}else{
				if(desc.length < 10)
					$('.error-desc').text('Mininum caracteres 10 !!!');
				else
					$('.error-desc').text('Maxmimun caracteres 500 !!!');
				return false;
			}
		}else{
			$('.error-desc').text("you can't let description empty !!!");
			return false;
		}

		// Prix 
		if( price.length > 0){
			if( price.match(/^(?!0\d)\d*(\.\d+)?$/mg)){
				cours.prix = Number(price);
				$('.error-prix').text('');
			}else{
				$('.error-prix').text("incorrect number !!!");
				return false;
			}
		}else{
			$('.error-prix').text('Matkhlich hadchi vide !!!');
			return false;
		}

		return true;
	}

	// Effectue le changement
	const $appliquerBtn = $('button#appliquer');
	$appliquerBtn.click(function (event) {
		const cours = {
			title : $('#title'),
			description : $('#description'),
			prix : $('#prix')
		};
		
		if(!ValidationInputs(cours))
			event.preventDefault();
		
	});

	// button chercher
	const $chercheBtn = $('#chercher');
	$chercheBtn.click(function (event) {
		render($("input[name='q']").val());
	});
});

// ====================  Update Files (Ressources)  ================
const handleRessourse = (files) => {
	const fileType = event.target.files[0].type;

	if(fileType !== 'application/zip'){
		$('.error-ressources').text('error only zip file !!!');
		e.preventDefault();
		return;
	}

	$('.error-ressources').text('');
};

// ====================  Update Miniature  ================
const handleMiniature = (files) => {
	const allowedExt = ['image/jpeg', 'image/png', 'image/jpg'];
	const fileType = event.target.files[0].type;

	if(!allowedExt.includes(fileType)){
		$('.error-miniature').text('error only image (jpg, png, jpeg) file !!!');
		e.preventDefault();
		return;
	}

	$('.error-ressources').text('');

	const x = URL.createObjectURL(event.target.files[0]);
	$('#miniature').attr('src', x);
};





















