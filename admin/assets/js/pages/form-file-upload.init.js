
var previewTemplate, dropzone, dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
dropzonePreviewNode.id = "";
if (dropzonePreviewNode) {
    previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
    dropzone = new Dropzone(".dropzone", {
        url: "save_post.php", // Correct URL to handle file uploads
        method: "POST", // Make sure to use POST method
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview",
        paramName: "image", // Make sure this matches the name attribute of your file input in the form
        maxFilesize: 4, // Maximum file size in MB
        acceptedFiles: "image/jpeg, image/png, image/webp", // Valid file types
        dictDefaultMessage: "Drop files here or click to upload."
    });
}
