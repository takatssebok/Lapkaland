<!-- connection to tinymce     -->
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script src="https://cdn.tiny.cloud/1/feixu2pch8itq6snh1yuvnun6tq2tgya77g8xzv33dm84we9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

 <script>
    // tinymce.init
    tinymce.init({
      selector: '#textarea1',
      mode : "specific_textareas",
      plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste",
                  "image code", "image"                  
              ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code",
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      media_live_embeds: true,
      image_advtab: true,
      
    // enable title field in the Image dialog
    image_title: true, 
    // enable automatic uploads of images represented by blob or data URIs
    automatic_uploads: true,
    
    file_picker_types: 'image',

    // file_picker_callback
    file_picker_callback: function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');

    input.onchange = function() {
      var file = this.files[0];
      var reader = new FileReader();
      
      reader.onload = function () {
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);

        // call the callback and populate the Title field with the file name
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };
    
    input.click();
  },

   });
</script>
