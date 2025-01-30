const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
});



if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {

	}
})



const themeToggle = document.getElementById('theme-toggle');
const body = document.body;

// Check localStorage on page load and apply the theme
document.addEventListener('DOMContentLoaded', () => {
    const isDarkMode = localStorage.getItem('theme') === 'dark';
    if (isDarkMode) {
        body.classList.add('dark');
        themeToggle.checked = true;
    } else {
        body.classList.remove('dark');
        themeToggle.checked = false;
    }
});

// Event listener for the toggle switch
themeToggle.addEventListener('change', () => {
    if (themeToggle.checked) {
        body.classList.add('dark');
        localStorage.setItem('theme', 'dark'); // Save dark mode state
    } else {
        body.classList.remove('dark');
        localStorage.setItem('theme', 'light'); // Save light mode state
    }
});
