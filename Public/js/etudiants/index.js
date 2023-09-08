$(function () {
	const URLROOT = 'http://localhost/MAHA';
	const $courses = $('#courses');
	const $pagination = $('#pagination');

	function fetch() {
		const search = window.location.search;

        $.ajax({
            type: 'GET',
            url: `${URLROOT}/etudiant/inscriptions/${search}`,
            beforeSend: function () {
                $courses.append(`
                    <div id="course-loading" class="text-center my-5 w-100 d-flex justify-content-center">
                    	<div class="spinner-wrapper">
                    		<div class="spinner-grow text-warning" style="width: 3rem; height: 3rem;" role="status">
	                    	</div>
                    	</div>
                    </div>
                `);
            },
            success: function ({data}) {
                const { my_courses, totalRecords, currentPage, nextPage, totalPages, prevPage } = data;
                renderCourses(my_courses, totalRecords, currentPage, nextPage);
                renderPagination(totalPages, currentPage, nextPage, prevPage, totalRecords);
            },
            error: function(){
                $courses.empty().append(`
                    <div class="col-12">
                        <div class="alert alert-danger text-center">Something went wrong, please try again</div>
                    </div>
                `);;
            }
        });
    }

    fetch();

    function renderCourses(courses, totalRecords, currentPage, nextPage) {
    	$courses.empty();
        if(totalRecords === 0){
            $courses.html(`
                <div class="col-12">
		           	<div class="alert alert-light alert-dismissible border-1 border-left-3 border-left-info">
		                <div class="text-black-70 d-flex align-items-center">
		                	<i class="material-icons mr-2 text-info">info</i> 
		                	<span>You didn't subscribe to any course yet.</span>
		                </div>
		            </div> 
                </div>
            `);
            return;           
        }

        courses.forEach((course) => {
            $courses.append(`
                <div class="col-12 col-sm-6">
                	<div class="card">
                		<div class="card-header text-center">
	                        <h4 class="card-title text-truncate mb-0"><a href="${URLROOT}/etudiant/formation/${course.id_formation}">${course.nomFormation}</a></h4>
	                        <div class="rating">
	                            ${course.jaimes} <i class="material-icons text-danger">favorite</i>
	                        </div>
	                    </div>
	                    <a href="${URLROOT}/etudiant/formation/${course.id_formation}">
	                        <img src="${URLROOT}/public/images/${course.image}"
	                             alt="image formation"
	                             style="width:100%;">
	                    </a>
	                    <div class="card-body">
	                        <small class="text-muted text-truncate d-block">${course.nomCategorie}</small>
	                        <div class="description mb-2">
	                            ${course.description}
	                    	</div>
	                        <span class="badge badge-primary">${course.nomNiveau}</span>
	                        <span class="badge badge-primary">${course.nomLangue}</span>
	                    </div>
	                </div>
                </div>
            `);
        });
    }

    function renderPagination(totalPages, currentPage, nextPage, prevPage, totalRecords){
    	$pagination.empty();
    	if(totalRecords < 2){
    		return;
    	}

    	$pagination.append(`
    		<ul class="pagination justify-content-center pagination-sm">
			    <li data-page="${prevPage}" class="page-item ${!prevPage && 'disabled'}">
			        <a class="page-link"
			           href="javascript:void(0)"
			           aria-label="Previous">
			            <span aria-hidden="true"
			                  class="material-icons">chevron_left</span>
			            <span>Prev</span>
			        </a>
			    </li>
			    ${(function(){
			    	let pageItems = '';
			    	for(let i = 1;i <= totalPages;i++){
			    		pageItems += `
			    			<li data-page="${i}" class="page-item ${currentPage === i && 'active'}">
						        <a class="page-link"
						           href="javascript:void(0)"
						           aria-label="1">
						            <span>${i}</span>
						        </a>
						    </li>
			    		`;
			    	}
			    	return pageItems;
			    })()}
			    <li data-page="${nextPage}" class="page-item ${!nextPage && 'disabled'}">
			        <a class="page-link"
			           href="javascript:void(0)"
			           aria-label="Next">
			            <span>Next</span>
			            <span aria-hidden="true"
			                  class="material-icons">chevron_right</span>
			        </a>
			    </li>
			</ul>
		`);

		$('li.page-item').click(function(){
            $('html, body').animate({ scrollTop: 0 }, 'slow');
			const page = parseInt($(this).data('page'));
			const currentPage = getParam('page') ? getParam('page') : 1; 
			if(currentPage !== page){
				setParams('page', page);
				fetch();
			}
		});
    }

    function setParams(key, value){
        const url = new URL(window.location);
        if(value) {
            url.searchParams.set(key, value);
        }else{
            url.searchParams.delete(key);
        }
        history.replaceState(null, null, url);
    }

    function getParam(name) {
      const params = new URLSearchParams(window.location.search);
      return params.get(name);
    }

    function showErrorMessage(message){
    	$('#join-code-help').text(message)
		.addClass('text-danger').removeClass('text-muted');
		$('#join-code').addClass('is-invalid');
    }

    function removeErrorMessage(message){
    	$('#join-code-help').text(message).addClass('text-muted').removeClass('text-danger');
    	$('#join-code').val("").removeClass('is-invalid');
    }

    // Rejoindre des cours privés
   	const helperText = $('#join-code-help').text();
    $('#join-form').submit(function(event){
    	event.preventDefault();
    	const code = $(this).serializeArray()[0];
    	const format = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;

    	if(code.value.length < 30 || code.value.length > 60 || format.test(code.value)){
    		showErrorMessage("Sorry! The giving code is not valid.");
 			return;
    	}

    	$.post(`${URLROOT}/etudiant/joinCourse`, {code: code.value}, function({messages}){
    		$('#join-course').modal('toggle');
    		$('#message').html(`
    			<div class="alert alert-light border-1 border-left-3 border-left-success d-flex justify-content-between">
	      			<div class="d-flex">
                    	<i class="material-icons text-success mr-3">check_circle</i>
                    	<div class="text-body">${messages}</div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					   <span aria-hidden="true">&times;</span>
					</button>
                </div>
	        `);
	        fetch();
    	}).fail(function({responseJSON: {messages}}){
    		showErrorMessage(messages?.code_error ?? messages);
    	});
    });

    // Clear Modal
    $('#join-course').on('hidden.bs.modal', function () {
    	removeErrorMessage(helperText);
	});
});