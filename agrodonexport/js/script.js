var button = document.querySelector('button');
var container = document.querySelector('.container');
var checkmark = document.querySelector('svg');
var className = "animate";

button.addEventListener('click', function(){
  if (!checkmark.classList.contains(className)) {
    checkmark.classList.add(className);
    
    setTimeout(function(){      
        checkmark.classList.remove(className);
    }, 1700);  
  } 
});