// init sweat alert pop-up component.
const swalWithBootstrapBtns = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger mx-3'
  },
  buttonsStyling: false
})

// method to apply the sweat alert popup.
function swalPopUp() {
  return swalWithBootstrapBtns.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
  })
}

// method to apply the 2nd sweat alert popup when success the process .
function swalSuccessDelete() {
  return swalWithBootstrapBtns.fire(
    'Deleted!',
    'Your data has been deleted.',
    'success'
  )
}

// method to apply the 2nd sweat alert popup when cancel the process .
function swalCancelDelete() {
  return swalWithBootstrapBtns.fire(
    'Cancelled',
    'Your imaginary data is safe :)',
    'error'
  )
}

// delete handler method.
// ---> use this pattern to avoid callback in the addEventListener. <--- //
function deleteHandler(path) {
  return async (event) => {
    // display the sweat alert pop-up and wait to user respond.
    const { isConfirmed, dismiss } = await swalPopUp()

    // if confirmed to delete.
    if (isConfirmed) {
      // get the id.
      const _id = event.target.getAttribute('data-id');
      // use the fetch to send a request with delete method.
      await fetch(`${path}/${_id}`, { method: 'DELETE' })
      // display the popup of process success.
      await swalSuccessDelete()
      // reload the page.
      window.location.reload()
    }

    // if the use canceld display this pop-up.
    if (dismiss === Swal.DismissReason.cancel) {
      swalCancelDelete()
    }
  }
}

// select all the agence deleted buttons.
const _agenceDeleteBtns = document.querySelectorAll('#agence-delete-btn');

// check if these buttons are stored inside the var.
if (_agenceDeleteBtns) {
  // loop for every button and add a listner.
  _agenceDeleteBtns.forEach((_deleteBtn) => {
    _deleteBtn.addEventListener('click', deleteHandler('/agence/supprimer'))
  })
}

// select all the voiture deleted buttons.
const _voitureDeleteBtns = document.querySelectorAll('#voiture-delete-btn');

// check if these buttons are stored inside the var.
if (_voitureDeleteBtns) {
  // loop for every button and add a listner.
  _voitureDeleteBtns.forEach((_deleteBtn) => {
    _deleteBtn.addEventListener('click', deleteHandler('/voiture/supprimer'))
  })
}
