// const comment = document.querySelector("a.comment");

const comment = document.querySelector("a.addComment");
const commentForm = document.querySelector(".commentForm");

comment.addEventListener('click', function(){

    commentForm.classList.toggle('d-none');

})