const filterBtn = document.querySelector('.filter-btn') ?? ""
const filterBlock = document.querySelector('.filter-block')
const filterList = document.querySelector('.dark')


filterBtn.addEventListener('click', ()=>{
  if (filterBlock.classList.contains('open')){
    filterBlock.classList.remove('open')
    filterList.style.display="none"
    anime({
      targets: filterBlock,
      duration: 0,
      easing: 'linear',
      translateX: 0,
      duration: 200
    });
  }
  else{
    filterBlock.classList.add('open')
    filterList.style.display="inline"
    filterList.style.zIndex = 99
    filterList.style.backgroundColor = "rgba(0,0,0,.3)"


    anime({
      targets: filterBlock,
      duration: 200,
      easing: 'linear',
      translateX: 800,
      delay: 200
    });
  }
})
