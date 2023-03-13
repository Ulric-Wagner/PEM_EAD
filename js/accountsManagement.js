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

DisabledCourseSelect.addEventListener('change', ()=>{DisabledCourseForm.submit()});
DisabledPromoSelect.addEventListener('change', ()=>{DisabledPromoForm.submit()});
DisabledRoleSelect.addEventListener('change', ()=>{DisabledRoleForm.submit()});

EnabledCourseSelect.addEventListener('change', ()=>{EnabledCourseForm.submit()});
EnabledPromoSelect.addEventListener('change', ()=>{EnabledPromoForm.submit()});
EnabledRoleSelect.addEventListener('change', ()=>{EnabledRoleForm.submit()});