$(document).ready(function () {
  // video time
  // if (window.localStorage.getItem("videosTimeData")) {
  //   let videoTime = JSON.parse(window.localStorage.getItem("videosTimeData"));
  //   videoTime.forEach((video) => {
  //     if (video.videoid == videoId) {
  //       document.getElementById("video").currentTime = video.time;
  //     }
  //   });
  // }

  function removeTags(str) {
    if (str === null || str === "") return "";
    else str = str.toString();

    // Regular expression to identify HTML tags in
    // the input string. Replacing the identified
    // HTML tag with a null string.
    return str.replace(/(<([^>]+)>)/gi, "");
  }

  // PLaylist
  const $videosList = $(".videos-list ul li");

  // video ID
  $videosList.on("click", function (event) {
    const $element = $(event.target);
    let vId = $(this).find(".video-name").attr("data-video-id");
    videoId = vId;
    // bookmark video
    if ($element.hasClass("fa-bookmark")) {
      if ($element.hasClass("fa-solid")) {
        $element.removeClass("fa-solid").addClass("fa-regular");
        markVideo(fromUser, vId);
      } else {
        $element.removeClass("fa-regular").addClass("fa-solid");
        markVideo(fromUser, vId);
      }
      return;
    }

    // watched videos
    if ($element.hasClass("fa-circle-check")) {
      if ($element.hasClass("fa-solid")) {
        $element.removeClass("fa-solid").addClass("fa-regular");
        watchVideo(fromUser, vId);
      } else {
        $element.removeClass("fa-regular").addClass("fa-solid");
        watchVideo(fromUser, vId);
      }
      return;
    }

    if ($(this).hasClass("selected")) return;

    $(".videos-list .selected .fa-circle-pause")
      .removeClass("fa-circle-pause")
      .addClass("fa-circle-play");
    $(".videos-list .selected").removeClass("selected");

    $(this).addClass("selected");

    $(this)
      .find("i.fa-circle-play")
      .removeClass("fa-circle-play")
      .addClass("fa-circle-pause");

    const videoName = $(this).find(".video-name").text();
    const videoDuration = $(this).find(".video-duration").text();
    const videoDesc = $(this).find(".video-name").attr("data-video-desc");
    const videoUrl = $(this).find(".video-duration").attr("data-video-url");
    const videoComments = JSON.parse(
      $(this).find(".video-duration").attr("data-video-comments")
    );

    $(".container .main-video-name").text(videoName);
    $(".main-video-duration").text(videoDuration);
    $("p.desc").text(videoDesc);

    const config = {
      sources: [
        {
          type: "mp4",
          src: videoUrl,
        },
      ],
      ui: {
        pip: true, // by default, pip is not enabled in the UI.
      },
    };

    const element = document.getElementById("playerContainer");
    element.innerHTML = "";
    const player = IndigoPlayer.init(element, config);

    // comments
    let commentsText = "";
    videoComments.forEach((comment) => {
      commentsText += `
				<div class="d-flex gap-2 mb-2 ${
          comment.type_user === "formateur" && "flex-row-reverse"
        }" data-video-id="${comment.id_video}" data-etudiant-id="${
        comment.id_etudiant
      }">
					  <img class="align-self-start" src="${comment.img}" alt="my-photo">
					  <div class="d-flex flex-column ${
              comment.type_user === "formateur"
                ? "formateur-comment"
                : "etudiant-comment"
            } ">
						  <span class="my-name">${comment.nom} ${comment.prenom}</span>
						  <p>${comment.commentaire}</p>
						  <div class="d-flex justify-content-between">
							<small>${comment.created_at}</small>
						  </div>
					  </div>
				  </div>
			`;
      videoId = comment.id_video;
    });
    $(".my-comments").html(commentsText);

    // video time
    if (window.localStorage.getItem("videosTimeData")) {
      let videoTime = JSON.parse(window.localStorage.getItem("videosTimeData"));
      videoTime.forEach((video) => {
        if (video.videoid == videoId) {
          document.getElementById("video").currentTime = video.time;
        }
      });
    }
  });

  // add comment
  const $btn = $(".submit-btn");
  $btn.click(function (event) {
    let nomTotal = etudiantFullName;
    let $comment = removeTags($(".comment-text").val());
    let date = new Date().toISOString().slice(0, 19).replace("T", " ");

    // comment validation
    if ($comment.length > 500) {
      $(".comment-entry .comment-error").text("500 caractères au maximum");
      return;
    } else {
      if ($comment.length < 4) {
        $(".comment-entry .comment-error").text("4 caractères au minimum");
        return;
      }
    }

    // for style comment
    const $user_comment = $(this).data("typeUser");
    const $toUser = $(this).data("toUser");
    const divComment = `
		<div class="d-flex gap-2 mt-2 ${
      $user_comment === "formateur" && "flex-row-reverse"
    }">
			<img class="align-self-start" src="${etudiantImageSrc}" alt="my-photo">
			<div class="d-flex flex-column ${$user_comment}-comment">
				<span class="my-name">${nomTotal}</span>
				<p>${$comment}</p>
				<small>${date}</small>
			</div>
		</div>
		`;
    addComment(fromUser, $toUser, videoId, $comment);
    $(".comments-section .my-comments").append(divComment);
    $(".comment-text").val("");
  });

  $(".comment-text").on("keydown keyup", function (event) {
    const $cptComment = $(".comment-text").val().length;
    $(".cpt-caractere").text($cptComment);
    if ($cptComment >= 500) {
      $(".cpt-caractere").text(500);
      $(".comment-entry .comment-error").text("500 caractères au maximum");
      return;
    } else {
      $(".comment-entry .comment-error").text("");
    }
  });

  // to-tp button
  const $toTop = $(".to-top");

  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 150) $toTop.addClass("active");
    else $toTop.removeClass("active");
  });

  $toTop.click(function (e) {
    e.preventDefault();
    window.scrollTo(0, 0);
  });

  // heart btn
  const $heartBtn = $(".love-ses-formations i");

  $heartBtn.click(function (e) {
    const $heart = $(this);
    if ($heart.hasClass("fa-regular")) {
      $heart.removeClass("fa-regular").addClass("fa-solid");
      likeToIt(fromUser, formationId);
    } else {
      $heart.addClass("fa-regular").removeClass("fa-solid");
      likeToIt(fromUser, formationId);
    }
  });
});

