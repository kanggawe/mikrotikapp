import './bootstrap';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// Inisialisasi editor
document.addEventListener('DOMContentLoaded', function () {
    const editorElement = document.querySelector('#content');
    if (editorElement) {
        ClassicEditor.create(editorElement)
            .then(editor => {
                console.log('Editor initialized', editor);
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    }
});
