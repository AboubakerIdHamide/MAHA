$(document).ready(function(){
    // heart btn
	const heartBtn = $('.info .fa-heart');
	heartBtn.on("click",function (e) {
        // e.stopPropagation();
	    const heart = $(this);
        const etudiantId=heart.attr("data-etudiant-id");
        const formationId=heart.attr("data-formation-id");
        const wrapper=heart.parent().find(".formation-likes");
	    if(heart.hasClass('fa-regular')){
	        heart.removeClass('fa-regular').addClass('fa-solid');
			likeToIt(etudiantId, formationId, wrapper);
		}else{
	        heart.addClass('fa-regular').removeClass('fa-solid');
			likeToIt(etudiantId, formationId, wrapper);
		} 
        return false;
	});
});

function likeToIt(idEtudiant, idFormation, wrapper){
	$.post(
		`${urlRoot}/ajax/likeToformation`,
		{idEtudiant:idEtudiant, idFormation:idFormation},
		function(res, status, xhr){
			res=JSON.parse(res)
			wrapper.text(res.likes);
  		}
	);
}