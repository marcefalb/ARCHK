const burgerBtn = document.querySelector('.burger-btn')
const headerLinks = document.querySelector('.header-nav__list')
const headerLogo = document.querySelector('.header-logo')
const headerSignIn = document.querySelector('.header-sign-in')
const headerWrapper = document.querySelector('.header__wrapper')

const btnDelay = () => {
  burgerBtn.style.pointerEvents = 'none'
  setTimeout(() => burgerBtn.style.pointerEvents = 'all', 500)
}

burgerBtn.addEventListener('click', () => {
  const headerWrapperHeight = headerWrapper.style.height
  btnDelay()

  if (headerWrapperHeight) {
    headerWrapper.style.height = ''
    headerWrapper.classList.remove('burger_active')
    document.documentElement.style.overflow = 'auto'

    anime({
      targets: headerLinks,
      duration: 0,
      easing: 'linear',
      translateY: 0,
    });
    anime({
      targets: headerSignIn,
      duration: 0,
      easing: 'linear',
      translateY: 0,
    });
  }
  else {
    document.documentElement.style.overflow = 'hidden'
    headerWrapper.style.height = '100vh'
    headerWrapper.classList.add('burger_active')

    anime({
      targets: headerLinks,
      duration: 300,
      easing: 'linear',
      translateY: 600,
      delay: 200
    });
    anime({
      targets: headerSignIn,
      duration: 300,
      easing: 'linear',
      translateY: 600,
      delay: 200
    });
  }
})