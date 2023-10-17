function reveal() {
  const items = document.querySelectorAll(".products-item");
  const products = document.querySelector(".products")

  for (let item of items) {
    const windowHeight = window.innerHeight;
    const elementTop = products.getBoundingClientRect().top;
    const elementVisible = 170;

    if (elementTop < windowHeight - elementVisible) {
      item.classList.add("products-item-active");
    } else {
      item.classList.remove("products-item-active");
    }
  }
}

window.addEventListener("scroll", reveal);


const menuButton = document.querySelector('.toggle');
menuButton.addEventListener("click", showMenu);

function showMenu() {
  const body = document.body
  const menu = document.querySelector(".menu");
  
  let opened = menu.classList.contains("show");
  if(opened) {
    menu.classList.remove("show")
    menuButton.classList.add("closed-menu")
    menuButton.classList.remove("opened-menu")
    body.classList.remove("background-fixed")
  }
  else {
    menu.classList.add("show")
    menuButton.classList.remove("closed-menu")
    menuButton.classList.add("opened-menu")
    body.classList.add("background-fixed")
  }  
  
}




function changeMap(location) {
  const map = document.querySelector(".location-map")
  const cards = document.querySelectorAll(".location-element")
  cards.forEach(element => {
    element.classList.remove("location-active")
  })
  if (location === "mexico") {
    map.classList.remove("location-2", "location-3")
    map.classList.add("location-1")
    cards[0].classList.add("location-active")
  }
  if (location === "brazil") {
    map.classList.remove("location-1", "location-3")
    map.classList.add("location-2")
    cards[1].classList.add("location-active")
  }
  if (location === "colombia") {
    map.classList.remove("location-1", "location-2")
    map.classList.add("location-3")
    cards[2].classList.add("location-active")
  }
}

const categories = document.querySelectorAll(".product-category")
categories.forEach(element => {
  element.addEventListener("click", selectCategory)
})

function selectCategory(e) {
  categories.forEach(element => {
    element.classList.remove("category-selected")
  })
  e.target.classList.add("category-selected")
}


const accountButton = document.querySelector('.account-button');
accountButton.addEventListener('click', showAccountMenu)
const accountNotf = document.querySelector('.account-notf');

function showAccountMenu() {
	const accountMenu = document.querySelector('.account-menu');
	let open = accountMenu.classList.contains('show')
	if(open) {
		accountMenu.classList.remove('show')
	}
	else {
		accountMenu.classList.add('show')
	}
	if (!accountNotf.classList.contains('show')) {
		accountNotf.classList.add('show');
	}
}

/* const addToCartButton = document.querySelector('.add-to-cart-btn');
addToCartButton.addEventListener('click', showNotf)

const accountNotf = document.querySelector('.account-notf');
function showNotf() {
	console.log('hola')
	if(!accountNotf.classList.contains('show')) {
		accountNotf.classList.add('show');
	}
} */

function deleteAlert(id) {
	const delAlert = document.querySelector('.delete-alert');
	delAlert.classList.toggle('hidden');
	const heading = document.querySelector('#delete-alert-heading')

	if(!delAlert.classList.contains('hidden')) {
		heading.innerText += `: ${id}?`;

		delAlert.innerHTML += `
		<input type='hidden' name='id' value='${id}'>
		`
	}
	
}