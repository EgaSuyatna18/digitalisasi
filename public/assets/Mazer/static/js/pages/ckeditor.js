let ckEditor2;

ClassicEditor.create( document.querySelector( '#editor' ), {
  removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed', 'Link', 'BlockQuote', 'Table'],
} )
.then( editor => {
	console.log( editor );
} )
.catch( error => {
	console.error( error );
} );

ClassicEditor.create( document.querySelector( '#editor2' ), {
	removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed', 'Link', 'BlockQuote', 'Table'],
  } )
  .then( editor => {
	ckEditor2 = editor;
	  console.log( editor );
  } )
  .catch( error => {
	  console.error( error );
  } );