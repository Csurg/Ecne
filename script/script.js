"use strict";
window.addEventListener("DOMContentLoaded", init);

let timeout;

function init() {

    const registerFirstname = document.querySelector('#registerFirstname');
    const registerLastname = document.querySelector('#registerLastname');
    const registerEmail = document.querySelector('#registerEmail');
    const registerPassword = document.querySelector('#registerPassword');
    const registerPasswordConfirm = document.querySelector('#registerPasswordConfirm');
    const registerPhone = document.querySelector('#registerPhone');

    const resetPassword = document.querySelector('#resetPassword');
    const resetPasswordConfirm = document.querySelector('#resetPasswordConfirm');

    const fl = document.querySelector('#fl');
    const registerForm = document.querySelector('#registerForm');
    const loginForm = document.querySelector('#loginForm');
    const forgetForm = document.querySelector('#forgetForm');
    const resetForm = document.querySelector('#resetForm');
    const petForm = document.querySelector('#petForm');
    const createAppForm = document.querySelector('#createAppForm');
    const treatmentForm = document.querySelector('#treatmentForm');

    if(treatmentForm !==null){
        treatmentForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const title = document.querySelector('#title');
            const medicine = document.querySelector('#medicine');
            if (isEmpty(title.value.trim())) {
                showErrorMessage(title, "Title can't be empty!");
                isValid = false;
            } else {
                hideErrorMessage(title);
            }
            if (isEmpty(medicine.value.trim())) {
                showErrorMessage(medicine, "Medicine can't be empty!");
                isValid = false;
            } else {
                hideErrorMessage(medicine);
            }

            if (isValid) this.submit();
        });
    }

    if(createAppForm !==null){
        createAppForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const title = document.querySelector('#title');
            if (isEmpty(title.value.trim())) {
                showErrorMessage(title, "Title can't be empty!");
                isValid = false;
            } else {
                hideErrorMessage(title);
            }

            if (isValid) this.submit();
        });
    }

    if (petForm !== null) {
        petForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const petName = document.querySelector('#name');
            const petAge = document.querySelector('#age');
            const petBreed = document.querySelector('#breed');
            const petVet = document.querySelector('#vet');

            if (isEmpty(petName.value.trim())) {
                showErrorMessage(petName, "Name can't be empty!");
                isValid = false;
            } else {
                hideErrorMessage(petName);
            }

            if (isEmpty(petAge.value.trim())) {
                showErrorMessage(petAge, "Age can't be empty!");
                isValid = false;
            }
            else if(((petAge.value.trim())<0) || ((petAge.value.trim())>200)) {
                showErrorMessage(petAge, "Type in a real age.");
                isValid = false;
            }
            else {
                hideErrorMessage(petAge);
            }

            let petGender = document.querySelectorAll('input[name="gender"]:checked');
            let checkedRadioGender = petGender.length>0 ? true : false;
            if(!checkedRadioGender) {
                showErrorMessage(document.getElementById('Gender'), "Choose a gender!");
                isValid = false;
            } else {
                hideErrorMessage(document.getElementById('Gender'));
            }

            if (isEmpty(petBreed.value.trim())) {
                showErrorMessage(petBreed, "Select your pets breed!");
                isValid = false;
            }
            else {
                hideErrorMessage(petBreed);
            }
            if (isEmpty(petVet.value.trim())) {
                showErrorMessage(petVet, "Choose a veterinarian for your pet!");
                isValid = false;
            }
            else {
                hideErrorMessage(petVet);
            }

            if (isValid) this.submit();
        });
    }

    if (fl !== null) {
        fl.addEventListener('click', function (e) {
            let forgetForm = document.querySelector('#forgetForm');

            if (forgetForm.style.display !== "block") {
                forgetForm.style.display = "block";
                this.textContent = 'Hide form.';
            } else {
                forgetForm.style.display = "none";
                this.textContent = 'Have you forgotten your password?';
            }

            e.preventDefault();
        });
    }



    if (registerForm !== null) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (validateForm()) this.submit();
        });
    }



    if (loginForm !== null) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const loginUsername = document.querySelector('#loginUsername');
            const loginPassword = document.querySelector('#loginPassword');

            if (isEmpty(loginUsername.value.trim())) {
                showErrorMessage2(loginUsername, "Username can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage2(loginUsername);
            }

            if (isEmpty(loginPassword.value.trim())) {
                showErrorMessage2(loginPassword, "Password can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage2(loginPassword);
            }

            if (isValid) this.submit();
        });
    }

    if (forgetForm !== null) {
        forgetForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const forgetEmail = document.querySelector('#forgetEmail');

            if (isEmpty(forgetEmail.value.trim())) {
                showErrorMessage2(forgetEmail, 'Email can not be empty.');
                isValid = false;
            } else if (!isValidEmail(forgetEmail.value.trim())) {
                showErrorMessage2(forgetEmail, 'Email is in incorrect format!');
                isValid = false;
            } else {
                hideErrorMessage2(forgetEmail);
            }

            if (isValid) this.submit();
        });
    }

    if (resetForm !== null) {
        resetForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const resetEmail = document.querySelector('#resetEmail');
            const resetPassword = document.querySelector('#resetPassword');
            const resetPasswordConfirm = document.querySelector('#resetPasswordConfirm');

            if (isEmpty(resetEmail.value.trim())) {
                showErrorMessage2(resetEmail, 'Email can not be empty.');
                isValid = false;
            } else if (!isValidEmail(resetEmail.value.trim())) {
                showErrorMessage2(resetEmail, 'Email is in incorrect format!');
                isValid = false;
            } else {
                hideErrorMessage2(resetEmail);
            }

            if (isEmpty(resetPassword.value.trim())) {
                showErrorMessage2(resetPassword, 'Password can not be empty.');
                isValid = false;
            } else if ((resetPassword.value.trim().length)<8) {
                showErrorMessage2(resetPassword, 'Password is not long enough! (min 8 characters)');
                isValid = false;
            } else {
                hideErrorMessage2(resetPassword);
            }

            if (isEmpty(resetPasswordConfirm.value.trim())) {
                showErrorMessage2(resetPasswordConfirm, 'Password can not be empty.');
                isValid = false;
            } else if (resetPassword.value.trim() !== resetPasswordConfirm.value.trim()) {
                showErrorMessage2(resetPasswordConfirm, 'Your passwords don\'t match!');
                isValid = false;
            } else {
                hideErrorMessage2(resetPasswordConfirm);
            }

            if (isValid) this.submit();
        });
    }



}


