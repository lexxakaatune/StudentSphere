export const handleToggling = (button, changeEle, changeEle2, str, str2) => {
  button.addEventListener('click', () => {
    changeEle.classList.toggle('visible');        
    changeEle.classList.toggle('hidden'); 
    if (changeEle2) {
      changeEle2.classList.remove('visible');        
      changeEle2.classList.add('hidden');
    }
    if (changeEle.classList.contains('visible')) {
      button.innerText = str;
    } else {
      button.innerText = str2;
    }
  });
}

export const handleImageChange = (element, imgUrl, statementElement, text) => {
  if (element) {
    element.src = imgUrl;
  }
  if (statementElement) {
    statementElement.innerText = text;
  }
}