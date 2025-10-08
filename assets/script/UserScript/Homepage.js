import { handleImageChange } from "../BaseScript/Functions.js";

export function initHomepage() {  

  function hero() {
    const stmt = document.getElementById('statement'),
    heroImg = document.getElementById('heroImg'),
    heroIconsHolder = document.getElementById('heroIcons'),
    images = [
      {
        statement: 'Education is a process, you have to dream it then live it!',
        imgURL: './assets/images/student2-853x1280.jpg'
      },
      {
        statement: 'Teach you in a way, you will want to come back for more. Education is fun!',
        imgURL: './assets/images/woman.jpg'
      },
      {
        statement: "Improves your reading and bring your attention back from social media. Control don't be CONTROLLED",
        imgURL: 'assets/images/about-big.jpg'
      }      
    ];
    images.forEach(img => {
      const imgElement = `<img src="${img.imgURL}" class="img-icon" alt="${img.statement}">`;
      heroIconsHolder.innerHTML += imgElement;
    });
    const getImgIcons = document.querySelectorAll('.img-icon');
    if (getImgIcons) {
      getImgIcons.forEach(i => {
        const url = i.src;
        const statement = i.alt;
        i.addEventListener('click', () => handleImageChange(heroImg, url, stmt, statement))
      });
    }
  }
  hero();

  function testimonial() {
    const stmt = document.getElementById('testimonialStmt'),
    testimonialImg = document.getElementById('testimonialImg'),
    testStr = document.getElementById('testStr'),
    testSmall = document.getElementById('testSmall'),
    iconsHolder = document.getElementById('testimonialDiv'),
    images = [
      {
        name: 'Anna Argent',
        role: 'Researcher,Chief Director',
        statement: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta error illo eaque recusandae praesentium reprehenderit tempora, deserunt dolore ut modi ducimus cumque aliquid, aliquam nostrum assumenda doloremque, optio maiores totam!',
        imgURL: './assets/images/student1-1280x987.jpg'
      },
      {
        name: 'kira Hale',
        role: 'Library Management',
        statement: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta error illo eaque recusandae praesentium reprehenderit',
        imgURL: './assets/images/student2-853x1280.jpg'
      },
      {
        name: 'Yuri Tate',
        role: 'Sport Assistant',
        statement: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta error illo eaque recusandae praesentium reprehenderit tempora, deserunt dolore ut modi ducimus cumque',
        imgURL: 'assets/images/about-big.jpg'
      }      
    ];
    images.forEach(img => {
      const imgElement = `<img src="${img.imgURL}" id="${img.name}" title="${img.role}" class="test-img-icon active" alt="${img.statement}">`;
      iconsHolder.innerHTML += imgElement;
    });
    const getImgIcons = document.querySelectorAll('.test-img-icon');
    if (getImgIcons) {
      getImgIcons.forEach(i => {
        const url = i.src;
        const statement = i.alt;
        i.addEventListener('click', () => handleImageChange(testimonialImg, url, stmt, statement));
        i.addEventListener('click', () => {
          getImgIcons.forEach(icon => icon.classList.remove('active'));
          i.classList.add('active');
          if (i.classList.contains('active')){
            testStr.innerHTML = i.id;
            testSmall.innerText = i.title;
          }
        });        
      });
    }
    
  }
  testimonial();
}