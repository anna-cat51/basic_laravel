window.addEventListener('load', function() {
  const commentForm = document.querySelector('#js-comment_form');
  const commentInput = document.querySelector('#js-comment_body');
  const commentArea = document.querySelector('.comment-area');

  commentForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const commentBody = commentInput.value;
      const url = event.target.getAttribute('action');
      axios({
          method: 'POST',
          url: url,
          headers: {
              'X-CSRF-TOKEN': event.target.querySelector('input[name="_token"]').value,
              'Content-Type': 'application/json',
              'Accept': 'application/json',
          },
          data: {
              body: commentBody
          }
      })
      .then(response => {
          commentInput.value = '';
          commentArea.insertAdjacentHTML('beforeend', response.data);
          addDeleteEventListeners();
      })
      .catch(error => console.error(error));
  });

  function addDeleteEventListeners() {
      const commentDeleteButtons = document.querySelectorAll('.js-comment_delete_button');
      commentDeleteButtons.forEach(commentDeleteButton => {
          commentDeleteButton.addEventListener('submit', function(event) {
              event.preventDefault();
              const commentId = event.target.getAttribute('data-comment-id');
              const deleteUrl = event.target.getAttribute('action');
              axios({
                  method: 'DELETE',
                  url: deleteUrl,
                  headers: {
                      'X-CSRF-TOKEN': event.target.querySelector('input[name="_token"]').value,
                      'Content-Type': 'application/json',
                      'Accept': 'application/json',
                  },
              })
              .then(response => {
                  document.querySelector(`#comment-id-${commentId}`).remove();
              })
              .catch(error => console.error(error));
          });
      });
  }
  addDeleteEventListeners();
});