let validateForm = () => {

    let isValid = true;

    if (isEmpty(registerFirstname.value.trim())) {
        showErrorMessage(registerFirstname, "First name can't be empty.");
        isValid = false;
    } else {
        hideErrorMessage(registerFirstname);
    }

    if (isEmpty(registerLastname.value.trim())) {
        showErrorMessage(registerLastname, "Last name can't be empty.");
        isValid = false;
    } else {
        hideErrorMessage(registerLastname);
    }

    if (isEmpty(registerPhone.value.trim())) {
        showErrorMessage(registerPhone, "Phone number can't be empty.");
        isValid = false;
    }
    else if(isNaN(registerPhone.value.trim())){
        showErrorMessage(registerPhone, "Type in a phone number.");
        isValid = false;
    }
    else if(((registerPhone.value.trim())<=0) || ((registerPhone.value.trim().length)>15)){
        showErrorMessage(registerPhone, "Type in a realistic phone number.");
        isValid = false;
    } else {
        hideErrorMessage(registerPhone);
    }

    if (isEmpty(registerEmail.value.trim())) {
        showErrorMessage(registerEmail, 'Email can not be empty.');
        isValid = false;
    } else if (!isValidEmail(registerEmail.value.trim())) {
        showErrorMessage(registerEmail, 'Email is in incorrect format!');
        isValid = false;
        inputError(registerEmail);
    } else {
        hideErrorMessage(registerEmail);
    }

    if (isEmpty(registerPassword.value.trim())) {
        showErrorMessage(registerPassword, 'Password can not be empty.');
        isValid = false;
    } else if ((registerPassword.value.trim().length)<8) {
        showErrorMessage(registerPassword, 'Password is not enough strong! (minimum 8 characters)');
        isValid = false;
    } else {
        hideErrorMessage(registerPassword);
    }

    if (isEmpty(registerPasswordConfirm.value.trim())) {
        showErrorMessage(registerPasswordConfirm, 'Please confirm your password.');
        isValid = false;
    } else if (registerPassword.value.trim() !== registerPasswordConfirm.value.trim()) {
        showErrorMessage(registerPasswordConfirm, 'Your passwords don\'t match!');
        isValid = false;
    } else {
        hideErrorMessage(registerPasswordConfirm);
    }


    return isValid;
};

const isEmpty = value => value === '';

const isValidEmail = (email) => {
    let rex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    return rex.test(email);
}


const showErrorMessage = (field, message) => {
    const error = field.nextElementSibling;
    error.classList.add('error');
    error.innerText = message;
};

const hideErrorMessage = (field) => {
    const error = field.nextElementSibling;
    error.classList.remove('error');
    error.innerText = '';
}

const showErrorMessage2 = (field, message) => {
    const error = field.nextElementSibling;
    error.classList.add('error2');
    error.innerText = message;
};

const hideErrorMessage2 = (field) => {
    const error = field.nextElementSibling;
    error.classList.remove('error2');
    error.innerText = '';
}

function isFileImage(file) {
    const acceptedImageTypes = ['image/gif', 'image/jpeg', 'image/png'];

    return file && acceptedImageTypes.includes(file['type'])
}



document.addEventListener('DOMContentLoaded', function () {
    var doc = document.getElementsByClassName('collapsible');
    var i;

    for (i = 0; i < doc.length; i++) {
        doc[i].addEventListener('click', function () {
            this.classList.toggle('active');
            var content = this.nextElementSibling;
            content.classList.toggle('show');
        });
    }
});

function updateVisit(vetId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "vets.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Visit updated successfully");
        }
    };
    xhr.send("selected_vet_id=" + vetId);
}

function submitForm(name, pet_id) {
    document.getElementById('name').value = name;
    document.getElementById('pet_id').value = pet_id;
    document.getElementById('resultsForm').submit();
}


