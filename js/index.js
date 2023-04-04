confirmButton = document.querySelectorAll('.confirmButton');

confirmButton.forEach( (self) => {
    self.addEventListener('click', ()=>{
        confirm("Veuillez confirmer votre action");
    })
})
