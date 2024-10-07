window.addEventListener('load', function() {
  const bookmarkForms = document.querySelectorAll('.bookmark-form');
  bookmarkForms.forEach((bookmarkForm) => {
    bookmarkForm.addEventListener('submit', (event) => {
      event.preventDefault();
      const url = event.target.getAttribute('action');
      let httpMethod = 'POST';
      const methodInput = event.target.querySelector('input[name="_method"]');
      if (methodInput && methodInput.value === 'DELETE') {
        httpMethod = 'DELETE';
      }
      axios({
        method: httpMethod,
        url: url,
        headers: {
          'X-CSRF-TOKEN': event.target.querySelector('input[name="_token"]').value,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        }
      })
      .then(response => {
        bookmarkForm.innerHTML = response.data.html;
      })
      .catch(error => console.error(error));
    });
  });
});