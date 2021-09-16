const modal = document.querySelector('.modal-contacts')
const showContacts = document.querySelector('.show-contacts')??""
const closeModal = document.querySelector('.closebtn')

const ShowContact = (UserName, UserPhone, UserMail, UserCity) =>`
          <div class="modal-contacts__wrapper">
            <img class="closebtn" src="./../themes/archk/assets/icons/modal-close.svg">
            <ul class="modal-contacts__list">
              <li class="modal-contacts__item">${UserName}</li>
              <li class="modal-contacts__item"><a href="tel:${UserPhone}">${UserPhone}</a></li>
              <li class="modal-contacts__item"><a href="mailto:${UserMail}">${UserMail}</a></li>
              <li class="modal-contacts__item">${UserCity}</li>
            </ul>
          </div>
`


if(showContacts!=""){
  showContacts.addEventListener('click', (e) => {
    let UserName  = e.currentTarget.getAttribute('data-name')
    let UserPhone = e.currentTarget.getAttribute('data-phone')
    let UserMail = e.currentTarget.getAttribute('data-mail')
    let UserCity = e.currentTarget.getAttribute('data-city')
    
    modal.innerHTML = ShowContact(UserName, UserPhone, UserMail, UserCity)
    modal.classList.add('modal-visible')
    
    const html = document.getElementsByTagName('html')[0]
    document.body.style.top = `-${window.scrollY}px`
    html.style.position = 'fixed'
  })


  modal.addEventListener('click', (e) => {
  	if (e.target == modal || e.target.classList.contains('closebtn')) {
  		modal.classList.remove('modal-visible')
  		
      const html = document.getElementsByTagName('html')[0]
      const scrollY = document.body.style.top
      html.style.position = ''
      document.body.style.top = ''
      window.scrollTo(0, parseInt(scrollY || '0') * -1)
  	}
  });
}