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
      this.SelectedRow = 0;
    }

    onChange() {
        this.EnabledRoleSelect.forEach( (self) => {
            self.addEventListener('change', (self)=>{
                this.SelectedRow = self.target.id.split("EnabledRoleSelect")[1];
                this.EnabledGroupementSelect.forEach( (self) => {
                    if (self.id.split("EnabledGroupementSelect")[1] === this.SelectedRow) {
                        console.log(self); // selection reussi, need to add action to hide ect and duplicate for every needs!
                    }
                })
            })
        })
    }
}

let test = new Selector();
test.onChange();
  