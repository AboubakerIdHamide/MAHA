$(function(){
	$("#transaction-days").flatpickr({ 
        mode: "range", 
        defaultDate: null,
        onClose: function(selectedDates) {
        	if(selectedDates.length > 0){
            	const dates = selectedDates.map((date) => date.toISOString());
            	setParams('page');
	        	setParams('start', dates[0]);
	            setParams('end', dates[1] ?? dates[0]);
	            fetchTransactions();
			}            
        },
    });

    // First Fetch Of Transactions
    fetchTransactions();

    function fetchTransactions() {
    	const search = window.location.search;

    	$.ajax({
	        url: `${URLROOT}/formateur/getTransactionsInSpecificDates${search}`,
	        beforeSend: function () {
	            
	        },
	        success: function ({data}) {
	            renderTransations(data);
	            renderPagination(data);
	        },
	        error: function(){
	            
	        },
		});
    }

    function renderTransations({transactions}){
    	const $transactions = $('#transactions');
    	$transactions.empty();
    	if(transactions.length === 0){
    		$transactions.html(`
    			<tr>
    				<td colspan="3" class="p-0">
	    				<div class="alert alert-info mb-0 rounded-0 d-flex align-items-center">
		    				<i class="material-icons mr-2">info</i> 
		    				<span>Nothing sold in the giving days.</span>
	    				</div>
    				</td>
    			</tr>
    		`);
    		return;
    	}

    	transactions.forEach((transation) => {
    		$transactions.append(`
	    		<tr>
	                <td>
	                    <div class="media align-items-center">
	                        <a href="${URLROOT}/courses/edit/${transation.id_formation}"
	                           class="avatar avatar-4by3 avatar-sm mr-3">
	                            <img src="${URLROOT}/public/images/${transation.image}"
	                                 alt="course"
	                                 class="avatar-img rounded">
	                        </a>
	                        <div class="media-body">
	                            <a class="text-body"
	                               href="${URLROOT}/courses/edit/${transation.id_formation}"><strong>${transation.nom}</strong></a><br>
	                            <small class="text-muted mr-1">
	                                Invoice
	                                <span>#${transation.id_inscription}</span>
	                            </small>
	                        </div>
	                    </div>
	                </td>
	                <td>
	                	<small>&dollar;${transation.prix} USD</small>
	                </td>
	                <td>
	                    <small class="text-muted">${transation.date_inscription}</small>
	                </td>
	            </tr>
    		`);
    	})
    }

    const $pagination = $('#pagination');
    function renderPagination({totalPages, currentPage, nextPage, prevPage, totalTransactions}){
    	$pagination.empty();
    	if(totalTransactions === 0) return;

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
                    fetchTransactions();
                }
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

    // Sort Transactions
    $('.sort-transactions').click(function(){
    	const sort = $(this).data('sort');
    	if(sort !== getParam('sort')){
    		setParams('sort', sort);
    		fetchTransactions();
    	}
    })
});