import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

const deleteButtons = document.querySelectorAll('.form_delete');

 deleteButtons.forEach(button => {
     button.addEventListener('click', event => {
         event.preventDefault();

         const deleteModal = document.getElementById('confirmDeleteModal');

         const bootstrapModal = new bootstrap.Modal('#confirmDeleteModal');
         bootstrapModal.show();

         const confirmDeleteButton = deleteModal.querySelector('.confirmDelete');

         confirmDeleteButton.addEventListener('click', () => {
             button.parentElement.submit();
         });
     })
 });

const btnPreviewDelete = document.getElementById('btn-preview-delete');

btnPreviewDelete.addEventListener('click', function () {
    const formPreviewDelete = document.getElementById('form-preview-delete');
    formPreviewDelete.submit();
});