const inputSkills = document.querySelector('.skill-input')
const skillsList_hiden = document.querySelector('.skills-list_hidden')
const addSkills = document.querySelector('.addSkill')
const skillsList = document.querySelector('.skills-list')
const form = document.querySelector('.edit-page__form')

const skills = document.querySelectorAll('.skills-list__item')
const delBtn = document.querySelectorAll('.delSkill')

const skillsArr = []

skills.forEach(skill=>{
  skillsArr.push(skill.textContent)
})

form.addEventListener('keydown', (e)=>{
  if(e.keyCode==13){
    e.preventDefault()
    return false
  }
})
inputSkills.addEventListener('keydown', (e)=>{
  if(e.keyCode==13){
    AddSkill()
  }
})


const AddSkill = () =>{
  skillsArr.push(inputSkills.value)
  skillsList.innerHTML +=`<li class="skills-list__item" data-id = "{{index}}">${skillsArr[skillsArr.length-1]}<img class="delSkill" src="./../themes/archk/assets/icons/del-vacansy.svg"></li>`
  inputSkills.value = ''
  skillsList_hiden.value = skillsArr
}

const deleteSkill = (index, array) =>{
  array.splice(index,1)
  skillsList_hiden.value = array
}

skillsList.addEventListener('click', (e)=>{
  if(e.target.classList.contains('delSkill')){
    const index = e.target.parentNode.dataset.id
    deleteSkill(index, skillsArr)
    e.target.parentNode.remove()
  }
})


addSkills.addEventListener('click', ()=>{
  AddSkill()
})

skillsList_hiden.value = skillsArr

