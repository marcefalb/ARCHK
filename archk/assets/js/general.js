// ------------------------------ Header

const burgerBtn = document.querySelector('.burger-btn')
const headerLinks = document.querySelector('.header-nav__list')
const headerLogo = document.querySelector('.header-logo')
const headerSignIn = document.querySelector('.header-sign-in')
const headerWrapper = document.querySelector('.header__wrapper')
const headerDropdownBtn = document.querySelector('.user-links__dropdown-btn') ?? ''
const searchSalarySettings = document.querySelector('.search-platform__settings') ?? ''
const listContactsBtn = document.querySelectorAll('.list-block__contacts-btn') ?? ''

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
      duration: 200,
      easing: 'linear',
      translateY: 600,
      delay: 200
    });
    anime({
      targets: headerSignIn,
      duration: 200,
      easing: 'linear',
      translateY: 600,
      delay: 200
    });
  }
})

if (headerDropdownBtn) {
  const headerDropdownList = document.querySelector('.user-links__dropdown-list')
  
  showWindow(headerDropdownBtn, headerDropdownList, 'user-links__dropdown-list_active', '.user-links__dropdown')
}

// ------------------------------ Header

tinymce.init({
  selector: 'textarea',
  menubar: false,
  toolbar: 'bold italic | alignleft aligncenter alignright alignjustify | numlist bullist | fontsizeselect | h3 h4 | forecolor',
  fontsize_formats: '12pt 14pt 16pt 18pt',
  plugins: 'lists',
  lists_indent_on_tab: false,
  height: 250,
  max_height: 500
});

// ------------------------------ TinyMCE

if (searchSalarySettings) {
  const searchSalaryBlock = document.querySelector('.search-platform__settings-block')
  
  showWindow(searchSalarySettings, searchSalaryBlock, 'search-platform__settings-block_active', '.search-platform__settings-btn')
}

if (listContactsBtn) {
  showWindow(listContactsBtn, '', 'list-block__contacts-block_active', '.list-block__contacts')
}

// ------------------------------ range-slider

$range = $('.js-range-slider')
$inputFrom = $('.js-input-from')
$inputTo = $('.js-input-to')
const min = 10000
const max = 300000
const step = 1000
let from = 0
let to = 0

$range.ionRangeSlider({
  skin: 'round',
  type: 'double',
  min: min,
  max: max,
  step: step,
  from: 10000,
  to: 300000,
  onStart: updateInputs,
  onChange: updateInputs
})
instance = $range.data('ionRangeSlider')

function updateInputs (data) {
	from = data.from;
    to = data.to;
    
    $inputFrom.prop("value", from);
    $inputTo.prop("value", to);	
}

$inputFrom.on("input", function () {
    var val = $(this).prop("value");
    
    // validate
    if (val < min) {
        val = min;
    } else if (val > to) {
        val = to;
    }
    
    instance.update({
        from: val
    });
});

$inputTo.on("input", function () {
    var val = $(this).prop("value");
    
    // validate
    if (val < from) {
        val = from;
    } else if (val > max) {
        val = max;
    }
    
    instance.update({
        to: val
    });
});

// ------------------------------ range-slider

// ------------------------------ general functions
function showWindow (btn, list, activeClass, parentBlock) {
  if (NodeList.prototype.isPrototypeOf(btn)) btn = Array.from(btn)
  
  if (Array.isArray(btn)) {
    btn.forEach(el => {
      el.addEventListener('click', () => {
        btn.forEach(item => {
          item.nextElementSibling.classList.remove(activeClass)
        })
        list = el.nextElementSibling
        list.classList.toggle(activeClass)
        
        window.addEventListener('click', event => {
          if (event.target.closest(parentBlock) === null) list.classList.remove(activeClass)
          else if (event.target === el) list.classList.add(activeClass)
        })
      })
    })
  }
  else {
    btn.addEventListener('click', () => {
      list.classList.toggle(activeClass)
      
      window.addEventListener('click', event => {
        if (!event.target.closest(parentBlock)) list.classList.remove(activeClass)
      })
    })
  }
}
//------------------------------- vacansies
const likeBtn = document.querySelectorAll('.list-block__like') ?? ""

if (!likeBtn==""){
   likeBtn.forEach(btn=>{
     btn.addEventListener('click', (el)=>{
        el.classList.toggle('now')
     })
   })  
}