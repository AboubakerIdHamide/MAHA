$(function(){
    const URLROOT = 'http://localhost/MAHA';
	const $langues = $('input[name="langue"]');
	const $niveaux = $('input[name="niveau"]');
	const $categories = $('input[name="categorie"]');
	const $duration = $('input[name="duration"]');
    const $courses = $('#courses');
    const $sortBy = $('input[name="sort"]');

    function addLoadMoreBtn(nextPage, currentPage, totalPages) {
        if(currentPage === totalPages) return;

        $courses.append(`
            <p class="text-center">
                <button id="load-more" data-next="${nextPage}" class="btn_1 rounded add_top_30">Load more</button>
            </p>
        `);

        $('#load-more').click(function(){
            fetch($(this).data('next'));
        });
    }

    function fetch(pageNumber = 1) {
        const search = window.location.search ? window.location.search + '&' : '?';

        $.ajax({
            type: 'GET',
            url: URLROOT + '/api/courses' + search + 'page=' + pageNumber,
            beforeSend: function () {
                $('#load-more').remove();
                
                if(pageNumber === 1) {
                    $courses.html(`
                        <div id="course-loading" class="text-center my-5">
                        <div class="spinner-grow text-warning" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </div>
                    `);
                }else{
                    $courses.append(`
                        <div id="course-loading" class="text-center my-5">
                        <div class="spinner-grow text-warning" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </div>
                    `);
                }
            },
            success: function ({data}) {
                const { courses, totalCourses, currentPage, nextPage, totalPages } = data;
                renderCourses(courses, totalCourses, currentPage, nextPage);
                addLoadMoreBtn(nextPage, currentPage, totalPages);
            },
            fail: function(){
                $courses.html('');
                $courses.append(`
                    <div class="col-12">
                        <div class="alert alert-danger text-center">Something went wrong, please try again</div>
                    </div>
                `);
            },
            complete: function(){
                $('#course-loading').fadeOut().remove();
            }
        });
    }

    function renderCourses(courses, totalCourses, currentPage, nextPage) {
        if(currentPage === 1) {
            $courses.html('');
            $('.hero-section').html(`
                <h3 class="text-center text-white">
                    ${totalCourses} résultats ${getParam('q') ? `pour “${getParam('q')}”` : ''}
                </h3>
            `)
        }

        if(totalCourses === 0){
            $courses.append(`
                <div class="col-12">
                    <div class="alert alert-warning text-center">Nous sommes désolés, nous n’avons trouvé aucun résultat.</div>
                </div>
            `);
            return;            
        }

        for(let course of courses){
            $courses.append(`
                <div class="col-md-6">
                    <div class="box_grid wow">
                        <figure class="block-reveal">
                            <div class="block-horizzontal"></div>
                            <span class="langue">
                                <i class="fa-solid fa-language me-1"></i> 
                                ${course.nomLangue}
                            </span>
                            <span class="niveau d-flex align-items-center gap-2">
                                <span>${course.iconNiveau}</span>
                            </span>
                            <span class="likes d-flex align-items-center gap-2">
                                <i class="fa-solid fa-heart" style="color: #e91e63"></i>
                                ${course.jaimes}
                            </span>
                            <a href="${URLROOT}/courses/${course.slug}">
                                <img src="${URLROOT}/public/images/${course.imgFormation}" class="img-fluid" alt="image formation">
                            </a>
                            <div class="price">$${course.prix}</div>
                            <div class="preview"><span>Apercu de formation</span></div>
                        </figure>
                        <div class="wrapper">
                            <small>${course.nomCategorie}</small>
                            <h3 class="title">${course.nomFormation}</h3>
                            <p class="description">${course.description}</p>
                        </div>
                        <ul>
                            <li>
                                <i class="fa-solid fa-clock"></i>
                                ${course.mass_horaire.split(':')[0]}h
                                ${course.mass_horaire.split(':')[1]}min
                            </li>
                            <li><i class="fa-solid fa-user"></i> ${course.total_inscriptions}</li>
                            <li><a href="${URLROOT}/PaymentPaypal/makePayment/${course.id_formation}">Acheter</a></li>
                        </ul>
                    </div>
                </div>
            `);
        }
    }

    // First Fetch
    fetch();

    function setParams(key, value){
        const url = new URL(window.location);
        if(value !== 'all') {
            url.searchParams.set(key, value);
        }else{
            url.searchParams.delete(key);
        }
        history.replaceState(null, null, url);
        fetch();
    }

    function getParam(name) {
      const params = new URLSearchParams(window.location.search);
      return params.get(name);
    }

    function checkButton(buttons, name){
    	const value = getParam(name);
    	const button = buttons.filter(function() {
          return $(this).val() === value;
        }).prop('checked', true).parent().addClass('checked');

    	if(button.length === 0) $(`input[name="${name}"][value="all"]`).prop('checked', true).parent().addClass('checked');
    }

    checkButton($langues, 'langue');
    checkButton($niveaux, 'niveau');
    checkButton($categories, 'categorie');
    checkButton($sortBy, 'sort');
    checkButton($duration, 'duration');

    const filters = [$langues, $niveaux, $categories, $sortBy, $duration];

    filters.forEach(filter => {
        filter.on('ifChecked change', function(event){
            setParams(event.target.name, event.target.value);
            const width = $(window).width();
            if(width > 991) $(window).scrollTop(100);
        });
    });

    $('.searchForm').submit(function (event) {
        event.preventDefault();
        const [ input ] = $(this).serializeArray();
        setParams(input.name, input.value);
        $('.closebt').click();
        const width = $(window).width();
        if(width > 991) $(window).scrollTop(100);
    });

    $('#input-search').val(getParam('q') || '');

    $('.filter_type').click(function(){
        $(this).find('ul').slideToggle();
        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
    });

    // Check and radio input styles
    $('input.icheck').iCheck({
        checkboxClass: 'icheckbox_square-yellow',
        radioClass: 'iradio_square-yellow'
    });
    
    // Sticky filters
    $(window).bind('load resize', function () {
        const width = $(window).width();
        if (width <= 991) {
            $('.sticky_horizontal').stick_in_parent({
                offset_top: 51.40
            });
        } else {
            $('.sticky_horizontal').stick_in_parent({
                offset_top: 73
            });
        }
    });

    // WoW - animation on scroll
    const wow = new WOW({
        boxClass:     'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset:       0,          // distance to the element when triggering the animation (default is 0)
        mobile:       true,       // trigger animations on mobile devices (default is true)
        live:         true,       // act on asynchronously loaded content (default is true)
        callback:     function(box) {
        // the callback is fired every time an animation is started
        // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null // optional scroll container selector, otherwise use window
    });
    wow.init();
});