// video Time Trucking
// const videoTag = document.getElementById("video");
// videoTag.addEventListener("timeupdate", (e) => {
//   // set as watch if finched
//   if (videoTag.currentTime == videoTag.duration) {
//     watchVideo(etudiantId, videoId, true);
//   }
//   // tracking time
//   if (videoTag.currentTime != 0) {
//     let trackingData = [],
//       videoTracked = false;
//     if (window.localStorage.getItem("videosTimeData")) {
//       trackingData = JSON.parse(window.localStorage.getItem("videosTimeData"));
//     } else {
//       trackingData = [
//         {
//           videoid: videoId,
//           time: videoTag.currentTime,
//         },
//       ];
//     }
//     trackingData.forEach((video) => {
//       if (video.videoid == videoId) {
//         video.time = videoTag.currentTime;
//         videoTracked = true;
//       }
//     });
//     if (videoTracked == false) {
//       trackingData.push({
//         videoid: videoId,
//         time: videoTag.currentTime,
//       });
//     }
//     window.localStorage.setItem("videosTimeData", JSON.stringify(trackingData));
//   }
// });

// ======================================== Ajax Calls =========================================
function likeToIt(idEtudiant, idFormation) {
  $.post(
    `${urlRoot}/ajax/likeToformation`,
    {
      idEtudiant: idEtudiant,
      idFormation: idFormation,
    },
    function (res, status, xhr) {
      res = JSON.parse(res);
      $(".formation-likes").text(res.jaimes);
    }
  );
}

function addComment(from_user, to_user, idVideo, commentaire) {
  $.post(
    `${urlRoot}/ajax/addComment`,
    {
      from_user: from_user,
      videoId: idVideo,
      comment: commentaire,
      to_user: to_user,
    },
    function (res, status, xhr) {
      res = JSON.parse(res);
      $(`#video-${videoId}`).attr(
        "data-video-comments",
        JSON.stringify(res.comments)
      );
    }
  );
}

function watchVideo(etudiantId, videoId, auto = false) {
  $.post(
    `${urlRoot}/ajax/watchVideo`,
    {
      idEtudiant: etudiantId,
      idVideo: videoId,
      automatic: auto,
    },
    function (res, status, xhr) {
      res = JSON.parse(res);
      if (res.success == true && auto == true) {
        document
          .querySelector(`#watch-${videoId}`)
          .classList.replace("fa-regular", "fa-solid");
      }
    }
  );
}

function markVideo(etudiantId, videoId) {
  $.post(
    `${urlRoot}/ajax/markVideo`,
    {
      idEtudiant: etudiantId,
      idVideo: videoId,
    },
    function (res, status, xhr) {
      res = JSON.parse(res);
    }
  );
}
