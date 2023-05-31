$(document).ready(function () {
  // Stop the video when the modal closed
  $("#modifier").on("hidden.bs.modal", function (e) {
    $("#modifier video").attr("src", $("#modifier video").attr("src"));
  });

  function removeTags(str) {
    if (str === null || str === "") return "";
    else str = str.toString();

    // Regular expression to identify HTML tags in
    // the input string. Replacing the identified
    // HTML tag with a null string.
    return str.replace(/(<([^>]+)>)/gi, "");
  }

  // clear showing errors when closing modal
  $(".fermer").click(function () {
    $(".error-title, .error-desc").text("");
  });

  // Refresh page
  function refreshPage() {
    location.reload(true);
  }

  // Delete button
  $(".delete").click(function () {
    // Remove the old event
    $("#delete-video").off();
    const $idVideo = $(this).attr("id");
    $("#delete-video").click(function () {
      $.ajax({
        url: "http://localhost/maha/formations/deleteVideo",
        method: "POST",
        data: {
          id_video: $idVideo,
        },
        success: function (response) {
          // console.log(response);
        },
      });
      refreshPage();
    });
  });

  //  Modifier Button
  // I need thoses variables being global, to compare with new values (Request Optimisation)
  let videoTitle;
  let videoDescription;
  let idVideo;
  $(".edit").click(function () {
    idVideo = $(this).attr("id");
    const $urlVideo = $(this)
      .parent()
      .parent()
      .parent()
      .find("input#link-video")
      .val();
    videoTitle = $(this)
      .parent()
      .parent()
      .parent()
      .find("span.video-name")[0].textContent;
    videoDescription = $(this)
      .parent()
      .parent()
      .parent()
      .find("input#description-video")
      .val();
    $(".modal input#title").val(videoTitle);
    $(".modal textarea#description").val(videoDescription);
    $("#mp4-video").attr("src", $urlVideo);
  });
  // validation for title and description
  $("#apply-btn").click(function (event) {
    const desc = {
      inputValue: removeTags($("#description").val()),
      label: "desc",
      maxCara: 600,
      regExp: /[]/,
    };

    const title = {
      inputValue: $("#title").val(),
      label: "title",
      maxCara: 50,
      regExp: /^[a-zA-Z0-9_ ]+$/,
    };

    const isInputValid = ({ inputValue, label, maxCara, regExp }) => {
      if (inputValue.length > maxCara) {
        $(".error-" + label).text(
          `${maxCara} caractères maximum`
        );
        return false;
      }

      if (inputValue.length < 6) {
        $(".error-" + label).text("5 caractères minimum");
        return false;
      }

      if (label === "title" && !inputValue.match(regExp)) {
        $(".error-" + label).text(
          "Le title ne doit pas contient des caractères speciaux."
        );
        return false;
      }

      $(".error-" + label).text("");
      return true;
    };
    if (desc.inputValue.length !== 0 || title.inputValue.length !== 0) {
      if (
        videoDescription !== desc.inputValue ||
        videoTitle !== title.inputValue
      ) {
        if (
          videoDescription !== desc.inputValue &&
          videoTitle !== title.inputValue
        ) {
          if (isInputValid(desc) && isInputValid(title)) {
            $.ajax({
              url: "http://localhost/maha/formations/updateVideo",
              method: "POST",
              data: {
                id_video: idVideo,
                description: desc.inputValue,
                titre: title.inputValue,
              },
              success: function (response) {
                // console.log(response);
              },
            });
            refreshPage();
          }
        } else {
          if (videoDescription !== desc.inputValue) {
            if (isInputValid(desc)) {
              $.ajax({
                url: "http://localhost/maha/formations/updateVideo",
                method: "POST",
                data: {
                  id_video: idVideo,
                  description: desc.inputValue,
                },
                success: function (response) {
                  // console.log(response);
                },
              });
              refreshPage();
            }
          } else {
            if (isInputValid(title)) {
              $.ajax({
                url: "http://localhost/maha/formations/updateVideo",
                method: "POST",
                data: {
                  id_video: idVideo,
                  titre: title.inputValue,
                },
                success: function (response) {
                  // console.log(response);
                },
              });
              refreshPage();
            }
          }
        }
      } else $(".btn-close").click();
    }
  });

  // tries les videos
  $(".order").click(function (event) {
    const videosWithOrder = [];
    const $idsOfVideos = $("button.edit");
    const $orderOfVideos = $("input.order-video");

    const getOrder = (index) => {
      if (
        Number($orderOfVideos[index].value) != $orderOfVideos[index].value ||
        $orderOfVideos[index].value === ""
      )
        return null;
      return Math.floor(Number($orderOfVideos[index].value));
    };
    let i = 0;
    for (let idVideo of $idsOfVideos) {
      if (getOrder(i) !== null) {
        const videoObj = {
          id: idVideo.id,
          order: getOrder(i),
        };
        videosWithOrder.push(videoObj);
      }
      i++;
    }

    if (videosWithOrder.length !== 0) {
      $.ajax({
        url: "http://localhost/maha/formations/setOrdreVideos",
        method: "POST",
        data: {
          videosWithOrder: JSON.stringify(videosWithOrder),
        },
        success: function (response) {
          // console.log(response);
        },
      });
      refreshPage();
    }
  });

  // preview video
  $(".preview").click(function () {
    $(".preview").removeAttr("disabled");
    $(this).attr("disabled", true);
    const idVideo = $(this).attr("id");
    $.ajax({
      url: "http://localhost/maha/formations/insertPreviewVideo/" + idVideo,
      success: function (response) {
        // console.log(response);
      },
    });
  });

  // tooltips
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );
});
