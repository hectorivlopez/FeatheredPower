const payCartBtn = document.querySelector('#payCartBtn')
if(payCartBtn) {
	payCartBtn.addEventListener('click', payCart)
}

function payCart(e) {
	e.preventDefault()

	fetch('../api/cart.php')
		.then(response => response.json())
		.then(data => {
			fetch('../email/sendEmail.php', {
				method: 'POST',
				body: JSON.stringify(data)
			})
			.then(response => {
				window.location.href = '/cart.php?result=1';
			})
			
		})
}