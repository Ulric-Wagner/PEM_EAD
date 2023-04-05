confirmButton = document.querySelectorAll('.confirmButton');

confirmButton.forEach( (self) => {
    self.addEventListener('click', ()=>{
        confirm("Veuillez confirmer votre action");
    })
})


//ouverture des collapse via url
urlhash = location.hash.split('&');
urlhash.forEach( (self) => {
    var myCollapse = document.querySelector(self)
    addEventListener('load', (event) => {var bsCollapse = new bootstrap.Collapse(myCollapse, {
        toggle: true
        })});
    })

