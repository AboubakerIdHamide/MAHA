$(function(){
    const URLROOT = 'http://localhost/maha';

    //=========== Chart Handler ============
    const $selectYear = $('#select-year');

    function getEarnings(year) {
        $.ajax({
	        url: `${URLROOT}/formateur/getEarnings?year=${year}`,
	        beforeSend: function () {
	            $('#earningChart').html(`
	                <div class="d-flex h-100 align-items-center justify-content-center">
	                    <div class="spinner-border text-primary" role="status"></div>
	                </div>
	            `);
	        },
	        success: function ({data}) {
	            renderChart(data);
	        },
	        error: function(){
	            $('#earningChart').html(`
	                <div class="d-flex h-100 align-items-center justify-content-center">
	                    <strong class="text-danger">Something went wrong!</strong>
	                </div>
	            `);
	        },
        });
    }

    // First render with current year
    getEarnings(new Date().getFullYear());

    $selectYear.change(function () { getEarnings($(this).val()) });

    function renderChart(data) {
        const chartElement = document.querySelector("#earningChart");
        chartElement.innerHTML = '';

        const options = {
            series: [{
                data: data.earning,
                name: 'Revenus',
            }],
            chart: {
                toolbar: {
                    show: false
                },
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                }
            },
            dataLabels: {
                enabled: false,
            },
            tooltip : {
                style: {
                    fontFamily: 'Oswald', 
                },
            },
            xaxis: {
                categories: data.months,
                labels: {
                    style: {
                      fontFamily: 'Oswald', 
                    },
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return val + "$";
                    },
                    style: {
                      fontFamily: 'Oswald', 
                    },
                }
            }
        };

        const chart = new ApexCharts(chartElement, options);
        chart.render();
    }

    //================= Sales Handler =========
    function getSalesOfAllTime(page = 1) {
    	$.ajax({
	        url: `${URLROOT}/formateur/getSalesOfAllTime?page=${page}`,
	        beforeSend: function () {
	            
	        },
	        success: function ({data}) {
	            renderSales(data);
	            renderPagination(data);
	        },
	        error: function(){
	           
	        },
        });
    }

    getSalesOfAllTime();

    function renderSales({formationsRevenue, totalRevenue: {totalRevenue}}) {
    	$('#sales').empty();
    	$('#total-revenue').text(`$${totalRevenue}`);
    	formationsRevenue.forEach(function(sell){
    		$('#sales').append(`
    			<tr>
                    <td>
                        <div class="media align-items-center">
                            <a href="${URLROOT}/courses/edit/${sell.id_formation}"
                               class="avatar avatar-4by3 avatar-sm mr-3">
                                <img src="${URLROOT}/public/images/${sell.image}"
                                     alt="course"
                                     class="avatar-img rounded">
                            </a>
                            <div class="media-body">
                                <a class="text-body js-lists-values-course"
                                   href="instructor-course-edit.html"><strong>${sell.nom}</strong></a>
                                <div class="text-muted small">${sell.sales} Sales</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center text-black-70">

                        &dollar;<span class="js-lists-values-fees">${sell.fees}</span> USD

                    </td>
                    <td class="text-center text-black-70">
                        &dollar;<span class="js-lists-values-revenue">${sell.revenue}</span> USD
                    </td>
                </tr>
    		`);
    	});
    }

    const $pagination = $('#pagination');
    function renderPagination({totalPages, currentPage, nextPage, prevPage}){
    	$pagination.empty();
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
			    <li data-page="${nextPage}" class="page-item ${currentPage === totalPages && 'disabled'}">
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
			const page = parseInt($(this).data('page'));
            if(page != getParam('page')) {
                const currentPage = getParam('page') ? getParam('page') : 1; 
                if(currentPage !== page){
                    setParams('page', page);
                    getSalesOfAllTime(page);
                }
            }
		});
    }

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
});