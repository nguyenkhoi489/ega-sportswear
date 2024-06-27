jQuery(function ($) {
  // Set all variables to be used in scope
  var frame,
    metaBox = $("#product_video_feature"), // Your meta box id here
    btnAdd = metaBox.find(".select_featured"),
    videoContainer = metaBox.find(".box-container"),
    videoInputID = metaBox.find(".box-container input");
  videoBoxInput = metaBox.find(".box-container .box-input");
  videoThumbnailContainer = metaBox.find(".box-input__video-Thumbnail");
  videoThumbnailButton = metaBox.find(
    ".box-input__video-Thumbnail .btn-add__videoThumbnail"
  );
  videoThumbnailID = metaBox.find(".box-input__video-Thumbnail input");
  btnAdd.on("change", function (event) {
    event.preventDefault();
    let type = $(this).val();
    if (!type) return;
    console.log(type);
    if (type == "upload") {
      videoBoxInput.addClass("d-none");
      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title: "Select or Upload Media Of Your Chosen Persuasion",
        button: {
          text: "Use this media",
        },
        multiple: false,
        library: {
          type: ["video"],
        },
      });
      // When an image is selected in the media frame...
      frame.on("select", function () {
        // Get media attachment details from the frame state
        var attachment = frame.state().get("selection").first().toJSON();
        console.log(attachment);
        //     // Send the attachment URL to our custom image input field.
        //     imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

        //     // Send the attachment id to our hidden input
        //     imgIdInput.val( attachment.id );

        //     // Hide the add image link
        //     addImgLink.addClass( 'hidden' );

        //     // Unhide the remove image link
        //     delImgLink.removeClass( 'hidden' );
        return;
      });
      frame.open();
      return;
    }
    videoBoxInput.removeClass("d-none");
    videoThumbnailContainer.removeClass("d-none");
  });
  videoThumbnailButton.on("click", function (event) {
    event.preventDefault();
    var frame = wp.media({});
    frame.on("select", function () {
      // Get media attachment details from the frame state
      var attachment = frame.state().get("selection").first().toJSON();

      // Send the attachment URL to our custom image input field.
      $(`<div class="element_item">
                    <img src="${attachment.url}" style="max-width: 100%" />
                    <span class="btn-remove__item">x</span>
                    </div>`).insertBefore(videoThumbnailButton);

      // Send the attachment id to our hidden input
      videoThumbnailID.val(attachment.id);
    });
    frame.open();
  });
  $('body').on('click','.btn-remove__item', function(event){
    $(this).parent().remove()
    videoThumbnailID.empty()
  })
  // ADD IMAGE LINK
});
