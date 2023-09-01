$(function () {
	// Prevent Default Behavior.
	$('#filter-form .dropdown').on('hide.bs.dropdown', function(event){
		event.preventDefault();
	});

	// Hide the dropdown only the user clicks outside the dropdown.
	$(document).on('click', function(event){
		const $dropdown = $('#filter-form .dropdown');
		if($dropdown.has(event.target).length <= 0){
			$('#filter-form .dropdown, #filter-form .dropdown-menu').removeClass('show');
		}
	});

	const URLROOT = 'http://localhost/MAHA';
	const $courses = $('#courses');
	const $pagination = $('#pagination');
	const $display = $('#display');
	const $filterForm = $('#filter-form');
	const $categories = $('#categories');
	
	function fetch() {
        const search = window.location.search === '' ? '?' : window.location.search + '&';

        $.ajax({
            type: 'GET',
            url: `${URLROOT}/api/courses${search}page_for=formateur`,
            beforeSend: function () {
                $courses.append(`
                    <div id="course-loading" class="text-center my-5">
                    <div class="spinner-grow text-warning" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    </div>
                `);
            },
            success: function ({data}) {
                const { courses, totalRecords, currentPage, nextPage, totalPages, prevPage } = data;
                renderCourses(courses, totalRecords, currentPage, nextPage);
                renderPagination(totalPages, currentPage, nextPage, prevPage, totalRecords);
                $display.text(`Displaying ${courses.length} out of ${totalRecords} courses`);
            },
            fail: function(){
                $courses.empty().append(`
                    <div class="col-12">
                        <div class="alert alert-danger text-center">Something went wrong, please try again</div>
                    </div>
                `);;
            },
            complete: function(){
                $('#course-loading').fadeOut().remove();
            }
        });
    }

    fetch();

    function renderCourses(courses, totalRecords, currentPage, nextPage) {
    	$courses.empty();
    	$('#alert').empty();
        if(totalRecords === 0){
            $('#alert').html(`
               <div class="alert alert-light alert-dismissible border-1 border-left-3 border-left-warning">
                    <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="text-black-70">Ohh no! No courses to display. Add some courses.</div>
                </div> 
            `);
            return;           
        }

        courses.forEach((course) => {
            $courses.append(`
                <div class="col-md-6" data-course="${course.id_formation}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-sm-row">
                                <a href="${URLROOT}/courses/${course.id_formation}/videos"
                                   class="avatar avatar-lg avatar-4by3 mb-3 w-xs-plus-down-100 mr-sm-3">
                                    <img src="${URLROOT}/public/images/${course.imgFormation}"
                                         alt="Image formation"
                                         class="avatar-img rounded">
                                </a>
                                <div class="flex"
                                     style="min-width: 200px;">
                                    <h5 class="card-title text-base m-0"><strong>${course.mass_horaire}</strong></h5>
                                    <h4 class="card-title mb-1"><a href="${URLROOT}/courses/${course.id_formation}/videos">${course.nomFormation}</a></h4>
                                    <p class="text-black-70">${course.nomCategorie}</p>
                                    <div class="d-flex align-items-end">
                                        <div class="d-flex flex flex-column mr-3">
                                            <div class="d-flex align-items-center py-1 border-bottom">
                                                <small class="text-black-70 mr-2">&dollar; ${course.prix}</small>
                                                <small class="text-black-50 mr-2">${course.total_inscriptions} SALES</small>
                                                <small class="text-black-50">${course.jaimes} LIKES</small>
                                            </div>
                                            <div class="d-flex align-items-center py-1">
                                                <small class="text-muted mr-2">${course.nomLangue}</small>
                                                <small class="text-muted mr-2">${course.nomNiveau}</small>
                                                <small class="text-muted">(${course.date_creation})</small>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <a href="${URLROOT}/courses/${course.slug}"
                                            	target="_blank"
                                               class="btn btn-sm btn-white"><i class="material-icons">visibility</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card__options dropdown right-0 pr-2">
                            <a href="#"
                               class="dropdown-toggle text-muted"
                               data-caret="false"
                               data-toggle="dropdown">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"
                                   href="${URLROOT}/courses/edit/${course.id_formation}">Edit course</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger delete-course"
                                   href="javascript:void(0)" data-id="${course.id_formation}" >Delete course</a>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        });

        // Delete Course
        $('.delete-course').click(function(){
            const id = $(this).data('id');
            $.ajax({
                type: 'POST',
                data: {method: 'DELETE'},
                url: `${URLROOT}/api/courses/${id}`,
                success: function ({messages}) {
                    $('#alert').html(`
                        <div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <strong>${messages}</strong>
                        </div>
                    `);
                    $(`[data-course="${id}"]`).remove();
                },
                fail: function(response){
                    $('#alert').append(`
                        <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <strong>Something went wrong!</strong>
                        </div>
                    `);;
                },
            });
        });
    }

    function renderPagination(totalPages, currentPage, nextPage, prevPage, totalRecords){
    	$pagination.empty();
    	if(totalRecords === 0){
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

    $filterForm.submit(function(event){
    	event.preventDefault();
    	console.log($(this).serializeArray());
    	$(this).serializeArray().forEach((field) => setParams(field.name, field.value));
    	setParams('page', 1);
    	fetch();
    });

    $categories.change(() => $filterForm.submit());
    $('input[name="sort"]').change(() => $filterForm.submit());

    function setParams(key, value){
        const url = new URL(window.location);
        if(value !== 'all') {
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

    // clear filtering
    $('#clearFilters').click(function(){ 
    	$categories.val('all');
    	$('[name="q"]').val('');
    	$('input[name="sort"]').prop('checked', false);
   		$filterForm.serializeArray().forEach((field) => setParams(field.name, field.value));
   		setParams('page', 1);
   		console.log(1);
   		fetch();
    });
});