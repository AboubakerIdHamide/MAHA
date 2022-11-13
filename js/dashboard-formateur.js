let courses = [
	{ id: 1, langue : 'Francais', niveauFormation : 'Débutant' ,apprenants : 12, titre: "SQL and MYSQL For PHP Developers 1", likes : 12, description : 'Description 1', zipFile : '#', dateUploaded : '2022-10-20', videos : '/idFormation', miniature : './images/thumb.jpg', prix : 120, spec : 'Code'},
	{ id: 2, langue : 'Francais', niveauFormation : 'Intermédiaire' ,apprenants : 11, titre: "SQL and MYSQL For PHP Developers 2", likes : 4, description : 'Description 2', zipFile : '#', dateUploaded : '2022-02-15', videos : '/idFormation', miniature : './images/default.jpg', prix : 80, spec : 'Architecture & BIM'},
	{ id: 3, langue : 'Anglais', niveauFormation : 'Avancé' ,apprenants : 10, titre: "SQL and MYSQL For PHP Developers 3", likes : 5, description : 'Description 3', zipFile : '#', dateUploaded : '2022-05-08', videos : '/idFormation', miniature : './images/landing.jpg', prix : 90, spec : 'Photographie'},
	{ id: 4, langue : 'Espagnol', niveauFormation : 'Intermédiaire' ,apprenants : 2, titre: "SQL and MYSQL For PHP Developers 4", likes : 10, description : 'Description 4', zipFile : '#', dateUploaded : '2022-01-12', videos : '/idFormation', miniature : './images/avatar-05.png', prix : 22, spec : 'Réseaux informatique'},
	{ id: 5, langue : 'Espagnol', niveauFormation : 'Débutant' ,apprenants : 3, titre: "SQL and MYSQL For PHP Developers 5", likes : 120, description : 'Description 5', zipFile : '#', dateUploaded : '2022-11-27', videos : '/idFormation', miniature : './images/membre.jpg', prix : 13, spec : 'Management'}
];

const render = (cours) => {
	const $tbody = $('tbody');
	$tbody.html('');

	for(let course of cours){
		let tr = `
		<tr>
			<td class="text-center"><input onchange='selectedCourses(event,${course.id});' type="checkbox" class="form-check-input fs-5 select"></td>
			<td><p class="titre">${course.titre}</p></td>
			<td class="text-center" style="font-weight: 600;">${course.likes}</td>
			<td><p class="desc">${course.description}</p></td>
			<td class="text-center" style="font-weight: 600;">${course.apprenants}</td>
			<td class="text-center"><a href='${course.zipFile}' class="btn btn-success btn-sm">Telecharger</a></td>
			<td class="text-center">${course.dateUploaded}</td>
			<td class="text-center"><a href="${course.videos}" class="btn btn-warning btn-sm">Leçons</a></td>
			<td class="text-center"><strong>${course.prix} $</strong></td>
		</tr>
		`;

		$tbody.html($tbody.html() + tr);
	}
}

// render received the data into the DOM
render(courses);


let coursesSelected = [];
const selectedCourses = (event, id) => {
	if(event.target.checked){
		coursesSelected.push(id);
		event.target.parentElement.parentElement.style.backgroundColor = '#dee2e6';
	}
	else
		if(coursesSelected.includes(id)){
			coursesSelected.splice(coursesSelected.indexOf(id), 1);
			event.target.parentElement.parentElement.style.backgroundColor = '#fff';
		}

	if(coursesSelected.length !== 0){
		$('button#delete').removeAttr('disabled');
		if(coursesSelected.length === 1)
			$('button#edit').removeAttr('disabled');
		else
			$('button#edit').attr('disabled', 'disabled');
		$('small#count-label').show();
		// console.log(coursesSelected);
		$('small#count-selected').text(coursesSelected.length);
	}
	else{
		$('button#delete').attr('disabled', 'disabled');
		$('button#edit').attr('disabled', 'disabled');
		$('small#count-label').hide();
		$('small#count-selected').text('');
	}
}

const $deleteBtn = $('button#deleteCours');
$deleteBtn.click(function (event) {
	courses = courses.filter(course => {
		if(!coursesSelected.includes(course.id))
			return course;
	});

	// clear selected courses
	coursesSelected = [];

	// apres la suppression
	render(courses);
	console.log('AJAX CALL FOR DELETE');
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
	const $modalSpec = $('#spec');
	const $modalNiveau = $('#niveau');
	const $modalLangue = $('#langue');
	
	const currentCours = courses.filter(cours => cours.id === coursesSelected[0])[0];
	$modalTitle.attr('placeholder', currentCours.titre);
	$modalDescription.val(currentCours.description);
	$modalMiniature.attr('src', currentCours.miniature);
	$modalPrix.attr('placeholder', currentCours.prix);
	$modalSpec.val(currentCours.spec);
	$modalNiveau.val(currentCours.niveauFormation);
	$modalLangue.val(currentCours.langue);
});


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

// ====================  Update Files (Ressources)  ================
const handleRessourse = (files) => {
	const fileType = event.target.files[0].type;

	if(fileType !== 'application/zip'){
		$('.error-ressources').text('error only zip file !!!');
		e.preventDefault();
		return;
	}

	$('.error-ressources').text('');
	// let form = new FormData();
	// form.append('zipFile', files[0])
};

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
		$('.error-title').text('');
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
		$('.error-prix').text('');
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
	if($("input[name='q']").val().length !== 0 ){
		// $.ajax({
		// 	method : 'GET',
		// 	data : {q : $("input[name='q']").val()},
		// 	success: function(result){
		// 		// $("#div1").html(result);
		// 		console.log(result);
		// 	}
		// })
		console.log('Ajax Call');
	}
	else
		event.preventDefault();
});



