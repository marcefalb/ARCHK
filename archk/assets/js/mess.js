const chatLinks = document.querySelectorAll('.messages-list__item')
const chatWindow = document.querySelector('.messages_right')

if (document.body.clientWidth <= 992) {
  chatLinks.forEach(el => {
    el.addEventListener('click', () => {
      chatWindow.classList.add('messages_active')
    })
  })
}