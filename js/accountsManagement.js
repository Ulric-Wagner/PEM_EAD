/*
let DisabledCourseForm = document.getElementById("DisabledCourseForm");
let DisabledCourseSelect = document.getElementById("DisabledCourseSelect");

let DisabledPromoForm = document.getElementById("DisabledPromoForm");
let DisabledPromoSelect = document.getElementById("DisabledPromoSelect");

let DisabledRoleForm = document.getElementById("DisabledRoleForm");
let DisabledRoleSelect = document.getElementById("DisabledRoleSelect");

let EnabledCourseForm = document.getElementById("EnabledCourseForm");
let EnabledCourseSelect = document.getElementById("EnabledCourseSelect");

let EnabledPromoForm = document.getElementById("EnabledPromoForm");
let EnabledPromoSelect = document.getElementById("EnabledPromoSelect");

let EnabledRoleForm = document.getElementById("EnabledRoleForm");
let EnabledRoleSelect = document.getElementById("EnabledRoleSelect");

if (DisabledCourseSelect){
DisabledCourseSelect.addEventListener('change', ()=>{DisabledCourseForm.submit()});}
if (DisabledPromoSelect){
DisabledPromoSelect.addEventListener('change', ()=>{DisabledPromoForm.submit()});}
if (DisabledRoleSelect){
DisabledRoleSelect.addEventListener('change', ()=>{DisabledRoleForm.submit()});}

if (EnabledCourseSelect){
EnabledCourseSelect.addEventListener('change', ()=>{EnabledCourseForm.submit()});}
if (EnabledPromoSelect){
EnabledPromoSelect.addEventListener('change', ()=>{EnabledPromoForm.submit()});}
if (EnabledRoleSelect){
EnabledRoleSelect.addEventListener('change', ()=>{EnabledRoleForm.submit()});}
*/

class Selector {
    constructor() {
      this.EnabledRoleSelect = document.querySelectorAll('[id^=EnabledRoleSelect]');
      this.EnabledGroupementSelect = document.querySelectorAll('[id^=EnabledGroupementSelect]');
      this.EnabledCourseSelect = document.querySelectorAll('[id^=EnabledCourseSelect]');
      this.EnabledPromoSelect = document.querySelectorAll('[id^=EnabledPromoSelect]');
      this.SelectedRow = 0;
    }

    onChange() {
        this.EnabledRoleSelect.forEach( (self) => {
            self.addEventListener('change', (self)=>{
                this.SelectedRow = self.target.id.split("EnabledRoleSelect")[1];
                this.SelectedValue = self.target.value;

                if (this.SelectedValue === "None") {
                    this.EnabledGroupementSelect.forEach( (self) => {
                        if (self.id.split("EnabledGroupementSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    })

                    this.EnabledCourseSelect.forEach( (self) => {
                        if (self.id.split("EnabledCourseSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    })

                    this.EnabledPromoSelect.forEach( (self) => {
                        if (self.id.split("EnabledPromoSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    }) 
                }

                if (this.SelectedValue === "Student") {
                    this.EnabledGroupementSelect.forEach( (self) => {
                        if (self.id.split("EnabledGroupementSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    })

                    this.EnabledCourseSelect.forEach( (self) => {
                        if (self.id.split("EnabledCourseSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    })

                    this.EnabledPromoSelect.forEach( (self) => {
                        if (self.id.split("EnabledPromoSelect")[1] === this.SelectedRow) {
                            self.hidden = false;
                        }
                    }) 
                }

                if (this.SelectedValue === "Instructeur") {
                    this.EnabledGroupementSelect.forEach( (self) => {
                        if (self.id.split("EnabledGroupementSelect")[1] === this.SelectedRow) {
                            self.hidden = false;
                        }
                    })

                    this.EnabledCourseSelect.forEach( (self) => {
                        if (self.id.split("EnabledCourseSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    })

                    this.EnabledPromoSelect.forEach( (self) => {
                        if (self.id.split("EnabledPromoSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    }) 
                }

                if (this.SelectedValue === "Pilote") {
                    this.EnabledGroupementSelect.forEach( (self) => {
                        if (self.id.split("EnabledGroupementSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    })

                    this.EnabledCourseSelect.forEach( (self) => {
                        if (self.id.split("EnabledCourseSelect")[1] === this.SelectedRow) {
                            self.hidden = false;
                        }
                    })

                    this.EnabledPromoSelect.forEach( (self) => {
                        if (self.id.split("EnabledPromoSelect")[1] === this.SelectedRow) {
                            self.hidden = true;
                        }
                    }) 
                }
            })
        })
    }
}


let select = new Selector();
select.onChange();
