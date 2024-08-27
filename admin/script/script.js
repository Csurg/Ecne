"use strict";
window.addEventListener("DOMContentLoaded", init);

let timeout;

function init() {

    const isEmpty = value => value === '';
    const loginForm = document.querySelector('#loginForm');
    const vetRegisterForm = document.querySelector('#vetRegisterForm');

    if (vetRegisterForm !== null) {
        vetRegisterForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const registerFirstname = document.querySelector('#firstname');
            const registerLastname = document.querySelector('#lastname');
            const registerEmail = document.querySelector('#email');
            const registerPassword = document.querySelector('#password');
            const registerPasswordConfirm = document.querySelector('#passwordConfirm');
            const registerPhone = document.querySelector('#phone');
            const specialization = document.querySelector('#specialization');
            const office = document.querySelector('#office');

            if (isEmpty(specialization.value.trim())) {
                showErrorMessage(specialization, "Select a specialization!");
                isValid = false;
            } else {
                hideErrorMessage(specialization);
            }

            if (isEmpty(office.value.trim())) {
                showErrorMessage(office, "Select an office!");
                isValid = false;
            } else {
                hideErrorMessage(office);
            }

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

            if (isEmpty(registerEmail.value.trim())) {
                showErrorMessage(registerEmail, 'Email can not be empty.');
                isValid = false;
            } else if (!isValidEmail(registerEmail.value.trim())) {
                showErrorMessage(registerEmail, 'Email is in incorrect format!');
                isValid = false;

            } else {
                hideErrorMessage(registerEmail);
            }

            if (isValid) this.submit();
        });
    }

    if (loginForm !== null) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const adminUsername = document.querySelector('#adminUsername');
            const adminPassword = document.querySelector('#adminPassword');

            if (isEmpty(adminUsername.value.trim())) {
                showErrorMessage(adminUsername, "Username can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(adminUsername);
            }

            if (isEmpty(adminPassword.value.trim())) {
                showErrorMessage(adminPassword, "Password can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(adminPassword);
            }

            if (isValid) this.submit();
        });
    }



}
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


